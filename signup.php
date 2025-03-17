<?php
session_start();

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];
    $email = $_POST['eml'];
    $hashed_password = password_hash($psw, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $uname, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) 
    {
        $_SESSION['error'] = "Username and/or email already exists!";
        header("Location: project.php");
        exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO customers (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $uname, $email, $hashed_password);

    if ($stmt->execute()) 
    {
        $_SESSION['userLoggedIn'] = true;
    	$_SESSION['username'] = $uname; 
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } 
    else 
    {
        $_SESSION['error'] = "An Unexpected Error Has Occured. Try Again.";
    }
    $stmt->close();
}
$conn->close();
?>
