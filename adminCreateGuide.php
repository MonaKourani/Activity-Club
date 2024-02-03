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
    <h1 style="text-align: center">Create Guide</h1>

    <form id="createGuideForm">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="dateOfBirth">Date of Birth:</label>
            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
        </div>
        <div class="form-group">
            <label for="profession">Profession:</label>
            <input type="text" class="form-control" id="profession" name="profession" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Guide</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#createGuideForm').submit(function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: 'api/guideCreate.php',
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
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>