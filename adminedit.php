<?php

require 'conn.php';

$id = $_GET['id'];

$sql = "select * from user_data where id = ".$id;
?>

<form action="adminview.php" method="POST">
<?php 

if($query_run=mysqli_query($conn,$sql)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                 $user_name=$row['name'];
                 $user_mail=$row['mail'];
                 $user_lgn_name=$row['username'];
                 //$user_name=$row['password'];
                 $user_mblno=$row['mobileno'];
                 $user_usertype=$row['usertype'];
                 $user_id=$row['id'];?>


                Name : <input type='text' name='name' value="<?php echo $user_name; ?>"><br>
				Email :<input type='text' name='mail' value="<?php echo $user_mail; ?>"><br>
				User Name :<input type='text' name='username' value="<?php echo $user_lgn_name; ?>"><br>
				Phone Number : <input type='text' name='mobileno' value="<?php echo $user_mblno; ?>"><br>
				<input type="hidden" name ="id" value='<?php echo $user_id; ?>'>
				Active :    <select name="active">
     <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select><br>


				User Type :
		<select name="myselectedbox">
 		 <option value="admin">Admin</option>
  		<option value="modarator">Modarator</option>
  		<option value="User">User</option>
		</select><br>

		<input type="submit" name="edit" value="Update">



            <?php }
} ?>
</form>




 




 















