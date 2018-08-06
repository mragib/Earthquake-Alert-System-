<?php
require 'conn.php';

if(isset($_POST['reset_sts'])) {

		date_default_timezone_set("Asia/Dhaka");
    $str_lcn_time= date("h:i:sa");
$str_lcn_date = date("Y-m-d");
$reset_status=$_POST['reset_status'];
$edit_sql= "UPDATE user_response SET userstatus='".$reset_status."',date='".$str_lcn_date."',time='".$str_lcn_time."'";


$x=mysqli_query($conn,$edit_sql);
if ($x) {
	echo "Updated";
}
else{
	echo "Not Save";
}

}





if(isset($_POST['change_status'])) {


$change_status=$_POST['myselect'];
$id=$_POST['id'];
$edit_sql= "UPDATE user_response SET userstatus='".$change_status."' WHERE mobileno='".$id."'";


$x=mysqli_query($conn,$edit_sql);
if ($x) {
	echo "Updated";
}
else{
	echo "Not Save";
}

}



?>

<form action="help_on_map.php" method="POST">


 User Status:
<select name="myselectedbox">
 <option value="SAFE">SAFE</option>
 <option value="HELP">HELP</option>
 <option value="ALL">ALL</option>
 </select><br>

		<input type="submit" name="status" value="status">
</form>


<?php
global $result;
$location = array();

if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,location.lattitude,location.longititude,location.address,user_response.date,user_response.time,user_response.userstatus FROM user_data join location on (user_data.mobileno=location.mobileno) join user_response on (location.mobileno=user_response.mobileno) WHERE user_data.mobileno=location.mobileno AND user_data.mobileno LIKE '%". $_GET['q']."%'";


	} else {
	
$sql="SELECT user_data.id,user_data.name,user_data.mail,user_data.username,user_data.mobileno,user_data.usertype,location.lattitude,location.longititude,location.address,user_response.date,user_response.time,user_response.userstatus FROM user_data join location on (user_data.mobileno=location.mobileno) join user_response on (location.mobileno=user_response.mobileno) WHERE user_data.mobileno=location.mobileno";


	}

	


			$result=mysqli_query($conn,$sql);
 ?>

<form action='help_on_map.php' method='GET'>
                   <div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="q" id="search" class="form-control input-lg" placeholder="Mobile Number" tabindex="3">
							<input type='submit' value='Search'>
						</div>
					</div>

</div>
</form>
 
			<form action="help_on_map.php" method="POST">
				<?php

	if(isset($_POST['status'])){

	$myselectedbox = $_POST['myselectedbox'];

	echo "<h1> Showing users who are asked for ".$myselectedbox."</h1>";

if($myselectedbox=='ALL')
{
	$sql="SELECT * From location JOIN user_data ON (location.mobileno = user_data.mobileno) Join user_response ON (user_response.mobileno=location.mobileno)";
}
else{
$sql="SELECT * From location JOIN user_data ON (location.mobileno = user_data.mobileno) Join user_response ON (user_response.mobileno=location.mobileno) where user_response.userstatus='".$myselectedbox."'";
}
$result=mysqli_query($conn,$sql);
}

				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Name</th>";
				echo "<th>Email</th>";
				echo "<th>Mobile Number</th>";
				echo "<th>Address</th>";
				echo "<th>Status</th>";
				echo "<th>Date</th>";
				echo "<th>Time</th>";
				echo "<th>Edit</th>";
				
				while($row=mysqli_fetch_assoc($result))
				{
					array_push($location, array($row["name"], $row["lattitude"], $row["longititude"], $row["mobileno"]));
					echo "<tr>";
					echo "<td>".$row["name"]."</td>";
					echo "<td>".$row["mail"]."</td>";
					echo "<td>".$row["mobileno"]."</td>";
					echo "<td>".$row["address"]."</td>";
					echo "<td>".$row["userstatus"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";
                 echo "<td><a href='help_on_map_edit.php?id=".$row['mobileno']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
		

			}
			
?>
<a href='help_status_reset.php'>Reset</a>
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
<div id="googleMap" style="width:1200px;height:800px; align: center"></div>

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
<div id="googleMap" style="width:1200px;height:800px; align: center"></div>















