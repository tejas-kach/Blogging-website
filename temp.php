<?php

require_once("include/config.php");
$title=$_GET["t"];
$sql="SELECT * FROM blogs where title='$title'";
$result=mysqli_query($conn,$sql);
if(!$result )
{
  echo "failed to execte query";
  die("Can't fetch data from database");
}

include("include/header.php");
echo '<br><div class="container-fluid " >
    <div class="row"><div class="col-sm-7 post">';  
$row=mysqli_fetch_assoc($result);
{
echo '<div class="hii"><p><h1 class="title">'.$row["title"].'</h1>
          	<img class="img-fluid" alt="Responsive image" src='.$row["img"].'>
            <h4>
             <!--blog content inserted  here dynamically-->';
             echo $row["content"];
             echo '
            </h4>
        </p>
      </div>'; 
}
$views=$row["views"]+1;
mysqli_query($conn,"update blogs set views='$views' where title='$title'"); 
?>  

<style type="text/css">
  .commentbox{
    border:1px solid black;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0 0 3px #000;
  }

  }
  .commentbox input{
    border:1px solid black;
    box-shadow: 0 0 3px #000;
    
  }
  .submit:hover{
    color:white;
    border:0px;
    background-color: red;
    transform:scale(1.05);
  }
</style>





  <div class="container commentbox">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <h1> Post Your Comment Below</h1><hr>
    <div class="col-md-5">
      <input type="text" class="name form-control" placeholder="Name"><br>
      <textarea class="comment form-control" placeholder="Comment"></textarea>
      <!-- <p>&nbsp;</p> --><br>
      <a href="javascript:void(0)" class="btn btn-dark submit">Submit</a>
    </div>
    <div class="clearfix"></div>
    <p>&nbsp;</p>
    <div class="comment_listing"></div>
  </div>
<!-- </body>
</html> -->
<script type="text/javascript">
  function listComments()
    {
       var parent_id=<?php echo $row["id"];?>;
      $.ajax({
        url:'comment_list.php',
        data:'&parent_id='+parent_id,
        type:'post',
        success:function(res){
          $('.comment_listing').html(res);
        }
      })
    }
  $(function(){
    
    
    listComments();
    setInterval(function(){
      listComments();
    },5000);
    $('.submit').click(function(){
      var name = $('.name').val();
      var comment = $('.comment').val();
      var parent_id=<?php echo $row["id"];?>;
      $.ajax({
        url:'save_comment.php',
        data:'name='+name+'&comment='+comment+'&parent_id='+parent_id,
        type:'post',
        success:function()
        {
          alert("Your comment has been posted");
          listComments();
        }
      })
    })
  })
</script>
</div>

 <?php 
include("include/sidebar.php");
 ?>
  
  

</div>


