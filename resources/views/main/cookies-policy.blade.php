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
                Prawo telekomunikacyjne Art.173
            </p>
            <ol class="my-2">
                Art. 173. 1. Przechowywanie informacji lub uzyskiwanie dostępu do informacji
                już przechowywanej w telekomunikacyjnym urządzeniu końcowym abonenta lub
                użytkownika końcowego jest dozwolone, pod warunkiem że:
                <ul class="leading-10 mt-4">
                    <li class="leading-normal pl-2">
                        1) abonent lub użytkownik końcowy zostanie uprzednio bezpośrednio
                        poinformowany w sposób jednoznaczny, łatwy i zrozumiały, o:
                    </li>
                    <li class="leading-normal pl-4">
                        a) celu przechowywania i uzyskiwania dostępu do tej informacji,
                    </li>
                    <li class="leading-normal pl-4">
                        b) możliwości określenia przez niego warunków przechowywania lub
                        uzyskiwania dostępu do tej informacji za pomocą ustawień
                        oprogramowania zainstalowanego w wykorzystywanym przez niego
                        telekomunikacyjnym urządzeniu końcowym lub konfiguracji usługi;
                    </li>
                    <li class="leading-normal pl-2">
                        2) abonent lub użytkownik końcowy, po otrzymaniu informacji, o których mowa
                        w pkt 1, wyrazi na to zgodę;
                    </li>
                    <li class="leading-normal pl-2">
                        3) przechowywana informacja lub uzyskiwanie do niej dostępu nie powoduje zmian
                        konfiguracyjnych w telekomunikacyjnym urządzeniu końcowym abonenta lub
                        użytkownika końcowego i oprogramowaniu zainstalowanym w tym urządzeniu.
                    </li>
                </ul>
                <ul>
                    <li class="leading-normal mt-4">
                        2. Abonent lub użytkownik końcowy może wyrazić zgodę, o której mowa
                        w ust. 1 pkt 2, za pomocą ustawień oprogramowania zainstalowanego
                        w wykorzystywanym przez niego telekomunikacyjnym urządzeniu końcowym lub
                        konfiguracji usługi.
                    </li>
                    <li class="leading-normal mt-4">
                        3. Warunków, o których mowa w ust. 1, nie stosuje się, jeżeli przechowywanie
                        lub uzyskanie dostępu do informacji, o której mowa w ust. 1, jest konieczne do:
                    </li>
                    <li class="leading-normal pl-2">
                        1) wykonania transmisji komunikatu za pośrednictwem publicznej sieci
                        telekomunikacyjnej;
                    </li>
                    <li class="leading-normal pl-2">
                        2) dostarczania usługi telekomunikacyjnej lub usługi świadczonej drogą
                        elektroniczną, żądanej przez abonenta lub użytkownika końcowego.
                    </li>
                    <li class="leading-normal mt-4">
                        4. Podmioty świadczące usługi telekomunikacyjne lub usługi drogą
                        elektroniczną mogą instalować oprogramowanie w telekomunikacyjnym urządzeniu
                        końcowym abonenta lub użytkownika końcowego przeznaczonym do korzystania
                        z tych usług lub korzystać z tego oprogramowania, pod warunkiem że abonent lub
                        użytkownik końcowy:
                    </li>
                    <li class="leading-normal pl-2">
                        1) przed instalacją oprogramowania zostanie poinformowany bezpośrednio,
                        w sposób jednoznaczny, łatwy i zrozumiały, o celu, w jakim zostanie
                        zainstalowane oprogramowanie, oraz sposobach korzystania przez podmiot
                        świadczący usługi z tego oprogramowania;
                    </li>
                    <li class="leading-normal pl-2">
                        2) zostanie poinformowany bezpośrednio, w sposób jednoznaczny, łatwy
                        i zrozumiały, o sposobie usunięcia oprogramowania z telekomunikacyjnego
                        urządzenia końcowego użytkownika lub abonenta;
                    </li>
                    <li class="leading-normal pl-2">
                        3) przed instalacją oprogramowania wyrazi zgodę na jego instalację i używanie.
                    </li>
                </ul>
            </ol>
        </x-div-1060>
    </x-section>


</x-layout>
