<html>
<head>
<title>Download File From MySQL Database</title>
<meta http-equiv="Content-Type" content="text/html; 
charset=iso-8859-1">
</head>
<body>
<?php
//database connection
$con = mysql_connect('localhost', 'root', 'bluemix123') or die(mysql_error());
//select database
$db = mysql_select_db('cse111', $con);
$query = "SELECT r_id, r_name FROM resources, coursers, courses, teach, teachers WHERE tr_id = '$teacher_id' AND tr_id = t_teacherid AND t_semester = '$semester' AND YEAR(t_start) = YEAR(NOW()) AND c_id = '$id' AND c_id = t_courseid AND c_id = cr_courseid AND cr_resourceid = r_id";
$result = mysql_query($query) or die('Error, query failed');
if(mysql_num_rows($result) == 0)
{
echo "Database is empty <br>";
} 
else
{
while(list($id2, $name) = mysql_fetch_array($result))
{
?>
<a href="test.php?id2=<?php echo urlencode($id2);?>"
><?php echo ($name);?></a> <br>
<?php 
}
}
mysql_close();
?>
</body>
</html>
<?php
if(isset($_GET['id2'])) 
{
// if id is set then get the file with the id from database
$con = mysql_connect('localhost', 'root', 'bluemix123') or die(mysql_error());
$db = mysql_select_db('cse111', $con);
$id2    = $_GET['id2'];
$query = "SELECT r_name, r_type, r_size, r_content " .
         "FROM resources WHERE r_id = '$id2'";
$result = mysql_query($query) or die('Error, query failed');
list($name, $type, $size, $content) = mysql_fetch_array($result);
header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
ob_clean();
flush();
echo $content;
mysql_close();
exit;
}
?>