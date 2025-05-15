<?php

return [
    // Domyślne opisy dla różnych tras i lokalizacji
    'defaults' => [
        'main_leaflets' => [
            'default' => [
                'meta_title' => "Gazetki promocyjne",
                'meta_description' => "Aktualne gazetki promocyjne, przeceny i wyprzedaże • GazetkaPromocyjna.com.pl – wszystkie promocje w jednym miejscu",
                'meta_keywords' => "gazetki, katalogi, promocje",
                'h1_title' => "Gazetki <strong>promocyjne</strong> - aktualne gazetki i katalogi",
                'excerpt' => '',
            ],
        ],
        'main_leaflets_category' => [
            'default' => [
                'meta_title' => "Gazetki promocyjne • {category}",
                'meta_description' => "Aktualne gazetki promocyjne, przeceny i wyprzedaże • {category} • GazetkaPromocyjna.com.pl – wszystkie promocje w jednym miejscu",
                'meta_keywords' => "{category}, gazetki",
                'h1_title' => "Gazetki <strong>promocyjne</strong> w kategorii <strong>{category}</strong>",
                'excerpt' => ''
            ]
        ],
        'subdomain_leaflet' => [
            'default' => [
                'meta_title' => "Gazetka promocyjna {shop} od {valid_from} do {valid_to}",
                'meta_description' => "Aktualna gazetka promocyjna {title} w {shop} od {valid_from} do {valid_to} 🔥 Nie przepłacaj! ✔️ GazetkaPromocyjna.com.pl",
                'meta_keywords' => "{category}, gazetki",
                'h1_title' => "Gazetka {shop} od {valid_from}",
                'excerpt' => "Zobacz najnowszą gazetkę promocyjną sieci <strong>{shop}</strong> – <strong>{title}</strong>, obowiązującą w dniach od {valid_from} do {valid_to}. W aktualnej ofercie {shop} znajdziesz szeroki wybór produktów w promocyjnych cenach. To dobry moment, by zaplanować zakupy i skorzystać z dostępnych okazji.
                {products}
                To tylko część promocji dostępnych w gazetce <strong>{shop}, {title}</strong>, obowiązującej od {valid_from}. Sprawdź pełną ofertę i przekonaj się, co jeszcze przygotowała sieć <strong>{shop}</strong> w {month}. Warto być na bieżąco z okazjami, które mogą pomóc w codziennych oszczędnościach."
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


