<?php

namespace App\Services;

use App\Models\Leaflet;


class LeafletService
{
    public function getLeaflets($limit = 'all', $shop_id = null, $order = [['updated_at', 'desc']], $pinned = null)
    {

        $leaflets = Leaflet::with(['shop', 'cover', 'pages'])
            ->whereHas('cover') // dodane: tylko jeśli istnieje cover
            ->whereHas('pages')
            ->where('display_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', 'published');

        if (!is_null($pinned)) {
            $leaflets = $leaflets->where('pinned', $pinned);
        }

        if(!is_null($shop_id)){
            $leaflets = $leaflets->where('shop_id', '=', $shop_id);
        }

        foreach ($order as $item) {

            $leaflets = $leaflets->orderBy($item[0], $item[1]);
        }
        $leaflets = $leaflets->get();

        if(is_null($shop_id)) {
            $counter_leaflets = $leaflets->count();
        } else {
            $counter_leaflets = 0;
        }

        if ($limit != 'all') {
            $leaflets = $leaflets->take($limit);
        }

        return [$leaflets, $counter_leaflets];
    }


    public function getLeafletsSimplePaginate($pages, $category = 'all')
    {

        $leaflets = Leaflet::with('shop', 'cover', 'products.category')
            ->where('display_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('leaflets.status', '=', 'published')
            ->whereHas('cover')
            ->whereHas('pages');

        if ($category != 'all')
        {
            $leaflets->whereHas('products.category', function ($queryProduct) use ($category) {
                $queryProduct->where('id', $category)
                    ->orWhere('parent_id', $category);
            });
        }

        return $leaflets->paginate($pages, ['*']);
    }


}
