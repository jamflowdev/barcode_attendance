<?php
	require_once 'db_connect.php';
	extract($_POST);
	$qry = $conn->query("SELECT * FROM users WHERE username = '$username'") or die(msqli_error());
	$login = $qry->fetch_array();
	if($qry->num_rows > 0){
		if(password_verify($password, $login['password'])) {
			echo true;
			session_start();
			foreach($login as $k => $v){
				if(!is_numeric($k) && $k !='password'){
					$_SESSION['login_'.$k] = $v;
				}
			}
			$_SESSION['user_role'] = $login['role'];
		}
	}else{
		echo false;
	}

	$conn->close();