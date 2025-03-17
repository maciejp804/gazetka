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


    <x-section class="flex-col mx-4 xl:m-auto">
        <x-h1-title h1Title="O nas" />
        <x-description :items="$descriptions"/>
    </x-section>


</x-layout>
