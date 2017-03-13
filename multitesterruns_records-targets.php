<?php
/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

if (isset($_GET['runid'])) {
	$runid = $_GET['runid'];
}

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($T1 ='', $T2 ='',$T3 ='',$T4 ='',$T5 ='',$T6 ='',$T7 ='', $error = '')
{ ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<link rel="stylesheet" href="css/normalize.css" />
		<title>Edit Record</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<?php include 'header.php';?>
		<h1>Edit Record</h1>
		<?php if ($error != '') {
		echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
		. "</div>";
		} ?>

		<form action="" method="post">
			<div>
			<?php if ($runid != '') { ?>
			<input type="hidden" name="runid" value="<?php echo $runid; ?>" />
			<p>ID: <?php echo $runid; ?></p>
			<?php } ?>

			<strong>T1: *</strong> <input type="text" name="T1"
			value="<?php echo $T1; ?>"/><br/>
			<strong>T2: *</strong> <input type="text" name="T2"
			value="<?php echo $T2; ?>"/><br/>
			<strong>T3: *</strong> <input type="text" name="T3"
			value="<?php echo $T3; ?>"/><br/>
			<strong>T4: *</strong> <input type="text" name="T4"
			value="<?php echo $T4; ?>"/><br/>
			<strong>T5: *</strong> <input type="text" name="T5"
			value="<?php echo $T5; ?>"/><br/>
			<strong>T6: *</strong> <input type="text" name="T6"
			value="<?php echo $T6; ?>"/><br/>
			<strong>T7: *</strong> <input type="text" name="T7"
			value="<?php echo $T7; ?>"/>
			<p>* required</p>
			<input type="submit" name="submit" value="Submit" />
			</div>
		</form>
	</body>
</html>

<?php }



/*

EDIT RECORD

*/
// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['runid']))
{
	// if the form's submit button is clicked, we need to process the form
	if (isset($_POST['submit']))
	{
		// get variables from the URL/form
		//$runid = $_POST['runid'];
		$T1 = htmlentities($_POST['T1'], ENT_QUOTES);
		$T2 = htmlentities($_POST['T2'], ENT_QUOTES);
		$T3 = htmlentities($_POST['T3'], ENT_QUOTES);
		$T4 = htmlentities($_POST['T4'], ENT_QUOTES);
		$T5 = htmlentities($_POST['T5'], ENT_QUOTES);
		$T6 = htmlentities($_POST['T6'], ENT_QUOTES);
		$T7 = htmlentities($_POST['T7'], ENT_QUOTES);

		// check that firstname and lastname are both not empty
		if ($T1 == '' || $T2 == '' || $T3 == '' || $T4 == '' || $T5 == '' || $T6 == '' || $T7 == '')
		{
			// if they are empty, show an error message and display the form
			$error = 'ERROR: Please fill in all required fields!';
			renderForm($T1 ='', $T2 ='',$T3 ='',$T4 ='',$T5 ='',$T6 ='',$T7 ='', $error);
		}
		else
		{
			// if everything is fine, update the record in the database
			$query="UPDATE multitester_targetCycles SET targetcycles = $T1 WHERE thermostat = 1 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T2 WHERE thermostat = 2 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T3 WHERE thermostat = 3 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T4 WHERE thermostat = 4 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T5 WHERE thermostat = 5 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T6 WHERE thermostat = 6 AND runid = '$runid';
				UPDATE multitester_targetCycles SET targetcycles = $T7 WHERE thermostat = 7 AND runid = '$runid';";

			if ($mysqli->multi_query($query)) {
				do {
					/* store first result set */
					if ($result = $mysqli->store_result()) {
						while ($row = $result->fetch_row()) {
							$array[$row[0]]=$row[1];
						}
						$result->free();
					}
					/* print divider */
					if ($mysqli->more_results()) {
						//printf("-----------------\n");
					}
				} while ($mysqli->next_result());
			}
			else
			{
				echo "ERROR: could not prepare SQL statement.";
				//echo $mysqli->error;
			}

			// redirect the user once the form is updated
			header("Location: multitesterruns_view-targets.php?runid=" . $runid);
		}

	}
	// if the form hasn't been submitted yet, get the info from the database and show the form
	else
	{
		// get 'id' from URL
		$runid = $_GET['runid'];

		// get the recod from the database
		if ($result = $mysqli->query("SELECT targetcycles FROM multitester_targetCycles WHERE runid = '$runid'"))
		{
			// display records if there are records to display
			if ($result->num_rows > 0)
			{
				$array = array(9);
				$i=1;
				while ($row = $result->fetch_row())
				{
					$array[$i]=$row;
					$i++;
				}

				$T1 = $array[1][0];
				$T2 = $array[2][0];
				$T3 = $array[3][0];
				$T4 = $array[4][0];
				$T5 = $array[5][0];
				$T6 = $array[6][0];
				$T7 = $array[7][0];
			}

			renderForm($T1,$T2,$T3,$T4,$T5,$T6,$T7);
		}
		// show an error if the query has an error
		else
		{
			echo "Error: could not prepare SQL statement";
		}
	}
}

// close the mysqli connection
$mysqli->close();
?>
