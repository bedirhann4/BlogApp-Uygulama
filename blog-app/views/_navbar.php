<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container">
        <a href="index.php" class="navbar-brand">BlogApp</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="blogs.php" class="nav-link">
                        Tüm Filmler
                    </a>
                </li>
                <?php if(isAdmin()): ?>
                    <li class="nav-item">
                        <a href="admin-blogs.php" class="nav-link">
                            Admin Film Liste
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin-categories.php" class="nav-link">
                            Admin Kategori
                        </a>
                    </li>  
                <?php endif; ?>
            </ul>
            <form class="d-flex" action="blogs.php" method="get">
                <input name="question" placeholder="Search" type="text" class="form-control me-2">
                <button class="btn btn-outline-light">Search</button>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if(isLoggedIn()): ?>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            Çıkış Yap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">
                            <?php echo $_SESSION["username"] ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">
                            Giriş Yap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link">
                            Kayıt Ol
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>