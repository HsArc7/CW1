<?php 
session_start();
include 'db.php';
include 'header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $query = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->execute([$username, $hashed_password, $email]);

    echo 'Registration successful. <a href="login.php">Login</a>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>

