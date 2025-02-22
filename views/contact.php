

	<!-- Start Banner Area -->
	<section class="bg-section">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1 class="esp">Contact Us</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Contact</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Contact Area =================-->
<section class="contact_area section_gap_bottom">
    <div class="container">
        <!-- Google Map -->
        <div class="mb-4" style="height: 400px;">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2631.9876406248263!2d2.409561115674903!3d48.669563179268616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e5d84e5c5cfd97%3A0x6df5aeec3c29be9f!2sDomaine%20de%20Villiers%2C%2091200%20Draveil%2C%20France!5e0!3m2!1sfr!2sfr!4v1615191789938!5m2!1sfr!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="row">
            <!-- Informations de Contact -->
            <div class="col-lg-4">
                <div class="contact_info">
                    <div class="info_item">
                        <i class="lnr lnr-home"></i>
                        <h6>Domaine de villier</h6>
                        <p>Draveil</p>
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-phone-handset"></i>
                        <h6><a href="tel:+14409865562">+1 (440) 9865 562</a></h6>
                        <!-- <p>Mon to Fri 9am to 6 pm</p> -->
                    </div>
                    <div class="info_item">
                        <i class="lnr lnr-envelope"></i>
                        <h6><a href="mailto:support@colorlib.com">support@colorlib.com</a></h6>
                        <p>Send us your query anytime!</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire de Contact -->
            <div class="col-lg-8">
                <form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                    <div class="col-md-6 form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>
                    <div class="col-md-6 form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" required>
                        <div class="invalid-feedback">Please enter a subject.</div>
                    </div>
                    <div class="col-md-12 form-group">
                        <textarea class="form-control" name="message" id="message" rows="4" placeholder="Enter Message" required></textarea>
                        <div class="invalid-feedback">Please enter your message.</div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" value="submit" class="primary-btn">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--================End Contact Area =================-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Validation Bootstrap 5
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.contact_form');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Envoi du formulaire via Ajax
    $('#contactForm').on('submit', function(event) {
        event.preventDefault();
        
        // Récupération des données du formulaire
        var formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            subject: $('#subject').val(),
            message: $('#message').val()
        };

        // Envoi des données avec Ajax
        $.ajax({
            type: 'POST',
            url: 'contact_process.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Message envoyé avec succès.');
                    $('#contactForm')[0].reset();
                } else {
                    alert('Erreur lors de l\'envoi du message.');
                }
            },
            error: function() {
                alert('Une erreur s\'est produite. Veuillez réessayer.');
            }
        });
    });
});
</script>
