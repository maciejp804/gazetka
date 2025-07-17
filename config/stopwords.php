<?php

return [
    'all' => [
    'do', 'dla', 'na', 'z', 'w', 'po', 'od', 'za', 'i', 'lub', 'czy', 'albo',
    'taki', 'ten', 'jego', 'jej', 'tego', 'ich', 'ta', 'to', 'tam', 'tu', 'te','przed'
    ],
    'auchan' => [
        '/najniższa cena z 30 dni przed obniżką to [\d\.,]+ zł/i',
        '/\** Procent obniżki odnosi się w zależności od produktu do najniższej ceny z okresu \d+ dni/i',
        '/\*.*?przed wprowadzeniem obniżki lub ceny sprzed pierwszego zastosowania obniżki/i',
        '/\*.*?przed wprowadzeniem obniżki/i',
        '/przy zakupie \d+ szt\.?/i',
        '/cena za 1 szt\.?/i',
        '/cena za 100 g -[\d\.,]+ zł/i',
        '/cena za 1 kg -[\d\.,]+ zł/i',
        '/\s{2,}/',
        '/pęczek/i'// wielokrotne spacje
    ],
];
