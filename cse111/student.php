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
	        <li><a href="student.php"><u><b>Home</u></b></a><li>
	       	<li><a href="current_offer_classes.php">+ Add Class</a></li>
	       	<li><a href="delete_enroll_class.php">- Delete Class</a></li>
	        <li><a href="student_schedule.php">Schedule</a></li>
	        <li><a href="student_view_assignment.php">View Assignment</a></li>
	        <li><a href="student_view_resource.php">View Resource</a></li>
	        <li><a href="student_view_grade.php">View Grade</a></li>
	        <li><a href="logout.php">Logout</a></li>
	      </ul>
		</td>
		<td id="page">
			<h2>Staff Menu</h2>
			<p>Welcome, <?php echo $_SESSION["sess_username"] ?></p>
			<p>Use the left side menu to look at your classes</p>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>