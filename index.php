<?php
include 'includes/header.php';
?>
<!-- =========================
     NAVIGATION LINKS     
============================== -->
<div class="navbar navbar-fixed-top custom-navbar" role="navigation">
	<div class="container">

		<!-- navbar header -->
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand">Activity Club</a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">
				<li><a href="#intro" class="smoothScroll">Intro</a></li>
				<li><a href="#overview" class="smoothScroll">Overview</a></li>
				<li><a href="#speakers" class="smoothScroll">Events</a></li>
				<?php if(isset($_SESSION['user_email'])){
					 		echo '<li><a href="profile.php" class="smoothScroll">Profile</a></li>'; 
						} 
						else{
							echo '<li><a href="#register" class="smoothScroll">Register</a></li>';
						}
				
				?>
				
				<li><a href="#contact" class="smoothScroll">Contact</a></li>
			</ul>

		</div>

	</div>
</div>


<!-- =========================
    INTRO SECTION   
============================== -->
<section id="intro" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<h1 class="wow fadeInUp" data-wow-delay="1.6s">WildHeart Adventures Club</h1>
				<a href="#overview" class="btn btn-lg btn-default smoothScroll wow fadeInUp hidden-xs" data-wow-delay="2.3s">LEARN MORE</a>
				<a href="#register" class="btn btn-lg btn-danger smoothScroll wow fadeInUp" data-wow-delay="2.3s">REGISTER NOW</a>
			</div>


		</div>
	</div>
</section>


<!-- =========================
    OVERVIEW SECTION   
============================== -->
<section id="overview" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="wow fadeInUp col-md-6 col-sm-6" data-wow-delay="0.6s">
				<h3>About WildHeart Adventures Club</h3>
				<p>At WildHeart Adventures Club, our mission is to inspire a love for nature, exploration, and camaraderie. We believe in creating a community where individuals can come together,
				embark on exciting journeys, and forge lasting memories.</p>
				<p> Whether you're a seasoned adventurer or a beginner, WildHeart welcomes everyone. Join our community, make new friends, and share the joy of exploration.</p>
			</div>
					
			<div class="wow fadeInUp col-md-6 col-sm-6" data-wow-delay="0.9s">
				<img src="images/about.jpeg" class="img-responsive" alt="Overview" style="height:300px">
			</div>

		</div>
	</div>
</section>


<!-- =========================
    DETAIL SECTION   
============================== -->
<section id="detail" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="wow fadeInLeft col-md-4 col-sm-4" data-wow-delay="0.3s">
				<i class="fa fa-group"></i>
				<h3>25 Participants</h3>
			</div>

			<div class="wow fadeInUp col-md-4 col-sm-4" data-wow-delay="0.6s">
				<i class="fa fa-clock-o"></i>
				<h3>20 Avtivities</h3>
			</div>

			<div class="wow fadeInRight col-md-4 col-sm-4" data-wow-delay="0.9s">
				<i class="fa fa-microphone"></i>
				<h3>11 guides</h3>
			</div>

		</div>
	</div>
</section>


<!-- =========================
    EVENTS SECTION   
============================== -->
<section id="speakers" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12 wow bounceIn">
				<div class="section-title">
					<h2>Amazing Activities</h2>
				</div>
			</div>
			
			<div id='eventPopupContent'> </div>
			<div id="owl-speakers" class="owl-carousel">
			
				<script>
					
					function enrollInEvent(eventId) {
    					var userEmail = <?php echo isset($_SESSION['user_email']) ? '"' . $_SESSION['user_email'] . '"' : 'null'; ?>;
    
    					$.ajax({
    					    url: '/Activity Club/api/eventEnroll.php',
    					    type: 'POST',
    					    data: {
    					        email: userEmail,
    					        eventid: eventId
    					    },
    					    dataType: 'json',
    					    success: function (response) {
    					        alert(response.message);
    					    },
    					    error: function (xhr, status, error) {
    					        console.error('Error:', xhr.responseText);
								alert('user not logged in')
    					    }
    					});
					}


					function showPopup(eventId) {
        				$.ajax({
            				url: `/Activity Club/api/eventReadSingle.php?eventid=${eventId}`,
            				type: 'GET',
            				dataType: 'json',
            				success: function (data) {
                				if (data.hasOwnProperty('eventid')) {
                    				var popupContent = `
										<img src="${data.photo}" class="img-responsive" alt="${data.description}" style="height:400px"> 
                        				<h2>${data.description}</h2>
                        				<p>Category: ${data.categories}</p>
										<p>Destination: ${data.destination}</p>
                        				<p>Date: ${data.dateFrom} to ${data.dateTo}</p>
                        				<p>Guides: ${data.guides}</p>
                        				<p>Status: ${data.status}</p>
										<button id="enrollButton-${data.eventid}" data-eventid="${data.eventid}">Enroll</button>
                    				`;
                    				$('#eventPopupContent').html(popupContent);
									document.getElementById(`enrollButton-${data.eventid}`).addEventListener('click', function () {
    									const eventId = this.getAttribute('data-eventid');
    									enrollInEvent(eventId);
									});
                				} else {
                    				console.log('Event not found.');
                				}
            				},
            				error: function (xhr, status, error) {
                				console.error('Error fetching event details:', error);
            				}
        				});
    				}
					document.addEventListener('DOMContentLoaded', function() {
					fetch('/Activity Club/api/eventReadBrief.php')

    				.then(response => response.json())
    				.then(data => {
      					if (data.hasOwnProperty('data') && data.data.length > 0) {
        					const container = document.getElementById('owl-speakers');
        					data.data.forEach(event => {
         					const eventHTML = `
            				<div class="item wow fadeInUp col-md-3 col-sm-3" data-wow-delay="0.6s" data-eventid="${event.eventid}">
              				<div class="speakers-wrapper">
                			<img src="${event.photo}" class="img-responsive" alt="${event.description}">
                			<div class="speakers-thumb">
                  			<h3>${event.description}</h3>
                  			<h6>${event.status}</h6>
                			</div>
            				</div>
            				</div>
          					`;
          					container.insertAdjacentHTML('beforeend', eventHTML);  
        				});
						document.querySelectorAll('.item').forEach(item => {
                    item.addEventListener('click', function () {
                        const eventId = this.getAttribute('data-eventid');
                        showPopup(eventId);
                    });
                });
      					} else {
        					console.log('No events found.');
						}
    				})
    				.catch(error => {
      					console.error('Error fetching events:', error);
    				});
					
				});
				</script>
				
			</div>

		</div>
	</div> 
