<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>
<body>
    
    <a href="create.php"  style="
        display: inline-block; 
        padding: 10px 15px; 
        background-color:white; 
        color: black; 
        border-radius: 5px; 
        transition: background-color 0.3s;"
        
>ENTER NEW DATA</a>
</body>
</html>
<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['loggedIn']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM task WHERE user_id = '$user_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    
    echo "<table border='3'>
            <tr>
                <th>Task ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>User ID</th>
                <th>View</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["task_id"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["description"] . "</td>
                <td>" . $row["start_date"] . "</td>
                <td>" . $row["end_date"] . "</td>
                <td>" . $row["user_id"] . "</td>
    
                <td>
                    <a href='view_task.php?task_id=" . $row["task_id"] . "'>View</a>
                </td>
                
                <td>
    <a href='delete.php?task_id=" . $row["task_id"] . "'>delete</a>
</td>
<td>
    <a href='update.php?task_id=" . $row["task_id"] . "'>update</a>
</td>
                
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "0 results";
}
echo '<p><a href="logout.php">Logout</a></p>';
$conn->close()?>