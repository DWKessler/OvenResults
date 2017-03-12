<!DOCTYPE html>
<?php
  /*
  Script  : PHP-JSON-MySQLi-GoogleChart
  Author  : Enam Hossain
  version : 1.0
  (modified)
  */

  include('connect-db.php');

  //these variables define the acceptable limits of contact pressure on the chart
  $LSL = 55;
  $USL = 70;

  //check whether a specific number of datapoints has been requested in the URL
  if (isset($_GET['qty'])) {
      $limitqty = $_GET['qty'];
  }else{
      $limitqty = 500;  //set it to 500 if nothing is specified
  }

	$timerange = array(9);  //empty array variable to hold incoming SQL data

  //this query
	$query = "SELECT max(timestamp),min(timestamp) FROM (
	SELECT * FROM (SELECT timestamp,station1,station3,adjustedlow1,adjustedlow2 FROM bucp WHERE station1 > 0 AND station3 > 20 ORDER BY timestamp DESC LIMIT $limitqty)a
	UNION ALL
	SELECT * FROM (SELECT timestamp,station2,station4,adjustedlow1,adjustedlow2 FROM bucp WHERE station2 > 0 AND station4 > 20 ORDER BY timestamp DESC LIMIT $limitqty)b)c
	ORDER BY timestamp;";

	$result = $mysqli->query($query);

	if($result === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}
	$result->data_seek(0);

		while ($row = mysqli_fetch_row($result)) {
			$timerange[0]=$row[0];
			$timerange[1]=$row[1];
		}



	$result->free();





  $result = $mysqli->query("SELECT timestamp AS timelimits,
  (SELECT station1 FROM bucp WHERE station1 > 0 AND station3 > 20 AND bucp.timestamp=timelimits) AS station1start,
  (SELECT station2 FROM bucp WHERE station2 > 0 AND station4 > 20 AND bucp.timestamp=timelimits) AS station2start,

  (SELECT station3 FROM bucp WHERE (station1segment = 1 OR station3segment = 1) AND bucp.timestamp=timelimits) AS station3endgood,
  (SELECT station3 FROM bucp WHERE adjustedlow1 = 1 AND bucp.timestamp=timelimits) AS station3adjlow,
  (SELECT station3 FROM bucp WHERE station1 > 0 AND station1segment < 1 AND station3segment < 1 AND bucp.timestamp=timelimits) AS station3startlow,
  (SELECT station3 FROM bucp WHERE (station3segment > 1) AND bucp.timestamp=timelimits) AS station3endhigh,

  (SELECT station4 FROM bucp WHERE (station2segment = 1 OR station4segment = 1) AND bucp.timestamp=timelimits) AS station4endgood,
  (SELECT station4 FROM bucp WHERE adjustedlow2 = 1 AND bucp.timestamp=timelimits) AS station4adjlow,
  (SELECT station4 FROM bucp WHERE station2 > 0 AND station2segment < 1 AND station4segment < 1 AND bucp.timestamp=timelimits) AS station4startlow,
  (SELECT station4 FROM bucp WHERE (station4segment > 1) AND bucp.timestamp=timelimits) AS station4endhigh,

  adjustedlow1,adjustedlow2

	FROM bucp
	WHERE timestamp>=$timerange[1] AND timestamp<=$timerange[0];");

  $rows = array();
  $table = array();
  $table['cols'] = array(
    // Labels for your chart, these represent the column titles.
  array('label' => 'Time', 'type' => 'number'),
  array('label' => 'Station1 (Before Adjustment)', 'type' => 'number'),
	array('label' => 'Station2 (Before Adjustment)', 'type' => 'number'),
	array('label' => 'Station3 (End Good)', 'type' => 'number'),
	array('label' => 'Station3 (Adjusted Low)', 'type' => 'number'),
	array('label' => 'Station3 (Started Low)', 'type' => 'number'),
	array('label' => 'Station3 (Ended High)', 'type' => 'number'),
	array('label' => 'Station4 (End Good)', 'type' => 'number'),
	array('label' => 'Station4 (Adjusted Low)', 'type' => 'number'),
	array('label' => 'Station4 (Started Low)', 'type' => 'number'),
	array('label' => 'Station4 (Ended High)', 'type' => 'number'),
	array('label' => 'LSL', 'type' => 'number'),
	array('label' => 'USL', 'type' => 'number')
  );

  /* Extract the information from $result */
  foreach($result as $r) {
      $temp = array();
      $temp[] = array('v' => (int) $r['timelimits']);
      $temp[] = array('v' => (float) $r['station1start']);
  	  $temp[] = array('v' => (float) $r['station2start']);
  	  $temp[] = array('v' => (float) $r['station3endgood']);
  	  $temp[] = array('v' => (float) $r['station3adjlow']);
  	  $temp[] = array('v' => (float) $r['station3startlow']);
  	  $temp[] = array('v' => (float) $r['station3endhigh']);
  	  $temp[] = array('v' => (float) $r['station4endgood']);
  	  $temp[] = array('v' => (float) $r['station4adjlow']);
  	  $temp[] = array('v' => (float) $r['station4startlow']);
  	  $temp[] = array('v' => (float) $r['station4endhigh']);
  	  $temp[] = array('v' => (float) $LSL);
  	  $temp[] = array('v' => (float) $USL);
      $rows[] = array('c' => $temp);
    }
  $table['rows'] = $rows;
  // convert data into JSON format
  $jsonTable1 = json_encode($table);
  //echo $jsonTable;



  $result->free();


  $result = $mysqli->query("SELECT timestamp,statscrap,adjustmentdial,statrate/100 FROM bucp WHERE station1 > 0 AND station3 > 20 AND timestamp<$timerange[0] AND timestamp>$timerange[1] ORDER BY timestamp DESC;");

  $rows = array();
  $table = array();
  $table['cols'] = array(
    // Labels for your chart, these represent the column titles.
    array('label' => 'Time', 'type' => 'number'),
  	array('label' => 'Scrap', 'type' => 'number'),
  	array('label' => 'DialSetting', 'type' => 'number'),
  	array('label' => 'Rate', 'type' => 'number')
  );

    /* Extract the information from $result */
  foreach($result as $r) {
    $temp = array();
    // The following line will be used to slice the Pie chart
    $temp[] = array('v' => (int) $r['timestamp']);
    // Values of the each slice
	  $temp[] = array('v' => (float) $r['statscrap']);
	  $temp[] = array('v' => (int) $r['adjustmentdial']);
	  $temp[] = array('v' => (float) $r['statrate/100']);
      $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  // convert data into JSON format
  $jsonTable2 = json_encode($table);
  //echo $jsonTable;


  $result->free();
  $array = array(9);

  $query = "SELECT station12delta,station34delta,station12count,station34count FROM bucp ORDER BY timestamp DESC LIMIT 1;";

  $result = $mysqli->query($query);

  if($result === false) {
    trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
  }
  $result->data_seek(0);

      while ($row = mysqli_fetch_row($result)) {
  		$array[0]=$row[0];
  		$array[1]=$row[1];
  		$array[2]=$row[2];
  		$array[3]=$row[3];
      }

  $result->free();
  $mysqli->close();
?>



<html>
  <head>
	<title>Base Unit CP Chart</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/stat.css">

	<style>
		html {
			background-color: #fff;
			}
		body div{
			background-color: #fff;
			}
	</style>
  <?php include 'header.php';?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<!--   <script type="text/javascript" src="gstatic/loader.js"></script>       -->


    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
		var data = new google.visualization.DataTable(<?=$jsonTable1?>);
    console.log(JSON.stringify(<?=$jsonTable1?>));
		var view = new google.visualization.DataView(data);
		view.setColumns([{
			type: 'date',
			label: data.getColumnLabel(0),
			calc: function (dt, row) {
				var timestamp = dt.getValue(row, 0) * 1000; // convert to milliseconds
				return new Date(timestamp);
			}
		}, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);


      var options = {
        title: 'Base Unit CP Adjustment Track',
		    titlePosition: 'in',
		    //hAxis: {title: 'Timestamp (Unix Seconds)'},
        vAxis: {title: 'Contact Pressure (grams)', min: 30},
		    vAxis: {
					viewWindowMode:'explicit',
					viewWindow: {
					max:150,
					min:50
					}
				},
          //legend: 'bottom',
		  legend: {position: 'in', textStyle: {bold: true}},
		  chartArea:{top:10,width:'90%',bottom:30},
		  trendlines: {
			10: {
				type: 'linear',
				color: 'black',
				lineWidth: 5,
				opacity: 1,
				showR2: false,
				visibleInLegend: true,
				labelInLegend: 'LSL'
				},
			11: {
				type: 'linear',
				color: 'black',
				lineWidth: 5,
				opacity: 1,
				showR2: false,
				visibleInLegend: true,
				labelInLegend: 'USL'
				}
			},
			series: {
				0:{color: '#33ccff', pointShape: 'square'},  //station 1
				1:{color: '#33ccff', pointShape: 'diamond'}, //station 2
				2:{color: 'green', pointShape: 'square'}, //station 3 good
				3:{color: 'red', pointShape: 'square', pointSize: 10}, //station 3 adjlow
				4:{color: 'orange', pointShape: 'square'}, //station 3 startlow
				5:{color: 'brown', pointShape: 'square', pointSize: 8}, //station 3 endhigh
				6:{color: 'green', pointShape: 'diamond'}, //station 4 good
				7:{color: 'red', pointShape: 'diamond', pointSize: 10}, //station 4 adjlow
				8:{color: 'orange', pointShape: 'diamond'}, //station 4 startlow
				9:{color: 'brown', pointShape: 'diamond', pointSize: 8}, //station 4 endhigh
				10:{pointsVisible: false, visibleInLegend: false},
				11:{pointsVisible: false, visibleInLegend: false}
			},
			explorer: {
				keepInBounds: true,
				maxZoomOut: 1


			}



        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div1'));

        chart.draw(view, options);
      }
    </script>


    <script type="text/javascript">
      //google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
		var data = new google.visualization.DataTable(<?=$jsonTable2?>);
    console.log(JSON.stringify(<?=$jsonTable2?>));
		var view = new google.visualization.DataView(data);
		view.setColumns([{
			type: 'date',
			label: data.getColumnLabel(0),
			calc: function (dt, row) {
				var timestamp = dt.getValue(row, 0) * 1000; // convert to milliseconds
				return new Date(timestamp);
			}
		}, 1, 2, 3]);

        var options = {
          title: 'Base Unit Statistics',
		  titlePosition: 'in',
          //hAxis: {title: 'Timestamp (Unix Seconds)'},
          vAxis: {title: '', minValue: 0},
          legend: {position: 'in', textStyle: {bold: true}},
		  chartArea:{top:10,width:'90%',bottom:30},
			explorer: {
				keepInBounds: true,
				maxZoomOut: 1
			},
			//pointSize: 7,
			series: {
				0:{labelInLegend: 'Scrap (%)', color:'red', pointShape: 'triangle'},
				1:{labelInLegend: 'DialSetting (#))', color:'blue', pointShape: 'square'},
				2:{labelInLegend: 'Production Rate (100\'s per hour)', color:'green', pointShape: 'circle'}
			}
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div2'));
        chart.draw(view, options);
      }
    </script>




  </head>

  <body>
	<section>
		<div id="chart_div1" class="ca51" style="width: 99%;"></div>
	</section>
	<section>
		<div id="chart_div2" class="ca52" style="width: 99%;"></div>
	</section>
	<section>

	<style>
	.viewtable {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
		width: 100%;
		font-size: 2vw;
		text-align: center;
		font-weight: bold;
	}
	.viewtable th {
		border:1px solid #C0C0C0;
		padding:5px;
		background:#F0F0F0;
	}
	.viewtable td {
		border:1px solid #C0C0C0;
		padding:5px;
	}
	</style>

		<table class="viewtable">
			<tbody>
				<tr>
					<td>Station 1&2 Delta: <?php echo $array[0];?> & n=<?php echo $array[2];?></td>
					<td></td>
					 <td>Station 3&4 Delta: <?php echo $array[1];?> & n=<?php echo $array[3];?></td>
				</tr>
			</tbody>
	</section>
  </body>
</html>
