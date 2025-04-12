<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Product</h1>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <div class="flex flex-col max-w-3xl mx-auto bg-white p-6 rounded shadow">
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
        @php
            $excerpt = old('excerpt', $product->descriptions->excerpt ?? '[]');
        @endphp
        <form action="{{ route('admin.products.description.excerpt.update', $product) }}" method="POST" >
            @csrf
            @method('PUT')
            <div id="faq-wrapper">
                 <div class="faq-item border rounded p-4 mb-3 relative">
                     <x-form.textarea type="textarea" name="excerpt" label="Wstęp" placeholder="Krótki wstęp..." :value="$excerpt"  maxlength="600"/>
                 </div>

            </div>
            <x-form.submit label="Edytuj Wstęp"/>

        </form>

    </div>
</x-layout-panel>
