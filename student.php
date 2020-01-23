<?php
require('connection.php');

session_start();
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}
$result=mysqli_query($con,"SELECT * FROM user");
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php
// retrieving positions sql query
$positions=mysqli_query($con, "SELECT * FROM tbPositions");
?> 
<?php
    // retrieval sql query
// check if Submit is set in POST
 if (isset($_POST['Submit']))
 {
 // get position value
 $position = addslashes( $_POST['position'] ); //prevents types of SQL injection
 
 // retrieve based on position
 $result = mysqli_query($con,"SELECT * FROM user WHERE position='$position'");
 // redirect back to vote
 //header("Location: vote.php");
 }
 else
 // do something
  
?>
<?php
// deleting sql query
// check if the 'id' variable is set in URL
 if (isset($_GET['id']))
 {
 // get id value
 $id = $_GET['id'];
 
 // delete the entry
 $result = mysqli_query($con, "DELETE FROM user WHERE id='$id'");
 
 // redirect back to candidates
 header("Location: student.php");
 }
 else
 ?>
<html><head>
<link href="user_styles.css" rel="stylesheet" type="text/css" />   
<script language="JavaScript" src="js/user.js">
</script>
<script type="text/javascript">
function getVote(int)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

	if(confirm("Your vote is for "+int))
	{
  var pos=document.getElementById("str").value;
  var id=document.getElementById("hidden").value;
  xmlhttp.open("GET","save.php?vote="+int+"&user_id="+id+"&position="+pos,true);
  xmlhttp.send();

  xmlhttp.onreadystatechange =function()
{
	if(xmlhttp.readyState ==4 && xmlhttp.status==200)
	{
  //  alert("dfdfd");
	document.getElementById("error").innerHTML=xmlhttp.responseText;
	}
}

  }
	else
	{
	alert("Choose another candidate ");
	}
	
}

function getPosition(String)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","student.php?position="+String,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
   var j = jQuery.noConflict();
    j(document).ready(function()
    {
        j(".refresh").everyTime(1000,function(i){
            j.ajax({
              url: "admin/refresh.php",
              cache: false,
              success: function(html){
                j(".refresh").html(html);
              }
            })
        })
        
    });
   j('.refresh').css({color:"green"});
});
</script>
</head><body bgcolor="tan">

<center><b><font color = "brown" size="6">E-VOTING </font></b></center><br><br>
<div id="page">
<div id="header">
<h1>STUDENT HOME </h1>
<a href="student.php">Home</a> | <a href="passkey.php">Current Polls</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
</div>
<div id="container">
<table width="420" align="center">
<form name="fmNames" id="fmNames" method="post" action="student.php" onSubmit="return positionValidate(this)">
<tr>
    <td>Choose Position</td>
    <td><SELECT NAME="position" id="position" onclick="getPosition(this.value)">
    <OPTION VALUE="select">select
    <?php 
    //loop through all table rows
    while ($row=mysqli_fetch_array($positions)){
    echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
    //mysql_free_result($positions_retrieved);
    //mysql_close($link);
    }
    ?>
    </SELECT></td>
    <td><input type="hidden" id="hidden" value="<?php echo $_SESSION['id']; ?>" /></td>
    <td><input type="hidden" id="str" value="<?php echo $_REQUEST['position']; ?>" /></td>
    <td><input type="submit" name="Submit" value="See Candidates" /></td>
</tr>
<tr>
    <td>&nbsp;</td> 
    <td>&nbsp;</td>
</tr>
</form> 
</table>
<table width="360" align="center">
<form>
</div>
<hr>
<table border="0" width="620" align="center">
<CAPTION><h3>AVAILABLE CANDIDATES</h3></CAPTION>
<tr>
<th>Candidate ID</th>
<th>Candidate Name</th>
<th>Candidate Mail</th>
<th>Candidate Position</th>
<th>Candidate image</th>
<th>Candidate Description</th>
</tr>

<?php
//loop through all table rows
if (isset($_POST['Submit']))
  {
$inc=1;
while ($row=mysqli_fetch_array($result)){
    
echo "<tr>";
echo "<td>" . $inc."</td>";
echo "<td>" . $row['name']."</td>";
echo "<td>" . $row['email']."</td>";
echo "<td>" . $row['position']."</td>";
//echo "<td>" . $row['image']."</td>";
#echo "<img src='images/".$row['image']."'>";
echo '<td><img height="100" width="100" src="images/'.$row['image'].'"></td>';
//echo "<td>" .base64_encode( $row['image'] )."<>/td";
//echo "<td>".img src=images/$row[image] class='rounded-circle' alt='$row[c_name]'."</td>";
echo "<td>" . $row['address']."</td>";
#echo '<td><a href="student.php?id=' . $row['id'] . '">Delete Candidate</a></td>';
echo "</tr>";
$inc++;
}
mysqli_free_result($result);
mysqli_close($con);
}
else
?>
<!--div class="img-block">
        <img src="<?php echo $img_src; ?>" alt="" title="<?php echo $image; ?>" width="100" height="100" class="img-responsive" />
        <p><strong><?php echo $image; ?></strong></p>
        </div-->
</table>
<hr>
<div id="footer">
<div class="bottom_addr"> SIKKIM MANIPAL INSTITUTE OF TECHNOLOGY</div>
</div>
</div>
</body></html>