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
        <li><a href="staff.php">Home</a><li>
        <li><a href="current_offer_classes.php"><b><u>+ Add Class</u></b></a></li>
        <li><a href="delete_enroll_class.php">- Delete Class</a></li>
        <li><a href="student_schedule.php">Schedule</a></li>
        <li><a href="add_assignment.php">View Assignments</a></li>
        <li><a href="add_assignment.php">View Resources</a></li>
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
              //echo("this is t-id" . $aDoor[$i] . "<br> ");
              $query = "SELECT t_courseid FROM teach WHERE t_id = '$t_id'";
              $c_courseid = mysql_result(mysql_query($query), 0);
              //echo "course id " . $c_courseid . "<br>";
              $query = "SELECT e_courseid, e_teachid, c_name FROM courses, enroll, students WHERE e_courseid = c_id AND s_id = '$s_id' AND s_id = e_studentid";
              $result = mysql_query($query) or die('Error, query failed');
              $flag = 0;
              while($row = mysql_fetch_array($result))
              {
                //echo "this is e_teachid: " .$row['e_teachid'] . "<br>";
                //echo "this is e_courseid: " . $row['e_courseid'] . "<br>";
                if($row['e_teachid'] == $t_id) 
                {
                  echo "You had already sign up for " .$row['c_name'] . "<br>";
                  $flag = 1;
                }
                else if($row['e_teachid'] != $t_id && $row['e_courseid'] == $c_courseid) 
                {
                  echo "You had already taken " . $row['c_name'] . "<br>";
                  $flag = 1;
                }
                //echo "flag is " . $flag . "<br>";
              }

                if($flag == 0)
                {
                  //echo "course id " . $c_courseid . "<br>";
                  $query = "INSERT INTO enroll VALUES ('$s_id', '$c_courseid', '$t_id')";
                  mysql_query($query) or die('Error, query failed');
                  echo "Successful sign up for class id: " . $c_courseid . "<br>";
                  $query = "SELECT distinct(t_teacherid) FROM teach WHERE t_id = '$t_id'";
                  $result = mysql_result(mysql_query($query), 0);
                  //echo $result;
                  $query = "INSERT INTO classin VALUES ('$s_id', '$result')";
                  mysql_query($query); 
                }
            }
          }
        ?>

    </td>
  </tr>
</table>


<?php require("includes/footer.php"); ?>