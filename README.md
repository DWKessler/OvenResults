This project is a compilation of several data/statistical user interfaces.
Many functions rely on PHP and some on a MySQL database.
The project files are available at https://github.com/DWKessler/OvenResults/tree/master but are also hosted live at http://codeL.DWKessler.com

The primary components and the techniques demonstrated are listed below.

* Header: Links together different segments in groups based on the machine they show data from.
  * Techniques:
    * Flexbox for layout.
    * CSS hover dropdowns.
    * CSS media queries to be responsive at different breakpoints.

* Ovens:
  * Status: A page designed for a display in a fixed location by a machine. Not intended to be responsive.
    * Techniques:
      * Table is entirely generated with Javascript and populated with data from a JS array.

  * Results: A page designed for viewing and printing of the oven run's results.
    * Techniques:
      * Javascript and jquery are used to generate the table, break it into smaller tables, and color code the randomly generated values.
      * CSS media queries to be responsive at different breakpoints and for printing.

* Assembly 5:
  * Status: This page showcases data from a MySQL database in the form of two Google Charts. A page designed for a display in a fixed location by a machine. Not intended to be responsive. Previous and Next buttons can be used to scroll through the data in time.
    * Techniques:
      * MySQL queries.
      * Google Chart formatting and JSON arrays.

* Multitester:
  * Devices: This page allows the user to add/delete/edit records from the MySQL database.
    * Techniques:
      * MySQL queries.
