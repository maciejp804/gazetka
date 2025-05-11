<?php
    return [
        'slots' => [
            'homepage_header' => [
                'slot' => '/7894359647/baner_750X200-2',
                'div_id' => 'article-inline-ad',
                'mapping' => [
                    [
                        'viewport' => [1024, 0],
                        'sizes' => [[750, 300]],
                    ],
                    [
                        'viewport' => [750, 0],
                        'sizes' => [[750, 100]],
                    ],
                    [
                        'viewport' => [0, 0],
                        'sizes' => [[300, 250]],
                    ],
                ],
                'targeting' => [
                    'page' => 'home',  // ← dynamiczne pole, może być nadpisane
                ],
                'adsense_fallback' => [
                    'client' => 'ca-pub-xxxxxxxxxxxx',
                    'slot'   => '1234567890',
                    'format' => 'auto',
                ],
            ],
            'homepage_sidebar_left' => [
                'slot' => '/7894359647/baner_300X600',
                'div_id' => 'article-vertical-ad-left',
                'mapping' => [
                    [
                        'viewport' => [1024, 0],
                        'sizes' => [[300, 600]],
                    ],
                    [
                        'viewport' => [750, 0],
                        'sizes' => [[300, 600]],
                    ],
                    [
                        'viewport' => [0, 0],
                        'sizes' => [[300, 250]],
                    ],
                ],
                'targeting' => [
                    'page' => 'home',  // ← dynamiczne pole, może być nadpisane
                ],
                'adsense_fallback' => [
                    'client' => 'ca-pub-xxxxxxxxxxxx',
                    'slot'   => '1234567890',
                    'format' => 'auto',
                ],
            ],
            'homepage_sidebar_right' => [
                'slot' => '/7894359647/baner_300X600',
                'div_id' => 'article-vertical-ad-right',
                'mapping' => [
                    [
                        'viewport' => [1024, 0],
                        'sizes' => [[300, 600]],
                    ],
                    [
                        'viewport' => [750, 0],
                        'sizes' => [[300, 600]],
                    ],
                    [
                        'viewport' => [0, 0],
                        'sizes' => [[300, 250]],
                    ],
                ],
                'targeting' => [
                    'page' => 'home',  // ← dynamiczne pole, może być nadpisane
                ],
                'adsense_fallback' => [
                    'client' => 'ca-pub-xxxxxxxxxxxx',
                    'slot'   => '1234567890',
                    'format' => 'auto',
                ],
            ],
        ]
    ];
