<div id="sidebar" class="sidemenu col-md-3 col-lg-2">
    <h1 class="menu">MENU</h1>
    <ul class="nav flex-column">
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('admin.index')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">home</span>
                <span class="title">Home</span>
            </a>
        </li>
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('admin.users.index')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">person</span>
                <span class="title">Users List</span>
            </a>
        </li>
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('admin.nutritionists.index')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">spa</span>
                <span class="title">Nutritionists List</span>
            </a>
        </li>
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('admin.categories.index')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">category</span>
                <span class="title">Categories List</span>
            </a>
        </li>
        <li class="menu-item d-flex align-items-center py-2">
            <a href="{{route('admin.inquiries.index')}}" class="d-flex align-items-center w-100">
                <span class="material-icons side-material-icons me-2">mail</span>
                <span class="title">Inquires List</span>
            </a>
        </li>
        <hr style="border-color: black; border-width: 1px;">
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




