<?php
include 'config.php';

$message_type = $_POST['message_type'];

$title = $_POST['title'];
$message = $_POST['message'];

$status = $_POST['status'];

$test = $_POST['test'];

if(isset($message_type)) {
	// Create connection
	$con=mysqli_connect($server,$user,$password,$db_name);

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$registation_ids = array();
	if($test == "test")
		$result = mysqli_query($con,"SELECT RegisterId FROM Users WHERE Email='racing.inside@gmail.com'");
	else		
		$result = mysqli_query($con,"SELECT RegisterId FROM Users");
	while($row = mysqli_fetch_array($result)) {
		array_push($registation_ids, $row['RegisterId']);
	}

	if($status="status")
		$cron = true;
	else
		$cron = false;
	$msg=array("message_type"=>$message_type, "title"=>$title, "message"=>$message, "status"=>$cron);
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
} else {
	echo '<!DOCTYPE html>
<html>
<head>
<title>Bootstrap 101 Template</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
 <script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it\'s height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

    </style>
</head><body>
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Cooperativa Terra di Mezzo - Crea una nuova news</h1></div>';

echo '<form action="sendGCM.php" method="post">
	Tipo di push: <select name="message_type">
	<option value="news">Notifica generica nuove news</option>
	<option value="notification">Notifica nuova news con testo</option>
	<option value="cron">Disabilita/abilita ricerca nuove news con servizio</option>
	</select><br>
	Titolo news (valido solo opzione 2): <input type="text" name="title"><br>
	Messaggio news (valido solo opzione 2): <input type="text" name="message"><br>
	<input type="checkbox" name="status" value="status"/> cron abilitato/disabilitato<br>
	<input type="checkbox" name="test" value="test"/> invia solo a account di test<br>
	<input type="submit">
	</form>';
echo '      </div>

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">Copyright <a href="http://lorenzobraghetto.com">Lorenzo Braghetto</a> license GPL <a href="http://github.com/monossido">source</a></p>
      </div>
    </div>';
}
?>
