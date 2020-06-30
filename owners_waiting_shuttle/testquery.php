<?php
$con=mysqli_connect("localhost","seohee",password,"waiting_shuttle");
 
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$ID = $_GET['ID'];
$NAME = $_GET['NAME'];
$result = mysqli_query($con,"SELECT image FROM restaurant_temp where name='$ID' and address='$NAME'");
 
$row = mysqli_fetch_array($result);
$data = $row[0];
 
if($data){
echo $data;
}
mysqli_close($con);
?>