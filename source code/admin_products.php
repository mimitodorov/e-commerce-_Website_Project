<!-- Through this page the admins will be able to upload new products onto the website --> 
    <?php
    
    @include 'config.php';
    
    session_start();
    
    // Retrieve the admin ID from the session
    $admin_id = $_SESSION['admin_id'];
    
    // If the admin ID is not set, redirect to the login page
    if(!isset($admin_id)){
        header('location:login.php');
};

if(isset($_POST['add_product'])){
    
   // Extract the product information from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folter = 'uploaded_img/'.$image;
    
    // Check if the product name already exists in the 'products' table
   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    // if admin tries to upload a product with the same product name it will show message "product name already exists". 
   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      // Insert the product information into the 'products' table
      $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');
        // if image size is to big, error message will pop up
      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            // Move the uploaded image to the designated folder
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'product added successfully!';
         }
      }
   }

}

// if user wants to delete item off the website
if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];

   // Retrieve the image filename associated with the product
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);

   // Delete the image file from the server
   unlink('uploaded_img/'.$fetch_delete_image['image']);

   // Delete the product from the 'products' table
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');

   // Delete the product from the 'wishlist' table
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

   // Delete the product from the 'cart' table
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');

   // Redirect to the admin products page
   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<!-- Admin will add new products through this form -->
<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add New Product</h3>
      <input type="text" class="box" required placeholder="Enter the name of the product" name="name">
      <input type="number" min="0" class="box" required placeholder="Enter the price of the product" name="price">
      <textarea name="details" class="box" required placeholder="Enter the description of the product" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>

<!-- displays the existing products -->
<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <div class="price">R<?php echo $fetch_products['price']; ?></div>
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="details"><?php echo $fetch_products['details']; ?></div>
         <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">Delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
   

</section>


<script src="js/admin_script.js"></script>

</body>
</html>