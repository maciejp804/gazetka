<?php

namespace App\Services\Ocr\Retailers;

use App\Services\Ocr\AbstractOcrService;
use App\Services\Ocr\Parsers\ChataPolskaBlockParser;

class ChataPolskaOcrService extends AbstractOcrService
{
    public function __construct(ChataPolskaBlockParser $parser)
    {
        parent::__construct($parser);
    }
}
