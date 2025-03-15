<?php 
session_start(); 
include 'errors.php';
include 'cart_count.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">	
	<meta name="description" content="Scale Model Shop">
	<meta name="keywords" content="Models, Colors, Scale, Hobby, Store">
	<meta name="author" content="BasilisLab">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BLab JChrono Static Model Shop</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<header>
		<div class="top-bar">
			<?php
			include 'topbar.php';
			?>
		</div>

		<div class="main-header">
			<div class="logo">
				<h1><a href="project.php">LabChrono Model Shop</a></h1>
			</div>
			<nav class="main-nav">
				<ul>
					<li><a href="project.php?page=Tanks">Tanks</a></li>
					<li><a href="project.php?page=Planes">Planes</a></li>
					<li><a href="project.php?page=Ships">Ships</a></li>
					<li><a href="project.php?page=Expendables">Expendables</a></li>
					<li><a href="project.php?page=Tools">Tools</a></li>
				</ul>
			</nav>
        </div>
	</header>
	<main>
	    <?php
            $page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : "main";
            switch ($page) 
            {
                case 'Tanks':
                case 'Planes':
                case 'Ships':
                case 'Expendables':
                case 'Tools':
                    include 'side.php';
                    break;
                case 'Cart':
                    include 'cart.php';
                    break;
				case 'Checkout':
					include 'checkout.php';
					break;
                default:
                    include 'main.php';
                    break;
            }
        ?>
	</main>

	<footer>
		<?php
		include 'footer.php';
		?>
	</footer>

	<script>
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.textContent = 'Added to Cart';
            button.style.backgroundColor = '#198754';
            setTimeout(() => {
                button.textContent = 'Add to Cart';
                button.style.backgroundColor = '#0d6efd';
            }, 1000);
        });
    });
	</script>	

</body>
</html>
