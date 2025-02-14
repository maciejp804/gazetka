<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $location = Cookie::get('user_location');

        if (!$location) {
            $place = Place::where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = Place::where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kontakt', 'url' => ''],
        ];

        return view('main.contact.index', [
            'place' => $place->name,

            // Opisy i dane globalne
            'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
            'page_title'=> 'Masz pytanie? Wypróbuj kontakt do nas | GazetkaPromocyjna.com.pl',
            'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function send(Request $request)
    {

        // Walidacja danych z formularza, w tym pola reCAPTCHA
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email',
            'message'               => 'required|string|min:5',
            'g-recaptcha-response'  => 'required', // Pole wygenerowane przez widget reCAPTCHA
        ]);

        // Pobranie tokenu reCAPTCHA z formularza
        $recaptchaResponse = $request->input('g-recaptcha-response');
        // Pobranie tajnego klucza, np. z pliku .env (upewnij się, że klucz jest ustawiony w config/services.php)
        $secretKey = config('services.recaptcha.secret');

        // Wysłanie żądania weryfikacyjnego do Google reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $response->json();



        // Sprawdzenie wyniku weryfikacji
        if (!isset($responseBody['success']) || $responseBody['success'] !== true) {
            return back()->with(['error' => 'Weryfikacja reCAPTCHA nie powiodła się. Spróbuj ponownie.']);
        }

        // Jeżeli reCAPTCHA została pomyślnie zweryfikowana,
        // możesz kontynuować przetwarzanie danych formularza (np. zapis do bazy, wysłanie maila itp.)
        // ...

        Mail::to('biuro@hoian.pl')
            ->bcc($request->email)
            ->send(
            new ContactMail($request->all())
        );

        return redirect()->back()->with('success', 'Wiadomość została wysłana.');
    }
}
