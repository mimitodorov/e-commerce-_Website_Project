<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; // Retrieving the user ID from the session

if(!isset($user_id)){
   header('location:login.php'); // Redirecting to the login page if the user ID is not set
}

if(isset($_POST['add_to_cart'])){ // Checking if the "add_to_cart" form has been submitted

    $product_id = $_POST['product_id']; // Retrieving the product ID from the form
    $product_name = $_POST['product_name']; // Retrieving the product name from the form
    $product_price = $_POST['product_price']; // Retrieving the product price from the form
    $product_image = $_POST['product_image']; // Retrieving the product image from the form
    $product_quantity = 1;

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
        $message[] = 'product added to cart';
    }

}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete']; // Get the order ID from the URL parameter 'delete'
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed'); // Delete the order from the database for the specified order ID
    header('location:wishlist.php'); // Redirect to the wishlist page after deleting the order
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location:wishlist.php'); // Redirect to the wishlist page after deleting the order
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/my_style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>your wishlist</h3>
    <p> <a href="index.php">Home</a> / wishlist </p>
</section>

<section class="wishlist">

    <h1 class="title">Products Added</h1>

    <div class="box-container">

    <?php
    // Initialize a variable to hold the total price of all wishlist items
        $grand_total = 0;
        // Retrieve wishlist items from the database for the current user
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
        // Check if there are any wishlist items
        if(mysqli_num_rows($select_wishlist) > 0){
            // Loop through each wishlist item
            while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
    ?>
    <form action="" method="POST" class="box">
        <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
        <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
        <div class="price">R<?php echo $fetch_wishlist['price']; ?></div>
        <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['pid']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
        
    </form>
    <?php
    // Add the price of the current wishlist item to the grand total
    $grand_total += $fetch_wishlist['price'];
        }
    }else{
        // Display a message indicating that the wishlist is empty
        echo '<p class="empty">your wishlist is empty</p>';
    }
    ?>
    </div>

    <div class="wishlist-total">
        <p>Total : <span>R<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">Continue Shopping</a>
        <!-- Delete all wishlist items if the total price is greater than 1 -->
        <a href="wishlist.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from wishlist?');">Delete All</a>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>