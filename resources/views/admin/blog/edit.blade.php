<x-layout-panel>
    <script src="https://cdn.tiny.cloud/1/yoiahkectrgcscxeo2bgr5il7l3eyii3yfp4v7zkvpuiu70h/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="min-h-full py-4">
        <x-admin.header-back/>
        <header class="bg-white shadow mb-6">
            <div class="flex justify-between mx-auto max-w-7xl">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{$blog->title}}</h1>
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
                <form action="{{route('admin.blogs.update', ['slug' => $blog->slug])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{$blog->user_id}}"/>
                    <x-form.input name="meta_title" label="Meta tytuł" :value="old('meta_title', $blog->meta_title)"/>
                    <x-form.input name="meta_description" label="Meta opis" :value="old('meta_description', $blog->meta_description)"/>
                    <x-form.input name="title" label="Tytuł" :value="old('title', $blog->title)"/>
                    <x-form.input name="slug" label="Slug" :value="old('slug', $blog->slug)"/>
                    <x-form.select
                        name="category_id"
                        label="Kategoria"
                        :options="$categories->pluck('name', 'id')"
                        :selected="old('category_id', $blog->category_id)"
                    />
                    <x-form.input type="datetime-local" name="published_at" label="Opublikowany od:" :value="old('published_at', $blog->published_at)"/>

                    <x-form.select
                        name="status"
                        label="Status"
                        :options="[
        'published' => 'Aktywny',
        'archive' => 'Archiwum',
        'draft' => 'Szkic',
    ]"
                        :selected="old('status', $blog->status)"
                    />

                    <x-form.textarea type="textarea" name="excerpt" label="Wstęp" :value="old('excerpt', $blog->excerpt)" maxlength="1000"/>
                    <x-form.textarea type="textarea" name="body" rows="20" label="Artykuł" :value="old('body', $blog->body)"  maxlength="30000"/>


                    <x-form.submit label="Edytuj gazetkę"/>
                </form>
            </div>
        </main>
    </div>
</x-layout-panel>
