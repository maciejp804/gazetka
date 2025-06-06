<?php

$url = 'https://gazetkapromocyjna.com.pl/robots.txt';

$agents = [
    'browser' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
    'googlebot' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
];

// Opcjonalny IP do nadpisania (jeśli chcesz symulować, że połączenie pochodzi od Googlebota)
$simulatedIp = '66.249.66.1'; // Przykładowy IP Googlebota

foreach ($agents as $label => $userAgent) {
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_USERAGENT => $userAgent,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER => [
            'Accept-Encoding: gzip, deflate, br',
            "X-Forwarded-For: {$simulatedIp}",
            "True-Client-IP: {$simulatedIp}",
            "CF-Connecting-IP: {$simulatedIp}",
        ],
        // CURLOPT_PROXY => 'http://your-proxy:port', // ← jeśli chcesz test przez proxy
    ]);

    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $filename = __DIR__ . "/robots_response_{$label}.txt";

    if ($response !== false) {
        file_put_contents($filename, "=== HEADER ===\n");
        file_put_contents($filename, print_r($info, true), FILE_APPEND);
        file_put_contents($filename, "\n=== RESPONSE ===\n", FILE_APPEND);
        file_put_contents($filename, $response, FILE_APPEND);

        echo "✔️  {$label} zapisane do {$filename}, MD5: " . md5($response) . "\n";
    } else {
        echo "❌  Błąd {$label}: $error\n";
    }
}
