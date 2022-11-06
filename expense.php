<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$payment_method = $_POST['payment_method'];
$category = $_POST['category'];
$comment = $_POST['comment'];

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = new mysqli($host, $db_user, $db_password, $db_name);

if ($connect->connect_errno != 0) {
    throw new Exception(mysqli_connect_errno());
} else {
    $result = $connect->query("INSERT INTO expenses VALUES (NULL, '$user_id', '$category', '$payment_method', '$amount', '$date', '$comment')");

    //if (!$result) throw new Exception($connect->error);

    header('Location: main-menu.php');

    $connect->close();
}

