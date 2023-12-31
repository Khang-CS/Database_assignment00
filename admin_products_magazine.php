<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $publisher = mysqli_real_escape_string($conn,$_POST['Publisher']);
   $description = mysqli_real_escape_string($conn,$_POST['description']);
   $price = $_POST['price'];
   $discount=$_POST['discount'];
   $author = mysqli_real_escape_string($conn,$_POST['author']);
   $duration = $_POST['duration'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT `Name` FROM `product` WHERE Name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `product`(Thumbnail,Name, Price,Discount_price,Publisher,Description) VALUES('$image','$name', '$price','$discount','$publisher','$description')") or die('query failed');

      $res = mysqli_query($conn,"SELECT Product_ID FROM `product` ORDER BY Product_ID DESC LIMIT 1;") or die ('query failed');
      $result = mysqli_fetch_array($res);
      $Product_ID = $result['Product_ID'];

      mysqli_query($conn,"INSERT INTO `magazine_seri` (Product_ID, Duration) VALUES ('$Product_ID','$duration')") or die ('query failed');

      #Author Handler.

      $find=',';
      $mark=0;
      $len = strlen($author);
      for ($i = 0; $i < $len; ++$i) {
      if($author[$i]==',') {
        $mark++;
      }
      }

      while ($mark>0) {
      $index=strpos($author,$find);
      $a_name=substr($author,0,$index);
      #Insert here
      $checkAuthor = mysqli_query($conn,"SELECT * FROM `author` WHERE Fullname='$a_name'") or die ('query failed');

      if(mysqli_num_rows($checkAuthor)>0) {
         $checkAuthor=mysqli_fetch_array($checkAuthor);
         $AuthorID=$checkAuthor['Author_ID'];

         mysqli_query($conn,"INSERT INTO `writee` (AUTHOR_ID,PRODUCT_ID) VALUES('$AuthorID','$Product_ID')") or die ('query failed');
      }

      else {
         mysqli_query($conn,"INSERT INTO `author` (Fullname) VALUES ('$a_name')") or die ('query failed');

         $getID = mysqli_query($conn,"SELECT `Author_ID` FROM `author` WHERE Fullname='$a_name'");
         $getID=mysqli_fetch_array($getID);
         $AuthorID=$getID['Author_ID'];

         mysqli_query($conn,"INSERT INTO `writee` (AUTHOR_ID,PRODUCT_ID) VALUES('$AuthorID','$Product_ID')") or die ('query failed');
      }
      #Insert end
      $author=substr($author,$index+2);
      $mark--;
      }

      $checkAuthor = mysqli_query($conn,"SELECT * FROM `author` WHERE Fullname='$author'") or die ('query failed');

      if(mysqli_num_rows($checkAuthor)>0) {
         $checkAuthor=mysqli_fetch_array($checkAuthor);
         $AuthorID=$checkAuthor['Author_ID'];

         mysqli_query($conn,"INSERT INTO `writee` (AUTHOR_ID,PRODUCT_ID) VALUES('$AuthorID','$Product_ID')") or die ('query failed');
      }

      else {
         mysqli_query($conn,"INSERT INTO `author` (Fullname) VALUES ('$author')") or die ('query failed');

         $getID = mysqli_query($conn,"SELECT `Author_ID` FROM `author` WHERE Fullname='$author'");
         $getID=mysqli_fetch_array($getID);
         $AuthorID=$getID['Author_ID'];

         mysqli_query($conn,"INSERT INTO `writee` (AUTHOR_ID,PRODUCT_ID) VALUES('$AuthorID','$Product_ID')") or die ('query failed');
      }

      #Author Handler end.

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT Thumbnail FROM `product` WHERE Product_ID = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['Thumbnail']);

   mysqli_query($conn,"DELETE FROM `magazine_seri` WHERE Product_ID='$delete_id'") or die ("query failed");
   mysqli_query($conn,"DELETE FROM `writee` WHERE PRODUCT_ID='$delete_id'") or die ('query failed');

   mysqli_query($conn, "DELETE FROM `product` WHERE Product_ID = '$delete_id'") or die('query failed');

   header('location:admin_products_magazine.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_discount=$_POST['update_discount'];
   $update_publisher=mysqli_real_escape_string($conn,$_POST['update_publisher']);
   $update_author=mysqli_real_escape_string($conn,$_POST['update_author']);
   $update_duration=$_POST['update_duration'];

   $update_description=$_POST['update_description'];

   mysqli_query($conn, "UPDATE `product` SET Name = '$update_name', Price = '$update_price', Description='$update_description', Discount_price='$update_discount', Publisher='$update_publisher' WHERE Product_ID = '$update_p_id'") or die('query failed here');

   mysqli_query($conn,"UPDATE `magazine_seri` SET Duration='$update_duration' WHERE Product_ID='$update_p_id'");

   $checkAuthor = mysqli_query($conn,"SELECT * FROM `author` WHERE Fullname='$update_author'") or die ('query failed');

      if(mysqli_num_rows($checkAuthor)>0) {
         $checkAuthor=mysqli_fetch_array($checkAuthor);
         $AuthorID=$checkAuthor['Author_ID'];

         mysqli_query($conn,"UPDATE`writee` SET AUTHOR_ID='$AuthorID' WHERE PRODUCT_ID='$update_p_id'") or die ('query failed');
      }

      else {
         mysqli_query($conn,"INSERT INTO `author` (Fullname) VALUES ('$author')") or die ('query failed');

         $getID = mysqli_query($conn,"SELECT `Author_ID` FROM `author` WHERE Fullname='$author'");
         $getID=mysqli_fetch_array($getID);
         $AuthorID=$getID['Author_ID'];

         mysqli_query($conn,"UPDATE`writee` SET AUTHOR_ID='$AuthorID' WHERE PRODUCT_ID='$update_p_id'") or die ('query failed');
      }



   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `product` SET Thumbnail = '$update_image' WHERE Product_ID = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products_magazine.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>all magazines</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">shop magazines</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add magazine</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>

      <input type="number" min="0" name="discount" class="box" placeholder="enter discount price" required>

      <input type="text" name="Publisher" class="box" placeholder="enter publisher name" required>
      <input type="text" name="author" class="box" placeholder="enter author name" required>

      <input type="number" min="0" name="duration" class="box" placeholder="enter duration" required>

      <textarea class="box" rows = "4" cols = "40" name = "description" placeholder="enter description" required></textarea>

      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
          $select_magazine_id = mysqli_query($conn,"SELECT `Product_ID` FROM `magazine_seri`") or die ('query failed');
          if(mysqli_num_rows($select_magazine_id) > 0){            
             while($fetch_magazine= mysqli_fetch_assoc($select_magazine_id)){
                $pid=$fetch_magazine['Product_ID'];
 
                $fetch_products = mysqli_query($conn,"SELECT * FROM `product` WHERE Product_ID='$pid'");
                $fetch_products = mysqli_fetch_array($fetch_products);
      ?>
      <div class="box">
         <img style="max-width:100%;" src="uploaded_img/<?php echo $fetch_products['Thumbnail']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['Name']; ?></div>
         <div class="price"><?php 
         $price=$fetch_products['Price'];
         $discount_price=$fetch_products['Discount_price'];
         if($discount_price) {
            echo "<s style='text-decoration: line-through'>$".$price."</s>";
            echo " | $".$discount_price;
         }
         else {
            echo "$".$price;
         }
          ?></div>
         <a href="admin_products_magazine.php?update=<?php echo $fetch_products['Product_ID']; ?>" class="option-btn">update</a>
         <a href="admin_products_magazine.php?delete=<?php echo $fetch_products['Product_ID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `product` WHERE Product_ID = '$update_id' ") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <!-- Get product id-->
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['Product_ID']; ?>">
      <!-- Get product thumbnail direction -->
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['Thumbnail']; ?>">
      <!-- Show thumbnail -->
      <img src="uploaded_img/<?php echo $fetch_update['Thumbnail']; ?>" alt="">

      <!--get Name -->
      <input type="text" name="update_name" value="<?php echo $fetch_update['Name']; ?>" class="box" required placeholder="enter product name">
      <!-- Get price -->
      <input style="width: 50%; float: left;" type="number" name="update_price" value="<?php echo $fetch_update['Price']; ?>" min="0" class="box" required placeholder="enter product price">
      <!--discount-->
      <input style="width: 50%; float: left;" type="number" name="update_discount" value="<?php echo $fetch_update['Discount_price']; ?>" min="0" class="box" required placeholder="enter discount price">
      <!--get publisher-->
      <input type="text" name="update_publisher" value="<?php echo $fetch_update['Publisher']; ?>" class="box" required placeholder="enter publisher">

      <input type="text" name="update_author" value="<?php
      $res=mysqli_query($conn,"SELECT `AUTHOR_ID` FROM `writee` WHERE PRODUCT_ID='$update_id'") or die ('query failed');
      $result=mysqli_fetch_array($res);
      $AUTHOR_ID= $result['AUTHOR_ID'];

      $res=mysqli_query($conn,"SELECT `Fullname` FROM `author` WHERE AUTHOR_ID='$AUTHOR_ID'") or die ('query failed');
      $result=mysqli_fetch_array($res);

      echo $result['Fullname']; 
       ?>" class="box" required placeholder="enter author">

        <input type="number" name="update_duration" value="<?php 
        $res=mysqli_query($conn,"SELECT `Duration` FROM `magazine_seri` WHERE Product_ID='$update_id'") or die ('query failed');
        $result=mysqli_fetch_array($res);
        echo $result['Duration'];
         ?>" min="0" class="box" required placeholder="enter duration">

      
      <textarea class="box" rows = "4" cols = "40" name = "update_description" required><?php echo $fetch_update['Description']; ?></textarea>
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>
<script>
   document.querySelector('#close-update').onclick = () =>{
   document.querySelector('.edit-product-form').style.display = 'none';
   window.location.href = 'admin_products_magazine.php';
}
</script>
</body>
</html>