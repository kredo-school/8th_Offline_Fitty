@extends('layouts.app')

@section('title', 'Admin Categories')

@section('content')
@include('sidebar.humburger')

<div class="bg-light d-flex vh-100 admin-nutritionists">
    <div class="row w-100">
        @include('sidebar.user-sidebar')

        <div class="col-md-9 ms-sm-auto col-lg-10">
            <div class="admin-categories-container">
                <div class="admin-categories-content-wrapper">
                    <!-- Header Section -->
                    <div class="admin-categories-header-section">
                        <h1 class="admin-categories-title">Categories</h1>
                        <button class="admin-categories-add-button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <span class="material-icons-outlined admin-categories-add-icon">add_circle</span>
                            <span>Add</span>
                        </button>
                    </div>

                    <!-- Category List -->
                    <!-- Subcategories (Accordion) -->
<div id="subcategory-{{ $category->id }}" class="collapse admin-categories-sublist">
    @foreach ($category->children as $child)
        <div class="admin-categories-subitem">
            <span class="admin-categories-subcategory-name">{{ $child->name }}</span>
            <div class="admin-categories-action-buttons">
                <!-- Edit Button -->
                <button class="btn admin-categories-edit-btn" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $child->id }}">
                    <span class="material-icons-outlined admin-categories-edit-icon">edit</span>
                </button>
                <!-- Delete Button -->
                <button class="btn admin-categories-delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $child->id }}">
                    <span class="material-icons-outlined admin-categories-delete-icon">delete</span>
                </button>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $child->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $child->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                <div class="modal-content admin-users-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-users-modal-header">
                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                        <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $child->id }}">Delete Subcategory</h5>
                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-users-modal-body">
                        <p>Are you sure you want to delete the subcategory "{{ $child->name }}"?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-users-modal-footer">
                        <button type="button" class="btn cancel-btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn admin-users-delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

            </div>

            <!-- Add Category Modal -->
            <div class="modal fade admin-categories-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered admin-categories-modal-dialog">
                    <div class="modal-content admin-categories-modal-content">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="modal-header admin-categories-modal-header border-0">
                                <h5 class="modal-title admin-categories-modal-title" id="addCategoryModalLabel">Add Category</h5>
                                <button type="button" class="btn-close admin-categories-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <hr class="admin-categories-modal-divider">
                            <div class="modal-body admin-categories-modal-body">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label admin-categories-form-label">Category Name</label>
                                    <input type="text" name="name" id="categoryName" class="form-control admin-categories-form-input" placeholder="Enter category name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="parentCategory" class="form-label admin-categories-form-label">Main Category</label>
                                    <select name="parent_id" id="parentCategory" class="form-select admin-categories-form-select">
                                        <option value="" disabled selected>Select main category</option>
                                        @foreach ($mainCategories as $mainCategory)
                                            <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer admin-categories-modal-footer">
                                <button type="button" class="btn admin-categories-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn admin-categories-submit-btn">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Category Modals -->
            @foreach ($categories as $category)
                @foreach ($category->children as $child)
                    <div class="modal fade admin-categories-modal" id="editCategoryModal-{{ $child->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel-{{ $child->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered admin-categories-modal-dialog">
                            <div class="modal-content admin-categories-modal-content">
                                <form action="{{ route('admin.categories.update', $child->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header admin-categories-modal-header border-0">
                                        <h5 class="modal-title admin-categories-modal-title" id="editCategoryModalLabel-{{ $child->id }}">Edit Category</h5>
                                        <button type="button" class="btn-close admin-categories-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <hr class="admin-categories-modal-divider">
                                    <div class="modal-body admin-categories-modal-body">
                                        <div class="mb-3">
                                            <label for="editCategoryName-{{ $child->id }}" class="form-label admin-categories-form-label">Category Name</label>
                                            <input type="text" name="name" id="editCategoryName-{{ $child->id }}" class="form-control admin-categories-form-input" value="{{ $child->name }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer admin-categories-modal-footer">
                                        <button type="button" class="btn admin-categories-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn admin-categories-submit-btn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryRows = document.querySelectorAll('.admin-categories-row');

        categoryRows.forEach(row => {
            row.addEventListener('click', function (event) {
                event.preventDefault(); // デフォルトの挙動を防ぐ（Bootstrapのデフォルト挙動と競合を避ける）

                const icon = this.querySelector('.admin-categories-toggle-icon');
                const targetId = this.getAttribute('data-bs-target');
                const target = document.querySelector(targetId);

                // アコーディオンを閉じたり開いたりする
                if (target.classList.contains('show')) {
                    target.classList.remove('show'); // 閉じる
                    icon.classList.remove('open');  // アイコンの回転を元に戻す
                } else {
                    target.classList.add('show');  // 開く
                    icon.classList.add('open');    // アイコンを回転
                }
            });
        });
    });
</script>

@endsection
