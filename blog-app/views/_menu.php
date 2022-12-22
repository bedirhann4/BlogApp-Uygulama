<?php 
if(isset($_GET["categoryid"]) && is_numeric($_GET["categoryid"])){
    $selectedCategories = $_GET["categoryid"];
}
?>

<?php $ozet = count(getData()["categories"]).' kategoride '.count(getData()["movies"]).'  film listelenmiştir'; ?>
<ul>
    <a style="text-align: center; background: gray;" class="list-group-item list-group-item-action" href="blogs.php">Tüm Kategoriler</a>
<ul class="list-group">
    <?php $result = getCaregoriyByActive(); ?>
    <?php while($item = mysqli_fetch_assoc($result)): ?>
            <a style="background-color: <?php if(($selectedCategories)==$item["id"]){echo "gray";} ?>;" class="list-group-item list-group-item-action" href='<?php echo "blogs.php?categoryid=".$item["id"] ?>'>
                <?php echo $item["name"] ?>
            </a>
    <?php endwhile; ?>
</ul>