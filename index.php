<?php header('Location: pages/login.php'); exit; ?>
<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: pages/dashboard.php');
} else {
    header('Location: pages/login.php');
}
exit;
