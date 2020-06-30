<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     (int)$owner_id = $_POST['owner_id'];
  
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     $response = array();
     //이미지 테이블
     $statement = mysqli_prepare($con, "SELECT id  FROM restaurant_image WHERE owner_id=?");
     
     mysqli_stmt_bind_param($statement, "i", $owner_id);
     mysqli_stmt_execute($statement);
     mysqli_stmt_store_result($statement);
     mysqli_stmt_bind_result($statement, $image_id);
    
    while(mysqli_stmt_fetch($statement)){
      $response["image_id"] = $image_id;
     

    }
    //주소 테이블
    $statement = mysqli_prepare($con, "SELECT id, longitude, latitude FROM restaurant_addr WHERE owner_id=?");
    //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
    mysqli_stmt_bind_param($statement, "i", $owner_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $addr_id, $longitude, $latitude);
   
   while(mysqli_stmt_fetch($statement)){
    
     $response["addr_id"] = $addr_id;
     $response["longitude"] = $longitude;
     $response["latitude"] = $latitude;
    

   }

   //상세정보 테이블
   //주소 테이블
   $statement = mysqli_prepare($con, "SELECT tel, time, breaktime, day_off, price, waiting FROM restaurant_info WHERE owner_id=?");
   //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
   mysqli_stmt_bind_param($statement, "i", $owner_id);
   mysqli_stmt_execute($statement);
   mysqli_stmt_store_result($statement);
   mysqli_stmt_bind_result($statement,$tel, $time, $breaktime, $day_off, $price, $waiting);
  
  while(mysqli_stmt_fetch($statement)){

    $response["tel"] = $tel;
    $response["time"] = $time;
    $response["breaktime"] = $breaktime;
    $response["day_off"] = $day_off;
    $response["price"] = $price;
    $response["waiting"] = $waiting;

  }
  
    $response["success"] = true;
       

     echo json_encode($response); 
?>