<?php

return [
    // Domyślne opisy dla różnych tras i lokalizacji
    'defaults' => [
        'main_blogs' => [
            'default' => [
                'meta_title' => 'ABC Zakupowicza – porady, recenzje i porównania | GazetkaPromocyjna.com.pl',
                'meta_description' => 'ABC Zakupowicza – sprawdź praktyczne porady zakupowe, recenzje produktów i porównania promocji w gazetkach 🔥 GazetkaPromocyjna.com.pl',
                'meta_keywords' => 'gazetki promocyjne, katalogi, promocje, kupony rabatowe, kody zniżkowe',
                'h1_title' => 'ABC Zakupowicza',
                'excerpt' => 'ABC Zakupowicza to miejsce, gdzie znajdziesz praktyczne porady zakupowe, recenzje produktów i przegląd najlepszych promocji. Planuj zakupy mądrze z GazetkaPromocyjna.com.pl!'
            ]
        ],
        'main_blogs_category' => [
            'default' => [
                'meta_title' => '{category} – sprawdź najnowsze wpisy i promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => '{category} na GazetkaPromocyjna.com.pl 🔥 praktyczne informacje, aktualne promocje i najlepsze okazje zakupowe',
                'meta_keywords' => '{category}, gazetki promocyjne, katalogi, promocje, kody rabatowe',
                'h1_title' => '{category} – ABC Zakupowicza',
                'excerpt' => 'Odkryj {category} na GazetkaPromocyjna.com.pl. Znajdziesz tu praktyczne informacje, aktualne gazetki promocyjne oraz porady, jak kupować taniej i mądrzej.'
            ]
        ],
        'main_blogs_article' => [
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


