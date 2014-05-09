<?php
include '../config.php';
header('Content-type: application/json');
$api_key_fromClient = $_POST['api_key'];
if($api_key_fromClient == $api_key) {
	$lastNewsId = $_POST['lastNewsId'];

	// Create connection
	$con=new mysqli($server,$user,$password,$db_name,null,'/cloudsql/cooptdm:newsapp');

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$result = mysqli_query($con,"SELECT * FROM Newsletter WHERE Id > $lastNewsId");

	$row = mysqli_fetch_array($result);
	$jsonResult = "";

	if(sizeof($row)>0)
		$jsonResult = "true";
	else
		$jsonResult = "false";

	echo "{\"result\":$jsonResult}";

	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
	echo json_encode($jsonArray);
}
?>
