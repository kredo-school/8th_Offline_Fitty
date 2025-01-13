@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="bg-light d-flex vh-100 admin-nutritionists">
        <div class="row w-100">
            @include('sidebar.user-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <!-- Main Content -->
                <div class="container my-5 admin-nutritionists">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3 admin-nutritionists-header">
                        <h1 class="text-success admin-nutritionists-title">
                            Nutritionists <span class="text-muted">({{ $nutritionists->total() }})</span>
                        </h1>

                        <!-- Search Box -->
                        <div class="admin-nutritionists-search-box">
                            <form action="{{ route('admin.nutritionists.index') }}" method="GET">
                                <div class="input-group admin-nutritionists-input-group">
                                    <input type="text" name="search" class="form-control admin-nutritionists-search-input"
                                           placeholder="Search" value="{{ request('search') }}">
                                    <button class="btn admin-nutritionists-search-btn" type="submit">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Button -->
                        <a href="#" class="add-button">
                          <span class="material-symbols-outlined">add</span>
                          <span>Add</span>
                      </a>
                    </div>

                    <!-- Nutritionists Table -->
                    <div class="table-responsive admin-nutritionists-table-container">
                        <table class="table table-hover align-middle admin-nutritionists-table">
                            <thead class="table-light admin-nutritionists-table-head">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($nutritionists as $nutritionist)
                                    <tr class="admin-nutritionists-row">
                                        <!-- ID -->
                                        <td>
                                            <a href="#" class="admin-nutritionists-id-link">{{ $nutritionist->id }}</a>
                                        </td>

                                        <!-- Name -->
                                        <td>{{ $nutritionist->name }}</td>

                                        <!-- Last Login -->
                                        <td>{{ $nutritionist->last_login->format('m/d/Y') }}</td>

                                        <!-- Status -->
                                        <td>
                                            @if ($nutritionist->is_active)
                                                <span class="status-badge status-active admin-nutritionists-status">
                                                    <span class="status-dot admin-nutritionists-status-dot"></span> Active
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive admin-nutritionists-status">
                                                    <span class="status-dot admin-nutritionists-status-dot"></span> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Action Buttons -->
                                        <td>
                                            <a href="#" class="admin-nutritionists-action-button">
                                                <span class="material-symbols-outlined">person</span>
                                            </a>
                                            <a href="#" class="admin-nutritionists-action-button" data-bs-toggle="modal"
                                               data-bs-target="#deleteModal-{{ $nutritionist->id }}">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center admin-nutritionists-pagination">
                        <p>Showing {{ $nutritionists->firstItem() }} to {{ $nutritionists->lastItem() }} of {{ $nutritionists->total() }} nutritionists</p>
                        {{ $nutritionists->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($nutritionists as $nutritionist)
        <div class="modal fade admin-nutritionists-delete-modal" id="deleteModal-{{ $nutritionist->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $nutritionist->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-nutritionists-modal-dialog">
                <div class="modal-content admin-nutritionists-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-nutritionists-modal-header">
                        <span class="material-symbols-outlined modal-icon admin-nutritionists-modal-icon">delete</span>
                        <h5 class="modal-title admin-nutritionists-modal-title" id="deleteModalLabel-{{ $nutritionist->id }}">Delete Nutritionist</h5>
                        <button type="button" class="btn-close admin-nutritionists-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-nutritionists-modal-body">
                        <p>Are you sure you want to delete this nutritionist?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-nutritionists-modal-footer">
                        <button type="button" class="btn cancel-btn admin-nutritionists-cancel-btn" data-bs-dismiss="modal">Cancel</button>

                        <form action="{{ route('admin.nutritionists.destroy', $nutritionist->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn admin-nutritionists-delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
