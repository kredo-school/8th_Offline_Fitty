@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="bg-light d-flex vh-100 admin-users">
        <div class="row w-100">
            @include('sidebar.user-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <!-- Main Content -->
                <div class="container my-5 admin-users">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3 admin-users-header">
                        <h1 class="text-success admin-users-title">
                            Users <span class="text-muted">({{ $users->total() }})</span>
                        </h1>

                        <!-- Search Box -->
                        <div class="admin-users-search-box">
                            <form action="{{ route('admin.users.index') }}" method="GET">
                                <div class="input-group admin-users-input-group">
                                    <input type="text" name="search" class="form-control admin-users-search-input"
                                           placeholder="Search" value="{{ request('search') }}">
                                    <button class="btn admin-users-search-btn" type="submit">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive admin-users-table-container">
                        <table class="table table-hover align-middle admin-users-table">
                            <thead class="table-light admin-users-table-head">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Registration Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="admin-users-row">
                                        <!-- ID -->
                                        <td>
                                            <a href="#" class="admin-users-id-link">{{ $user->id }}</a>
                                        </td>

                                        <!-- Name -->
                                        <td>{{ $user->name }}</td>

                                        <!-- Registration Date -->
                                        <td>{{ $user->created_at->format('m/d/Y') }}</td>

                                        <!-- Status -->
                                        <td>
                                            @if ($user->is_active)
                                                <span class="status-badge status-active admin-users-status">
                                                    <span class="status-dot admin-users-status-dot"></span> Active
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive admin-users-status">
                                                    <span class="status-dot admin-users-status-dot"></span> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Action Buttons -->
                                        <td>
                                            <a href="#" class="admin-users-action-button">
                                                <span class="material-symbols-outlined">person</span>
                                            </a>
                                            <a href="#" class="admin-users-action-button" data-bs-toggle="modal"
                                               data-bs-target="#deleteModal-{{ $user->id }}">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center admin-users-pagination">
                        <p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</p>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($users as $user)
        <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $user->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                <div class="modal-content admin-users-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-users-modal-header">
                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                        <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $user->id }}">Delete User</h5>
                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-users-modal-body">
                        <p>Are you sure you want to delete the user?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-users-modal-footer">
                        <button type="button" class="btn cancel-btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn admin-users-delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
