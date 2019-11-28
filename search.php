<?php



if(isset($_POST["search"]))
{
  require_once("include/config.php");
require_once("include/header.php");
  $Name=$_POST["search"];
 $sql="SELECT * FROM blogs where title LIKE '%$Name%' order by id DESC ";


$result=mysqli_query($conn,$sql);
if(!$result)
{
  echo "failed to execte query";
  die("Can't fetch data from database");
}
if(mysqli_num_rows($result) == 0)
{
    echo "<h1>No result found.</h1>";
}
else
{

$sql2="select id,login from admins where id=?;";
$stmt2=mysqli_prepare($conn,$sql2);
 mysqli_stmt_bind_param($stmt2,"i",$loginid);

 $sql3="select id,category from category where id=?;";
$stmt3=mysqli_prepare($conn,$sql3);
 mysqli_stmt_bind_param($stmt3,"i",$catid);


?>
   <div class="container-fluid " >
      <br>
    <div class="row"><div class="col-sm-7 post">

    <?php 
while($row=mysqli_fetch_assoc($result))
{
echo '<div class="hii"><p><h1 class="title">'.$row["title"].'</h1>
            by: ';
            $loginid=$row["admin_id"];
             mysqli_stmt_execute($stmt2);
             $result2=mysqli_stmt_get_result($stmt2);
             $row2=mysqli_fetch_assoc($result2);
             echo $row2["login"];
            echo ' in:';
            $catid=$row["category_id"];
             mysqli_stmt_execute($stmt3);
             $result3=mysqli_stmt_get_result($stmt3);
             $row3=mysqli_fetch_assoc($result3);
             echo $row3["category"];
            echo '  on: '.$row["timestamp"].'    <i class="far fa-calendar-alt"></i>
          	<img class="img-fluid blogimg" alt="Responsive image" src='.$row["img"].'>
            <h4 class="content_text">
            <br>
             <!--blog content inserted  here dynamically-->';
             echo substr($row["content"],0,300);
             ?>
            </h4>
            <br>
            <button type="button" class="btn btn-dark readmorebtn"><a href=
            <?php
              echo '"temp.php?t='.$row["title"].'"';
            ?>>
        Read more
</a></button>
        </p>
        <hr>
      </div>
      <?php 
} 
?>   
</div>
 <?php 
}
}
include("include/sidebar.php");
 ?>
  
</div>
</div>
 <?php
include("include/footer.php");
  ?>
