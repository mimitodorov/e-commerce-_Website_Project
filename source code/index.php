<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   // Redirect to the login page if the user is not logged in
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   
   // Check if the product is already in the wishlist for the current user
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   // Check if the product is already in the cart for the current user
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
      // If the product is already in the wishlist, add a message indicating that
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
      // If the product is already in the cart, add a message indicating that
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       // If the product is not in the wishlist or cart, insert it into the wishlist for the current user
       $message[] = 'product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Check if the product is already in the cart for the current user
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      // If the product is already in the cart, add a message indicating that
       $message[] = 'already added to cart';
   }else{

      // Check if the product is in the wishlist for the current user
       $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

       if(mysqli_num_rows($check_wishlist_numbers) > 0){
         // If the product is in the wishlist, remove it from the wishlist
           mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
       }

       mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       // Insert the product into the cart for the current user
       $message[] = 'product added to cart';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>New Collections</h3>
      <a href="about.php" class="btn">Load More</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

      <?php
      // Select the latest 6 products from the database
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            // Loop through each product fetched from the database
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <!-- Link to view the product details page -->
         <div class="price">R<?php echo $fetch_products['price']; ?></div>
         <!-- Display product price and image -->
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <!-- Display product name -->
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <!-- Quantity input field -->
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <!-- Hidden field to store the product ID -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <!-- Hidden field to store the product name -->
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <!-- Hidden field to store the product price -->
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <!-- Hidden field to store the product image -->
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <!-- Add to wishlist button -->
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
         <!-- Add to cart button -->
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
      }else{
         // If no products are available, display a message
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <!-- Link to load more products in the shop -->
      <a href="shop.php" class="option-btn">Load More</a>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Have any questions?</h3>
      <p>Can't find the information you're looking for on our website? Feel free to send us a message and we'll get back to you asap.</p>
      <a href="contact.php" class="btn">Contact Us</a>
   </div>

</section>


<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>