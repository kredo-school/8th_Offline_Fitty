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
                <td>
                    <a href="{{ route('nutri.showHistory', ['id' => $user_profile->user->id, 'date' => $advice->created_at->toDateString()]) }}" class="d-flex align-items-center">
                        <span class="me-2">{{ $advice->created_at->format('Y/m/d') }}</span>
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
    <div class="mt-4">
        {{ $adviceList->links('nutritionists.pagination') }}
    </div>
</div>



@endsection
