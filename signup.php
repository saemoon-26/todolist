<?php
include 'db_connection.php';

if (isset($_POST['submit'])) {
   
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    $sql = "INSERT INTO `user`(user_name,email,password) values('$user_name','$email','$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('location:display.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Create New user</title>
</head>

<body>
    <h1>SIGN UP</h1>
    <form method="post">
        

        <label for="user_name">User name :</label>
        <input type="text" id="user_name" name="user_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="title" name="email" required><br><br>

        <label for="password">Password:</label>
        <textarea id="password" name="password" required></textarea><br><br>

       
        <input type="submit" name="submit" value="Create Task">
    </form>
</body>

</html>