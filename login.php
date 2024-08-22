<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental Kathmandu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
       
        <?php include 'header.php'; ?>
    </header>
    <main>
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="notification"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
