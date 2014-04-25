<?php require_once("includes/connection.php"); ?>
<?php $page_header = "CROPS - Staff Area";?>
<?php include("includes/header.php"); ?>

<?php
  session_start();

  if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || ($_SESSION['sess_flag'] != 1) || !isset($_SESSION['sess_flag']) ) {
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
      <h2>Give grade to the students</h2>
      <?php
        if(isset($_GET['id2'])) {
          $id    = $_GET['id2'];
          $query = "SELECT s_id, s_name FROM students, viewa WHERE va_studentid = s_id AND va_assignid = '$id'";
          $result = mysql_query($query) or die('Error, query failed');
          ?>
          <?php echo
          " <form action='input_grade.php' method='post'><table border = '1'> 
          <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Point Recieve</th>
            <th>Total Point<th>
          </tr>";
          while($row = mysql_fetch_array($result))
          {
            $s_id = $row['s_id'];
            $query1 = "SELECT gb_points_received FROM gradebook, viewgb, graderecieved WHERE vgb_studentid = '$s_id' AND 
            vgb_gbid = gb_id AND gr_gbid = gb_id AND gr_assignid = '$id'";
            $query2 = "SELECT gb_points_out_of FROM gradebook, viewgb, graderecieved WHERE vgb_studentid = '$s_id' AND 
            vgb_gbid = gb_id AND gr_gbid = gb_id AND gr_assignid = '$id'";
            $result1 = mysql_query($query1) or die('Error, query failed');
            $result2 = mysql_query($query2) or die('Error, query failed');
            if(mysql_num_rows($result1) == 0)
            {
              echo "no grade in data yet";
              $grade = 0;
              $total = 0;
            }
            else 
            {
                $grade = mysql_result($result1, 0);
                $total = mysql_result($result2, 0);
              
            }
            $studentID = $row['s_id'];  
            echo "<tr>";
            echo "<td>" . $row['s_id'] . "</td>";
            echo "<td>" . $row['s_name'] . "</td>"; 
            //$query = "SELECT gb_id FROM gradebook WHERE"
            ?>
            <input type="hidden" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>">
            <td><input type="text" name="recieve[]" value="<?php echo htmlspecialchars($grade); ?>"/></td>
            <td><input type="text" name="total[]" value="<?php echo htmlspecialchars($total); ?>" /></td>
            <input type="hidden" name="assignID" value="<?php echo htmlspecialchars($id); ?>">
            </tr>
            <?php
          }
          echo "<tr>";
          echo "</tr>";
          echo "</table><input type='submit' name='fromSubmit' value='Submit'></form>"; 
        }
      ?>

    </td>
  </tr>
</table>


<?php include("includes/footer.php"); ?>