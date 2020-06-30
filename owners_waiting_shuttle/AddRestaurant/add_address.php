<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     (int)$owner_id = $_POST['owner_id'];
     $owner_userID = $_POST['owner_userID'];
     $address =  $_POST['address'];
     $longitude = $_POST['longitude'];
     $latitude = $_POST['latitude'];
    
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO restaurant_addr (owner_id, owner_userID, address, longitude, latitude) VALUES (?, ?, ?, ?, ?)");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "issss", $owner_id, $owner_userID, $address, $longitude, $latitude);
     mysqli_stmt_execute($statement);
     mysqli_stmt_store_result($statement);
     mysqli_stmt_bind_result($statement);
     $response = array();

  
        $response["success"] = true;
       

      
    //주소 테이블 id(key) 값 가져오기
    $statement2 = mysqli_prepare($con, "SELECT id FROM restaurant_addr WHERE owner_userID = ?");
    mysqli_stmt_bind_param($statement2, "s", $owner_userID);
    mysqli_stmt_execute($statement2);
    mysqli_stmt_store_result($statement2);
    mysqli_stmt_bind_result($statement2, $id);

    while(mysqli_stmt_fetch($statement2)){
      $response["addr_id"] = $id;
      
    }
     //$response["success"] = true;
     //회원 가입 성공을 알려주기 위한 부분임
     echo json_encode($response); 
?>