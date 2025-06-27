<?php
include("../database.php");
$id = $_GET['id'];
$conn->query("DELETE FROM courses WHERE id=$id");
header("Location: courses.php");
exit();
?>