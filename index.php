<?php
include 'config.php';

// Create connection
$con=mysqli_connect($server,$user,$password,$db_name);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM Categorie");
$users = mysqli_query($con,"SELECT * FROM Users");

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

echo '<form action="createNewsletter.php" method="post">
	Titolo news: <input type="text" name="titolo" required><br>
	Data: <input type="text" name="data"><br>
	Ora: <input type="text" name="ora"><br>
	Luogo: <input type="text" name="luogo"><br>
	Testo: <textarea name="testo" required></textarea><br>
	Categoria: <select name="categoria">';
	while($row = mysqli_fetch_array($result)) {
	  $id = $row['Id'];
	  $titolo = $row['Titolo'];
	  echo '<option value="'.$id.'">'.$titolo.'</option>';
	}
	echo '</select><br>';
	echo 'Tags (opzionale - separati da virgole): <input type="text" name="tags"><br>';
	echo '<br>
	<input type="submit">
	</form>';

echo '<br /><h1>Dispositivi registrati</h1>
	<table class="table" width="100%">
	<tr><th>Num.</th><th>Email</th><th>Versione Android</th><th>Versione App</th><th>Data registrazione</th></tr>';
	while($row = mysqli_fetch_array($users)) {
	  $i++;
	  $DeviceId = $row['DeviceId'];
	  $RegisterId = $row['RegisterId'];
	  $Email = $row['Email'];
	  $AndroidVersion = $row['AndroidVersion'];
	  $AppVersion = $row['AppVersion'];
	  $Data = $row['Data'];
	  echo '<tr><td>'.$i.'</td><td>'.$Email.'</td><td>'.$AndroidVersion.'</td><td>'.$AppVersion.'</td><td>'.$Data.'</td></tr>';
	}
echo	'</table>';

echo '      </div>

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">Copyright <a href="http://lorenzobraghetto.com">Lorenzo Braghetto</a> license GPL <a href="http://github.com/monossido/CoopTDM-backend">source</a></p>
      </div>
    </div>';
?>
