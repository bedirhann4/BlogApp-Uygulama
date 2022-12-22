<?php  
    require "libs/vars.php";
    require "libs/functions.php";

    $id = $_GET["id"];
    if(deleteCategory($id)){
        header("Location: admin-categories.php?dlt=success");
    }else {
        echo "Hata";
    }

   


?>