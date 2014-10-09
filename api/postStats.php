<?php
include '../config.php';
header('Content-type: application/json');
$api_key_fromClient = $_POST['api_key'];
if($api_key_fromClient == $api_key) {
	$email = $_POST['email'];
	$name = $_POST['name'];
	$app = $_POST['app'];
	$tempo = $_POST['tempo'];
	$difficolta = $_POST['difficolta'];
	$soloClassifica = $_POST['soloClassifica'];

	// Create connection
	$con=mysqli_connect($server,$user,$password,$db_name);

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if($app == 'orienteering') {
		$sqlCheck = "INSERT INTO OrienteeringUser (Email, Nome, Tempo, Difficolta) VALUES ('$email', '$name', '$tempo', '$difficolta')";
		$sql = "SELECT * FROM OrienteeringUser LIMIT 20";
	} else if($app == 'castello') {
		$sqlCheck = "INSERT INTO CastelloUser (Email, Nome, Tempo, Difficolta) VALUES ('$email', '$name', '$tempo', '$difficolta')";
		$sql = "SELECT * FROM CastelloUser LIMIT 20";
	}
	if($soloClassifica=="false") {
		$resultInsert=mysqli_query($con, $sqlCheck);
	} else {
		$resultInsert = true;
	}
	$arrayItem = array();

	if($resultInsert!=false) {
		$result=mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($result)) {
			$nome = $row["Nome"];
			//$email = $row["email"];
			$tempo = $row["Tempo"];
			$difficolta = $row["Difficolta"];
			$jsonArrayItem = array('nome'=>$nome, 'tempo'=>$tempo, 'difficolta'=>$difficolta);
			array_push($arrayItem, $jsonArrayItem);
		}

		$jsonArray = array('result'=>'success', 'punteggi'=>$arrayItem, 'soloClassifica'=>$soloClassifica);
	} else {
		$jsonArray = array('result'=>'failed');
	}

	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
}

echo json_encode($jsonArray);

?>
