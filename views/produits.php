<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Shop page</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="/produits">shop<span class="lnr lnr-arrow-right"></span></a>
                    
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- End Banner Area -->
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    <?php foreach($categories as $categorie): ?>
                        <li class="main-nav-list">
                            <a data-toggle="collapse" href="#categorie-<?php echo $categorie->id; ?>" aria-expanded="false" aria-controls="categorie-<?php echo $categorie->id; ?>">
                                <span class="lnr lnr-arrow-right"></span><?php echo $categorie->nom; ?>
                            </a>
                            <ul class="collapse" id="categorie-<?php echo $categorie->id; ?>">
                                <?php foreach($sousCategories as $sousCategorie): ?>
                                    <?php if($sousCategorie->categorie_id == $categorie->id): ?>
                                        <li class="main-nav-list child">
                                            <a href="produits.php?sous-categorie=<?php echo $sousCategorie->id; ?>">
                                                <?php echo $sousCategorie->nom; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- Filtres Produits -->
            <div class="sidebar-filter mt-50">
                <div class="top-filter-head">Product Filters</div>
				<div class="common-filter">
    <div class="head">Pierres</div>
    <form action="#" method="GET">
        <ul>
            <?php if (!empty($pierres) && is_array($pierres)): ?>
                <?php foreach($pierres as $pierre): ?>
                    <li class="filter-list">
                        <input class="pixel-radio" type="radio" id="pierre-<?php echo strtolower(str_replace(' ', '-', htmlspecialchars($pierre->nom, ENT_QUOTES, 'UTF-8'))); ?>" name="pierre" value="<?php echo htmlspecialchars($pierre->nom, ENT_QUOTES, 'UTF-8'); ?>">
                        <label for="pierre-<?php echo strtolower(str_replace(' ', '-', htmlspecialchars($pierre->nom, ENT_QUOTES, 'UTF-8'))); ?>">
                            <?php echo ucfirst(htmlspecialchars($pierre->nom, ENT_QUOTES, 'UTF-8')); ?> <span>(<?php echo intval($pierre->count); ?>)</span>
                        </label>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune pierre trouvée.</p>
            <?php endif; ?>
        </ul>
    </form>


                        
                    </form>
                </div>
                <div class="common-filter">
                    <div class="head">Color</div>
                    <form action="#" method="GET">
                        <ul>
                            <?php foreach($couleurs as $couleur): ?>
                                <li class="filter-list">
    <input class="pixel-radio" type="radio" id="color-<?php echo $couleur->nom; ?>">
    <label for="color-<?php echo $couleur->nom; ?>">
        <?php echo $couleur->nom; ?> <span>(<?php echo $couleur->count; ?>)</span>
    </label>
</li>
                            <?php endforeach; ?>
                        </ul>
                    </form>
                </div>
                <div class="common-filter">
                    <div class="head">Price</div>
                    <form action="#" method="GET">
                        <input type="range" min="1" max="50" step="1" name="price" value="<?php echo isset($_GET['price']) ? $_GET['price'] : 50; ?>">
                        <span>1€ - 50€</span>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
		<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting">
						<select>
							<option value="1">Default sorting</option>
							<option value="1">Default sorting</option>
							<option value="1">Default sorting</option>
						</select>
					</div>
					<div class="sorting mr-auto">
						<select>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
						</select>
					</div>
					<div class="pagination">
						<a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
    <div class="row">
        <?php if(empty($touslesproduits)): ?>
            <p>Aucun produit trouvé pour cette catégorie.</p>
        <?php else: ?>
            <?php foreach($touslesproduits as $produit): ?>
                <div class="col-lg-4 col-md-6">
    <div class="single-product">
        <a href="/single-product?id=<?php echo $produit->id; ?>" class="product-image">
            <img src="img/product/<?php echo htmlspecialchars($produit->image, ENT_QUOTES, 'UTF-8'); ?>" 
                 alt="<?php echo htmlspecialchars($produit->nom, ENT_QUOTES, 'UTF-8'); ?>">
        </a>
        <div class="product-details">
            <h6><a href="/single-product?id=<?php echo $produit->id; ?>">
                <?php echo htmlspecialchars($produit->nom, ENT_QUOTES, 'UTF-8'); ?>
            </a></h6>
          

            <div class="price">
                <h6><?php echo number_format($produit->prix, 2); ?>€</h6>
                <h6 class="l-through"><?php echo number_format($produit->prix * 1.2, 2); ?>€</h6>
            </div>
            <div class="prd-bottom">
                <a href="#" class="social-info">
                    <span class="ti-bag"></span>
                    <p class="hover-text">add to bag</p>
                </a>
                <a href="#" class="social-info">
                    <span class="lnr lnr-heart"></span>
                    <p class="hover-text">Wishlist</p>
                </a>
                <a href="#" class="social-info">
                    <span class="lnr lnr-sync"></span>
                    <p class="hover-text">compare</p>
                </a>
                <a href="#" class="social-info">
                    <span class="lnr lnr-move"></span>
                    <p class="hover-text">view more</p>
                </a>
            </div>
        </div>
    </div>
