<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>update</title>
</head>
<body>
    
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

include('db_connection.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date) || $user_id <= 0) {
        echo "All fields are required.";
        exit;
    }

    $sql = "UPDATE task SET title = ?, description = ?, start_date = ?, end_date = ?, user_id = ? WHERE task_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssii", $title, $description, $start_date, $end_date, $user_id, $task_id);
        if ($stmt->execute()) {
            header("Location: display.php");
            exit();
        } else {
            echo "Error updating task: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    if (isset($_GET['task_id'])) {
        $task_id = (int)$_GET['task_id'];
        
        $sql = "SELECT * FROM task WHERE task_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $task_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form action="update.php?task_id=<?php echo $task_id; ?>" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $row["task_id"]; ?>">
                    <label for="title">Title:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($row["title"]); ?>"><br><br>
                    <label for="description">Description:</label>
                    <input type="text" name="description" value="<?php echo htmlspecialchars($row["description"]); ?>"><br><br>
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" value="<?php echo htmlspecialchars($row["start_date"]); ?>"><br><br>
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" value="<?php echo htmlspecialchars($row["end_date"]); ?>"><br><br>
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>"><br><br>
                    <button type="submit">Update</button>
                </form>
                <?php
            } else {
                echo "Task not found.";
            }
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "No task ID provided.";
    }
}

$conn->close();
?>
