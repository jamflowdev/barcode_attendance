<!DOCTYPE html>
<?php
	include 'auth.php';
?>
<html lang = "eng">
	<head>
		<title>Attendance Record System</title>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'nav_bar.php' ?>
		<div class="container-fluid">
			<div class="row">
			<?php include 'sidebar.php' ?>

				<div class = "col-md-10 main-body" >
					<div class = "alert alert-primary">Dashboard</div>
					
					<div class="attendance_log_field">
						<div id="company-logo-field" class="mb-4 ">
							<img style="height:120px; width: 130px" src="./assets/logo.png" alt="">
						</div>
						<div class="col-md-8 offset-md-2">
							<div class="card">
								<div class="card-body">
									<div class="text-center">
										<h4><?php echo date('F d,Y') ?> <span id="now"></span></h4>
									</div>
									<div class="text-center mb-4" id="log_display"></div>

									<table id="table" style="display:none;" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Barcode No</th>
												<th>Full Name</th>
												<th>Faculty Name</th>
												<th>Mobile No</th>
												<th>Position</th>
												<th style="display: none">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$emp_qry=$conn->query("SELECT * FROM employee`") or die(mysqli_error());
												while($row=$emp_qry->fetch_array()){
											?>
											<tr>
												<td><?php echo $row['barcode']?></td>
												<td><?php echo $row['fullname']?></td>
												<td><?php echo $row['facultyname']?></td>
												<td><?php echo $row['mobileno']?></td>
												<td><?php echo $row['position']?></td>
												<td style="display: none">
													<center>
														<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now ' id="IN<?php echo $row['barcode']?>" data-uid="<?php echo $row['id']?>" data-barcode="<?php echo $row['barcode']?>" data-id="1">IN AM</button>
														<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now' id="OUT<?php echo $row['barcode']?>" data-uid="<?php echo $row['id']?>" data-barcode="<?php echo $row['barcode']?>" data-id="2">OUT AM</button>
														<div class="loading bg-info" style="display: none"><center>Please wait...</center></div>
													</center>
												</td>
											</tr>
											<?php
												}
												$student_qry=$conn->query("SELECT * FROM student`") or die(mysqli_error());
												while($row=$student_qry->fetch_array()){
											?>
											<tr>
												<td><?php echo $row['barcode']?></td>
												<td><?php echo $row['fullname']?></td>
												<td><?php echo $row['facultyname']?></td>
												<td><?php echo $row['mobileno']?></td>
												<td><?php echo $row['position']?></td>
												<td style="display: none">
													<center>
														<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now ' id="IN<?php echo $row['barcode']?>" data-uid="<?php echo $row['id']?>" data-barcode="<?php echo $row['barcode']?>" data-id="1">IN AM</button>
														<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now' id="OUT<?php echo $row['barcode']?>" data-uid="<?php echo $row['id']?>" data-barcode="<?php echo $row['barcode']?>" data-id="2">OUT AM</button>
														<div class="loading bg-info" style="display: none"><center>Please wait...</center></div>
													</center>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>
									<!-- <div class="col-md-12">
										<div class="text-center mb-4" id="log_display"></div>
											<form action="" id="att-log-frm" >
												<div class="form-group">
													<label for="barcode" class="control-label">Enter Barcode Number</label>
													<input type="text" id="barcode" name="barcode" class="form-control col-sm-12">
												</div>
												<div class="att_details" style="display: none"></div>
												<div class="text-center">
													<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now' data-id="1">IN AM</button>
													<button type="button" class='btn btn-sm mx-2 px-3 btn-primary log_now' data-id="2">OUT AM</button>
												</div>
												<div class="loading" style="display: none"><center>Please wait...</center></div>
											</form>
									</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include 'footer.php'; ?>

	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable({
				"language": {
					"search": "Enter Barcode:"
				},
				"bPaginate": false,
				"columnDefs": [
					{
						"targets": [2,3,4,5],
						"searchable": false
					}
				],
			});
			$('#table_filter').addClass('barcode')
			$('input[type="search"]').focus()
		});
	</script>
	<script>
		$(document).ready(function(){
			setInterval(function(){
				var time = new Date();
				var now = time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true })
				$('#now').html(now)
			},500)
			// console.log()
			$('.dataTables_length').hide();
			$('.dataTables_info').hide();
			$('.dataTables_paginate').hide();
			$('input[type="search"]').on('keypress',function(e) {
					if(e.which == 13) {
					// console.log(this.value);
					let barcode = this.value;
						$.ajax({
							url:'get_att.php',
							method:"POST",
							data:{barcode: barcode},
							error:err=>console.log(),
							success:function(resp){
								if(typeof resp !=undefined){
									resp = JSON.parse(resp)
									console.log(resp)
									// console.log($('#IN','data-barcode='+barcode))
									if(resp.status == 1){
										$("#IN"+barcode).trigger('click');
									}else if(resp.status == 2){
										$("#OUT"+barcode).trigger('click');
									}else{
										alert(resp.msg)
										location.reload()
									}
								}
							}
						})
					}
			});
			$('input[type="search"]').on("input", function() {
 				($.trim(this.value).length >= 5) ? $('.table').show() : $('.table').hide()
			});

			

			$('#table').on('click', '.log_now', function(){
				var _this = $(this)
				console.log(_this);
				var id=$(this).attr('data-id');
				var u_id=$(this).attr('data-uid');
				// var barcode = $('[name="barcode"]').val()
				var barcode = $(this).attr('data-barcode');
				if(barcode == ''){
					alert("Please enter your student | employee number");
				}else{
					if(barcode.includes("STAFF")){
						console.log(barcode)
					}
					$('.log_now').hide()		
					$('.loading').show()
					$.ajax({
						url:'time_log.php',
						method:'POST',
						data:{type:id, barcode:barcode},
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								if(resp.status == 1){
									// $('[name="barcode"]').val('')
									$('#log_display').html(resp.msg);
									setTimeout(function(){
										$('#log_display').html('');
										$('input[type="search"]').val('');
										$('input[type="search"]').trigger('input');
										$('input[type="search"]').focus();
										$('.log_now').show();
										$('.loading').hide();
										location.reload();
									},3000)
							}else{
								alert(resp.msg)
								$('.log_now').show()		
								$('.loading').hide()
								}
							}
						},
					});
				}
			});
			var loc = window.location.href;
			loc.split('{/}')
			$('#sidebar a').each(function(){
			// console.log(loc.substr(loc.lastIndexOf("/") + 1),$(this).attr('href'))
				if($(this).attr('href') == loc.substr(loc.lastIndexOf("/") + 1)){
					$(this).addClass('active')
				}
			});
		})
	</script>
</html>