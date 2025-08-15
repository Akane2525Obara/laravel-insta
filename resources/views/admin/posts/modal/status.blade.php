
@if($post->trashed())
    {{-- Unhide --}}
    <div class="modal fade" id="unhide-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-success">
                <div class="modal-header border-success">
                    <h3 class="h5 modal-title text-success">
                        <i class="fa-solid fa-eye"></i>Unhide
                    </h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to unhide this post?</p>
                    {{-- post image --}}
                    @if($post->image)
                        <img src="{{$post->image }}" 
                             alt="Post Image" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 200px; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-image fa-3x text-muted mb-3"></i>
                    @endif

                    {{-- post description --}}
                    <p class="mb-3 text-secondary">{{ $post->description }}</p>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.unhide', $post->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Unhide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Hide --}}
    <div class="modal fade" id="hide-post-{{ $post->id }}">
        <div class="modal-dialog">
            <div class="modal-content border-danger">
                <div class="modal-header border-danger">
                    <h3 class="h5 modal-title text-danger">
                        <i class="fa-solid fa-eye-slash"></i>Hide
                    </h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to hide this post?</p>
                    {{-- post image --}}
                    @if($post->image)
                        <img src="{{$post->image }}" 
                             alt="Post Image" 
                             class="img-fluid rounded mb-3" 
                             style="max-height: 200px; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-image fa-3x text-muted mb-3"></i>
                    @endif

                    {{-- post description --}}
                    <p class="mb-3 text-secondary">{{ $post->description }}</p>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.posts.hide', $post->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
