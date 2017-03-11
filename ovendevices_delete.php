<?php

// connect to the database
include('connect-db.php');

// confirm that the 'id' variable has been set
if (isset($_GET['device_id']) && is_numeric($_GET['device_id']))
{
// get the 'id' variable from the URL
$device_id = $_GET['device_id'];

// delete record from database
if ($stmt = $mysqli->prepare("DELETE FROM ovenshifter_devices WHERE device_id = $device_id LIMIT 1"))
{
//stmt->bind_param("i",$device_id);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$mysqli->close();

// redirect user after delete is successful
header("Location: ovendevices_view.php");
}
else
// if the 'id' variable isn't set, redirect the user
{
header("Location: ovendevices_view.php");
}

?>
