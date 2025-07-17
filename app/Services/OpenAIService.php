<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function connect()
    {
        $response = Http::withToken(config('services.openai.token'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Odpowiadaj w formacie JSON'],
                    ['role' => 'user', 'content' => 'Podaj 10 marek chipsów w Polsce z aliasami']
                ],
            ]);

        $data = $response->json();

        return $data;
    }
}
