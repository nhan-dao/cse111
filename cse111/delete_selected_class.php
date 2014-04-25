<?php require_once("includes/connection.php"); ?>
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
        <li><a href="delete_enroll_class.php"><u><b>- Delete Class</u></b></a></li>    
        <li><a href="student_schedule.php">Schedule</a></li>
        <li><a href="student_view_assignment.php">View Assignment</a></li>
        <li><a href="student_view_resource.php">View Resource</a></li>
        <li><a href="student_view_grade.php">View Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </td>
    <td id="page">
        <h2>Welcome to CROPS</h2>
                 

        <?php
          $s_id = $_SESSION['sess_user_id'];

          if(empty($_POST['formDoor'])) 
          {
            echo("You didn't select any Class. Please go back and select a class.");
          } 
          else
          {
            $aDoor = $_POST['formDoor'];
            $N = count($aDoor);
         
            for($i=0; $i < $N; $i++)
            {
              $t_id = $aDoor[$i];

              $query = "Delete FROM enroll WHERE e_teachid = '$t_id' AND e_studentid = '$s_id'";
              $result = mysql_query($query) or die('Error, query failed');
              $query = "SELECT distinct(t_teacherid) FROM teach WHERE t_id = '$t_id'";
              $result = mysql_result(mysql_query($query), 0);
              $query = "DELETE FROM classin WHERE ci_studentid = '$s_id' AND ci_teacherid = '$result'";
              mysql_query($query);
            }
               echo "Successfully deleted the class";
          }
        ?>

    </td>
  </tr>
</table>


<?php require("includes/footer.php"); ?>