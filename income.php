<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$category = $_POST['category'];
$comment = $_POST['comment'];

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{
$connect = new mysqli($host, $db_user, $db_password, $db_name);

if ($connect->connect_errno != 0) {
    throw new Exception(mysqli_connect_errno());
} else {
    if ($connect->query("INSERT INTO incomes VALUES (NULL, '$user_id', '$category', '$amount', '$date', '$comment');")) {
        header('Location: main-menu.php');
    } else {
        throw new Exception($connect->error);
    }
    $connect->close();
}
} catch (Exception $e) {
    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
}

?>