<?php
include 'connect.php';
include 'functions.php';
include 'errors.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prod_id'])) 
{
    $check_que = "SELECT BQUANT FROM basket WHERE CUSTOMERS_USERNAME = ? AND PRODUCTS_ID = ?";
    $stmt = $conn->prepare($check_que);
    $stmt->bind_param("ss", $_SESSION['username'], $_POST['prod_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    $current_quant = $row['BQUANT'];
    $p_id = $_POST['prod_id'];
    $p_quant = checkQuant($conn, $p_id);

    if ($result->num_rows != 0) 
    {

        if ($p_quant>$current_quant)
        {
            $update_que = "UPDATE basket SET BQUANT = BQUANT + 1 WHERE CUSTOMERS_USERNAME = ? AND PRODUCTS_ID = ?";
            $stmt = $conn->prepare($update_que);
            $stmt->bind_param("ss", $_SESSION['username'], $_POST['prod_id']);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            $update_que = "UPDATE basket SET BQUANT = ? WHERE CUSTOMERS_USERNAME = ? AND PRODUCTS_ID = ?";
            $stmt = $conn->prepare($update_que);
            $stmt->bind_param("iss", $p_quant, $_SESSION['username'], $_POST['prod_id']);
            $stmt->execute();
            $stmt->close();
            $_SESSION['error'] = "No more stock for this product.";
        }
    } 
    else 
    {
        if ($p_quant>0)
        {
            $cadd_que = "INSERT INTO basket (BQUANT, CUSTOMERS_USERNAME, PRODUCTS_ID) VALUES (1, ?, ?)";
            $stmt = $conn->prepare($cadd_que);
            $stmt->bind_param("ss", $_SESSION['username'], $_POST['prod_id']);
            $stmt->execute();
            $stmt->close();
        }
        else
            $_SESSION['error'] = "No more stock for this product. Restocking soon!";
    }
}
$conn->close();
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>