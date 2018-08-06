<?php

	require('conn.php'); 

	if(isset($_POST['edit'])) {
		$name = $_POST['name'];
		$username = $_POST['user_name'];
		$mail = $_POST['email'];
		$mobileno =$_POST['mobileno'];
$active=$_POST['active'];

		 $id=$_POST['id'];

		
		$edit_sql = "UPDATE user_data SET username='".$username."',mail='".$mail."',name='".$name."',mobileno='".$mobileno."',active='".$active."' WHERE id = '".$id."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}
	if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From user_data WHERE username LIKE '%". $_GET['q']."%' AND usertype ='Admin'";


	} else {
		$sql="SELECT * From user_data WHERE usertype ='Admin'";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>

			<form action='member.php' method='GET'>

				Search : <input type='text' name ='q'><br>
				<input type='submit' value='Search'> 
			</form>



			<form action="member.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Id</th>";
				echo "<th>Name</th>";
				echo "<th>Email</th>";
				echo "<th>User Name</th>";
				echo "<th>Mobile Number</th>";
				echo "<th>Active</th>";
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
					echo "<td>".$row["active"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['id']."></td>";
					echo "<td><a href='member_edit.php?id=".$row['id']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
				<a href='logout.php'>Add Member</a>
				<a href='index.php'>Home</a>
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM user_data WHERE id = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: member.php');
				}









