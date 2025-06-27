<?php
include("../database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $conn->query("INSERT INTO courses (name, description, duration) VALUES ('$name', '$description', '$duration')");
    header("Location: courses.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Course</title>
    <style>
        body {
            margin: 0;
            background: rgba(0, 0, 0, 0.3);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .modal {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            position: relative;
        }
        .modal h2 {
            margin-top: 0;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .modal-buttons {
            text-align: right;
        }
        button {
            padding: 10px 15px;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .close-btn {
            background: #777;
            color: white;
        }
        .submit-btn {
            background: blue;
            color: white;
        }
        .close-icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 18px;
            cursor: pointer;
            color: #aaa;
        }
        .close-icon:hover {
            color: black;
        }
    </style>
</head>
<body>
    <div class="modal">
        <form method="post">
            <div class="close-icon" onclick="window.location.href='courses.php'">&times;</div>
            <h2>Add New Course</h2>
            <input type="text" name="name" placeholder="Course Name" required>
            <textarea name="description" rows="4" placeholder="Description" required></textarea>
            <input type="text" name="duration" placeholder="Duration (e.g., 3 years)" required>
            <div class="modal-buttons">
                <button type="button" class="close-btn" onclick="window.location.href='courses.php'">Close</button>
                <button type="submit" class="submit-btn">Add Course</button>
            </div>
        </form>
    </div>
</body>
</html>
