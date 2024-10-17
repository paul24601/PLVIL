<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$userType = $_POST['userType'];

// Debugging output to verify credentials
if ($userType === "student-admin" && $username === "studentadmin" && $password === "iloveplvil") {
    $_SESSION['userType'] = 'student-admin';
    echo json_encode(['status' => 'success', 'userType' => 'student-admin']);
} elseif ($userType === "library-admin" && $username === "libraryadmin" && $password === "iloveplvil") {
    $_SESSION['userType'] = 'library-admin';
    echo json_encode(['status' => 'success', 'userType' => 'library-admin']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
