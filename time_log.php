<?php
include 'db_connect.php';
	extract($_POST);
	$data= array();
	$flag = null;
	$qry= "";

	// SELECT * FROM ( SELECT id, barcode, fullname, position from employee UNION ALL SELECT id, barcode, fullname, position from student) a WHERE barcode = '$barcode'
	$qry = $conn->query("SELECT * FROM ( SELECT id, barcode, fullname, position from employee UNION ALL SELECT id, barcode, fullname, position from student) a WHERE barcode = '$barcode'");
	if($qry->num_rows > 0){
		$res = $qry->fetch_array();
		$save_log = null;
		$fullname = ucwords($res['fullname']);

		if($type == 1){
			$save_log = $conn->query("INSERT INTO attendance (barcode, fullname, position) VALUES('".$res['barcode']."', '$fullname', '".$res['position']."')");
			// $last_id = $conn->insert_id;
			$log = ' entry time';
		}elseif($type == 2){
			// SELECT * FROM attendance WHERE barcode = emp_id AND log_type=1 ORDER BY id DESC LIMIT 1
			$qry = $conn->query("SELECT * FROM attendance WHERE barcode ='".$res['barcode']."' AND datetime_log_out IS NULL ORDER BY id DESC LIMIT 1");
			if($qry->num_rows > 0){
				$res = $qry->fetch_array();
				$save_log = $conn->query("UPDATE attendance SET datetime_log_out = now() WHERE id = '".$res['id']."'");
				$log = ' leaving out time';
				// echo "<script>console.log('".$res['id']."');</script>";
			}else{
				$data['status'] = 2;
				$data['msg'] = $fullname .', your last entry time is not recorded yet.' ;
			}
		}
		if($save_log){
				$data['status'] = 1;
				$data['msg'] = $fullname .', your '.$log.' has been recorded. <br/>' ;
			}
	}else{
		$data['status'] = 2;
		$data['msg'] = "$flag";
	}
	echo json_encode($data);
	$conn->close();
