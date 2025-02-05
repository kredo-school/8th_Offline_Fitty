
    <div id="sidebar" class="sidemenu col-md-3 col-lg-2">
    <h1 class="menu">MENU</h1>
    <ul class="nav flex-column">
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.inputmeal')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">assignment</span>
                <span class="title">Record</span>
            </a>
        </li>
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.profile', Auth::user()->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">person</span>
                <span class="title">Profile</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.history', Auth::user()->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">history</span>
                <span class="title">History</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.advice.index', Auth::user()->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">notifications</span>
                <span class="title">Notification</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{ route('user.sendInquiry.form', Auth::user()->id) }}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">chat</span>
                <span class="title">Inquiry</span>
            </a>
        </li>


        <li class="menu-item d-flex align-items-center py-2">
            <a href="#" class="d-flex align-items-center w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <span class="material-icons side-material-icons me-2">logout</span>
                <span class="title">Logout</span>
            </a>
        </li>

    </ul>
</div>
@include('sidebar.modals.logout-modal')



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 現在のURLを取得
        const currentUrl = window.location.href;

        // サイドメニューのリンクをすべて取得
        const menuLinks = document.querySelectorAll('.nav li a');

        // 現在のURLに一致するリンクに「active」クラスを付与
        menuLinks.forEach(link => {
            if (link.href === currentUrl) {
                link.parentElement.classList.add('active');
            } else {
                link.parentElement.classList.remove('active');
            }
        });
    });

    // サイドバーとハンバーガーボタンのトグル機能
    const sidebar = document.getElementById('sidebar');
    const hamburgerButton = document.getElementById('hamburgerButton');

    // ハンバーガーボタンがクリックされたときにサイドバーの表示を切り替え
    if (hamburgerButton) {
        hamburgerButton.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }
</script>

