 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



$country=isset($_POST['country']) ? $_POST['country'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($country != "" ){ 

    $sql="select * from restaurant_temp where name='$country'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo "'";
        echo $country;
        echo "'은 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);

            array_push($data, 
                array('id'=>$row["id"],
                'name'=>$row["name"],
                'address'=>$row["address"]
            ));
        }


        if (!$android) {
            echo "<pre>"; 
            print_r($data); 
            echo '</pre>';
        }else
        {
            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }
}
else {
    echo "검색할 나라를 입력하세요 ";
}

?>



