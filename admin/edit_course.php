<?php
include("../database.php");
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM courses WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $conn->query("UPDATE courses SET name='$name', description='$description', duration='$duration' WHERE id=$id");
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .modal {
            background: #fff;
            width: 400px;
            padding: 25px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .modal h2 {
            margin-top: 0;
        }

        .modal input, .modal textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal textarea {
            resize: vertical;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #4c68ff;
            color: white;
        }

        .close-btn {
            background-color: #ccc;
        }

        .close-icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 18px;
            cursor: pointer;
            color: #999;
        }

        .close-icon:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="modal">
        <div class="close-icon" onclick="window.location.href='courses.php'">×</div>
        <h2>Edit Course</h2>
        <form method="post">
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required placeholder="Course Name">
            <textarea name="description" required placeholder="Description"><?= htmlspecialchars($row['description']) ?></textarea>
            <input type="text" name="duration" value="<?= htmlspecialchars($row['duration']) ?>" required placeholder="Duration (e.g., 3 years)">
            <div class="modal-buttons">
                <button type="button" class="close-btn" onclick="window.location.href='courses.php'">Close</button>
                <button type="submit" class="save-btn">Save changes</button>
            </div>
        </form>
    </div>
</body>
</html>
