<x-layout-panel>
    <script src="https://cdn.tiny.cloud/1/yoiahkectrgcscxeo2bgr5il7l3eyii3yfp4v7zkvpuiu70h/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>



    <div class="min-h-full">
        <x-admin.header-back/>
        <header class="bg-white shadow mb-6">
            <div class="flex justify-between mx-auto max-w-7xl">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Produkty</h1>
                </div>
                <div class="flex items-center w-1/3">
                    <input type="text" id="search-products" placeholder="Szukaj produktu..."
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
            <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
                <form action="{{route('admin.blogs.add')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}"/>
                    <x-form.input name="meta_title" label="Meta tytuł" />
                    <x-form.input name="meta_description" label="Meta opis" />
                    <x-form.input name="title" label="Tytuł" />
                    <x-form.input name="slug" label="Slug" />
                    <x-form.select
                        name="category_id"
                        label="Kategoria"
                        :options="$categories->pluck('name', 'id')"
                        :selected="old('category_id')"
                    />
                    <x-form.input type="datetime-local" name="published_at" label="Opublikowany od:" />
                    <div class="my-4">
                        <x-form.input type="file" name="image" label="Okładka" />
                    </div>
                    <x-form.select
                        name="status"
                        label="Status"
                        :options="[
        'published' => 'Aktywny',
        'archive' => 'Archiwum',
        'draft' => 'Szkic',
    ]"
                        :selected="old('status')"
                    />

                    <x-form.textarea type="textarea" name="excerpt" label="Wstęp" :value="old('excerpt')" maxlength="1000"/>
                    <x-form.textarea type="textarea" name="body" rows="20" label="Artykuł" :value="old('body')"  maxlength="20000"/>


                    <x-form.submit label="Dodaj gazetkę"/>
                </form>
            </div>
        </main>
    </div>
</x-layout-panel>
