{{-- <div> --}}
{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
{{-- </div> --}}

<span class="d-inline-flex align-items-center gap-1">
    @if (!$isLoggedIn)
        <a href="{{ route('login') }}" class="text-muted small">ログインして「いいね」</a>
    @else
        <button wire:click="toggle" wire:loading.attr="disabled" class="btn btn-sm shadow-none p-0"
            aria-label="like button">
            @if ($liked)
                <i class="fa-solid fa-heart text-danger"></i>
            @else
                <i class="fa-regular fa-heart"></i>
            @endif
        </button>
        <span>{{ $count }}</span>
    @endif
</span>
