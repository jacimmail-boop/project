<?php
require_once 'config.php';
require_once 'auth.php';
require_admin(); // only Admin (campus security) may update status

$item_id = intval($_GET['item_id'] ?? 0);

if ($item_id > 0) {
    // UPDATE: admin marks an item as Found
    $stmt = $conn->prepare("UPDATE items SET status = 'Found' WHERE item_id = ?");
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $stmt->close();
}

header('Location: dashboard.php');
exit;
?>
