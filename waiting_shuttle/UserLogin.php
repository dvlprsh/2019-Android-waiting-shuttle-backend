<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //�ȵ���̵� �����κ��� �Ʒ� ������ ����
    $userID = $_POST["userID"];
    $userPassword = $_POST["userPassword"];
    $statement = mysqli_prepare($con, "SELECT userID, is_owner, userPhone FROM account_user WHERE userID = ? AND userPassword = ?");
    mysqli_stmt_bind_param($statement, "ss", $userID, $userPassword);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $userID, $is_owner, $userPhone);
    $response = array();
    $response["success"] = false;
    while(mysqli_stmt_fetch($statement)){
      $response["success"] = true;
      $response["userID"] = $userID;
      $response["userPhone"] = $userPhone;
      if($is_owner==0){
        $response["is_owner"]=false;

      }else{
        $response["is_owner"]=true;
      }
        
      
    }

    
   
    //로그인 한 아이디의 id 칼럼값 가져오기
    $statement = mysqli_prepare($con, "SELECT id FROM account_user WHERE userID = ?");
    mysqli_stmt_bind_param($statement, "s", $userID);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id);

    while(mysqli_stmt_fetch($statement)){
      $response["id"] = $id;
      
    }
 //로그인 한 아이디의 id 칼럼값 가져오기
    echo json_encode($response);
?>



