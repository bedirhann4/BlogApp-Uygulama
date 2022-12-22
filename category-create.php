<?php
require "libs/vars.php";
require "libs/functions.php";

$categoryName = "";
$categoryName_err = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    //validate categoryName
    $categoryName_input = trim($_POST['categoryName']); //trim = baş ve sondaki boşlukları sil

    if(empty($categoryName_input)){
        $categoryName_err = "Kategori İsmi Boş Bırakılamaz";
    }else if(strlen($categoryName_input) > 20){     //strlen = değişkenin karakter sayısını sayar
        $categoryName_err = "Kategori İsmi İçin Fazla Karakter";
    }else {
        // $categoryName = strip_tags($categoryName_input,"<b><br>"); //strip_tags = srcipt saldırıları gibi zararlı yazılımları önlemek için yazılan kelime filtresi
        $categoryName = control_input($categoryName_input);
    }
    
    if(empty($categoryName_err)){
        if(createCategory($categoryName)){
            // echo "Başarılı";
            header("Location: admin-categories.php?crte=success");
        }else{
            echo "hata";
        }
    }    
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
    <title>Film Oluştur | Blog App</title>
</head>
<body>
<?php include "views/_navbar.php"; ?>
<div class="container my-5">
    <div class="row">
        <div class="col-3">
            <?php include "views/_menu.php"; ?>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <form action="category-create.php" method="post">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Kategori Adı</label>
                            <input type="text" name="categoryName" id="categoryName" value="<?php echo $categoryName ?>" class="form-control <?php if(!empty($categoryName_err)){echo "is-invalid";}?>">
                            <span class="invalid-feedback"><?php echo $categoryName_err; ?></span>
                        </div>
                        <input type="submit" value="Ekle" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>