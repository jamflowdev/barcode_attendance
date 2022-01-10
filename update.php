<?php
include 'db_connect.php';
	if(isset($_POST['update_setting'])){
    $data = array();
    $qry_1 = $conn->query("UPDATE student SET barcode = '', semester = 7 WHERE semester = 6");
    $qry_2 = $conn->query("UPDATE student SET semester = 6 WHERE semester = 5");
    $qry_3 = $conn->query("UPDATE student SET semester = 5 WHERE semester = 4");
    $qry_4 = $conn->query("UPDATE student SET semester = 4 WHERE semester = 3");
    $qry_5 = $conn->query("UPDATE student SET semester = 3 WHERE semester = 2");
    $qry_6 = $conn->query("UPDATE student SET semester = 2 WHERE semester = 1");
    
    if($qry_1 && $qry_2 && $qry_3 && $qry_4 && $qry_5 && $qry_6){
      $data['status'] = 1;
      $data['msg'] = "Records updated successfully." ;
    }else{
      $data['status'] = 2;
      $data['msg'] = 'Something went wrong.\n Please contact Support Team.' ;
    }
  }
	echo json_encode($data);
	$conn->close();
