<!DOCTYPE html>
<?php
	require_once 'auth.php';
?>
<html lang="eng">
	<head>
		<title>Student List | Attendance Record System</title>
		<?php include('header.php') ?>
	</head>
	<body>
		<?php include('nav_bar.php') ?>
		<div class="container-fluid">
			<div class="row">
			<?php include 'sidebar.php' ?>

		<div class="col-md-10 main-body" >
			<div class="alert alert-primary">Student List</div>
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
					<form id="importCSV" class="bg-light" method="post" enctype="multipart/form-data">
						<label for="upload_csv" class="form-label" style="font-size: 18px">Upload new students</label>
						<input style="width:50%; margin: 0 auto;" required="required" class="form-control my-3" type="file" id="upload_csv" name="upload_csv" accept=".csv">
						<button type="submit" class="form-group mt-2 btn btn-success" name="csv_upload">Upload CSV</button>
					</form>
				</div>
				<div class="row p-3 m-0 border">
					<button class="btn btn-success " type="button" id="new_stu_btn"><span class="fa fa-plus"></span> Add New </button>
					<button class="btn btn-success ml-auto" type="button" id="exportStudents" value="csv"><span class="fa fa-download"></span> Export Students</button>
					<a href="javascript:void(0)" id="dlbtn" style="display: none;">
						<button type="button" id="mine">Export Students</button>
					</a>
				</div>
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Barcode No</th>
							<th>Full Name</th>
							<th>Faculty Name</th>
							<th>Semester</th>
							<th>Mobile No</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$student_qry=$conn->query("SELECT * FROM student WHERE semester<7") or die(mysqli_error());
							while($row=$student_qry->fetch_array()){
						?>
						<tr>
							<td><?php echo $row['barcode']?></td>
							<td><?php echo $row['fullname']?></td>
							<td><?php echo $row['facultyname']?></td>
							<td><?php echo $row['semester']?></td>
							<td><?php echo $row['mobileno']?></td>
							<td>
								<center>
								 <button class="btn btn-sm btn-outline-primary edit_student" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"> Edit</i></button>
								<button class="btn btn-sm btn-outline-danger remove_student" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"> Delete</i></button>
								</center>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		</div>
		
		<div class="modal fade" id="new_student" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add new Student</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
						</div>
						<form id='student_frm'>
							<div class ="modal-body">
								<div class="form-group">
									<label>Roll No</label>
									<input type="hidden" name="id" />
									<input type="number" name="roll_no" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name ="fullname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Faculty Name</label>
									<input type="text" name="facultyname" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Semester</label>
									<input type="number" min="1" max="6" name="semester" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Mobile Number</label>
									<input type="text" minlength="10" maxlength="10" name="mobileno" required="required" class="form-control" />
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

			$('#student_frm').submit(function(e){
				e.preventDefault()
				$('#student_frm [name="submit"]').attr('disabled',true)
				$('#student_frm [name="submit"]').html('Saving')
				$.ajax({
					url:'save_student.php',
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
			$('#table').on('click', '.remove_student', function(){
				// $('.remove_student').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("Are you sure to delete this data ?");
				if(_conf == true){
					$.ajax({
						url:'delete_student.php?id='+id,
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
			$('#table').on('click', '.edit_student', function(){
				// $('.edit_student').click(function(){
				var $id=$(this).attr('data-id');
				$.ajax({
					url:'get_student.php',
					method:"POST",
					data:{id:$id},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="id"]').val(resp.id)
							$('[name="roll_no"]').val(resp.roll_no)
							$('[name="fullname"]').val(resp.fullname)
							$('[name="facultyname"]').val(resp.facultyname)
							$('[name="semester"]').val(resp.semester)
							$('[name="mobileno"]').val(resp.mobileno)
							$('#new_student .modal-title').html('Edit Student')
							$('#new_student').modal('show')
						}
					}
				})
			});

			$("#exportStudents").click(function(){
				var csv = "student_csv";
				$.ajax({
					type: 'POST',
					url: 'exportExcel.php',
					data: {student_csv:csv},
						success: function(result) {
							console.log(result);
							setTimeout(function() {
								var dlbtn = document.getElementById("dlbtn");
								var file = new Blob([result], {type: 'text/csv'});
								dlbtn.href = URL.createObjectURL(file);
								dlbtn.download = 'students.csv';
								$( "#mine").click();
							}, 2000);
						}
				});
			});
			$("form#importCSV").submit(function(e) {
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
							$('form#importCSV')[0].reset();
						},
						cache: false,
						contentType: false,
						processData: false
				});
			});

			$('#new_stu_btn').click(function(){
				$('[name="id"]').val('')
				$('[name="roll_no"]').val('')
				$('[name="fullname"]').val('')
				$('[name="facultyname"]').val('')
				$('[name="semester"]').val('')
				$('[name="mobileno"]').val('')
				$('#new_student .modal-title').html('Add New Student')
				$('#new_student').modal('show')
			})
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