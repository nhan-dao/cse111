<?php require_once("includes/connection.php"); ?>

<?php
  session_start();

	if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '') || ($_SESSION['sess_flag'] != 1) || !isset($_SESSION['sess_flag']) ) {
		header("location: login_page_staff.php");
		exit();
	}
  $tr_id = $_SESSION['sess_user_id'];
?>

<?php

    	$aGrade = $_POST['recieve'];
    	$studentID = $_POST['studentID'];
    	$aTotal = $_POST['total'];
    	$assignID = $_POST['assignID'];
    	$N = count($aGrade);
    	echo $assignID . "<br>";
    	for($i = 0; $i <$N; $i++)
    	{
    		echo $aGrade[$i] . "<br>";
    		echo $aTotal[$i] . "<br>";
    		echo $studentID[$i] . "<br>";
    		$grade = $aGrade[$i];
    		$total = $aTotal[$i];
    		$s_id = $studentID[$i];
    		$query1 = "SELECT gb_id, gb_points_received, gb_points_out_of FROM gradebook, viewgb, graderecieved WHERE vgb_gbid = gb_id AND 
    		vgb_studentid = '$s_id' AND gb_id = gr_gbid AND gr_assignid = '$assignID'";
    		$result = mysql_query($query1) or die('Error100, query failed');
    		if(mysql_num_rows($result) == 0)
    		{
    			$query2 = "INSERT INTO gradebook (gb_points_received,gb_points_out_of) VALUES ('$grade','$total')";
    			$result2 = mysql_query($query2) or die('Error, query failed');
    			$gbID = mysql_result(mysql_query("SELECT MAX(gb_id) AS gb_id FROM gradebook"), 0);
    			echo "gbID " . $gbID . "<br>";
    			$query2 = "INSERT INTO graderecieved VALUES ('$assignID','$gbID')"; 
    			mysql_query($query2) or die('Error3, query failed'); 
    			$query2 = "INSERT INTO viewgb VALUES ('$s_id', '$gbID')";
    			mysql_query($query2) or die('Error4, query failed'); 
    			$query2 = "INSERT INTO gradegiven VALUES ('$gbID','$tr_id')";
    			mysql_query($query2) or die('Error5, query failed'); 
    			header('Location: create_grade.php');
    		}
    		else
    		{
    			while($row = mysql_fetch_array($result))
    			{
    				if($row['gb_points_received'] != $grade || $row['gb_points_out_of'] != $total)
    				{
    					$gb_id = $row['gb_id'] . "<br>";
    					echo "this is the real grade ".$grade;
    					$query2 = "UPDATE gradebook SET gb_points_received = '$grade', gb_points_out_of = '$total' WHERE 
    					gb_id = '$gb_id'";
    					mysql_query($query2) or die('Error5, query failed'); 
    					header('Location: create_grade.php');
    				}
    			}
    		}


    	}

    	//$query = "UPDATE gradebook SET WHERE"
    
?>