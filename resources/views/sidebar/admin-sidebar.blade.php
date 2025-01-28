
<div id="sidebar" class="sidemenu col-md-3 col-lg-2">
    <a href="#" class="menu-item">
        <span class="material-icons">home</span> Top
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">person</span> Users
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">spa</span> Nutritionists
    </a>
    <a href="#" class="menu-item">
        <span class="material-icons">category</span> Categories
    </a>
    <a href="#" class="menu-item active">
        <span class="material-icons">mail</span> Inquires
    </a>
    <hr style="border-color: black; border-width: 1px;">
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

    </script>
