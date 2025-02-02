{{-- Wyniki dla gazetek --}}
@if($searchType == 'leaflets')
    <x-section-filtr-results :ads-status="true" data-container-id="leaflet-filter" :items="$results" :type="$searchType"/>
@endif

@if($searchType == 'retailers')
    <x-section-filtr-results :ads-status="true" data-container-id="retailers-filter" :items="$results" :type="$searchType"/>
@endif

@if($searchType == 'products')
    <x-section-filtr-results :ads-status="true" data-container-id="products-filter" :items="$results" :type="$searchType"/>
@endif

@if($searchType == 'vouchers')
    <x-section-filtr-results :ads-status="true" data-container-id="vouchers-filter" :items="$results" :type="$searchType"/>
@endif
