<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() && $_SESSION['usertype']=='Admin'){ header('Location: memberpage.php'); }
elseif( $user->is_logged_in() && $_SESSION['usertype']=='User'){ header('Location: userProfile.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM user_data WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT mail FROM user_data WHERE mail = :mail');
		$stmt->execute(array(':mail' => $_POST['mail']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['mail'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			date_default_timezone_set("Asia/Dhaka");
			$str_lcn_time= date("h:i:sa");
			$str_lcn_date = date("Y-m-d");

			//insert into database with a prepared statement

			$stmt1 = $db->prepare('INSERT INTO user_response (mobileno,userstatus,date,time) VALUES (:mobileno,"SAFE", :date, :time)');
			$stmt1->execute(array(
			':mobileno' => $_POST['mobileno'],
			':date' => $str_lcn_date,
			':time' => $str_lcn_time,
			
			));

						$stmt = $db->prepare('INSERT INTO user_data (name,mail,username,password,mobileno,usertype,active) VALUES (:name, :mail, :username, :password, :mobileno,"User",:active)');
			$stmt->execute(array(
			':name' => $_POST['name'],
			':mail' => $_POST['mail'],
			':username' => $_POST['username'],
			':password' => $hashedpassword,
			':mobileno' => $_POST['mobileno'],
			':active' => $activasion
			));
			$id = $db->lastInsertId('id');

			$stmt2 = $db->prepare('INSERT INTO location (mobileno,lattitude,longititude,address,date,time) VALUES (:mobileno,"23.786982","90.377493","Green University", :date, :time)');
			$stmt2->execute(array(
			':mobileno' => $_POST['mobileno'],
			':date' => $str_lcn_date,
			':time' => $str_lcn_time,
			
			));











			

			//send email
			$to = $_POST['mail'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at EarthQuake site.</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Earth Quake';

//include header template
require('layout/header.php');
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='index.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
				}
				?>

				<div class="form-group">
				<input type="text" name="name" id="name" class="form-control input-lg" placeholder="Name" value="<?php if(isset($error)){ echo $_POST['name']; } ?>" tabindex="1">

					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="email" name="mail" id="mail" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['mail']; } ?>" tabindex="2">

					<input type="text" name="mobileno" id="mobileno" class="form-control input-lg" placeholder="Phone Number" value="<?php if(isset($error)){ echo $_POST['mobileno']; } ?>" tabindex="2">
				</div>
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

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>

</div>

<?php
//include header template
require('layout/footer.php');
?>
