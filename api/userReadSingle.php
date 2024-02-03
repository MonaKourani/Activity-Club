<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

if (isset($_GET['email'])) {
    $user->email = $_GET['email'];

    try {
        $user->readSingle();

        if ($user->email) {
            $user_arr = array(
                'email' => $user->email,
                'name' => $user->name,
                'password' => $user->password,
                'dateOfBirth' => $user->dateOfBirth,
                'gender' => $user->gender,
                'joiningDate' => $user->joiningDate,
                'mobile' => $user->mobile,
                'emergencyNumber' => $user->emergencyNumber,
                'photo' => $user->photo,
                'profession' => $user->profession,
                'nationality' => $user->nationality,
                'role' => $user->role
            );

            echo json_encode($user_arr);
        } else {
            echo json_encode(array('message' => 'User not found'));
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Database Error: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'Missing email parameter'));
}
?>
