<?php
session_start();

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    # Database Connection File
    include "../db_conn.php";

    # Validation helper function
	include "func-validation.php";

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    # Simple form validation (you can add more validation as needed)
    $text = "username";
	$location = "../registeruser.php";
	$ms = "error";
    is_empty($username, $text, $location, $ms, "");

    $text = "Email";
	$location = "../registeruser.php";
	$ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
	$location = "../registeruser.php";
	$ms = "error";
    is_empty($password, $text, $location, $ms, "");

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $em = "Username này đã được đăng ký.";
        header("Location: ../registeruser.php?error=$em");
        exit();
    }

    # Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    # Insert user into the database
    $insert_sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    if ($insert_stmt->execute([$username, $email, $hashed_password])) {
        $_SESSION['user_username'] = $username;
        $success_message = "Đăng ký thành công!";
        header("Location: ../registeruser.php?success_message=$success_message");
        exit();
    }
} else {
    # Redirect to the registration page if data is not posted
    header("Location: index.php");
    exit();
}
?>