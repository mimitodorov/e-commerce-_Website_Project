<!-- The admins will be able to update a product that has already been uploaded --> 
<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; // Retrieving the admin ID from the session

if(!isset($admin_id)){
   header('location:login.php'); // Redirecting to the login page if the admin ID is not set
};

if(isset($_POST['update_product'])){ // Checking if the form for updating a product is submitted

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

   // Updating the product details in the database based on the product ID
   mysqli_query($conn, "UPDATE `products` SET name = '$name', details = '$details', price = '$price' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name']; // Retrieving the updated image filename
   $image_size = $_FILES['image']['size']; // Retrieving the size of the updated image
   $image_tmp_name = $_FILES['image']['tmp_name']; // Retrieving the temporary path of the updated image
   $image_folter = 'uploaded_img/'.$image; // Setting the folder path to save the updated image
   $old_image = $_POST['update_p_image']; // Retrieving the filename of the old image
   
   // Checking if a new image is uploaded
   if(!empty($image)){
      // Error message if the image size exceeds the limit
      if($image_size > 2000000){
         $message[] = 'image file size is too large!';
      }else{
         // Updating the image filename in the database
         mysqli_query($conn, "UPDATE `products` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter); // Moving the uploaded image to the designated folder
         unlink('uploaded_img/'.$old_image); // Deleting the old image file
         $message[] = 'image updated successfully!';
      }
   }

   $message[] = 'product updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php

   $_GET['update'] = '';
   $update_id = $_GET['update']; // Retrieving the product ID to be updated from the URL parameter 'update'
   // Retrieving the product details from the database based on the product ID
   $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="image"  alt=""> <!-- Displaying the current product image -->
   <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id"> <!-- Hidden input field to store the product ID for updating -->
   <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image"> <!-- Hidden input field to store the current image filename -->
   <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="update product name" name="name"> <!-- Text input field to update the product name -->
   <input type="number" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="update product price" name="price"> <!-- Number input field to update the product price -->
   <textarea name="details" class="box" required placeholder="update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea> <!-- Textarea to update the product details -->
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image"> <!-- File input field to update the product image -->
   <input type="submit" value="update product" name="update_product" class="btn">
   <a href="admin_products.php" class="option-btn">Go Back</a>
</form>

<?php
      }
   }else{
      // Displayed if no products are found with the specified ID
      echo '<p class="empty">No Updated Products</p>';
   }
?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>