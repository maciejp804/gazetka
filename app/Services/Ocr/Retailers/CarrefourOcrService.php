<?php

namespace App\Services\Ocr\Retailers;

use App\Services\Ocr\AbstractOcrService;
use App\Services\Ocr\Parsers\CarrefourBlockParser;

class CarrefourOcrService extends AbstractOcrService
{
    public function __construct(CarrefourBlockParser $parser)
    {
        parent::__construct($parser);
    }

}
