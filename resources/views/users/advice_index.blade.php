@extends('layouts.app')

@section('title', 'Advice List')

@section('content')
@include('sidebar.humburger')


    <div class="row row-main">
        @include('sidebar.user-sidebar')


        <!-- Filter Buttons -->
          <div class="mb-3 d-flex justify-content-center">
            <a href="{{ route('user.advice.index', ['id' => $user->id, 'filter' => 'all']) }}" 
              class="btn {{ request('filter') == 'all' || !request('filter') ? 'btn-primary' : 'btn-secondary' }} me-2">
                All
            </a>
            <a href="{{ route('user.advice.index', ['id' => $user->id, 'filter' => 'read']) }}" 
              class="btn {{ request('filter') == 'read' ? 'btn-primary' : 'btn-secondary' }} me-2">
                Read
            </a>
            <a href="{{ route('user.advice.index', ['id' => $user->id, 'filter' => 'unread']) }}" 
              class="btn {{ request('filter') == 'unread' ? 'btn-primary' : 'btn-secondary' }} me-2">
                Unread
            </a>
            <a href="{{ route('user.advice.index', ['id' => $user->id, 'filter' => 'liked']) }}" 
              class="btn {{ request('filter') == 'liked' ? 'btn-primary' : 'btn-secondary' }} me-2">
                With-Star
            </a>
            <a href="{{ route('user.advice.index', ['id' => $user->id, 'filter' => 'unliked']) }}" 
              class="btn {{ request('filter') == 'unliked' ? 'btn-primary' : 'btn-secondary' }}">
                No-Star
            </a>
          </div>

        {{-- Advice Table --}}

        <div class="col-md-9 ms-sm-auto col-lg-10 d-flex flex-column align-items-center">
            <table class="unique-table-2">
                <thead>
                    <tr>
                        <th style="width: 10%;">Read/Unread</th>
                        <th style="width: 10%;">Star/Unstar</th>
                        <th style="width: 40%;">Advice</th>
                        <th style="width: 10%;">Overall</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($advices as $advice)
                    <tr>
                        <td style="width: 10%;">
                            @if ($advice->is_read == 1)
                            <form action="{{ route('user.advice.unread',['id' => $user->id, 'advice' => $advice->id]) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm shadow-none p-0">
                                    <i class="material-symbols-outlined" title="Read">mark_email_read</i>
                                </button>
                            </form>
                            @elseif($advice->is_read == 0)
                            <form action="{{ route('user.advice.read',['id' => $user->id, 'advice' => $advice->id]) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm shadow-none p-0">
                                    <i class="material-symbols-outlined" title="Read">mark_email_unread</i>
                                </button>
                            </form>
                            @endif
                        </td>

                        <td style="width: 10%;">
                            @if ($advice->is_liked == 1)
                            <form action="{{ route('user.advice.unlike', ['id' => $user->id, 'advice' => $advice->id]) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm shadow-none p-0">
                                    <i class="material-icons" style="color: yellow;" title="Liked">star</i>
                                </button>
                            </form>
                            @elseif ($advice->is_liked == 0)
                            <form action="{{ route('user.advice.like', ['id' => $user->id, 'advice' => $advice->id]) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm shadow-none p-0">
                                    <i class="material-icons" title="Not Liked">star_border</i>
                                </button>
                            </form>
                            @endif
                        </td>
                        <td style="width: 40%;">
                            @if ($advice->created_at)
                            <a href="{{ route('user.advice.showAdvice', ['id' => $user->id, 'date' => $advice->created_at->format('Y-m-d')]) }}" class="d-flex align-items-center">
                                <span class="me-2">{{ $advice->created_at->format('Y/m/d') }}</span>
                            </a>
                            @else
                            <span class="text-muted">No Date</span>
                            @endif
                        </td>
                        <td style="width: 10%;">
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No previous advice yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3 w-100 d-flex justify-content-center">
                {{ $advices->links('nutritionists.pagination') }}
            </div>
        </div>
    </div>

@endsection
