<?php

require "libs/vars.php";
require "libs/functions.php";

?>

<?php include "views/_header.php"; ?>
<?php include "views/_navbar.php"; ?>
<?php 


?>
<div class="container my-5">
    <div class="row">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
            <?php
                if (isset($_POST["loginSubmit"])){
                    $username = $_POST["isim"];
                    $password = $_POST["sifre"];
                    if ($username == user["username"] && $password == user["password"]) {
                        
                        setcookie("auth[kullaniciadi]", user["username"], time()+3600);
                        setcookie("auth[name]", user["name"], time()+3600);
                        
                        header("Location: index.php");
                    }else{   
                        echo "<div class='alert alert-danger mb-0'>Kullanıcı Adı Veya Şifre Hatalı</div>";
                    }
                }
            ?>
                <div class="card-body"><!--login-box-->
                    <div class="wrapper">
                        <div class="typing-demo">
                            <h2>Lütfen Giriş Yapın</h2>
                        </div>
                    </div>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="isim" class="form-label"></label>
                            <input type="text" class="form-control" name="isim" id="isim" placeholder="Kullancı Adı" required>
                        </div>
                        <div class="mb-3"><!--user-box-->
                            <label for="sifre" class="form-label"></label>
                            <input type="password" name="sifre" id="sifre" class="form-control" placeholder="Şifre" required>
                        </div>
                        <div class="button-form">
                        <input type="submit" id="gönderbutonu" value="Gönder" name="loginSubmit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>