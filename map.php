<?php

require 'conn.php';

if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From location WHERE mobileno LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT * From location";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>

			<form action='location.php' method='GET'>

				Seaech : <input type='text' name ='q'><br>
				<input type='submit' value='Search'> 
			</form>





			<form action="location.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Mobile Number</th>";
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
					echo "<td>".$row["mobileno"]."</td>";
					echo "<td>".$row["lattitude"]."</td>";
					echo "<td>".$row["longititude"]."</td>";
					echo "<td>".$row["address"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['mobileno']."></td>";
					echo "<td><a href='adminedit.php?id=".$row['mobileno']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
				<a href='index.php'>Add Member</a>
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM location WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: location.php');
				}




