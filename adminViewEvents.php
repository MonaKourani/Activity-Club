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
    <title>Admin </title>
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
            <li><a href="adminViewGuide.php"><i class="fa fa-users fa-fw"></i>Manage Guides</a></li>
            <li><a href="adminMessages.php"><i class="fa fa-comments fa-fw"></i>Messages</a></li>
            <li><a href="adminViewEvents.php" class="active"><i class="fa fa-map-marker fa-fw"></i>Events</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
<div class="container mt-5">
    <h1 style="text-align:center">Events</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Description</th>
                <th>Destination</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Status</th>
                <th>Categories</th>
                <th>Guides</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="eventTableBody"></tbody>
    </table>
    <a href="adminCreateEvent.php"> Create Event </a>
</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchEvents() {
            $.ajax({
                url: '/Activity Club/api/eventRead.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var eventTableBody = $('#eventTableBody');

                    eventTableBody.empty();

                    data.data.forEach(function (event) {
                        var row = '<tr>' +
                            '<td><a href="adminEnrolledUser.php?eventid=' + event.eventid + '">' + event.eventid + '</a></td>'  +
                            '<td>' + event.description + '</td>' +
                            '<td>' + event.destination + '</td>' +
                            '<td>' + event.dateFrom + '</td>' +
                            '<td>' + event.dateTo + '</td>' +
                            '<td>' + event.status + '</td>' +
                            '<td>' + event.categories + '</td>' +
                            '<td>' + event.guides + '</td>' +
                            '<td><img src="' + event.photo + '" alt="Event Photo" style="max-width: 100px; max-height: 100px;"></td>' +
                            '<td>' +
                            '<a href="adminUpdateEvent.php?eventid=' + event.eventid + '" class="btn btn-primary">Update</a>' +
                            '<button class="btn btn-danger btn-delete" data-eventid="' + event.eventid + '">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        eventTableBody.append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        }

        fetchEvents();

        $('#eventTableBody').on('click', '.btn-delete', function () {
            var eventId = $(this).data('eventid');

            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '/Activity Club/api/eventDelete.php?eventid=' + eventId,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (data) {
                        alert(data.message);
                        fetchEvents();
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
