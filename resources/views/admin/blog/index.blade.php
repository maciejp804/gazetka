<x-layout-panel>
    <div class="min-h-full">
        <x-admin.header-back/>
        <header class="bg-white shadow mb-6">
            <div class="flex justify-between mx-auto max-w-7xl">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Blog</h1>
                </div>
                <div class="flex items-center w-1/3">
                    <input type="text" id="search-products" placeholder="Szukaj artykułu..."
                           class="w-full border border-gray-200 focus:border-gray-200
                       placeholder-gray-400 focus:outline-none focus:ring-0 bg-white-50 rounded-3xl px-4 py-2 shadow" />
                </div>
                <div class="flex items-center px-4">
                    <x-buttons.primary-a :url="route('admin.blogs.create')">Dodaj artykuł</x-buttons.primary-a>
                </div>
            </div>
        </header>
        <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <p class="font-bold mb-2">Wystąpiły błędy:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div id="product-results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">

                    <x-admin.blog-item :items="$blogs"/>

                </div>
                {{ $blogs->links('custom-paginator') }}
            </div>
        </main>
    </div>
</x-layout-panel>
