@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')
        <div class="row row-main w-100">
            @include('sidebar.include-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10 ">
                <!-- Main Content -->
                <div class="container admin-inquiries">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="admin-inquiries-title">
                            Inquiries <span class="text-muted text-small">({{ $inquiries->total() }})</span>
                        </h1>

                        
                        <div class="admin-users-search-box">
                            <form action="{{ route('admin.inquiries.index') }}" method="GET" class="w-100">
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
                                        <td>{{ optional($inquiry->created_at)->format('m/d/Y') ?? 'N/A' }}</td>
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
                                            <div class=" d-flex gap-3 admin-inquiries-action-button">
                                                <a href="{{ route('user.profile', $inquiry->user_id) }}" ">
                                                    <span class="material-symbols-outlined">person</span>
                                                </a>
                                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" ">
                                                    <span class="material-symbols-outlined">mail</span>
                                                </a>
                                                <a href="#" n " data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $inquiry->id }}">
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
                    <div class="mt-4" style="color: #333">
                        {{ $inquiries->appends(request()->query())->links('admin.pagination') }}
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
