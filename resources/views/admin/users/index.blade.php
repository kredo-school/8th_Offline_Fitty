@extends('layouts.admin')

@section('content')
    <div class="container my-5 admin-users">
        <div class="d-flex justify-content-between align-items-center mb-3 admin-users-header">
            <h1 class="text-success admin-users-title">
                Users <span class="text-muted">({{ $users->total() }})</span>
            </h1>
            <div class="admin-users-search-box">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control admin-users-search-input"
                            placeholder="Search" value="{{ request('search') }}">
                        <button class="btn admin-users-search-btn" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive admin-users-table-container">
            <table class="table table-hover align-middle admin-users-table">
                <thead class="table-light">
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
                            <td><a href="#" class="admin-users-id-link">{{ $user->id }}</a></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->created_at->format('m/d/Y') }}</td>
                            <td>
                                @if ($user->is_active)
                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span> Active
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <span class="status-dot"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="admin-users-action-button">
                                    <span class="material-symbols-outlined">person</span>
                                </a>
                                <a href="#" class="admin-users-action-button" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center admin-users-pagination">
            <p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users</p>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- モーダルウィンドウ -->
    @foreach ($users as $user)
        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="material-symbols-outlined modal-icon">delete</span>
                        <h5 class="modal-title" id="deleteModalLabel-{{ $user->id }}">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
