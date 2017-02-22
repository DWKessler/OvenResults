//create a php array to represent the data that is pulled in from a remote or local DB
<?php $array=array('1','1','0','0','1','1','0','1','1','1','1','1','0','1','1','0','0','0','0','1','0','1','1','1','0','1','0','1','1','1','1','0','0','0','1','0','1','1','1','0','1','1','1','0','0','1','0','1','1','0','0','0','1','0','0','1','0','1','1','1','0','0','1','1','0','1','1','1','0','1','1','0','1','1','1','1','0','1','0','1','1','1','0','1','1','0','0','0','0','0','0','1','1','0','0','0','0','1','1','0','1','1','0','0','1','1','1','1','0','0','0','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','1','0','1','1','0','1','0','1','0','0','1','0','0','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','0','1','0','0','1','0','0','1','0','1','0','1','0','0','0','0','1','0','0','0','0','1','1','0','0','1','0','1','0','1','1','1','1','1','1','1','0','1','0','0','1','0','1','0','0','1','1','1','0','1','1','0','1','0','0','0','1','1','0','0','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','0','0','0','1','0','1','1','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','0','0','0','1','1','1','1','1','0','0','0','1','1','0','1','0','0','0','1','1','1','1','0','0','1','0','0','1','0','1','0','1','0','1','0','0','0','0','0','0','1','1','1','0','1','1','0','1','1','1','1','0','0','0','0','0','1','1','1','0','1','1','1','1','1','1','0','1','1','0','1','1','1','0','1','1','0','1','1','0','0','1','1','1','1','1','0','1','0','0','1','0','0','0','0','0','0','0','0','0','1','0','1','1','0','1','0','0','1','0','0','0','0','1','1','1','1','1','0','0','1','0','1','1','0','1','0','0','0','0','0','1','0','1','1','1','0','0','0','1','1','1','1','1','0','0','1','1','1','1','1','1','1','1','1','1','0','1','1','1','0','0','0','1','1','0','0','1','0','1','0','1','0','1','0','1','1','1','0','0','0','0','1','1','1','1','0','0','0','0','0','0','1','0','1','1','0','1','0','0','0','0','1','1','0','1','0','0','1','1','1','1','1','1','1','0','0','1','1','1','0','0','1','1','0','0','1','0','0','0','0','0','1','1','1','0');?>
//this currently has 505 elements instead of 504

//transfer the data from php over to javascript by converting it to JSON
var thermostatarray = <?php echo json_encode($array);?>;

var table = document.getElementById("OvenTable");  //retrieves the table reference via the ID

//this makes the main title row
var rowx = table.insertRow(-1);  //adds a title row
var cellx = rowx.insertCell(-1); //adds a title cell
cellx.colSpan = "46"; //sets the span for the title to cover the whole table that will be generated
cellx.innerHTML = "Low Oven Status"; //sets the title

//this makes the Block title row
rowx = table.insertRow(-1);
for (i=0; i<11; i=i+2) {
 cellx = rowx.insertCell(i);
 cellx.innerHTML = "Block " + (i/2 + 1);// + i;
 cellx.colSpan = "6";
 if (i!=10) {  //prevents spacers from being added after the last block
   cellx = rowx.insertCell(i+1);
   cellx.innerHTML = "<b>&#9940;</b>";
   cellx.style.backgroundColor = "black";
 }
}

var titlerows = table.rows.length - 1; //check how many title rows were made

//this makes cells for thermostats 1~504 and then adds spacer columns
for (j=0; j<36; j++) { //works from left to right
  for (i=1; i<15; i++) {  //and top to bottom
    if (j==0) rowx = table.insertRow(-1); //if on the first column, adds all the new rows
    cellx = table.rows[i+titlerows].insertCell(-1); //adds a new cell in the rightmost position


    //cellx.innerHTML = i+j*14; //gives the cell a number based on its position
    //cellx.innerHTML = "<?php echo '1';?>"   //this is a placeholder for php content
    //cellx.innerHTML = "<?php echo array_rand($array);?>"   //this is a placeholder for php content
    //cellx.innerHTML = Math.round(Math.random());  //populates the cells with random continuity data
    cellx.innerHTML = thermostatarray[i+j*14];

    //this section color codes the cells either yellow or blue based on their continuity value / cell contents
    if (cellx.innerHTML == 1) {
      cellx.style.backgroundColor = "yellow";
    }
    else if (cellx.innerHTML == 0) {
      cellx.style.backgroundColor = "blue";
    }

    var block = (i+j*14) / 84;  //calculates the block being processed
    var blockcheck = Number.isInteger(block);  //determines whether the current number is the end of a block (it will be evenly divisible by 84)

    if (blockcheck == 1 && block != 6) {  //if the end of a block has been reached and that it isn't the last block
      var totalrows = table.rows.length;  //calculate the total number of rows in the table

      for (k=titlerows+1; k<totalrows; k++) {   //increment through the non-title rows
        cellx = table.rows[k].insertCell(-1);  //add a cell to the rightmost space
        cellx.innerHTML = "<b>&#9940;</b>";  //make it a spacer cell
        cellx.style.backgroundColor = "black";
      }
    }
  }
}

//this adds the middle spacer row, spans it across, and colors it black
rowx = table.insertRow(titlerows+8);
cellx = rowx.insertCell(-1);
cellx.colSpan = "46";
cellx.style.backgroundColor = "black";

//this adds the bottom row with the reference temperature
rowx = table.insertRow(-1);
cellx = rowx.insertCell(-1);
cellx.innerHTML = "Reference Temperature: xx °C";
cellx.colSpan = "46";
