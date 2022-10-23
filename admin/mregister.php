<!--manager register server side-->
<!--this file the sever side for handling manager to register-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<HTML XMLns="http://www.w3.org/1999/xHTML">
<body>
<H1>BuyOnline Admin Register</H1>
<br/>

<form>
    Name: <input type="text" name="name"> <br/>
    Password: <input type="text" name="password"> <br/><br/>
    <input type="submit" value="Register" /> <br/>
</form>
</body>
<?php
//check if name and password both provided
  if(isset($_GET['name']) && isset($_GET['password']))
  {
      //if provided, get the values
    $bowlerName = $_GET['name'];
    $bowlerPass = $_GET['password'];
    //use time stamp as user id
    date_default_timezone_set('Australia/Melbourne');
    $managerid = time();
    $bowlerInfo = $managerid.", ".$bowlerPass.",".$bowlerName."\n";
    $file = "./manager.txt";
    if(file_put_contents($file, $bowlerInfo, FILE_APPEND) > 0)
        //successufully register msg
    echo "<p><em>{$_GET['name']}</em>, you has been registered as a admin of the BuyOnline, your manager id is </p>".$managerid;
    else echo "<p>Registration error!</p>";
}
//else {
//  echo "<p>Please enter your name and phone number and click the Register button.</p>";
//}
echo "<br><br><button><a href='mlogin.htm'>Admin Login</a></button>";
?>
</HTML>
