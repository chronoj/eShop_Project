<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) 
{
    $delete_que = "DELETE FROM basket WHERE PRODUCTS_ID = '{$_POST['product_id']}' AND CUSTOMERS_USERNAME = '{$_SESSION['username']}'";
    mysqli_query($conn, $delete_que);
    header("Location: project.php?page=Cart");
    exit();
}
?>