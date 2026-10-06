<?php
require '../includes/auth.php';
$_SESSION = []; session_destroy();
header('Location: ' . BASE . '/auth/login.php');
