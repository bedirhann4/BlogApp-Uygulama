<?php

function filmEkle(string $baslik, string $aciklama, string $resim, int $yorumSayisi=0,int $begeniSayisi=0,bool $vizyon=false) {
        
    $new_item[count($_SESSION["filmler"]) + 1] = array(
        "baslik" => $baslik,
        "aciklama" => $aciklama,
        "resim" => $resim,
        "yorumSayisi" => $yorumSayisi,
        "begeniSayisi" => $begeniSayisi,
        "vizyon" => $vizyon
    );

    $_SESSION["filmler"] = array_merge($_SESSION["filmler"], $new_item);

    foreach ($_SESSION["filmler"] as $key => $film) {
        $_SESSION["filmler"][$key]["url"] = strtolower($_SESSION["filmler"][$key]["baslik"]);
        $_SESSION["filmler"][$key]["url"] = str_replace([" ","ç"],["-","c"],$_SESSION["filmler"][$key]["url"]);
    }
}

function kisaAciklama($aciklama, $limit) {
    if (strlen($aciklama) > $limit) {
        echo substr($aciklama,0,$limit)."...";
    } else {
        echo $aciklama;
    };
}

?>