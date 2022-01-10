<!DOCTYPE html>
<?php
	session_start();
	if(ISSET($_SESSION['login_id'])){
		header('location: home.php');
	}
?>
<html lang = "eng">
	<head>
		<title>Attendance Record System</title>
		<?php include 'header.php' ?>
	</head>
	<body>
		<div class="bg-warning login-wrapper">
			<div class = "container">
				<div class="row align-items-center">
					<div class = "col-lg-12">
						<div class="col-md-12 d-flex justify-content-center">
							<img style="height:200px; width: 210px" src="./assets/logo.png" alt="">
						</div>
						<h1 class="text-center text-info my-4 justify-content-center">Dr. V. R. Godhaniya Girls' Colleger, Porbandar</h1>
						<div class = "row justify-content-center">
							<div class = "col-md-6 text-center">
								<div class = "card login-field">
									<div class = "card-header">
										<h4>Login</h4>
									</div>
									<div class = "card-body">
										<form id = "login-frm">
											<div id = "" class = "form-group">
												<label class = "control-label" >Username:</label>
												<input type = "text" name = "username" class = "form-control" required/>
											</div>
											<div id = "" class = "form-group">
												<label class = "control-label">Password:</label>
												<input type = "password" maxlength = "20" name = "password" class = "form-control" required/>
											</div>
											<br />
											<button type = "submit" class = "btn btn-primary btn-block" >Login <i class="fa fa-arrow-right"></i></button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'db_connect.php'; ?>
		<?php include 'footer.php'; ?>
	</body>
	<!-- <script src = "./assets/js/jquery.js"></script> -->
	<script src = "./assets/js/jquery-3.5.1.min.js"></script>

	<script src = "./assets/js/bootstrap.js"></script>

	<script>
		$(document).ready(function(){
			$('#login-frm').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:'login.php',
					method:'POST',
					data:$(this).serialize(),
					error:err=>{
						console.log(err)
					},
					success:function(resp){
						if(resp == true){
							location.replace('home.php')
						}else if(resp == false){
							alert('Invalid Credentials.')
						}else{
							console.log(resp)
						}
					}
				})
			})
		})
	</script>
</html>