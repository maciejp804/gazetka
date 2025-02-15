<x-layout :main_domain>
    <x-slot:place>
        {{ $place->name }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>

    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>


    <x-section class="flex-col mx-4 mt-4">
        <x-div-1060 class="text-lg">
            <x-h1-title class="font-bold" :h1-title="$h1_title" />
                <p class="mt-2 pl-4">
                    Internetowy serwis informacyjny
                    <a class="underline text-blue-550" href="https://gazetkapromocyjna.com.pl">gazetkapromocyjna.com.pl</a>
                    (dalej „Serwis”), prowadzony jest przez Usługodawcę – Gazetka Promocyjna, z siedzibą w Poznaniu przy ul. Kartuskiej 39, wpisaną do rejestru przedsiębiorców, REGON: 639733819, e-mail:
                    <a class="underline text-blue-550" href="mailto:kontakt@gazetkapromocyjna.com.pl">kontakt@gazetkapromocyjna.com.pl</a>, nr telefonu: 889921990.
                </p>

                <p class="mt-2 pl-4">
                    1. Zamieszczony regulamin definiuje zakres i sposób funkcjonowania serwisu
                    <a class="underline text-blue-550" href="https://gazetkapromocyjna.com.pl">gazetkapromocyjna.com.pl</a>, funkcjonującego jako serwis informacyjny.
                </p>

                <p class="mt-2 pl-4">
                    2. Zamierzeniem Serwisu jest udostępnianie informacji o przygotowywanych ofertach, gazetkach i akcjach promocyjnych wydawanych online i nie tylko przez sieci handlowe znajdujące się na terytorium Polski. Serwis jest jedynie stroną informacyjną i nie pełni funkcji sklepu ani sklepu internetowego.
                </p>

                <p class="mt-2 pl-4">
                    3. Użytkownikiem Serwisu jest osoba, która odwiedza Serwis w sieci Internet.
                </p>

                <p class="mt-2 pl-4">
                    4. Odnośniki do stron oraz informacje ze stron internetowych zamieszczane są spośród materiałów udostępnionych i rozpowszechnianych publicznie i bezpłatnie przez sieci handlowe, a także za pomocą zgłoszeń dokonanych przez podmioty handlowe. Ideą Serwisu jest informowanie o sieciach handlowych, ich stronach internetowych, a także o przygotowywanych akcjach promocyjnych przez sieci handlowe, m.in. na podstawie gazetek reklamowych.
                </p>

                <p class="mt-2 pl-4">
                    5. Osoby prowadzące Serwis dokładają pełnych starań, aby informacje przedstawiane w Serwisie były aktualne i wiarygodne, jednak zastrzegają sobie prawo do pomyłek i błędów, a użytkownik, godząc się z tym faktem, nie będzie rościł sobie żadnych praw z tytułu ewentualnych błędów.
                </p>

                <p class="mt-2 pl-4">
                    6. Osoby prowadzące Serwis nie ponoszą odpowiedzialności za skutki decyzji podjętych na podstawie zawartych treści.
                </p>

                <p class="mt-2 pl-4">
                    7. Akcje promocyjne kończą się w terminie wskazanym w ofercie przez podmiot handlowy lub w chwili wyczerpania zapasów.
                </p>

                <p class="mt-2 pl-4">
                    8. Prawa autorskie do grafik zawartych w materiałach promocyjnych udostępnianych przez podmioty handlowe należą do tych podmiotów.
                </p>

                <p class="mt-2 pl-4">
                    9. Wszystkie nazwy firmowe oraz znaki towarowe zostały wykorzystane w Serwisie jedynie w celach informacyjnych.
                </p>

                <p class="mt-2 pl-4">
                    10. Znaki towarowe wyświetlane są na podstawie art. 158 ust. 1 ustawy Prawo własności przemysłowej.
                </p>

                <p class="mt-2 pl-4">
                    11. W sytuacji braku zgody na zamieszczanie w Serwisie informacji oraz materiałów promocyjnych, nazw i znaków towarowych dotyczących danego podmiotu handlowego, należy przesłać odpowiednią informację na adres mailowy:
                    <a class="underline text-blue-550" href="mailto:kontakt@gazetkapromocyjna.com.pl">kontakt@gazetkapromocyjna.com.pl</a>, a zakwestionowane treści zostaną usunięte ze stron Serwisu.
                </p>

                <p class="mt-2 pl-4">
                    12. Informacje o akcjach promocyjnych zamieszczone w Serwisie nie stanowią oferty handlowej w rozumieniu prawa handlowego.
                </p>

                <p class="mt-2 pl-4">
                    13. Korzystanie z Serwisu oznacza pełną akceptację treści niniejszego regulaminu.
                </p>

                <p class="mt-2 pl-4">
                    14. Usługodawca ma prawo do zmiany Regulaminu. O powyższych zmianach Użytkownicy zostaną poinformowani na stronie
                    <a class="underline text-blue-550" href="https://gazetkapromocyjna.com.pl">gazetkapromocyjna.com.pl</a>.
                </p>

                <p class="mt-2 pl-4">
                    15. Zmiany Regulaminu wchodzą w życie w terminie wskazanym na stronie internetowej, nie wcześniej jednak niż po 7 dniach od daty ich opublikowania.
                </p>

                <p class="mt-2 pl-4">
                    16. Serwis oferuje płatne wyświetlanie oferty w postaci banera reklamowego na podstawie indywidualnej oferty.
                </p>

                <p class="mt-2 pl-4">
                    17. Po dodaniu ogłoszenia do Serwisu, Ogłaszający jest zobowiązany do sprawdzenia, czy ogłoszenie zostało opublikowane zgodnie z podanymi przez niego danymi.
                </p>

                <p class="mt-2 pl-4">
                    18. Użytkownik oraz Ogłaszający mają prawo zgłosić reklamację dotyczącą nienależytego wykonania usługi. Reklamacja może być złożona do dnia zakończenia publikacji ogłoszenia w Serwisie lub do dnia, w którym ogłoszenie miało być opublikowane.
                </p>

                <p class="mt-2 pl-4">
                    19. Reklamacje należy składać pisemnie lub w formie elektronicznej na adres Usługodawcy lub na adres mailowy:
                    <a class="underline text-blue-550" href="mailto:kontakt@gazetkapromocyjna.com.pl">kontakt@gazetkapromocyjna.com.pl</a>.
                </p>

                <p class="mt-2 pl-4">
                    20. Reklamacje będą rozstrzygane w terminie do 7 dni roboczych licząc od daty otrzymania reklamacji przez Usługodawcę.
                </p>

                <p class="mt-2 pl-4">
                    21. Regulamin podlega prawu polskiemu. Wszelkie spory wynikłe z korzystania z Serwisu będą rozstrzygane przez sąd właściwy dla siedziby Usługodawcy.
                </p>
        </x-div-1060>
    </x-section>


</x-layout>
