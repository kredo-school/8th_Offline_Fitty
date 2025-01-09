@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    @include('sidebar.humburger')
    <div class="container user-dailylog">
        <div class="row">
            @include('sidebar.user-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 mt-4">
                <!-- main content -->

                <body>
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="profile-card profile-card-edit">
                            <div class="profile-header profile-header-edit">
                                <img src="https://via.placeholder.com/120" alt="Profile Picture"
                                    class="profile-picture profile-picture-edit">
                                <div class="info info-edit">
                                    <label class="form-label form-label-edit">Emiko Imai</label>
                                    <p class="profile-email profile-email-view">alexarawles@gmail.com</p>
                                </div>
                            </div>
                            <div class="details details-edit">
                                <div class="detail-item detail-item-edit">
                                    <span class="detail-label detail-label-edit">Full Name</span>
                                    <input type="text" name="full_name" value="Emiko Imai"
                                        class="detail-input detail-input-edit">
                                </div>
                                <div class="detail-item detail-item-edit">
                                    <span class="detail-label detail-label-edit">Description</span>
                                    <textarea name="description" class="detail-textarea detail-textarea-edit"></textarea>
                                </div>
                            </div>
                            <div class="edit-button edit-button-edit">
                                <button type="submit" class="save-button save-button-edit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </body>
            </div>
        </div>
    </div>




@endsection
