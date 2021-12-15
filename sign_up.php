<?php
	
	include 'connection.php';
    
	if(isset($_POST['submit']))
	{
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$email = mysqli_real_escape_string($con,$_POST['email']);
       	        $mobile = mysqli_real_escape_string($con,$_POST['mobile']);
		$password = mysqli_real_escape_string($con,$_POST['password']);
		$cpassword = mysqli_real_escape_string($con,$_POST['cpassword']);

		function validate_mobile_email($copy_mobile, $copy_email)
		{
  			   $res1 = preg_match('/^[7-9][0-9]{9}$/', $copy_mobile);
  			   $res2 = preg_match('/^[a-zA-Z0-9.!#$%&*+/=?^_{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $copy_email);

  			  if($res1 OR $res2)
  			  {
  			       return false;
  			  }
  			  else
  			  {
  			  	return true;
  			  }
		}

		if(validate_mobile_email($mobile, $email))
		{
  	        ?>
			<script>
				alert("Invalid email or mobile number");
				location.replace("sign_up.php");
			</script>
		<?php
		}
		else
		{

		$emailquery = "SELECT * FROM sign_up WHERE email = '$email'";
		$query = mysqli_query($con, $emailquery);

		$emailcount = mysqli_num_rows($query);

		if($emailcount > 0)
		{
		?>
			<script>
				alert("Email Already exit");
				location.replace("login.php");
			</script>
		<?php
		}
		else
		{
			$len = strlen($password);

			if($len<8)
			{
			?>
				<script>
					alert("Password must be 8 or more characters in length");
					location.replace("sign_up.php");
				</script>
			<?php
			}
			elseif($password == $cpassword)
			{
				$insertquery = "INSERT INTO sign_up (name, email, mobile, password, cpassword) VALUES('$name', '$email','$mobile', '$password', '$cpassword')";

				$iquery = mysqli_query($con, $insertquery);

				if($iquery) 
				{
				?>
					<script>
						alert("Account created successfully");
						location.replace("login.php");
					</script>

				<?php
				}
				else
				{
				?>
					<script>
						alert("Please check your connection");
					</script>
				<?php
				}
			}
			else
			{
			?>
				<script>
					alert("Passwords are not matching");
					location.replace("sign_up.php");
				</script>
			<?php
			}
		}
	  }
	}
	
?>

<!DOCTYPE html>
<html>

<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!--Bootsrap  CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="style.css?version=51">

    <title>INTERNSHIP | Login</title>
</head>

<body>
    <div class="container-fluid" style="height: 100%; padding: 50px;">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Sign Up</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="name" placeholder="Full name" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="email" placeholder="Email address" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" name="mobile" placeholder="Mobile number" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password"
                                required>
                        </div>
                        <input type="submit" type="submit" name="submit" value="Sign up"
                            class="btn float-right login_btn">
                </div>
                </form>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Already have an account?<a href="./login.php">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
