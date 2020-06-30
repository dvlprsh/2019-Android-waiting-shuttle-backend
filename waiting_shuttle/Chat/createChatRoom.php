<?php
    $con = mysqli_connect('localhost', 'seohee', password, 'waiting_shuttle');
     //안드로이드 앱으로부터 아래 값들을 받음
     //String->int 변환
     $last_message= $_POST['last_message'];
     $restaurant_name= $_POST['restaurant_name'];
     $userID= $_POST['userID'];
     (int)$owner_id = $_POST['owner_id'];
     (int)$user_id = $_POST['user_id'];
    

     
    
     if (mysqli_connect_errno($con)) {


        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
        }else {
       
           
       }
     mysqli_set_charset($con, "utf8");
     /*
     1. $statement--chat_room 테이블에 행이 존재하는지 확인
     2. $statement2--없으면 추가
     3. $statement3--room_number 반환
     모두 완료 후 $response["success"] = true; 반환
     */
     //insert 쿼리문을 실행함
     $statement = mysqli_prepare($con, "SELECT room_number FROM chat_room WHERE owner_id=? and user_id=?");
     //$statement = mysqli_prepare($con, "INSERT INTO account_user VALUES (userID, userPassword, userGender, userPhone, userEmail, userName)");
     mysqli_stmt_bind_param($statement, "ii", $owner_id, $user_id);
   
     
        $response = array();

        if(mysqli_stmt_execute($statement)){
            mysqli_stmt_store_result($statement);
            //mysqli_stmt_bind_result($statement, $room_number2);
                (int)$num_row=mysqli_stmt_num_rows($statement); //현재 채팅방 존재하는지

                $response["is_room"] = $num_row;
                if($num_row==0){
                    $response["test1"] = $num_row;
                    //채팅방 존재하지 않으면
                    $statement2 = mysqli_prepare($con, "INSERT INTO chat_room (restaurant_name, owner_id, user_id, last_message, userID) VALUES (?, ?, ?, ?, ?)");
                    $response["test2"] = $num_row;
                    mysqli_stmt_bind_param($statement2, "siiss", $restaurant_name, $owner_id, $user_id, $last_message, $userID);
                    $response["test3"] = $restaurant_name;
                    $response["test33"] = $last_message;
                    if(mysqli_stmt_execute($statement2)){
                        $response["test4"] = $num_row;
                        $statement3 = mysqli_prepare($con, "SELECT room_number FROM chat_room WHERE owner_id=? and user_id=?");
                        mysqli_stmt_bind_param($statement3, "ii", $owner_id, $user_id);
                        mysqli_stmt_store_result($statement3);
                        mysqli_stmt_bind_result($statement3, $room_number);
                        while(mysqli_stmt_fetch($statement)){
    
                            $response["room_number"] = $room_number;
                        

                        }
                        $response["success"] = true;
                        
                    }
                }else{
                    $response["test2"] = $num_row;
                    //$response["success"] = true;
                    //$response["room_number"] = $room_number2;
                    $statement3 = mysqli_prepare($con, "SELECT room_number FROM chat_room WHERE owner_id=? and user_id=?");
                        mysqli_stmt_bind_param($statement3, "ii", $owner_id, $user_id);
                        mysqli_stmt_store_result($statement3);
                        mysqli_stmt_bind_result($statement3, $room_number2);
                        while(mysqli_stmt_fetch($statement)){
    
                            $response["room_number"] = $room_number2;
                            $response["owner_id"] = $owner_id;
                            $response["user_id"] = $user_id;
                        }
                        $response["success"] = true;
                }

        }
    /*
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
        }*/
        
     echo json_encode($response); 
?>