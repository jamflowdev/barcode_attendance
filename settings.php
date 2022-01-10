<!DOCTYPE html>
<?php
	require_once 'auth.php';
	if ($_SESSION["user_role"] == 1) {
	
?>
<html lang="eng">
	<head>
		<title>Users | user Attendance Record System</title>
		<meta charset="utf-8" />
		<?php include 'header.php' ?>
	</head>
	<body>
		<?php include 'nav_bar.php' ?>
		<div class="container-fluid">
			<div class="row">
			<?php include 'sidebar.php' ?>
				<div class="col-md-10 main-body" >
					
					<div class="alert alert-primary">Settings</div>
					<div class="well col-lg-12">
						<button type="button" class="btn btn-primary btn-sm" id="update_sem"><i class="fa fa-edit"></i> Update Semester</button>
					</div>
				</div>
			</div>
		</div>
	</body>
<?php
	}else{
		echo "<script>alert('Unauthorized...')</script>";
		echo "<script>window.location = 'index.php'</script>";
	}
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#update_sem').click(function(){
				var $update_setting = "update_setting";
				$.ajax({
					url:'update.php',
					method:"POST",
					data:{update_setting:$update_setting},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							alert(resp.msg);
						}
					}
				})
				
			});
			var loc = window.location.href;
			loc.split('{/}')
			$('#sidebar a').each(function(){
			// console.log(loc.substr(loc.lastIndexOf("/") + 1),$(this).attr('href'))
				if($(this).attr('href') == loc.substr(loc.lastIndexOf("/") + 1)){
					$(this).addClass('active')
				}
			});
		});
	</script>
</html>
