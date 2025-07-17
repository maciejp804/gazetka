<?php

namespace App\Services\Ocr\Retailers;

use App\Services\Ocr\AbstractOcrService;
use App\Services\Ocr\Parsers\AuchanBlockParser;
use App\Services\Ocr\Parsers\CarrefourBlockParser;

class AuchanOcrService extends AbstractOcrService
{
    public function __construct(AuchanBlockParser $parser)
    {
        parent::__construct($parser);
    }

}
