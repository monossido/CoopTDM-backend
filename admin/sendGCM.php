<?php
include '../config.php';

// Create connection
$con=new mysqli($server,$user,$password,$db_name,null,'/cloudsql/cooptdm:newsapp');

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
$fields=array
 (
  'registration_ids'=>$registation_ids,
  'data'=>$msg
 );

$data = json_encode($fields);
$context = [
  'http' => [
    'method' => 'POST',
    'header' => 'Authorization: key=AIzaSyBF0xO7MxWEWaG_o28IMr25IfxHiGt1xW4' . "\r\n" .
                    'Content-Type: application/json' . "\r\n",
    'content' => $data
  ]
];
$context = stream_context_create($context);
$result = file_get_contents('https://android.googleapis.com/gcm/send', false, $context);

echo $result;
?>