</section>



<!-- =========================
   REGISTER SECTION   
============================== -->
<section id="register" class="parallax-section">
	<div class="container">
		<div class="row">

		<div id="loginForm" style="display:none; text-align:center">
			<div class="wow fadeInUp col-md-6 col-md-offset-3">
				<form id="loginForm" method="post">
				<input name="email" type="email" class="form-control" placeholder="Email Address" required>
				<input name="password" type="password" class="form-control" placeholder="Password" required>

				<div class="col-md-offset-6 col-md-6 col-sm-offset-1 col-sm-10">
					<input name="submit" type="submit" class="form-control" value="LOGIN">
				</div>
				</form>
				<div class="col-md-12" style="text-align: center; margin-top: 20px;">
					 <p>Don't have an account? <a href="#register" onclick="showRegistrationForm()">Register</a></p>
				</div>
			</div>
		</div>


		<div id="registrationForm" style="display:none; text-align:center">
			<div class="wow fadeInUp col-md-6 col-md-offset-3" >
				<form id="registerForm" method="post" enctype="multipart/form-data">
					<input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required>
					<input name="email" type="email" class="form-control" id="email" placeholder="Email Address" required>
					<input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
					<input name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
					<input name="dateOfBirth" type="date" class="form-control" id="dateOfBirth" placeholder="Date of Birth" required>
					<select name="gender" class="form-control" id="gender" required>
						<option value="Male" style="color:black">Male</option>
						<option value="Female" style="color:black">Female</option>
					</select>
					<input name="mobile" type="tel" class="form-control" id="mobile" placeholder="Mobile Number" required>
					<input name="emergencyNumber" type="tel" class="form-control" id="emergencyNumber" placeholder="Emergency Number" required>
					<input name="photo" type="file" class="form-control" id="photo" accept="image/*" placeholder="Profile Photo" required>
					<input name="profession" type="text" class="form-control" id="profession" placeholder="Profession" required>
					<input name="nationality" type="text" class="form-control" id="nationality" placeholder="Nationality" required>

					<div class="col-md-offset-6 col-md-6 col-sm-offset-1 col-sm-10">
						 <input name="submit" type="submit" class="form-control" id="submit" value="REGISTER">
					</div>
				  </form>
				  <div class="col-md-12" style="text-align: center; margin-top: 20px;">
                <p>Already have an account? <a href="#register" onclick="showLoginForm()">Login</a></p>
            </div>
			</div>
			</div>
		    <div id="initialView">
			<div class="wow fadeInUp col-md-7 col-sm-7" data-wow-delay="0.6s">
				<h2>Register Here</h2>
				<h3>Welcome to the Adventure Club, where thrilling experiences and unforgettable moments await you!</h3>
				<p> By registering with us, you gain exclusive access to a myriad of outdoor activities, ranging from breathtaking mountain climbs to serene nature hikes and exhilarating water sports. Whether you're an avid adventurer seeking new challenges or a nature enthusiast eager to connect with like-minded individuals, our club offers a diverse range of events tailored to your interests. Join our community of passionate members.</p>
			</div>

			<div class="wow fadeInUp col-md-5 col-sm-5" style="padding-top:90px" data-wow-delay="1s">
			<button class="col-md-offset-6 col-md-6 col-sm-offset-1 col-sm-10" onclick="showRegistrationForm()"> Register </a>
			<button class="col-md-offset-6 col-md-6 col-sm-offset-1 col-sm-10" onclick="showLoginForm()"> Login </a>
			</div>
			</div>
			
			

			<div class="col-md-1"></div>

		</div>
	</div>
</section>


<!-- =========================
    CONTACT SECTION   
============================== -->
<section id="contact" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="wow fadeInUp col-md-offset-1 col-md-5 col-sm-6" data-wow-delay="0.6s">
				<div class="contact_des">
					<h3>New Event</h3>
					<p>Have questions, suggestions, or just want to say hello? We'd love to hear from you!</p>
    				<p>Your feedback is valuable to us and helps us improve. Feel free to reach out through the form below, and we'll get back to you as soon as possible.</p>
    				<p>Thank you for connecting with us!</p>
				</div>
			</div>

			<div class="wow fadeInUp col-md-5 col-sm-6" data-wow-delay="0.9s">
				<div class="contact_detail">
					<div class="section-title">
						<h2>Keep in touch</h2>
					</div>
					<form id="contactForm" method="post">
    <input name="name" type="text" class="form-control"  placeholder="Name" required>
    <input name="email" type="email" class="form-control"  placeholder="Email" required>
    <textarea name="message" rows="5" class="form-control" placeholder="Message" reuired></textarea>
    <div class="col-md-6 col-sm-10">
        <button type="submit" class="form-control" id="submitBtn">SEND</button>
    </div>
</form>

<script>
     document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        fetch('api/messageCreate.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            // You can perform additional actions here if needed
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>


				</div>
			</div>

		</div>
	</div>
</section>

<?php 
include 'includes/footer.php';
?>