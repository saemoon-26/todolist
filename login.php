<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id; // ✅ Added: Store user_id in session
        header('Location:display.php');
        exit;
    } else {
        echo "Invalid email and password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">

    <title>Login Page</title>
</head>
<body>
    <h1>SIGN IN</h1>
    <form action="" method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
        <div>
            <a href="signup.php">SIGN UP</a>
        </div>
    </form>
</body>
</html>
