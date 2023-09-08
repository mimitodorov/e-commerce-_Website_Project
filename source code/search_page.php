<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    // Redirect the user to the login page if user_id is not set in the session
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){
    // Handle adding a product to the wishlist

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        // If the product is already in the wishlist
        $message[] = 'already added to wishlist';
        // If the product is already in the cart
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{
        // Add the product to the wishlist
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist';
    }

}

if(isset($_POST['add_to_cart'])){
    // Handle adding a product to the cart

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        // If the product is already in the cart
        $message[] = 'already added to cart';
    }else{

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            // If the product is in the wishlist, remove it before adding to the cart
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        // Add the product to the cart
        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
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
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Search Page</h3>
    <p> <a href="index.php">Home</a> / search </p>
</section>

<section class="search-form">
    <form action="" method="POST">
        <input type="text" class="box" placeholder="search products..." name="search_box">
        <input type="submit" class="btn" value="search" name="search_btn">
    </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">

      <?php
        if(isset($_POST['search_btn'])){
            // Handle search button click
         $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
         // Escape special characters in the search box value
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'") or die('query failed');
         // Perform a database query to fetch products that match the search box value
         if(mysqli_num_rows($select_products) > 0){
             // If there are matching products, display them
            while($fetch_products = mysqli_fetch_assoc($select_products)){
                // Fetch each product
      ?>
      <form action="" method="POST" class="box">
        <!-- Link to view the product details page -->
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <!-- Display the product price -->
         <div class="price">R<?php echo $fetch_products['price']; ?></div>
         <!-- Display the product image -->
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <!-- Display the product name -->
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <!-- Input field for product quantity -->
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <!-- Hidden field to store the product ID -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <!-- Hidden field to store the product name -->
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <!-- Hidden field to store the product price -->
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <!-- Hidden field to store the product image -->
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <!-- Submit button to add the product to the wishlist -->
         <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
         <!-- Submit button to add the product to the cart -->
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
         }
            }else{
                // If no products match the search, display a message
                echo '<p class="empty">No result found!</p>';
            }
        }else{
            // Display a message to search for something
            echo '<p class="empty">Search for something!</p>';
        }
      ?>
   </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>