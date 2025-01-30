@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="d-flex admin-users">
        <div class="row w-100">
            @include('sidebar.admin-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <!-- Main Content -->
                <div class="container my-5 mx-1 admin-users">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3 admin-users-header">
                        <h1 class="admin-users-title">
                            Nutritionists <span class="text-muted">({{ $nutritionists_profiles->total() }})</span>
                        </h1>

                        <!-- Search Box -->
                        <div class="d-flex align-items-center">
                            <form action="{{ route('admin.nutritionists.index') }}" method="GET" class="d-flex me-3">
                                <div class="input-group admin-users-input-group">
                                    <input type="text" name="search" class="form-control admin-users-search-input"
                                           placeholder="Search" value="{{ request('search') }}">
                                    <button class="btn admin-users-search-btn" type="submit">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                </div>
                            </form>

                            <!-- Add Button -->
                            <a href="{{ route('admin.nutritionists.create') }}" class="admin-nutritionists-add-button">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>

                    <!-- Nutritionists Table -->
                    @if($nutritionists_profiles->isEmpty())
                        <p class="text-muted">No nutritionists found for "{{ request('search') }}"</p>
                    @else
                        <table class="table table-hover align-middle admin-users-table">
                            <thead class="admin-users-table-head">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nutritionists_profiles as $nutritionist_profile)
                                    <tr class="admin-users-row">
                                        <td><a href="#" class="admin-users-id-link">{{ $nutritionist_profile->id }}</a></td>
                                        <td>{{ $nutritionist_profile->first_name }} {{ $nutritionist_profile->last_name }}</td>
                                        <td>{{ $nutritionist_profile->last_login ? $nutritionist_profile->last_login->format('m/d/Y') : 'N/A' }}</td>
                                        <td>
                                            @if ($nutritionist_profile->is_active)
                                                <span class="status-badge status-active admin-users-status">
                                                    <span class="status-dot admin-users-status-dot"></span> Active
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive admin-users-status">
                                                    <span class="status-dot admin-users-status-dot"></span> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href={{ route('nutri.profile', ['id' => $nutri_profile->$nutri_id]) }} class="admin-users-action-button">
                                                <span class="material-symbols-outlined">person</span>
                                            </a>
                                            <a href="#" class="admin-users-action-button" data-bs-toggle="modal"
                                               data-bs-target="#deleteModal-{{ $nutritionist_profile->id }}">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $nutritionists_profiles->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($nutritionists_profiles as $nutritionist_profile)
        <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $nutritionist_profile->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $nutritionist_profile->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                <div class="modal-content admin-users-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-users-modal-header">
                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                        <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $nutritionist_profile->id }}">Delete Nutritionist</h5>
                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-users-modal-body">
                        <p>Are you sure you want to delete this nutritionist?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-users-modal-footer">
                        <button type="button" class="btn cancel-btn admin-users-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.nutritionists.destroy', $nutritionist_profile->id) }}" method="POST" style="display: inline;">
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
