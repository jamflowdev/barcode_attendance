<!DOCTYPE html>
<?php
	require_once 'auth.php';
?>
<html lang="eng">
	<head>
		<title>Employee List | Attendance Record System</title>
		<?php include('header.php') ?>
	</head>
	<body>
		<?php include('nav_bar.php') ?>
		<div class="container-fluid">
			<div class="row">
			<?php include 'sidebar.php' ?>
		<div class="col-md-10 main-body" >
			<div class="alert alert-primary">Employee List</div>
			<div class="modal fade" id="edit_student" tabindex="-1" role="dialog" aria-labelledby="myModallabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content panel-warning">
						<div class="modal-header panel-heading">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
							<h4 class="modal-title" id="myModallabel">Edit Student</h4>
						</div>
						<div id="edit_query"></div>
					</div>
				</div>
			</div>
			<div class="well col-lg-12">
			<div class="p-3 border text-center">
					<form id="import_staff_csv" class="bg-light" method="post" enctype="multipart/form-data">
						<label for="upload_staff_csv" class="form-label" style="font-size: 18px">Upload new employees</label>
						<input style="width:50%; margin: 0 auto;" required="required" class="form-control my-3" type="file" id="upload_staff_csv" name="upload_staff_csv" accept=".csv">
						<button type="submit" class="form-group mt-2 btn btn-success" name="csv_upload">Upload CSV</button>
					</form>
				</div>
				<div class="row p-3 m-0 border">
					<button class="btn btn-success " type="button" id="new_emp_btn"><span class="fa fa-plus"></span> Add New </button>
					<button class="btn btn-success ml-auto" type="button" id="exportEmployees" value="csv"><span class="fa fa-download"></span> Export Employees</button>
					<a href="javascript:void(0)" id="dlbtn" style="display: none;">
						<button type="button" id="mine">Export Employees</button>
					</a>
				</div>
				<br />
				<br />
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Barcode No</th>
							<th>Full Name</th>
							<th>Faculty Name</th>
							<th>Mobile No</th>
							<th>Position</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$employee_qry=$conn->query("SELECT * FROM employee`") or die(mysqli_error());
							while($row=$employee_qry->fetch_array()){
						?>
						<tr>
							<td><?php echo $row['barcode']?></td>
							<td><?php echo $row['fullname']?></td>
							<td><?php echo $row['facultyname']?></td>
							<td><?php echo $row['mobileno']?></td>
							<td><?php echo $row['position']?></td>
							<td>
								<center>
									<button class="btn btn-sm btn-outline-primary edit_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i> Edit</button>
									<button class="btn btn-sm btn-outline-danger remove_employee" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i> Delete</button>
								</center>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
			<br />
			<br />	
			<br />	
		</div>
		</div>
		</div>
		
		<div class="modal fade" id="new_employee" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add new Employee</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
						</div>
						<form id='employee_frm'>
							<div class ="modal-body">
								<div class="form-group">
									<label>Employee No</label>
									<input type="hidden" name="id" />
									<input type="numder" name="employee_no" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="fullname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Faculty Name</label>
									<input type="text" name="facultyname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Mobile No</label>
									<input type="text" pattern="[0-9]+" maxlength="10" name="mobileno" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Position</label>
									<input type="text" name="position" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Barcode</label>
									<input type="text" name="barcode" required="required" class="form-control" />
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#employee_frm').submit(function(e){
				e.preventDefault()
				$('#employee_frm [name="submit"]').attr('disabled',true)
				$('#employee_frm [name="submit"]').html('Saving')
				$.ajax({
					url:'save_employee.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								alert(resp.msg);
								location.reload();
							}
						}
					}
				})
			})
			$('#table').on('click', '.remove_employee', function(){
				// $('.remove_employee').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("Are you sure to delete this data ?");
				if(_conf == true){
					$.ajax({
						url:'delete_employee.php?id='+id,
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								if(resp.status == 1){
									alert(resp.msg);
									location.reload()
								}
							}
						}
					})
				}
			});
			$('#table').on('click', '.edit_employee', function(){
				// $('.edit_employee').click(function(){
				var $id=$(this).attr('data-id');
				$.ajax({
					url:'get_employee.php',
					method:"POST",
					data:{id:$id},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="id"]').val(resp.id)
							$('[name="employee_no"]').val(resp.employee_no)
							$('[name="fullname"]').val(resp.fullname)
							$('[name="facultyname"]').val(resp.facultyname)
							$('[name="mobileno"]').val(resp.mobileno)
							$('[name="position"]').val(resp.position)
							$('[name="barcode"]').val(resp.barcode)
							$('#new_employee .modal-title').html('Edit Employee')
							$('#new_employee').modal('show')
						}
					}
				})
				
			});
			$('#new_emp_btn').click(function(){
				$('[name="id"]').val('')
				$('[name="employee_no"]').val('')
				$('[name="fullname"]').val('')
				$('[name="facultyname"]').val('')
				$('[name="mobileno"]').val('')
				$('[name="position"]').val('')
				$('[name="barcode"]').val('')
				$('#new_employee .modal-title').html('Add New Employee')
				$('#new_employee').modal('show')
			})
		});
		$("#exportEmployees").click(function(){
			var csv = "staff_csv";
			$.ajax({
				type: 'POST',
				url: 'exportExcel.php',
				data: {staff_csv:csv},
					success: function(result) {
						console.log(result);
						setTimeout(function() {
							var dlbtn = document.getElementById("dlbtn");
							var file = new Blob([result], {type: 'text/csv'});
							dlbtn.href = URL.createObjectURL(file);
							dlbtn.download = 'staff.csv';
							$( "#mine").click();
						}, 2000);
					}
			});
		});
		$("form#import_staff_csv").submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);
			// console.log(formData);
			$.ajax({
					url: 'importCSV.php',
					type: 'POST',
					data: formData,
					error:err=>console.log(err),
					success:function(resp){
						if(typeof resp != undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								alert(resp.msg);
								location.reload()
							}else{
								alert(resp.msg);
								location.reload()
							}
						}
						$('form#import_staff_csv')[0].reset();
					},
					cache: false,
					contentType: false,
					processData: false
			});
		});
		var loc = window.location.href;
		loc.split('{/}')
		$('#sidebar a').each(function(){
		// console.log(loc.substr(loc.lastIndexOf("/") + 1),$(this).attr('href'))
			if($(this).attr('href') == loc.substr(loc.lastIndexOf("/") + 1)){
				$(this).addClass('active')
			}
		});
	</script>
</html>