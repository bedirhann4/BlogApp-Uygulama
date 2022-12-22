<?php

    require "libs/vars.php";
    require "libs/functions.php";
    
    if(!isset($_GET["id"]) or !is_numeric($_GET["id"])){
        header("Location: index.php");
    }
    
    $result = getBlogById($_GET["id"]);
    $blog = mysqli_fetch_assoc($result);

    if(!$blog){
        header("Location: index.php");
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
    <title>Film Detay | Blog App</title>
</head>
<body>
<?php include "views/_navbar.php"; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card p-1">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img class="img-fluid" src="img/<?php echo $blog["imageUrl"]; ?>" alt="<?php echo $blog["title"]; ?>">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars_decode($blog["title"]); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars_decode($blog["short_description"]); ?></p>
                            <hr>
                            <p class="card-text"><?php echo htmlspecialchars_decode($blog["description"]); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "views/_footer.php"; ?>