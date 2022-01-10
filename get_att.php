<?php
	include 'db_connect.php';
		extract($_POST);
		$data=array();
		$get=$conn->query("SELECT * FROM ( SELECT id, barcode, fullname, position from employee UNION ALL SELECT id, barcode, fullname, position from student) a WHERE barcode = '$barcode'") or die(mysqli_error());
		
		if($get->num_rows > 0 ){
			$result = $get->fetch_array();
			// SELECT * FROM `attendance` WHERE `barcode` = ".$barcode." AND DATE_FORMAT(`datetime_log_in` ,'%Y/%m/%d') = CURRENT_DATE() AND `datetime_log_out` IS NULL
			$qry = $conn->query("SELECT * FROM `attendance` WHERE `barcode` = '$barcode' AND DATE_FORMAT(`datetime_log_in` ,'%Y/%m/%d') = CURRENT_DATE() AND `datetime_log_out` IS NULL") or die(mysqli_error());
			// echo $qry;
			if($qry->num_rows > 0 ){
				// $data = $qry->fetch_array();
				$data['status'] = 2;
				$data['msg'] = 'ok';
			}else{
				// $data = $result;
				$data['status'] = 1;
				$data['msg'] = 'ok';
			}
		}else{
			$data['status'] = 402;
			$data['msg'] = 'Record Not Found';
		}
		echo json_encode($data);
$conn->close();