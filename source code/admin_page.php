<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; // Retrieves the admin ID from the session

if(!isset($admin_id)){
   header('location:login.php'); // If the admin ID is not set, redirects to the login page
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS link for admin page -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php
@include 'admin_header.php';
?>

<section class="dashboard">
    <h1 class="title">Dashboard</h1>

    <div class="box-container">

    <div class="box">
    <!-- Displays the total price of orders that are pending at that time -->
    <?php
        $total_pendings = 0;
        // Retrieves pending orders from the 'orders' table
        $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
        while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){ // Iterates over each pending order
            $total_pendings += $fetch_pendings['total_price']; // Accumulates the total price of pending orders
        };
    ?>
    <h3>R<?php echo $total_pendings; ?></h3>
    <p>Total Pendings</p>
    </div>


    <div class="box">
    <!-- The number of completed payments will be output here = total price -->
    <?php
        $total_completes = 0;
        // Retrieves completed orders from the 'orders' table
        $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
        while($fetch_completes = mysqli_fetch_assoc($select_completes)){ // Iterates over each completed order
            $total_completes += $fetch_completes['total_price']; // Accumulates the total price of completed orders
        };
    ?>
    <h3>R<?php echo $total_completes; ?></h3>
    <p>Completed Payments</p>
    </div>


    <div class="box">
    <!-- Will display the number of orders placed by fetching the number of rows for the 'orders' table -->
    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed'); // Retrieves all orders from the 'orders' table
        $number_of_orders = mysqli_num_rows($select_orders); // Counts the number of orders
    ?>
    <h3><?php echo $number_of_orders; ?></h3>
    <p>Orders Placed</p>
    </div>


    <div class="box">
    <!-- Will display the number of products that have been added -->
    <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed'); // Retrieves all products from the 'products' table
        $number_of_products = mysqli_num_rows($select_products); // Counts the number of products
    ?>
    <h3><?php echo $number_of_products; ?></h3>
    <p>Products Added</p>
    </div>


    <div class="box">
    <!-- Will display the number of users that have been registered. This data is retreived under 'user_type' from the 'users' table  -->
    <?php
    // Retrieves all users with user_type 'user' from the 'users' table
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
        $number_of_users = mysqli_num_rows($select_users); // Counts the number of users
    ?>
    <h3><?php echo $number_of_users; ?></h3>
    <p>Users</p>
    </div>


    <div class="box">
    <!-- Will display the number of admins that have been registered. This data is retreived under 'user_type' from the 'users' table  -->
    <?php
    // Retrieves all users with user_type 'admin' from the 'users' table
        $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
        $number_of_admin = mysqli_num_rows($select_admin); // Counts the number of admins
    ?>
    <h3><?php echo $number_of_admin; ?></h3>
    <p>Admins</p>
    </div>


    <div class="box">
    <!-- Will display the number of total accounts that have been registered. This data is retreived from the 'users' table  -->
    <?php
        $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed'); // Retrieves all accounts from the 'users' table
        $number_of_account = mysqli_num_rows($select_account); // Counts the number of accounts
    ?>
    <h3><?php echo $number_of_account; ?></h3>
    <p>Total Accounts</p>
    </div>


    <div class="box">
    <!-- Will display new messages that have been sent. This data is retreived from the 'message' table  -->
    <?php
        $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed'); // Retrieves all messages from the 'message' table
        $number_of_messages = mysqli_num_rows($select_messages); // Counts the number of messages
    ?>
    <h3><?php echo $number_of_messages; ?></h3>
    <p>New Messages</p>
    </div>

    </div>

</section>


<script src="js/admin_script.js"></script>
    
</body>
</html>

