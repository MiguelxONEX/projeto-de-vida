<?php
require_once '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = logout();
    if ($result['success']) {
        header('Location: ../index.html');
        exit;
    } else {
        echo json_encode($result);
    }
}
?>
