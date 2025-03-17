<?php
include 'connect.php';

$sql="SELECT * FROM products WHERE CATEGORY = '$page'";
$sqlres=mysqli_query($conn,$sql);
$nrows=mysqli_num_rows($sqlres);	
if($nrows==0)
{
    echo "<section class='featured-products'>
                <h2>$page</h2>
                <h4>No stock for this category</h4>
            </section>";
}
else
{	
    echo "<section class='featured-products'>
	        <h2>$page</h2>
            <div class='product-grid'>";
    while($row=mysqli_fetch_array($sqlres))
    {
        $p_id = htmlspecialchars($row["ID"]);
        $p_name = htmlspecialchars($row["NAME"]);
        $p_price = htmlspecialchars($row["PRICE"]);
        $p_image = htmlspecialchars($row["PHOTO"]);
        $p_desc = htmlspecialchars($row["DESC"]);
        echo "
            <div class='product-card'>
                <img src='$p_image' alt='Image'>
                <div class='product-info'>
                    <h3 class='product-title'>$p_name</h3>
                    <h5 style='font-weight: normal;'>$p_desc</h5>
                    <p class='product-price'>$p_price €</p>";
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true)
        {
            echo "                    
                    <form action='cart_add.php' method='POST'>
                        <input type='hidden' name='prod_id' value='$p_id'>
                        <button class='add-to-cart-btn'>Add to Cart</button>
                    </form>
                </div>
            </div>";
        }
        else
        {
            echo "
                    <button class='add-to-cart-btn' onclick=\"document.getElementById('id01').style.display='block'\">Add to Cart</button>
                </div>
            </div>";
        }
    }
    echo   "</div>
            </section>";
}
?>