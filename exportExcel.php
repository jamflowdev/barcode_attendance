<?php

include("db_connect.php");
if (isset($_POST['student_csv'])) {
	header('Content-Type: text/csv; charset=utf-8');

	header('Content-Disposition: attachment; filename=Data.csv');
	
	$output = fopen("php://output", "w");
	fputcsv($output, array('id', 'roll_no', 'barcode', 'fullname', 'facultyname', 'semester', 'mobileno'));
	$sql = "SELECT `id`, `roll_no`, `barcode`, `fullname`, `facultyname`, `semester`, `mobileno` FROM `student`";
	$qry = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($qry)) {
		fputcsv($output, $row);
	}
	fclose($output);
}
if (isset($_POST['staff_csv'])) {
	header('Content-Type: text/csv; charset=utf-8');

	header('Content-Disposition: attachment; filename=Data.csv');
	
	$output = fopen("php://output", "w");
	fputcsv($output, array('id', 'employee_no', 'barcode', 'fullname', 'facultyname', 'mobileno', 'position'));
	$sql = "SELECT * FROM `employee`";
	$qry = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($qry)) {
		fputcsv($output, $row);
	}
	fclose($output);
}
if (isset($_POST['att_csv'])) {
	header('Content-Type: text/csv; charset=utf-8');

	header('Content-Disposition: attachment; filename=Data.csv');
	
	$output = fopen("php://output", "w");
	fputcsv($output, array('Id', 'Barcode', 'FullName', 'EntryTime', 'ExitTime', 'Position'));
	

	$date=date_create($_POST['from_date']);
	$from_date = date_format($date,"Y-m-d 05:00:00");
	
	$date=date_create($_POST['to_date']);
	$to_date = date_format($date,"Y-m-d 23:00:00");

	$sql = "SELECT * FROM `attendance` WHERE datetime_log_in >= '".$from_date."' AND datetime_log_in <= '".$to_date."'";
	// echo $sql;
	$qry = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($qry)) {
		fputcsv($output, $row);
	}
	fclose($output);
}
?>