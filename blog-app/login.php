<?php
require "libs/vars.php";
require "libs/functions.php";
require "libs/connection.php";
if(isLoggedIn()){
    header("Location: profile.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Giriş Yap | Blog App</title>
</head>
<body>
<?php include "views/_navbar.php"; ?>
<div class="container my-5">
    <div class="row">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
            <?php
                $username = $password = "";
                $username_err = $password_err = $login_err = "";
                if (isset($_POST["loginSubmit"])){
                    if(empty(trim($_POST["username"]))){
                        $username_err = "Lütfen Kullanıcı Adı Giriniz.";
                    }else{
                        $username = $_POST["username"];
                    }
                    if(empty(trim($_POST["password"]))){
                        $password_err = "Lütfen Parola Giriniz.";
                    }else{
                        $password = $_POST["password"];
                    }
                    if(empty($username_err) && empty($password_err)){
                        $sql = "SELECT id, username, password, user_type FROM users WHERE username = ?";
                        if($stmt = mysqli_prepare($dbbaglantisi, $sql)){ //prepare -> (hazırlamak)sorguyu gönderiyoruz. 
                            mysqli_stmt_bind_param($stmt, 's', $username); //parametreleri bağlıyoruz (ing(bind -> bağlamak))
                            if(mysqli_stmt_execute($stmt)){ //sorguyu çalıştırıyoruz(uyguluyoruz)
                                mysqli_stmt_store_result($stmt); //result'u kaydediyoruz (sanırım önbelleğe)
                                if(mysqli_stmt_num_rows($stmt) == 1){
                                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_passeword, $user_type); //veritabanından gelen değerleri saklamaya(depolamaya yarar)
                                    if(mysqli_stmt_fetch($stmt)){
                                        if(password_verify($password, $hashed_passeword)){
                                            $_SESSION["loggedIn"] = true;
                                            $_SESSION["id"] = $id;
                                            $_SESSION["username"] = $username;
                                            $_SESSION["user_type"] = $user_type;
                                            header("location: profile.php?login=success");
                                        }else{
                                            $login_err = "Şifre Hatalı";
                                        }
                                    }
                                }else{
                                    $login_err = "Kullanıcı Adı Hatalı.";
                                }
                            }else{
                                $login_err = "Bilinmeyen bir hata oluştu";
                            }
                            mysqli_stmt_close($stmt);
                        }
                    }
                    mysqli_close($dbbaglantisi);
                }
            ?>
            <?php if(isset($_GET["register"]) == "success"): ?>
                <div class="alert alert-success mb-0 text-center"><?php echo "Kayıt İşlemi Başarılı, Lütfen Giriş Yapın" ?></div>
            <?php endif; ?>
            <?php if(!empty($login_err)){
                echo '<div class="alert alert-danger">'.$login_err.'</div>';
            } ?>
                <div class="card-body"><!--login-box-->
                    <div class="wrapper">
                        <div class="typing-demo">
                            <h2>Lütfen Giriş Yapın</h2>
                        </div>
                    </div>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label"></label>
                            <input type="text" value="<?php echo $username ?>" name="username" id="username" placeholder="Kullancı Adı" class="form-control <?php echo(!empty($username_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="mb-3"><!--user-box-->
                            <label for="password" class="form-label"></label>
                            <input type="password" name="password" id="password" placeholder="Şifre" class="form-control <?php echo(!empty($password_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
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