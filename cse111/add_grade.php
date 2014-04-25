<?php $page_header = "CROPS - Staff Area";?>
<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php
  session_start();

  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: login_page_staff.php");
    exit();
  }
  $tr_id = $_SESSION['sess_user_id'];

?>

<table id="structure">
  <tr>
    <td id="navigation">
      <ul>
        <li><a href="staff.php">Home</a><li>
        <li><a href="teacher_schedule.php">Schedule</a></li>
        <li><a href="create_assignment.php">+ Add Assignment</a></li>
        <li><a href="delete_assignment.php">- Delete Assignment</a></li>
        <li><a href="create_resource.php">+ Add Resources</a></li>
        <li><a href="delete_resource.php">- Delete Resources</a></li>
        <li><a href="create_grade.php"><b><u>+ Give Grade</u></b></a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Choose the assingment that you want to give grade to</h2>


<?php
//For showing already uploaded resource in the class. 

  if(date("n") >= 1 || date("n") <=5) {
          $semester = "Spring";
        }
        if (date("n") >= 8 || date("n") <= 12) {
          $semester = "Fall";
        }
        else {
          $semester = "Summer";
        }

if(isset($_GET['id'])) {
  $id    = $_GET['id'];
  $query = "SELECT a_id, a_name
  FROM assignments, give, teachers, teach, courses
  WHERE c_id = '$id' AND c_id = t_courseid AND t_semester = '$semester' AND year(t_start) = year(now()) AND t_teacherid = tr_id and tr_id = g_teacherid AND g_assignid = a_id";
  $result = mysql_query($query) or die('Error, query failed');
  if(mysql_num_rows($result) == 0)
  {
    echo "There is no assignment in your class.<br>";
  } 
  else
  {
    while(list($id2, $name) = mysql_fetch_array($result))
    {
      ?>
      <a href="give_grade.php?id2=<?php echo urlencode($id2);?>"
      ><?php echo urlencode($name);?></a> <br>
      <?php 
    }
  }
}
?>
    </td>
  </tr>
</table>


<?php include("includes/footer.php"); ?>