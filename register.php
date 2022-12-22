<?php
require "libs/vars.php";
require "libs/functions.php";
require "libs/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Kayıt Ol | Blog App</title>
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
                $username = $email = $password = $confirmpassword = "";
                $username_err = $email_err = $password_err = $confirmpassword_err = "";
                if (isset($_POST["registerSubmit"])){
                    //validate username
                    if(empty(trim($_POST["username"]))){
                        $username_err = "Lütfen Kullanıcı Adı Giriniz.";
                    }elseif(strlen(trim($_POST["username"])) < 5 or  strlen(trim($_POST["username"])) > 20 ){
                        $username_err = "Kullanıcı Adı 5-20 Karekter Arasında Olmalıdır.";
                    }elseif(!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["username"])){
                        $username_err = "Geçersiz Karakter Kullandınız.";
                    }else{
                        $sql = "SELECT id from users WHERE username = ?";
                        if($stmt = mysqli_prepare($dbbaglantisi, $sql)){
                            $param_username = trim($_POST["username"]);
                            mysqli_stmt_bind_param($stmt, "s", $param_username);
                            if(mysqli_stmt_execute($stmt)){
                                mysqli_stmt_store_result($stmt);
                                if(mysqli_stmt_num_rows($stmt) == 1){
                                    $username_err = "Kullanıcı Adı Daha Önceden Alınmış";
                                }else{
                                    $username = $_POST["username"];
                                }
                            }else{
                                echo "Bir Hata Oluştu" . mysqli_error($dbbaglantisi);
                            }
                        }
                    }
                    //validate email
                    if(empty(trim($_POST["email"]))){
                        $email_err = "Lütfen Mail Adresinizi Giriniz.";
                    }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                        $email_err = "Hatalı Email Girdiniz";
                    }else{
                        $sql = "SELECT id from users WHERE email = ?";
                        if($stmt = mysqli_prepare($dbbaglantisi, $sql)){
                            $param_username = trim($_POST["email"]);
                            mysqli_stmt_bind_param($stmt, "s", $param_username);
                            if(mysqli_stmt_execute($stmt)){
                                mysqli_stmt_store_result($stmt);
                                if(mysqli_stmt_num_rows($stmt) == 1){
                                    $email_err = "Email Daha Önceden Alınmış";
                                }else{
                                    $email = $_POST["email"];
                                }
                            }else{
                                echo "Bir Hata Oluştu" . mysqli_error($dbbaglantisi);
                            }
                        }
                    }
                    //validate password
                    if(empty(trim($_POST["password"]))){
                        $password_err = "Lütfen Şifrenizi Giriniz.";
                    }elseif(strlen(trim($_POST["password"])) < 6){
                        $password_err = "Parola 6 karakterden Kısa";
                    }else{
                        $password = $_POST["password"];
                    }
                    //validate confirmpassword
                    if(empty(trim($_POST["confirmpassword"]))){
                        $confirmpassword_err = "Lütfen Doğrulama Şifrenizi Giriniz.";
                    }elseif(strlen(trim($_POST["confirmpassword"])) < 6){
                        $confirmpassword_err = "Doğrulama Parolası 6 karakterden Kısa";
                    }else{
                        $confirmpassword = $_POST["confirmpassword"];
                        if(empty($password_err) && ($password != $confirmpassword)){
                            $confirmpassword_err = "Parolalar Eşleşmiyor.";
                        }
                    }

                    //baglantıyı yapğtı sql bağlantısı
                    if(empty($username_err) && empty($$email_err) && empty($$password_err)){
                        $sql = "INSERT INTO users(username, email, password) VALUES (?,?,?)";
                        if($stmt =  mysqli_prepare($dbbaglantisi, $sql)){
                            $param_username = $username;
                            $param_email = $email;
                            $param_password = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"sss",$param_username, $param_email, $param_password);

                            if(mysqli_stmt_execute($stmt)){
                                header("Location: login.php?register=success");
                            }else{
                                echo "Bir Hata Oluştu".mysqli_error($dbbaglantisi);
                            }

                        }
                    }

                }?>
                <div class="card-body"><!--login-box-->
                    <div class="wrapper">
                        <div class="typing-demo">
                            <h2>Kayıt Ol</h2>
                        </div>
                    </div>
                    <form action="register.php" method="post" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label"></label>
                            <input value="<?php echo $username; ?>" type="text" name="username" id="username" placeholder="Kullanıcı Adı" class="form-control <?php echo(!empty($username_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"></label>
                            <input value="<?php echo $email; ?>" type="email" name="email" id="email" placeholder="Mail Adresi" class="form-control <?php echo(!empty($email_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"></label>
                            <input value="<?php echo $password; ?>" type="password" name="password" id="password" placeholder="Şifre" class="form-control <?php echo(!empty($password_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="mb-3"><!--user-box-->
                            <label for="confirmpassword" class="form-label"></label>
                            <input value="<?php echo $confirmpassword; ?>" type="password" name="confirmpassword" id="confirmpassword" placeholder="Şifreyi Onayla" class="form-control <?php echo(!empty($confirmpassword_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $confirmpassword_err; ?></span>
                        </div>
                        <div class="button-form">
                        <input type="submit" id="kayıtButonu" value="Kayıt Ol" name="registerSubmit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>