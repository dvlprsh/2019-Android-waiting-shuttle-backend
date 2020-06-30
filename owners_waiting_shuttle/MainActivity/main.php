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

  
        $response["success"] = true;
        $response["test"] =  $_POST['owner_id'];

      
    //주소 테이블 id(key) 값 가져오기
    $statement = mysqli_prepare($con, "SELECT address FROM restaurant_addr WHERE owner_id = ?");
    mysqli_stmt_bind_param($statement, "i", $owner_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $address);

    while(mysqli_stmt_fetch($statement)){
      $response["address"] = $address;
      
    }
    //이미지 테이블 id(key) 값 가져오기
    $statement = mysqli_prepare($con, "SELECT image FROM restaurant_image WHERE owner_id = ?");
    mysqli_stmt_bind_param($statement, "i", $owner_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $image);

    while(mysqli_stmt_fetch($statement)){
      $response["image"] = $image;
      
    }
    //Restaurant(String image, String name, String kind, String address, String tel, String time, String day_off, String breaktime, String price)
    //상세 테이블 id(key) 값 가져오기
    $statement = mysqli_prepare($con, "SELECT name, kind, tel, time, day_off, breaktime, price FROM restaurant_info WHERE owner_id = ?");
    mysqli_stmt_bind_param($statement, "i", $owner_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $name, $kind, $tel, $time, $day_off, $breaktime, $price);

    while(mysqli_stmt_fetch($statement)){
      $response["name"] = $name;
      $response["kind"] = $kind;
      $response["tel"] = $tel;
      $response["time"] = $time;
      $response["day_off"] = $day_off;
      $response["breaktime"] = $breaktime;
      $response["price"] = $price;

      
    }
     //$response["success"] = true;
     //회원 가입 성공을 알려주기 위한 부분임
     echo json_encode($response); 
?>