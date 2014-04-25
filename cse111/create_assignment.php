<?php $page_header = "CROPS - Staff Area";?>
<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php
  session_start();
  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || ($_SESSION['sess_flag'] != 1) || !isset($_SESSION['sess_flag']) ) {
    header("location: login_page_staff.php");
    exit();
  }

?>


<table id="structure">
  <tr>
    <td id="navigation">
      <ul>
        <li><a href="staff.php">Home</a><li>
        <li><a href="teacher_schedule.php">Schedule</a></li>
        <li><a href="create_assignment.php"><b><u>+ Add Assignment</u></b></a></li>
        <li><a href="delete_assignment.php">- Delete Assignment</a></li>
        <li><a href="create_resource.php">+ Add Resources</a></li>
        <li><a href="delete_resource.php">- Delete Resources</a></li>
        <li><a href="create_grade.php">+ Give Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Choose the course that you want to add resource</h2>
      
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
        $query = "SELECT c_name, c_id from teachers, teach, courses where tr_id = t_teacherid and t_courseid = c_id and tr_id = '$teacher_id' and t_semester = '$semester' and year(t_start) = YEAR(CURDATE())"; 
        $result = mysql_query($query) or die('Error, query failed');

        if(mysql_num_rows($result) == 0)
        {
        echo "You are not teaching any class this semester<br>";
        } 
        else 
        {
          while(list($course, $c_id) = mysql_fetch_array($result))
          {
          ?>
          <a href="add_assignment.php?id=<?php echo urlencode($c_id);?>"
          ><?php echo ($course);?></a> <br>
          <?php 
          }
        }
      ?>

    </td>
  </tr>
</table>


<?php include("includes/footer.php"); ?>
