<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SortOptionsService
{
    public static function getSortOptions($maindomain = true): Collection
    {
        if ($maindomain) {
            return collect([
                ['id' => 1, 'name' => 'Popularne sklepy'],
                ['id' => 2, 'name' => 'Kończą się'],
                ['id' => 3, 'name' => 'Nadchodzące'],
                ['id' => 4, 'name' => 'Aktualne'],
            ])->map(function ($item) {
                return (object) $item; // Konwertuje każdy element na obiekt
            });
        } else {
            return collect([

                ['id' => 2, 'name' => 'Kończą się'],
                ['id' => 3, 'name' => 'Nadchodzące'],
                ['id' => 4, 'name' => 'Aktualne'],
            ])->map(function ($item) {
                return (object) $item; // Konwertuje każdy element na obiekt
            });
        }

    }

    public static function getSortPopularity(): Collection
    {
        return collect([
            //['id' => 1, 'name' => 'Ulubione'],
            ['id' => 2, 'name' => 'Najwyżej oceniane'],
            ['id' => 3, 'name' => 'Alfabetycznie'],
            ['id' => 4, 'name' => 'Z ofertą']

        ])->map(function ($item) {
            return (object) $item; // Konwertuje każdy element na obiekt
        });
    }

    public static function getCategoryOptions(): Collection
    {
        return collect([
                ['id' => 1, 'name' => 'Dom', 'value' => 'dom'],
                ['id' => 2, 'name' => 'Moda', 'value' => 'moda'],
                ['id' => 3, 'name' => 'Zabawki', 'value' => 'zabawki'],
                ['id' => 4, 'name' => 'Art.Spożywcze', 'value' => 'spozywcze'],
                ['id' => 5, 'name' => 'Ogród', 'value' => 'ogrod'],
        ])->map(function ($item) {
            return (object) $item;
        });
    }

    public static function getSortOptionsProducts(): Collection
    {
        return collect([
            ['id' => 1, 'name' => 'Najniższa cena'],
            ['id' => 2, 'name' => 'Najwyższa cena'],
            ['id' => 3, 'name' => 'Kończą się'],
            ['id' => 4, 'name' => 'Nadchodzace'],
            ['id' => 5, 'name' => 'Aktualne'],


        ])->map(function ($item) {
            return (object) $item;
        });
    }


}
