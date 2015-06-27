<form action="displayMonthlyCosts.php" method="post">

Select a month and year to view monthly expenditures <br> <br>

Enter Year: <input type="text" name="year">

Select Month:
<select name="month" id="month">
   <option value="all">All Months</option>
   <option value="01">January</option>
   <option value="02">February</option>
   <option value="03">March</option>
   <option value="04">April</option>
   <option value="05">May</option>
   <option value="06">June</option>
   <option value="07">July</option>
   <option value="08">August</option>
   <option value="09">September</option>
   <option value="10">October</option>
   <option value="11">November</option>
   <option value="12">December</option>

   
</select>

<br><br>

User Name: <input type="text" name="user"> Password: <input type="password" name="pswd"><br><br>   

<input name="submitbutton" type="submit" value="submit" />

</form>


<form action="homepage.html">
<input name="Go back home" type="submit" value="Go back home" />
</form>


<object>
<param name="autostart" value="true">
<param name="src" value="sound.mp3">
<param name="autoplay" value="true"> 
<param name="controller" value="true">
<embed src="../audio/03 Big Top.mp3" controller="true" autoplay="true" autostart="True" type="audio/mp3" height = "50"/>
</object>