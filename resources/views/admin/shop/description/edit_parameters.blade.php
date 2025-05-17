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
                $parameters = old('parameters', $product->globalDescription->parameters ?? []);
            @endphp
            <form action="{{ route('admin.products.description.parameters.update', $product) }}" method="POST" >
                @csrf
                @method('PUT')
                <div id="parameters-wrapper">
                    @foreach($parameters as $key => $value)
                        <div class="parameter-item border rounded p-4 mb-3 relative">
                            <input type="text" name="parameters[{{ $loop->index }}][key]" class="w-full mb-2 border-gray-300" placeholder="Nazwa parametru" value="{{ $key }}">
                            <textarea name="parameters[{{ $loop->index }}][value]" class="w-full border-gray-300" placeholder="Wartość">{{ $value }}</textarea>
                            <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-full bg-white border border-gray-300 absolute top-2 right-2 text-sm hover:border-red-600">🗑️</button>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" id="parameters-counter" value="{{ count($parameters) }}">
                <x-form.submit label="Edytuj Parametry"/>
                <button type="button" onclick="addParameter()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">➕ Dodaj parametr</button>
            </form>
            <script>
                function addParameter() {
                    let index = parseInt(document.getElementById('parameters-counter').value);
                    const wrapper = document.getElementById('parameters-wrapper');

                    const div = document.createElement('div');
                    div.className = "parameter-item border rounded p-4 mb-3 relative";
                    div.innerHTML = `
            <input type="text" name="parameters[${index}][key]" class="w-full mb-2 border-gray-300" placeholder="Nazwa parametru">
            <textarea name="parameters[${index}][value]" class="w-full border-gray-300" placeholder="Wartość"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-full bg-white border border-gray-300 absolute top-2 right-2 text-sm hover:border-red-600">🗑️</button>
        `;

                    wrapper.appendChild(div);
                    document.getElementById('parameters-counter').value = index + 1;
                }
            </script>


    </div>
</x-layout-panel>
