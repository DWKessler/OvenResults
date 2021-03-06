//create a php array to represent the data that is pulled in from a remote or local DB
//<?php $array=array('1','1','0','0','1','1','0','1','1','1','1','1','0','1','1','0','0','0','0','1','0','1','1','1','0','1','0','1','1','1','1','0','0','0','1','0','1','1','1','0','1','1','1','0','0','1','0','1','1','0','0','0','1','0','0','1','0','1','1','1','0','0','1','1','0','1','1','1','0','1','1','0','1','1','1','1','0','1','0','1','1','1','0','1','1','0','0','0','0','0','0','1','1','0','0','0','0','1','1','0','1','1','0','0','1','1','1','1','0','0','0','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','1','0','1','1','0','1','0','1','0','0','1','0','0','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','0','1','0','0','1','0','0','1','0','1','0','1','0','0','0','0','1','0','0','0','0','1','1','0','0','1','0','1','0','1','1','1','1','1','1','1','0','1','0','0','1','0','1','0','0','1','1','1','0','1','1','0','1','0','0','0','1','1','0','0','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','0','0','0','1','0','1','1','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','0','0','0','1','1','1','1','1','0','0','0','1','1','0','1','0','0','0','1','1','1','1','0','0','1','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','1','1','1','0','1','1','0','1','1','1','1','0','0','0','0','0','1','1','1','0','1','1','1','1','1','1','0','1','1','0','1','1','1','0','1','1','0','1','1','0','0','1','1','1','1','1','0','1','0','0','1','0','0','0','0','0','0','0','0','0','1','0','1','1','0','1','0','0','1','0','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','1','1','1','1','1','0','1','1','1','0','0','0','1','1','0','0','1','0','1','0','1','0','1','0','1','1','1','0','0','0','0','1','1','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','0','1','1','0','1','0','0','1','1','1','1','1','1','1','0','0','1','1','1','0','0','1','1','0','0','1','0','0','0','0','0','1','1','1','0');?>
//this currently has 505 elements instead of 504

//transfer the data from php over to javascript by converting it to JSON
//var thermostatarray = <?php echo json_encode($array);?>;

var resultCount = 504; //this currently statically controls the number of results that are tabulated.

var table = document.getElementById("OvenBody");  //retrieves the table reference via the ID

//this makes the main title row
var tHead = document.getElementById("OvenTable").createTHead();
var rowx = tHead.insertRow(-1);  //adds a title row
rowx.className = "titleRow";
var cellx = rowx.insertCell(-1); //adds a title cell
cellx.colSpan = "3"; //sets the span for the title to cover the whole table that will be generated
cellx.innerHTML = "Temperature Results"; //sets the title


//this makes the Block title row
rowx = tHead.insertRow(-1);
rowx.className = "labelRow";
for (i=0; i<4; i=i+4) {
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "Stat";
 cellx.className = "stat";
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "Off";
 cellx.className = "off";
 cellx = rowx.insertCell(-1);
 cellx.innerHTML = "On";
 cellx.className = "on";

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
    cellx1.className = "thermostatNumber";

    //these two variables are used to determine whether both chacteristics of the thermostat are in spec or not
    var offcheck;
    var oncheck;

    //inserts an "off" temperature results cell and generates a random number to simulate actual data
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

    //inserts an "on" temperature results cell and generates a random number to simulate actual data
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


//var rowCount = $('#OvenTable >tbody >tr').length;

//finds the first instance of a row with the labelRow and TitleRow classes, this prevents the subsequent cloning from cloning multiple copies
var copyLabelRow = $(".labelRow").eq(0) ;
var copyTitleRow = $(".titleRow").eq(0);

//defines strings for endign one table and beginning anothe rtable
//var tableEnd = '</tbody></table>';
//var tableStart = '<table id="OvenTable" class="OvenTable"  border="1" cellpadding="2"><tbody>';

var increment = 14; //this defines the increment by which the table is split

 //increments through the dataRows at a defined or calculated increment and inserts the title and label rows
for (j=increment-1; j<=resultCount-increment; j=j+increment) {
  var targetRow = $(".dataRow").eq(j); //selects the nth dataRow based on the for loop
  $(copyLabelRow).clone().insertAfter(targetRow).addClass("copiedLabel");  //inserts the label row
  $(copyTitleRow).clone().insertAfter(targetRow).addClass("copiedTitle");  //inserts the title row
}

var $mainTable = $(".OvenTable");
var splitBy = increment + 2; //adds two because of the added title and label rows

//based on the number of results and the increment used, slices up the mainTable into secondary appended tables
for (j=1; j< resultCount / (increment - 1); j++){
  var zrows = $mainTable.find ( "tr" ).slice( splitBy,splitBy*2 );  //slices off rows
  var $secondTable = $(".OvenTable").parent().append("<table id='secondTable' class='OvenTable'><tbody></tbody></table>"); //appends a seconary table to the table container
  $secondTable.find("tbody").last().append(zrows); //inserts the sliced rows into the new secondary table
}
