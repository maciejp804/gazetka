{{-- Wyniki dla gazetek --}}
@if(!empty($leaflets) && count($leaflets) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflet"/>
@endif

@if(!empty($retailers) && count($retailers) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="retailers-container" :items="$retailers" type="retailer"/>
@endif

@if(!empty($products) && count($products) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="products-container" :items="$products" type="product"/>
@endif

@if(!empty($vouchers) && count($vouchers) > 0)
    <x-section-filtr-results :ads-status="true" data-container-id="vouchers-container" :items="$vouchers" type="voucher"/>
@endif
