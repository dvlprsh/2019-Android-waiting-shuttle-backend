<?php 
 
 /*
 * Created by Belal Khan
 * website: www.simplifiedcoding.net 
 * Retrieve Data From MySQL Database in Android
 */
 
 //database constants
 define('DB_HOST', 'localhost');
 define('DB_USER', 'seohee');
 define('DB_PASS', password);
 define('DB_NAME', 'waiting_shuttle');
 
 //connecting to database and getting the connection object
 $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
 //Checking if any error occured while connecting
 if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 die();
 }
 
 //creating a query
 $stmt = $conn->prepare("SELECT id, userID, profile_image_url FROM account_user;");
 $conn->set_charset("utf8"); 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($id, $userID, $profile_image_url);
 
 $users = array(); 
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
//$temp=['id']=$id;
 $temp['id'] = $id; 
 $temp['userID'] = $userID; 
 $temp['profile_image_url'] = $profile_image_url;

 array_push($users, $temp);
 }
 
 //displaying the result in json format 
 echo json_encode($users);
 ?>