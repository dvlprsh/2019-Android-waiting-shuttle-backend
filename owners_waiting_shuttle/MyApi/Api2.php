<?php 
 
 //Constants for database connection
 define('DB_HOST','localhost');
 define('DB_USER','seohee');
 define('DB_PASS', password);
 define('DB_NAME','waiting_shuttle');
 
 //We will upload files to this folder
 //So one thing don't forget, also create a folder named uploads inside your project folder i.e. MyApi folder
 define('UPLOAD_PATH', 'uploads/');
 
 //connecting to database 
 $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Unable to connect');
 $conn->set_charset("utf8"); //이렇게 하면 jsonException 안뜨고
 //mysqli_set_charset($conn, "utf8");
 /*이렇게 하면 jsonException 뜬다
 if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
} else {
    printf("Current character set: %s\n", $conn->character_set_name());
}*/
 //An array to display the response
 $response = array();
 
 //if the call is an api call 
 if(isset($_GET['apicall'])){
 
 //switching the api call 
 switch($_GET['apicall']){
 
 //if it is an upload call we will upload the image
 case 'uploadpic':
 
 //first confirming that we have the image and tags in the request parameter
 //$_FILES['userfile']['name']<==서버에 저장된 업로드된 파일의 임시 파일 이름.
 if(isset($_FILES['pic']['name']) && isset($_POST['owner_userID'])){
 
 //uploading file and storing it to database as well 
 try{
 move_uploaded_file($_FILES['pic']['tmp_name'], UPLOAD_PATH . $_FILES['pic']['name']);
 //(int)$owner_id=$_POST['owner_id'];
 $stmt = $conn->prepare("INSERT INTO restaurant_image (image, owner_userID, owner_id, addr_id) VALUES (?, ?, ?, ?)");
(int)$nono=0;
(int)$owner_id=$_POST['owner_id'];
(int)$addr_id=$_POST['addr_id'];
 $stmt->bind_param("ssii", $_FILES['pic']['name'], $_POST['owner_userID'], $owner_id, $addr_id);
 if($stmt->execute()){
 $response['error'] = false;
 $response['message'] = 'File uploaded successfully';
 }else{
 throw new Exception("Could not upload file");
 }
 }catch(Exception $e){
 $response['error'] = true;
 $response['message'] = 'Could not upload file';
 }
 
 }else{
 $response['error'] = true;
 $response['message'] = "Required params not available";
 }
 
 break;
 
 //in this call we will fetch all the images 
 case 'getpics':
 
 //getting server ip for building image url 
 $server_ip = gethostbyname(gethostname());
 
 //query to get images from database
 $stmt = $conn->prepare("SELECT id, image, name, address FROM restaurant_temp");
 $stmt->execute();
 $stmt->bind_result($id, $image, $name, $address);
 
 $images = array();
 
 //fetching all the images from database
 //and pushing it to array 
 while($stmt->fetch()){
 $temp = array();
 $temp['id'] = $id; 
 $temp['image'] = 'http://' . $server_ip . '/owners_waiting_shuttle/MyApi/'. UPLOAD_PATH . $image; 
 $temp['name'] = $name;
 $temp['address'] = $address;
 
 array_push($images, $temp);
 }
 
 //pushing the array in response 
 $response['error'] = false;
 $response['images'] = $images; 
 break; 
 
 default: 
 $response['error'] = true;
 $response['message'] = 'Invalid api call';
 }
 
 }else{
 header("HTTP/1.0 404 Not Found");
 echo "<h1>404 Not Found</h1>";
 echo "The page that you have requested could not be found.";
 exit();
 }
 
 //displaying the response in json 
 header('Content-Type: application/json');
 echo json_encode($response);
 ?>