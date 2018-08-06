<?php

	require('conn.php'); 
	require('layout/header.php');
	require('includes/config.php'); 

	if(isset($_POST['edit'])) {

		$name = $_POST['name'];
		$mail = $_POST['mail'];
		$username = $_POST['username'];
		$mobileno = $_POST['mobileno'];
		$myselectedbox = $_POST['myselectedbox'];
		$id=$_POST['id'];
		
		
		$edit_sql = "UPDATE user_data SET name='".$name."',mail='".$mail."',username='".$username."',mobileno='".$mobileno."',usertype='".$myselectedbox."' WHERE id = '".$id."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}


if(isset($_POST['change_password'])) {



		$id=$_POST['id'];


   if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	if(!isset($error)){
         $hashedpassword = $_POST['password'];

			$edit_sql= "UPDATE user_data SET password='".$hashedpassword."' WHERE id='".$id."'";


		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}


	}


	if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From user_data WHERE name LIKE '%". $_GET['q']."%' or mobileno LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT * From user_data";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>
	<form action='user_data.php' method='GET'>
                   <div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="q" id="search" class="form-control input-lg" placeholder="Name or Mobile Number" tabindex="3">
							<input type='submit' value='Search'>
						</div>
					</div>

</div>
</form>

			<?php






			?>




			<form action="user_data.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Id</th>";
				echo "<th>Name</th>";
				echo "<th>Email</th>";
				echo "<th>User Name</th>";
				echo "<th>Mobile Number</th>";
				echo "<th>User Type</th>";
				echo "<th>Delete</th>";
				echo "<th>Edit</th>";
				echo "<th>Change Password</th>";

				
				while($row=mysqli_fetch_assoc($result))
				{
					
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["name"]."</td>";
					echo "<td>".$row["mail"]."</td>";
					echo "<td>".$row["username"]."</td>";
					echo "<td>".$row["mobileno"]."</td>";
					echo "<td>".$row["usertype"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['id']."></td>";
					echo "<td><a href='user_data_edit.php?id=".$row['id']."'>Edit</a></td>";
					echo "<td><a href='user_change_password.php?id=".$row['id']."'>Change Password</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
				<a href='userregistation.php'>Add User</a>
				<a href='index.php'>Home</a>
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM user_data WHERE id = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: user_data.php');
				}









