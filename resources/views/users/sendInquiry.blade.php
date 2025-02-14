@extends('layouts.app')

@section('title', 'SendInquiry')

@section('content')
<div class="row row-main">
    @include('sidebar.include-sidebar')
    <div class="col-md-9 ms-sm-auto col-lg-10 "> 
        <div class="d-flex justify-content-center">
            <div class="nurti-card w-50  m-3">

                @if (session('success'))
                    <div id="success-message" class="alert alert-success text-center" style="font-size: 16px; padding: 15px; border-radius: 5px;">
                        🎉 {{ session('success') }}
                    </div>

                    <script>
                        setTimeout(function() {
                            document.getElementById('success-message').style.opacity = '0';
                            setTimeout(function() {
                                document.getElementById('success-message').style.display = 'none';
                            }, 500);
                        }, 3000);
                    </script>
                @endif

                <div class="card-header" style="border-bottom: 2px solid #00984f;">
                    <h3>Inquiry Form</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.sendInquiry.store', Auth::user()->id) }}" method="POST">
                        @csrf
                        {{-- Email --}}
                        <div class="my-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <label class="form-label">Category of your inquiry</label>
                            <select class="form-select" name="category">
                                <option value="Login_Issues" {{ old('category') == 'Login_Issues' ? 'selected' : '' }}>Login Issues</option>
                                <option value="Billing" {{ old('category') == 'Billing' ? 'selected' : '' }}>Billing</option>
                                <option value="Feature_Request" {{ old('category') == 'Feature_Request' ? 'selected' : '' }}>Feature Request</option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Content --}}
                        <div class="mb-5">
                            <label class="form-label">Content</label>
                            <textarea class="form-control" name="content" rows="6">{{ old('content') }}</textarea>
                            <small class="text-muted">*Please enter at least 30 characters for your inquiry.</small><br>
                            @error('content')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="">
                            <button type="submit" class="btn-submit w-100">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
