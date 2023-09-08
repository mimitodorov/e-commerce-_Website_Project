<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; // Retrieving the user ID from the session

if(!isset($user_id)){
   header('location:login.php'); // Redirecting to the login page if the user ID is not set
};

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Checking if the message already exists in the database
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!'; // If the message already exists, display a message indicating that it has been sent already
    }else{
        // Inserting the new message into the database
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!'; // Displaying a success message indicating that the message has been sent successfully
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>contact us</h3>
    <p> <a href="index.php">Home</a> / contact </p>
</section>

<section class="contact">

    <form action="" method="POST">
        <h3>Send us message!</h3>
        <input type="text" name="name" placeholder="enter your name" class="box" required> <!-- Text input for the user's name -->
        <input type="email" name="email" placeholder="enter your email" class="box" required> <!-- Email input for the user's email -->
        <input type="number" name="number" placeholder="enter your number" class="box" required> <!-- Number input for the user's phone number -->
        <textarea name="message" class="box" placeholder="enter your message" required cols="30" rows="10"></textarea> <!-- Textarea for the user's message -->
        <input type="submit" value="Send Message" name="send" class="btn"> <!-- Submit button to send the message -->
    </form>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>