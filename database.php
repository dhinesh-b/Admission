<?php
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit']) && isset($_FILES['marksheet'])) {
    $first = $_POST['first'];
    $last = $_POST['last'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $address = $_POST['address'];
    $group = $_POST['group'];
    $marks = $_POST['marks'];
    $course = $_POST['course'];
    $declaration = isset($_POST['check']) ? 1 : 0;

    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!isset($_FILES["marksheet"]) || $_FILES["marksheet"]["error"] !== 0) {
        die("Error: Invalid or missing marksheet file.");
    }

    $marksheetName = basename($_FILES["marksheet"]["name"]);
    $marksheetTmp = $_FILES["marksheet"]["tmp_name"];
    $marksheetPath = $uploadDir . uniqid() . "_" . $marksheetName;
    if ($_FILES["marksheet"]["size"] > 2 * 1024 * 1024 || pathinfo($marksheetName, PATHINFO_EXTENSION) != "pdf") {
        die("Error: Marksheet must be a PDF under 2MB.");
    }
    move_uploaded_file($marksheetTmp, $marksheetPath);

    $photoName = basename($_FILES["photo"]["name"]);
    $photoTmp = $_FILES["photo"]["tmp_name"];
    $photoExt = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
    $photoPath = $uploadDir . uniqid() . "_" . $photoName;
    if ($_FILES["photo"]["size"] > 500 * 1024 || !in_array($photoExt, ['jpg', 'jpeg', 'png'])) {
        die("Error: Photo must be JPG/PNG under 500KB.");
    }
    move_uploaded_file($photoTmp, $photoPath);

    $stmt = $conn->prepare("INSERT INTO course_applications 
        (first_name, last_name, gender, dob, email, phone, address, student_group, total_marks, course, marksheet_path, photo_path, declaration) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssisssi",
        $first, $last, $gender, $dob, $email, $phone, $address, $group, $marks, $course, $marksheetPath, $photoPath, $declaration
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Application submitted successfully!');
            window.location.href = 'success.html';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}
?>
