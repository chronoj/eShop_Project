<?php
include 'connect.php';

$itemCount=0;

if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true)
{
    $sql = "SELECT SUM(BQUANT) AS item_count FROM basket WHERE CUSTOMERS_USERNAME = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($itemCount);
    if ($stmt->fetch() && $itemCount === NULL) 
    {
        $itemCount = 0;
    }
    $stmt->close();
} 
$conn->close();
?>