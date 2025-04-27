<?php

return [
    // Domyślne opisy dla różnych tras i lokalizacji
    'defaults' => [
       'main_vouchers' => [
            'default' => [
                'meta_title' => "Kody rabatowe {date}🔥GazetkaPromocyjna.com.pl",
                'meta_description' => "Odkryj aktualne promocje i kody rabatowe na {date} 🔥 Oszczędzaj z GazetkaPromocyjna.com.pl!",
                'meta_keywords' => "gazetki, katalogi, promocje, kupony rabatowe, kody",
                'h1_title' => "Aktualne kody rabatowe {date} - kupony na zniżki promocyjne",
                'excerpt' => ''
            ]
        ],
        'main_vouchers_category' => [
            'default' => [
                'meta_title' => "Kody rabatowe {category} {date} 🔥 GazetkaPromocyjna.com.pl",
                'meta_description' => "Odkryj aktualne promocje i kody rabatowe w kategorii {category} na {date} 🔥 Oszczędzaj z GazetkaPromocyjna.com.pl!",
                'meta_keywords' => "{category}, gazetki, katalogi, promocje, kupony rabatowe, kody",
                'h1_title' => "Aktualne kody rabatowe w kategorii <strong>{category}</strong> {date} - kupony na zniżki promocyjne",
                'excerpt' => ''
            ]
        ],
        // Domyślne wartości dla innych tras
        'default' => [
            'meta_title' => "Gazetki promocyjne • GazetkaPromocyjna.com.pl",
            'meta_description' => "Aktualne gazetki promocyjne, przeceny i wyprzedaże • GazetkaPromocyjna.com.pl – wszystkie promocje w jednym miejscu",
            'meta_keywords' => "gazetki, katalogi, promocje",
            'h1_title' => "Gazetki <strong>promocyjne</strong> - aktualne gazetki i katalogi",
            'excerpt' => '',
        ]
    ]
];


