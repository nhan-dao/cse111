<?php $page_header = "CROPS - Staff Area"; ?>
<?php include("includes/header.php"); ?>

<?php
	session_start();

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || ($_SESSION['sess_flag'] != 1) || !isset($_SESSION['sess_flag']) ) {
		header("location: login_page_staff.php");
		exit();
	}

?>

<table id="structure">
	<tr>
		<td id="navigation">
      <ul>
        <li><a href="staff.php"><b><u>Home</u></b></a><li>
        <li><a href="teacher_schedule.php">Schedule</a></li>
        <li><a href="create_assignment.php">+ Add Assignment</a></li>
        <li><a href="delete_assignment.php">- Delete Assignment</a></li>
        <li><a href="create_resource.php">+ Add Resources</a></li>
        <li><a href="delete_resource.php">- Delete Resources</a></li>
        <li><a href="create_grade.php">+ Give Grade</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul> 
		</td>
		<td id="page">
			<h2>Staff Menu</h2>
			<p>Welcome, <?php echo $_SESSION["sess_username"] ?></p>
			<p>To add resources use the menu on the left hand side!</p>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>