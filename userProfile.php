<?php require('includes/config.php'); 
require('conn.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: index.php'); } 

//define page title
$title = 'User Profile';

//include header template
require('layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			
				<h2>User only page - Welcome <?php echo $_SESSION['username']; ?></h2>
				<?php
	if(isset($_POST['edit'])) {

$username = $_POST['user_name'];

   if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	if(!isset($error)){
         $hashedpassword = $_POST['password'];

			$edit_sql= "UPDATE user_data SET password='".$hashedpassword."' WHERE username='".$username."'";


		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}


	}


$username=$_SESSION['username'];

$location = array();


$sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,location.lattitude,location.longititude,location.address,location.date,location.time FROM user_data,location WHERE user_data.mobileno=location.mobileno AND user_data.username='".$username."'";



			$result=mysqli_query($conn,$sql);


				if(mysqli_num_rows ($result)>0){
	
				while($row=mysqli_fetch_assoc($result))
				{
					array_push($location, array($row["name"], $row["lattitude"], $row["longititude"], $row["mobileno"]));
					
					echo "Your Name is : ".$row["name"]."<br>";
					echo "Your Email Adrress is : ".$row["mail"]."<br>";
					echo "Your Username : ".$row["username"]."<br>";
					echo "Your Mobile number is : ".$row["mobileno"]."<br>";
					echo "You are : ".$row["usertype"]."<br>";
					echo "Your Present Lattitude : ".$row["lattitude"]."<br>";
					echo "Your Present Longititude : ".$row["longititude"]."<br>";
					echo "Your Present Address : ".$row["address"]."<br>";


				}
			
			}



echo '<a href="userProfileEdit.php?id='.$username.'">Change Password</a>';
echo '<p><a href="logout.php">Logout</a></p>';

?>



		</div>
	</div>


</div>





<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>
<script>

// Set location to centre on
var myCenter=new google.maps.LatLng(23.786982,90.377493);


var locations = <?php echo json_encode($location); ?>;


function initialize()
{
//apply location marker to centre on
var mapProp = {
  center:myCenter,
  zoom:18,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
position:myCenter,
title: 'My centre location marker'
});

marker.setMap(map);

 
// apply other location markers
for (i = 0; i < locations.length; i++) {

marker = new google.maps.Marker({
position: new google.maps.LatLng(locations[i][1], locations[i][2]),
map: map,
title: locations[i][0]+" "+locations[i][3]
});
}
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="googleMap" style="width:1500px;height:500px; align: center"></div>
	

				






<?php

//include header template
require('layout/footer.php'); 
?>
