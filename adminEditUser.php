<?php  session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
    header("Location: /Activity%20Club/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>Admin Edit User </title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    
    

  </head>
  <body>  
    <!-- Left column -->
    <div class="templatemo-flex-row">
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
          <div class="square"></div>
          <h1><a href="index.php">Club Admin </a></h1>
        </header>
            
        
        <div class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
        </div>
        <nav class="templatemo-left-nav">          
          <ul>
            <li><a href="admin.php" ><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
            <li><a href="adminViewUsers.php" class="active"><i class="fa fa-users fa-fw"></i>Manage Users</a></li>
            <li><a href="adminViewGuide.php"><i class="fa fa-users fa-fw"></i>Manage Guides</a></li>
            <li><a href="adminMessages.php"><i class="fa fa-comments fa-fw"></i>Messages</a></li>
            <li><a href="adminViewEvents.php"><i class="fa fa-map-marker fa-fw"></i>Events</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">

<div class="container mt-5">
    <h1 style="text-align:center">Edit User</h1>

    <form id="editUserForm">
    <input type="hidden" id="email" name="email">

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="form-group">
        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" >
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <select class="form-control" id="gender" name="gender">
            <option value="Male" >Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div class="form-group">
        <label for="joiningDate">Joining Date:</label>
        <input type="date" class="form-control" id="joiningDate" name="joiningDate" >
    </div>
    <div class="form-group">
        <label for="mobile">Mobile:</label>
        <input type="tel" class="form-control" id="mobile" name="mobile">
    </div>
    <div class="form-group">
        <label for="emergencyNumber">Emergency Number:</label>
        <input type="tel" class="form-control" id="emergencyNumber" name="emergencyNumber">
    </div>
    <div class="form-group">
        <label for="profession">Profession:</label>
        <input type="text" class="form-control" id="profession" name="profession">
    </div>
    <div class="form-group">
        <label for="nationality">Nationality:</label>
        <input type="text" class="form-control" id="nationality" name="nationality">
    </div>
    <div class="form-group">
        <label for="role">Role:</label>
        <select class="form-control" id="role" name="role">
            <option value="0">Regular User</option>
            <option value="1">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" class="form-control-file" id="photo" name="photo">
    </div>

    <button type="submit" class="btn btn-primary">Update User</button>
</form>

</div>


                
</div>
      </div>
    </div>
    
    <!-- JS -->
    <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
    <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
    <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
    <script>
      /* Google Chart 
      -------------------------------------------------------------------*/
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});


      $(document).ready(function(){
        if($.browser.mozilla) {
          //refresh page on browser resize
          // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
          $(window).bind('resize', function(e)
          {
            if (window.RT) clearTimeout(window.RT);
            window.RT = setTimeout(function()
            {
              this.location.reload(false); /* false to get page from cache */
            }, 200);
          });      
        } else {
          $(window).resize(function(){
            drawChart();
          });  
        }
        var email = getUrlParameter('email');
        function getUrlParameter(name) {
            name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
            var results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
        $.ajax({
            url: '/Activity Club/api/userReadSingle.php',
            type: 'GET',
            data: { email: email },
            dataType: 'json',
            success: function (data) {
                $('#email').val(data.email);
                $('#name').val(data.name);
                $('#password').val(data.password);
                $('#dateOfBirth').val(data.dateOfBirth);
                $('#gender').val(data.gender);
                $('#joiningDate').val(data.joiningDate);
                $('#mobile').val(data.mobile);
                $('#emergencyNumber').val(data.emergencyNumber);
                $('#profession').val(data.profession);
                $('#nationality').val(data.nationality);
                $('#role').val(data.role);
                $('#photo').data('original-photo', data.photo);
            },
            error: function (xhr, status, error) {
        console.error('Error: ' + error);
            }
        });
        $('#editUserForm').submit(function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            if (!$('#photo').val() && $('#photo').data('original-photo')) {
                formData.set('photo', $('#photo').data('original-photo'));
            }
            $.ajax({
                url: '/Activity Club/api/userUpdate.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                alert(data.message);
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                    console.log(xhr.responseText); // Log the actual response content
                }
            });
        });
    });


    </script>
    <script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->

  </body>
</html>
