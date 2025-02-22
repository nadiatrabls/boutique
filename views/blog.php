

    <!-- Start Banner Area -->
    <section class="bg-section">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1 class="esp">Blog Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Blog</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->



    <section class="blog_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog_left_sidebar">
                    <!-- On utilise maintenant $produits -->
                    <?php if (!empty($produits)): ?>
                        <?php foreach ($produits as $produit): ?>
                            <article class="row blog_item">
                                <div class="col-md-3">
                                    <div class="blog_info text-right">
                                        <ul class="blog_meta list">
                                            <li><i class="lnr lnr-calendar-full"></i> <?= date('d M, Y', strtotime($produit->date_creation)) ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="blog_post">
                                        <img src="img/product/<?= htmlspecialchars($produit->image); ?>" alt="<?= htmlspecialchars($produit->nom); ?>">
                                        <div class="blog_details">
                                        <a href="index.php?url=single-blog&id=<?= $produit->id; ?>">
    <h2><?= htmlspecialchars($produit->nom); ?></h2>
</a>
<p>Bienvenue dans l’univers d’Estelle Mercier, où chaque bijou est une création unique alliant artisanat et bienfaits des pierres naturelles. Nos bijoux sont fabriqués avec des matériaux de qualité supérieure, soigneusement sélectionnés pour leurs vertus énergétiques et thérapeutiques.

<br>    Que vous cherchiez un bracelet en améthyste apaisante, une pierre de labradorite protectrice, ou un collier en quartz rose pour attirer l’amour, nous avons la pièce qui vous accompagnera au quotidien.</p>

                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun produit trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
           

                </div>
            </div>
        </div>
    </div>
</section>
