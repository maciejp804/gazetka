<?php

namespace App\Services\Ocr\Groupers;

class GroupAndMergeService
{
    private int $verticalThreshold;
    private int $minColumnGap;
    private int $yLineThreshold;
    private int $xLinePadding;
    private int $horizontalProximityThreshold;

    protected LineGroupingService  $lineGroupingService;


    /**
     * Konstruktor OcrService.
     *
     * @param int $verticalThreshold  Pionowy próg odległości do grupowania linii w bloki/kolumny.
     * @param int $minColumnGap      Minimalna pozioma przerwa, aby uznać dwie grupy słów za oddzielne kolumny.
     * @param int $yLineThreshold    Pionowy próg odległości do grupowania słów w tę samą linię poziomą.
     * @param int $xLinePadding      Poziowy margines, aby umożliwić przerwy między słowami w tej samej linii.
     * @param int $horizontalProximityThreshold Poziomy próg odległości do grupowania słów w obrębie bloku LUB do wyrównywania linii w kolumnach.
     */
    public function __construct(
        LineGroupingService  $lineGroupingService,
        int $verticalThreshold = 35, // Zmieniono na 35 dla elastyczności pionowego łączenia linii w bloki.
        int $minColumnGap = 10,
        int $yLineThreshold = 5, // Zostawiono 8 dla rygorystycznego tworzenia początkowych linii.
        int $xLinePadding = 15, // Zostawiono 15 dla rygorystycznego tworzenia początkowych linii.
        int $horizontalProximityThreshold = 10 // Zostawiono 40 dla wyrównania poziomego linii w kolumnach.

    ) {
        $this->verticalThreshold = $verticalThreshold;
        $this->minColumnGap = $minColumnGap;
        $this->yLineThreshold = $yLineThreshold;
        $this->xLinePadding = $xLinePadding;
        $this->horizontalProximityThreshold = $horizontalProximityThreshold;
        $this->lineGroupingService = $lineGroupingService;

    }

    /**
     * Główna metoda do grupowania słów w linie, następnie w grupy bliskości (kolumny),
     * i ostatecznie łączenia ich w skonsolidowane bloki tekstowe z ramkami ograniczającymi.
     *
     * @param array $words Tablica danych słów, każda z 'description' i 'boundingPoly' z 'vertices'.
     * @return array Scalone grupy słów z 'description', 'x', 'y', 'width', 'height'.
     */
    public function groupAndMerge(array $words): array
    {
        // Krok 1: Grupuj słowa poziomo w rygorystyczne linie.
        $lines = $this->groupWordsIntoLines($words); // lines jest teraz tablicą tablic słów, np. [['word1', 'word2'], ['word3']]

        // Krok 2: Grupuj te linie w większe bloki/kolumny na podstawie bliskości.
        // groupWordsByProximityLineBased teraz przyjmuje tablicę linii.
        $lineBased = $this->lineGroupingService->groupWordsByProximityLineBased($lines);

        // Krok 3: Grupuje linie jedna pod drugą w większe bloki/kolumny na podstawie bliskości.
        // mergeGroupedLinesToTextBlock teraz przyjmuje tablicę linii.

        $finalGroups = array_map(
            [$this->lineGroupingService, 'mergeGroupedLinesToTextBlock'],
            $lineBased
        );

        // Krok 3: Scal zgrupowane finalGroups w pojedyncze bloki tekstowe z połączonymi ramkami ograniczającymi.
        // mergeRelatedBlocks teraz przyjmuje tablicę linii.

//        dd($this->lineGroupingService->mergeRelatedBlocks($finalGroups));

        return $this->lineGroupingService->mergeRelatedBlocks($finalGroups);

    }

    /**
     * Grupuje słowa w linie poziome na podstawie ich pozycji Y i X.
     */

