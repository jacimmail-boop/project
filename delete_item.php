<?php
require_once 'config.php';
require_once 'auth.php';

$item_id = intval($_GET['item_id'] ?? 0);
$role    = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($item_id > 0) {
    if ($role === 'Admin') {
        // Admin can delete any listing
        $stmt = $conn->prepare('DELETE FROM items WHERE item_id = ?');
        $stmt->bind_param('i', $item_id);
    } else {
        // Student may only delete reports they personally created
        $stmt = $conn->prepare('DELETE FROM items WHERE item_id = ? AND reported_by = ?');
        $stmt->bind_param('ii', $item_id, $user_id);
    }
    $stmt->execute();
    $stmt->close();
}

header('Location: dashboard.php');
exit;
?>
