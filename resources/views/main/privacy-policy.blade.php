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

            <p class="mx-6 my-2">
                Polityka prywatności opisuje zasady przetwarzania przez nas informacji na Twój temat, w tym danych osobowych oraz ciasteczek, czyli tzw. cookies.
            </p>
            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">1. Informacje ogólne</h2>
            <ol class="my-2 leading-10">
                <li class="px-8">
                    Niniejsza polityka dotyczy Serwisu www, funkcjonującego pod adresem url: <b>gazetkapromocyjna.com.pl</b>
                </li>
                <li class="mx-8">
                    Operatorem serwisu oraz Administratorem danych osobowych jest: GazetkaPromocyjna, Kartuska 39, 60-471 Poznań
                </li>
                <li class="mx-8">
                    Adres kontaktowy poczty elektronicznej operatora: <a href="mailto:kontakt@gazetkapromocyjna.com.pl">kontakt@gazetkapromocyjna.com.pl</a>
                </li>
                <li class="mx-8">
                    Operator jest Administratorem Twoich danych osobowych w odniesieniu do danych podanych dobrowolnie w Serwisie.
                </li>
                <li class="mx-8">
                    Serwis wykorzystuje dane osobowe w następujących celach:
                    <ul class="mx-6 list-disc">
                        <li class="mx-10">Prowadzenie newslettera</li>
                        <li class="mx-10">Prowadzenie systemu komentarzy</li>
                        <li class="mx-10">Obsługa zapytań przez formularz</li>
                        <li class="mx-10">Prezentacja oferty lub informacji</li>
                    </ul>
                </li>
                <li class="mx-8">
                    Serwis realizuje funkcje pozyskiwania informacji o użytkownikach i ich zachowaniu w następujący sposób:
                    <ol class="list-disc">
                        <li class="mx-8">
                            Poprzez dobrowolnie wprowadzone w formularzach dane, które zostają wprowadzone do systemów Operatora.
                        </li>
                        <li class="mx-8">
                            Poprzez zapisywanie w urządzeniach końcowych plików cookie (tzw. „ciasteczka”).
                        </li>
                    </ol>
                </li>
                <li class="mx-8">
                    <strong>Podstawa prawna przetwarzania danych:</strong> Przetwarzanie danych odbywa się na podstawie zgody użytkownika, niezbędności do wykonania umowy oraz prawnie uzasadnionych interesów Administratora, zgodnie z RODO.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">2. Wybrane metody ochrony danych stosowane przez Operatora</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Miejsca logowania i wprowadzania danych osobowych są chronione w warstwie transmisji (certyfikat SSL). Dzięki temu dane osobowe i dane logowania, wprowadzone na stronie, zostają zaszyfrowane w komputerze użytkownika i mogą być odczytane jedynie na docelowym serwerze.
                </li>
                <li class="mx-8">
                    Dane osobowe przechowywane w bazie danych są zaszyfrowane w taki sposób, że jedynie posiadający Operator klucz może je odczytać. Dzięki temu dane są chronione na wypadek wykradzenia bazy danych z serwera.
                </li>
                <li class="mx-8">
                    Hasła użytkowników są przechowywane w postaci hashowanej. Funkcja hashująca działa jednokierunkowo – nie jest możliwe odwrócenie jej działania, co stanowi współczesny standard w zakresie przechowywania haseł.
                </li>
                <li class="mx-8">
                    Operator okresowo zmienia swoje hasła administracyjne.
                </li>
                <li class="mx-8">
                    W celu ochrony danych Operator regularnie wykonuje kopie bezpieczeństwa.
                </li>
                <li class="mx-8">
                    Istotnym elementem ochrony danych jest regularna aktualizacja oprogramowania wykorzystywanego do przetwarzania danych osobowych, w tym aktualizacje komponentów programistycznych.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">3. Hosting</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Serwis jest hostowany (technicznie utrzymywany) na serwerach operatora: cyberFolks.pl
                </li>
                <li class="mx-8">
                    Firma hostingowa, w celu zapewnienia niezawodności technicznej, prowadzi logi na poziomie serwera. Zapisowi mogą podlegać:
                    <ul class="list-disc">
                        <li class="mx-8">
                            zasoby określone identyfikatorem URL (adresy żądanych zasobów – stron, plików),
                        </li>
                        <li class="mx-8">
                            czas nadejścia zapytania,
                        </li>
                        <li class="mx-8">
                            czas wysłania odpowiedzi,
                        </li>
                        <li class="mx-8">
                            nazwa stacji klienta – identyfikacja realizowana przez protokół HTTP,
                        </li>
                        <li class="mx-8">
                            informacje o błędach, które wystąpiły przy realizacji transakcji HTTP,
                        </li>
                        <li class="mx-8">
                            adres URL strony poprzednio odwiedzanej przez użytkownika (referer link) – w przypadku, gdy przejście do Serwisu nastąpiło przez odnośnik,
                        </li>
                        <li class="mx-8">
                            informacje o przeglądarce użytkownika,
                        </li>
                        <li class="mx-8">
                            informacje o adresie IP,
                        </li>
                        <li class="mx-8">
                            informacje diagnostyczne związane z procesem zamawiania usług poprzez rejestratory na stronie,
                        </li>
                        <li class="mx-8">
                            informacje związane z obsługą poczty elektronicznej kierowanej do Operatora oraz wysyłanej przez Operatora.
                        </li>
                    </ul>
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">4. Twoje prawa i dodatkowe informacje o sposobie wykorzystania danych</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    W niektórych sytuacjach Administrator ma prawo przekazywać Twoje dane osobowe innym odbiorcom, jeśli będzie to niezbędne do wykonania zawartej z Tobą umowy lub do zrealizowania obowiązków ciążących na Administratorze. Dotyczy to takich grup odbiorców:
                    <ul class="list-disc">
                        <li class="mx-8">firma hostingowa na zasadzie powierzenia,</li>
                        <li class="mx-8">upoważnieni pracownicy i współpracownicy, którzy korzystają z danych w celu realizacji celów działania Serwisu,</li>
                        <li class="mx-8">firmy świadczące usługi marketingu na rzecz Administratora.</li>
                    </ul>
                </li>
                <li class="mx-8">
                    Twoje dane osobowe przetwarzane przez Administratora nie będą przechowywane dłużej niż jest to konieczne do wykonania czynności określonych przepisami prawa (np. o prowadzeniu rachunkowości). W odniesieniu do danych marketingowych okres przechowywania nie przekroczy 3 lat, natomiast pozostałe dane będą przechowywane przez okres niezbędny do realizacji celów, dla których zostały zebrane.
                </li>
                <li class="mx-8">
                    Przysługuje Ci prawo żądania od Administratora:
                    <ul class="list-disc">
                        <li class="mx-8">dostępu do danych osobowych Ciebie dotyczących,</li>
                        <li class="mx-8">ich sprostowania,</li>
                        <li class="mx-8">usunięcia,</li>
                        <li class="mx-8">ograniczenia przetwarzania,</li>
                        <li class="mx-8">oraz przenoszenia danych.</li>
                    </ul>
                </li>
                <li class="mx-8">
                    Przysługuje Ci również prawo do złożenia sprzeciwu wobec przetwarzania danych osobowych w celach marketingowych lub na podstawie prawnie uzasadnionych interesów, chyba że istnieją nadrzędne podstawy prawne (np. w celu ustalenia, dochodzenia lub obrony roszczeń).
                </li>
                <li class="mx-8">
                    Na działania Administratora przysługuje skarga do Prezesa Urzędu Ochrony Danych Osobowych, ul. Stawki 2, 00-193 Warszawa.
                </li>
                <li class="mx-8">
                    Podanie danych osobowych jest dobrowolne, lecz niezbędne do obsługi Serwisu.
                </li>
                <li class="mx-8">
                    W stosunku do Ciebie mogą być podejmowane czynności polegające na zautomatyzowanym podejmowaniu decyzji, w tym profilowaniu, w celu świadczenia usług w ramach zawartej umowy oraz prowadzenia przez Administratora marketingu bezpośredniego.
                </li>
                <li class="mx-8">
                    Dane osobowe nie są przekazywane z krajów trzecich, co oznacza, że nie przesyłamy ich poza teren Unii Europejskiej.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">5. Informacje w formularzach</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Serwis zbiera informacje podane dobrowolnie przez użytkownika, w tym dane osobowe, o ile zostaną one podane.
                </li>
                <li class="mx-8">
                    Serwis może zapisać informacje o parametrach połączenia (oznaczenie czasu, adres IP).
                </li>
                <li class="mx-8">
                    W niektórych przypadkach Serwis może zapisać informację ułatwiającą powiązanie danych w formularzu z adresem e-mail użytkownika. W takim przypadku adres e-mail pojawia się wewnątrz adresu URL strony zawierającej formularz.
                </li>
                <li class="mx-8">
                    Dane podane w formularzu są przetwarzane w celu wynikającym z funkcji konkretnego formularza, np. obsługi zgłoszenia serwisowego, kontaktu handlowego czy rejestracji usług. Każdorazowo kontekst i opis formularza jasno informują o jego przeznaczeniu.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">6. Logi Administratora</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Informacje o zachowaniu użytkowników w Serwisie mogą być logowane i wykorzystywane do celów administracyjnych oraz analitycznych, co pozwala na ulepszanie funkcjonowania Serwisu.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">7. Istotne techniki marketingowe</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Operator stosuje analizę statystyczną ruchu na stronie przy użyciu Google Analytics (Google Inc. z siedzibą w USA). Operator przekazuje jedynie zanonimizowane dane. Usługa bazuje na wykorzystaniu ciasteczek w urządzeniu końcowym użytkownika. W zakresie informacji o preferencjach użytkownika, gromadzonych przez sieć reklamową Google, użytkownik może przeglądać i edytować te informacje za pomocą narzędzia: <a href="https://myadcenter.google.com/home" class="text-blue-550 underline">https://myadcenter.google.com/home</a>
                </li>
                <li class="mx-8">
                    Operator korzysta z piksela Facebooka. Technologia ta umożliwia serwisowi Facebook (Facebook Inc. z siedzibą w USA) rozpoznanie, że osoba zarejestrowana na tej platformie korzysta z Serwisu. Dane wykorzystywane przez Facebook są zarządzane przez tego dostawcę i nie są dodatkowo przekazywane przez Operatora.
                </li>
                <li class="mx-8">
                    Operator stosuje rozwiązania automatyzujące działanie Serwisu, np. wysyłanie wiadomości e-mail do użytkowników po odwiedzeniu konkretnej podstrony, o ile wyrazili oni zgodę na otrzymywanie korespondencji handlowej.
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">8. Informacja o plikach cookies</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Serwis korzysta z plików cookies.
                </li>
                <li class="mx-8">
                    Pliki cookies (tzw. „ciasteczka”) to dane informatyczne, w szczególności pliki tekstowe, przechowywane w urządzeniu końcowym użytkownika, przeznaczone do korzystania ze stron internetowych Serwisu. Cookies zazwyczaj zawierają nazwę strony, czas przechowywania oraz unikalny identyfikator.
                </li>
                <li class="mx-8">
                    Podmiotem umieszczającym pliki cookies na urządzeniu końcowym użytkownika jest Operator Serwisu.
                </li>
                <li class="mx-8">
                    Pliki cookies wykorzystywane są w następujących celach:
                    <ol class="list-disc">
                        <li class="mx-8">
                            utrzymanie sesji użytkownika po zalogowaniu, dzięki czemu użytkownik nie musi ponownie wpisywać loginu i hasła na każdej podstronie,
                        </li>
                        <li class="mx-8">
                            realizacja celów marketingowych i analitycznych opisanych w sekcji "Istotne techniki marketingowe".
                        </li>
                    </ol>
                </li>
                <li class="mx-8">
                    Stosowane są dwa rodzaje plików cookies:
                    <ul class="list-disc">
                        <li class="mx-8">
                            <strong>Cookies sesyjne</strong> – tymczasowe, przechowywane do momentu wylogowania lub zamknięcia przeglądarki,
                        </li>
                        <li class="mx-8">
                            <strong>Cookies stałe</strong> – przechowywane przez określony czas lub do momentu ich usunięcia przez użytkownika.
                        </li>
                    </ul>
                </li>
                <li class="mx-8">
                    Przeglądarka internetowa zazwyczaj domyślnie dopuszcza zapisywanie plików cookies. Użytkownicy mogą zmienić ustawienia w tym zakresie, usunąć cookies lub automatycznie blokować ich zapis, zgodnie z dokumentacją przeglądarki.
                </li>
                <li class="mx-8">
                    Ograniczenie stosowania plików cookies może wpłynąć na funkcjonalność niektórych elementów Serwisu.
                </li>
                <li class="mx-8">
                    Pliki cookies umieszczane na urządzeniu użytkownika mogą być również wykorzystywane przez podmioty współpracujące z Operatorem, takie jak: Google (Google Inc. z siedzibą w USA) oraz Facebook (Facebook Inc. z siedzibą w USA).
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">9. Zarządzanie plikami cookies – jak w praktyce wyrażać i cofać zgodę?</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Jeśli użytkownik nie chce otrzymywać plików cookies, może zmienić ustawienia przeglądarki. Wyłączenie cookies niezbędnych dla uwierzytelnienia, bezpieczeństwa czy utrzymania preferencji może jednak utrudnić lub uniemożliwić korzystanie z Serwisu.
                </li>
                <li class="mx-8">
                    Aby zarządzać ustawieniami cookies, wybierz przeglądarkę, której używasz, i postępuj zgodnie z instrukcjami:
                    <ul>
                        <li class="mx-8"><a class="underline text-blue-550" href="https://support.microsoft.com/pl-pl/help/10607/microsoft-edge-view-delete-browser-history">Edge</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="https://support.microsoft.com/pl-pl/help/278835/how-to-delete-cookie-files-in-internet-explorer">Internet Explorer</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://support.google.com/chrome/bin/answer.py?hl=pl&amp;answer=95647">Chrome</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://support.apple.com/kb/PH5042">Safari</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://support.mozilla.org/pl/kb/W%C5%82%C4%85czanie%20i%20wy%C5%82%C4%85czanie%20obs%C5%82ugi%20ciasteczek">Firefox</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://help.opera.com/Windows/12.10/pl/cookies.html">Opera</a></li>
                    </ul>
                    <p>Urządzenia mobilne:</p>
                    <ul>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://support.google.com/chrome/bin/answer.py?hl=pl&amp;answer=95647">Android</a></li>
                        <li class="mx-8"><a class="underline text-blue-550" href="http://support.apple.com/kb/HT1677?viewlocale=pl_PL">Safari (iOS)</a></li>
                    </ul>
                </li>
            </ol>

            <h2 class="pb-3 text-xl mx-6 mt-2 font-semibold">10. Inspektor Ochrony Danych</h2>
            <ol class="leading-10">
                <li class="mx-8">
                    Jeżeli Operator wyznaczył Inspektora Ochrony Danych, dane kontaktowe Inspektora będą dostępne w Serwisie lub po bezpośrednim zapytaniu do Administratora.
                </li>
            </ol>
        </x-div-1060>
    </x-section>


</x-layout>
