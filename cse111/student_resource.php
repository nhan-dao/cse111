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
        <li><a href="student_view_resource.php"><u><b>View Resource</u></b></a></li>
        <li><a href="student_view_grade.php">View Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Student Area: View Resources</h2>

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
  $query = "SELECT r_id, r_name
FROM students, viewr, resources, coursers, courses, teach
WHERE s_id = ' $student_id' AND s_id = vr_studentid AND vr_resourceid AND r_id = cr_resourceid AND cr_courseid = c_id AND c_id = t_courseid AND t_semester = 'Fall' AND year(t_start) = year(now()) AND c_id = '$id'";
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
      <a href="student_resource.php?id2=<?php echo urlencode($id2);?>"
      ><?php echo ($name);?></a> <br>
      <?php 
    }
  }
}
?>
    </td>
  </tr>
</table>

<?php
//Download the file
if(isset($_GET['id2'])) 
{
// if id is set then get the file with the id from database
$con = mysql_connect('localhost', 'root', 'bluemix123') or die(mysql_error());
$db = mysql_select_db('cse111', $con);
$id2    = $_GET['id2'];
$query = "SELECT r_name, r_type, r_size, r_content " .
         "FROM resources WHERE r_id = '$id2'";
$result = mysql_query($query) or die('Error, query failed');
list($name, $type, $size, $content) = mysql_fetch_array($result);
header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
ob_clean();
flush();
echo $content;
}
?>

<?php include("includes/footer.php"); ?>