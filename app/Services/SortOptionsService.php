<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SortOptionsService
{
    public static function getSortOptions(): Collection
    {
        return collect([
            ['id' => 1, 'name' => 'Najnowsze'],
            ['id' => 2, 'name' => 'Kończą się'],
            ['id' => 3, 'name' => 'Nadchodzące'],
            ['id' => 4, 'name' => 'Aktualne'],
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

    public static function getCategoryRetailers(): Collection
    {
        return collect([
            ['id' => 1, 'name' => 'Dom', 'value' => 'dom'],
            ['id' => 2, 'name' => 'Moda', 'value' => 'moda'],
            ['id' => 3, 'name' => 'Zabawki', 'value' => 'zabawki'],

        ])->map(function ($item) {
            return (object) $item;
        });
    }


}
