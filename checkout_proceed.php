<?php

session_start();
include 'connect.php';
include 'functions.php';
include 'errors.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $username=$_SESSION["username"];
  $name=$_POST["name"];
  $address=$_POST["road-address"];
  $number=$_POST["road-number"];
  $city=$_POST["city"];
  $postal_code=$_POST["postal-code"];
  $telephone=$_POST["telephone"];
  $grand_total = getCartTotal($conn) + 20;

  $det_array = array($username,$name,$address,$number,$city,$postal_code,$telephone,$grand_total);
  $shipping_id = addShippingDetailsOnDatabase($conn,$det_array);

  if($shipping_id!=0)
  {
    migrateOrder($conn,$det_array,$shipping_id);
    deleteFromBasket($conn);
    header("Location: project.php");
    exit();
  }
  else
  {
    $_SESSION['error'] = "Unexpected Error Happened! Try Again";
    header("Location: project.php");
    exit();
  }
}

?>