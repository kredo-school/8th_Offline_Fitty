@extends('layouts.app')
@section('title', 'Send Advice')
@section('content')

<div class="d-flex justify-content-center">
<table class="unique-table ">
  <thead>
    <tr>
      <th>History of {{$user_profile->first_name}} {{$user_profile->last_name}}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><a href="page8.html">2024/02/16</a></td>
    </tr>
    <tr>
      <td><a href="page7.html">2024/02/09</a></td>
    </tr>
    <tr>
      <td><a href="page6.html">2024/02/02</a></td>
    </tr>
    <tr>
      <td><a href="page5.html">2024/01/26</a></td>
    </tr>
    <tr>
      <td><a href="page4.html">2024/01/19</a></td>
    </tr>
    <tr>
      <td><a href="page3.html">2024/01/12</a></td>
    </tr>
    <tr>
      <td><a href="page2.html">2024/01/05</a></td>
    </tr>
    <tr>
      <td><a href="page1.html">2023/12/29</a></td>
    </tr>
  </tbody>
</table>
</div>
@endsection
