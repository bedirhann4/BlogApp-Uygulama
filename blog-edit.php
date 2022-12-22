<?php  // benim kod
require "libs/vars.php";
require "libs/functions.php";

$id = $_GET["id"];
$result = getBlogById($id);
$secilenFilm = mysqli_fetch_assoc($result);
$categories = getCategories();
$selectedCategories = getCategoriesByBlogId($id);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = control_input($_POST['title']);
    $sdescription = control_input($_POST['sdescription']);
    $description = control_input($_POST['description']);
    $imageUrl = control_input($_POST['imageUrl']);
    $url = control_input($_POST['url']);
    $categories = $_POST["categories"];
    $isActive = isset($_POST["isActive"]) ? true : false;
    $isHome = isset($_POST["isHome"]) ? true : false;

    if(!empty($_FILES["image"]["name"])){
        $result = saveImage($_FILES["image"]);

        if($result["isSuccess"] == 1){
            $imageUrl = $result["image"];
        }
    }

    if (editBlog($id, $title, $sdescription, $description, $imageUrl, $url, $isActive, $isHome)) {
        clearBlogCategories($id); //tüm blog kategorisi bilgilerini siler.
        if($categories > 0){
            addBlogCategories($id, $categories); //kategori varsa dizi halinde veritabanına yükler
        }
        header("Location: admin-blogs.php?edt=success");
    } else {
        echo "hata";
    }
}

?>
<?php include "views/_header.php"; ?>
<?php include "views/_navbar.php"; ?>
<div class="container my-5">
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-3">
                <?php foreach ($categories as $c): ?>
                <div class="form-check">
                    <label for="category_<?php echo $c["id"] ?>">
                        <?php echo $c["name"] ?>
                    </label>
                    <input type="checkbox" name="categories[]" 
                    id="category_<?php echo $c["id"] ?>" 
                    class="form-check-input"
                    value="<?php echo $c["id"] ?>" 
                    
                        <?php 
                            $isChecked=false; 
                            
                            foreach ($selectedCategories as $s) {
                                if($s["id"] == $c["id"]) {
                                    $isChecked=true;
                                }
                            }

                    if ($isChecked) {
                        echo "checked";
                    } ?>>
                </div>
                <?php endforeach; ?>
                <hr>
                <div class="form-check">
                    <label class="form-check-label" for="isActive">Yayında Mı?</label>
                    <input class="form-check-input" type="checkbox" value="" id="isActive" name="isActive" <?php
                        if ($secilenFilm["isActive"]) {
                            echo "checked";
                        } ?>>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="isHome">Ana Sayfada mı?</label>
                    <input class="form-check-input" type="checkbox" value="" id="isHome" name="isHome" <?php
                        if ($secilenFilm["isHome"]) {
                            echo "checked";
                        } ?>>
                </div>
                <hr>
                <input type="hidden" name="imageUrl" value="<?php echo $secilenFilm["imageUrl"] ?>">
                <img class="img-fluid" src="img/<?php echo $secilenFilm["imageUrl"] ?>" alt="">
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div id="edit-form">
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlığı Düzenle</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="<?php echo $secilenFilm["title"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="sdescription" class="form-label">Kısa Açıklamayı Düzenle</label>
                                <textarea style="background: #242026; color: #fff;" name="sdescription" id="sdescription"
                                    class="form-control"><?php echo $secilenFilm["short_description"]; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Açıklamayı Düzenle</label>
                                <textarea style="background: #242026; color: #fff;" name="description" id="description"
                                    class="form-control"><?php echo $secilenFilm["description"]; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Resim</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">Url Düzenle</label>
                                <input type="text" class="form-control" name="url" id="url"
                                    value="<?php echo $secilenFilm["url"] ?>">
                            </div>
                            
                            <input type="submit" value="Güncelle" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include "views/_ckeditor.php"; ?>
<?php include "views/_footer.php"; ?>