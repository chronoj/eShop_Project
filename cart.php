<section class="cart-container">
    <h2>Shopping Cart</h2>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'connect.php';
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
            ?>
                <tr>
                    <td><img src="<?php echo $row2['PHOTO']; ?>" alt="image"></td>
                    <td><?php echo $row2['NAME']; ?></td>
                    <td>
                        <form action="cart_update.php" method="POST" class="qty-form">
                            <input type="hidden" name="product_id" value="<?php echo $row['PRODUCTS_ID']; ?>">
                            <div class="qty-container">
                                <button type="submit" name="decrease" class="qty-btn decrease">-</button>
                                <input type="number" class="qty-input" value="<?php echo $row['BQUANT']; ?>" readonly max="99">
                                <button type="submit" name="increase" class="qty-btn increase">+</button>
                            </div>
                        </form>
                    </td>
                    <td class="subtotal"><?php echo number_format($subtotal, 2); ?> €</td>
                    <td>
                        <form action="cart_remove.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $row['PRODUCTS_ID']; ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="cart-summary">
        <p>Total: <span id="cart-total"><?php echo number_format($total, 2); ?> €</span></p>
        <button class="checkout-btn" id="checkout-btn">Proceed to Checkout</button>
        <button class="cancel-btn" onclick="window.location.href='project.php'">Cancel</button>
    </div>
</section>

<script>
    let value = <?php echo $total; ?>;
    let button = document.getElementById("checkout-btn");
    if (value > 0) 
    {
        button.onclick = function() 
        {
            window.location.href = 'project.php?page=Checkout';
        };
    } 
    else 
    {
        button.disabled = true;
    }
</script>

<style>
.cart-table td {
    padding: 1rem;
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid #ddd;
}

.cart-table td .qty-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px; 
}

.qty-btn {
    background: #0d6efd;
    color: white;
    border: none;
    width: 24px; 
    height: 24px; 
    padding: 0; 
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
    line-height: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.qty-input {
    width: 2.5em;
    height: 24px; 
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    padding: 0;
    box-sizing: border-box;
    -moz-appearance: textfield;
}

.qty-btn:hover {
    background: #0b5ed7;
}

.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.cart-container {
    max-width: 800px;
    margin: 2rem auto;
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    padding: 1rem;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.cart-table img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.remove-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    cursor: pointer;
    border-radius: 4px;
}

.remove-btn:hover {
    background: #c82333;
}

.cart-summary {
    text-align: right;
    margin-top: 1.5rem;
}

.checkout-btn, .cancel-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    margin-left: 1rem;
}

.checkout-btn {
    background: #28a745;
    color: white;
}

.cancel-btn {
    background: #6c757d;
    color: white;
}
</style>