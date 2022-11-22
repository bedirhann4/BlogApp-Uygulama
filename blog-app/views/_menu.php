<?php $ozet = count($kategoriler).' kategoride '.count($filmler).'  film listelenmiştir';
?>
<ul class="list-group">
    <?php
        foreach ($kategoriler as $kategori) {
            echo '<li class="list-group-item"><a class="linkler" href="#">' . $kategori . '</a></li>';
        };
    ?>
</ul>