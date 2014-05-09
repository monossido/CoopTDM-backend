<?php
include '../config.php';
header('Content-type: application/json');
$api_key_fromClient = $_POST['api_key'];
if($api_key_fromClient == $api_key) {
	$deviceId = $_POST['deviceId'];
	$registerId = $_POST['registerId'];
	$email = $_POST['email'];
	$android_version = $_POST['android_version'];
	$app_version = $_POST['app_version'];

	// Create connection
	$con=new mysqli($server,$user,$password,$db_name,null,'/cloudsql/cooptdm:newsapp');

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sqlCheck = "SELECT * FROM Users WHERE DeviceId='$deviceId')";

	$result=mysqli_query($con,$sqlCheck);
	$row="";
	if($result!=false) {
		$row = mysqli_fetch_array($result);
	}
	$sql="";

	//TODO dichiarare unico
	//TODO inserire più info
	if(sizeof($row)>0) {
		$sql = "UPDATE Users SET RegisterId='$registerId', Email='$email', AndroidVersion='$android_version', AppVersion='$app_version' WHERE DeviceId='$deviceId'";
	} else {
		$sql = "INSERT INTO Users (DeviceId, RegisterId, Email, AndroidVersion, AppVersion) VALUES ('$deviceId', '$registerId', '$email', '$android_version', '$app_version')";
	}

	if (!mysqli_query($con,$sql)) {
	  die('Error: ' . mysqli_error($con));
	 }
	$jsonArray = array('result'=>'success');

	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
}

echo json_encode($jsonArray);

?>
