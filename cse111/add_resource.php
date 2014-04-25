<?php $page_header = "CROPS - Staff Area";?>
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
      <ul>
        <li><a href="staff.php">Home</a><li>
        <li><a href="teacher_schedule.php">Schedule</a></li>
        <li><a href="create_assignment.php">+ Add Assignment</a></li>
        <li><a href="delete_assignment.php">- Delete Assignment</a></li>
        <li><a href="create_resource.php"><b><u>+ Add Resources</u></b></a></li>
        <li><a href="delete_resource.php">- Delete Resources</a></li>
        <li><a href="create_grade.php">+ Give Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
      <h2>Staff Area: Upload New Resources</h2>
      <p>Welcome to the staff area!</p>

<!--The form for adding resources to a class-->
<form method="post" enctype="multipart/form-data">
  <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
    <tr>
      <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
        <input name="userfile" type="file" id="userfile"> 
      </td>
      <td width="80"><input name="upload"type="submit" class="box" id="upload" value=" Upload "></td>
    </tr>
  </table>
</form>
<a href="staff.php">Cancel</a><br>


<?php
  if(isset($_POST['upload'])&&$_FILES['userfile']['size']>0)
  {
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    $fileType=(get_magic_quotes_gpc()==0 ? mysql_real_escape_string(
    $_FILES['userfile']['type']) : mysql_real_escape_string(
    stripslashes ($_FILES['userfile'])));
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    if(!get_magic_quotes_gpc())
    {
        $fileName = addslashes($fileName);
    }
    if($db_select){
      $query = "INSERT INTO resources (r_name, r_size, r_type, r_content ) ".
      "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
      mysql_query($query) or die('Error1, query failed'); 
      echo "<br>File $fileName had been uploaded<br>";

  

      $highest_id = mysql_result(mysql_query("SELECT MAX(r_id) AS r_id FROM resources"), 0);

      $query3 = "INSERT INTO upload VALUES ('$teacher_id','$highest_id')";
      mysql_query($query3) or die('Error2, query failed'); 


      $query = "SELECT s_id FROM students, classin, teachers, upload, resources WHERE s_id = ci_studentid 
      AND ci_teacherid = tr_id AND tr_id = u_teachid AND u_resourceid = r_id AND r_id = '$highest_id'";
      $result = mysql_query($query) or die('Error3, query failed');
      while ($row = mysql_fetch_array($result)) 
      {
        $s_id = $row['s_id'];
        $query = "INSERT INTO viewr VALUES ('$highest_id', '$s_id')";
        mysql_query($query);
      }
      

      if(isset($_GET['id'])) {
        $id    = $_GET['id'];
        $query4 = "INSERT INTO coursers VALUES ('$id','$highest_id')";
        mysql_query($query4) or die('Error4, query failed'); 
      }
    }
    else 
    { 
      echo "file upload failed"; 
    }
  } 
?>

<h2>Uploaded Resources</h2>

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
  $result = mysql_query($query) or die('Error5, query failed');
  if(mysql_num_rows($result) == 0)
  {
    echo "There is no resources in your class.<br>";
  } 
  else
  {
    while(list($id2, $name) = mysql_fetch_array($result))
    {
      ?>
      <a href="add_resource.php?id2=<?php echo urlencode($id2);?>"
      ><?php echo urlencode($name);?></a> <br>
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
$con = mysql_connect('localhost', 'root', '') or die(mysql_error());
$db = mysql_select_db('cse111', $con);
$id2    = $_GET['id2'];
$query = "SELECT r_name, r_type, r_size, r_content " .
         "FROM resources WHERE r_id = '$id2'";
$result = mysql_query($query) or die('Error6, query failed');
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