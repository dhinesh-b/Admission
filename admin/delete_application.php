<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include("../database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $res = $conn->query("SELECT marksheet_path, photo_path FROM course_applications WHERE id = $id");
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (file_exists($row['marksheet_path'])) {
            unlink($row['marksheet_path']);
        }
        if (file_exists($row['photo_path'])) {
            unlink($row['photo_path']);
        }
    }


    $conn->query("DELETE FROM course_applications WHERE id = $id");


    header("Location: admin_dashboard.php");
    exit();
}
?>
