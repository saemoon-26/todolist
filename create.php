<?php
session_start();
include 'db_connection.php';

// ✅ Redirect to login if not logged in
if (!isset($_SESSION['loggedIn']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id']; // ✅ get user_id from session
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startdate = $_POST['start_date'];
    $enddate = $_POST['end_date'];

    $stmt = $conn->prepare("INSERT INTO task (user_id, title, description, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user_id, $title, $description, $startdate, $enddate);

    if ($stmt->execute()) {
        header('Location: display.php');
        exit();
    } else {
        die("Error: " . $stmt->error);
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <title>Create New Task</title>
</head>
<body>
    <h1>Create New Task</h1>
    <form method="post">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" readonly><br><br>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <input type="submit" name="submit" value="Create Task">
    </form>
</body>
</html>
