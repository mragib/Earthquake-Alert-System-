<?php

require 'conn.php';

 $username =$_GET['id'];
//echo $username;

// $sql="SELECT mobileno FROM user_data WHERE username='".$username."'";

// $sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,location.lattitude,location.longititude,location.address,location.date,location.time FROM user_data,location WHERE user_data.mobileno=location.mobileno AND user_data.username='".$username."'";
// //var_dump($sql);

?>

<form action="userProfile.php" method="POST">
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

      <input type="submit" name="edit" value="Update">
       
</form>