<?php

require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

date_default_timezone_set("Asia/Kolkata");

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    redirect('index.php');
}

if(isset($_POST['pay_now']))
{
    $ConfirmationNumber = $_SESSION['uId'] . random_int(11111, 9999999);

    $frm_data = filteration($_POST);

    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `booking_status`)
    VALUES (?,?,?,?,?,?)";

    insert($query1,[$_SESSION['uId'],$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ConfirmationNumber,'booked'],'isssss');
    
    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`,
    `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";

    insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],
       $_SESSION['room']['payment'],$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');
       
}

?>


<html>
  <body>
    <div class="container">
      <div class="row">
        <?php  
          echo '
          <div class="col-12 my-5 mb-3 px-4">
            <h2>PAYMENT STATUS</h2>
          </div>
          <div class="col-12 px-4">
            <p class="fw-bold alert alert-success">
              <i class="bi bi-check-circle-fill"></i>
              Payment done! Booking successful!
            </p>
            <p>Confirmation Number: ' . $ConfirmationNumber . '</p>
            <a href="bookings.php">Go to Bookings</a>
          </div>
          ';
        ?>       
      </div>
    </div>        
  </body>
</html>





