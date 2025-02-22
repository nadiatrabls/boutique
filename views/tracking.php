<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Suivi de Livraison</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Accueil<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=order-tracking">Suivi de Livraison</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Tracking Box Area =================-->
<section class="tracking_box_area section_gap">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Pour suivre votre commande, veuillez entrer votre numéro de commande et votre adresse email de facturation ci-dessous, puis cliquez sur "Suivre".</p>
            <form class="row tracking_form" id="tracking-form" method="post">
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" id="order" name="order" placeholder="Numéro de commande" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Numéro de commande'">
                    <small class="text-danger d-none" id="order-error">Veuillez entrer un numéro de commande valide.</small>
                </div>
                <div class="col-md-12 form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Adresse Email de Facturation" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adresse Email de Facturation'">
                    <small class="text-danger d-none" id="email-error">Veuillez entrer une adresse email valide.</small>
                </div>
                <div class="col-md-12 form-group">
                    <button type="button" id="track-order" class="primary-btn">Suivre</button>
                </div>
            </form>

            <!-- Résultats du suivi -->
            <div class="tracking-result d-none">
                <h4>Statut de votre commande</h4>
                <ul class="progress-tracker">
                    <li class="step" data-step="1">
                        <span class="icon"><i class="fa fa-check-circle"></i></span>
                        <span class="text">Commande confirmée</span>
                    </li>
                    <li class="step" data-step="2">
                        <span class="icon"><i class="fa fa-box"></i></span>
                        <span class="text">Commande en préparation</span>
                    </li>
                    <li class="step" data-step="3">
                        <span class="icon"><i class="fa fa-truck"></i></span>
                        <span class="text">Commande expédiée</span>
                    </li>
                    <li class="step" data-step="4">
                        <span class="icon"><i class="fa fa-home"></i></span>
                        <span class="text">Commande livrée</span>
                    </li>
                </ul>
                <div class="tracking-message mt-3">
                    <p class="text-info">Votre commande est actuellement en cours de traitement.</p>
                </div>
            </div>

            <!-- Message d'erreur -->
            <div class="tracking-error d-none">
                <h4 class="text-danger">Commande introuvable</h4>
                <p>Veuillez vérifier votre numéro de commande et votre adresse email, puis réessayez.</p>
            </div>
        </div>
    </div>
</section>
<!--================End Tracking Box Area =================-->

<!-- Styles personnalisés pour le suivi -->
<style>
    .progress-tracker {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: space-between;
    }
    .progress-tracker .step {
        text-align: center;
        flex: 1;
    }
    .progress-tracker .step .icon {
        display: block;
        font-size: 30px;
        color: #ccc;
    }
    .progress-tracker .step.active .icon {
        color: #4CAF50;
    }
    .progress-tracker .step .text {
        display: block;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<!-- Script jQuery pour le suivi des commandes -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#track-order').on('click', function() {
        var order = $('#order').val().trim();
        var email = $('#email').val().trim();
        var valid = true;

        // Validation des champs
        if (order === '') {
            $('#order-error').removeClass('d-none');
            valid = false;
        } else {
            $('#order-error').addClass('d-none');
        }
        if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
            $('#email-error').removeClass('d-none');
            valid = false;
        } else {
            $('#email-error').addClass('d-none');
        }

        if (valid) {
            // Requête Ajax pour le suivi de la commande
            $.ajax({
                type: 'POST',
                url: 'index.php?url=track-order',
                data: { order_id: order, email: email },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'found') {
                        $('.tracking-error').addClass('d-none');
                        $('.tracking-result').removeClass('d-none');
                        $('.progress-tracker .step').removeClass('active');
                        res.steps.forEach(function(step) {
                            $('.progress-tracker .step[data-step="'+ step +'"]').addClass('active');
                        });
                        $('.tracking-message p').text(res.message);
                    } else {
                        $('.tracking-result').addClass('d-none');
                        $('.tracking-error').removeClass('d-none');
                    }
                },
                error: function() {
                    alert("Erreur lors du suivi de la commande. Veuillez réessayer plus tard.");
                }
            });
        }
    });
});
</script>
