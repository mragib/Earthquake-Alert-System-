<?php
$id = $_GET['id'];
?>
<form action="help_on_map.php" method="POST">
 User Status:
<select name="myselect">
 <option value="SAFE">SAFE</option>
 <option value="HELP">HELP</option>
 </select><br>
 	<input type="submit" name="change_status">
       <input type='hidden' name='id' value="<?php echo $id; ?>"><br>


    </form>