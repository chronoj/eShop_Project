<?php

function checkQuant($conn,$prod_id) :int
{
  $quant_que = mysqli_query($conn, "SELECT * FROM products WHERE ID = '$prod_id'");
  $row = mysqli_fetch_assoc($quant_que);
  $current = $row['QUANT'];
  return $current;
}

function getCartTotal($conn): float
{
  $cart_que = mysqli_query($conn, "SELECT * FROM basket WHERE CUSTOMERS_USERNAME = '{$_SESSION['username']}'");
  $total = 0;
  while ($row = mysqli_fetch_array($cart_que)) 
  {
    $prod_que = mysqli_query($conn, "SELECT * FROM products WHERE ID = '{$row['PRODUCTS_ID']}'");
    $row2 = mysqli_fetch_array($prod_que);
    if ($row['BQUANT']>$row2['QUANT'])
    {
      $update_quant = "UPDATE basket SET BQUANT = '{$row2['QUANT']}' WHERE PRODUCTS_ID = '{$row['PRODUCTS_ID']}' AND CUSTOMERS_USERNAME = '{$_SESSION['username']}'";
      mysqli_query($conn, $update_quant);
    }
    $subtotal = $row['BQUANT'] * $row2['PRICE'];
    $total += $subtotal;
  }
  return $total;
}

function addShippingDetailsOnDatabase($conn,$det_array)
{
  $ordadd_que = "INSERT INTO user_shipping(customers_username,delivery_name,road_address,
  road_number,city,postal_code,call_number,order_date,payment) VALUES (?,?,?,?,?,?,?,NOW(),?)";
  $stmt = $conn->prepare($ordadd_que);
  $stmt->bind_param("sssssssd", $det_array[0],$det_array[1],$det_array[2],$det_array[3],$det_array[4],$det_array[5],$det_array[6],$det_array[7]);

  if($stmt->execute())
  {
    $shipping_id =$conn->insert_id;
    $stmt->close();
    return $shipping_id;
  }
  else
  { 
    $stmt->close();
    return 0;
  }
}

function migrateOrder($conn, $det_array, $shipping_id) 
{
  $cart_que = "SELECT * FROM basket WHERE CUSTOMERS_USERNAME = ?";
  $stmt=$conn->prepare($cart_que);
  $stmt->bind_param("s", $det_array[0]); 
  $stmt->execute();
  $cart_result = $stmt->get_result();

  while ($row = mysqli_fetch_array($cart_result)) 
  {
    $product_id = $row['PRODUCTS_ID'];
    $qty = $row['BQUANT'];
    $order_product_que = "INSERT INTO orders (ORDER_ID, FBQUANT, FCUSTOMERS_USERNAME, FPRODUCTS_ID) VALUES (?, ?, ?, ?)";
    $stmt2 =$conn->prepare($order_product_que);
    $stmt2->bind_param("iiss", $shipping_id, $qty, $det_array[0], $product_id);
    $stmt2->execute();
  }
}

function deleteFromBasket($conn)
{
  $username = $_SESSION['username'];

  $select_que = "SELECT * FROM basket WHERE CUSTOMERS_USERNAME = ?";
  $stmt=$conn->prepare($select_que);
  $stmt->bind_param("s", $username); 
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = mysqli_fetch_array($result)) 
  {
      $update_que = "UPDATE products SET QUANT = QUANT - ? WHERE ID = ?";
      $update_stmt = $conn->prepare($update_que);
      $update_stmt->bind_param("is", $row['BQUANT'], $row['PRODUCTS_ID']);
      $update_stmt->execute();
  }

  $delete_que = "DELETE FROM basket WHERE CUSTOMERS_USERNAME = ?";
  $delete_stmt = $conn->prepare($delete_que);
  $delete_stmt->bind_param("s", $username);
  $delete_stmt->execute();

  $stmt->close();
  $update_stmt->close();
  $delete_stmt->close();
}

?>