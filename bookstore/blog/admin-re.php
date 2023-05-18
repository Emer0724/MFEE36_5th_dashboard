<?php

if (!isset($_SESSION)) {
    SESSION_start();
}
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
