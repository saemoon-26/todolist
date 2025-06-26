<?php
$conn = new mysqli('localhost', 'root', '', 'todolist');

if (!$conn) {
    die(mysqli_error($conn));
}
