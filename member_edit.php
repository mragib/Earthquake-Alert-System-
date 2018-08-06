<?php

require 'conn.php';

$id = $_GET['id'];

$sql = "select * from user_data where id = ".$id;
?>

<form action="member.php" method="POST">
<?php 

if($query_run=mysqli_query($conn,$sql)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                 $id=$row['id'];
                 $name=$row['name'];
                 $user_name=$row['username'];
                 $email=$row['mail'];
                 //$user_name=$row['password'];
                $mobileno=$row['mobileno'];
                 ?>


             
                Name :<input type='text' name='name' value="<?php echo $name; ?>"><br>
				User Name :<input type='text' name='user_name' value="<?php echo $user_name; ?>"><br>
				Email :<input type='text' name='email' value="<?php echo $email; ?>"><br>
				Mobile Number : <input type='text' name='mobileno' value="<?php echo $mobileno; ?>"><br>
				<input type="hidden" name ="id" value='<?php echo $id; ?>'>
                                Active :    <select name="active">
     <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select><br>

		<input type="submit" name="edit" value="Update">



            <?php }
} ?>
</form>