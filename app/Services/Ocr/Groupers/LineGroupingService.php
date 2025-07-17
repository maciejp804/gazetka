<?php

namespace App\Services\Ocr\Groupers;

class LineGroupingService
{
    protected int $verticalThreshold = 30;
    protected int $horizontalProximityThreshold = 15;


    /**
     * Wersja: od góry do dołu bez kolumn.
     */
    public function groupWordsByProximityLineBased(array $lines): array
    {
        $lineObjects = [];

        foreach ($lines as $line) {
            if (empty($line)) continue;

            $allX = [];
            foreach ($line as $word) {
                foreach ($word['boundingPoly']['vertices'] as $v) {
                    if (isset($v['x'], $v['y'])) {
                        $allX[] = $v['x'];
                    }
                }
            }

            $startX = min($allX);
            $endX = max($allX);
            $centerY = (min(array_column($line[0]['boundingPoly']['vertices'], 'y')) + max(array_column(end($line)['boundingPoly']['vertices'], 'y'))) / 2;
            $height = max(array_column(end($line)['boundingPoly']['vertices'], 'y')) - min(array_column($line[0]['boundingPoly']['vertices'], 'y'));

            $lineObjects[] = [
                'words' => $line,
                'startX' => $startX,
                'endX' => $endX,
                'centerY' => $centerY,
                'height' => $height,
                'description' => implode(' ', array_column($line, 'description')),
            ];
        }

        usort($lineObjects, fn($a, $b) => $a['centerY'] <=> $b['centerY']);

        // Początkowo każda linia to osobna grupa
        $groups = array_map(fn($line) => [$line], $lineObjects);

        do {
            $counter = 0; // licznik udanych połączeń
            $newGroups = [];

            while (!empty($groups)) {
                $groupA = array_shift($groups);
                $merged = false;

                foreach ($groups as $key => $groupB) {
                    if ($this->groupsCanBeMerged($groupA, $groupB)) {
                        $groupA = array_merge($groupA, $groupB);
                        unset($groups[$key]);
                        $counter++;
                        $merged = true;
                        break;
                    }
                }

                $newGroups[] = $groupA;
            }

            $groups = array_values($newGroups); // resetuj indeksy
        } while ($counter > 0);

        return $groups;
    }

    private function groupsCanBeMerged(array $groupA, array $groupB): bool
    {
        foreach ($groupA as $lineA) {
            foreach ($groupB as $lineB) {
                $closeVertically = abs($lineA['centerY'] - $lineB['centerY']) <= $this->verticalThreshold;
                $overlapsHorizontally = !(
                    $lineA['endX'] < $lineB['startX'] - $this->horizontalProximityThreshold ||
                    $lineA['startX'] > $lineB['endX'] + $this->horizontalProximityThreshold
                );

                $heightAcceptable = $lineB['height'] <= ($this->calculateAverageHeightOfLineObjects($groupA) * 1.5);

                // Standardowy przypadek – poziome nachodzenie i bliskość pionowa
                if ($closeVertically && $overlapsHorizontally && $heightAcceptable) {
                    return true;
                }

                // ❗ DODATKOWA LOGIKA: dozwolona bliskość pionowa nawet bez poziomego overlapu
                $isCenterAligned = abs($lineA['startX'] + $lineA['endX'] - $lineB['startX'] - $lineB['endX']) < 30; // różnica środka X

                if ($closeVertically && $isCenterAligned) {
                    return true;
                }
            }
        }

        return false;
    }

    private function calculateAverageHeightOfLineObjects(array $group): float
    {
        $heights = array_column($group, 'height');
        return array_sum($heights) / max(count($heights), 1);
    }

    public function mergeGroupedLinesToTextBlock(array $group): array
    {

        // Sortujemy linie od góry do dołu (po centerY)
        usort($group, fn($a, $b) => $a['centerY'] <=> $b['centerY']);

        $mergedText = implode("\n", array_map(
            fn($line) => trim($line['description']),
            $group
        ));

        $allStartX = array_column($group, 'startX');
        $allEndX   = array_column($group, 'endX');
        $allCenterY = array_column($group, 'centerY');
        $allHeights = array_column($group, 'height');

        return [
            'text' => $mergedText,
            'startX' => min($allStartX),
            'endX'   => max($allEndX),
            'minY'   => min($allCenterY) - max($allHeights)/2,
            'maxY'   => max($allCenterY) + max($allHeights)/2,
            'linesCount' => count($group),
        ];
    }

    public function mergeRelatedBlocks(array $blocks, float $verticalThreshold, float $xTolerance): array
    {
        usort($blocks, fn($a, $b) => $a['minY'] <=> $b['minY'] ?: $a['startX'] <=> $b['startX']);
        $merged = [];
        $visited = [];

        foreach ($blocks as $i => $block) {
            if (isset($visited[$i])) continue;

            $group = [$block];
            $visited[$i] = true;

            $changed = true;

            while ($changed) {
                $changed = false;

                foreach ($blocks as $j => $other) {
                    if (isset($visited[$j])) continue;

                    foreach ($group as $g) {
                        $centerX1 = ($g['startX'] + $g['endX']) / 2;
                        $centerX2 = ($other['startX'] + $other['endX']) / 2;
                        $similarX = abs($centerX1 - $centerX2) <= $xTolerance;

                        $verticallyClose = (
                            abs($g['maxY'] - $other['minY']) <= $verticalThreshold ||
                            ($other['minY'] >= $g['minY'] && $other['minY'] <= $g['maxY'])
                        );

                        if ($similarX && $verticallyClose) {
                            $group[] = $other;
                            $visited[$j] = true;
                            $changed = true;
                            break;
                        }
                    }
                }
            }

            // Sortuj i scal grupę
            usort($group, fn($a, $b) => $a['minY'] <=> $b['minY']);
            $merged[] = [
                'text'        => implode("\n", array_column($group, 'text')),
                'startX'      => min(array_column($group, 'startX')),
                'endX'        => max(array_column($group, 'endX')),
                'minY'        => min(array_column($group, 'minY')),
                'maxY'        => max(array_column($group, 'maxY')),
                'linesCount'  => array_sum(array_column($group, 'linesCount')),
            ];
        }

        return $merged;
    }


//    public function mergeRelatedBlocks(array $blocks, float $verticalThreshold = 20, float $xTolerance = 50): array
//    {
//        $merged = [];
//        $used = [];
//
//        foreach ($blocks as $i => $blockA) {
//            if (in_array($i, $used)) continue;
//
//            $group = [$blockA];
//            $used[] = $i;
//
//            foreach ($blocks as $j => $blockB) {
//                if ($i === $j || in_array($j, $used)) continue;
//
//                $closeVertically = abs($blockA['maxY'] - $blockB['minY']) <= $verticalThreshold;
//                $similarX = abs($blockA['startX'] - $blockB['startX']) <= $xTolerance;
//
//                if ($closeVertically && $similarX) {
//                    $group[] = $blockB;
//                    $used[] = $j;
//                }
//            }
//
//            // Sortuj po minY
//            usort($group, fn($a, $b) => $a['minY'] <=> $b['minY']);
//
//            // Scal teksty
//            $merged[] = [
//                'text' => implode("\n", array_column($group, 'text')),
//                'startX' => min(array_column($group, 'startX')),
//                'endX' => max(array_column($group, 'endX')),
//                'minY' => min(array_column($group, 'minY')),
//                'maxY' => max(array_column($group, 'maxY')),
//                'linesCount' => array_sum(array_column($group, 'linesCount')),
//            ];
//        }
//
//        return $merged;
//    }

}
