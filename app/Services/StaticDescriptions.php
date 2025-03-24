<?php

namespace App\Services;

class StaticDescriptions
{
    public static function getDescriptions()
        {

            return collect([
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/001-badge 1.png',
                        'title' => 'Ponad 10 lat<br>doświadczenia',
                        'titleHover' => '',
                        'description' => 'Od ponad dekady codziennie dostarczamy Ci aktualne gazetki promocyjne. Dzięki naszemu doświadczeniu oszczędzanie jest proste i przyjemne!'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/userstar.png',
                        'title' => 'Indywidualne<br>podejście do klienta',
                        'titleHover' => '',
                        'description' => 'Każdy użytkownik jest wyjątkowy. Dbamy, by oferty były dopasowane do Twoich potrzeb.'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/003-sketch 1.png',
                        'title' => 'Wyjątkowe <br>marki',
                        'titleHover' => '',
                        'description' => 'Prezentujemy oferty najlepszych i najbardziej cenionych marek. U nas znajdziesz promocje sklepów, które znasz i lubisz!'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/004-newspapers 1.png',
                        'title' => 'Ponad 100<br>gazetek',
                        'titleHover' => '',
                        'description' => 'W jednym miejscu zebraliśmy ponad 100 aktualnych gazetek promocyjnych. Odkrywaj codziennie nowe okazje i promocje, które pomogą Ci oszczędzać!'
                    ],
                    [
                        'url' =>'https://hoian.pl/assets/image/pro/005-hot-sale 1.png',
                        'title' => 'Najlepsze<br>oferty',
                        'titleHover' => '',
                        'description' => 'Codziennie zbieramy dla Ciebie najatrakcyjniejsze promocje i rabaty. Sprawdź aktualne gazetki i kupuj taniej w ulubionych sklepach!'
                    ],
            ])->map(function ($item) {
                return (object) $item;
            });

        }
}
