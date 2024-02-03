<footer>
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<p class="wow fadeInUp" data-wow-delay="0.6s">Copyright &copy; Mona
                    
                    | Design: <a rel="nofollow" href="http://www.templatemo.com/page/1" target="_parent">Templatemo</a></p>

				<ul class="social-icon">
					<li><a href="#" class="fa fa-facebook wow fadeInUp" data-wow-delay="1s"></a></li>
					<li><a href="#" class="fa fa-twitter wow fadeInUp" data-wow-delay="1.3s"></a></li>
					<li><a href="#" class="fa fa-dribbble wow fadeInUp" data-wow-delay="1.6s"></a></li>
					<li><a href="#" class="fa fa-behance wow fadeInUp" data-wow-delay="1.9s"></a></li>
					<li><a href="#" class="fa fa-google-plus wow fadeInUp" data-wow-delay="2s"></a></li>
				</ul>

			</div>
			
		</div>
	</div>
</footer>


<!-- Back top -->
<a href="#back-top" class="go-top"><i class="fa fa-angle-up"></i></a>

<!-- =========================
     SCRIPTS   
============================== -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.parallax.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>
<script>
    function showRegistrationForm() {
        $('#initialView').hide();
		$('#loginForm').hide();
        $('#registrationForm').show();
    }

    function showLoginForm() {
        $('#initialView').hide();
		$('#registrationForm').hide();
        $('#loginForm').show();
    }

    $(document).ready(function() {
    $('#registerForm').submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'api/userRegister.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                alert(data.message);
            },
            error: function(xhr, status, error) {
                alert(JSON.parse(xhr.responseText).message);
                window.location.href = '/Activity%20Club/index.php';
            }
        });
        var loginForm = document.getElementById('register');

        if (initialView) {
            initialView.style.display = 'none';
        }
    });
    $('#loginForm form').submit(function(event) {
        event.preventDefault(); 

        var formData = $(this).serialize(); 

        $.ajax({
            url: 'api/userLogin.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.role === 0) {
                    window.location.href = '/Activity Club/profile.php';
                } else{
                    window.location.href = '/Activity%20Club/admin.php';
                }
            },
            error: function(xhr, status, error) {
                alert(JSON.parse(xhr.responseText).message);
            }
        });
        var loginForm = document.getElementById('register');

        if (initialView) {
            initialView.style.display = 'none';
        }
    });

				
});

</script>
</body>
</html>