    public function groupWordsIntoLines(array $words): array
    {
        // Posortuj słowa najpierw według Y, a następnie według X, aby przetwarzać je linia po linii.
        usort($words, function ($a, $b) {
            $aY = $this->getBoundingBoxCenterY($a['boundingPoly']['vertices']);
            $bY = $this->getBoundingBoxCenterY($b['boundingPoly']['vertices']);

            // Jeśli współrzędne Y są bardzo bliskie, sortuj według X.
            if (abs($aY - $bY) < $this->yLineThreshold) {
                return $this->getBoundingBoxStartX($a['boundingPoly']['vertices']) <=> $this->getBoundingBoxStartX($b['boundingPoly']['vertices']);
            }
            return $aY <=> $bY;
        });

        $lines = [];
        $currentLine = [];

        foreach ($words as $word) {
            $wordX = $this->getBoundingBoxStartX($word['boundingPoly']['vertices']);
            $wordY = $this->getBoundingBoxCenterY($word['boundingPoly']['vertices']);

            if (empty($currentLine)) {
                $currentLine[] = $word;
                continue;
            }

            $last = end($currentLine);
            $lastY = $this->getBoundingBoxCenterY($last['boundingPoly']['vertices']);

            // Maksymalny koniec X z dotychczasowej linii
            $maxLineX = max(array_map(fn($w) => $this->getBoundingBoxEndX($w['boundingPoly']['vertices']), $currentLine));

            // Odległość między końcem ostatniego słowa a początkiem nowego
            $horizontalDistance = abs($wordX - $this->getBoundingBoxEndX($last['boundingPoly']['vertices']));

            // Progi
            $sameLine = abs($wordY - $lastY) <= $this->yLineThreshold;
            $xReasonablyClose = $wordX <= $maxLineX + $this->xLinePadding;
            $horizontalGapAcceptable = $horizontalDistance <= ($this->maxWordGap ?? 150); // dodatkowy warunek

            if ($sameLine && $xReasonablyClose && $horizontalGapAcceptable) {
                $currentLine[] = $word;
            } else {
                $lines[] = $currentLine;
                $currentLine = [$word];
            }
        }

        if (!empty($currentLine)) {
            $lines[] = $currentLine;
        }

        return $lines;
    }


    /**
     * Grupuje linie na podstawie ich pionowej i poziomej bliskości,
     * uwzględniając wykryte kolumny
     */
    private function groupWordsByProximity(array $lines): array
    {
        $lineObjects = [];

        foreach ($lines as $line) {
            if (empty($line)) continue;

            $allX = $allY = [];
            foreach ($line as $word) {
                foreach ($word['boundingPoly']['vertices'] as $v) {
                    if (isset($v['x'], $v['y'])) {
                        $allX[] = $v['x'];
                        $allY[] = $v['y'];
                    }
                }
            }

            $startX = min($allX);
            $endX = max($allX);
            $centerY = (min(array_column($line[0]['boundingPoly']['vertices'], 'y')) + max(array_column(end($line)['boundingPoly']['vertices'], 'y'))) / 2;
            $height = max(array_column(end($line)['boundingPoly']['vertices'], 'y')) - min(array_column($line[0]['boundingPoly']['vertices'], 'y'));

            $alignment = $this->detectTextAlignment($startX, $endX);
            $columnX = match ($alignment) {
                'right' => $endX,
                'center' => ($startX + $endX) / 2,
                default => $startX,
            };

            $lineObjects[] = [
                'words' => $line,
                'startX' => $startX,
                'endX' => $endX,
                'centerY' => $centerY,
                'height' => $height,
                'description' => implode(' ', array_column($line, 'description')),
                'columnX' => $columnX,
            ];
        }

        $columnXs = $this->detectColumnsFromLineObjects($lineObjects);

        usort($lineObjects, function ($a, $b) {
            return abs($a['columnX'] - $b['columnX']) < 10
                ? $a['centerY'] <=> $b['centerY']
                : $a['columnX'] <=> $b['columnX'];
        });

        $groups = [];

        foreach ($lineObjects as $lineObject) {
            $lineX = $lineObject['columnX'];
            $lineCenterY = $lineObject['centerY'];
            $lineHeight = $lineObject['height'];
            $closestColumnX = $this->findClosestColumnX($lineX, $columnXs);

            $added = false;

            foreach ($groups as &$group) {
                $last = end($group);
                $lastX = $last['columnX'];
                $lastCenterY = $last['centerY'];
                $lastClosestColumnX = $this->findClosestColumnX($lastX, $columnXs);

                $sameColumn = $closestColumnX === $lastClosestColumnX;
                $closeVertically = abs($lineCenterY - $lastCenterY) <= $this->verticalThreshold;
                $horizontallyClose = $lineObject['startX'] - $last['endX'] <= $this->horizontalProximityThreshold;
                $avgHeight = $this->calculateAverageHeightOfLineObjects($group);
                $heightAcceptable = $lineHeight <= ($avgHeight * 1.5);

                if ($sameColumn && $closeVertically && $horizontallyClose && $heightAcceptable) {
                    $group[] = $lineObject;
                    $added = true;
                    break;
                }
            }

            if (!$added) {
                $groups[] = [$lineObject];
            }
        }

        return $groups;
    }


