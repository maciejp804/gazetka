@props([
    'label',
    'name',
    'value' => '',
    'required' => false,
    'rows' => 8,
    'maxlength' => 500, // domyślna maksymalna liczba znaków
])

@if ($name == 'body')
    <div class="mb-4" >
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>

        <textarea
            rows="{{ $rows }}"
            name="{{ $name }}"
            id="{{ $name }}"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
            @if($required) required @endif
    >{{ old($name, $value) }}</textarea>

    </div>

    <script>

        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/panel/blogs/tiny/upload-image');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            xhr.send(formData);
        });


        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: '#body',
                plugins: "powerpaste a11ychecker linkchecker wordcount table advtable editimage autosave advlist anchor advcode image link lists media mediaembed searchreplace visualblocks mergetags",
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | outdent indent | link image ',
                height: 700,
                menubar: true,
                branding: false, // Ukrycie logo TinyMCE
                content_css: 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_handler: example_image_upload_handler,
                // Opcjonalnie: Wczytanie wtyczek lokalnie
                external_plugins: {
                    'hr': 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/plugins/hr/plugin.min.js',
                    'print': 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/plugins/print/plugin.min.js'
                }
            });
        });
    </script>


@else
    <div class="mb-4" x-data="{ content: '{{ old($name, $value) }}' }">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>

        <textarea
            rows="{{ $rows }}"
            name="{{ $name }}"
            id="{{ $name }}"
            x-model="content"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
            @if($required) required @endif
    >{{ old($name, $value) }}</textarea>

        <div class="text-sm text-right text-gray-500 mt-1 h-7">
            <span x-text="content.length + ' / {{$maxlength}} znaków'"></span>
        </div>
    </div>
@endif





