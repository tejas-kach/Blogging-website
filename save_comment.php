<?php
require_once("include/config.php");
$name = mysqli_real_escape_string($conn,$_POST['name']);
$comment = mysqli_real_escape_string($conn,$_POST['comment']);
$parent_id=mysqli_real_escape_string($conn,$_POST['parent_id']);
$q = "INSERT INTO comment (user,comment,parent_id) VALUES('".$name."','".$comment."','".$parent_id."')";
mysqli_query($conn,$q);
?>