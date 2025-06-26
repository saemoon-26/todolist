<?php
session_start();
include 'db_connection.php';
// Check if user is logged in
if (empty($_SESSION['loggedIn']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Check if task_id exists in URL
if (empty($_GET['task_id'])) {
    header('Location: display.php');
    exit;
}
// Get values
$task_id = $_GET['task_id'];
$user_id = $_SESSION['user_id'];
// Delete the task
$sql = "DELETE FROM task WHERE task_id = '$task_id' AND user_id = '$user_id'";
if ($conn->query($sql) === TRUE) {
    header('Location: display.php');
    exit;
} else {
    echo "Error deleting task: " . $conn->error;
}
$conn->close();