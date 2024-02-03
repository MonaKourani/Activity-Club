<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

$user = new User($db);

try {
    $result = $user->read();

    $num = $result->rowCount();

    if ($num > 0) {
        $user_arr = array();
        $user_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'dateOfBirth' => $dateOfBirth,
                'gender' => $gender,
                'joiningDate' => $joiningDate,
                'mobile' => $mobile,
                'emergencyNumber' => $emergencyNumber,
                'photo' => $photo,
                'profession' => $profession,
                'nationality' => $nationality,
                'role' => $role
            );
            array_push($user_arr['data'], $user_item);
        }
        echo json_encode($user_arr);
    } else {
        echo json_encode(array('message' => 'No Users Found'));
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => $e->getMessage()));
}
?>
