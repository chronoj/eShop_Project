<div class="user-controls">

    <?php if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true): ?>
        <button class="logbtn">
            <span style="color: blue; text-decoration: underline;">
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
        </button>
    <?php else: ?>
        <button class="logbtn" onclick="document.getElementById('id01').style.display='block'">
            Login
        </button>
    <?php endif; ?>

    <div id="id01" class="modal">
        <form class="modal-content animate" action="http://localhost/eshop/login.php" method="post">
            <div class="modalcontainer">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <button class="modalbtn" type="submit">Login</button>
            </div>
        </form>
    </div>
    |
    <?php if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true): ?>
        <button class="logbtn" onclick="window.location.href='http://localhost/eshop/logout.php'">
            Logout
        </button>
    <?php else: ?>
        <button class="logbtn" onclick="document.getElementById('id02').style.display='block'">
            Sign Up
        </button>
    <?php endif; ?>
    
    <div id="id02" class="modal">
        <form class="modal-content animate" action="http://localhost/eshop/signup.php" method="post">
            <div class="modalcontainer">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <label for="eml"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="eml" required>
                <button class="modalbtn" type="submit">Sign Up</button>
            </div>
        </form>
    </div>

    <div class="cart">
        <?php
            if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true)
            {
                echo '<a href="project.php?page=Cart">🛒</a>';
            } 
            else 
            {
                echo '<a href="javascript:void(0);" onclick="document.getElementById(\'id01\').style.display=\'block\'">🛒</a>';
            }
        ?>
        <span class="cart-count"><?php echo $itemCount; ?></span>
    </div>
</div>

<script>
    var modal2 = document.getElementById('id02');
    var modal = document.getElementById('id01');
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == modal2) {
                modal2.style.display = "none";
            }
    }
</script>