</div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<!-- End Best Seller -->
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="sorting mr-auto">
						<select>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
							<option value="1">Show 12</option>
						</select>
					</div>
					<div class="pagination">
						<a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
						<a href="#">6</a>
						<a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
					</div>
				</div>
				<!-- End Filter Bar -->
        </div>
    </div>
</div>

<!-- Start related-product Area -->
<section class="related-product-area section_gap">
    <div class="container-fluid"> <!-- Utilisation de container-fluid pour pleine largeur -->
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Autres Produits</h1>
                    <p>Découvrez notre sélection d'autres articles disponibles.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <?php foreach ($autresProduits as $produit): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4"> <!-- Largeur ajustée pour bon affichage -->
                    <div class="single-related-product d-flex flex-column align-items-center">
                        <a href="index.php?url=single-product&id=<?= $produit->id ?>">
                            <img src="img/product/<?= htmlspecialchars($produit->image) ?>" 
                                 alt="<?= htmlspecialchars($produit->nom) ?>" 
                                 class="img-fluid rounded" 
                                 style="width: 100%; height: 250px; object-fit: cover;">
                        </a>
                        <div class="desc text-center mt-2">
                            <a href="index.php?url=single-product&id=<?= $produit->id ?>" class="title"><?= htmlspecialchars($produit->nom) ?></a>
                            <div class="price">
                                <h6><?= number_format($produit->prix, 2, ',', ' ') ?> €</h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End related-product Area -->





	<!-- Modal Quick Product View -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="container relative">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="product-quick-view">
					<div class="row align-items-center">
						<div class="col-lg-6">
							<div class="quick-view-carousel">
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="quick-view-content">
								<div class="top">
									<h3 class="head">Mill Oil 1000W Heater, White</h3>
									<div class="price d-flex align-items-center"><span class="lnr lnr-tag"></span> <span class="ml-10">$149.99</span></div>
									<div class="category">Category: <span>Household</span></div>
									<div class="available">Availibility: <span>In Stock</span></div>
								</div>
								<div class="middle">
									<p class="content">Mill Oil is an innovative oil filled radiator with the most modern technology. If you are
										looking for something that can make your interior look awesome, and at the same time give you the pleasant
										warm feeling during the winter.</p>
									<a href="#" class="view-full">View full Details <span class="lnr lnr-arrow-right"></span></a>
								</div>
								<div class="bottom">
									<div class="color-picker d-flex align-items-center">Color:
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
									</div>
									<div class="quantity-container d-flex align-items-center mt-15">
										Quantity:
										<input type="text" class="quantity-amount ml-15" value="1" />
										<div class="arrow-btn d-inline-flex flex-column">
											<button class="increase arrow" type="button" title="Increase Quantity"><span class="lnr lnr-chevron-up"></span></button>
											<button class="decrease arrow" type="button" title="Decrease Quantity"><span class="lnr lnr-chevron-down"></span></button>
										</div>

									</div>
									<div class="d-flex mt-20">
										<a href="#" class="view-btn color-2"><span>Add to Cart</span></a>
										<a href="#" class="like-btn"><span class="lnr lnr-layers"></span></a>
										<a href="#" class="like-btn"><span class="lnr lnr-heart"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
	.single-related-product img, 
.product-item img {
    width: 100%; /* Ajuste la largeur à la colonne */
    height: auto; /* Garde le ratio aspect */
    max-height: 200px; /* Ajuste selon ton design */
    object-fit: cover; /* Coupe l'image pour l'adapter à la taille */
    display: block; /* Supprime l'espace blanc sous les images */
    border-radius: 5px; /* Arrondit les bords pour un meilleur visuel */
}

</style>

