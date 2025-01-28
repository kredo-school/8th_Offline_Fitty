@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="d-flex vh-100 admin-nutritionists">
        <div class="row w-100">
            @include('sidebar.admin-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <div class="container my-5 mx-1 admin-nutritionists">
                    <div class="d-flex justify-content-between align-items-center mb-3 admin-nutritionists-header">
                        <h1 class="text-success admin-nutritionists-title">
                            Nutritionists <span class="text-muted">({{ $nutritionists_profiles->total() }})</span>
                        </h1>

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

                        <a href="{{ route('admin.nutritionists.create') }}" class="add-button">
                            <span class="material-symbols-outlined">add</span>
                            <span>Add</span>
                        </a>
                    </div>

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
                                @foreach ($nutritionists_profiles as $nutritionist_profile)
                                    <tr>
                                        <td>
                                            <a href="#" class="admin-nutritionists-id-link">{{ $nutritionist_profile->id }}</a>
                                        </td>
                                        <td>{{ $nutritionist_profile->first_name }} {{ $nutritionist_profile->last_name }}</td>
                                        <td>{{ $nutritionist_profile->last_login ? $nutritionist_profile->last_login->format('m/d/Y') : 'N/A' }}</td>
                                        <td>
                                            @if ($nutritionist_profile->is_active)
                                                <span class="status-badge status-active admin-nutritionists-status">Active</span>
                                            @else
                                                <span class="status-badge status-inactive admin-nutritionists-status">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="admin-nutritionists-action-button">
                                                <span class="material-symbols-outlined">person</span>
                                            </a>
                                            <a href="#" class="admin-nutritionists-action-button" data-bs-toggle="modal"
                                               data-bs-target="#deleteModal-{{ $nutritionist_profile->id }}">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $nutritionists_profiles->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($nutritionists_profiles as $nutritionist_profile)
        <div class="modal fade" id="deleteModal-{{ $nutritionist_profile->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $nutritionist_profile->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $nutritionist_profile->id }}">Delete Nutritionist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this nutritionist?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.nutritionists.destroy', $nutritionist_profile->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
