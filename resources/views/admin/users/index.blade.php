@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')
    <div class="row main-row">
        @include('sidebar.admin-sidebar')

        <div class="col-md-9 ms-sm-auto col-lg-10 admin-users">
    <div class="mx-auto" style="width: 80%;">
        <!-- Main Content -->

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-3 admin-users-header">
            <h1 class="admin-users-title">
                Users <span class="text-muted">({{ $user_profiles->total() }})</span>
            </h1>

            <!-- Search Box -->
            <div class="admin-users-search-box">
                <form action="{{ route('admin.users.index') }}" method="GET" class="w-100">
                    <div class="input-group admin-users-input-group ">
                        <input type="text" name="search" class="form-control admin-users-search-input"
                               placeholder="Search" value="{{ old('search', $search) }}">
                        <button class="btn admin-users-search-btn" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        @if($user_profiles->isEmpty())
            <p class="text-muted">No users found for "{{ $search }}"</p>
        @else
            <table class="table table-hover align-middle admin-users-table">
                <thead class="admin-users-table-head">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_profiles as $user_profile)
                        <tr class="admin-users-row">
                            <td><a href="#" class="admin-users-id-link">{{ $user_profile->id }}</a></td>
                            <td>{{ $user_profile->first_name }} {{ $user_profile->last_name }}</td>
                            <td>{{ $user_profile->created_at->format('m/d/Y') }}</td>
                            <td>
                                <a href="{{ route('user.profile', ['id' => $user_profile->user_id]) }}" class="admin-users-action-button">
                                    <span class="material-symbols-outlined">person</span>
                                </a>
                                <a href="#" class="admin-users-action-button" data-bs-toggle="modal"
                                   data-bs-target="#deleteModal-{{ $user_profile->id }}">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Pagination -->
        <div class="mt-4">
            {{ $user_profiles->links('admin.pagination') }}
        </div>
    </div>
</div>

    </div>

    <!-- Delete Confirmation Modals -->
    @foreach ($user_profiles as $user_profile)
        <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $user_profile->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $user_profile->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                <div class="modal-content admin-users-modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header admin-users-modal-header pb-2">
                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                        <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $user_profile->id }}">Delete User</h5>
                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-users-modal-body">
                        <p>Are you sure you want to delete the user?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-users-modal-footer">
                        <button type="button" class="btn cancel-btn admin-users-cancel-btn admin-btn-equal" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.users.destroy', $user_profile->user_id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn admin-users-delete-btn admin-btn-equal">Delete</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

@endsection
