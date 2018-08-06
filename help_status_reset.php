<form action="help_on_map.php" method="POST">
 User Status:
<select name="reset_status">
 <option value="SAFE">SAFE</option>
 <option value="HELP">HELP</option>
 </select><br>
 	<input type="submit" name="reset_sts">
       <input type='hidden' name='id' value="<?php echo $id; ?>"><br>


    </form>