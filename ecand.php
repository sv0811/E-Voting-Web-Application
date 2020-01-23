<?php
session_start();
require('../connection.php');
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
//export.php  
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM tbCandidates";
 $result = mysqli_query($con, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Candidate ID</th>
						<th>registartion</th>
					<th>Candidate Name</th>
				<th>Candidate Position</th>
                    </tr>
  ';
  $inc=1;
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$inc.'</td>  
                         <td>'.$row["Regd_No"].'</td>  
                         <td>'.$row["candidate_name"].'</td>  
       <td>'.$row["candidate_position"].'</td>  
                    </tr>
   ';
   $inc++;
  }
  $output .= '</table>';
  header('Content-Type: xls');
  header('Content-Disposition: attachment; filename=test.xlsx');
  echo $output;
 }
 else
   { 
        $type = "error";
        $message = "Invalid File Type. .";
    }
  header("Location: ecand.php");
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
 header("Location: ecand.php");
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
</head>
<body bgcolor="tan">
<center><b><font color = "brown" size="6">E-VOTING</font></b></center><br><br>
<div id="page">
<div id="header">
  <h1>MANAGE CANDIDATES</h1>
  <a href="admin.php">Home</a> |<a href="stud.php">Add Student List</a> |<a href="cand1.php">Add Candidares List</a> |<a href="ecand.php">export candidate list</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Poll Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</div>
</div>
<div class="container">  
   <br />  
   <br />  
   <br />  
   <div class="table-responsive">  
    <h2 align="center">Export MySQL data to Excel in PHP</h2><br /> 
    <table class="table table-bordered">
     <tr>  
                         <th>Candidate ID</th>
<th>registartion</th>
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
<br />
    <form method="post" action="ecand.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
    </form>
<hr>
</div>
<div id="footer"> 
  <div class="bottom_addr">SIKKIM MANIPAL INSTITUTE OF TECHNOLOGY</div>
</div>
</div>
</body>
</html>