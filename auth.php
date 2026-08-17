<?php
/**
 * auth.php
 * Include this at the top of any page that requires a logged-in user.
 * Must be included AFTER config.php (session_start already called there).
 */
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

function require_admin() {
    if ($_SESSION['role'] !== 'Admin') {
        header('Location: dashboard.php');
        exit;
    }
}
?>
