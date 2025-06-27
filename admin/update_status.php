<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $status = ucfirst(strtolower(trim($_POST['status'])));

    if (!in_array($status, ['Pending', 'Accepted', 'Rejected'])) {
        die("Invalid status value.");
    }

    $stmt = $conn->prepare("UPDATE course_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: admin_dashboard.php");
exit();
