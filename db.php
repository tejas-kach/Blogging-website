<?php
require_once("include/config.php");

session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login'];
$ses_sql=mysqli_query($conn,"select login,id from admins where login='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session =$row['login'];
if(!isset($login_session)){
mysqli_close($conn); // Closing Connection
header('Location:login.php'); // Redirecting To Home Page
}

$err_insert="";
$err_title=$err_category=$err_image=$err_content="";
if(isset($_POST["submit1"]))
{
 
  $title=$_POST['title'];
   if(isset($_FILES["img"]))
  {
  $pic="img/".$_FILES["img"]["name"];
  }else
  {
    $err_image="file not found";
  } 
  $content=$_POST['editor'];
  $adminid=$row['id'];
  $catid=$_POST['category'];
  $query3="INSERT INTO `blogs` (`title`, `content`,`category_id`,`admin_id`,`img`) VALUES ('$title','$content','$catid','$adminid','$pic');";
  $res5=mysqli_query($conn,$query3);
  if(!$res5)
  {
    $err_insert='<div class="alert alert-primary" role="alert">
                      Failed insertion 
                      '.$err_image.'
                      </div>';
  }
  else
  {
    $err_insert='<div class="alert alert-primary" role="alert">
                      Inserted successfully 
                      </div>';
  }
}

$err_del="";
//BLOG DELETE 
if(isset($_POST["delsubmit"]))
{
  $id=$_POST['blogdelete'];
  $query4="delete from blogs where id='$id';";
  $stmt6=mysqli_query($conn,$query4);
  if(!$stmt6)
  {
    $err_del='<div class="alert alert-primary" role="alert">
                      Failed deletion 
                      </div>';
  }
  else
  {
   $err_del='<div class="alert alert-primary" role="alert">
                      Deleted successfully 
                      </div>';
  }
}
$err_update="";
if(isset($_GET["u"]))
{
  if($_GET["u"]==t)
  {
    $err_update='<div class="alert alert-primary" role="alert">
                      Update successfully 
                      </div>';
  }
  else
  {
    $err_update='<div class="alert alert-primary" role="alert">
                      Failed updation 
                      </div>';
  }
}


$sql1="select * from category";

$res1=mysqli_query($conn,$sql1);
$res2=mysqli_query($conn,"select * from blogs");
$sql2="select login from admins where id = ?";
$stmt=mysqli_prepare($conn,$sql2);
$sql3="select * from category where id=?";
$stmt2=mysqli_prepare($conn,$sql3);
   if(!$res2)
        {
            echo "error stmt not prepared  ",mysqli_error($conn);
          header("Location:index.php");
        }   
     if(!$stmt)
        {
            echo "error stmt not prepared  ",mysqli_error($conn);
           header("Location:index.php");
        }     
        if(!$stmt2)
        {
            echo "error stmt not prepared  ",mysqli_error($conn);
           header("Location:index.php");
        }
     if(!$res1)
        {
            echo "error stmt not prepared  ",mysqli_error($conn);
           header("Location:index.php");
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

    <title>Dashboard</title>
   <script src="https://cdn.tiny.cloud/1/uvemvxsooe3ao8w3d0a78pwzme2dcw3bk8f5kbbzwmj0ix9g/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
tinymce.init({
  selector: 'textarea#full-featured-non-premium',
  plugins: 'print preview page paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

  imagetools_cors_hosts: ['picsum.photos'],
  menubar: 'file edit view insert format tools table help',
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
  toolbar_sticky: true,
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
  ],
  link_list: [
    { title: 'My page 1', value: 'http://www.tinymce.com' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_list: [
    { title: 'My page 1', value: 'http://www.tinymce.com' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_class_list: [
    { title: 'None', value: '' },
    { title: 'Some class', value: 'class-name' }
  ],
  importcss_append: true,
  height: 400,
  file_picker_callback: function (callback, value, meta) {
    /* Provide file and text for the link dialog */
    if (meta.filetype === 'file') {
      callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
    }

    /* Provide image and alt text for the image dialog */
    if (meta.filetype === 'image') {
      callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
    }

    /* Provide alternative source and posted for the media dialog */
    if (meta.filetype === 'media') {
      callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
    }
  },
  templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
  ],
  template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
  template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
  height: 600,
  image_caption: true,
  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
  noneditable_noneditable_class: "mceNonEditable",
  toolbar_drawer: 'sliding',
  contextmenu: "link image imagetools table",
 });


</script>  </head>
  <body>
 
	
 <style>
 
 body {
  font-size: .875rem;
}

.feather {
  width: 16px;
  height: 16px;
  vertical-align: text-bottom;
}

/*
 * Sidebar
 */

.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 48px 0 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

@supports ((position: -webkit-sticky) or (position: sticky)) {
  .sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
  }
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}

/*
 * Content
 */

[role="main"] {
  padding-top: 133px; /* Space for fixed navbar */
}

@media (min-width: 768px) {
  [role="main"] {
    padding-top: 48px; /* Space for fixed navbar */
  }
}

/*
 * Navbar
 */

.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: 1rem;
  background-color: rgba(0, 0, 0, .25);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .form-control {
  padding: .75rem 1rem;
  border-width: 0;
  border-radius: 0;
}

.form-control-dark {
  color: #fff;
  background-color: rgba(255, 255, 255, .1);
  border-color: rgba(255, 255, 255, .1);
}

.form-control-dark:focus {
  border-color: transparent;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
}
main{
  font-size:large;
  font-weight: 700;
}
nav{
  background-color:#b80c00;
}
.white{
color: white;
}
.white:hover{
  color: black;
}

 </style>


<nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">Techtricksworld</a>
  <!-- <section class="form-control form-control-light w-100" type="label" placeholder=""></section> -->
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-item white" href="include/logout.php">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Dashboard</h1>  
      </div>
      <br>
    <div>
      <?php
     if(isset($err_insert))
    {
      echo $err_insert;
    }
    if(isset($err_del))
    {
      echo $err_del;
    }
     if(isset($err_update))
    {
      echo $err_update;
    }
  ?>
      <h1 class="h2">Insert a Blog.</h1>
      <br>

      <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" class="form-control" id="" aria-describedby="" placeholder="Enter Title" required>
          <!-- <small id="" class="form-text text-muted">This title will help for searching the blog</small> -->
        </div>
        <label>Category</label>
        <div class="input-group mb-3">
        <select class="custom-select" id="inputGroupSelect02" name="category" required>
          <option selected>Choose...</option>
          <?php
          while($cat=mysqli_fetch_assoc($res1))
          {
            echo '<option value="'.$cat["id"].'">'.$cat["category"].'</option>';
          }
          ?>  
        </select>
        <div class="input-group-append">
          <label class="input-group-text" for="inputGroupSelect02">Options</label>
        </div>
      </div>

        <!-- <div class="form-group">
          <label>Author</label>
          <input type="text" class="form-control" id="" aria-describedby="" placeholder="Enter Author">
           <small id="" class="form-text text-muted">Enter the correct author of the blog.</small> 
        </div> -->
        
        
        <div class="form-group">
          <label>Image</label><br>
          <input type="file" name="img"   placeholder="Enter Image" required>
          <!-- <small id="" class="form-text text-muted">Enter the correct image url.</small> -->
        </div>


        

        <div class="form-group">
          <label>Content</label>
          <textarea id="full-featured-non-premium" name="editor" ></textarea>
         <!--  <small id="" class="form-text text-muted">Enter the actual blog content.</small> -->
        </div>
        
        <br>
        <input  type="submit" class="btn btn-primary" name="submit1" value="submit">
      </form>
    </div>
      <!--closing of insert a blog-->
      <hr>
        <?php require_once("include/table.php");?>
      <hr>

      <br>
      <form id="f2" action="" method="POST">
    <div>
      <h1 class="h2">Delete a blog.</h1>
      <br>
      <div class="form-group">
        <label>Enter blog id</label>
        <input type="text"  name="blogdelete" class="form-control"  aria-describedby="" placeholder="Enter id of blog to be deleted" required>
      </div>
      <input type="submit" name="delsubmit" class="btn btn-primary">
    </div><!--clossing of delete a blog-->
  </form>
      <hr>
      <br>
      <form method="POST" action="update.php">
    <div>
      <h1 class="h2">Update a blog.</h1>
      <br>
      <div class="form-group">
        <label>Enter blog id</label>
        <input type="text" name="blogupdate" class="form-control" id="" aria-describedby="" placeholder="Enter the id of the blog to be updated" required>
      </div>
      <input type="submit" name="update_submit" class="btn btn-primary" value="Submit">
    </div>
  </form>
<!-- 
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
 -->
      
    </main>
  </div>
</div>

	
	<script >
    $(document).ready(function(){

  $("#button").click(funtion(){
    var x=$("#imgupload").val();
    var y=$("#txtarea").val();
    alert(x);
    alert(y);
     y.=x;
    $("#txtarea").val(y);
   
  });
});
  </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>