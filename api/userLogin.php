<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->checkLogin($email, $password)) {
        session_start();
        $_SESSION['user_email'] = $email;
        if ($user->isAdmin()) {
            $_SESSION['user_role'] = 1;
            $user->role=1;
        } else {
            $_SESSION['user_role'] = 0;
            $user->role=0;
        }
        http_response_code(200);
        echo json_encode(array('message' => 'Login successful', 'user' => $user));
    } else {
        http_response_code(401); 
        echo json_encode(array('message' => 'Login failed. Invalid email or password.'));
    }
} else {
    http_response_code(400); 
    echo json_encode(array('message' => 'Missing email or password'));
}
?>
