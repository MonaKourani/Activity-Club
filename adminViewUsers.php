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
    <title>Admin View User </title>
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
        <h1 style="text-align:center">User List</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Joining Date</th>
                    <th>Mobile</th>
                    <th>Emergency Number</th>
                    <th>Photo</th>
                    <th>Profession</th>
                    <th>Nationality</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '/Activity Club/api/userRead.php', 
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.message && data.message === 'No Users Found') {
                        $('#userTableBody').html('<tr><td colspan="14">No Users Found</td></tr>');
                    } else {
                        data.data.forEach(function (user) {
                            var row = '<tr data-email="' + user.email + '">' +
                                '<td>' + user.email + '</td>' +
                                '<td>' + user.name + '</td>' +
                                '<td>' + user.password + '</td>' +
                                '<td>' + user.dateOfBirth + '</td>' +
                                '<td>' + user.gender + '</td>' +
                                '<td>' + user.joiningDate + '</td>' +
                                '<td>' + user.mobile + '</td>' +
                                '<td>' + user.emergencyNumber + '</td>' +
                                '<td> <img src="' + user.photo + '" alt="User Photo" style="width: 50px; height: 50px;"></td>' +
                                '<td>' + user.profession + '</td>' +
                                '<td>' + user.nationality + '</td>' +
                                '<td>' + user.role + '</td>' +
                                '<td>' +
                                '<button class="btn btn-primary edit-btn" onclick="editUser(\'' + user.email + '\')">Edit</button>' +
                                '<button class="btn btn-success create-btn" onclick="deleteUser(\'' + user.email + '\')">Delete</button>' +
                                '</td>' +
                                '</tr>';
                            $('#userTableBody').append(row);
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        });

    </script>














<?php include 'includes/adminfooter.php'?>