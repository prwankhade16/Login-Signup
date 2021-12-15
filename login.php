<?php

	session_start();

    if (isset($_SESSION["btn_disable_time"]))
    {
        $diff = time() - $_SESSION["btn_disable_time"];
        
        if($diff > 30)
        {
            unset($_SESSION["btn_disable_time"]);
            unset($_SESSION["total_attempts"]);
        }
    }

	include 'connection.php';

	if(isset($_POST['submit']))
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		$email_present = "SELECT * FROM sign_up WHERE email='$email' ";
		$query = mysqli_query($con, $email_present);

		$email_count = mysqli_num_rows($query);

		if($email_count)
		{
			   $email_pass = mysqli_fetch_assoc($query);

			   $db_pass = $email_pass['password'];

			   $_SESSION['username'] = $email_pass['username'];
			   $_SESSION['email'] = $email_pass['email'];

			//$pass_decode = password_verify($password,$db_pass);

			if($db_pass === $password)
			{
				//$_SESSION["msg"] = "Login Successful";
                ?>
<script>
location.replace("home.html");
</script>
<?php
			}
			else
			{
                $_SESSION["total_attempts"] += 1;
                $_SESSION["msg"] = "Email or Password is Incorrect";
			}
		}
		else
		{
            $_SESSION["total_attempts"] += 1;
            $_SESSION["msg"] = "Please Check your Login Credentials";
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
    <div class="container-fluid">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="email" placeholder="Email address" required>
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="row align-items-center remember">
                            <input type="checkbox">Remember Me
                        </div>
                        <?php
                        if (isset($_SESSION["msg"]))
                        {
                            ?>
                        <p style="color: orange; font-size: 15px;">
                            <?= $_SESSION["msg"];?>
                        </p>
                        <?php unset($_SESSION["msg"]);
                        }
                        ?>
                        <div class="form-group">
                            <?php
                                if ($_SESSION["total_attempts"] > 3)
                                {
                                    $_SESSION["btn_disable_time"] = time();
                                    ?>
                            <p style="color: #fc0303; font-size:20px; font-weight: bold;">please contact to Admin or
                                wait
                                for</p>
                            <?php
                        $phpvar="30";
                        ?>
                            <script>
                            function countDown(secs, elem) {
                                var element = document.getElementById(elem);
                                element.innerHTML = secs + " sec";
                                if (secs < 1) {
                                    clearTimeout(timer);
                                    element.innerHTML = '<p></p>';
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                secs--;
                                var timer = setTimeout('countDown(' + secs + ',"' + elem + '")', 1000);
                            }
                            </script>
                            <div id="status" style="font-size:30px; color: #fc0303; font-weight: bold;"></div>
                            <script>
                            countDown(<?php echo $phpvar; ?>, "status");
                            </script>
                            <?php
                            }
                            else
                            {
                            ?>
                            <input type="submit" type="submit" name="submit" value="login"
                                class="btn float-right login_btn">
                            <?php
                                }
                            ?>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="./sign_up.php">Sign Up</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>