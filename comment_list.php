<?php
require_once("include/config.php");
$parent_id=mysqli_real_escape_string($conn,$_POST['parent_id']);
$c_result= mysqli_query($conn,"SELECT * FROM comment where parent_id=".$parent_id." ORDER BY id DESC");
if(mysqli_num_rows($c_result)>0)
{
	while($c_row=mysqli_fetch_assoc($c_result))
	{
		?>
		<div class="card bg-dark mb-3" style="max-width: 30rem;width: 40%;">
  <div class="card-header" style="color: white;font-weight:bold;"><?php echo $c_row["user"];?></div>
  <div class="card-body">
    <!-- <h5 class="card-title">Info card title</h5> -->
    <p class="card-text" style="color: white;"><?php echo $c_row["comment"];?></p>
  </div>
</div>
		<?php
	}
}
?>