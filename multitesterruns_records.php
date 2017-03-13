<?php
/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($device ='', $product ='', $lot ='', $desc ='', $error = '')
{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<link rel="stylesheet" href="css/normalize.css" />
		<title>
			<?php if (isset($_GET['runid'])) {
						$runid = $_GET['runid'];
					} ?>
			<?php if ($runid != '') { echo "Edit Record"; } else { echo "New Record"; } ?>
		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<?php include 'header.php';?>
		<h1><?php if ($runid != '') { echo "Edit Record"; } else { echo "New Record"; } ?></h1>
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

			<strong>device: *</strong> <input type="text" name="device"
			value="<?php echo $device; ?>"/><br/>
			<strong>product: *</strong> <input type="text" name="product"
			value="<?php echo $product; ?>"/><br/>
			<strong>lot: </strong> <input type="text" name="lot"
			value="<?php echo $lot; ?>"/><br/>
			<strong>description: </strong> <input type="text" name="desc"
			value="<?php echo $desc; ?>"/>
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
		$runid = $_POST['runid'];
		$device = htmlentities($_POST['device'], ENT_QUOTES);
		$product = htmlentities($_POST['product'], ENT_QUOTES);
		$lot = htmlentities($_POST['lot'], ENT_QUOTES);
		$desc = htmlentities($_POST['desc'], ENT_QUOTES);

		// check that firstname and lastname are both not empty
		if ($product == '' || $device == '')
		{
			// if they are empty, show an error message and display the form
			$error = 'ERROR: Please fill in all required fields!';
			renderForm($device, $product, $lot, $desc, $error);
		}
		else
		{
			// if everything is fine, update the record in the database
			if ($stmt = $mysqli->prepare("UPDATE multitester_runs SET device = ?, product = ?, lot = ?, description = ? WHERE runid=? "))
			{
				$stmt->bind_param("sssss", $device, $product, $lot, $desc, $runid);
				$stmt->execute();
				$stmt->close();
			}
			// show an error message if the query has an error
			else
			{
				echo "ERROR: could not prepare SQL statement.";
			}

			// redirect the user once the form is updated
			header("Location: multitesterruns_view.php");
		}

	}
	// if the form hasn't been submitted yet, get the info from the database and show the form
	else
	{
		// get 'id' from URL
		$runid = $_GET['runid'];

		// get the recod from the database
		if($stmt = $mysqli->prepare("SELECT runid,device,product,lot,description FROM multitester_runs WHERE runid=?"))
		{
			$stmt->bind_param("s", $runid);
			$stmt->execute();

			$stmt->bind_result($runid, $device, $product, $lot, $desc);
			$stmt->fetch();

			// show the form
			renderForm($device, $product, $lot, $desc);

			$stmt->close();
		}
		// show an error if the query has an error
		else
		{
			echo "Error: could not prepare SQL statement";
		}
	}
}



/*

NEW RECORD

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else
{
	// if the form's submit button is clicked, we need to process the form
	if (isset($_POST['submit']))
	{
		// get the form data
		$device = htmlentities($_POST['device'], ENT_QUOTES);
		$product = htmlentities($_POST['product'], ENT_QUOTES);
		$lot = htmlentities($_POST['lot'], ENT_QUOTES);
		$desc = htmlentities($_POST['desc'], ENT_QUOTES);

		// check that firstname and lastname are both not empty
		if ($product == '' || $device == '' )
		{
			// if they are empty, show an error message and display the form
			$error = 'ERROR: Please fill in all required fields!';
			renderForm($device, $product, $lot, $desc, $error);
		}
		else
		{
			// insert the new record into the database
			if ($stmt = $mysqli->prepare("INSERT INTO multitester_runs (device,product,lot,description) VALUES (?,?,?,?)"))
			{
				$stmt->bind_param("ssss", $device, $product, $lot, $desc);
				$stmt->execute();
				$stmt->close();
			}
			// show an error if the query has an error
			else
			{
				echo "ERROR: Could not prepare SQL statement.";
			}
			$query="SET @firstTargets = 10000;
				SET @runid = (SELECT MAX(runid) FROM multitester_runs);
				SET @device = (SELECT device FROM multitester_runs WHERE runid = @runid);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,1,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,2,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,3,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,4,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,5,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,6,@firstTargets);
				INSERT INTO multitester_targetCycles (runid,device,thermostat,targetcycles) VALUES (@runid,@device,7,@firstTargets);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,1,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,2,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,3,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,4,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,5,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,6,0);
				INSERT INTO multitester_reachedCycles (runid,device,thermostat,reachedcycles) VALUES (@runid,@device,7,0);";

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

			// redirect the user
			header("Location: multitesterruns_view.php");
		}
	}
	// if the form hasn't been submitted yet, show the form
	else
	{
		renderForm();
	}
}

// close the mysqli connection
$mysqli->close();
?>
