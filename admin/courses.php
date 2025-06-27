<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
include("../database.php");
$result = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
        }
        .sidebar {
            position: fixed;
            width: 220px;
            height: 100%;
            background: #2c3e50;
            color: white;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #34495e;
        }
        .main {
            margin-left: 220px;
            padding: 0;
        }
        .topbar {
            background: #2c3e50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            font-size: 16px;
            border-bottom: 2px solid #34495e;
        }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-info i {
            font-size: 20px;
        }
        .content {
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .add-btn {
            background: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            margin-bottom: 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-btn:hover {
            background: darkblue;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: blue;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
            background: #ecf0f1;
        }
        td form {
            margin: 0;
        }
        td a {
            margin: 0 5px;
            color: blue;
            text-decoration: none;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ADMISSIONS</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <a class="active" href="courses.php">Course Management</a>
    </div>

    <div class="main">
        <div class="topbar">
            <div><strong>Course Management</strong></div>
            <div class="admin-info">
                <i class="fas fa-user-circle"></i>
                <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
                <a href="logout.php" style="color: white; margin-left: 20px; text-decoration: underline;">Logout</a>
            </div>
        </div>

        <div class="content">
            <h1>Courses</h1>
            <button class="add-btn" onclick="window.location.href='add_course.php'">+ Add Course</button>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['duration'] ?></td>
                    <td>
                        <form method="post" action="toggle_status.php">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="checkbox" name="active_status" onchange="this.form.submit()" <?= $row['active_status'] ? 'checked' : '' ?>>
                        </form>
                    </td>
                    <td>
                        <a href="edit_course.php?id=<?= $row['id'] ?>">✏️</a>
                        <a href="delete_course.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this course?')">🗑️</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>
