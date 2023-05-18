<?php

session_start();

if (isset($_SESSION['admin'])) {
    include './list-admin.php';
}
