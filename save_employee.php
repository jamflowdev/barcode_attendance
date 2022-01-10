<?php
	include 'db_connect.php';
		extract($_POST);
		if(empty($id)){
				$i= 1;
				while($i == 1){
				$e_num = 'STAFF_'.$facultyname.'_'.$position.'_'.$employee_no;
					$chk  = $conn->query("SELECT * FROM employee where employee_no = '$e_num' ")->num_rows;
					if($chk <= 0){
						$i = 0;
					}
				}
				// exit;
				$save=$conn->query("INSERT INTO `employee` (`employee_no`, `barcode`, `fullname`, `facultyname`, `mobileno`, `position`) VALUES('$employee_no', '$barcode','$fullname', '$facultyname', '$mobileno', '$position')") or die(mysqli_error());
				if($save){
					echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
				}else{
					echo json_encode(array('status'=>2,'msg'=>"Something went wrong. Contact Administrator"));
				}	
		}else{
			$save=$conn->query("UPDATE `employee` set employee_no='$employee_no', barcode='$barcode', fullname='$fullname', facultyname='$facultyname', mobileno='$mobileno',position='$position' where id = $id ") or die(mysqli_error());
				if($save){
					echo json_encode(array('status'=>1,'msg'=>"Data successfully Updated"));
				}else{
					echo json_encode(array('status'=>2,'msg'=>"Something went wrong. Contact Administrator"));
				}
		}	

$conn->close();