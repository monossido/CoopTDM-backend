<?php
include '../config.php';
header('Content-type: application/json');
$api_key_fromClient = $_POST['api_key'];
if($api_key_fromClient == $api_key) {
	// Create connection
	$con=new mysqli($server,$user,$password,$db_name,null,'/cloudsql/cooptdm:newsapp');

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_query($con, 'SET CHARACTER SET latin1_swedish_ci');
	mysqli_query($con, "SET NAMES 'utf8'");
	$result = mysqli_query($con,"SELECT * FROM Newsletter");


	$newsArray = array();
	$catsArray = array();


	while($row = mysqli_fetch_array($result)) {
	  $id = $row['Id'];
	  $titolo = $row['Titolo'];
	  $data = $row['Data'];
	  $ora = $row['Ora'];
	  $luogo = $row['Luogo'];
	  $testo = $row['Testo'];
	  $categoria = $row['Categoria'];
	  $arr = array('id' => $id, 'titolo' => $titolo, 'data' => $data, 'ora' => $ora, 'luogo' => $luogo, 'testo' => $testo, 'categoria' => $categoria);

	array_push($newsArray, $arr);
	}

	$result = mysqli_query($con,"SELECT * FROM Categorie");

	while($row = mysqli_fetch_array($result)) {
	  $titolo = $row['Titolo'];
	  $id = $row['Id'];
	  $arr = array('titolo' => $titolo, 'id' => $id);

	array_push($catsArray, $arr);
	}
	$jsonArray = array('news' => $newsArray, 'cats' => $catsArray);


	echo json_encode($jsonArray);

	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
	echo json_encode($jsonArray);
}
?>
