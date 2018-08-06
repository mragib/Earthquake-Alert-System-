<?php

require 'conn.php';

$mobileno = $_GET['id'];

$sql = "select * from user_response where mobileno = ".$mobileno;
?>

<form action="user_response.php" method="POST">
<?php 

if($query_run=mysqli_query($conn,$sql)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                 $mobileno=$row['mobileno'];
                 $userstatus=$row['userstatus'];
                 $date=$row['date'];
                 //$user_name=$row['password'];
                 $time=$row['time'];
                 ?>


             
				User Status :<input type='text' name='userstatus' value="<?php echo $userstatus; ?>"><br>
				Date :<input type='text' name='date' value="<?php echo $date; ?>"><br>
				Time : <input type='text' name='time' value="<?php echo $time; ?>"><br>

				<input type="hidden" name ="mobileno" value='<?php echo $mobileno; ?>'>

		<input type="submit" name="edit" value="Update">



            <?php }
} ?>
</form>