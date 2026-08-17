<?php
require_once 'config.php';
require_once 'auth.php';

$error = '';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = trim($_POST['item_name'] ?? '');
    $location  = trim($_POST['location'] ?? '');
    $status    = $_POST['status'] ?? 'Lost';

    if ($item_name === '' || $location === '') {
        $error = 'Please fill in both item name and location.';
    } else {
        // CREATE: insert new item, linked to the logged-in user
        $stmt = $conn->prepare(
            'INSERT INTO items (item_name, status, location, reported_by) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('sssi', $item_name, $status, $location, $user_id);
        $stmt->execute();
        $stmt->close();

        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report an Item - EWU Lost & Found Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Report a Lost / Found Item</h1>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="report_item.php">
            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Lost">Lost</option>
                <option value="Found">Found</option>
            </select>

            <button type="submit">Submit Report</button>
        </form>
        <p><a href="dashboard.php">&larr; Back to dashboard</a></p>
    </div>
</body>
</html>
