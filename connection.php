  <?php
	error_reporting(0);
	$username = 'root';
	$password = '';
	$server = 'localhost';
	$db = 'login_db';

	$con = mysqli_connect($server, $username, $password, $db);

	if ($con) 
	{
		//echo "connection successful";
        ?>
  <script>
//alert("connection successful");
  </script>
  <?php

  }
  else
  {
  echo "Not connected";
  }

  ?>