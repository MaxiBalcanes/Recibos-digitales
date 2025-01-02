<?php
session_start();

function checkAuth($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }

    if ($role && $_SESSION['role'] !== $role) {
        header('Location: /index.php');
        exit;
    }
}
?>
