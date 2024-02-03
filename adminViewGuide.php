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
    <title>Admin Guides</title>
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
            <li><a href="adminViewUsers.php"><i class="fa fa-users fa-fw"></i>Manage Users</a></li>
            <li><a href="adminViewGuide.php" class="active"><i class="fa fa-users fa-fw"></i>Manage Guides</a></li>
            <li><a href="adminMessages.php"><i class="fa fa-comments fa-fw"></i>Messages</a></li>
            <li><a href="adminViewEvents.php"><i class="fa fa-map-marker fa-fw"></i>Events</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
<div class="container mt-5">
    <h1 style="text-align:center">Guides</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Profession</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="guideTableBody"></tbody>
    </table>
    <a href="adminCreateGuide.php"> Create Guide </a>
</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchGuides() {
            $.ajax({
                url: '/Activity Club/api/guideView.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var guideTableBody = $('#guideTableBody');

                    guideTableBody.empty();

                    data.data.forEach(function (guide) {
                        var row = '<tr>' +
                            '<td>' + guide.email + '</td>' +
                            '<td>' + guide.name + '</td>' +
                            '<td>' + guide.dateOfBirth + '</td>' +
                            '<td>' + guide.profession + '</td>' +
                            '<td>' +
                            '<a href="adminGuideUpdate.php?email=' + guide.email + '" class="btn btn-primary">Update</a>' +
                            '<button class="btn btn-danger btn-delete" data-email="' + guide.email + '">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        guideTableBody.append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }

        // Initial fetch and display guides
        fetchGuides();

        // Event delegation for dynamically added buttons
        $('#guideTableBody').on('click', '.btn-delete', function () {
            var guideEmail = $(this).data('email');

            // Confirm before deleting
            if (confirm('Are you sure you want to delete this guide?')) {
                $.ajax({
                    url: '/Activity Club/api/guideDelete.php?email=' + guideEmail,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (data) {
                        alert(data.message);
                        // Refresh guides after deletion
                        fetchGuides();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error: ' + error);
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<script type="text/javascript" src="js/templatemo-script.js"></script>      <!-- Templatemo Script -->

  </body>
</html>