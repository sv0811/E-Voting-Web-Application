<html><head>
<link href="user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/user.js">
</script>
</head><body bgcolor="tan">
   
<center><b><font color = "brown" size="6"> E-VOTING </font></b></center><br><br>
<div id="page">
<div id="header">
<h1>Student Registration </h1>
<div class="news"><marquee behavior="alternate">New polls are up and running. But they will not be up forever! Just Login and then go to Current Polls to vote for your favourate candidates. </marquee></div>
</div>

<div id="container">
<?php
require('connection.php');
if(isset($_POST['uploadfilesub'])) {
//declaring variables
$filename = $_FILES['uploadfile']['name'];
$filetmpname = $_FILES['uploadfile']['tmp_name'];
//folder where images will be uploaded
$folder = 'imagesuploadedf/';
//function for saving the uploaded images in a specific folder
move_uploaded_file($filetmpname, $folder.$filename);
//inserting image details (ie image name) in the database
$sql = "INSERT INTO `images` (`image`)  VALUES ('$filename')";
$qry = mysqli_query($conn,  $sql);
if( $qry) {
echo "</br>image uploaded"; 
}
}
//Process

if (isset($_POST['submit']))
{

$myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
//$myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
$myEmail = $_POST['email'];
$myPassword = $_POST['password'];

$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash

$sql = mysqli_query($con, "INSERT INTO images(c_name, email,password) 
VALUES ('$myFirstName', '$myEmail', '$newpass') ");

die( "You have registered for an account.<br><br>Go to <a href=\"index.php\">Login</a>" );
}

echo "<center><h3>Register an account by filling in the needed information below:</h3></center><br><br>";
echo '<form action="registeracc.php" method="post" onsubmit="return registerValidate(this)">';
echo '<table align="center"><tr><td>';
echo "<tr><td>First Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='firstname' maxlength='15' value=''></td></tr>";
//echo "<tr><td>Last Name:</td><td><input type='text' style='background-color:#999999; font-weight:bold;' name='lastname' maxlength='15' value=''></td></tr>";
echo "<tr><td>Email Address:</td><td><input type='email' style='background-color:#999999; font-weight:bold;' name='email' maxlength='100' id='email'value=''></td><td><span id='result' style='color:red;'></span></td></tr>";
echo "<tr><td>Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='password' maxlength='15' value=''></td></tr>";
echo "<tr><td>Confirm Password:</td><td><input type='password' style='background-color:#999999; font-weight:bold;' name='ConfirmPassword' maxlength='15' value=''></td></tr>";
echo '<tr><td>upload image:</td><td><input type="file" name="uploadfile" />
<input type="submit" name="uploadfilesub" value="upload" /></td></tr>';
echo "<tr><td>&nbsp;</td><td><input type='submit' name='submit' value='Register Account'/></td></tr>";
//echo '<tr><td>upload image:</td><td><input type="file" name="uploadfile" />
//input type="submit" name="submit" value="" /></td></tr>';
echo "<tr><td colspan = '2'><p>Already have an account? <a href='index.php'><b>Login Here</b></a></td></tr>";
echo "</tr></td></table>";
echo "</form>";
?>
</div> 



<div id="footer">
<div class="bottom_addr"> SIKKIM MANIPAL INSTITUTE OF TECHNOLOGY</div>
</div>
</div>
</body>
<script src="js/jquery-1.2.6.min.js"></script>
    <script>
    $(document).ready(function(){
      
        $('#email').blur(function(event){
         
            event.preventDefault();
            var emailId=$('#email').val();
                                $.ajax({                     
                            url:'checkuser.php',
                            method:'post',
                            data:{email:emailId},  
                            dataType:'html',
                            success:function(message)
                            {
                            $('#result').html(message);
                            }
                      });
                    
           

        });

    });
   
    </script>
</html>