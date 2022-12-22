<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "blogapp";

$dbbaglantisi = mysqli_connect($server, $username, $password, $database);
mysqli_set_charset($dbbaglantisi, "UTF8");
if(mysqli_connect_errno() > 0){
    die ("error: ".mysqli_connect_errno());
}



?>