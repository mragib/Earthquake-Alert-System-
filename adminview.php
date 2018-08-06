<?php

	require('conn.php'); 

	if(isset($_POST['edit'])) {

		$name = $_POST['name'];
		$mail = $_POST['mail'];
		$username = $_POST['username'];
		$mobileno = $_POST['mobileno'];
		$myselectedbox = $_POST['myselectedbox'];
		$id=$_POST['id'];
		$active=$_POST['active'];
		

		$edit_sql = "UPDATE user_data SET name='".$name."',mail='".$mail."',username='".$username."',mobileno='".$mobileno."',usertype='".$myselectedbox."', active = '".$active."' WHERE id = '".$id."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}
	?>
	<form action='adminview.php' method='GET'>
                   <div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="q" id="search" class="form-control input-lg" placeholder="Mobile Number" tabindex="3">
							<input type='submit' value='Search'>
						</div>
					</div>

</div>
</form>
	<?php


	if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,location.lattitude,user_data.active,location.longititude,location.address,location.date,location.time FROM user_data,location WHERE user_data.mobileno=location.mobileno and user_data.mobileno LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,user_data.active,location.lattitude,location.longititude,location.address,location.date,location.time FROM user_data,location WHERE user_data.mobileno=location.mobileno";


	}


	



			$result=mysqli_query($conn,$sql); ?>

			<form action="adminview.php" method="POST">
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
				echo "<th>Active</th>";
				echo "<th>Lattitude</th>";
				echo "<th>Longititude</th>";
				echo "<th>Address</th>";
				echo "<th>Date</th>";
				echo "<th>Time</th>";
				echo "<th>Delete</th>";
				echo "<th>Edit</th>";

				
				while($row=mysqli_fetch_assoc($result))
				{
					
					echo "<tr>";
					echo "<td>".$row["id"]."</td>";
					echo "<td>".$row["name"]."</td>";
					echo "<td>".$row["mail"]."</td>";
					echo "<td>".$row["username"]."</td>";
					echo "<td>".$row["mobileno"]."</td>";
					echo "<td>".$row["usertype"]."</td>";
					echo "<td>".$row["active"]."</td>";
					echo "<td>".$row["lattitude"]."</td>";
					echo "<td>".$row["longititude"]."</td>";
					echo "<td>".$row["address"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";

					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['mobileno']."></td>";
					echo "<td><a href='adminedit.php?id=".$row['id']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM user_data WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
       					$sql = "DELETE FROM location WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
       					$sql = "DELETE FROM user_response WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: adminview.php');
				}






