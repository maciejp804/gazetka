<?php

namespace App\Services\Ocr\Retailers;

use App\Services\Ocr\AbstractOcrService;
use App\Services\Ocr\Parsers\BiedronkaBlockParser;

class BiedronkaOcrService extends AbstractOcrService
{
    public function __construct(BiedronkaBlockParser $parser)
    {
        parent::__construct($parser);
    }

}
