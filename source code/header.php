<!-- popup messages when the user tries to click on a button -->
<?php
if(isset($message)){
   foreach($message as $message){
    // Display each message within a message block
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

    <div class="flex">

        <a href="index.php" class="logo">SKIMI.</a>

        <!-- The navigation menu contains links to the different pages -->
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Pages +</a>
                    <ul>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="#">Account +</a>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
            ?>
            <!-- Retrieve the count of items in the user's wishlist from the database -->
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <!-- Retrieve the count of items in the user's cart from the database -->
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <!-- Account dropdown box -->
        <div class="account-box">
            <p>Username : <span><?php echo $_SESSION['user_name']; ?></span></p> <!-- Displaying admin's username -->
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p> <!-- Displaying admin's email -->
            <a href="logout.php" class="delete-btn">Logout</a> <!-- Logout button -->
        </div>
    </div>
</header>