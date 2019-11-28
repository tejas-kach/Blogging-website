<?php
 
require_once("include/config.php");
$loginid=$password="";
$err_invalid=$err_pass="";
function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
session_start();

if(isset($_POST["submit"])){
	$loginid=trim(htmlspecialchars($_POST["username"]));
  $password=trim(htmlspecialchars($_POST["pass"]));
  if (empty($loginid) && !valid_email($loginid))
    {
        $err_invalid='<div class="alert alert-primary" role="alert">
                      invalid login id 
                      </div>';
    }else
    {
      if(empty($password) )
      {
        $err_pass='<div class="alert alert-primary" role="alert">
                      Enter password 
                      </div>';
      }
      else
      {
        $sql="SELECT * FROM admins WHERE email =?";
        $stmt=mysqli_prepare($conn,$sql);
        if(!$stmt)
        {
            echo "error stmt not prepared  ",mysqli_error($conn);
          
        }
        else
        {
          mysqli_stmt_bind_param($stmt,"s",$loginid);
          mysqli_stmt_execute($stmt);
          $result=mysqli_stmt_get_result($stmt);
          if(mysqli_num_rows($result) != 1)
          {
              $err_invalid='<div class="alert alert-primary" role="alert">
                              invalid login id 
                            </div>';
          }
          else
          {
            $row=mysqli_fetch_assoc($result);
            //password_verify($password,$row["password"])
            if($row["password"]==$password)
            {
              $_SESSION['login']=$row["login"];
               header("Location:db.php");
            }
            else
            {
               $err_pass='<div class="alert alert-primary" role="alert">
                      Wrong Password 
                      </div>';
            }
          }
          }
        }
  mysqli_close($conn);
 }
}

if(isset($_SESSION['username'])){
header("location: db.php");
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
    <style type="text/css">
body {
  height: 100%;
}

body { display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-image: url("img/bg15.jpg");
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: inherit;
  background-size: cover;
}

.form-signin {
  width: 100%;
  height:400px;
  padding: 25px;
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
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  width: 50%;
  padding: 10px;
  font-size: 16px;
  align-items: center;
  margin-left: 25%;
  margin-top: 20px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  width: 40px;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.title{
  color:white;
}
.submitbtn{
  width: 100px;
}
.submitbtn:hover{
  color:white;
  background-color: red;
  transform:scale(1.05);
  border:0px;
}

    </style>
  </head>
  <body>
 <form  class="form-signin" method="POST" action="">
  <h1 class="title">Sign in</h1><br>
  <label for="inputEmail" class="sr-only">Login id</label>
  <br>
  <input type="text" id="username" name="username" class="form-control" placeholder="email id" autofocus>
  <?php
     if(isset($err_invalid))
    {
      echo $err_invalid;
    }

  ?>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
  <?php  
    if(isset($err_pass))
    {
      echo $err_pass;
    }

  ?>
  </div>
  <br>
  <input type="submit"  class="btn btn-lg btn-dark submitbtn"  name="submit">
</form>
<script>
  
</script>


   
  </body>
</html>