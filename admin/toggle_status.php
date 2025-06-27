<?php
include("../database.php");

$id = $_POST['id'];
$current = $conn->query("SELECT active_status FROM courses WHERE id=$id")->fetch_assoc()['active_status'];
$new = $current ? 0 : 1;

$conn->query("UPDATE courses SET active_status=$new WHERE id=$id");

header("Location: courses.php");
?>