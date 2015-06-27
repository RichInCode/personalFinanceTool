Select the table data you want to view <br><br>

<form action="displayTableInfo.php" method="post">
Table:
<select name="listOption" id="listOption">
   <option value="Select">Select</option>
   <option value="current_money">current_money</option>
   <option value="billpay">billpay</option>
   <option value="bankbalance">bankbalance</option>
   
</select>

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
<embed src="../audio/04 Orbly Resting.mp3" controller="true" autoplay="true" autostart="True" type="audio/mp3" height = "50"/>
</object>