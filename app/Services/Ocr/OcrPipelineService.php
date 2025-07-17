<?php

namespace App\Services\Ocr;

use App\Services\Ocr\Groupers\GroupAndMergeService;
use App\Services\Ocr\Groupers\LineGroupingService;

class OcrPipelineService
{
    protected AbstractOcrService $ocrService;

    protected GroupAndMergeService $groupAndMergeService;

    protected LineGroupingService $lineGroupingService;

    public function __construct(GroupAndMergeService $groupAndMergeService,
                                LineGroupingService $lineGroupingService,
                                AbstractOcrService $ocrService)
    {
        $this->groupAndMergeService = $groupAndMergeService;
        $this->lineGroupingService = $lineGroupingService;
        $this->ocrService = $ocrService;
    }
    public function ocrProcess(array $words, float $verticalThreshold = 30, float $xTolerance = 50): array
    {
        // Krok 1: Grupuj słowa poziomo w rygorystyczne linie.
        $lines = $this->groupAndMergeService->groupWordsIntoLines($words); // lines jest teraz tablicą tablic słów, np. [['word1', 'word2'], ['word3']]

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
//        dd($finalGroups);


        $mergedBlocks =  $this->lineGroupingService->mergeRelatedBlocks($finalGroups, $verticalThreshold , $xTolerance);

//        dd($mergedBlocks);

        [$productDetails, $suggestions] = $this->ocrService->extractProductDetails($mergedBlocks);

        return [$productDetails, $suggestions];

    }
}
