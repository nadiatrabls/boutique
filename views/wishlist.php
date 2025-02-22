<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Favoris</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=wishlist">Favoris</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Wishlist Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produit</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produitsFavoris)): ?>
                            <?php foreach ($produitsFavoris as $produit): ?>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="img/product/<?= htmlspecialchars($produit->image); ?>" alt="<?= htmlspecialchars($produit->nom); ?>" style="width: 100px;">
                                            </div>
                                            <div class="media-body">
                                                <p><?= htmlspecialchars($produit->nom); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?= number_format((float)$produit->prix, 2, ',', ' ') ?> €</h5>
                                    </td>
                                    <td>
                                        <a href="index.php?url=single-product&id=<?= $produit->id; ?>" class="btn btn-primary">Voir Plus</a>
                                        <button class="btn btn-danger remove-from-favorites" data-id="<?= $produit->id; ?>">Retirer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Aucun produit dans vos favoris.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Wishlist Area =================-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Suppression d'un produit des favoris
    $('.remove-from-favorites').on('click', function() {
        var produitId = $(this).data('id');

        if (confirm("Voulez-vous vraiment retirer ce produit de vos favoris ?")) {
            $.ajax({
                type: 'POST',
                url: 'index.php?url=supprimer-des-favoris',
                data: { produit_id: produitId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert('Produit retiré des favoris.');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression des favoris.');
                    }
                },
                error: function() {
                    alert("Erreur lors de la requête.");
                }
            });
        }
    });
});
</script>
