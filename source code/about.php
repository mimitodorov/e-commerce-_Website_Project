<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; // Retrieves the admin ID from the session

if(!isset($user_id)){
   header('location:login.php'); // If the admin ID is not set, redirects to the login page
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="index.php">Home</a> / about </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/about-img-1.png" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Our customers are the backbone of our brand and we continuously strive to deliver excellent customer service across
                 all of our platforms. Providing personalised service, advice and consultations to every customer. 
                 Being there, every step of the our customer's skincare journey.</p>
            <a href="shop.php" class="btn">Shop Now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>What we provide?</h3>
            <p>We have the only line of skincare products with a unique blend of three essential ceramides, plus patented MVE 
                technology that gradually releases our ceramide-enriched formula over an extended period of time. 
                MVE is like a sphere with a series of layers that slowly dissolves, releasing the ingredients into your skin. 
                The product continues to work after it is applied, hydrating your skin all day in just one use. 
                This system-along with our unique combination of skin-identical ceramides-helps replenish your skin's existing ceramides, 
                relieves dry skin by reducing moisture loss, increases hydration and helps restore the skin barrier.</p>
            <a href="contact.php" class="btn">Contact Us</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.jpg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.jpg" alt="">
        </div>

        <div class="content">
            <h3>Who we are?</h3>
            <p>SKIMI was created to deliver a reputable and trusted South African skincare brand formulated with tried and trusted active ingredients,
                while offering consumers the transparency they deserve. As a result, SKIMI was born out of a collaborative effort with a combined experience 
                of 30 years across various fields. Integrating the fields of pharmacology, chemistry, clinical dermatology and aesthetic medicine. 
                The brand is based on peer reviewed literature, which forms the basis of SKIN functional's endorsement.</p>
            <a href="#reviews" class="btn">Clients Reviews</a>
        </div>

    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>