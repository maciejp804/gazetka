<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Walidacja adresu e-mail
        $request->validate([
            'email' => 'required|email',
            'terms' => 'accepted'
        ]);

        $email  = $request->input('email');
        $terms  = $request->input('terms');
        $apiKey = env('MAILER_API_KEY');
        $groupId = env('MAILER_GROUP_ID');

        // Adres URL API dla dodawania subskrybenta do konkretnej grupy
        $url = "https://api.mailerlite.com/api/v2/groups/{$groupId}/subscribers";

        // Konfiguracja klienta HTTP
        $client = new Client([
            'headers' => [
                'X-MailerLite-ApiKey' => $apiKey,
                'Content-Type'        => 'application/json',
            ]
        ]);

        try {
            $response = $client->post($url, [
                'json' => [
                    'email' => $email,
                ]
            ]);

            switch ($response->getStatusCode()){
                case 200:
                    return redirect()->back()->with('update', 'Adres e-mail znajduje się w naszej bazie!');

                case 201:
                    return redirect()->back()->with('success', 'Dziękujemy za subskrypcję newslettera!');

            }

        } catch (\Exception $e) {
            \Log::error("MailerLite subscribe error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Wystąpił problem przy zapisie, spróbuj ponownie.');
        }
    }
}
