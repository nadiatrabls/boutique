<!--================Order Details Area =================-->
<section class="order_details section_gap">
    <div class="container">
        <h3 class="title_confirmation">Merci pour votre commande !</h3>
        <p class="text-center">Votre commande a été reçue et sera traitée sous peu.</p>
        
        <div class="row order_d_inner">
            <div class="col-lg-4">
                <div class="details_item">
				<h4>Informations sur la commande</h4>
<ul class="list">
    <li><span>Numéro de commande :</span> <?= htmlspecialchars($order->numero_commande ?? 'N/A'); ?></li>
    <li><span>Date :</span> <?= isset($order->date_commande) ? date('d M, Y', strtotime($order->date_commande)) : 'N/A'; ?></li>
    <li><span>Total :</span> <?= number_format($order->total ?? 0, 2, ',', ' '); ?> €</li>
    <li><span>Méthode de paiement :</span> <?= htmlspecialchars($order->methode_paiement ?? 'N/A'); ?></li>
</ul>


                </div>
            </div>
            <div class="col-lg-4">
			<div class="details_item">
    <h4>Adresse de facturation</h4>
    <ul class="list">
        <li><span>Nom :</span> <?= htmlspecialchars($billing->nom); ?></li>
        <li><span>Prénom :</span> <?= htmlspecialchars($billing->prenom); ?></li>
        <li><span>Adresse :</span> <?= htmlspecialchars($billing->adresse); ?></li>
        <li><span>Téléphone :</span> <?= htmlspecialchars($billing->telephone); ?></li>
        <li><span>Email :</span> <?= htmlspecialchars($billing->email); ?></li>
    </ul>
</div>

            </div>
            <div class="col-lg-4">
			<div class="details_item">
    <h4>Adresse de livraison</h4>
    <ul class="list">
        <li><span>Nom :</span> <?= htmlspecialchars($shipping->nom); ?></li>
        <li><span>Prénom :</span> <?= htmlspecialchars($shipping->prenom); ?></li>
        <li><span>Adresse :</span> <?= htmlspecialchars($shipping->adresse); ?></li>
        <li><span>Téléphone :</span> <?= htmlspecialchars($shipping->telephone); ?></li>
        <li><span>Email :</span> <?= htmlspecialchars($shipping->email); ?></li>
    </ul>
</div>

            </div>
        </div>
        
        <div class="order_details_table">
            <h2>Détails de la commande</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produit</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td>
                                <div class="media">
                                    <img class="mr-3" src="img/product/<?= htmlspecialchars($item->image); ?>" alt="<?= htmlspecialchars($item->nom); ?>" style="width: 50px;">
                                    <div class="media-body">
                                        <p><?= htmlspecialchars($item->nom); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>x <?= $item->quantite; ?></h5>
                            </td>
                            <td>
                                <p><?= number_format($item->prix * $item->quantite, 2, ',', ' '); ?> €</p>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
    <td>
        <h4>SOUS-TOTAL</h4>
    </td>
    <td>
        <h5></h5>
    </td>
    <td>
        <p><?= number_format($sous_total, 2, ',', ' '); ?> €</p>
    </td>
</tr>
<tr>
    <td>
        <h4>LIVRAISON</h4>
    </td>
    <td>
        <h5></h5>
    </td>
    <td>
        <p><?= number_format($livraison, 2, ',', ' '); ?> €</p>
    </td>
</tr>
<tr>
    <td>
        <h4>TOTAL</h4>
    </td>
    <td>
        <h5></h5>
    </td>
    <td>
        <p><?= number_format($sous_total + $livraison, 2, ',', ' '); ?> €</p>
    </td>
</tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Order Details Area =================-->
