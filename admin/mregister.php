<HTML XMLns="http://www.w3.org/1999/xHTML">
<body>
<H1>BuyOnline Admin Register</H1>
<br/>

<form>
    Name: <input type="text" name="name"> <br/>
    Phone: <input type="text" name="phone"> <br/><br/>
    <input type="submit" value="Register" /> <br/>
</form>
</body>
<?php
  if(isset($_GET['name']) && isset($_GET['phone']))
  {
    $bowlerName = $_GET['name'];
    $bowlerPhone = $_GET['phone'];
    $bowlerInfo = $bowlerName.", ".$bowlerPhone."\n";
    $file = "./manager.txt";
    if(file_put_contents($file, $bowlerInfo, FILE_APPEND) > 0)
    echo "<p><em>{$_GET['name']}</em> has been registered as a admin of the BuyOnline.</p>";
    else echo "<p>Registration error!</p>";
}
//else {
//  echo "<p>Please enter your name and phone number and click the Register button.</p>";
//}
echo "<button><a href='mlogin.php'>Login</a></button>";
?>
</HTML>
