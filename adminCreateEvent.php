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
    <h1 style="text-align: center">Create Event</h1>

    <form id="createEventForm">
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="destination">Destination:</label>
            <input type="text" class="form-control" id="destination" name="destination" required>
        </div>
        <div class="form-group">
            <label for="dateFrom">Date From:</label>
            <input type="date" class="form-control" id="dateFrom" name="dateFrom" required>
        </div>
        <div class="form-group">
            <label for="dateTo">Date To:</label>
            <input type="date" class="form-control" id="dateTo" name="dateTo" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="status" required>
        </div>
        <div class="form-group">
            <label for="categories">Categories:</label>
            <input type="text" class="form-control" id="categories" name="categories" required>
            <small class="form-text text-muted">The categories shoulld be separated by ', '</small> 
        </div>
        <div class="form-group">
            <label for="guides">Guides:</label>
            <input type="text" class="form-control" id="guides" name="guides" required>
            <small class="form-text text-muted">The guides shoulld be separated by ', ' and write their emails instead of their names.</small>
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control-file" id="photo" name="photo" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
    $('#createEventForm').submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    $.ajax({
        url: 'api/eventCreate.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data) {
            if (data && data.message) {
                alert(data.message);
            } else {
                console.error('Unexpected response format:', data);
            }
        },
        error: function (xhr, status, error) {
            console.error('Ajax request failed. Status:', status, 'Error:', error);
            console.log(xhr.responseText);
        }
    });
});

});

</script>

</body>
</html>
