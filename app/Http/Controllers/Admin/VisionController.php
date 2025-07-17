<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ocr\Retailers\BiedronkaOcrService;
use App\Services\Ocr\XmlProcess\XmlProductParser;
use App\Services\OpenAIService;
use App\Services\OpenFoodFactsServices;

class VisionController extends Controller
{

    protected BiedronkaOcrService $ocrService;

    protected XmlProductParser $parser;

    protected OpenAIService  $openAIService;

    protected OpenFoodFactsServices $factsServices;

    public function __construct(BiedronkaOcrService $ocrService, XmlProductParser $parser, OpenAIService $openAIService, OpenFoodFactsServices $factsServices)
    {
        $this->ocrService = $ocrService;
        $this->parser = $parser;
        $this->openAIService = $openAIService;
        $this->factsServices = $factsServices;
    }

//    public function send()
//    {
////        $result = $this->parser->parse(storage_path('app/ocr/kaufland.xml'));
//
//
//        $imagePath = asset('/assets/images/68517e7c42f1a.webp'); // tutaj podaj ścieżkę do swojego obrazu
//        $imageData = base64_encode(file_get_contents($imagePath));
//
//        $response = Http::withHeaders([
//            'Content-Type' => 'application/json',
//        ])->post('https://vision.googleapis.com/v1/images:annotate?key=' . config('services.vision.token'), [
//            'requests' => [[
//                'image' => ['content' => $imageData],
//                'features' => [[
//                    'type' => 'TEXT_DETECTION',
//                    'maxResults' => 1
//                ]]
//            ]]
//        ]);
//
//        Storage::put("ocr/page-1.json", $response);
//        $json = json_decode(Storage::get('ocr/page-1.json'), true);
////        dd(array_slice($json['responses'][0]['textAnnotations'], 1));
//        $mergedBlocks = $this->ocrService->groupAndMerge(array_slice($json['responses'][0]['textAnnotations'], 1));
//
//        $productDetails = $this->ocrService->extractProductDetails($mergedBlocks);
//        $result = $this->ocrService->mergeDuplicateProductBlocks($productDetails, 300);
//        return response()->json($result);
//
//    }

    public function chat()
    {
        return $this->openAIService->connect();
    }

    public function productsOpenFood($product)
    {
        return $this->factsServices->connect($product);
    }

}
