<?php

@include 'config.php';

if(isset($_POST['submit'])){

//    collects user input to place into database 
   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');


   if(mysqli_num_rows($select_users) > 0){
    // if user already exists output message will be displayed indicating that user exists
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
        // if password does not match an output message will be displayed indicating that password does not match
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
        //  message will be displayed if registration has been successful
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custome CSS link -->
    <link rel="stylesheet" href="css/my_style.css">

</head>
<body>

<!-- popup messages when the user tries to Register -->
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


<!-- Register form -->
<section class="form-container">

    <form action="" method="post">
        <h3>Register Now!</h3>
        <!-- users username -->
        <input type="text" name="name" class="box" placeholder="Enter your username" required>
        <!-- users email address -->
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <!-- users password -->
        <input type="pass" name="pass" class="box" placeholder="Enter your password" required>
        <!-- ask user to confirm password by inputting it again -->
        <input type="pass" name="cpass" class="box" placeholder="Confirm password" required>
        <input type="submit" class="btn" name="submit" value="Register Now" required>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </form>

</section>
    
</body>
</html>