<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="CodeHim">
      <title> Profile </title>
      <link rel="stylesheet" href="./css/profilestyle.css">
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   </head>
   <body>
      <main class="cd__main">
         <div class="profile-page">
  <div class="content">
    <div class="content__cover">
      <div class="content__avatar"></div>
      <div class="content__bull"><span></span><span></span><span></span><span></span><span></span>
      </div>
    </div>
    <div class="content__actions"></div>
    <div class="content__title">
      <h1></h1><span></span>
    </div>
    <div class="content__description">
      <p></p>
      <p></p>
      <p> <h2>Enrolled Events: </h2></p>
    </div>
    
    <ul class="content__list">
      
    </ul>
    <div class="content__button"><a class="button" >
        <div class="button__border"></div>
        <div class="button__bg"></div>
        <p class="button__text" onclick="signout()">Sign Out</p></a></div>
  </div>
  <div class="bg">
    <div><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
  </div>
  <div class="theme-switcher-wrapper" id="theme-switcher-wrapper"><span>Themes color</span>
    <ul>
      <li><em class="is-active" data-theme="orange"></em></li>
      <li><em data-theme="green"></em></li>
      <li><em data-theme="purple"></em></li>
      <li><em data-theme="blue"></em></li>
    </ul>
  </div>
  <div class="theme-switcher-button" id="theme-switcher-button">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
      <path fill="currentColor" d="M352 0H32C14.33 0 0 14.33 0 32v224h384V32c0-17.67-14.33-32-32-32zM0 320c0 35.35 28.66 64 64 64h64v64c0 35.35 28.66 64 64 64s64-28.65 64-64v-64h64c35.34 0 64-28.65 64-64v-32H0v32zm192 104c13.25 0 24 10.74 24 24 0 13.25-10.75 24-24 24s-24-10.75-24-24c0-13.26 10.75-24 24-24z"></path>
    </svg>
  </div>
</div>
      </main>
      
      
      <!-- Script JS -->
      <script src="./js/script.js"></script>
      <script>
        function signout() {
            $.ajax({
                url: 'api/logout.php',
                type: 'POST', 
                dataType: 'json',
                success: function (response) {
                    console.log(response.message);
                    window.location.href = '../Activity Club/index.php';
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
          var userEmail = "<?php echo ($_SESSION['user_email']); ?>";
          
          $.ajax({
             url: 'api/userReadSingle.php',
             type: 'GET',
             data: { email: userEmail },
             dataType: 'json',
             success: function (userData) {
                $('.content__title h1').text(userData.name);
                var emailText = 'Email: ' + (userData.email ? userData.email : 'N/A');
                $('.content__title').append('<p>' + emailText + '</p>');
                $('.content__title span').text(userData.nationality + ', ' + userData.profession);
                $('.content__description p:first-child').text(userData.profession);
                var birthdayText = 'Birthday: ' + (userData.dateOfBirth ? userData.dateOfBirth : 'N/A');
                var joiningDateText = 'Joining Date: ' + (userData.joiningDate ? userData.joiningDate : 'N/A');
                $('.content__description p:nth-child(2)').html(birthdayText + '<br>' + joiningDateText);
                if (userData.photo) {
                $('.content__avatar').css('background', '#8f6ed5 url("' + userData.photo + '") center center no-repeat');
                $('.content__avatar').css('background-size', 'cover');
                $('.content__avatar').css('border-radius', '50%');
                $('.content__avatar').css('box-shadow', '0 15px 35px rgba(50,50,93,0.1), 0 5px 15px rgba(0,0,0,0.07)');
            }
             },
             error: function (xhr, status, error) {
                console.error('Error: ' + error);
             }
          });
          
          function getEnrolledEvents() {
            $.ajax({
                url: 'api/eventEnrolled.php',
                type: 'GET',
                data: { email: userEmail },
                dataType: 'json',
                success: function (enrolledEvents) {
                  enrolledEvents.forEach(function (event) {
                    var eventInfo = '<li>' +
                      '<strong>Description:</strong> ' + event.description +
                      '<br><strong>Destination:</strong> ' + event.destination +
                      '<br><strong>Date From:</strong> ' + event.dateFrom +
                      '<br><strong>Date To:</strong> ' + event.dateTo +
                      '<br><button class="unenroll-btn" data-eventid="' + event.eventid + '">Unenroll</button>' +
                      '</li>';
                    $('.content__list').append(eventInfo);
                  });
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
          }
          $('.content__list').on('click', '.unenroll-btn', function () {
            var eventid = $(this).data('eventid');
            unenrollEvent(eventid);
          });
          getEnrolledEvents();

          
        function unenrollEvent(eventid) {
          $.ajax({
              url: 'api/eventUnenroll.php',
              type: 'POST',
              data: { email: userEmail, eventid: eventid },
              dataType: 'json',
              success: function (response) {
                  console.log(response.message); $('[data-eventid="' + eventid + '"]').parent('li').remove();
              },
              error: function (xhr, status, error) {
                  console.error('Error: ' + error);
              }
          });
      }
      });
    </script>



   </body>
</html>