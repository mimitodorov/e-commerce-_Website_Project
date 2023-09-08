   <?php
   
   @include 'config.php';
   
   session_start();
   
   if(isset($_POST['submit'])){
      
   //collects user input to place into database 
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING); //filters the user input for the email field
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   // Executes a SQL query to select users with the provided email and password
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   // If a user is found with the provided email and password
   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){ // If the user type is 'admin'

         $_SESSION['admin_name'] = $row['name']; // Stores the admin's name in a set variable
         $_SESSION['admin_email'] = $row['email']; // Stores the admin's email in a set variable
         $_SESSION['admin_id'] = $row['id']; // Stores the admin's ID in a set variable
         header('location:admin_page.php'); // Redirects the user to the admin_page.php page

      }elseif($row['user_type'] == 'user'){ // If the user type is 'user'

         $_SESSION['user_name'] = $row['name']; // Stores the user's name in a set variable
         $_SESSION['user_email'] = $row['email']; // Stores the user's email in a set variable
         $_SESSION['user_id'] = $row['id']; // Stores the user's ID in a set variable
         header('location:index.php'); // Redirects the user to the index.php page (Home page)

      }else{
         // If no valid user type is found message displays indicating no user was found
         $message[] = 'no user found!';
      }

   }else{
      // If no user is found with the provided email and password message displays indicating incorrect email or password
      $message[] = 'incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>

<!-- popup message when the user tries to login to their account -->
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

<section class="form-container">
   
   <!-- Login form -->
   <form action="" method="post">
      <h3>Login Now</h3>
      <!-- users email address -->
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <!-- users password -->
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="submit" class="btn" name="submit" value="login now">
      <p>Don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>

</body>
</html>