<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php $page_header = "CROPS - Staff Area"; ?>
<?php include("includes/header.php"); ?>

<?php
	session_start();

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
		header("location: login_page_staff.php");
		exit();
	}
?>

<table id="structure">
	<tr>
		<td id="navigation">
	      <ul>
	        <li><a href="staff.php">Home</a><li>
	        <li><a href="teacher_schedule.php"><b><u>Schedule</u></b></a></li>
	        <li><a href="create_assignment.php">+ Add Assignment</a></li>
	        <li><a href="delete_assignment.php">- Delete Assignment</a></li>
	        <li><a href="create_resource.php">+ Add Resources</a></li>
	        <li><a href="delete_resource.php">- Delete Resources</a></li>
	        <li><a href="create_grade.php">+ Give Grade</a></li>
	        <li><a href="logout.php">Logout</a></li>
	      </ul> 
		</td>
		<td id="page">
			<h2>Teacher Current Schedule</h2>

			<?php
			  if(date("n") >= 1 || date("n") <=5) {
			    $semester = "Spring";
			  }
			  if (date("n") >= 8 || date("n") <= 12) {
			    $semester = "Fall";
			  }
			  else {
			    $semester = "Summer";
			  }
			  $teacher_id = $_SESSION['sess_user_id'];
			  $query = "SELECT c_name, c_id, t_start, t_end, t_room, t_day, t_starttime, t_endtime from teachers, teach, courses where tr_id = t_teacherid and t_courseid = c_id and tr_id = '$teacher_id' and t_semester = '$semester' and year(t_start) = YEAR(CURDATE())"; 
			  $result = mysql_query($query) or die('Error, query failed');

				if(mysql_num_rows($result) == 0)
				{
				echo "You are not teaching any class this semester<br>";
				} 
				else 
				{
					echo "<table border='1'>
					<tr>
						<th>Course Name</th>
						<th>Start Day</th>
						<th>End Day</th>
						<th>Room Number</th>
						<th>Day</th>
						<th>Start Time</th>
						<th>End Time</th>
					</tr>";
					while ($row =  mysql_fetch_array($result)) {
						echo "<tr>";
						echo "<td>" . $row['c_name'] . "</td>";
						echo "<td>" . $row['t_start'] . "</td>";
						echo "<td>" . $row['t_end'] . "</td>";
						echo "<td>" . $row['t_room'] . "</td>";
						echo "<td>" . $row['t_day'] . "</td>";
						echo "<td>" . $row['t_starttime'] . "</td>";
						echo "<td>" . $row['t_endtime'] . "</td>";
						echo "</tr>";
					}
				  	echo "</table>";
				}
			?>
			
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>
