@extends('layouts.app')

@section('title', 'Admin Categories')

@section('content')

@include('sidebar.humburger')

<div class="bg-light d-flex vh-100 admin-nutritionists">
    <div class="row w-100">
        @include('sidebar.admin-sidebar')

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
                                    <button 
                                        class="accordion-button custom-accordion-toggle {{ request('highlighted_category') == $category->id ? '' : 'collapsed' }}" 
                                        type="button" 
                                        aria-expanded="{{ request('highlighted_category') == $category->id ? 'true' : 'false' }}" 
                                        aria-controls="collapse-{{ $category->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span class="admin-categories-item-name" style="font-size: 20px;">{{ $category->name }}</span>
                                            <span class="admin-categories-toggle-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" fill="none"></circle>
                                                    <polyline points="8 10 12 14 16 10" class="icon-chevron-down"></polyline>
                                                    <polyline points="8 14 12 10 16 14" class="icon-chevron-up"></polyline>
                                                </svg>
                                            </span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $category->id }}" class="accordion-collapse collapse {{ request('highlighted_category') == $category->id ? 'show' : '' }}" aria-labelledby="heading-{{ $category->id }}" data-bs-parent="#categoriesAccordion">
                                    <div class="accordion-body admin-categories-accordion-body">
                                        @foreach ($category->subcategory as $subcategory)
                                            <div class="admin-categories-subitem d-flex justify-content-between align-items-center">
                                                <span class="admin-categories-subcategory-name">
                                                    {{ $subcategory->name }} ({{ $subcategory->requirement }} mg)
                                                </span>
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
                                                        <div class="modal-header admin-users-modal-header pb-2">
                                                            <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                                                            <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $subcategory->id }}">Delete Subcategory</h5>
                                                            <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body admin-users-modal-body">
                                                            <p>Are you sure you want to delete the subcategory "{{ $subcategory->name }}"?</p>
                                                        </div>
                                                        <div class="modal-footer admin-users-modal-footer">
                                                            <button type="button" class="btn admin-users-cancel-btn admin-btn-equal" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.categories.destroy', $subcategory->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn admin-users-delete-btn admin-btn-equal">Delete</button>
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
                                    <div class="modal-header admin-users-modal-header border-0 pb-2 px-4 my-">
                                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">add_circle</span>
                                        <h5 class="modal-title admin-users-modal-title" id="addCategoryModalLabel">Add Subcategory</h5>
                                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body admin-users-modal-body px-4">
                                        <div class="mb-3">
                                            <label for="categoryName" class="form-label admin-categories-form-label">Subcategory</label>
                                            <input type="text" name="name" id="categoryName" class="form-control admin-categories-form-input" placeholder="Enter subcategory name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="requirement" class="form-label admin-categories-form-label">Nutrient Requirement</label>
                                            <input type="number" step="0.01" name="requirement" id="requirement" class="form-control admin-categories-form-input" placeholder="Enter nutrient requirement" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parentCategory" class="form-label admin-categories-form-label">Maincategory</label>
                                            <select name="category_id" id="parentCategory" class="form-select admin-categories-form-select" required>
                                                <option value="" disabled selected>Select main category</option>
                                                @foreach ($categories as $mainCategory)
                                                    <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer admin-users-modal-footer px-4">
                                        <button type="button" class="btn admin-users-cancel-btn admin-btn-equal" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn admin-users-delete-btn admin-btn-equal">Add</button>
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
                                            @method('PATCH')
                                            <div class="modal-header admin-users-modal-header border-0 pb-2">
                                                <span class="material-symbols-outlined modal-icon admin-users-modal-icon">edit</span>
                                                <h5 class="modal-title admin-users-modal-title" id="editCategoryModalLabel-{{ $subcategory->id }}">Edit Subcategory</h5>
                                                <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body admin-users-modal-body">
                                                <div class="mb-3">
                                                    <label for="editCategoryName-{{ $subcategory->id }}" class="form-label admin-categories-form-label">Subcategory</label>
                                                    <input type="text" name="name" id="editCategoryName-{{ $subcategory->id }}" class="form-control admin-categories-form-input" value="{{ $subcategory->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editRequirement-{{ $subcategory->id }}" class="form-label admin-categories-form-label">Nutrient Requirement (mg)</label>
                                                    <input type="number" step="0.01" name="requirement" id="editRequirement-{{ $subcategory->id }}" class="form-control admin-categories-form-input" value="{{ $subcategory->requirement }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editParentCategory-{{ $subcategory->id }}" class="form-label admin-categories-form-label">Maincategory</label>
                                                    <select name="category_id" id="editParentCategory-{{ $subcategory->id }}" class="form-select admin-categories-form-select" required>
                                                        @foreach ($categories as $mainCategory)
                                                            <option value="{{ $mainCategory->id }}" {{ $subcategory->category_id == $mainCategory->id ? 'selected' : '' }}>
                                                                {{ $mainCategory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer admin-users-modal-footer">
                                                <button type="button" class="btn admin-users-cancel-btn admin-btn-equal" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn admin-users-delete-btn admin-btn-equal">Save</button>
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
    const accordionButtons = document.querySelectorAll('.custom-accordion-toggle');
    const footer = document.querySelector('footer'); // フッターを取得
    const mainContent = document.querySelector('.main-content'); // メインコンテンツ

    // フッター位置の更新関数
    function updateFooterPosition() {
        if (mainContent && footer) {
            const contentHeight = mainContent.scrollHeight;
            footer.style.marginTop = `${contentHeight - mainContent.offsetHeight}px`;
        }
    }

    accordionButtons.forEach(button => {
        const targetId = button.getAttribute('aria-controls');
        const target = document.getElementById(targetId);
        const chevronDown = button.querySelector('.icon-chevron-down');
        const chevronUp = button.querySelector('.icon-chevron-up');

        // 初期状態の設定
        function setInitialState() {
            if (target.classList.contains('show')) {
                chevronDown.style.display = 'none';
                chevronUp.style.display = 'block';
            } else {
                chevronDown.style.display = 'block';
                chevronUp.style.display = 'none';
            }
        }
        setInitialState();

        // クリックイベントで開閉を制御
        button.addEventListener('click', function () {
            const isOpen = target.classList.contains('show');

            // 全てのアコーディオンを閉じる（開いているものを閉じる）
            document.querySelectorAll('.accordion-collapse.show').forEach(collapse => {
                collapse.classList.remove('show');
                const previousButton = document.querySelector(`[aria-controls="${collapse.id}"]`);
                if (previousButton) {
                    previousButton.setAttribute('aria-expanded', 'false');
                }
            });

            // アイコンの状態をリセット
            document.querySelectorAll('.icon-chevron-down').forEach(icon => icon.style.display = 'block');
            document.querySelectorAll('.icon-chevron-up').forEach(icon => icon.style.display = 'none');

            if (isOpen) {
                // 既に開いている場合は閉じる
                target.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
                chevronDown.style.display = 'block';
                chevronUp.style.display = 'none';
            } else {
                // 開いていない場合は開く
                target.classList.add('show');
                button.setAttribute('aria-expanded', 'true');
                chevronDown.style.display = 'none';
                chevronUp.style.display = 'block';
            }

            // アニメーション後にフッターの位置を更新
            setTimeout(updateFooterPosition, 0); // アニメーション完了後に更新
        });
    });

    // 初期状態でフッター位置を調整
    updateFooterPosition();
});


</script>

@endsection
