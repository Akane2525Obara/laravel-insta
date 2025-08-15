
@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary fw-bold">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    {{-- ID --}}
                    <td>{{ $post->id }}</td>
                    {{-- PHOTO --}}
                    <td>
                        @if ($post->image)
                        <a href="{{ route('post.show', $post->id) }}">
                            <img src="{{ $post->image }}" alt="Post Image" 
                                class="d-block mx-auto" style="width:80px; height:80px; object-fit:cover;">
                        </a>
                        @else
                            <i class="fa-solid fa-image text-secondary d-block text-center" style="font-size:40px;"></i>
                        @endif
                    </td>

                    {{-- CATEGORY --}}
                    <td>
                       @if($post->categories->isNotEmpty())
                            {{ $post->categories->pluck('name')->join(', ') }}
                        @else
                            <span class="text-muted">Uncategorized</span>
                        @endif
                    </td>

                    {{-- OWNER --}}
                    <td>
                       <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">
                            {{ $post->user->name }}
                        </a>
                    </td>

                    {{-- CREATED AT --}}
                    <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>

                    {{-- STATUS --}}
                    <td>
                        @if ($post->trashed())
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#unhide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye"></i> Unhide Post
                                    </button>
                                @else
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#hide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post
                                    </button>
                                @endif
                            </div>
                        </div>
                        {{-- modal --}}
                        @include('admin.posts.modal.status')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $all_posts->links() }}
@endsection
