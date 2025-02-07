<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Shop;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $city = $request->get('city');
        $subdomain = $request->post('subdomain');
        $id = $request->get('id');

        $validated = $request->validate([
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);



        $exists = Rating::where('rateable_id', $validated['rateable_id'])
            ->where('rateable_type', $validated['rateable_type'])
            ->where('user_id', auth()->id())
            ->exists();

        if ($exists) {
            $shop = Shop::where('slug', $subdomain)->first();

            Rating::where('rateable_id', $validated['rateable_id'])
                ->where('rateable_type', $validated['rateable_type'])
                ->where('user_id', auth()->id())->update(['rating' => $validated['rating']]);


            if ($shop) {
                $average = $shop->ratings()
                    ->where('rateable_type', $validated['rateable_type'])
                    ->avg('rating');

                $shop->update(['ranking' => $average]);
            }

            if(!$city){
                if(!$id){
                    return redirect()->back()->with('update', 'Zaktualizowaliśmy Twoją ocenę!');
                } else {
                    return redirect()->route('subdomain.leaflet', ['subdomain' => $subdomain,'id' => $id])->with('update', 'Zaktualizowaliśmy Twoją ocenę!');
                }

            } else {
                    return redirect()->route('subdomain.index_gps', ['subdomain' => $subdomain,'community' => $city])->with('update', 'Zaktualizowaliśmy Twoją ocenę!');


            }

        }

        Rating::create([
            'rateable_id' => $validated['rateable_id'],
            'rateable_type' => $validated['rateable_type'],
            //'user_id' => 1,
            'user_id' => auth()->id(), // Pobiera ID zalogowanego użytkownika
            'rating' => $validated['rating'],
        ]);

        Shop::where('slug', $subdomain)->first()->update(['ranking' => $validated['rating']]);

        return redirect()->back()->with('success', 'Dziękujemy za ocenę!');
    }


    // Wyświetlenie ocen dla obiektu (np. produktu lub sklepu)
    public function index(Request $request)
    {
        $validated = $request->validate([
            'rateable_id' => 'required|integer',
            'rateable_type' => 'required|string',
        ]);

        $ratings = Rating::where('rateable_id', $validated['rateable_id'])
            ->where('rateable_type', $validated['rateable_type'])
            ->with('user')
            ->get();

        return response()->json($ratings);
    }

    // Usunięcie oceny
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return response()->json(['success' => 'Rating deleted successfully.']);
    }
}
