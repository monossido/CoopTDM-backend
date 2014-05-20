<?php
include 'config.php';

// Create connection
$con=mysqli_connect($server,$user,$password,$db_name);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM Categorie");

echo "<head><body>";

echo '<form action="createNewsletter.php" method="post">
	<!--Numero newsletter: <input type="text" name="num"><br>-->
	Titolo news: <input type="text" name="titolo"><br>
	Data: <input type="text" name="data"><br>
	Ora: <input type="text" name="ora"><br>
	Luogo: <input type="text" name="luogo"><br>
	Testo: <textarea name="testo" ></textarea><br>
	Categoria: <select name="categoria">';
	while($row = mysqli_fetch_array($result)) {
	  $id = $row['Id'];
	  $titolo = $row['Titolo'];
	  echo '<option value="'.$id.'">'.$titolo.'</option>';
	}
	echo 'Tags (opzionale - separati da virgole): <input type="text" name="tags"><br>';
	echo '</select><br>
	<input type="submit">
	</form>';
?>