    /**
     * Pomocnik do znajdowania najbliższej współrzędnej X kolumny dla danej współrzędnej X słowa/linii.
     *
     * @param int $x Współrzędna X słowa lub linii.
     * @param array $columnXs Tablica wykrytych współrzędnych X kolumn.
     * @return int Najbliższa współrzędna X kolumny.
     */
    private function findClosestColumnX(int $x, array $columnXs): int
    {
        if (empty($columnXs)) {
            return $x; // Fallback, jeśli nie wykryto kolumn, traktuj X jako swoją "kolumnę".
        }

        $closestX = $columnXs[0];
        $minDiff = abs($columnXs[0] - $x);

        foreach ($columnXs as $colX) {
            $diff = abs($colX - $x);
            if ($diff < $minDiff) {
                $minDiff = $diff;
                $closestX = $colX;
            }
        }
        return $closestX;
    }

    /**
     * Oblicza średnią wysokość obiektów linii w grupie.
     *
     * @param array $lineObjects Tablica obiektów linii.
     * @return float Średnia wysokość.
     */
    private function calculateAverageHeightOfLineObjects(array $lineObjects): float
    {
        if (empty($lineObjects)) {
            return 0.0;
        }
        $totalHeight = array_sum(array_map(fn ($lineObject) => $lineObject['height'], $lineObjects));
        return $totalHeight / count($lineObjects);
    }

    /**
     * Wykrywa potencjalne współrzędne X kolumn w dokumencie na podstawie
     * początkowych współrzędnych X obiektów linii.
     *
     * @param array $lineObjects Tablica obiektów linii.
     * @return array Tablica reprezentatywnych współrzędnych X dla każdej wykrytej kolumny.
     */
    private function detectColumnsFromLineObjects(array $lineObjects): array
    {
        $startXs = array_map(fn ($lineObject) => $lineObject['startX'], $lineObjects);
        sort($startXs);

        $columns = [];
        $currentColumnGroup = [];

        foreach ($startXs as $x) {
            if (empty($currentColumnGroup) || abs($x - end($currentColumnGroup)) < $this->minColumnGap) {
                $currentColumnGroup[] = $x;
            } else {
                $columns[] = $currentColumnGroup;
                $currentColumnGroup = [$x];
            }
        }

        if (!empty($currentColumnGroup)) {
            $columns[] = $currentColumnGroup;
        }

        return array_map(function ($group) {
            return (int) (array_sum($group) / count($group));
        }, $columns);
    }

    /**
     * Łączy słowa z obiektów linii w każdej grupie w pojedynczy ciąg tekstowy
     * i oblicza skonsolidowaną ramkę ograniczającą dla połączonego tekstu.
     *
     * @param array $groups Tablica grup obiektów linii.
     * @return array Tablica scalonych bloków tekstowych z ich ramkami ograniczającymi.
     */
    private function mergeGroupedWords(array $groups): array
    {
        $merged = [];

        foreach ($groups as $groupOfLineObjects) {
            $allWordsInGroup = [];
            // Zbierz wszystkie oryginalne słowa z każdego obiektu linii w grupie.
            foreach ($groupOfLineObjects as $lineObject) {
                $allWordsInGroup = array_merge($allWordsInGroup, $lineObject['words']);
            }

            // Skonkatynuj opisy wszystkich słów w grupie.
            $text = implode(' ', array_column($allWordsInGroup, 'description'));

            $allX = [];
            $allY = [];

            // Zbierz wszystkie współrzędne X i Y ze wszystkich słów w grupie.
            foreach ($allWordsInGroup as $word) {
                foreach ($word['boundingPoly']['vertices'] as $v) {
                    if (isset($v['x'], $v['y'])) {
                        $allX[] = $v['x'];
                        $allY[] = $v['y'];
                    }
                }
            }

            // Oblicz ogólną ramkę ograniczającą dla scalonego tekstu.
            $x = min($allX);
            $y = min($allY);
            $width = max($allX) - $x;
            $height = max($allY) - $y;

            $merged[] = [
                'description' => $text,
                'x' => $x,
                'y' => $y,
                'width' => $width,
                'height' => $height,
            ];
        }

        return $merged;
    }

