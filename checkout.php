<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   
   $shipping_method = $_POST['shipping_method'];
   $address = $_POST['Address'];
   $note=$_POST['Note'];
   $Total_amount=0;

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
        
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $Total_amount += $sub_total;
      }
   }

   if($Total_amount == 0){
      $message[] = 'your cart is empty';
   }else{      
      $check_ok=1;
      
         mysqli_query($conn, "INSERT INTO `orders`(Status,Total_amount,Address,ACC_ID,METHOD_ID,Note) VALUES('Processing','$Total_amount','$address','$user_id','$shipping_method', '$note')") or die('query failed here');

         $ORDERID=mysqli_query($conn,"SELECT Order_ID FROM `orders` ORDER BY Order_ID DESC LIMIT 1");
         $ORDERID=mysqli_fetch_array($ORDERID);
         $Order_ID=$ORDERID['Order_ID'];

         $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         while($fetch_product=mysqli_fetch_assoc($cart_query)) {
            $Price=$fetch_product['price'];
            $Quantity=$fetch_product['quantity'];
            $Total_cost=$Price*$Quantity;
            $ORDERID=$Order_ID;
            $PID=$fetch_product['Product_ID'];           

            $get_p=mysqli_query($conn,"SELECT * FROM `book` WHERE Product_ID='$PID'") or die ('query failed');
            if(mysqli_num_rows($get_p)>0) {
               $get_p=mysqli_fetch_array($get_p);
               $get_p_quantity=$get_p['Quantity_in_store'];

               $update_quantity=$get_p_quantity-$Quantity;
               if($update_quantity>0) {
                  mysqli_query($conn,"UPDATE `book` SET Quantity_in_store='$update_quantity' WHERE Product_ID='$PID'") or die('query failed');
                  mysqli_query($conn,"INSERT INTO `order_detail` (Price,Quantity,Total_cost,ORDERID,PID) VALUES ('$Price', '$Quantity','$Total_cost','$ORDERID','$PID') ") or die ('query failed');
                  
                  
               }

               else {
                  
                  $message[]=$fetch_product['name']." is OUT OF STOCK !!!";  
                  $check_ok=0;                
               }
            }

            else {
               mysqli_query($conn,"INSERT INTO `order_detail` (Price,Quantity,Total_cost,ORDERID,PID) VALUES ('$Price', '$Quantity','$Total_cost','$ORDERID','$PID') ") or die ('query failed');                
               
            }            
         }

         if($check_ok) {
            $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
         }

         else {
            mysqli_query($conn,"DELETE FROM `order_detail` WHERE ORDERID='$Order_ID'") or die ('query failed');
            mysqli_query($conn,"DELETE FROM `orders` WHERE Order_ID='$Order_ID'") or die ('query failed here');
         }

              
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>checkout</h3>
   <p> <a href="home.php">home</a> / checkout </p>
</div>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].' '.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your first name :</span>
            <input type="text" name="FName" value ="<?php 
            $FName= mysqli_query($conn,"SELECT FName FROM account WHERE Account_ID='$user_id'");
            $FName=mysqli_fetch_array($FName);
            echo $FName['FName'];
            ?>" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>your last name :</span>
            <input type="text" name="LName" value ="<?php 
            $LName= mysqli_query($conn,"SELECT LName FROM account WHERE Account_ID='$user_id'");
            $LName=mysqli_fetch_array($LName);
            echo $LName['LName'];
            ?>" required placeholder="enter your name">
         </div>
        
         <div class="inputBox">
            <span>shipping method :</span>
            <select name="shipping_method">
               <?php
               $method=mysqli_query($conn,"SELECT * FROM `shipping_method`");
               if(mysqli_num_rows($method)>0) {
                  while($fetch_method=mysqli_fetch_assoc($method)) {
               ?>
               <option value="<?php echo $fetch_method['Method_ID']; ?>"><?php echo $fetch_method['Name']." | $".$fetch_method['Fee']; ?></option>
               <?php
                  }
               }
               ?>
            </select>
         </div>

         <div class="inputBox">
            <span>your address :</span>
            <input type="text" name="Address" required placeholder="enter your delivery address" value="<?php
             $Address= mysqli_query($conn,"SELECT Address FROM account WHERE Account_ID='$user_id'");
             $Address=mysqli_fetch_array($Address);
             echo $Address['Address'];?>">
         </div>
         
         <div class="inputBox">
            <span>your note :</span>
            <input type="text" name="Note" placeholder="please enter your note">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>