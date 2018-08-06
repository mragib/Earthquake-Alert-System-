<?php

	require('conn.php'); 

	if(isset($_POST['edit'])) {
        $notice =$_POST['notice'];
		$status = $_POST['status'];
		$date = $_POST['date'];
		$time =$_POST['time'];
	

		 $serial=$_POST['serial'];

		
		$edit_sql = "UPDATE alertnotice SET notice ='".$notice."',status='".$status."',date='".$date."',time='".$time."' WHERE serial = '".$serial."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}
	if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From alertnotice WHERE date LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT * From alertnotice";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>

			<form action='alertnotice.php' method='GET'>

				Search : <input type='text' name ='q'><br>
				<input type='submit' value='Search'> 
			</form>



			<form action="alertnotice.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
			echo "<th>Serial</th>";
				echo "<th>Notice</th>";
				echo "<th>Status</th>";
				echo "<th>Date</th>";
				echo "<th>Time</th>";
				echo "<th>Delete</th>";
				echo "<th>Edit</th>";

				
				while($row=mysqli_fetch_assoc($result))
				{
					
					echo "<tr>";
					echo "<td>".$row["serial"]."</td>";
					echo "<td>".$row["notice"]."</td>";
					echo "<td>".$row["status"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['serial']."></td>";
					echo "<td><a href='alertnotice_edit.php?id=".$row['serial']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
				<a href="new_alert_notice.php">New Alert</a>
				
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM alertnotice WHERE serial = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: alertnotice.php');
				}





require 'core.php';
	require('conn.php');

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{

			$notice = $_POST["notice"];
			$status = $_POST["status"];
		
		date_default_timezone_set("Asia/Dhaka");
    $str_lcn_time= date("h:i:sa");
$str_lcn_date = date("Y-m-d");




  	      $sql1="INSERT INTO alertnotice (serial,notice,status,date,time) VALUES (null,'$notice','$status','$str_lcn_date','$str_lcn_time')";
		
		
		  $x=mysqli_query($conn,$sql1);
		  var_dump($sql1);
		
		  	if($x)
		   	echo "save";
			else
			echo "Not Save";
	}



