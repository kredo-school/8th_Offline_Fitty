@extends('layouts.app')

@section('title', 'advice index')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <table class="unique-table ">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th>History of {{$user->name}} Advices</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><i class="fa fa-envelope-open opened" aria-hidden="true" title="is_read"></i></td>
                  <td><i class="fa fa-regular fa-star" aria-hidden="true"></i></td>
                  <td><a href="page8.html">2024/02/16</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 4) selected @endif"
                    data-value="4">sentiment_satisfied</span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page7.html">2024/02/09</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page6.html">2024/02/02</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page5.html">2024/01/26</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page4.html">2024/01/19</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page3.html">2024/01/12</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page2.html">2024/01/05</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
                <tr>
                  <td><i class="fa fa-envelope closed" aria-hidden="true"></i></td>
                  <td><i class="fa fa-star liked text-warning" aria-hidden="true"></i></td>
                  <td><a href="page1.html">2023/12/29</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span>
                <span></td>
                </tr>
              </tbody>
            </table>
            </div>
    </div>
@endsection