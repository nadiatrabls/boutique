<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=register">Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Register Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="img/exclusive.jpg" alt="Register Image">
                    <div class="hover">
                        <h4>Already have an account?</h4>
                        <p>If you already have an account, please login to access your profile and order history.</p>
                        <a class="primary-btn" href="index.php?url=login">Log In</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Create an Account</h3>

                    <!-- 🔥 Affichage des erreurs -->
                    <?php if (isset($erreur)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreur); ?>
                        </div>
                    <?php endif; ?>

                    <!-- 🔥 Affichage du succès -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire d'inscription -->
                    <form class="row login_form" action="index.php?url=register" method="post" id="contactForm" novalidate="novalidate">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Register Box Area =================-->
