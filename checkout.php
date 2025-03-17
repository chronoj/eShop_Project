<?php 
    include 'connect.php';
    include 'functions.php';
?>

<section class="checkout-section">
    <div class="checkout-container">
        <div class="checkout-form">
            <form action="checkout_proceed.php" method="post">
                <h2>Shipping & Payment Details</h2>
                <div class="name-field">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="address-details">
                    <div class="address-row">
                        <div class="input-group road-address1">
                            <label for="road-address">Address:</label>
                            <input type="text" id="road-address" name="road-address" required>
                        </div>
                        <div class="input-group road-address">
                            <label for="road-number">Number:</label>
                            <input type="text" id="road-number" name="road-number" required>
                        </div>
                        <div class="input-group postal-code">
                            <label for="postal-code">Postal Code:</label>
                            <input type="text" id="postal-code" name="postal-code" required>
                        </div>
                    </div>
                    <div class="more-info">
                        <div class="input-group more-info1">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="input-group more-info2">
                            <label for="telephone">Telephone:</label>
                            <input type="tel" id="telephone" name="telephone" required>
                        </div>
                    </div>
                </div>
                <div class="credit-card-details">
                    <label for="cc-number">Credit Card Number:</label>
                    <input type="text" id="cc-number" name="cc-number" placeholder="1234-1234-1234-1234"required>
                    
                    <div class="credit-card-details2">
                        <div class="input-group credit-card1">
                            <label for="cc-owner">Card Owner:</label>
                            <input type="text" id="cc-owner" name="cc-owner" placeholder="John Doe"required>
                        </div>
                        <div class="input-group credit-card2">
                            <label for="cc-expiry">Exp.Date:</label>
                            <input type="text" id="cc-expiry" name="cc-expiry" placeholder="MM/YY" required>
                        </div>
                        <div class="input-group credit-card3">
                            <label for="cc-ccv">CCV:</label>
                            <input type="text" id="cc-ccv" name="cc-ccv" placeholder="123"required>
                        </div>
                    </div>
                </div>
        </div>
                <?php
                    $vat = getCartTotal($conn)*24/124;
                    $no_vat = getCartTotal($conn)*100/124;
                    $shipping_cost = 20;
                    $grand_total = getCartTotal($conn) + $shipping_cost;
                ?>
            
                <div class="checkout-summary">
                    <h3>Order Summary</h3>
                    <p>Total: <?php echo number_format($no_vat, 2)?>€</p>
                    <p>Vat: <?php echo number_format($vat,2);?>€</p>
                    <p>Shipping: <?php echo number_format($shipping_cost,2);?>€</p>
                    <p>Grand Total: <?php echo number_format($grand_total,2);?>€</p>
                    <div class="buttons">
                        <button type="submit" id="proceed-btn" class="btn">Proceed</button>
            </form>
                        <button id="cancel-btn" class="btn" onclick="window.location.href='http://localhost/eshop/project.php?page=Cart'">Cancel</button>
                    </div>
                </div>   
    </div>
</section>

<style>
.checkout-section {
    display: flex;
    justify-content: center;
    padding: 2rem;
    background-color: #f5f5f5;
}

.checkout-container {
    display: flex;
    width: 80%;
    gap: 2rem;
}

.checkout-form {
    flex: 2;
    padding: 2rem;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.checkout-form h2 {
    margin-bottom: 1rem;
    color: #212529;
}

.checkout-form label {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    display: block;
}

.checkout-form input {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.name-field, .address-details, .credit-card-details, .address-row, .more-info, .credit-card-details2 {
    margin-bottom: 1rem;
}

.address-row, .credit-card-details2, .more-info {
    display: flex;
    gap: 1rem;
}

.input-group {
    display: flex;
    flex-direction: column;
}

.road-address1 {
    flex: 2;
}

.road-address, .credit-card2, .credit-card3 {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.road-address input {
    width: 50%;
}

.credit-card1, .more-info1, .more-info2{
    flex: 4;
}

.credit-card2 {
    flex:2
}

.credit-card3 {
    flex:1
}

.more-info1 input, .more-info2 input,{
    width: 70%;
}

.credit-card3 input, .credit-card2 input {
    width: 55%;
}

.checkout-summary {
    flex: 1;
    padding: 2rem;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.checkout-summary h3 {
    margin-bottom: 1rem;
    color: #212529;
}

.checkout-summary p {
    font-size: 1.1rem;
    margin: 0.5rem 0;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 1.5rem;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    color: white;
}

.btn:hover {
    background-color: #0d6efd;
    color: white;
}

#proceed-btn {
    background-color: #04AA6D;
}

#cancel-btn {
    background-color: #6c757d;
}

@media (max-width: 1024px) {
    .checkout-container {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .checkout-container {
        flex-direction: column;
        width: 100%;
        padding: 1rem;
    }

    .checkout-form,
    .checkout-summary {
        width: 100%;
        padding: 1rem;
    }

    .checkout-summary {
        margin-left: 0;
        margin-top: 1rem;
    }

    .address-row, .credit-card-details2 {
        flex-direction: column;
        gap: 0.5rem;
    }

    .road-address input,
    .credit-card2 input,
    .credit-card3 input {
        width: 100%;
    }

    .buttons {
        flex-direction: column;
        gap: 1rem;
    }

    .btn {
        width: 100%;
    }
}
</style>
