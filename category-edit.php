<?php
require "libs/vars.php";
require "libs/functions.php";

$id = $_GET["id"];
$result = getCaregoriyById($id);
$secilenKategori = mysqli_fetch_assoc($result);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $categoryName = $_POST["categoryname"];
    $isActive = isset($_POST["isActive"]) ? 1 : 0;

    if(editCategory($id, $categoryName, $isActive)){
        header("Location: admin-categories.php?edt=success");
    }else{
        echo "hata";
    }
}
?>

<?php include "views/_header.php"; ?>
<?php include "views/_navbar.php"; ?>
<div class="container my-5">
    <div class="row">
        <div class="col-3">
            <?php include "views/_menu.php"; ?>
        </div>
            <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="categoryname" class="form-label">İsmi Düzenle</label>
                            <input type="text" class="form-control" name="categoryname" id="categoryname" value="<?php echo $secilenKategori["name"] ?>">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="isActive" style="color: white;">Aktif Mi?</label>
                            <input class="form-check-input" type="checkbox" value="" id="isActive" name="isActive" <?php if($secilenKategori["isActive"]) {echo "checked";} ?>>
                        </div>
                        <input type="submit" value="Güncelle" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>