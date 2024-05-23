<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];

if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match!'); window.location.href = '../signup.html';</script>";
    exit;
}

$sql = "SELECT id FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);

if ($stmt->fetch()) {
    echo "<script>alert('Username already exists!'); window.location.href = '../signup.html';</script>";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

if ($success) {
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;
    header("Location: ../dashboard.html");
    exit();
} else {
    echo "<script>alert('Registration failed!'); window.location.href = '../signup.html';</script>";
}
?>
