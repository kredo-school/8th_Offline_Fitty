@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')
        <div class="row row-main w-100">
            @include('sidebar.include-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <!-- Main Content -->
<div class="container inquiry-container">
    <div class="card inquiry-card">
        <div class="card-header inquiry-header">
            <h2 class="inquiry-title mb-0"><i>Inquiry</i></h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.inquiries.update', $inquiry->id) }}" method="POST">
                @csrf
                @method('PATCH')
            
                <div class="form-group mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" value="{{ $inquiry->name }}" readonly>
                </div>
            
                <div class="form-group mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="{{ $inquiry->email }}" readonly>
                </div>
            
                <div class="form-group mb-3">
                    <label>Category</label>
                    <input type="text" class="form-control" value="{{ $inquiry->category }}" readonly>
                </div>
            
                <div class="form-group mb-3">
                    <label>Content</label>
                    <textarea class="form-control" rows="12" readonly>{{ $inquiry->content }}</textarea>
                </div>
            
                <div class="form-group mb-3">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $inquiry->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            
                <div class="form-group mb-3">
                    <label>Person in Charge</label>
                    <input type="text" name="person_in_charge" class="form-control" value="{{ $inquiry->person_in_charge }}">
                </div>
            
                <div class="form-group mb-3">
                    <label>Memo</label>
                    <textarea class="form-control" name="memo" rows="3">{{ $inquiry->memo }}</textarea>
                </div>

                <div class="form-buttons">
                    <a href="{{ route('admin.inquiries.index') }}" class="btn cancel-btn admin-users-cancel-btn admin-btn-equal">Cancel</a>
                    <button type="submit" class="btn send-btn admin-users-delete-btn admin-btn-equal">Save</button>


                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection