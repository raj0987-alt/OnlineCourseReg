<?php
error_reporting(0);
session_start();
include('includes/config.php');
if(strlen($_SESSION['tlogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$department_id=$_POST['department_id'];
$semester_id=$_POST['semester_id'];
$year=$_POST['year'];
$regiStartDate=$_POST['regiStartDate'];
$regiEndDate=$_POST['regiEndDate'];

$ret=mysqli_query($con,"insert into sessions(department_id,semester_id,year,regiStartDate,regiEndDate) 
values('$department_id','$semester_id','$year','$regiStartDate','$regiEndDate')");
if($ret)
{
$_SESSION['msg']="Session Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Session not created";
}
}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from sessions where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Course deleted !!";
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Session</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['tlogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Session  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Session 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
  
 
  
  <div class="form-group">
    <label for="syid">Department  </label>
    <select class="form-control" name="department_id" required="required">
   <option value="">Select Department</option>   
   <?php 
$sql=mysqli_query($con,"select * from department");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['department']);?></option>
<?php } ?>

    </select> 
  </div> 
  <div class="form-group">
    <label for="yid">Semester Name  </label>
    <select class="form-control" name="semester_id" required="required">
   <option value="">Select Semester Option</option>   
   <?php 
$sql=mysqli_query($con,"select * from semester_name");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['semesterType']);?></option>
<?php } ?>

    </select> 
  </div> 
  
  <div class="form-group">
    <label for="year">Year  </label>
    <input type="text" class="form-control" id="year" name="year" placeholder="Enter Year" required />
  </div>
  
 
  <div class="form-group">
    <label for="regiStartDate">Registration Start Date  </label>
    <input type="date" class="form-control" id="regiStartDate" name="regiStartDate" placeholder="Registration Start Date" required />
  </div>
  
  <div class="form-group">
    <label for="regiEndDate">Registration End Date  </label>
    <input type="date" class="form-control" id="regiEndDate" name="regiEndDate" placeholder="Registration End Date" required />
  </div>
 

 <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
				<font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Sessoin
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Department Name </th>
											
											<th>Semester Name </th>
											<th>Year </th>
                                            <th>Registration Start Date</th>
                                            
											
											<th>Registration End Date </th>
                                           
                                             <th>Creation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select sessions.id as id, sessions.year as ye, department.department as dpt, semester_name.semesterType as sem,
sessions.regiStartDate as rs, sessions.regiEndDate as rd, sessions.creationDate as cd
from sessions join department on department.id=sessions.department_id 
join semester_name on semester_name.id=sessions.semester_id");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>
                                       <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['dpt']);?></td>
											<td><?php echo htmlentities($row['sem']);?></td>
											<td><?php echo htmlentities($row['ye']);?></td>
                                            <td><?php echo htmlentities($row['rs']);?></td>
											<td><?php echo htmlentities($row['rd']);?></td>
											<td><?php echo htmlentities($row['cd']);?></td>
                                            
                                            <td>
                                            <a href="session-edit.php?id=<?php echo $row['id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>                                        
  <a href="session-create.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                            <button class="btn btn-danger">Delete</button>
</a>
                                            </td>
                                        </tr>
<?php 
$cnt++;
} ?>

                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
                </div>
            </div>





        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
