@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')
        <div class="row row-main w-100">
            @include('sidebar.admin-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10 admin-inquiries">
                <!-- Main Content -->
                <div class="container my-5 mx-1 admin-inquiries">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3 admin-inquiries-header">
                        <h1 class="admin-inquiries-title">
                            Inquiries <span class="text-muted">({{ $inquiries->total() }})</span>
                        </h1>

                        <!-- Search Box -->
                        <div class="admin-inquiries-search-box">
                            <form action="{{ route('admin.inquiries.index') }}" method="GET">
                                <div class="input-group admin-inquiries-input-group">
                                    <input type="text" name="search" class="form-control admin-inquiries-search-input"
                                           placeholder="Search" value="{{ old('search', $search) }}">
                                    <button class="btn admin-inquiries-search-btn" type="submit">
                                        <span class="material-symbols-outlined">search</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Inquiries Table -->
                    @if($inquiries->isEmpty())
                        <p class="text-muted">No inquiries found for "{{ $search }}"</p>
                    @else
                        <table class="table table-hover align-middle admin-inquiries-table">
                            <thead class="admin-inquiries-table-head">
                                <tr>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Person in Charge</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquiries as $inquiry)
                                    <tr class="admin-inquiries-row {{ $inquiry->status === 'In Progress' ? 'table-warning' : ($inquiry->status === 'Unresolved' ? 'table-danger' : '') }}">
                                        <td>{{ $inquiry->category }}</td>
                                        <td>{{ $inquiry->name }}</td>
                                        <td>{{ optional($inquiry->created_at)->format('m/d/y') ?? 'N/A' }}</td>
                                        <td>
                                            @if ($inquiry->status === 'completed')
                                                <span class="status-badge badge-completed">Completed</span>
                                            @elseif ($inquiry->status === 'in_progress')
                                                <span class="status-badge badge-in-progress">In Progress</span>
                                            @else
                                                <span class="status-badge badge-pending">Pending</span>
                                            @endif
                                        </td>                                       
                                        <td>{{ $inquiry->person_in_charge }}</td>
                                        <td>
                                            <div class="d-flex gap-3">
                                                <a href="{{ route('user.profile', ['id' => $inquiry->id]) }}" class="admin-inquiries-action-button">
                                                    <span class="material-symbols-outlined">person</span>
                                                </a>
                                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="admin-inquiries-action-button">
                                                    <span class="material-symbols-outlined">mail</span>
                                                </a>
                                                <a href="#" class="admin-inquiries-action-button" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inquiry->id }}">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </a>
                                            </div>
                                            
                                        </td>
                                        
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $inquiries->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>


    <!-- Delete Confirmation Modal -->
    @foreach ($inquiries as $inquiry)
        <div class="modal fade admin-users-delete-modal" id="deleteModal-{{ $inquiry->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $inquiry->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-users-modal-dialog">
                <div class="modal-content admin-users-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-users-modal-header pb-2">
                        <span class="material-symbols-outlined modal-icon admin-users-modal-icon">delete</span>
                        <h5 class="modal-title admin-users-modal-title" id="deleteModalLabel-{{ $inquiry->id }}">Delete Inquiry</h5>
                        <button type="button" class="btn-close admin-users-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-users-modal-body">
                        <p>Are you sure you want to delete this inquiry?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-users-modal-footer">
                        <button type="button" class="btn cancel-btn admin-users-cancel-btn admin-btn-equal" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
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
