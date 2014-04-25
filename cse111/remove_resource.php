<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php
  session_start();

  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: login_page_staff.php");
    exit();
  }

$teacher_id = $_SESSION['sess_user_id'];
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
        <li><a href="delete_resource.php"><b><u>- Delete Resources</u></b></a></li>
        <li><a href="create_grade.php">+ Give Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul> 
    </td>
    <td id="page">

<!--The form for adding resources to a class-->

<h2>Uploaded Resources</h2>
<p>Click on the resource that you want to delete!</p>

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
  $query = "SELECT r_id, r_name FROM resources, coursers, courses, teach, teachers WHERE tr_id = '$teacher_id' AND tr_id = t_teacherid AND t_semester = '$semester' AND YEAR(t_start) = YEAR(NOW()) AND c_id = '$id' AND c_id = t_courseid AND c_id = cr_courseid AND cr_resourceid = r_id";
  $result = mysql_query($query) or die('Error, query failed');
  if(mysql_num_rows($result) == 0)
  {
    echo "There is no resources in your class.<br>";
  } 
  else
  {
    while(list($id2, $name) = mysql_fetch_array($result))
    {
      ?>
      <a href="remove_resource.php?id2=<?php echo urlencode($id2);?>"
      ><?php echo urlencode($name);?></a> <br>
      <?php 
    }
  }
}
?>


<?php
//Download the file
if(isset($_GET['id2'])) 
{
// if id is set then get the file with the id from database
$con = mysql_connect('localhost', 'root', 'bluemix123') or die(mysql_error());
$db = mysql_select_db('cse111', $con);
$id2    = $_GET['id2'];

$query = "DELETE FROM resources WHERE r_id = '$id2'";
$result = mysql_query($query) or die('Error, query failed');
echo "resource has been deleted" . "<br>";
}
?>

<a href="staff.php">Cancel</a><br>

    </td>
  </tr>
</table>



<?php include("includes/footer.php"); ?>