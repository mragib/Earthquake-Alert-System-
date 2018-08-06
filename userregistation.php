<?php
	
	require 'core.php';
	require('conn.php');
	require('includes/config2.php');


       //fill up form

		if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_again'])&&isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['mobileno'])&&isset($_POST['myselectedbox'])){

            

			$reg_user_name = $_POST["name"];
			$reg_user_mail = $_POST["email"];
			$reg_lgn_user_name = $_POST["username"];
			$reg_user_pass = $_POST["password"];
			$reg_user_pass_again=$_POST['password_again'];
			$reg_user_mblno= $_POST["mobileno"];
			$reg_user_type=$_POST["myselectedbox"];

			

			// password match

			if(!empty($reg_user_name)&&!empty($reg_user_mail)&&!empty($reg_user_name)&&!empty($reg_user_pass)&&!empty($reg_user_pass_again)&&!empty($reg_user_mblno)&&!empty($reg_user_type)){

				if ($reg_user_pass!=$reg_user_pass_again) {
					echo 'Password dont match';
				} else {
					
					$sql="select username from user_data where username='".mysqli_real_escape_string($conn,$reg_lgn_user_name)."'";

					$query_run=mysqli_query($conn,$sql);


					if(mysqli_num_rows($query_run)==1){

						echo 'Username '.$reg_lgn_user_name.' is already exists';

					}else{
						$reg_user_pass = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);


  	      $sql1="INSERT INTO user_data(id,name,mail,username,password,mobileno,usertype,active) VALUES (null,'".mysqli_real_escape_string($conn,$reg_user_name)."','".mysqli_real_escape_string($conn,$reg_user_mail)."','".mysqli_real_escape_string($conn,$reg_lgn_user_name)."','".mysqli_real_escape_string($conn,$reg_user_pass)."','".mysqli_real_escape_string($conn,$reg_user_mblno)."','".mysqli_real_escape_string($conn,$reg_user_type)."','Yes')";
		
		
		  $x=mysqli_query($conn,$sql1);
		
		  	if($x)
		   	echo "save";
			else
			echo "Not Save";

					}


				}
				

			}
			else{
				echo 'All field are required';
			}



		}
		
	

?>


		<form action="userregistation.php" method="POST">
		Name : <input type='text' name ="name"><br>
		User Name : <input type='text' name='username'><br>
		Email ID : <input type='mail' name="email"><br>
		Phone : <input type='mail' name='mobileno'><br>
		Password:<input type='password' name='password'><br>
		Password Again : <input type='password' name='password_again'><br>
		
		User Type :
		<select name="myselectedbox">
 		 <option value="Admin">Admin</option>
  		<option value="Modarator">Modarator</option>
  		<option value="User">User</option>
		</select>

		<input type='submit' value='Submit' id="demo" onclick="getLocation()">
		
</form>




<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
   global Latitude = " + position.coords.latitude + 
    global Longitude =  " + position.coords.longitude;
}
</script>



