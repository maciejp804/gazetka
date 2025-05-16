<?php

return [
    // Domyślne opisy dla różnych tras i lokalizacji
    'defaults' => [
        'main_products' => [
            'default' => [
                'meta_title' => "Produkty",
                'meta_description' => "Szukasz okazji? Przeglądaj produkty i korzystaj z aktualnych promocji 🔥 Oszczędzaj więcej z GazetkaPromocyjna.com.pl",
                'meta_keywords' => "produkty, gazetki, katalogi, promocje, sieci handlowe",
                'h1_title' => "<strong>Produkty</strong> w gazetkach promocyjnych",
                'excerpt' => '',
            ],
        ],
        'main_products_category' => [
            'default' => [
                'meta_title' => "Produkty 🔥 {category}",
                'meta_description' => "Szukasz okazji w kategorii {category}? Przeglądaj produkty i korzystaj z aktualnych promocji 🔥 Oszczędzaj więcej z GazetkaPromocyjna.com.pl!",
                'meta_keywords' => "{category}, gazetki, katalogi, promocje, sieci handlowe",
                'h1_title' => "<strong>Produkty</strong> w gazetkach promocyjnych • <strong>{category}</strong>",
                'excerpt' => ''
            ]
        ],
        'main_products_subcategory' => [
            'default' => [
                'meta_title' => "Produkty 🔥 {category} - {subcategory}",
                'meta_description' => "Szukasz okazji w kategorii {subcategory}? Przeglądaj produkty i korzystaj z aktualnych promocji 🔥 Oszczędzaj więcej z GazetkaPromocyjna.com.pl!",
                'meta_keywords' => "{subcategory}, {category}, gazetki, katalogi, promocje, sieci handlowe",
                'h1_title' => "<strong>Produkty</strong> w gazetkach promocyjnych • <strong>{subcategory}</strong> - {category}",
                'excerpt' => ''
            ]
        ],
        'main_product' => [
            'default' => [
                'meta_title' => "{product} 🔥 promocje, aktualna cena w sklepach",
                'meta_description' => "Promocje na {product} – aktualne ceny i okazje w gazetkach 🔥 Odkryj więcej na GazetkaPromocyjna.com.pl!",
                'meta_keywords' => "{product}, gazetki, katalogi, promocje, sieci handlowe",
                'h1_title' => "<strong>{product}</strong> - promocje w sklepach",
                'excerpt' => ''
            ]
        ],
        'subdomain_products_show' => [
            'default' => [
                "meta_title" => "{product} {shop} 🔥 promocje {data}",
                "meta_description" => "Sprawdź promocje na {product} w sklepach {shop}. Aktualne ceny, gazetki i najlepsze okazje – wszystko w jednym miejscu!",
                "meta_keywords" => "{product}, {shop}, gazetki, katalogi, promocje, sieci handlowe",
                "h1_title" => "{product} w {shop} - <strong>aktualne promocje</strong>",
                "excerpt" => "Zobacz, gdzie kupisz {product} w promocji. W gazetkach {shop} znajdziesz aktualne ceny, rabaty i specjalne oferty. Sprawdź dostępne okazje i zaplanuj zakupy taniej!"

            ]
        ],
        // Domyślne wartości dla innych tras
        'default' => [
            'meta_title' => "Gazetki promocyjne",
            'meta_description' => "Aktualne gazetki promocyjne, przeceny i wyprzedaże • GazetkaPromocyjna.com.pl – wszystkie promocje w jednym miejscu",
            'meta_keywords' => "gazetki, katalogi, promocje",
            'h1_title' => "Gazetki <strong>promocyjne</strong> - aktualne gazetki i katalogi",
            'excerpt' => '',
        ]
    ]
];


