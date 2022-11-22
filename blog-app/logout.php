<?php  
    setcookie("auth[kullaniciadi]", "", time()-3600);
    setcookie("auth[name]", "", time()-3600);
    header("Location: login.php");
?>