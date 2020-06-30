<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //�ȵ���̵� �����κ��� �Ʒ� ������ ����
    (int) $owner_id = $_POST["owner_id"];
    //$userPassword = $_POST["userPassword"];
    $statement = mysqli_prepare($con, "SELECT image FROM restaurant_image WHERE owner_id = ?");
    mysqli_stmt_bind_param($statement, "i", $owner_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $image);
    $response = array();
    $response["success"] = false;
    while(mysqli_stmt_fetch($statement)){
      $response["success"] = true;
      $response["image"] = $image;
    }
    echo json_encode($response);
?>



