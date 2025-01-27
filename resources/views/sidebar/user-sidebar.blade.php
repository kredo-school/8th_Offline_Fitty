
<!-- <div id="sidebar" class="sidemenu col-md-3 col-lg-2">
    <a href="#" class="menu-item">
        <span class="material-icons mt-3">assignment</span> Record
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">person</span> Profile
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">history</span> History
    </a>
    <a href="#" class="menu-item active">
        <span class="material-icons">notifications</span> Notification
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">help_outline</span> Help
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">help</span> FAQ
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">logout</span> Logout
    </a>
</div>

<script>
        // Handle active menu state
        document.querySelectorAll('.menu-item').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            });
        });



        // サイドバーとハンバーガーボタンのトグル機能
        const sidebar = document.getElementById('sidebar');
        const hamburgerButton = document.getElementById('hamburgerButton');

        // ハンバーガーボタンをクリックしたらサイドバーを開閉
        hamburgerButton.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

    </script> -->

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
            <a href="{{route('user.profile', $user->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">person</span>
                <span class="title">Profile</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.history', $user->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">history</span>
                <span class="title">History</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('user.advice.index', $user->id)}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">notifications</span>
                <span class="title">Notification</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="#" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">help_outline</span>
                <span class="title">Help</span>
            </a>
        </li>

        <li class="menu-item d-flex align-items-center py-2">
            <a href="#" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">help</span>
                <span class="title">FAQ</span>
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

