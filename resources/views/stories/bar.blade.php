{{-- <div class="d-flex align-items-center gap-3 overflow-auto py-2 px-1" style="white-space:nowrap;">
  追加ボタン（画像選択で即投稿） --}}
  {{-- <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
    @csrf
    <label class="btn btn-sm btn-outline-primary mb-0" style="cursor:pointer;">
      <i class="fa-solid fa-plus"></i> Story
      <input type="file" name="image" accept="image/*" class="d-none" onchange="this.form.submit()" capture="environment">
    </label>
  </form>

  @forelse ($stories->unique('user_id') as $s)
    <a href="{{ route('stories.show',$s) }}" class="text-decoration-none text-dark" title="{{ $s->user->name }}">
      <div class="text-center">
        <img src="{{ $s->user->avatar ?? 'https://placehold.co/60x60?text=U' }}"
             class="rounded-circle" width="60" height="60"
             style="object-fit:cover; border:3px solid #ff3b30;"
             loading="lazy" alt="{{ $s->user->name }}'s story">
        <small class="d-block text-truncate" style="max-width:60px">{{ $s->user->name }}</small>
      </div>
    </a>
  @empty
    <span class="text-muted small ps-2">No stories yet</span>
  @endforelse
</div>
<hr class="my-3"> --}}
