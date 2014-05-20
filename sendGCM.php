<?php
include 'config.php';

// Create connection
$con=mysqli_connect($server,$user,$password,$db_name);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$registation_ids = array();
$result = mysqli_query($con,"SELECT RegisterId FROM Users");
while($row = mysqli_fetch_array($result)) {
	array_push($registation_ids, $row['RegisterId']);
}


#$msg=array("message_type"=>'news');
$msg=array("message_type"=>'notification', "title"=>'Prova', "message"=>'Prova2');
$url='https://android.googleapis.com/gcm/send';
$fields=array
 (
  'registration_ids'=>$registation_ids,
  'data'=>$msg
 );
$headers=array
 (
  'Authorization: key=AIzaSyBF0xO7MxWEWaG_o28IMr25IfxHiGt1xW4',
  'Content-Type: application/json'
 );
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
$result=curl_exec($ch);
curl_close($ch);
echo $result;
?>
