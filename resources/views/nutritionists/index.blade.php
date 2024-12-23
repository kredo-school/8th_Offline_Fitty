@extends('layouts.app')
@section('title', 'Home')
@section('content')


<div class="container w-75">
    <h3 class="pt-5 pb-2">Send Feedback to</h2>
    <div class="row g-4">
      <!-- 8名分のカードをループして作成 -->
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">James Anderson</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">Michael Carter</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">David Thompson</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">John Walker</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">Robert Parker</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">Jordan Bailey</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">Jessica Brown</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card nutri-card">
          <img src="https://via.placeholder.com/80" class="nutri-card-img-top " alt="Avatar">
          <div class="card-body">
            <h5 class="nutri-card-title">Sophia Miller</h5>
            <button class="nutri-btn">Send Advice</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
