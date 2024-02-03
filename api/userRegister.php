<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

if (isset($_POST['email'])) {
    $user->email = $_POST['email'];
    $user->name = $_POST['name'];
    $user->password = $_POST['password'];
    $user->dateOfBirth = $_POST['dateOfBirth'];
    $user->gender = $_POST['gender'];
    $user->mobile = $_POST['mobile'];
    $user->emergencyNumber = $_POST['emergencyNumber'];
    $user->profession = $_POST['profession'];
    $user->nationality = $_POST['nationality'];

    if($_POST['password']!=$_POST['confirmPassword']){
        echo json_encode(array('message' => 'passwords dont match'));
    }
    $sourceFilePath = $_FILES['photo']['tmp_name'];
    $targetDirectory = SITE_ROOT . DS . 'images' . DS . 'users' . DS;
    $targetFilePath = $targetDirectory . basename($_FILES['photo']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        echo json_encode(array('message' => 'File is not an image.'));
        exit;
    }

    if ($_FILES["photo"]["size"] > 500000) {
        $uploadOk = 0;
        echo json_encode(array('message' => 'Sorry, your file is too large.'));
        exit;
    }

    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $uploadOk = 0;
        echo json_encode(array('message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'));
        exit;
    }

    if ($uploadOk == 0) {
        echo json_encode(array('message' => 'Sorry, your file was not uploaded.'));
        exit;
    } else {
        if (move_uploaded_file($sourceFilePath, $targetFilePath)) {
            $user->photo = $user->photo = 'images/users/' . basename($_FILES['photo']['name']);
            if ($user->create()) {
                session_start();
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_role'] = 0;
                http_response_code(201);
                echo json_encode(array('message' => 'User created successfully.'));
            } else {
                http_response_code(500);
                echo json_encode(array('message' => 'Unable to create user.'));
            }
        } else {
            echo json_encode(array('message' => 'Sorry, there was an error uploading your file.'));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing required fields.'));
}
?>
