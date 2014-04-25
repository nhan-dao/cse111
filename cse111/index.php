<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
		</td>
		<td id="page">
				<h2>Welcome to CROPS</h2>
				 &nbsp
				<p><a href="login_page_student.php">Student Enter Here</a></p>
				Don't have an account? <a href="new_student.php">Create a Student Account</a>

				 &nbsp
				<p><a href="login_page_staff.php">Staff Enter Here</a></p>
				Don't have an account? <a href="new_staff.php">Create a Staff Account</a>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>