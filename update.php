 <?php include('connection.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="user_styles.css">
</head>
<body>
  <div class="header">
    <h2>DETAILS</h2>
  </div>
  <form method="post" action="update.php">
  	<?php include('error.php'); ?>
  	<div class="input-group">
  	  <label>NAME</label>
  	  <input type="text" name="name" ><br>
  	</div>
  	<div class="input-group">
  	  <label>REGISTRATION NO</label>
  	  <input type="text" name="regno" ><br>
  	</div>
  	<div class="input-group">
  	  <label>PHONE NUMBER</label>
  	  <input type="text" name="phone">
  	</div>
    <div>
      <label>COUNCIL</label><br>
      <input type="radio" 
        name="contact" value="stureg">
      <label for="contactChoice1">STUDENT</label><br>
      <input type="radio" 
       name="contact" value="canreg">
      <label for="contactChoice2">DEPARTMENT</label><br>
    </div>
    <div class="input-group">
      <label>POSITION</label>
    	<input type="text" name="position">
    </div>
    <div class="modal-header"> 
      <h3 id="myModalLabel">Add</h3>
    </div> 
    <div class="modal-body">
      <table class="table1">
<!--	<tr>
		<td><label style="color:#3a87ad; font-size:18px;">FirstName</label></td>
		<td width="30"></td>
		<td><input type="text" name="first_name" placeholder="FirstName" required /></td>
	</tr>
	<tr>
		<td><label style="color:#3a87ad; font-size:18px;">LastName</label></td>
		<td width="30"></td>
		<td><input type="text" name="last_name" placeholder="LastName" required /></td>
	</tr>		-->
    	<tr>
	   	<td><label style="color:#3a87ad; font-size:18px;">Select your Image</label></td>
		  <td width="30"></td>
		  <td><input type="file" name="image"></td>
    	</tr>	
      </table>
    </div>
    <div class="modal-footer">
  <!--  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>	-->
      <button type="submit" name="Submit" class="btn btn-primary">Upload</button>
    </div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg1_user">SUBMIT</button>
  	</div>     
  </form>
</body>
</html>