<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     $userID = $_POST['userID'];
     $userPassword = $_POST['userPassword'];
     $userGender =  $_POST['userGender'];
     $userPhone = $_POST['userPhone'];
     $userEmail = $_POST['userEmail'];
     $userName = $_POST['userName'];
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO account_user (userID, userPassword, userGender, userPhone, userEmail, userName) VALUES (?, ?, ?, ?, ?, ?)");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "ssssss", $userID, $userPassword, $userGender, $userPhone, $userEmail, $userName);
     $check=mysqli_stmt_execute($statement);
     $response = array();
     if($check==true){
      $response["success"] = true;
     }else{
      $response["success"] = false;
     }
     
     //$response["success"] = true;
     //회원 가입 성공을 알려주기 위한 부분임
     echo json_encode($response); 
?>

