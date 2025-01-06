@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <form action="/profile/update" method="POST">
        @csrf
        <div class="profile-card profile-card-edit">
            <div class="profile-header profile-header-edit">
                <img src="https://via.placeholder.com/120" alt="Profile Picture" class="profile-picture profile-picture-edit">
                <div class="info info-edit">
                    <label class="form-label form-label-edit">Emiko Imai</label>
                    <input type="email" name="email" value="alexarawles@gmail.com"
                        class="form-control form-control-edit">
                </div>
            </div>
            <div class="details details-edit">
                <div class="detail-item detail-item-edit">
                    <span class="detail-label detail-label-edit">Full Name</span>
                    <input type="text" name="full_name" value="Emiko Imai" class="detail-input detail-input-edit">
                </div>
                <div class="detail-item detail-item-edit">
                    <span class="detail-label detail-label-edit">Description</span>
                    <textarea name="description" class="detail-textarea detail-textarea-edit">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor nisi a erat tristique, nec gravida justo bibendum.</textarea>
                </div>
            </div>
            <div class="edit-button edit-button-edit">
                <button type="submit" class="save-button save-button-edit">Save Changes</button>
            </div>
        </div>
    </form>
@endsection

@endsection
