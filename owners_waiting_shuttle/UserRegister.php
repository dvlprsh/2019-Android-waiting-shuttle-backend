<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     $userID = $_POST['userID'];
     $userPassword = $_POST['userPassword'];
     $userName =  $_POST['userName'];
     $userRegiNum =  $_POST['userRegiNum'];
     $userEmail = $_POST['userEmail'];
     $userPhone = $_POST['userPhone'];


     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO account_owner VALUES (?, ?, ?, ?, ?, ?)");
     mysqli_stmt_bind_param($statement, "ssssss", $userID, $userPassword, $userName, $userRegiNum, $userEmail, $userPhone);
     mysqli_stmt_execute($statement);
     $response = array();
     $response["success"] = true;
     //회원 가입 성공을 알려주기 위한 부분임
     echo json_encode($response); 
?>

