<?php

		ob_start();
		session_start();

require 'conn.php';

		$current_file=$_SERVER['SCRIPT_NAME'];


		if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])){
		$http_referer = $_SERVER['HTTP_REFERER'];
	}


		function loggedin(){


			if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
				

				return true;
			} else {
				
				return false;
			}
			
		}


		function getuserfield(){

			global $conn;
			
			$query="SELECT * FROM user_data WHERE id='".$_SESSION['user_id']."'AND usertype = 'user'";

			if($query_run=mysqli_query($conn,$query)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                   	echo	$user_id=$row['id'];
                   	echo	$user_name=$row['name'];



                   }


			} else {
				echo 'Not Found';
			}
			


		}




?>