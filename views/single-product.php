<?php if (!isset($produit)) { die("Produit introuvable."); } ?>

	<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Détails du Produit</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Accueil<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Boutique<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Produit - <?php echo htmlspecialchars($produit->nom); ?></a>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- End Banner Area -->

	<!--================Single Product Area =================-->
	<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_Product_carousel">
                    <div class="single-prd-item">
                        <img class="img-fluid" src="img/product/<?php echo htmlspecialchars($produit->image); ?>" alt="<?php echo htmlspecialchars($produit->nom); ?>">
                    </div>
					<div class="single-prd-item">
                        <img class="img-fluid" src="img/product/<?php echo htmlspecialchars($produit->image); ?>" alt="<?php echo htmlspecialchars($produit->nom); ?>">
                    </div>
					<div class="single-prd-item">
                        <img class="img-fluid" src="img/product/<?php echo htmlspecialchars($produit->image); ?>" alt="<?php echo htmlspecialchars($produit->nom); ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3><?php echo htmlspecialchars($produit->nom); ?></h3>
                    <h2><?php echo number_format($produit->prix, 2); ?>€</h2>
                    <ul class="list">
                        <li><span>Catégorie</span> : <?php echo isset($produit->categorie_nom) ? htmlspecialchars($produit->categorie_nom) : 'Non spécifiée'; ?></li>
                        <li><span>Disponibilité</span> : En Stock</li>
                    </ul>
                    <p><?php echo nl2br(htmlspecialchars($produit->description)); ?></p>
                    <div class="product_count">
                        <label for="qty">Quantité:</label>
                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                    </div>
					<div class="card_area d-flex align-items-center">
    <a class="primary-btn add-to-cart" data-id="<?= $produit->id; ?>" href="javascript:void(0);">Ajouter au Panier</a>
    <a class="icon_btn add-to-wishlist" data-id="<?= $produit->id; ?>" href="javascript:void(0);"><i class="lnr lnr-heart"></i></a>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
	<!--================End Single Product Area =================-->

	
	<!-- Start related-product Area -->
<section class="related-product-area section_gap_bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Autres Produits</h1>
                    <p>Découvrez nos autres créations uniques</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($autresProduits as $autreProduit): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                    <div class="single-related-product d-flex">
                        <!-- Image entourée par le lien -->
                        <a href="index.php?url=single-product&id=<?php echo $autreProduit->id; ?>">
                            <img src="img/product/<?php echo htmlspecialchars($autreProduit->image); ?>" alt="<?php echo htmlspecialchars($autreProduit->nom); ?>" style="width: 100px; height: auto;">
                        </a>
                        <div class="desc">
                            <a href="index.php?url=single-product&id=<?php echo $autreProduit->id; ?>" class="title"> 
                                <?php echo htmlspecialchars($autreProduit->nom); ?>
                            </a>
                            <div class="price">
                                <h6><?php echo number_format($autreProduit->prix, 2); ?>€</h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End related-product Area -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Ajouter au panier
    $('.add-to-cart').on('click', function() {
        var produitId = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'index.php?url=ajouter-au-panier',
            data: { produit_id: produitId, quantite: 1 },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    alert('Produit ajouté au panier avec succès.');
                } else {
                    alert('Erreur lors de l\'ajout au panier.');
                }
            },
            error: function() {
                alert('Erreur lors de la requête.');
            }
        });
    });

    // Ajouter aux favoris
    $('.add-to-wishlist').on('click', function() {
        var produitId = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'index.php?url=ajouter-aux-favoris',
            data: { produit_id: produitId },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    alert('Produit ajouté aux favoris.');
                } else {
                    alert('Erreur lors de l\'ajout aux favoris.');
                }
            },
            error: function() {
                alert('Erreur lors de la requête.');
            }
        });
    });
});
</script>


