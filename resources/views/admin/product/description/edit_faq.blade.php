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
            $faqs = old('faq', $product->descriptions->faq ?? '[]');
        @endphp
        <form action="{{ route('admin.products.description.faq.update', $product) }}" method="POST" >
            @csrf
            @method('PUT')
            <div id="faq-wrapper">
                @foreach($faqs as $index => $faq)
                    <div class="faq-item border rounded p-4 mb-3 relative">
                        <input type="text" name="faq[{{ $index }}][question]" class="w-full mb-2 border-gray-300" placeholder="Pytanie" value="{{ $faq['question'] ?? '' }}">
                        <textarea name="faq[{{ $index }}][answer]" class="w-full border-gray-300" placeholder="Odpowiedź">{{ $faq['answer'] ?? '' }}</textarea>
                        <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-full bg-white border border-gray-300 absolute top-2 right-2 text-sm hover:border-red-600">🗑️</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addFaq()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">➕ Dodaj FAQ</button>
            <x-form.submit label="Edytuj FAQ"/>
            <input type="hidden" id="faq-counter" value="{{ count($faqs) }}">

        </form>


        <script>
            function addFaq() {
                let index = parseInt(document.getElementById('faq-counter').value);
                const wrapper = document.getElementById('faq-wrapper');

                const div = document.createElement('div');
                div.classList.add('faq-item', 'border', 'rounded', 'p-4', 'mb-3', 'relative');
                div.innerHTML = `
            <input type="text" name="faq[${index}][question]" class="w-full mb-2 border-gray-300" placeholder="Pytanie">
            <textarea name="faq[${index}][answer]" class="w-full border-gray-300" placeholder="Odpowiedź"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-full bg-white border border-gray-300 absolute top-2 right-2  text-sm hover:border-red-600">🗑️</button>
        `;

                wrapper.appendChild(div);
                document.getElementById('faq-counter').value = index + 1;
            }
        </script>

</div>
</x-layout-panel>
