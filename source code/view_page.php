<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php'); // Redirects to the login page if the user ID is not set
};

if(isset($_POST['add_to_wishlist'])){ // Executes if the 'add_to_wishlist' form is submitted

    $product_id = $_POST['product_id']; // Retrieves the product ID from the form
    $product_name = $_POST['product_name']; // Retrieves the product name from the form
    $product_price = $_POST['product_price']; // Retrieves the product price from the form
    $product_image = $_POST['product_image']; // Retrieves the product image from the form
    
    // Checks if the product is already in the wishlist
    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    // Checks if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist'; // Adds a message indicating that the product is already in the wishlist
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart'; // Adds a message indicating that the product is already in the cart
    }else{
        // Inserts the product into the wishlist table
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist'; // Adds a success message indicating that the product is added to the wishlist
    }

}

if(isset($_POST['add_to_cart'])){ // Executes if the 'add_to_cart' form is submitted

    $product_id = $_POST['product_id']; // Retrieves the product ID from the form
    $product_name = $_POST['product_name']; // Retrieves the product name from the form
    $product_price = $_POST['product_price']; // Retrieves the product price from the form
    $product_image = $_POST['product_image']; // Retrieves the product image from the form
    $product_quantity = $_POST['product_quantity']; // Retrieves the product quantity from the form

    // Checks if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        // Adds a message indicating that the product is already in the cart
        $message[] = 'already added to cart';
    }else{

        // Checks if the product is in the wishlist
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            // Deletes the product from the wishlist if it exists
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }
        // Inserts the product into the cart table
        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart'; // Adds a success message indicating that the product is added to the cart
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">Product Details</h1>

    <?php  
        if(isset($_GET['pid'])){
            $pid = $_GET['pid']; // Retrieves the product ID from the URL parameter
            // Retrieves the product details from the 'products' table based on the product ID
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){ // Checks if the product exists
            while($fetch_products = mysqli_fetch_assoc($select_products)){ // Loops through each fetched product
    ?>
    <!-- Display product -->
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image"> <!-- Displays the product image -->
         <div class="name"><?php echo $fetch_products['name']; ?></div> <!-- Displays the product name -->
         <div class="price">R<?php echo $fetch_products['price']; ?></div> <!-- Displays the product price -->
         <div class="details"><?php echo $fetch_products['details']; ?></div> <!-- Displays the product details -->
         <input type="number" name="product_quantity" value="1" min="0" class="qty"> <!-- Allows the user to select the product quantity -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>"> <!-- Stores the product ID as a hidden field -->
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>"> <!-- Stores the product name as a hidden field -->
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>"> <!-- Stores the product price as a hidden field -->
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>"> <!-- Stores the product image as a hidden field -->
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"> <!-- Submits the form to add the product to the wishlist -->
         <input type="submit" value="add to cart" name="add_to_cart" class="btn"> <!-- Submits the form to add the product to the cart -->
      </form>
    <?php
            }
        }else{
            // Displays a message when no product details are available
        echo '<p class="empty">No products details available!</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="index.php" class="option-btn">Go to home page</a>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>