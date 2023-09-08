<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; // Retrieves the admin ID from the session

if(!isset($admin_id)){
   header('location:login.php'); // If the admin ID is not set, redirects to the login page
};

if(isset($_GET['delete'])){ // Checks if the 'delete' parameter is set in the URL
   $delete_id = $_GET['delete']; // Retrieves the ID of the user to be deleted from the URL
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed'); // Executes a query to delete the user from the 'users' table based on the ID
   header('location:admin_users.php');// Redirects to the admin users page after deleting the user
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title">Users Accounts</h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed'); // Retrieves all users from the 'users' table
         if(mysqli_num_rows($select_users) > 0){ // Checks if there are any users
            while($fetch_users = mysqli_fetch_assoc($select_users)){ // Iterates over each user
      ?>
      <div class="box">
         <p>User ID : <span><?php echo $fetch_users['id']; ?></span></p>
         <p>Username : <span><?php echo $fetch_users['name']; ?></span></p>
         <p>Email : <span><?php echo $fetch_users['email']; ?></span></p>
         <p>User type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; }; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
         <!-- Deletes the user with confirmation -->
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
      </div>
      <?php
         }
      }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>