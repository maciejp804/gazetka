<div>
    @if (session('success'))
        <div id="flash-message" class="absolute top-0 left-0 w-full bg-green-100 border-l-4 border-green-500 text-sm text-green-700 p-2 z-50">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-message" class="absolute top-0 left-0 w-full bg-red-100 border-l-4 border-red-500 text-sm text-red-700 p-2 z-50">
            <p>{{ session('error') }}</p>
        </div>
    @endif

        @if (session('update'))
            <div id="flash-message" class="absolute top-0 left-0 w-full bg-blue-100 border-l-4 border-blue-500 text-sm text-blue-700 p-2 z-50">
                <p>{{ session('update') }}</p>
            </div>
        @endif
</div>
