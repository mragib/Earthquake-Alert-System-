<?php
$id = $_GET['id'];
?>
<form action="user_data.php" method="POST">
<div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                          <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
                                    </div>
                              </div>
                              <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                          <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
                                    </div>
                              </div>
                        </div>
      <input type='hidden' name='user_name' value="<?php echo $username; ?>"><br>
      <input type='hidden' name='id' value="<?php echo $id; ?>"><br>

      <input type="submit" name="change_password" value="Update">
       
</form>