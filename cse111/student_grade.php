<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php
  session_start();

  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: login_page_staff.php");
    exit();
  }

 $student_id = $_SESSION['sess_user_id'];

?>
<table id="structure">
  <tr>
    <td id="navigation">
      <ul>
        <li><a href="student.php">Home</a><li>
	    <li><a href="current_offer_classes.php">+ Add Class</a></li> 
	    <li><a href="delete_enroll_class.php">- Delete Class</a></li>       	
        <li><a href="student_schedule.php">Schedule</a></li>
        <li><a href="student_view_assignment.php">View Assignment</a></li>
        <li><a href="student_view_resource.php">View Resource</a></li>
        <li><a href="student_view_grade.php"><u><b>View Grade</u></b></a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Student Area: View Grade</h2>

<?php
 	if(isset($_GET['id']))
 	{

 		if(date("n") >= 1 || date("n") <=5) {
          $semester = "Spring";
        }
        if (date("n") >= 8 || date("n") <= 12) {
          $semester = "Fall";
        }
        else {
          $semester = "Summer";
        }

        $id = $_GET['id'];
        $query = "SELECT a_id, a_name, gb_points_received, gb_points_out_of FROM students, viewa, assignments, assignincourse, courses, teach, gradebook, graderecieved
		WHERE s_id = '$student_id' AND s_id = va_studentid AND va_assignid = a_id AND a_id = ac_assignid AND ac_courseid = c_id AND c_id = t_id 
		AND t_semester = '$semester' AND year(t_start) = year(now()) AND c_id = '$id' AND a_id = gr_assignid AND gr_gbid = gb_id";
  		$result = mysql_query($query) or die('Error, query failed');
  		echo
          "<table border = '1'> 
          <tr>
            <th>Assignment Name</th>
            <th>Point Recieve</th>
            <th>Total Point<th>
          </tr>";
          while($row = mysql_fetch_array($result))
          {
          	echo "<tr>";
          	echo "<td>" . $row['a_name'] . "</td>";
          	echo "<td>" . $row['gb_points_received'] . "</td>";
			echo "<td>" . $row['gb_points_out_of'] . "</td>";
			echo "<tr>";
          }

        echo "<tr>";
        echo "</tr>";
        echo "</table>"; 
	}

?>
    </td>
  </tr>
</table>


<?php include("includes/footer.php"); ?>