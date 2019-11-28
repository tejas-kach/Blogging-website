<?php



require_once("include/config.php");
//INTIALIZING THE TXT FIELD
  



if (isset($_POST["submit"])) {
	 $id=$_POST["id"];
	$result=mysqli_query($conn,"select * from blogs where id='$id';");
  $row=mysqli_fetch_assoc($result);
   $title=$_POST['title'];
   if(isset($_FILES["img"]))
  {
  $pic="img/".$_FILES["img"]["name"];
  }else
  {
     $pic=$row["img"];
  } 
   $content=$_POST['editor'];
   $id=$_POST["id"];
  if($_POST["category"]!=$row["category_id"])
  {
     $catid=$_POST['category'];
  }
  else
  {
     $catid=$row["category_id"];
  }
  $id=$_POST["id"];
  if(mysqli_query($conn,"update blogs set title='$title',img='$pic',content='$content',category_id='$catid' where id='$id';"))
  { 
    header("Location:db.php?u=t");
  }
  else
  {
     header("Location:login.php");
  }
}
?>