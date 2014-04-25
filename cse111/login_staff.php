<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
/*this is the page that the login_page.php would go to after the teacher has fill out the information. It would check if the
there in existing user if not then it would go back to the login_page_staff.php so the user would try to sign in again.*/
ob_start();
session_start();
 
$username = $_POST['username'];
$password = $_POST['password'];

$username = mysql_real_escape_string($username);
$query = "SELECT tr_id, tr_username, tr_password, tr_salt, flag
        FROM teachers
        WHERE tr_username = '$username';";
 
$result = mysql_query($query);
 
if(mysql_num_rows($result) == 0) // User not found. So, redirect to login_form again.
{
    header('Location: login_page_staff.php');
}
 
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['tr_salt'] . hash('sha256', $password) );
 
if($hash != $userData['tr_password']) // Incorrect password. So, redirect to login_form again.
{
    header('Location: login_page_staff.php');
}else{ // Redirect to home page after successful login.
	session_regenerate_id();
	$_SESSION['sess_user_id'] = $userData['tr_id'];
	$_SESSION['sess_username'] = $userData['tr_username'];
	$_SESSION['sess_flag'] = $userData['flag'];
	session_write_close();
	header('Location: staff.php');
}
?>
<?php require("includes/footer.php"); ?>