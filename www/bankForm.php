<html>
<head>
<title>Bank Form</title>

<object>
<param name="autostart" value="true">
<param name="src" value="sound.mp3">
<param name="autoplay" value="true"> 
<param name="controller" value="true">
<embed src="../audio/02 Foreign Legion.mp3" controller="true" autoplay="true" autostart="True" type="audio/mp3" height = "50"/><br>
</object>

</head>
<body>

Enter Transaction Information <br><br>

<form action="process.php" method="post">
Transaction Value: $<input type="text" name="value"><br><br>
Transaction Type:<br />
<input type="radio" name="formDoor" value="Paybill" />PayBill
&nbsp &nbsp What Bill? <input type="text" name="bill"><br />
<input type="radio" name="formDoor" value="Gas" />Gas<br />
<input type="radio" name="formDoor" value="Childcare" />Child Care<br />
<input type="radio" name="formDoor" value="Food" />Food/Supplies<br />
<input type="radio" name="formDoor" value="Forfun" />For Fun<br />
<input type="radio" name="formDoor" value="ATM" /> ATM Withdrawl<br />
<input type="radio" name="formDoor" value="Other" />Other<br />
<input type="radio" name="formDoor" value="Gotpaid" />Got Paid<br />
<br>

From Account:<br/>
<input type="radio" name="aDoor" value="cash" />Cash<br />
<input type="radio" name="aDoor" value="debit" />Debit<br />
<input type="radio" name="aDoor" value="credit" />Credit<br />
<input type="radio" name="aDoor" value="savings" />Savings<br /><br>

Person Making Transaction:<br />
<input type="radio" name="pDoor" value="M" />Melissa<br />
<input type="radio" name="pDoor" value="R" />Rich<br /><br>

User Name: <input type="text" name="user"> Password: <input type="password" name="pswd"><br><br>

<input type="submit" name="formSubmit" value="Submit" />



</form>


<form action="homepage.html">
<input name="Go back home" type="submit" value="Go back home" />
</form>

</body>
</html>
