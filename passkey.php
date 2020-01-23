<?php
session_start();
require('connection.php');

//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
} 

//retrive student details from the tbmembers table
//$result=mysqli_query($con, "SELECT * FROM tbMembers WHERE member_id = '$_SESSION[member_id]'");
//if (mysqli_num_rows($result)<1){
//    $result = null;
//}
//$row = mysqli_fetch_array($result);
//if($row)
// {
 // get data from db
// $stdId = $row['member_id']; 
 // $encpass= $row['password'];
//}
?>
<?php
// updating sql query
if(isset($_POST['passkey'])){
  $passkey1 = $_POST['passkey1'];
  if($passkey1 == "EV19"){
//If everything checks out, you will now be forwarded to student.php
//$user1 = mysqli_fetch_assoc($sql1);
//$_SESSION['image_id'] = $user1['image_id'];
    header("location:vote.php");}
}
/*if (isset($_POST['changepass'])){
$myId =  $_REQUEST['id'];
$oldpass = md5($_POST['oldpass']);
$newpass = $_POST['newpass'];
$conpass = $_POST['conpass'];
if($encpass == $oldpass)
{
  if($newpass == $conpass)
  {
    $newpassword = md5($newpass); //This will make your password encrypted into md5, a high security hash
    $sql = mysqli_query($con,"UPDATE tbmembers SET password='$newpassword' WHERE member_id = '$myId'" );
    echo "<script>alert('Password Change')</script>";
  }
  else
  {
    echo "<script>alert('New and Confirm Password Not Match')</script>";
  }

}
else
{
    echo "<script>alert('Old password not match')</script>";
}*/


// redirect back to profile
// header("Location: manage-profile.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Student Profile Management</title>
<link href="user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/user.js">
</script>
</head>
<body bgcolor="tan">
     
<center><b><font color = "brown" size="6">E-VOTING </font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE MY PROFILE</h1>
  <a href="student.php">Home</a> | <a href="passkey.php">Current Polls</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
</div>
<div id="container">
<table border="0" width="620" align="center">
<CAPTION><h3>PASS KEY</h3></CAPTION>
<form action="passkey.php" method="post">
<table align="center">
<tr><td>Pass key:</td><td><input type="text" name="passkey1" maxlength="15" value=""></td></tr>
<tr><td>&nbsp;</td></td><td><input type="submit" name="passkey" value="VERIFY"></td></tr>

</table>
</form>
<hr>
</div>
</div>
</body>
</html>