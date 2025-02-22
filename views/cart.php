<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Shopping Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=cart">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produit</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Total</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produitsPanier)): ?>
                            <?php foreach ($produitsPanier as $produit): ?>
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
                                        <div class="product_count">
                                            <input type="number" name="qty" data-id="<?= $produit->id; ?>" value="<?= $produit->quantite; ?>" min="1" class="input-text qty update-quantity">
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?= number_format((float)$produit->total, 2, ',', ' ') ?> €</h5>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger remove-from-cart" data-id="<?= $produit->id; ?>">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><h5>Total Général</h5></td>
                                <td>
                                    <h5><?= number_format((float)$totalGeneral, 2, ',', ' ') ?> €</h5>
                                </td>
                                <td></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Votre panier est vide.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Lien pour Passer à la Caisse -->
            <?php if (!empty($produitsPanier)): ?>
                <div class="d-flex justify-content-end">
                    <a href="index.php?url=checkout" class="primary-btn">Passer à la caisse</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Mise à jour de la quantité
    $('.update-quantity').on('change', function() {
        var produitId = $(this).data('id');
        var nouvelleQuantite = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'index.php?url=update-quantity',
            data: { produit_id: produitId, quantite: nouvelleQuantite },
            success: function(response) {
                location.reload();
            },
            error: function() {
                alert("Erreur lors de la mise à jour de la quantité.");
            }
        });
    });

    // Suppression d'un produit du panier
    $('.remove-from-cart').on('click', function() {
        var produitId = $(this).data('id');

        if (confirm("Voulez-vous vraiment supprimer ce produit du panier ?")) {
            $.ajax({
                type: 'POST',
                url: 'index.php?url=supprimer-du-panier',
                data: { produit_id: produitId },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert("Erreur lors de la suppression du produit.");
                }
            });
        }
    });
});
</script>                                                     
