@extends('layouts.app')

@section('title', 'Advice List')

@section('content')
@include('sidebar.humburger')

<div class="container">
        @include('sidebar.user-sidebar') 
        <div class="d-flex justify-content-center">
          <table class="unique-table-2">
              <thead>
                  <tr>
                    <th colspan="4">History of {{$user->name}}</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($adviceList as $advice)
                  <tr>
                    <td style="width: 10%;">
                      @if ($advice->is_read)
                          <span class="material-symbols-outlined" title="Read">mark_email_read</span>
                      @else
                          <span class="material-symbols-outlined" title="Unread">mark_email_unread</span>
                      @endif
                    </td>
                    <td  style="width: 10%;">
                      @if ($advice->is_liked)
                          <i class="material-icons" style="color: yellow;" title="Liked">star</i>
                      @else
                          <i class="material-icons" title="Not Liked">star_border</i>
                      @endif
                    </td>
                    <td style="width: 40%;">
                      @if ($advice->created_at)
                          <a href="{{ route('user.advice.showAdvice', ['id' => $user->id, 'date' => $advice->created_at->format('Y-m-d')]) }}" class="d-flex align-items-center">
                              <span class="me-2">{{ $advice->created_at->format('Y/m/d') }}
                              </span>
                          </a>
                          @else
                          <span class="text-muted">No Date</span> <!-- `created_at` がない場合のフォールバック -->
                           @endif
                    </td>
                    <td style="width: 10%;">
                            
                              <!-- 顔文字の表示 -->
                              @if ($advice->overall == 5)
                                  <span class="material-symbols-outlined history-icon">sentiment_excited</span>
                              @elseif ($advice->overall == 4)
                                  <span class="material-symbols-outlined history-icon">sentiment_satisfied</span>
                              @elseif ($advice->overall == 3)
                                  <span class="material-symbols-outlined history-icon">sentiment_content</span>
                              @elseif ($advice->overall == 2)
                                  <span class="material-symbols-outlined history-icon">sentiment_neutral</span>
                              @elseif ($advice->overall == 1)
                                  <span class="material-symbols-outlined history-icon">sentiment_sad</span>
                              @endif
                          </a>
                    </td>
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