<?php

require "libs/vars.php";
require "libs/functions.php";
if(!isAdmin()){
    header("Location: unautorize.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Film Listesi | Blog App</title>
</head>
<body>
<?php 
if(isset($_GET["dlt"])=="success"): ?>
    <div class="alert alert-danger mb-0 text-center"><?php echo "Film Başarıyla Silindi" ?></div>
<?php endif; ?>
<?php 
if(isset($_GET["crte"])=="success"): ?>
    <div class="alert alert-success mb-0 text-center"><?php echo "Film Başarıyla Yüklendi" ?></div>
<?php endif; ?>
<?php 
if(isset($_GET["edt"])=="success"): ?>
    <div class="alert alert-success mb-0 text-center"><?php echo "Film Başarıyla Güncellendi" ?></div>
<?php endif; ?>
<?php include "views/_navbar.php"; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card mb-1">
                <div class="card-body">
                    <a href="blog-create.php" class="btn btn-primary">Yeni Film Oluştur</a>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Resim</th>
                        <th>Başlık</th>
                        <th>Kısa Açıklama</th>
                        <th>Açıklama</th>
                        <th>Kategori</th>
                        <th>Aktiflik</th>
                        <th>Ana Sayfa</th>
                        <th></th>
                    </tr>
                </thead> 
                <tbody>
                    <?php include "libs/connection.php"; $result = getBlogs();  while($sırala = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="width: 50px;"><img src="img/<?php echo $sırala["imageUrl"] ?>" alt="" class="img-fluid"></td>
                            <td style="width: 50px;"><?php echo htmlspecialchars_decode($sırala["title"]) ?></td>
                            <td style="width: 200px;"><?php echo htmlspecialchars_decode($sırala["short_description"]) ?></td>
                            <td style="width: 400px;"><?php echo htmlspecialchars_decode($sırala["description"]) ?></td>

                            <td style="width: 100px;">
                            <?php
                                echo "<ul>";
                                    $sonuc = getCategoriesByBlogId($sırala["id"]);

                                    if (mysqli_num_rows($sonuc) > 0) {
                                        while($deger = mysqli_fetch_assoc($sonuc)){
                                            echo "<li>".$deger["name"]."</li>";
                                        }
                                    }else{
                                        echo "<li>Kategori Seçilmedi</li>";
                                    }
                                echo "</ul>";

                            ?>
                            
                        
                            </td>

                            <td style="width: 50px;"><?php if($sırala["isActive"]): ?> <i class="fas fa-check"></i><?php else: ?><i class="fas fa-times"><?php endif; ?></i></td>
                            <td style="width: 50px;"><?php if($sırala["isHome"]): ?> <i class="fas fa-check"></i><?php else: ?><i class="fas fa-times"><?php endif; ?></i></td>
                            <td style="width: 50px;">
                                <a name="duzenle" class="btn btn-primary" style="width: 80px;" href="blog-edit.php?id=<?php echo $sırala["id"] ?>">Düzenle</a>
                                <a name="sil" class="btn btn-danger" style="width: 80px;" href="blog-delete.php?id=<?php echo $sırala["id"] ?>">Sil</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>