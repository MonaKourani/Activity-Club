<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

try {
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
        $user->role = $_POST['role'];
        $user->joiningDate = $_POST['joiningDate'];

        if (isset($_FILES['photo']) && isset($_FILES['photo']['tmp_name'])) {
            $sourceFilePath = $_FILES['photo']['tmp_name'];
            $targetDirectory = SITE_ROOT . DS . 'images' . DS . 'users' . DS;
            $targetFilePath = $targetDirectory . basename($_FILES['photo']['name']);

            if (move_uploaded_file($sourceFilePath, $targetFilePath)) {
                $user->photo = 'images/users/' . basename($_FILES['photo']['name']);
            } else {
                http_response_code(500);
                echo json_encode(array('message' => 'Error uploading photo.'));
                exit;
            }
        }

        if ($user->update()) {
            http_response_code(200);
            echo json_encode(array('message' => 'User updated successfully.'));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Unable to update user.'));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Missing required fields.'));
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('error' => 'Database Error: ' . $e->getMessage()));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
}
?>
