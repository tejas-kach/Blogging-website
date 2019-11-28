
<?php

require_once "include/config.php";

if(isset($_POST['register'])){ // Fetching variables of the form which travels in URL
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $phone = $_POST['phone'];
    $email = $_POST['your_email'];

    $sql = "INSERT INTO user (username, pwd, phone, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if(!$stmt){
    	echo "error";
    }else{
      mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_pwd, $param_phone, 
      	$param_email);

      # Set the parameters
      $param_username = $username;
      $param_pwd = password_hash($pwd, PASSWORD_DEFAULT);
      $param_phone = $phone;
      $param_email = $email;

      # Try to Execute the Query
      mysqli_stmt_execute($stmt);
      
        echo "<script>alert('data inserted');</script>";
        header("location:index.php");
      
      
      #mysqli_stmt_close($stmt);
    }
      //mysqli_stmt_close($stmt);
}

  mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="http://use.fontawesome.com/releases/v5.7.0/css/all.css">

    <title>Register</title>

    <style type="text/css">
        body{
            background-image: url("img/bg15.jpg");
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: inherit;
            background-size: cover;
        }
    	.page-content{
    		border:1.5px solid black;
    		margin-left: 25%;
    		margin-right: 25%;
    		margin-top: 5%;
    		text-align: center;
    		align-items: center;
            background-image: url("img/bg16.jpg");
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: inherit;
            background-size: cover;

            border-radius:10px;
            box-shadow: 0 0 20px #000;


    	}
    	.username,.pwd,.phone,.input-text{
    		border:1px solid black;
    		align-items: center;
    		margin:auto;
    		margin-top: 2%;
    		text-align: center;
    	}
    	.register{
    		background-color: red;
    		color: white;
    		border-width: 0;
    	}
    	.text ,p{
    		font-size: 1.3em;
            font-weight: bold;
            color: white;
    	}
        h1{
            color: white;
        }
    </style>

  </head>
  <body>
<div class="form-v10">
	<div class="page-content conatiner-fluid">
		<div class="form-v10-content">
			<form class="form-detail" action="register.php" method="post" id="myform">
				<div class="form-left">
					<br>
					<h1>INFORMATION</h1>

                    <div class="form-row">
                        <input type="text" name="username" class="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-row">
                        <input type="password" name="pwd" class="pwd" id="pwd" placeholder="Password" required>
					</div>
					 <div class="form-row">
                        <input type="text" name="phone" class="phone" id="phone" placeholder="Your contact-no." required>
					</div>
					<div class="form-row">
						<input type="text" name="your_email" id="your_email" class="input-text" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" placeholder="Your Email">
					</div>
					<br>
					<div class="form-checkbox">
						<label class="container"><p>I do accept the <a href="#" class="text">Terms and Conditions</a> of your site.</p>
						  	<input type="checkbox" name="checkbox">
						  	<span class="checkmark"></span>
						</label>
					</div>
					<div class="form-row-last">
						<input type="submit" name="register" class="register" value="Register">
					</div>
					<br>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>