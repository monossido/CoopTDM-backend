<?php
include '../config.php';

$titolo = $_POST['titolo'];
$colore = $_POST['colore'];
$data = $_POST['data'];
$ora = $_POST['ora'];
$luogo = $_POST['luogo'];
$testo = $_POST['testo'];
$categoria = $_POST['categoria'];
$titolo = mysql_escape_mimic($titolo);
$colore = mysql_escape_mimic($colore);
$data = mysql_escape_mimic($data);
$ora = mysql_escape_mimic($ora);
$luogo = mysql_escape_mimic($luogo);
$testo = mysql_escape_mimic($testo);
$categoria = mysql_escape_mimic($categoria);

// Create connection
$con=new mysqli($server,$user,$password,$db_name,null,'/cloudsql/cooptdm:newsapp');

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO Newsletter (Titolo, Data, Ora, Luogo, Testo, Categoria) VALUES ('$titolo', '$data','$ora','$luogo','$testo','$categoria')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
echo "Dati inseriti";

mysqli_close($con);


function mysql_escape_mimic($inp) { 
    if(is_array($inp)) 
        return array_map(__METHOD__, $inp); 

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
} 
?>
