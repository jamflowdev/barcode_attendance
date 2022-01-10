<!DOCTYPE html>
<?php
	require_once 'auth.php';
?>
<html lang = "eng">
	<head>
		<title>Attendance List | Attendance Record System</title>
		<?php include('header.php') ?>
	</head>
	<body>
		<?php include('nav_bar.php') ?>
		<div class="container-fluid">
			<div class="row">
			<?php include 'sidebar.php' ?>

		<div class="col-md-10 main-body" >
			<div class = "alert alert-primary">Attendance List</div>
			<div class = "modal fade" id = "delete" tabindex = "-1" role = "dialog" aria-labelledby = "myModallabel">
				
			</div>
			<div class = "well col-lg-12">
				<div class="p-3 my-3 border text-center">
					<form method='post' id="export_attendace" name="export_attendace" action='download.php'>

						<!-- Datepicker -->
						<input type='date' class='datepicker' placeholder="From date" name="from_date" id='from_date' required="required">
						<input type='date' class='datepicker' placeholder="To date" name="to_date" id='to_date' required="required">

						<!-- Export button -->
						<button class="btn btn-success ml-auto" type="submit" id="exportAtt" value="csv"><span class="fa fa-download"></span> Export</button>
						<a href="javascript:void(0)" id="dlbtn" style="display: none;">
							<button type="button" id="mine">Export</button>
						</a>
					</form> 
				</div>
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Barcode No</th>
							<th>Full Name</th>
							<th>Date</th>
							<th>Entry Time</th>
							<th>Leaving Time</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$attendance_qry = $conn->query("SELECT * from `attendance`") or die(mysqli_error());
						while($row = $attendance_qry->fetch_array()){
					?>	
						<tr>
							<td><?php echo $row['barcode']?></td>
							<td><?php echo htmlentities($row['fullname'])?></td>
							<td><?php echo date("F d, Y", strtotime($row['datetime_log_in']))?></td>
							<td><?php echo date("h:i a", strtotime($row['datetime_log_in']))?></td>
							<td><?php 
							$out_time = date("h:i a", strtotime($row['datetime_log_out']));
								if($out_time !== "01:00 am")
									echo $out_time;
							?></td>
							<td><center><button data-id = "<?php echo $row['id']?>" class = "btn btn-sm btn-outline-danger remove_log" type="button"><i class = "fa fa-trash"></i> Remove</button></center></td>
						</tr>
					<?php
						}
					?>	
					</tbody>
				</table>
			<br />
			<br />	
			<br />	
			</div>
		</div>
		</div>
		</div>

	</body>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#table').on('click', '.remove_log', function(){
				// $('.remove_log').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("Are you sure to delete this data ?");
				if(_conf == true){
					$.ajax({
						url:'delete_log.php?id='+id,
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
			
			$("form#export_attendace").submit(function(e) {
				e.preventDefault();
				let formData = new FormData(this);
				let from_date = formData.get('from_date');
				let to_date = formData.get('to_date');
				
				$.ajax({
					type: 'POST',
					url: 'exportExcel.php',
					data: {att_csv:'att_csv', from_date:from_date, to_date:to_date},
						success: function(result) {
							console.log(result);
							setTimeout(function() {
								var dlbtn = document.getElementById("dlbtn");
								var file = new Blob([result], {type: 'text/csv'});
								dlbtn.href = URL.createObjectURL(file);
								dlbtn.download = 'attendance.csv';
								$( "#mine").click();
							}, 2000);
						}
				});
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