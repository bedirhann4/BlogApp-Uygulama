<?php
$categoyId = ""; $keyword = ""; $page = 1;
if(isset($_GET["categoryid"]) && is_numeric($_GET["categoryid"])){
    $categoyId = $_GET["categoryid"];
}
if(isset($_GET["question"])){
    $keyword = $_GET["question"];
}
if(isset($_GET["page"]) && is_numeric($_GET["page"])){
    $page = $_GET["page"]; }
$result = getBlogByFilters($categoyId, $keyword, $page); ?>
<?php if(mysqli_num_rows($result["data"]) > 0): ?>
    <?php while($film = mysqli_fetch_assoc($result["data"])): ?>
        <?php if($film["isActive"] && $film["isHome"]): ?>
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-3">
                                <img class="img-fluid" src="img/<?php echo $film["imageUrl"] ?>">
                            </div>
                            <div class="col-9">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="blog-details.php?id=<?php echo $film["id"] ?>">
                                            <?php echo htmlspecialchars_decode($film["title"]) ?>
                                        </a></h5>
                                    <p class="card-text">
                                        <?php echo kisaAciklama(htmlspecialchars_decode($film['short_description']), 200); ?>
                                    </p>
                                    <h6><?php
                                            $sonuc = getCategoriesByBlogId($film["id"]);

                                            if (mysqli_num_rows($sonuc) > 0) {
                                                while($deger = mysqli_fetch_assoc($sonuc)){
                                                    echo "<li>".$deger["name"]."</li>";
                                                }
                                            }else{
                                                echo "<li>Kategori Seçilmedi</li>";
                                            }
                                    ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php else: ?>
            <div class="alert alert-warning">
                Film bulunamadı
            </div>
<?php endif; ?>
<?php if($result["total_page"] > 1): ?>
    <nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php for ($i=1; $i <= $result["total_page"]; $i++): ?>
            <li class="page-item <?php if ($i == $page) {
                echo "active";} ?>"><a class="page-link" href="
                <?php
                    $url = "?page=".$i;
                    if(!empty($categoyId)){
                        $url .= "&categoryid=".$categoyId;
                    }
                    if(!empty($keyword)){
                        $url .= "&question=".$keyword;
                    }
                    echo $url;
                ?>
            "><?php echo $i ?></a></li>
        <?php endfor; ?>
    </ul>
    </nav>
<?php endif; ?>