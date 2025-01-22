 @extends('layouts.app')

@section('title', 'show advice')

@section('content')

    <style>
        #app {
            min-height: auto !important;
        }
    </style>

@include('sidebar.humburger')
    <div class="container">

        
        <div class="row">
            @include('sidebar.user-sidebar') 

            
            <div class="col-md-9 ms-sm-auto col-lg-10"> 
            <div class="custom-right-section">
                <h4 class="text-center p-4">Advice</h4>

                <!-- Radar Chart Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Radar Chart</h5>
                        <div class="text-center">
                            <!-- Radar Chart Placeholder -->
                            <img src="https://via.placeholder.com/300x200" alt="Radar Chart" class="img-fluid">
                        </div>
                    </div>
                </div>
                
                <form action="#" method="post" class="w-75">
                    @csrf

                    <!-- Overall Rating -->
                    <div class="">
                        <label for="overall" class="form-label ">Overall Rating</label>
                        <div id="overall" class="d-flex justify-content-start gap-4">
                            <span
                                class="material-symbols-outlined user-material-symbols-outlined @if (old('overall') == 5) selected @endif "
                                data-value="5">sentiment_excited
                            </span>
                        </div>
                        <input type="hidden" name="overall" id="overall-input" value="{{ old('overall') }}">
                        @error('overall')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Comment --}}
                    <div class="mb-3">
                        <label for="message" class="form-label">Comment</label>
                        <textarea class="form-control" id="message" name="message" rows="18" placeholder="asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl" style="padding: 12px;">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- User ID -->
                    <input type="hidden" name="user_id" value="#">

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn see-previous-btn">Previous Advice</a>

                    </div>
                </form>

            </div>
            
            </div>
        </div>
    </div>
@endsection