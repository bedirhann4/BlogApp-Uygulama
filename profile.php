<?php

require "libs/vars.php";
require "libs/functions.php";

if(!isLoggedIn()){
    header("Location: login.php");
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
    <title>Kullanıcı Sayfası | Blog App</title>
</head>
<body>
<?php include "views/_navbar.php"; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-9">
            <h3>Hoşgeldiniz, <?php echo $_SESSION["username"] ?></h3>
            <div>
                <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>