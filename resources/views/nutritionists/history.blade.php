@extends('layouts.app')
@section('title', 'Send Advice')
@section('content')

<div class="d-flex justify-content-center">
<table class="unique-table">
  <thead>
    <tr>
      <th>History of {{$user_profile->first_name}} {{$user_profile->last_name}}</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($adviceList as $advice)
    <tr>
      <td><a href="{{route('nutri.showHistory', $user_profile->id)}}">{{ $advice->created_at->format('Y/m/d') }}</a></td>
    </tr>
    @empty
    <tr>
      <td>No previous advice yet</td>
    </tr>
    @endforelse
  </tbody>
</table>
</div>

@endsection
