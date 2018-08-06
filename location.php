<?php

require 'conn.php';

if(isset($_GET['q']) && $_GET['q']){  

		$sql="SELECT * From location WHERE mobileno LIKE '%". $_GET['q']."%'";


	} else {
		$sql="SELECT * From location JOIN user_data ON  location.mobileno = user_data.mobileno";


	}

	



			$result=mysqli_query($conn,$sql); 
			?>

			<form action='location.php' method='GET'>

				Seaech : <input type='text' name ='q'><br>
				<input type='submit' value='Search'> 
			</form>


<?php //var_dump(mysqli_fetch_assoc($result));
$location = array();
 ?>


			<form action="location.php" method="POST">




				<?php
				if(mysqli_num_rows ($result)>0){
			echo "<table style='border:1px solid red'>";
			echo"<br>";
				echo "<th>Mobile Number</th>";
				echo "<th>Lattitude</th>";
				echo "<th>Longititude</th>";
				echo "<th>Address</th>";
				echo "<th>Date</th>";
				echo "<th>Time</th>";
				echo "<th>Delete</th>";
				echo "<th>Edit</th>";

				
				while($row=mysqli_fetch_assoc($result))
				{
					array_push($location, array($row["name"], $row["lattitude"], $row["longititude"], $row["mobileno"]));
					
					echo "<tr>";
					echo "<td>".$row["mobileno"]."</td>"; 
					echo "<td>".$row["lattitude"]."</td>";
					echo "<td>".$row["longititude"]."</td>";
					echo "<td>".$row["address"]."</td>";
					echo "<td>".$row["date"]."</td>";
					echo "<td>".$row["time"]."</td>";
					echo "<td><input name='checkbox[]' type='checkbox' value=".$row['mobileno']."></td>";
					echo "<td><a href='locationedit.php?id=".$row['mobileno']."'>Edit</a></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
 
				?>
				<input type='submit' name='delete' value='Delete'>
				
				
			
			</form>
			<?php
			if (isset($_POST['delete']) && isset($_POST['checkbox'])) {
    			foreach($_POST['checkbox'] as $del_id){
        				$del_id = (int)$del_id;
        				$sql = "DELETE FROM location WHERE mobileno = $del_id"; 
       						 mysqli_query($conn,$sql);
   					 }
   					 header('Location: location.php');
				}
?>
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

	if(isset($_POST['edit'])) {

		$mobileno=$_POST['mobileno'];
		$lattitude = $_POST['lattitude'];
		$longititude = $_POST['longititude'];
		$address = $_POST['address'];
		$date = $_POST['date'];
		$time=$_POST['time'];
		
		
		$edit_sql = "UPDATE location SET mobileno='".$mobileno."',lattitude='".$lattitude."',longititude='".$longititude."',address='".$address."',date='".$date."',time='".$time."' WHERE mobileno = '".$mobileno."'";

		$x=mysqli_query($conn,$edit_sql);
		if ($x) {
			echo "Updated";
		}
		else{
			echo "Not Save";
		}

	}
?>