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

	mysqli_query($con, 'SET CHARACTER SET latin1_swedish_ci');
	mysqli_query($con, "SET NAMES 'utf8'");

	$newsArray = array();
	$catsArray = array();

	$result = mysqli_query($con,"SELECT * FROM Categorie");

	while($row = mysqli_fetch_array($result)) {
	  $titolo = $row['Titolo'];
	  $id = $row['Id'];
	  $arr = array('titolo' => $titolo, 'id' => $id);

	array_push($catsArray, $arr);
	}

	$result = mysqli_query($con,"SELECT * FROM Newsletter ORDER BY Id DESC limit 30");

	while($row = mysqli_fetch_array($result)) {
	  $id = $row['Id'];
	  $titolo = $row['Titolo'];
	  $data = $row['Data'];
	  $ora = $row['Ora'];
	  $luogo = $row['Luogo'];
	  $testo = $row['Testo'];
	  $categoria = $row['Categoria'];
	  $tags = $row['Tags'];
	  $datapubblicazione = $row['DataPubblicazione'];

	  $catsTitolo = $catsArray[$categoria-1];
	  $catsTitolo = $catsTitolo['titolo'];

	  //aggiungo a tags di default category e luogo
	  $tags_result = "$catsTitolo";
	  if(strlen($tags)>0)
	  	$tags_result = "$tags_result,$tags";

	  if(strlen($luogo)>0)
	  	  $tags_result = "$tags_result,$luogo";

	  $arr = array('id' => $id, 'titolo' => $titolo, 'data' => $data, 'ora' => $ora, 'luogo' => $luogo, 'testo' => $testo, 'categoria' => $categoria, 'tags' => $tags_result, 'dataPubblicazione' => $datapubblicazione);

	array_push($newsArray, $arr);
	}

	$jsonArray = array('news' => $newsArray, 'cats' => $catsArray);


	echo json_encode($jsonArray);

	mysqli_close($con);
} else {
	$jsonArray = array('result'=>'failed');
	echo json_encode($jsonArray);
}
?>
