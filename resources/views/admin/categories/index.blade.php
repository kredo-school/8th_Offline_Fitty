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
                    <div class="accordion admin-categories-accordion" id="categoriesAccordion">
                        @foreach ($categories as $category)
                            <div class="accordion-item admin-categories-accordion-item">
                                <h2 class="accordion-header admin-categories-accordion-header" id="heading-{{ $category->id }}">
                                    <button class="accordion-button admin-categories-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->id }}" aria-expanded="false" aria-controls="collapse-{{ $category->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="admin-categories-item-name" style="font-size: 20px;">{{ $category->name }}</span>
                                            <span class="admin-categories-toggle-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00804F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" fill="none"></circle>
                                                    <polyline points="8 10 12 14 16 10" class="icon-chevron-down"></polyline>
                                                    <polyline points="8 14 12 10 16 14" class="icon-chevron-up" style="display: none;"></polyline>
                                                </svg>
                                            </span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $category->id }}" class="accordion-collapse collapse admin-categories-accordion-collapse" aria-labelledby="heading-{{ $category->id }}" data-bs-parent="#categoriesAccordion">
                                    <div class="accordion-body admin-categories-accordion-body">
                                        @foreach ($category->subcategory as $subcategory)
                                            <div class="admin-categories-subitem d-flex justify-content-between align-items-center">
                                                <span class="admin-categories-subcategory-name">{{ $subcategory->name }}</span>
                                                <div class="admin-categories-action-buttons">
                                                    <!-- Edit Button -->
                                                    <button class="btn admin-categories-edit-btn" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $subcategory->id }}">
                                                        <span class="material-icons-outlined admin-categories-edit-icon">edit</span>
                                                    </button>
                                                    <!-- Delete Button -->
                                                    <button class="btn admin-categories-delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $subcategory->id }}">
                                                        <span class="material-icons-outlined admin-categories-delete-icon">delete</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $subcategory->id }}" tabindex="-1"
                                                 aria-labelledby="deleteModalLabel-{{ $subcategory->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                                                    <div class="modal-content admin-users-modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header admin-users-modal-header">
                                                            <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                                                            <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $subcategory->id }}">Delete Subcategory</h5>
                                                            <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body admin-users-modal-body">
                                                            <p>Are you sure you want to delete the subcategory "{{ $subcategory->name }}"?</p>
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer admin-users-modal-footer">
                                                            <button type="button" class="btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.categories.destroy', $subcategory->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn admin-users-delete-btn">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <!-- Add Category Modal -->
                    <div class="modal fade admin-users-delete-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                            <div class="modal-content admin-users-modal-content">
                                <form action="{{ route('admin.categories.store') }}" method="POST">
                                    @csrf
                                    <!-- Modal Header -->
                                    <div class="modal-header admin-users-modal-header border-0">
                                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">add_circle</span>
                                        <h5 class="modal-title admin-users-modal-title" id="addCategoryModalLabel">Add Category</h5>
                                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body admin-users-modal-body">
                                        <div class="mb-3">
                                            <label for="categoryName" class="form-label admin-categories-form-label">Sub Category</label>
                                            <input type="text" name="name" id="categoryName" class="form-control admin-categories-form-input" placeholder="Enter category name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parentCategory" class="form-label admin-categories-form-label">Main Category</label>
                                            <select name="category_id" id="parentCategory" class="form-select admin-categories-form-select">
                                                <option value="" disabled selected>Select main category</option>
                                                @foreach ($categories as $mainCategory)
                                                    <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer admin-users-modal-footer">
                                        <button type="button" class="btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn admin-users-delete-btn">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Category Modals -->
                    @foreach ($categories as $category)
                        @foreach ($category->subcategory as $subcategory)
                            <div class="modal fade admin-users-delete-modal" id="editCategoryModal-{{ $subcategory->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel-{{ $subcategory->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                                    <div class="modal-content admin-users-modal-content">
                                        <form action="{{ route('admin.categories.update', $subcategory->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- Modal Header -->
                                            <div class="modal-header admin-users-modal-header border-0">
                                                <span class="material-symbols-outlined modal-icon admin-users-modal-icon">edit</span>
                                                <h5 class="modal-title admin-users-modal-title" id="editCategoryModalLabel-{{ $subcategory->id }}">Edit Subcategory</h5>
                                                <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="modal-body admin-users-modal-body">
                                                <div class="mb-3">
                                                    <label for="editCategoryName-{{ $subcategory->id }}" class="form-label admin-categories-form-label">Category Name</label>
                                                    <input type="text" name="name" id="editCategoryName-{{ $subcategory->id }}" class="form-control admin-categories-form-input" value="{{ $subcategory->name }}" required>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer admin-users-modal-footer">
                                                <button type="button" class="btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn admin-users-delete-btn">Save</button>
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
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleIcons = document.querySelectorAll('.admin-categories-toggle-icon .accordion-icon');

        toggleIcons.forEach(icon => {
            const chevronDown = icon.querySelector('.icon-chevron-down');
            const chevronUp = icon.querySelector('.icon-chevron-up');

            icon.closest('.accordion-button').addEventListener('click', function () {
                const isCollapsed = this.classList.contains('collapsed');

                if (isCollapsed) {
                    chevronDown.style.display = 'block';
                    chevronUp.style.display = 'none';
                } else {
                    chevronDown.style.display = 'none';
                    chevronUp.style.display = 'block';
                }
            });
        });
    });
</script>

@endsection
