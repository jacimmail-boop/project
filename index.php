<?php
require_once 'config.php';

// If already logged in, go straight to the dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ewu_id   = trim($_POST['ewu_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($ewu_id === '' || $password === '') {
        $error = 'Please enter both EWU ID and password.';
    } else {
        // Prepared statement prevents SQL injection
        $stmt = $conn->prepare('SELECT id, name, password, role FROM users WHERE ewu_id = ?');
        $stmt->bind_param('s', $ewu_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // NOTE: passwords are stored in plain text to match the
            // simple VARCHAR(50) schema used in this lab project.
            // In a production system use password_hash()/password_verify().
            if ($password === $user['password']) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role']      = $user['role'];

                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Incorrect password.';
            }
        } else {
            $error = 'No account found with that EWU ID.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EWU Lost & Found Portal - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>EWU Lost & Found Portal</h1>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <label for="ewu_id">EWU ID (e.g., 2024-1-60-001 or admin-01):</label>
            <input type="text" id="ewu_id" name="ewu_id" required>

            <label for="password">Password (Hint: 1234):</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
