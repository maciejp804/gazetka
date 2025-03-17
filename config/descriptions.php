<?php

return [
    // Domyślne opisy dla różnych tras i lokalizacji
    'defaults' => [
        'main_index' => [
            'meta_title' => "Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl",
            'meta_description' => "Znajdź najlepsze promocje i oferty. Sprawdź aktualne gazetki i rabaty.",
            'meta_keywords' => "gazetki promocyjne, oferty, promocje",
            'h1_title' => "Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje"
        ],

        'main_index_gps' => [
            'meta_title' => "Gazetki promocyjne, nowe i nadchodzące promocje w {city} | GazetkaPromocyjna.com.pl",
            'meta_description' => "Znajdź najlepsze promocje i oferty w {city}. Sprawdź aktualne gazetki i rabaty.",
            'meta_keywords' => "gazetki promocyjne, oferty, promocje, {city}",
            'h1_title' => "Wszystkie <strong>gazetki promocyjne</strong> w jednym miejscu w {city}"
        ],
        'shop_aldi' => [
            'meta_title' => "Gazetki promocyjne Aldi - {city}",
            'meta_description' => "Aktualne promocje Aldi w {city}. Sprawdź, co warto kupić!",
            'meta_keywords' => "aldi, gazetki, {city}",
            'h1_title' => "Gazetki promocyjne"
        ],
        // Domyślne wartości dla innych tras
        'default' => [
            'meta_title' => "Gazetki promocyjne",
            'meta_description' => "Sprawdź najnowsze gazetki promocyjne i oszczędzaj na zakupach.",
            'meta_keywords' => "promocje, gazetki, okazje",
            'h1_title' => "Gazetki promocyjne"
        ]
    ]
];

