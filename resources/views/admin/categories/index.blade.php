@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')
<div class="mb-3">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex">
        @csrf
        <input type="text" name="name" class="form-control me-2" placeholder="Add a category" required>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-plus">Add</i> 
        </button>
    </form>
</div>

<table class="table table-hover align-middle bg-white border text-secondary">
    <thead class="small table-warning fw-bold">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>COUNT</th>
            <th>LAST UPDATED</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>@if (strtolower($category->name) !== 'uncategorized')
                    {{ $category->id }}
                @endif</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->posts_count }}</td>
                <td>
                    @if ($category->updated_at)
                        {{ $category->updated_at->format('Y-m-d H:i') }}
                    @endif
                </td>
                <td class="text-center">
                    @if (strtolower($category->name) !== 'uncategorized')
                        <!-- Edit -->
                        <button class="btn btn-sm text-warning btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#edit-category-{{ $category->id }}">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        <!-- Delete -->
                        <button class="btn btn-sm text-danger btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#delete-category-{{ $category->id }}">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>

                        {{-- Modals --}}
                        @include('admin.categories.modal.edit', ['category' => $category])
                        @include('admin.categories.modal.delete', ['category' => $category])
                    @else
                        <span class="text-muted"></span>
                    @endif


                    {{-- Modals --}}
                    @include('admin.categories.modal.edit', ['category' => $category])
                    @include('admin.categories.modal.delete', ['category' => $category])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $categories->links() }}
@endsection
