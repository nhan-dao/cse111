<?php require_once("includes/connection.php"); ?>

<?php
/*This is to check the new_staff.php which is the form that the teachers need to input information in*/
//retrieve our data from POST
$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$name = $_POST['name'];
 
if($password1 != $password2)
    header('Location: new_staff.php');
 
if(strlen($username) > 30)
    header('Location: new_staff.php');

$hash = hash('sha256', $password1);
 
function createSalt()
{
    $text = md5(uniqid(rand(), true));
    return substr($text, 0, 3);
}
 
$salt = createSalt();
$password = hash('sha256', $salt . $hash);
 
//sanitize username
$username = mysql_real_escape_string($username);
 
$query = "INSERT INTO teachers (tr_username, tr_password, tr_email, tr_salt, tr_name)
        VALUES ( '$username', '$password', '$email', '$salt', '$name');";
mysql_query($query);
 
mysql_close();
 
header('Location: login_page_staff.php');
?>