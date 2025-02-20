<?php 
ob_start(); 

$templatePath = __DIR__ . '/../views/templates/template.php';
if (!file_exists($templatePath)) {
    die("Erreur : Le fichier template.php est introuvable. Vérifiez son emplacement.");
}
?>

<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Catégories</h1>
                <nav class="d-flex align-items-center">
                    <a href="/">Accueil <span class="lnr lnr-arrow-right"></span></a>
                    <a href="/produits">Boutique <span class="lnr lnr-arrow-right"></span></a>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <div class="row">
        <!-- Barre latérale des catégories -->
        <div class="col-lg-3">
            <h4 class="mb-3">Catégories</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="index.php?url=categorie" class="text-decoration-none font-weight-bold">Toutes les catégories</a>
                </li>
                <?php foreach ($categories as $categorie) : ?>
                    <li class="list-group-item">
                        <a href="index.php?url=categorie&id=<?= $categorie->id ?>" 
                           class="text-decoration-none">
                            <?= htmlspecialchars($categorie->nom) ?> (<?= $categorie->nombre_produits ?>)
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Affichage des produits -->
        <div class="col-lg-9">
            <h2 class="text-center mb-4">
                <?= isset($categorie_nom) ? htmlspecialchars($categorie_nom) : 'Toutes les catégories' ?>
            </h2>
            <div class="row">
                <?php if (!empty($produits)) : ?>
                    <?php foreach ($produits as $produit) : ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <a href="index.php?url=single-product&id=<?= $produit->id ?>">
                                    <img src="img/product/<?= !empty($produit->image) ? htmlspecialchars($produit->image) : 'default.jpg' ?>" 
                                         class="card-img-top img-fluid"
                                         alt="<?= htmlspecialchars($produit->nom) ?>"
                                         style="height: 250px; object-fit: cover;">
                                </a>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($produit->nom) ?></h5>
                                    <p class="card-text"><?= number_format($produit->prix, 2, ',', ' ') ?> €</p>
                                    <a href="index.php?url=single-product&id=<?= $produit->id ?>" class="btn btn-primary">Voir plus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center w-100">Aucun produit trouvé dans cette catégorie.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


