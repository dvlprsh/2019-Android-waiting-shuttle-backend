<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     (int)$owner_id = $_POST['owner_id'];
     (int)$addr_id = $_POST['addr_id'];
   
     $name =  $_POST['name'];
     $kind = $_POST['kind'];
     $tel = $_POST['tel'];
     $time =  $_POST['time'];
     $breaktime = $_POST['breaktime'];
     $day_off = $_POST['day_off'];
     $price = $_POST['price'];
    
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO restaurant_info 
     (addr_id, owner_id, name, kind, tel, time, breaktime, day_off, price)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "iisssssss", $addr_id, $owner_id, $name, $kind, $tel, $time, $breaktime, $day_off, $price);
     mysqli_stmt_execute($statement);
     mysqli_stmt_store_result($statement);
     mysqli_stmt_bind_result($statement);
     $response = array();

  
        $response["success"] = true;
       
    //account_user 테이블 is_owner 칼럼 갱신
/*
    $sql = "UPDATE account_user SET is_ower=1 WHERE id=owner_id";

if (mysqli_query($con, $sql)) {
    $response["update"]=true;
} else {
    $response["update"]=false;
}*/

$statement = mysqli_prepare($con, "UPDATE account_user SET is_owner=1 WHERE id=?");
//$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
mysqli_stmt_bind_param($statement, "i", $owner_id);
mysqli_stmt_execute($statement);
mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($statement);
$response["update"]=true;
    //test
      
  
     //$response["success"] = true;
     //회원 가입 성공을 알려주기 위한 부분임
     echo json_encode($response); 
?>