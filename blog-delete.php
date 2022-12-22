<?php  
    require "libs/vars.php";
    require "libs/functions.php";

    $id = $_GET["id"];
    if(deleteBlog($id)){
        header("Location: admin-blogs.php?dlt=success");
    }else {
        echo "Hata";
    }

   


?>