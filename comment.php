<!-- <!DOCTYPE html>
<html>
<head>
	<title>Comments</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
</head>
<body> -->
	<div class="container">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		
		<h1>Post Your Comment Below</h1>
		<div class="col-md-5">
			<input type="text" class="name form-control" placeholder="Name"><br>
			<textarea class="comment form-control"></textarea>
			<!-- <p>&nbsp;</p> -->
			<a href="javascript:void(0)" class="btn btn-primary submit">Submit</a>
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
			$.ajax({
				url:'comment_list.php',
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
			$.ajax({
				url:'save_comment.php',
				data:'name='+name+'&comment='+comment,
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