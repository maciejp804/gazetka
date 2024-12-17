{{-- Wyniki dla gazetek --}}
@if(!empty($leaflets) && count($leaflets) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflets"/>
@endif

@if(!empty($retailers) && count($retailers) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="retailers-container" :items="$retailers" type="retailers"/>
@endif

@if(!empty($products) && count($products) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="products-container" :items="$products" type="products"/>
@endif

@if(!empty($vouchers) && count($vouchers) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="vouchers-container" :items="$vouchers" type="vouchers"/>
@endif
