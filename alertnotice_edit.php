<?php

require 'conn.php';

$serial = $_GET['id'];

$sql = "select * from alertnotice where serial = ".$serial;
?>

<form action="alertnotice.php" method="POST">
<?php 

if($query_run=mysqli_query($conn,$sql)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                 $notice=$row['notice'];
                 $status=$row['status'];
                 $date=$row['date'];
                 $time=$row['time'];
                 ?>


                Notice :<input type='text' name='notice' value="<?php echo $notice; ?>"><br>
			    Status :<input type='text' name='status' value="<?php echo $status; ?>"><br>
				Date :<input type='text' name='date' value="<?php echo $date; ?>"><br>
				Time : <input type='text' name='time' value="<?php echo $time; ?>"><br>

				<input type="hidden" name ="serial" value='<?php echo $serial; ?>'>

		<input type="submit" name="edit" value="Update">



            <?php }
} ?>
</form>