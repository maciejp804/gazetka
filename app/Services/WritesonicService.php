<?php
// app/Services/WritesonicService.php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WritesonicService
{
    protected $client;
    protected $apiToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiToken = config('services.writesonic.token'); // Token z pliku konfiguracyjnego
    }

    /**
     * Generuje opis produktu przy użyciu Writesonic API.
     *
     * @param array $payload - Dane do wysłania do API
     * @return string - Wygenerowany opis lub komunikat o błędzie
     */
    public function generateProductDescription($payload)
    {
        try {
            $response = $this->client->post('https://api.writesonic.com/v2/business/content/product-descriptions?engine=premium&language=pl&num_copies=1', [
                'json' => $payload,  // Dane wysyłane do API w formacie JSON
                'headers' => [
                    'X-API-KEY' => $this->apiToken,  // Własny token API
                    'accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Sprawdzamy, czy odpowiedź zawiera 'output' z wygenerowanym opisem
            return $data ?? 'Opis nie został wygenerowany';

        } catch (RequestException $e) {
            // Obsługuje błędy związane z zapytaniem HTTP
            return 'Błąd podczas łączenia z API Writesonic: ' . $e->getMessage();
        } catch (\Exception $e) {
            // Ogólny wyjątek dla innych błędów
            return 'Wystąpił błąd: ' . $e->getMessage();
        }
    }
}
