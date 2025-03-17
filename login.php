<?php
session_start();

include 'connect.php';

$user = $_POST['uname'];
$pass = $_POST['psw'];

$stmt = $conn->prepare("SELECT username, password FROM customers WHERE username = ?");
$stmt->bind_param("s", $user);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) 
{
    $row = $result->fetch_assoc();
    $stored_hashed_password = $row['password'];
    
    if (password_verify($pass, $stored_hashed_password)) 
    {
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['username'] = $row['username'];
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } 
    else 
    {
        $_SESSION['error'] = "Invalid password!";
        header("Location: project.php");
        exit();
    }
} 
else 
{
    $_SESSION['error'] = "Username not found!";
    header("Location: project.php");
    exit();
}

$stmt->close();
$conn->close();
?>
