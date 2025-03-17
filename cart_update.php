<?php
include 'connect.php';
include 'functions.php';
include 'errors.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) 
{
    $p_id = $_POST['product_id'];
    $p_quant = checkQuant($conn, $p_id);
    $cart_que = mysqli_query($conn, "SELECT * FROM basket WHERE PRODUCTS_ID = '$p_id' AND CUSTOMERS_USERNAME = '{$_SESSION['username']}'");
    $row = mysqli_fetch_assoc($cart_que);
    $n_quant = $row['BQUANT'];

    if (isset($_POST['increase'])) 
    {
        if ($p_quant>$n_quant)
            $n_quant++;
        else
            $_SESSION['error'] = "No more stock for this product.";
    } 
    elseif (isset($_POST['decrease']) && $n_quant > 1) 
    {
        $n_quant--;
    }

    $update_cart = "UPDATE basket SET BQUANT = $n_quant WHERE PRODUCTS_ID = '{$_POST['product_id']}' AND CUSTOMERS_USERNAME = '{$_SESSION['username']}'";
    mysqli_query($conn, $update_cart);

    header("Location: project.php?page=Cart");
    exit();
}
?>