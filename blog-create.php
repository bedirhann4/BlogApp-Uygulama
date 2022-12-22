<?php
require "libs/vars.php";
require "libs/functions.php";


$title = $sdescription = $description = $image = $url = $category = "";
$title_err = $sdescription_err = $description_err = $image_err = $url_err = $category_err = "";
$categories = getCategories();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    //validate title
    $title_input = trim($_POST["title"]); //trim = baş ve sondaki boşlukları sil

    if(empty($title_input)){
        $title_err = "Başlık Boş Bırakılamaz!";
    }elseif(strlen($title_input) > 20){     //strlen = değişkenin karakter sayısını sayar
        $title_err = "Başlık İçin Fazla Karakter!";
    }else {
        // $title = strip_tags($title_input,"<b><br>"); //strip_tags = srcipt saldırıları gibi zararlı yazılımları önlemek için yazılan kelime filtresi
        $title = control_input($title_input);
    }

    $sdescription_input = trim($_POST["sdescription"]); //trim = baş ve sondaki boşlukları sil

    if(empty($sdescription_input)){
        $sdescription_err = "Kısa Açıklama Boş Bırakılamaz!";
    }elseif(strlen($sdescription_input) < 5){     //strlen = değişkenin karakter sayısını sayar
        $sdescription_err = "Kısa Açıklama İçin Az Karakter!";
    }else {
        $sdescription = control_input($sdescription_input);
    }

    //validate description
    $description_input = trim($_POST["description"]); //trim = baş ve sondaki boşlukları sil

    if(empty($description_input)){
        $description_err = "Açıklama Boş Bırakılamaz!";
    }elseif(strlen($description_input) < 5){     //strlen = değişkenin karakter sayısını sayar
        $description_err = "Açıklama İçin Az Karakter!";
    }else {
        $description = control_input($description_input);
    }

    if (empty($_FILES["image"]["name"])){
        $image_err = "Resim Boş Geçilmez!";
    }else {
        $result = saveImage($_FILES["image"]);

        if($result["isSuccess"] == 0){
            $image_err = $result["message"];
        }else{
            $image = $result["image"];
        }
    }

    $url_input = $_POST['url'];

    if(empty($url_input)){
        $url_err = "Url Boş Geçilemez!";
    }else{
        $url = control_input($url_input);
    }
    
    if(empty($title_err) && empty($sdescription_err) && empty($description_err) && empty($imgUrl_err) && empty($url_err)){
        if(createBlog($title, $sdescription, $description, $image, $url)){
            // echo "Başarılı";
            header("Location: admin-blogs.php?crte=success");
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="blog-create.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" name="title" id="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid':'' ?>" value="<?php echo $title;?>">
                            <span class="invalid-feedback"><?php echo $title_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="sdescription" class="form-label">Kısa Açıklama</label>
                            <textarea style="background: #242026; color: #fff;" name="sdescription" id="sdescription" class="form-control <?php echo (!empty($sdescription_err)) ? 'is-invalid':'' ?>"><?php echo $sdescription;?></textarea>
                            <span class="invalid-feedback"><?php echo $sdescription_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea style="background: #242026; color: #fff;" name="description" id="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid':'' ?>"><?php echo $description;?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Resim</label>
                            <input type="file" name="image" id="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid':'' ?>">
                            <span class="invalid-feedback"><?php echo $image_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" class="form-control <?php echo (!empty($url_err)) ? 'is-invalid':'' ?>" name="url" id="url" value="<?php echo $url;?>">
                            <span class="invalid-feedback"><?php echo $url_err; ?></span>
                        </div>
                        <input type="submit" value="Ekle" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_ckeditor.php"; ?>
<?php include "views/_footer.php"; ?>