<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>We are college team with big dream to bring the greatest experienct to you. Our products are always high quality and have been qualified by the global association</p>
         <p>We promise to service you as good as possible. </p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

   <?php
$get_comment=mysqli_query($conn,"SELECT * FROM `review` ORDER BY Created_date DESC LIMIT 6");
if(mysqli_num_rows($get_comment)>0) {
   while($fetch_comment=mysqli_fetch_assoc($get_comment)) {
      $ACCID=$fetch_comment['ACCID'];
      $fetch_account=mysqli_query($conn,"SELECT* FROM `account` WHERE Account_ID='$ACCID'") or die ('query failed');
      $fetch_account=mysqli_fetch_array($fetch_account);
?>

      <div class="box">
         <img src="./uploaded_img/<?php echo $fetch_comment['Image']; ?>" alt="">
         <p><?php echo $fetch_comment['Content']; ?></p>
         <div class="stars">
            <?php $star=$fetch_comment['Rating']; 
            while($star>0){
               echo"
            <i class='fas fa-star'></i>";
             $star--; ?>            
            
            <?php }
            $non=5-$fetch_comment['Rating'];
            while($non>0){
            echo'

            <i style="color: rgb(203, 195, 195);"class="fas fa-star"></i>';
            $non--;

            }
            ?>


         </div>
         <h3><?php echo $fetch_account['FName']." ".$fetch_account['LName']; ?></h3>
      </div>
      <?php
   }
}
?>

   </div>

</section>

<section class="authors">

   <h1 class="title">our authors</h1>

   <div class="box-container">
      <?php
      $select_author=mysqli_query($conn,"SELECT* FROM `author`");
      if(mysqli_num_rows($select_author)>0) {

      while($fetch_author=mysqli_fetch_assoc($select_author)) {
      ?>

      <div class="box">
         <!--<img src="images/author.png" alt="">-->
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3><?php echo $fetch_author['Fullname']; ?></h3>
      </div>

      <?php }}?>
   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>