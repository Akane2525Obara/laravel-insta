{{-- @extends('layouts.app')
@section('title','Story')

@section('content') --}}
  {{-- 画面全体の簡易モーダル（最小） --}}
  {{-- <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
       style="background: rgba(0,0,0,.85); z-index:1050;">
    <div class="bg-dark text-white rounded-3 p-2" style="max-width: 720px; width: 98%;">
      <div class="d-flex align-items-center gap-2 mb-2">
        <img src="{{ $story->user->avatar ?? 'https://placehold.co/32x32?text=U' }}" class="rounded-circle" width="32" height="32" alt="">
        <strong>{{ $story->user->name }}</strong>
        <small class="text-secondary">{{ $story->expires_at->diffForHumans() }}</small> --}}

        {{-- Close は「戻れるなら戻る、無ければホームへ」 --}}
        {{-- <button id="closeBtn" class="ms-auto btn btn-sm btn-light">Close</button>
      </div>

      <div class="text-center">
        <img src="{{ asset('storage/'.$story->image_path) }}"
             class="img-fluid rounded mb-2"
             style="max-height:80vh; object-fit:contain;" alt="">
        @if($story->caption)
          <div class="small text-secondary">{{ $story->caption }}</div>
        @endif
      </div>
    </div>
  </div>

  <script>
    const backOrHome = () => {
      if (window.history.length > 1) {
        // 直リンクなどでリダイレクトチェーンがある場合も考慮して try
        try { history.back(); } catch(e) { location.href = "{{ route('index') }}"; }
        // まれに戻れないケース
        setTimeout(() => { if (document.visibilityState === 'visible') location.href = "{{ route('index') }}"; }, 150);
      } else {
        location.href = "{{ route('index') }}";
      }
    };
    document.getElementById('closeBtn').addEventListener('click', backOrHome);
    // Escキーでも閉じる
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') backOrHome(); });
  </script>
@endsection --}}


