<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php $page_header = "CROPS - Student Area"; ?>
<?php include("includes/header.php"); ?>

<?php
  session_start();

  //Check whether the session variable SESS_MEMBER_ID is present or not
  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: login_page_student.php");
    exit();
  }
?>

<table id="structure">
  <tr>
    <td id="navigation">
      <ul>
        <li><a href="student.php">Home</a><li>
        <li><a href="current_offer_classes.php">+ Add Class</a></li>
        <li><a href="delete_enroll_class.php"><b><u>- Delete Class</u></b></a></li>    
        <li><a href="student_schedule.php">Schedule</a></li>
        <li><a href="student_view_assignment.php">View Assignment</a></li>
        <li><a href="student_view_resource.php">View Resource</a></li>
        <li><a href="student_view_grade.php">View Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Chose The Class You Want To Delete</h2>

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
        $query = "SELECT t_semester, t_start, t_end, t_room, t_day, t_starttime, t_endtime, t_courseid, tr_name, c_name, e_teachid 
        FROM teach, teachers, courses, enroll
        WHERE c_id = t_courseid AND t_teacherid = tr_id AND year(t_start) = YEAR(CURDATE()) AND t_semester = '$semester' AND e_teachid = t_id"; 
        $result = mysql_query($query) or die('Error, query failed');

        if(mysql_num_rows($result) == 0)
        {
        echo "You are not taking any class in semester.<br>";
        } 
        else 
        {
  
          echo "<form action='delete_selected_class.php' method='post'><table border='1'>
          <tr>
            <th>Select</th>
            <th>Course Name</th>
            <th>Start Day</th>
            <th>End Day</th>
            <th>Room Number</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Teacher Name</th>
          </tr>";
          while ($row =  mysql_fetch_array($result)) {
            $name = $row['e_teachid'];
            echo "<tr>"; ?>
            <td><input type="checkbox" name="formDoor[]" value="<?php echo htmlspecialchars($name); ?>" /></td>
            <?php
            echo "<td>". $row['c_name'] . "</td>";
            echo "<td>" . $row['t_start'] . "</td>";
            echo "<td>" . $row['t_end'] . "</td>";
            echo "<td>" . $row['t_room'] . "</td>";
            echo "<td>" . $row['t_day'] . "</td>";
            echo "<td>" . $row['t_starttime'] . "</td>";
            echo "<td>" . $row['t_endtime'] . "</td>";
            echo "<td>" . $row['tr_name'] . "</td>";
            echo "</tr>";
          }
          echo "<tr>";
          echo "</tr>";
            echo "</table><input type='submit' name='fromSubmit' value='Submit'></form>"; 

        }
      ?>
      
    </td>
  </tr>
</table>
<?php require("includes/footer.php"); ?>
