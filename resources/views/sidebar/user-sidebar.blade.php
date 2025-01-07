
<div id="sidebar" class="sidemenu col-md-3 col-lg-2">
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

    </script>