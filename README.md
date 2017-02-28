# personalFinanceTool
A tool to manage personal finances in a two person house hold.  Includes a python gui to interface with a mysql database and php scripts for web forms and database analytics.

## Overview:
  This project provides a method to access a MySQL database that has been previously constructed with the specific schema as described below (to do).  The code is a combination of PHP and HTML.  Recently, a summary dashboard constructed with D3 has been added as well.
  
## To Do:
  Add some scripts for setup and construction of the database following the required schema.
  
## Description and Screen shots:
  homepage.html is the main homepage for the tool.  From this page, one can navigate one of three features.
  Markup : * Expenditure Form
  	     * Used to input data into the database detailing a financial transaction
	   * View Table Data
	     * Simply displays the information in the specified data base in the specified time range
	   * View Expenditures
	     * A crude visualization of the pulled data.  This has recently been replaced with a D3 interactive dashboard

 newhome.html is the link for the summary dashboard.  Currently the dashboard is setup to summarize financials transactions for the current month.  A month select button will be added to view historical data at any time.

 Some screen shots are below.  First is a view of the dashboard:

 ![Dashboard](/screenshots/sampleScreenShot.png)
 Format: ![Alt Text](url)

 Below shows what happens when the mouse hovers over a point in a graph:

 And if one hovers over the segments in the pie chart:


  
  


