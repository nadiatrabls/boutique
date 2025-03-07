<!-- Start Banner Area -->
<section class="bg-section">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1 class="esp">Login/Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="index.php?url=login">Login/Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <!-- Image de connexion -->
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="img/exclusive.jpg" alt="Login Image">
                    <div class="hover">
                        <h4>New to our website?</h4>
                        <p>Join us today and discover a world of amazing products!</p>
                        <a class="primary-btn" href="index.php?url=register">Create an Account</a>
                    </div>
                </div>
            </div>

            <!-- Formulaire de connexion -->
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>

                    <!-- 🔥 Affichage des erreurs -->
                    <?php if (isset($erreur)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($erreur); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire -->
                    <form class="row login_form" action="index.php?url=login" method="post" id="contactForm" novalidate="novalidate">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="keep_logged_in">
                                <label for="f-option2">Keep me logged in</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Log In</button>
                            <a href="#">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->
