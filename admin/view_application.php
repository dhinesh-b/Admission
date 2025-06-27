<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
include("../database.php");

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM course_applications WHERE id = $id");

if ($result->num_rows != 1) {
    die("Application not found");
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Details</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 30px; }
        .container { max-width: 700px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; color: blue; }
        .section { margin-top: 20px; }
        .section h3 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .field { margin: 10px 0; }
        .label { font-weight: bold; display: inline-block; width: 200px; }
        .value { display: inline-block; }
        .btn-back { margin-top: 20px; text-align: center; }
        .btn-back a { padding: 10px 20px; background: blue; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Application Information</h2>

        <div class="section">
            <h3>Personal Information</h3>
            <div class="field"><span class="label">Full Name:</span><span class="value"><?= $data['first_name'] . ' ' . $data['last_name'] ?></span></div>
            <div class="field"><span class="label">Gender:</span><span class="value"><?= $data['gender'] ?></span></div>
            <div class="field"><span class="label">Date of Birth:</span><span class="value"><?= $data['dob'] ?></span></div>
            <div class="field"><span class="label">Email:</span><span class="value"><?= $data['email'] ?></span></div>
            <div class="field"><span class="label">Phone Number:</span><span class="value"><?= $data['phone'] ?></span></div>
            <div class="field"><span class="label">Address:</span><span class="value"><?= $data['address'] ?></span></div>
        </div>

        <div class="section">
            <h3>Academic Information</h3>
            <div class="field"><span class="label">Group:</span><span class="value"><?= $data['student_group'] ?></span></div>
            <div class="field"><span class="label">Course Applied:</span><span class="value"><?= $data['course'] ?></span></div>
            <div class="field"><span class="label">Total Marks:</span><span class="value"><?= $data['total_marks'] ?> / 600</span></div>
            <div class="field"><span class="label">Status:</span><span class="value"><?= $data['status'] ?></span></div>
            <div class="field"><span class="label">Declaration:</span><span class="value"><?= $data['declaration'] ? 'Yes' : 'No' ?></span></div>
        </div>

        <div class="section">
            <h3>Attachments</h3>
            <div class="field"><span class="label">Marksheet:</span><span class="value"><a href="../<?= $data['marksheet_path'] ?>" target="_blank">View PDF</a></span></div>
            <div class="field"><span class="label">Photo:</span><span class="value"><a href="../<?= $data['photo_path'] ?>" target="_blank">View Image</a></span></div>
        </div>

        <div class="btn-back">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
