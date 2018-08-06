<?php

require 'conn.php';

$mobileno = $_GET['id'];

$sql = "select * from location where mobileno = ".$mobileno;
?>

<form action="location.php" method="POST">
<?php 

if($query_run=mysqli_query($conn,$sql)) {
				
				 while ($row=mysqli_fetch_assoc($query_run)) {
                   		
                 $mobileno=$row['mobileno'];
                 $lattitude=$row['lattitude'];
                 $longititude=$row['longititude'];
                 //$user_name=$row['password'];
                 $address=$row['address'];
                 $date=$row['date'];
                 $time=$row['time'];?>


             <input type='hidden' name='mobileno' value="<?php echo $mobileno; ?>"><br>
				Lattitude :<input type='text' name='lattitude' value="<?php echo $lattitude; ?>"><br>
				Longititude :<input type='text' name='longititude' value="<?php echo $longititude; ?>"><br>
				Address : <input type='text' name='address' value="<?php echo $address; ?>"><br>
        Date : <input type='text' name='date' value="<?php echo $date; ?>"><br>
        Time : <input type='text' name='time' value="<?php echo $time; ?>"><br>
				<input type="hidden" name ="id" value='<?php echo $user_id; ?>'>

		<input type="submit" name="edit" value="Update">



            <?php }
} ?>
</form>