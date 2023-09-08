<!-- popup messages when the user tries to click on a button -->
<?php
if(isset($message)){
   foreach($message as $message){
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

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <!-- Navigation bar -->
      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="admin_products.php">Products</a>
         <a href="admin_orders.php">Orders</a>
         <a href="admin_users.php">Users</a>
         <a href="admin_contacts.php">Messages</a>
      </nav>

      <!-- Icons -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div> <!-- Menu button icon -->
         <div id="user-btn" class="fas fa-user"></div> <!-- User button icon -->
      </div>

      <!-- Account dropdown box -->
      <div class="account-box">
         <p>Username : <span><?php echo $_SESSION['admin_name']; ?></span></p> <!-- Displaying admin's username -->
         <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p> <!-- Displaying admin's email -->
         <a href="logout.php" class="delete-btn">Logout</a> <!-- Logout button -->
         <div>New <a href="login.php">Login</a> | <a href="register.php">Register</a> </div> <!-- Links for login and registration -->
      </div>

   </div>

</header>