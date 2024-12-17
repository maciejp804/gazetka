<?php

namespace App\Services;

class StaticDescriptions
{
    public static function getDescriptions()
        {

            return collect([
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/001-badge 1.png',
                        'title' => 'Ponad 20 lat<br>doświadczenia',
                        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/userstar.png',
                        'title' => 'Indywidualne<br>podejście do klienta',
                        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/003-sketch 1.png',
                        'title' => 'Wyjątkowe <br>marki',
                        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/004-newspapers 1.png',
                        'title' => 'Ponad 1000<br>gazetek',
                        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/005-hot-sale 1.png',
                        'title' => 'Najlepsze<br>oferty',
                        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
                    ],
            ])->map(function ($item) {
                return (object) $item;
            });

        }
}
