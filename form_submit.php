<?php
require_once("./admin/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {

    // Sanitize inputs
    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    $first     = clean($_POST['first']);
    $last      = clean($_POST['last']);
    $gender    = clean($_POST['gender']);
    $dob       = $_POST['dob']; // Date validation done below
    $email     = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone     = clean($_POST['number']);
    $address   = clean($_POST['address']);
    $group     = clean($_POST['group']);
    $marks     = intval($_POST['marks']);
    $course    = clean($_POST['course']);
    $declaration = isset($_POST['check']) ? 1 : 0;

    $uploadDir = "assets/uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validate DOB
    if (!strtotime($dob)) {
        die("Invalid date format.");
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Validate Marksheet PDF
    if (!isset($_FILES["marksheet"]) || $_FILES["marksheet"]["error"] !== 0) {
        die("Error: Invalid or missing marksheet.");
    }
    $marksheet = $_FILES["marksheet"];
    $marksheetExt = strtolower(pathinfo($marksheet["name"], PATHINFO_EXTENSION));
    if ($marksheetExt !== "pdf" || $marksheet["size"] > 2 * 1024 * 1024) {
        die("Error: Marksheet must be a PDF under 2MB.");
    }
    $marksheetPath = $uploadDir . uniqid("ms_") . ".pdf";
    move_uploaded_file($marksheet["tmp_name"], $marksheetPath);

    // Validate Photo
    if (!isset($_FILES["photo"]) || $_FILES["photo"]["error"] !== 0) {
        die("Error: Invalid or missing photo.");
    }
    $photo = $_FILES["photo"];
    $photoExt = strtolower(pathinfo($photo["name"], PATHINFO_EXTENSION));
    if (!in_array($photoExt, ['jpg', 'jpeg', 'png']) || $photo["size"] > 500 * 1024) {
        die("Error: Photo must be JPG/PNG under 500KB.");
    }
    $photoPath = $uploadDir . uniqid("pp_") . "." . $photoExt;
    move_uploaded_file($photo["tmp_name"], $photoPath);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO course_applications 
        (first_name, last_name, gender, dob, email, phone, address, student_group, total_marks, course, marksheet_path, photo_path, declaration) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssisssi",
        $first, $last, $gender, $dob, $email, $phone, $address, $group, $marks, $course, $marksheetPath, $photoPath, $declaration
    );

    if ($stmt->execute()) {
        header("Location: success.html");
        exit();
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
