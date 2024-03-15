<?php

include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $street = $_POST['street'];
   $ward = $_POST['ward'];
   $district = $_POST['district'];
   $province = $_POST['province'];
   $pin_code = $_POST['pin_code'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = ($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `orders`(name, phone, email, method, street, ward, district, province, pin_code, total_products, total_price) VALUES('$name','$phone','$email','$method','$street','$ward','$district','$province','$pin_code','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Cảm tạ bạn đã đặt hàng!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> Tổng : ".number_format($price_total)."VND  </span>
         </div>
         <div class='customer-details'>
            <p> Họ tên: : <span>".$name."</span> </p>
            <p> SĐT : <span>".$phone."</span> </p>
            <p> Email : <span>".$email."</span> </p>
            <p> Địa chỉ : <span>".$street.", ".$ward.", ".$district.", ".$province." - ".$pin_code."</span> </p>
            <p> Phương thức thanh toán : <span>".$method."</span> </p>
         </div>
            <a href='products.php' class='btn'>Tiếp tục mua sắm</a>
         </div>
      </div>
      ";
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

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Hoàn thành đơn đặt</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>Giỏ hàng đang rỗng</span></div>";
      }
      ?>
      <span class="grand-total"> Tổng chi phí : <?= number_format($grand_total); ?>VND </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Họ tên</span>
            <input type="text" placeholder="Nhập họ tên" name="name" required>
         </div>
         <div class="inputBox">
            <span>Số điện thoại</span>
            <input type="number" placeholder="Nhập SĐT" name="phone" required>
         </div>
         <div class="inputBox">
            <span>Email</span>
            <input type="email" placeholder="Nhập email" name="email" required>
         </div>
         <div class="inputBox">
            <span>Phương thức thanh toán</span>
            <select name="method">
               <option value="Thanh toán tại chỗ" selected>Thanh toán tại chỗ</option>
               <option value="Credit card">Credit card</option>
               <option value="Ví điện tử">Ví điện tử</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Đường</span>
            <input type="text" placeholder="e.g. Đường 3/2" name="street" required>
         </div>
         <div class="inputBox">
            <span>Phường</span>
            <input type="text" placeholder="e.g. Xuân Khánh" name="ward" required>
         </div>
         <div class="inputBox">
            <span>Huyện</span>
            <input type="text" placeholder="e.g. Ninh Kiều " name="district" required>
         </div>
         <div class="inputBox">
            <span>Tỉnh</span>
            <input type="text" placeholder="e.g. Cần Thơ" name="province" required>
         </div>
         <div class="inputBox">
            <span>Pin code</span>
            <input type="text" placeholder="e.g. 123456" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="Đặt ngay" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>