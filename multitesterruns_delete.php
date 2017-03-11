<?php

// connect to the database
include('connect-db.php');

// confirm that the 'id' variable has been set
if (isset($_GET['runid']))
{
	// get the 'id' variable from the URL
	$runid = $_GET['runid'];

	// delete record from database
	if ($stmt = $mysqli->prepare("DELETE FROM multitester_runs WHERE runid = ? LIMIT 1"))
	{
		$stmt->bind_param("s",$runid);
		$stmt->execute();
		$stmt->close();
	}
	else
	{
		echo "ERROR: could not prepare SQL statement.";
	}
	$mysqli->close();

	// redirect user after delete is successful
	header("Location: multitesterruns_view.php");
}
else
// if the 'id' variable isn't set, redirect the user
{
	header("Location: multitesterruns_view.php");
}

?>
