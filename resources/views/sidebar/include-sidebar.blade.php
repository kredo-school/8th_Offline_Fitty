@if(Auth::user()->role == "A")
        @include('sidebar.admin-sidebar')
@elseif(Auth::user()->role == "N")
    @include('sidebar.nutri-sidebar')
@else
    @include('sidebar.user-sidebar')
@endif