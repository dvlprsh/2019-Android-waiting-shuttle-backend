<?php

  //header('Content-Type: application/json; charset=UTF-8');
   //database constants
 define('DB_HOST', 'localhost');
 define('DB_USER', 'seohee');
 define('DB_PASS', password);
 define('DB_NAME', 'waiting_shuttle');
 
 //connecting to database and getting the connection object
 $connect =mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
 //Checking if any error occured while connecting
 if (mysqli_connect_errno($connect)) {


 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 die();
 }else {


}
mysqli_set_charset($connect, "utf8");
  




    $query = "SELECT * FROM restaurant_temp where id='77'";


    $result = mysqli_query($connect, $query);
   // $row = mysqli_fetch_array($result);

   // echo json_encode($row);
//test
if($result){

    header('Content-Type: application/json; charset=utf8');
    $number_of_rows = mysqli_num_rows($result); //열수 반환
   

        $response = array();

        if($number_of_rows >0) {
            while($row = mysqli_fetch_assoc($result)) {
    

             
                echo json_encode($row, JSON_UNESCAPED_UNICODE);
    
            }
        }
    
      

}else{
    echo "조회 오류";

}
//test



    mysqli_close($connect);

?>

