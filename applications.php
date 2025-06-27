<?php
require_once("db_connect.php");
include("includes/admin_header.php");
include("includes/sidebar.php");

$status = $_GET['status'] ?? 'all';
$titleMap = [
    'all' => 'All Applications',
    'pending' => 'Pending Applications',
    'accepted' => 'Accepted Applications',
    'rejected' => 'Rejected Applications'
];
$title = $titleMap[$status] ?? 'Applications';

$query = "SELECT * FROM course_applications";
if ($status !== 'all') {
    $safeStatus = ucfirst(strtolower($status));
    $query .= " WHERE status = ?";
}
$query .= " ORDER BY id DESC";

$stmt = $conn->prepare($query);
if ($status !== 'all') {
    $stmt->bind_param("s", $safeStatus);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main">
    <h1>Applications</h1>
    <div class="filters">
        <a href="applications.php?status=all"><button>All</button></a>
        <a href="applications.php?status=pending"><button>Pending</button></a>
        <a href="applications.php?status=accepted"><button>Accepted</button></a>
        <a href="applications.php?status=rejected"><button>Rejected</button></a>
    </div>
    <h2><?= htmlspecialchars($title) ?></h2>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Course</th><th>Date</th><th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['course']) ?></td>
                <td><?= date("M d, Y", strtotime($row['dob'])) ?></td>
                <td><a class="view-btn" href="view_application.php?id=<?= $row['id'] ?>">View</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include("includes/admin_footer.php"); ?>