    /**
     * Oblicza środkową współrzędną Y ramki ograniczającej słowa.
     * Zakłada prostokątną ramkę ograniczającą z wierzchołkami[0] jako top-left i wierzchołkami[2] jako bottom-right.
     *
     * @param array $vertices Tablica współrzędnych wierzchołków.
     * @return float Środkowa współrzędna Y.
     */
    private function getBoundingBoxCenterY(array $vertices): float
    {
        return ($vertices[0]['y'] + $vertices[2]['y']) / 2;
    }

    /**
     * Pobiera początkową (minimalną) współrzędną X ramki ograniczającej słowa.
     *
     * @param array $vertices Tablica współrzędnych wierzchołków.
     * @return int Początkowa współrzędna X.
     */
    private function getBoundingBoxStartX(array $vertices): int
    {
        return min(array_column($vertices, 'x'));
    }

    /**
     * Pobiera końcową (maksymalną) współrzędną X ramki ograniczającej słowa.
     *
     * @param array $vertices Tablica współrzędnych wierzchołków.
     * @return int Końcowa współrzędna X.
     */
    private function getBoundingBoxEndX(array $vertices): int
    {
        return max(array_column($vertices, 'x'));
    }

    /**
     * Oblicza wysokość ramki ograniczającej słowa.
     *
     * @param array $vertices Tablica współrzędnych wierzchołków.
     * @return int Wysokość ramki ograniczającej.
     */
    private function getBoundingBoxHeight(array $vertices): int
    {
        return abs($vertices[2]['y'] - $vertices[0]['y']);
    }

    public function mergeDuplicateProductBlocks(array $products, int $distanceThreshold = 50, int $minBlockWidth = 40, int $minBlockHeight = 15): array
    {
        $merged = [];

        foreach ($products as $product) {
            $block = $product['original_block'];

            if ($block['width'] < $minBlockWidth || $block['height'] < $minBlockHeight) {
                continue;
            }

            $mergedToExisting = false;

            foreach ($merged as &$existing) {
                $existingBlock = $existing['original_block'];
                $name1 = mb_strtolower($product['name']);
                $name2 = mb_strtolower($existing['name']);
                $sameName = $name1 === $name2;

                $sameLineY = abs($block['y'] - $existingBlock['y']) <= 10;
                if ($sameName && $sameLineY) {
                    $mergedToExisting = true;
                    break;
                }

                $dx = abs(($block['x'] + $block['width'] / 2) - ($existingBlock['x'] + $existingBlock['width'] / 2));
                $dy = abs(($block['y'] + $block['height'] / 2) - ($existingBlock['y'] + $existingBlock['height'] / 2));
                $closeEnough = $dx <= $distanceThreshold && $dy <= $distanceThreshold;

                if ($sameName && $closeEnough) {
                    $area = $block['width'] * $block['height'];
                    $existingArea = $existingBlock['width'] * $existingBlock['height'];

                    if ($area > $existingArea) {
                        $existing['original_block'] = $block;
                        $existing['name'] = $product['name'];
                    }

                    foreach (['price', 'unit_price', 'weight_volume', 'promotion'] as $field) {
                        if (empty($existing[$field]) && !empty($product[$field])) {
                            $existing[$field] = $product[$field];
                        }
                    }

                    $mergedToExisting = true;
                    break;
                }
            }

            if (!$mergedToExisting) {
                $merged[] = $product;
            }
        }

        return $merged;
    }

    private function detectTextAlignment(int $startX, int $endX): string
    {
        $centerX = ($startX + $endX) / 2;

        if ($centerX < 600) return 'left';
        if ($centerX > 1100) return 'right';
        return 'center';
    }


}
