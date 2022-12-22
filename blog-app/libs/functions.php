<?php // benim kod
function getData(){
    $myfile = fopen("db.json", "r");
    $size = filesize("db.json");
    $aktar = json_decode(fread($myfile, $size), true);
    fclose($myfile);
    return $aktar;
}
function createUser(string $name, string $username, string $email, string $password){
    //veriyi çağır 
    $db = getData();
    //kayıtta alınan veriyi diziye ekle
    array_push(
        $db["users"],
        array(
            "id" => count($db["users"]) + 1,
            "name" => $name,
            "userName" => $username,
            "email" => $email,
            "password" => $password
        )
    );
    //dosyayı aç
    $myfile = fopen("db.json", "w");
    //eklenen veriyi veritabanına yükle
    fwrite($myfile, json_encode($db, JSON_PRETTY_PRINT));
    //dosyayı kapat
    fclose($myfile);
}
function getUser(string $username){
    $users = getData()["users"];

    foreach ($users as $user) {
        if ($user["userName"] == $username) {
            return $user;
        }
    }
    return null;
}

function createBlog(string $title, string $sdescription, string $description, string $imageUrl, string $url, int $isActive=0){
    include "connection.php";
    #sorgu 
    $query = "INSERT INTO blogs(title, short_description, description, imageUrl, url, isActive) VALUES (?, ?, ?, ?, ?, ?)";
    $result = mysqli_prepare($dbbaglantisi, $query);

    mysqli_stmt_bind_param($result, 'sssssi' , $title,$sdescription,$description,$imageUrl,$url,$isActive);
    mysqli_stmt_execute($result);
    mysqli_stmt_close($result);

    return $result;
}
function getBlogs(){
    include "connection.php";
    $sorgu = "SELECT * FROM blogs";
    $query = mysqli_query($dbbaglantisi, $sorgu);
    mysqli_close($dbbaglantisi);
    return $query;
}
function getBlogByFilters($categoyId, $keyword, $page){
    include "connection.php";
    $pageCount = 2;  //sayfa sayısı
    $offSet = ($page-1) * $pageCount;
    $query = "";

    if(!empty($categoyId)){ //kategori id varmı
        $query = "FROM blog_category bc inner join blogs b on bc.blog_id=b.id WHERE bc.category_id=$categoyId AND isActive=1";
    }else{
        $query = "FROM blogs WHERE isActive=1";
    }

    if(!empty($keyword)){ //arama kelimesi 
        $query .= " && title LIKE '%$keyword%' or description LIKE '%$keyword%'";
    }
    $total_sql = "SELECT COUNT(*) ".$query;
    
    $count_data = mysqli_query($dbbaglantisi, $total_sql);
    $count = mysqli_fetch_array($count_data)[0]; //isActive'i 1 olan filmler
    $total_page = ceil($count / $pageCount);    //bir sayfada kaç blog gözükmesini istiyorsak onun katı

    // echo $total_page; //alttaki sayfa sayısı

    $sql = "SELECT * ".$query." LIMIT $offSet, $pageCount"; //($offSet)inci kayıttan sonra $pageCount(2) veri daha getirdemiş olduk.
    $result = mysqli_query($dbbaglantisi, $sql);
    mysqli_close($dbbaglantisi);
    return array("total_page" => $total_page,"data" => $result);
}
function getHomePageBlogs(){
    include "connection.php";
    $sorgu = "SELECT * FROM blogs WHERE isActive=1 and isHome=1 ORDER BY dateAdded DESC LIMIT 10";
    $query = mysqli_query($dbbaglantisi, $sorgu);
    mysqli_close($dbbaglantisi);
    return $query;
}
function getCategoriesByBlogId(int $id){
    include "connection.php";
    $query = "SELECT * FROM blog_category bc inner join categories c on bc.category_id=c.id WHERE bc.blog_id=$id";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function getBlogsByCategoryId(int $catid){
    include "connection.php";
    $query = "SELECT * FROM blog_category bc inner join blogs b on bc.blog_id=b.id WHERE bc.category_id=$catid";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function getCategoryByKeyWord($question){
    include "connection.php";
    $query = "SELECT * FROM blogs WHERE title LIKE '%$question%' or description LIKE '%$question%'";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function getBlogById(int $movieId){
    include "connection.php";
    $query = "SELECT * FROM blogs WHERE id='$movieId'";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function editBlog(int $id, string $title, string $sdescription, string $description, string $imageUrl, string $url, int $isActive, int $isHome){
    include "connection.php";
    $query = "UPDATE blogs SET title='$title', short_description='$sdescription',description='$description',imageUrl='$imageUrl',url='$url', isActive=$isActive, isHome=$isHome WHERE id=$id";
    $result = mysqli_query($dbbaglantisi, $query);
    echo mysqli_error($dbbaglantisi);
    mysqli_close($dbbaglantisi);
    return $result;
}
function clearBlogCategories(int $blogid){
    include "connection.php";
    $query = "DELETE FROM blog_category WHERE blog_id=$blogid";
    $result = mysqli_query($dbbaglantisi, $query);
    echo mysqli_error($dbbaglantisi);
    mysqli_close($dbbaglantisi);
    return $result;
}
function addBlogCategories(int $blogid, array $categories){
    include "connection.php";

    $query = "";
    foreach($categories as $catid){
        $query .= "INSERT INTO blog_category(blog_id,category_id) VALUE ($blogid, $catid);";
    }
    $result = mysqli_multi_query($dbbaglantisi, $query);
    echo mysqli_error($dbbaglantisi);
    mysqli_close($dbbaglantisi);
    return $result;
}
function deleteBlog(int $id){
    include "connection.php";
    $query = "DELETE FROM blogs WHERE id='$id'";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function getCategories(){
    include "connection.php";
    $sorgu = "SELECT * FROM categories";
    $query = mysqli_query($dbbaglantisi, $sorgu);
    mysqli_close($dbbaglantisi);
    return $query;
}
function createCategory(string $name){
    include "connection.php";
    $query = "INSERT INTO categories(name) VALUES (?)";
    $result = mysqli_prepare($dbbaglantisi, $query);

    mysqli_stmt_bind_param($result, 's', $name);
    mysqli_stmt_execute($result);
    mysqli_stmt_close($result);

    return $result;
}
function getCaregoriyById(int $categoryId){
    include "connection.php";
    $query = "SELECT * FROM categories WHERE id='$categoryId'";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function getCaregoriyByActive(){
    include "connection.php";
    $query = "SELECT * FROM categories WHERE isActive=1";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function editCategory(int $id, string $categoryName,bool $isActive){
    include "connection.php";
    $query = "UPDATE categories SET name='$categoryName', isActive='$isActive' WHERE id=$id";
    $result = mysqli_query($dbbaglantisi, $query);
    echo mysqli_error($dbbaglantisi);
    mysqli_close($dbbaglantisi);
    return $result;
}
function deleteCategory(int $id){
    include "connection.php";
    $query = "DELETE FROM categories WHERE id='$id'";
    $result = mysqli_query($dbbaglantisi, $query);
    mysqli_close($dbbaglantisi);
    return $result;
}
function control_input($data){
    // $data = strip_tags($data);
    $data = htmlspecialchars($data);
    // $data = htmlentities($data);
    $data = stripslashes($data);

    return $data;
}
function kisaAciklama($aciklama, $limit){
    if (strlen($aciklama) > $limit) {
        echo substr($aciklama, 0, $limit) . "...";
    } else {
        echo $aciklama;
    }
    ;
}
function isLoggedIn(){
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
        return true;
    }else{
        return false;
    }
}
function isAdmin(){
    if (isLoggedIn() && isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin") {
        return true;
    }else{
        return false;
    }
}
function saveImage($file){
    $message = "";
    $uploadOk = 1;
    $fileTempPath = $file["tmp_name"];
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $maxFileSize = ((1024 * 1024) * 1);
    $dosyaUzantilari = array("jpg","jpeg","png");
    $uploadFolder = "./img/";

    if($fileSize > $maxFileSize){
        $message = "Dosya Boyutu Fazla.<br>";
        $uploadOk = 0;
    }
    $dosyaAdi_Arr = explode(".", $fileName);
    $dosyaAdi_Uzantisiz = $dosyaAdi_Arr[0];
    $dosyanınUzan = $dosyaAdi_Arr[1];

    if(!in_array($dosyanınUzan,$dosyaUzantilari)){
        $message .= " Dosya Uzantısı Kabul Edilemiyor. <br>";
        $message .= " Kabul Edilen Dosya Uzantıları: ".implode(", ", $dosyaUzantilari)."<br>";
        $uploadOk = 0;
    }

    $yeniDosyaAdi = md5(time().$dosyaAdi_Uzantisiz).'.'.$dosyanınUzan;
    $dest_path = $uploadFolder . $yeniDosyaAdi;

    if($uploadOk == 0){
        $message .= "Dosya Yüklenemedi<br>";
    }else{
        if(move_uploaded_file($fileTempPath, $dest_path)){
            $message .= "Dosya Başarıyla Yüklendi<br>";
        }
    }
    
    return array(
        "isSuccess" => $uploadOk,
        "message" => $message,
        "image" => $yeniDosyaAdi
    );
}
?>