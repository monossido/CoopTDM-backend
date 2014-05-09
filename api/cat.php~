<?php
include '../config.php';
header('Content-type: application/json');
$api_key_fromClient = $_POST['api_key'];
if($api_key_fromClient == $api_key) {
	// Create connection
	$con=mysqli_connect($server,$user,$password,$db_name);

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$result = mysqli_query($con,"SELECT * FROM Categorie");


	$jsonArray = array();

	while($row = mysqli_fetch_array($result)) {
	  $titolo = $row['Titolo'];
	  $id = $row['Id'];
	  $arr = array('titolo' => $titolo, 'id' => $id);

	array_push($jsonArray, $arr);

	}
	echo json_encode(array_values($jsonArray));
	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
	echo json_encode($jsonArray);
}

?>
