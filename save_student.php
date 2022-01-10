<?php
	include 'db_connect.php';
		extract($_POST);
		if(empty($id)){
				$i= 1;
				while($i == 1){
				$barcode= $facultyname.$roll_no;
					$chk  = $conn->query("SELECT * FROM student where barcode = '$barcode' ")->num_rows;
					if($chk <= 0){
						$i = 0;
					}
				}
				// exit;
				$save=$conn->query("INSERT INTO `student` (`roll_no`, `barcode`, `fullname`, `facultyname`, `semester`, `mobileno`) VALUES('$roll_no', '$barcode', '$fullname', '$facultyname', '$semester', '$mobileno')") or die(mysqli_error());
				if($save){
						echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
				}else{
					echo json_encode(array('status'=>2,'msg'=>"Something went wrong. Contact Administrator"));
				}
		}else{
			$save=$conn->query("UPDATE `student` set roll_no='$roll_no', fullname='$fullname', facultyname='$facultyname', semester='$semester',mobileno='$mobileno' where id = $id ") or die(mysqli_error());
				if($save){
						echo json_encode(array('status'=>1,'msg'=>"Data successfully Updated"));
				}else{
					echo json_encode(array('status'=>2,'msg'=>"Something went wrong. Contact Administrator"));
				}
		}	

$conn->close();