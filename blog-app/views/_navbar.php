<?php 

    if (!empty($_GET['question'])) {
        $keyword = $_GET['question'];

        $filmler = array_filter($filmler, function($film) use ($keyword){//use ile global çapta değikenleri fonksiyon içinde kullanabiliyoruz
            return (stristr($film['baslik'], $keyword) or stristr($film['aciklama'], $keyword));
        });
    }
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a href="index.php" class="navbar-brand">BlogApp</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="create.php" class="nav-link">
                        Film Ekle
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        link 2
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        link 3
                    </a>
                </li>
            </ul>
            <form class="d-flex" action="index.php" method="get">
                <input name="question" placeholder="Search" type="text" class="form-control me-2">
                <button class="btn btn-outline-light">Search</button>
            </form>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if(isset($_COOKIE["auth"])): ?>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            Çıkış Yap
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <?php echo $_COOKIE["auth"]["name"] ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link active">
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