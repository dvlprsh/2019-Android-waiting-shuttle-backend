<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     (int)$owner_id = $_POST['owner_id'];
     //(int)$addr_id = $_POST['addr_id'];
   
     $phone =  $_POST['phone'];
     $person_count = $_POST['person_count'];
     
    
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     /*
     1. $statement--waiting 테이블에 대기정보 INSERT
     2. $statement2--현재 식당 웨이팅 수 waiting 테이블로부터 가져오기(owner_id=현재id 인 행 수를 반환)
     3. $statement3--restaurant_info 테이블에 waiting 칼럼에 현재 대기 팀수 저장
     모두 완료 후 $response["success"] = true; 반환
     */
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "INSERT INTO waiting (owner_id, phone, person_number) VALUES (?, ?, ?)");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "iss", $owner_id, $phone, $person_count);
 
        $response = array();
    
        if(mysqli_stmt_execute($statement)){
            //2. $statement2--현재 식당 웨이팅 수 waiting 테이블로부터 가져오기(owner_id=현재id 인 행 수를 반환)
            $statement2 = mysqli_prepare($con, "SELECT * FROM waiting WHERE owner_id=?");
            //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
            mysqli_stmt_bind_param($statement2, "i", $owner_id);
            if(mysqli_stmt_execute($statement2)){
                mysqli_stmt_store_result($statement2);
                (int)$num_row=mysqli_stmt_num_rows($statement2); //현대 대기 팀 수 가져오기
               
                $response["waiting"] = $num_row;
                //3. $statement3--restaurant_info 테이블에 waiting 칼럼에 현재 대기 팀수 저장        
                $statement3 = mysqli_prepare($con, "UPDATE restaurant_info SET waiting=? WHERE owner_id=?");
     
                mysqli_stmt_bind_param($statement3, "ii", $num_row, $owner_id);
                if(mysqli_stmt_execute($statement3)){
                    $response["success"] = true;
                }
            }
        //$response["success"] = true;
       }
     echo json_encode($response); 
?>