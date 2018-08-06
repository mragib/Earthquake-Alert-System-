<?php

	require('conn.php'); 

	if(isset($_POST['edit'])) {

		$userstatus = $_POST['userstatus'];
		$date = $_POST['date'];
		$time =$_POST['time'];
	

		 $mobileno=$_POST['mobileno'];

		
		$edit_sql = "UPDATE user_response SET userstatus='".$userstatus."',date='".$date."',time='".$time."' WHERE mobileno = '".$mobileno."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}
	if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From user_response WHERE mobileno LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT * From user_response";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>

			<form action='user_response.php' method='GET'>

				Search : <input type='text' name ='q'><br>
				<input type='submit' value='Search'> 
			</form>



			<form action="user_response.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Mobile Number</th>";
				echo "<th>User Status</th>";
				echo "<th>Date</th>";
				echo "<th>Time</th>";
				echo "<th>Delete</th>";
				echo "<th>Edit</th>";

				
				while($row=mysqli_fetch_assoc($result))
				{
					
					echo "<tr>";
					echo "<td>".$row["mobileno"]."</td>";
					echo "<td>".$row["userstatus"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['mobileno']."></td>";
					echo "<td><a href='user_response_edit.php?id=".$row['mobileno']."'>Edit</a></td>";
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
        				$sql = "DELETE FROM user_response WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: user_response.php');
				}









