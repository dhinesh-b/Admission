<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
include("../database.php");

// Filter handling
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';

$query = "SELECT * FROM course_applications";
if ($filter != 'All') {
    $query .= " WHERE status='" . $conn->real_escape_string($filter) . "'";
}
$query .= " ORDER BY id DESC";
$result = $conn->query($query);

// Summary counts
$total = $conn->query("SELECT COUNT(*) as count FROM course_applications")->fetch_assoc()['count'];
$pending = $conn->query("SELECT COUNT(*) as count FROM course_applications WHERE status='Pending'")->fetch_assoc()['count'];
$accepted = $conn->query("SELECT COUNT(*) as count FROM course_applications WHERE status='Accepted'")->fetch_assoc()['count'];
$rejected = $conn->query("SELECT COUNT(*) as count FROM course_applications WHERE status='Rejected'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="course_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            color: white;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #34495e;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border-bottom: 2px solid #34495e;
        }

        .header-bar .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-bar .admin-info i {
            font-size: 20px;
        }

        .summary {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .summary form {
            display: inline;
        }

        .summary button {
            padding: 10px 20px;
            border: none;
            background-color: blue;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .summary button:hover {
            background-color: darkblue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: blue;
            color: white;
        }

        .action-btns form {
            display: inline-block;
            margin: 2px;
        }

        .action-btns button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btns .delete-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>ADMISSIONS</h2>
        <a class="active" href="admin_dashboard.php">Dashboard</a>
        <a href="courses.php">Course Management</a>
    </div>

    <div class="header-bar">
        <div><strong>Admin Dashboard</strong></div>
        <div class="admin-info">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
            <a href="logout.php" style="color: white; margin-left: 20px; text-decoration: underline;">Logout</a>
        </div>
    </div>

    <div class="content">
        <div class="summary">
            <form method="get"><input type="hidden" name="filter" value="All"><button type="submit">Total (<?= $total ?>)</button></form>
            <form method="get"><input type="hidden" name="filter" value="Pending"><button type="submit">Pending (<?= $pending ?>)</button></form>
            <form method="get"><input type="hidden" name="filter" value="Accepted"><button type="submit">Accepted (<?= $accepted ?>)</button></form>
            <form method="get"><input type="hidden" name="filter" value="Rejected"><button type="submit">Rejected (<?= $rejected ?>)</button></form>
        </div>

        <table>
            <tr>
                <th>Name</th>
                <th>Course</th>
                <th>Email</th>
                <th>Marks</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                <td><?= $row['course'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['total_marks'] ?></td>
                <td><?= $row['status'] ?></td>
                <td class="action-btns">
                    <form method="post" action="update_status.php">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <select name="status">
                            <option <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option <?= $row['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                            <option <?= $row['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>

                    <form method="get" action="view_application.php">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit">View</button>
                    </form>

                    <form method="post" action="delete_application.php" onsubmit="return confirm('Are you sure you want to delete this application?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
