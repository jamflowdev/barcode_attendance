<?php
include("db_connect.php");
$output = '';

    if (isset($_FILES['upload_csv'])) {
        $filename = $_FILES['upload_csv']['tmp_name'];

        if ($_FILES['upload_csv']['size']>0) {
            $file = fopen($filename, 'r');
            $upload = false;
            $count = 0;
            $errors = [];
            
            while (($column = fgetcsv($file, 10000, ',')) !== false) {
                if ($count === 0) {
                    if ($column[0]!=="sr_no" || $column[1]!=="roll_no" || $column[2]!=="fullname" || $column[3]!=="facultyname" || $column[4]!=="semester"|| $column[5]!=="mobileno") {
                        // echo "<script>alert('Invalid File Structure or Missing Headers.\n Please try again...')</script>";
                        echo json_encode(array('status'=>2,'msg'=>"Invalid File Structure or Missing Headers.\nPlease try again..."));
                        exit;
                    }
                } else {
                    if (empty($column[0]) === true || empty($column[1]) === true || empty($column[2]) === true || empty($column[3]) === true || empty($column[4]) === true || empty($column[5]) === true) {
                        array_push($errors, "Invalid Data at row [$count]\n");
                    } else {
                        $barcode= $column[3].$column[1];
                        $chk = $conn->query("SELECT * FROM student where barcode = '$barcode'")->num_rows;
                        if($chk > 0){
                            array_push($errors, "Duplicate Data at row [$count]\n");
                        }else{
                            //"INSERT INTO `student` (`roll_no`, `barcode`, `fullname`, `facultyname`, `semester`, `mobileno`) VALUES('$roll_no', '$barcode', '$fullname', '$facultyname', '$semester', '$mobileno')"
                            $qry = 'INSERT INTO `student` (`roll_no`, `barcode`, `fullname`, `facultyname`, `semester`, `mobileno`) values ("'.$column[1].'","'.$barcode.'","'.$column[2].'","'.$column[3].'","'.$column[4].'","'.$column[5].'");';
                            $upload = mysqli_query($conn, $qry);
                            // if($upload){
                            //     echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
                            // }
                        }
                    }
                }
                $count++;
                // echo "<script>alert('$count')</script>";
            }
            if (($count-1) === count($errors)) {
                // echo "<script>alert('Error:".implode($errors)."\nFailed to upload file, Please try again with valid data.')</script>";
                echo json_encode(array('status'=>2,'msg'=>"Error:\n".implode($errors)."\nFailed to upload file, Please try again with valid data."));
                exit;
            }
            if (empty($errors)) {
                echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
            } else {
                // echo "<script>alert('Error:".implode($errors)."\nTry again with only corrected row(s) for avoiding duplicate records.')</script>";
                echo json_encode(array('status'=>2,'msg'=>"Error:\n".implode($errors)."\nTry again with only corrected row(s) for avoiding duplicate records."));
            }
        }
    }
    if (isset($_FILES['upload_staff_csv'])) {
        $filename = $_FILES['upload_staff_csv']['tmp_name'];

        if ($_FILES['upload_staff_csv']['size']>0) {
            $file = fopen($filename, 'r');
            $upload = false;
            $count = 0;
            $errors = [];
            
            while (($column = fgetcsv($file, 10000, ',')) !== false) {
                if ($count === 0) {
                    if ($column[0]!=="sr_no" || $column[1]!=="employee_no" || $column[2]!=="fullname" || $column[3]!=="facultyname" || $column[4]!=="mobileno" || $column[5]!=="position" || $column[6]!=="barcode") {
                        echo json_encode(array('status'=>2,'msg'=>"Invalid File Structure or Missing Headers.\nPlease try again..."));
                        exit;
                    }
                } else {
                    if($column[6] != 'FALSE'){
                        if (empty($column[0]) === true || empty($column[1]) === true || empty($column[2]) === true || empty($column[3]) === true || empty($column[4]) === true || empty($column[5]) === true) {
                            array_push($errors, "Invalid Data at row [$count]\n");
                        } else {
                            $barcode= $column[6];
                            $chk = $conn->query("SELECT * FROM employee where barcode = '$barcode'")->num_rows;
                            if($chk > 0){
                                array_push($errors, "Duplicate Data at row [$count]\n");
                            }else{
                                $qry = 'INSERT INTO `employee` (`employee_no`, `barcode`, `fullname`, `facultyname`, `mobileno`, `position`) values ("'.$column[1].'","'.$barcode.'","'.$column[2].'","'.$column[3].'","'.$column[4].'","'.$column[5].'");';
                                $upload = mysqli_query($conn, $qry);
                                // if($upload){
                                //     echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
                                // }
                            }
                        }
                    }
                }
                $count++;
                // echo "<script>alert('$count')</script>";
            }
            if (($count-1) === count($errors)) {
                // echo "<script>alert('Error:".implode($errors)."\nFailed to upload file, Please try again with valid data.')</script>";
                echo json_encode(array('status'=>2,'msg'=>"Error:\n".implode($errors)."\nFailed to upload file, Please try again with valid data."));
                exit;
            }
            if (empty($errors)) {
                echo json_encode(array('status'=>1,'msg'=>"Data successfully Saved"));
            } else {
                // echo "<script>alert('Error:".implode($errors)."\nTry again with only corrected row(s) for avoiding duplicate records.')</script>";
                echo json_encode(array('status'=>2,'msg'=>"Error:\n".implode($errors)."\nTry again with only corrected row(s) for avoiding duplicate records."));
            }
        }
    }