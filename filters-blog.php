<?php $result = getHomePageBlogs(); ?>

<?php if(mysqli_num_rows($result) > 0): ?>

    <?php while($film = mysqli_fetch_assoc($result)): ?>      
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
                                </div>
                            </div>
                        </div>
                    </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-warning">
        Film bulunamadı
    </div>
<?php endif; ?>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Önceki</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Sonraki</a></li>
  </ul>
</nav>