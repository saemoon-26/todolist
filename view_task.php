

<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}?>
<?php
include 'db_connection.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    $sql = "SELECT * FROM task WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "No task found with this ID.";}
} else {
    echo "Task ID not provided.";
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>View Task</title>
</head>
<body>
    <h1>Task Details</h1>
    <?php if (isset($task)): ?>
        <p><strong>Task ID:</strong> <?php echo htmlspecialchars($task['task_id']); ?></p>
        <p><strong>User ID:</strong> <?php echo htmlspecialchars($task['user_id']); ?></p>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($task['title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($task['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($task['end_date']); ?></p>
    <?php endif; ?>
    <a href="display.php">Back to Task List</a>
</body>
<p><a href="logout.php">Logout</a></p></html>
<?php
$conn->close();
?>
