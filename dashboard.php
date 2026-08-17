<?php
require_once 'config.php';
require_once 'auth.php';

$role      = $_SESSION['role'];
$user_id   = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// READ: everyone (Student or Admin) sees all items on the dashboard
$sql = "SELECT items.item_id, items.item_name, items.status, items.location,
               items.reported_by, users.name AS reporter_name
        FROM items
        LEFT JOIN users ON items.reported_by = users.id
        ORDER BY items.item_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - EWU Lost & Found Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?> (<?php echo htmlspecialchars($role); ?>)</h1>
            <a class="btn" href="logout.php">Logout</a>
        </div>

        <a class="btn" href="report_item.php">Report a Lost Item</a>

        <h2>All Lost & Found Items</h2>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Location</th>
                <th>Status</th>
                <th>Reported By</th>
                <th>Actions</th>
            </tr>
            <?php while ($item = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['location']); ?></td>
                    <td class="status-<?php echo strtolower($item['status']); ?>">
                        <?php echo htmlspecialchars($item['status']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['reporter_name'] ?? 'Unknown'); ?></td>
                    <td>
                        <?php if ($role === 'Admin'): ?>
                            <?php if ($item['status'] === 'Lost'): ?>
                                <a href="update_status.php?item_id=<?php echo $item['item_id']; ?>">Mark Found</a> |
                            <?php endif; ?>
                            <a href="delete_item.php?item_id=<?php echo $item['item_id']; ?>"
                               onclick="return confirm('Delete this item?');">Delete</a>
                        <?php elseif ($role === 'Student' && $item['reported_by'] == $user_id): ?>
                            <a href="delete_item.php?item_id=<?php echo $item['item_id']; ?>"
                               onclick="return confirm('Delete this item?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
