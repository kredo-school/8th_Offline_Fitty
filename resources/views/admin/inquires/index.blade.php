@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="d-flex admin-inquiries">
        <div class="row w-100">
            @include('sidebar.admin-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquiries as $inquiry)
                                    <tr class="admin-inquiries-row {{ $inquiry->status === 'In Progress' ? 'table-warning' : ($inquiry->status === 'Unresolved' ? 'table-danger' : '') }}">
                                        <td>{{ $inquiry->category }}</td>
                                        <td>{{ $inquiry->name }}</td>
                                        <td>{{ $inquiry->submission_date->format('Y/m/d') }}</td>
                                        <td>
                                            @if ($inquiry->status === 'Resolved')
                                                <span class="status-badge status-resolved admin-inquiries-status">
                                                    Resolved
                                                </span>
                                            @elseif ($inquiry->status === 'In Progress')
                                                <span class="status-badge status-in-progress admin-inquiries-status">
                                                    In Progress
                                                </span>
                                            @else
                                                <span class="status-badge status-unresolved admin-inquiries-status">
                                                    Unresolved
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="admin-inquiries-action-button">
                                                <span class="material-symbols-outlined">mail</span>
                                            </a>
                                            <a href="#" class="admin-inquiries-action-button" data-bs-toggle="modal"
                                               data-bs-target="#deleteModal-{{ $inquiry->id }}">
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
                        {{ $inquiries->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($inquiries as $inquiry)
        <div class="modal fade admin-inquiries-delete-modal" id="deleteModal-{{ $inquiry->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel-{{ $inquiry->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered admin-inquiries-modal-dialog">
                <div class="modal-content admin-inquiries-modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header admin-inquiries-modal-header">
                        <span class="material-symbols-outlined modal-icon admin-inquiries-modal-icon">delete</span>
                        <h5 class="modal-title admin-inquiries-modal-title" id="deleteModalLabel-{{ $inquiry->id }}">Delete Inquiry</h5>
                        <button type="button" class="btn-close admin-inquiries-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body admin-inquiries-modal-body">
                        <p>Are you sure you want to delete this inquiry?</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer admin-inquiries-modal-footer">
                        <button type="button" class="btn cancel-btn admin-inquiries-cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn admin-inquiries-delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
