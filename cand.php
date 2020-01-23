<?php
session_start();
require('../connection.php');
//require_once('vendor/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
//require_once('vendor/spreadsheet-reader-master/SpreadsheetReader.php');
//If your session isn't valid, it returns you to the login screen for protection
if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
} 
//retrive candidates from the tbcandidates table
$result=mysqli_query($con,"SELECT * FROM tbCandidates");
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php
// retrieving positions sql query
$positions_retrieved=mysqli_query($con, "SELECT * FROM tbPositions");
/*
$row = mysqli_fetch_array($positions_retrieved);
 if($row)
 {
 // get data from db
 $positions = $row['position_name'];
 }
 */
?>
<?php
//$conn = mysqli_connect("localhost","root","","sample");
require_once('vendor/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('vendor/spreadsheet-reader-master/SpreadsheetReader.php');

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
          
                $newRegistration = "";
                if(isset($Row[0])) {
                    $newCandidateName = mysqli_real_escape_string($con,$Row[1]);
                }
                $newCandidateName = "";
                if(isset($Row[1])) {
                    $newCandidateName = mysqli_real_escape_string($con,$Row[2]);
                }
                $newCandidatePosition = "";
                if(isset($Row[2])) {
                    $newCandidatePosition = mysqli_real_escape_string($con,$Row[3]);
                }
                
                if (!empty($name) || !empty($description)) {
                    $query = "INSERT INTO tbCandidates(regno,candidate_name,candidate_position) VALUES ('$newCandidateName','$newCandidatePosition')";
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
 $result = mysqli_query($con, "DELETE FROM tbCandidates WHERE candidate_id='$id'");
 
 // redirect back to candidates
 header("Location: cand.php");
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
  <a href="admin.php">Home</a> |<a href="cand1.php">Add Candidares List</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</div>
</div>
<div id="container">
<table width="380" align="center">
<CAPTION><h3>ADD CANDIDATES LIST</h3></CAPTION>
<form name="fmCandidates" id="fmCandidates" action="cand1.php" method="post" onsubmit="return candidateValidate(this)">
<div class="header">
  	<h2>Register</h2>
  </div>
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
<th>Candidate ID</th>
<th>regd no</th>
<th>Candidate Name</th>
<th>Candidate Position</th>
</tr>

<?php
//loop through all table rows
$inc=1;
while ($row=mysqli_fetch_array($result)){
    
echo "<tr>";
echo "<td>" . $inc."</td>";
echo "<td>" . $row['Regd_No']."</td>";
echo "<td>" . $row['candidate_name']."</td>";
echo "<td>" . $row['candidate_position']."</td>";
echo '<td><a href="cand.php?id=' . $row['candidate_id'] . '">Delete Candidate</a></td>';
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