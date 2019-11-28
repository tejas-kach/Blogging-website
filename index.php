<?php

require_once("include/config.php");
$limit = 3;
if (isset($_GET["page"])) {
  $page  = $_GET["page"];
  }
  else{
  $page=1;
  };
$start_from = ($page-1) * $limit;

if(isset($_GET["sort"])){
  $sort=$_GET["sort"];
}
else
{
  $sort="Latest";
}
if($sort=="Latest"){
 $sql="SELECT * FROM blogs order by id DESC LIMIT $start_from, $limit";
}
if($sort=="Oldest")
 {
   $sql="SELECT * FROM blogs order by id ASC LIMIT $start_from, $limit";
}
if($sort=="Popular")
{
    $sql="SELECT * FROM blogs order by views DESC LIMIT $start_from, $limit";
}
$result=mysqli_query($conn,$sql);
if(!$result)
{
  echo "failed to execte query";
  die("Can't fetch data from database");
}
$sql2="select id,login from admins where id=?;";
$stmt2=mysqli_prepare($conn,$sql2);
 mysqli_stmt_bind_param($stmt2,"i",$loginid);

 $sql3="select id,category from category where id=?;";
$stmt3=mysqli_prepare($conn,$sql3);
 mysqli_stmt_bind_param($stmt3,"i",$catid);

include("include/header.php");
?>
  <div class="container-fluid " >
      <br>
    <div class="row"><div class="col-sm-7 post">
      <div class="sortbtn">
        <select onchange="location = this.value;">
          <option selected>Sort by</option>
        <option value="index.php?sort=Latest">Latest</option>
        <option value="index.php?sort=Oldest">Oldest</option>
        <option value="index.php?sort=Popular">Popular</option>
      </select>
      </div>
      <hr>

    <?php 
while($row=mysqli_fetch_assoc($result))
{
echo '<div class="hii"><p><h1 class="title">'.$row["title"].'</h1>
            <h5>BY:';
            $loginid=$row["admin_id"];
             mysqli_stmt_execute($stmt2);
             $result2=mysqli_stmt_get_result($stmt2);
             $row2=mysqli_fetch_assoc($result2);
             echo $row2["login"];
            echo ' IN:';
            $catid=$row["category_id"];
             mysqli_stmt_execute($stmt3);
             $result3=mysqli_stmt_get_result($stmt3);
             $row3=mysqli_fetch_assoc($result3);
             echo $row3["category"];
            echo ' ON: '.$row["timestamp"].'    <i class="far fa-calendar-alt"></i><h5>
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
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="index.php?page=
      <?php
      if($page==1)
      {
        echo $page;

      }else
      {
        echo $page-1;

      }
            ?>
            " aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <?php
                    $result_db = mysqli_query($conn,"SELECT COUNT(id) FROM blogs");
            $row_db = mysqli_fetch_row($result_db);
            $total_records = $row_db[0];
            $total_pages = ceil($total_records / $limit);
             // echo  $total_pages;
            $pagLink = "";
                  for ($i=1; $i<=$total_pages; $i++) {
                    if($page!=$i)
                    {
                    $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?sort=".$sort."&page=".$i."'>".$i."</a></li>";
            }
            else
            {
              $pagLink .= "<li class='page-item active'><a class='page-link' href='index.php?sort=".$sort."&page=".$i."'>".$i."</a></li>";
            }
            }
            echo $pagLink;



                ?>
    <li class="page-item">
      <a class="page-link" href="index.php?page=
      <?php
      if($total_pages==$page)
      {
        echo $page;

      }else
      {
        echo $page+1;

      }
            ?>
            " aria-label="Previous">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
</div>

 <?php 
include("include/sidebar.php");
 ?>
</div>
</div>
 <?php
include("include/footer.php");
  ?>
