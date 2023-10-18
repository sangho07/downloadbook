<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    # Database Connection File
    include "../db_conn.php";

    # Validation helper function
	include "func-validation.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    # Simple form validation (you can add more validation as needed)
    $text = "Username";
	$location = "../loginuser.php";
	$ms = "error";
    is_empty($username, $text, $location, $ms, "");

    $text = "Password";
	$location = "../loginuser.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();
        $user_password = $user['password'];
        
        if (password_verify($password, $user_password)) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../user.php");
            exit();
        } else {
            $em = "Sai tên người dùng hoặc mật khẩu.";
            $_SESSION['error_message'] = $em;
            header("Location: ../loginuser.php");
            exit();
        }
    } else {
        $em = "Sai tên người dùng hoặc mật khẩu.";
        $_SESSION['error_message'] = $em;
            header("Location: ../loginuser.php");
            exit();
    }
} else {
    # Redirect to the login page if data is not posted
    header("Location: ../index.php");
    exit();
}
?>
