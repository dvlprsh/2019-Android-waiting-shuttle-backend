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
 $stmt = $conn->prepare("SELECT image, address, name, restaurant_addr.owner_id FROM restaurant_image join restaurant_addr join restaurant_info on restaurant_image.owner_id=restaurant_addr.owner_id and restaurant_image.owner_id=restaurant_info.owner_id;");
 $conn->set_charset("utf8"); 
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result($image, $address, $name, $id);
 
 $products = array(); 
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
//$temp=['id']=$id;
 $temp['title'] = $name; 
 $temp['image'] = $image; 
 $temp['address'] = $address;
 $temp['id']=$id;
 array_push($products, $temp);
 }
 
 //displaying the result in json format 
 echo json_encode($products);
 ?>