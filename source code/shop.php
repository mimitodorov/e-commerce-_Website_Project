<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; // Retrieving the user ID from the session

if(!isset($user_id)){
   header('location:login.php'); // Redirecting to the login page if the user ID is not set
};

if(isset($_POST['add_to_wishlist'])){ // Checking if the "add_to_wishlist" form has been submitted

    $product_id = $_POST['product_id']; // Retrieving the product ID from the form
    $product_name = $_POST['product_name']; // Retrieving the product name from the form
    $product_price = $_POST['product_price']; // Retrieving the product price from the form
    $product_image = $_POST['product_image']; // Retrieving the product image from the form

    // Checking if the product is already in the wishlist for the user
    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    // Checking if the product is already in the cart for the user
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist'; // If the product is already in the wishlist, set a message indicating that it is already added
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart'; // If the product is already in the cart, set a message indicating that it is already added
    }else{
        // Inserting the product into the wishlist
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist'; // Setting a message indicating that the product has been added to the wishlist
    }

}
if(isset($_POST['add_to_cart'])){ // Checking if the "add_to_cart" form has been submitted

    $product_id = $_POST['product_id'];  // Retrieving the product ID from the form
    $product_name = $_POST['product_name']; // Retrieving the product name from the form
    $product_price = $_POST['product_price']; // Retrieving the product price from the form
    $product_image = $_POST['product_image']; // Retrieving the product image from the form
    $product_quantity = $_POST['product_quantity'];  // Retrieving the product quantity from the form

    // Checking if the product is already in the cart for the user
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart'; // If the product is already in the cart, set a message indicating that it is already added
    }else{

        // Checking if the product is in the wishlist for the user
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            // If the product is in the wishlist, remove it from the wishlist
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        // Inserting the product into the cart
        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart'; // Setting a message indicating that the product has been added to the cart
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>our shop</h3>
    <p> <a href="index.php">Home</a> / shop </p>
</section>

<section class="products">

   <h1 class="title">Latest Products</h1>

   <div class="box-container">

      <?php
      // Retrieving all products from the database
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         // Checking if there are products available
         if(mysqli_num_rows($select_products) > 0){
            // Looping through each product
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a> <!-- Link to view the product details page -->
         <div class="price">R<?php echo $fetch_products['price']; ?>/-</div> <!-- Displaying the product price -->
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image"> <!-- Displaying the product image -->
         <div class="name"><?php echo $fetch_products['name']; ?></div> <!-- Displaying the product name -->
         <input type="number" name="product_quantity" value="1" min="0" class="qty"> <!-- Input field to select the product quantity -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>"> <!-- Hidden input field for the product ID -->
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>"> <!-- Hidden input field for the product name -->
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>"> <!-- Hidden input field for the product price -->
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>"> <!-- Hidden input field for the product image -->
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"> <!-- Button to add the product to the wishlist -->
         <input type="submit" value="add to cart" name="add_to_cart" class="btn"> <!-- Button to add the product to the cart -->
      </form>
      <?php
         }
      }else{
        // Message displayed when there are no products available
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>

   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>