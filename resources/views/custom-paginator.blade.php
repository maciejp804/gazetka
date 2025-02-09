@if ($paginator->hasPages())
    <div class="custom-pagination flex items-center justify-between p-4">

        {{-- Link do poprzedniej strony --}}
        @if ($paginator->onFirstPage())
            <button class="px-4 py-2 bg-gray-200 text-gray-500 cursor-not-allowed" disabled>
                Poprzednia
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300">
                Poprzednia
            </a>
        @endif

        {{-- Informacja o aktualnej stronie --}}
        <span class="mx-2">
            Strona {{ $paginator->currentPage() }} z {{ $paginator->lastPage() }}
        </span>

        {{-- Link do następnej strony --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300">
                Następna
            </a>
        @else
            <button class="px-4 py-2 bg-gray-200 text-gray-500 cursor-not-allowed" disabled>
                Następna
            </button>
        @endif

    </div>
@elseif($paginator->total() > 0)
    <div class="custom-pagination flex items-center justify-center p-4">
        <span class="text-sm text-gray-700">Koniec</span>
    </div>
@endif
