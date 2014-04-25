<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	$page_header = "Student Registration";
?>
<?php include("includes/header.php"); ?>

<table id="structure">
	<tr>
		<td id="navigation">
						&nbsp;
		</td>
		<td id="page">
			<h2>Welcome to CROPS: New Student</h2>
			
			<form name="register" action="register_student.php" method="post">
				<table width="510" border="0">
					<tr>
						<td colspan="2"><p><strong>Registration Form</strong></p></td>
					</tr>
					<tr>
						<td>Name (Last & First Name):</td>
						<td><input type="text" name="name"/></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" maxlength="20" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password1" /></td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td><input type="password" name="password2" /></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name="email" id="email" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Register" /></td>
					</tr>
				</table>
			</form>

		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>
