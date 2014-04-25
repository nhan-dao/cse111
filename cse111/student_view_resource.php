<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php
  session_start();

  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: login_page_staff.php");
    exit();
  }

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
        <li><a href="student_view_resource.php"><u><b>View Resource</u></b></a></li>
        <li><a href="student_view_grade.php">View Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Choose the course that you want to view resource</h2>
      
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
        $s_id = $_SESSION['sess_user_id'];
        $query = "SELECT c_name, c_id 
        FROM teach, courses, enroll
        WHERE c_id = t_courseid AND year(t_start) = YEAR(CURDATE()) AND t_semester = '$semester' AND e_teachid = t_id AND e_studentid = '$s_id'"; 
        $result = mysql_query($query) or die('Error, query failed');

        if(mysql_num_rows($result) == 0)
        {
        echo "You are not taking any class this semester<br>";
        } 
        else 
        {
          while(list($course, $c_id) = mysql_fetch_array($result))
          {
          ?>
          <a href="student_resource.php?id=<?php echo urlencode($c_id);?>"
          ><?php echo ($course);?></a> <br>
          <?php 
          }
        }
      ?>

    </td>
  </tr>
</table>


<?php include("includes/footer.php"); ?>
