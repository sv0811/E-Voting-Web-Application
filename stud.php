<?php
session_start();
require('../connection.php');
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
} 
//retrive candidates from the tbcandidates table
$result=mysqli_query($con,"SELECT * FROM tbMembers");
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php
require_once('vendor/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('vendor/spreadsheet-reader-master/SpreadsheetReader.php');
$temp = "something";
if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $myFirstName = "";
                if(isset($Row[0])) {
                    $myFirstName = mysqli_real_escape_string($con,$Row[0]);
                }
                
                $myLastName = "";
                if(isset($Row[1])) {
                    $myLastName = mysqli_real_escape_string($con,$Row[1]);
                }
                $myEmail= "";
                if(isset($Row[2])) {
                    $myEmail = mysqli_real_escape_string($con,$Row[2]);
                }
                $newpass = $myLastName.$myFirstName;
                $newpass=md5($newpass);
                // echo "fghjkkghjnkedsuxbjvhsudbjkdvuhsjkdvhioscnklfdvhiosfvuhsdjkfsdvujkfducbjk";
                // if(isset($Row[3])) {
                    // $newpass = mysqli_real_escape_string($con,$Row[3]);
                // }
                if (!empty($myFirstName) || !empty($myLastName)|| !empty($myEmail)|| !empty($newpass)) {
                    $query = "INSERT INTO tbMembers(first_name, last_name, email,password) 
                                VALUES ('$myFirstName','$myLastName', '$myEmail', '$newpass') " ;
                    $result = mysqli_query($con, $query);
                
                    if (! empty($result)) {         
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
  header("Location: stud.php");
}
?>
<?php
// deleting sql query
// check if the 'id' variable is set in URL
 if (isset($_GET['id']))
 {
 // get id value
 $id = $_GET['id'];
 
 // delete the entry
 $result = mysqli_query($con, "DELETE FROM tbMembers WHERE member_id='$id'");
 
 // redirect back to candidates
 header("Location: stud.php");
 }
 else
 // do nothing   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administration Control Panel:Candidates</title>
<link href="admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/admin.js">
</script>
</head>
<body bgcolor="tan">
<center><b><font color = "brown" size="6">E-VOTING</font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE CANDIDATES</h1>
  <a href="admin.php">Home</a> |<a href="stud.php">Add Student List</a> |<a href="cand1.php">Add Candidates List</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</div>
</div>
<div id="container">
<div align="center">
<CAPTION><h3>ADD CANDIDATES LIST</h3></CAPTION></div>

<div class="header">
    <h2>add list</h2>
  </div>
<body>
    <h2>Import Excel File into MySQL Database using PHP</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>         
<hr>
<table border="0" width="620" align="center">
<CAPTION><h3>AVAILABLE CANDIDATES</h3></CAPTION>
<tr>
<th>member ID</th>
<th>Registartion</th>
<th>Last name</th>
<th>Gmail</th>
<th>password</th>
</tr>

<?php
//loop through all table rows
$inc=1;
while ($row=mysqli_fetch_array($result)){
    
echo "<tr>";
echo "<td>" . $inc."</td>";
echo "<td>" . $row['first_name']."</td>";
echo "<td>" . $row['last_name']."</td>";
echo "<td>" . $row['email']."</td>";
echo '<td><a href="stud.php?id=' . $row['member_id'] . '">Delete Candidate</a></td>';
echo "</tr>";
$inc++;
}

mysqli_free_result($result);
mysqli_close($con);
?>
</table>
<hr>
</div>
<div id="footer"> 
  <div class="bottom_addr">SIKKIM MANIPAL INSTITUTE OF TECHNOLOGY</div>
</div>
</div>
</body>
</html>