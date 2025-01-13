@extends('layouts.app')

@section('title', 'Admin Categories')

@section('content')

<body class="bg-light">
    <div class="container my-5 admin-home">
        <div class="d-flex justify-content-between align-items-center mb-3 px-1">
            <h1 class="text-success">Categories</h1>
            <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+
                Add</button>
        </div>

        <div class="list-group">
            @foreach ($categories as $category)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $category->name }}</span>
                        <div>
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal-{{ $category->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if ($category->children->isNotEmpty())
                        <div class="ms-3 mt-2">
                            @foreach ($category->children as $child)
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>{{ $child->name }}</span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal-{{ $child->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $child->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-success" id="addCategoryModalLabel">
                            <span class="material-icons">add</span> Add Category
                        </h5>
                    </div>
                    <hr class="green-line">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subCategoryName" class="form-label">Sub Categories</label>
                            <input type="text" name="name" id="subCategoryName" class="form-control"
                                placeholder="Enter subcategory name" required>
                        </div>
                        <div class="mb-3">
                            <label for="mainCategory" class="form-label">Main Categories</label>
                            <select name="parent_id" id="mainCategory" class="form-select">
                                <option value="" disabled selected>Select main category</option>
                                @foreach ($categories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-warning me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-white">Add</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

{{-- </html> --}}
@endsection