<?php $page_header = "CROPS - Staff Login";?>
<?php include("includes/header.php"); ?>

<table id="structure">
	<tr>
		<td id="navigation">
						&nbsp;
		</td>
		<td id="page">
			<h2>Welcome to CROPS</h2>
			<form id="form1" name="form1" method="post" action="login_staff.php">
			<table width="510" border="0" align="center">
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" id="username" /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password" id="password" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="button" id="button" value="Submit" /></td>
				</tr>
			</table>
			</form>

		</td>
	</tr>
</table>

<?php include("includes/footer.php"); ?>