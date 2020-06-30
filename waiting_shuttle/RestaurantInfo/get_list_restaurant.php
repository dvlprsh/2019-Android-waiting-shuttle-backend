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
 $stmt = $conn->prepare("SELECT restaurant_addr.owner_id, image, name, kind, address, waiting FROM restaurant_image join restaurant_addr join restaurant_info on restaurant_image.owner_id=restaurant_addr.owner_id and restaurant_image.owner_id=restaurant_info.owner_id;");
 $conn->set_charset("utf8"); 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($owner_id, $image, $name, $kind, $address, $waiting);
 
 $products = array(); 
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
//$temp=['id']=$id;
 $temp['owner_id'] = $owner_id; 
 $temp['image'] = $image; 
 $temp['name'] = $name;
 $temp['kind']=$kind;
 $temp['address']=$address;
 $temp['waiting']=$waiting;
 array_push($products, $temp);
 }
 
 //displaying the result in json format 
 echo json_encode($products);
 ?>