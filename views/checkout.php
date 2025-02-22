<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=checkout">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Informations de facturation</h3>
                    <form class="row contact_form" action="index.php?url=valider-commande" method="post" novalidate="novalidate">
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="adresse" placeholder="Adresse" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" name="telephone" placeholder="Téléphone" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <input type="hidden" name="total" value="<?= $totalGeneral ?>">
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Votre commande</h2>
                        <ul class="list">
                            <li><a href="#">Produit <span>Total</span></a></li>
                            <?php if (!empty($produitsPanier)): ?>
                                <?php foreach ($produitsPanier as $produit): ?>
                                    <li>
                                        <?= htmlspecialchars($produit->nom) ?> 
                                        <span class="middle">x <?= $produit->quantite; ?></span> 
                                        <span class="last"><?= number_format((float)$produit->total, 2, ',', ' ') ?> €</span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Aucun produit dans le panier.</li>
                            <?php endif; ?>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Total <span><?= number_format((float)$totalGeneral, 2, ',', ' ') ?> €</span></a></li>
                        </ul>
                        <div class="payment_item">
                            <div class="radion_btn">
                                <input type="radio" id="f-option5" name="payment_method" value="check" checked>
                                <label for="f-option5">Paiement par chèque</label>
                                <div class="check"></div>
                            </div>
                            <p>Veuillez envoyer un chèque à l'adresse suivante :...</p>
                        </div>
                        <div class="payment_item active">
                            <div class="radion_btn">
                                <input type="radio" id="f-option6" name="payment_method" value="paypal">
                                <label for="f-option6">Paypal </label>
                                <img src="img/product/card.jpg" alt="">
                                <div class="check"></div>
                            </div>
                            <p>Payer via PayPal ; vous pouvez utiliser votre carte bancaire si vous n'avez pas de compte PayPal.</p>
                        </div>
                        <button type="submit" class="primary-btn">Valider la commande</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->
