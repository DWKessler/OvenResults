//create a php array to represent the data that is pulled in from a remote or local DB
//<?php $array=array('1','1','0','0','1','1','0','1','1','1','1','1','0','1','1','0','0','0','0','1','0','1','1','1','0','1','0','1','1','1','1','0','0','0','1','0','1','1','1','0','1','1','1','0','0','1','0','1','1','0','0','0','1','0','0','1','0','1','1','1','0','0','1','1','0','1','1','1','0','1','1','0','1','1','1','1','0','1','0','1','1','1','0','1','1','0','0','0','0','0','0','1','1','0','0','0','0','1','1','0','1','1','0','0','1','1','1','1','0','0','0','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','1','0','1','1','0','1','0','1','0','0','1','0','0','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','0','1','0','0','1','0','0','1','0','1','0','1','0','0','0','0','1','0','0','0','0','1','1','0','0','1','0','1','0','1','1','1','1','1','1','1','0','1','0','0','1','0','1','0','0','1','1','1','0','1','1','0','1','0','0','0','1','1','0','0','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','0','0','0','1','0','1','1','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','0','0','0','1','1','1','1','1','0','0','0','1','1','0','1','0','0','0','1','1','1','1','0','0','1','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','1','1','1','0','1','1','0','1','1','1','1','0','0','0','0','0','1','1','1','0','1','1','1','1','1','1','0','1','1','0','1','1','1','0','1','1','0','1','1','0','0','1','1','1','1','1','0','1','0','0','1','0','0','0','0','0','0','0','0','0','1','0','1','1','0','1','0','0','1','0','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','1','1','1','1','1','0','1','1','1','0','0','0','1','1','0','0','1','0','1','0','1','0','1','0','1','1','1','0','0','0','0','1','1','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','0','1','1','0','1','0','0','1','1','1','1','1','1','1','0','0','1','1','1','0','0','1','1','0','0','1','0','0','0','0','0','1','1','1','0');?>
//this currently has 505 elements instead of 504

//transfer the data from php over to javascript by converting it to JSON
//var thermostatarray = <?php echo json_encode($array);?>;

var resultCount = 30;

var table = document.getElementById("OvenTable");  //retrieves the table reference via the ID

//this makes the main title row
var rowx = table.insertRow(-1);  //adds a title row
rowx.className = "titleRow";
var cellx = rowx.insertCell(-1); //adds a title cell
cellx.colSpan = "3"; //sets the span for the title to cover the whole table that will be generated
cellx.innerHTML = "Temperature Results"; //sets the title


//this makes the Block title row
rowx = table.insertRow(-1);
rowx.className = "labelRow";
for (i=0; i<4; i=i+4) {
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "Stat";
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "Off";
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "On";

 if (i!=0) {  //prevents spacers from being added after the last block
   cellx = rowx.insertCell(-1);
   cellx.innerHTML = "<b>&#9940;</b>";
   cellx.style.backgroundColor = "black";
 }
}

var titlerows = table.rows.length - 1; //check how many title rows were made

//this makes cells for results
for (j=1; j<=resultCount; j++) { //creates result rows until all of the result set has been run through
    //inserts a new row for the next thermostat
    rowx = table.insertRow(-1);
    rowx.className = "dataRow";
    cellx1 = rowx.insertCell(-1); //adds a new cell in the rightmost position
    cellx1.innerHTML = j;

    var offcheck;
    var oncheck;

    cellx = rowx.insertCell(-1);
    cellx.innerHTML = Number(Math.random().toFixed(2))*5+78;


    //highlight the temperature result  based on whether it is in or out of spec
    if (cellx.innerHTML > 80.0 && cellx.innerHTML < 90.0) {
      cellx.style.backgroundColor = "green";
      offcheck = 1;
    }
    else {
      cellx.style.backgroundColor = "yellow";
      offcheck = 0;
    }

    cellx = rowx.insertCell(-1);
    cellx.innerHTML = Number(Math.random().toFixed(2))*5+68;

    //highlight the temperature result  based on whether it is in or out of spec
    if (cellx.innerHTML > 70.0 && cellx.innerHTML < 80.0) {
      cellx.style.backgroundColor = "green";
      oncheck = 1;
    }
    else {
      cellx.style.backgroundColor = "yellow";
      oncheck = 0;
    }

    //highlight the thermostat number based on whether off/on are in spec or out of spec
    if (offcheck == 1 && oncheck == 1) {
      cellx1.style.backgroundColor = "blue";
    }
    else cellx1.style.backgroundColor = "red";


}

var rowCount = table.rows.length;
var lastRow = table.rows[rowCount-1];
lastRow.className = "lastRow";
lastRow.cells[0].style.backgroundColor = "purple";
lastRow.cells[1].style.backgroundColor = "purple";
lastRow.cells[2].style.backgroundColor = "purple";


var rowCount = $('#OvenTable >tbody >tr').length;

//$(".titleRow").clone().appendTo($("table"));
//$(".labelRow").clone().appendTo($("table"));

$("tr").eq( 2 ).css( "backgroundColor = red" );



var copyLabelRow = $(".labelRow").eq(0) ; //finds the first instance of a row with the labelRow class, this prevents the subsequent cloning from
var copyTitleRow = $(".titleRow").eq(0);

//var targetRow = $("tr").eq(2);
//$(copyLabelRow).clone().insertAfter(targetRow);



for (j=2; j<=resultCount; j=j+5) { //creates result rows until all of the result set has been run through
  var targetRow = $("tr").eq(j);
  //$(".labelRow").clone().insertAfter(targetRow);
  $(copyLabelRow).clone().insertAfter(targetRow);
}
