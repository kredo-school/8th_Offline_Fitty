@extends('layouts.app')

@section('title', 'advice index')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <table class="unique-table">
              <thead class="">
                <tr>
                  <th></th>
                  <th></th>
                  <th>History of {{$user->name}} Advices</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_read">mark_email_read</span></td>
                  <td>
                    <span class="material-symbols-sharp" title="favorite" style="color: yellow;">star</span></td>
                  <td><a href="page8.html">2024/02/16</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 4) selected @endif"
                    data-value="4">sentiment_satisfied</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page7.html">2024/02/09</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page6.html">2024/02/02</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page5.html">2024/01/26</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page4.html">2024/01/19</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page3.html">2024/01/12</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page2.html">2024/01/05</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
                <tr>
                  <td><span class="material-symbols-outlined" title="is_unread">mark_email_unread</span></td>
                  <td><span class="material-symbols-outlined" title="not_favorite">star</span></td>
                  <td><a href="page1.html">2023/12/29</a></td>
                  <td><span
                    class="material-symbols-outlined @if (old('overall') == 5) selected @endif"
                    data-value="5">sentiment_excited</span></td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
@endsection
