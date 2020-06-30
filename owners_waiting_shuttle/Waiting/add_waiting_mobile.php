<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     (int)$owner_id = $_POST['owner_id'];
     //(int)$addr_id = $_POST['addr_id'];
   
     $phone =  $_POST['phone'];
     $person_count = $_POST['person_count'];
     
     (int)$user_id =  $_POST['user_id'];
     $user_userID = $_POST['user_userID'];
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO waiting (owner_id, user_id, user_userID ,phone, person_number) VALUES (?, ?, ?, ?, ?)");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "iisss", $owner_id, $user_id, $user_userID,$phone, $person_count);
     mysqli_stmt_execute($statement);
     mysqli_stmt_store_result($statement);
     mysqli_stmt_bind_result($statement);
     $response = array();

  
        $response["success"] = true;
       

     echo json_encode($response); 
?>