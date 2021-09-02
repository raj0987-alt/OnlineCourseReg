<?php
session_start();
include('includes/config.php');
//error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
  $semester=$_POST['semester'];
  $dept_id=$_POST['dept_id'];
  $regStartDate=$_POST['regStartDate'];
  $regEndDate=$_POST['regEndDate'];
  $dpt=$_POST['dpt'];
$ret=mysqli_query($con,"insert into semester(dept_id,semester,regStartDate,regEndDate,dpt) values('$dept_id','$semester',
'$regStartDate','$regEndDate','$dpt')");
if($ret)
{
$_SESSION['msg']="Semester Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Semester not created";
}
}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from semester where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="semester deleted !!";
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Semester</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Semester  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Semester 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="semester" method="post">
					   
<div class="form-group">
    <label for="dept_id">Department  </label>
    <select class="form-control" name="dpt" required="required">
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
    <label for="dept_id">Year  </label>
    <select class="form-control" name="dept_id" required="required">
   <option value="">Select Year</option>   
   <?php 
$sql=mysqli_query($con,"select * from session");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['session']);?></option>
<?php } ?>

    </select> 
  </div> 
   <div class="form-group">
    <label for="semester">Add Semester  </label>
    <input type="text" class="form-control" id="semester" name="semester" placeholder="semester" required />
  </div>
  
  <div class="form-group">
    <label for="regStartDate">Registration Start Date  </label>
    <input type="date" class="form-control" id="regStartDate" name="regStartDate" required />
  </div>
  
  <div class="form-group">
    <label for="regEndDate">Registration End Date  </label>
    <input type="date" class="form-control" id="regEndDate" name="regEndDate" required />
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
                            Manage Semester
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Department</th>
											<th>Year</th>
                                            <th>Semester</th>
											<th>Registration Start Date</th>
											<th>Registration END Date</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"SELECT semester.semester as sem, session.session as sec,semester.regStartDate as st,
semester.regEndDate as ed, department.department as dp,  semester.creationDate as cd from semester
 join session on session.id=semester.dept_id join department on department.id=semester.dpt");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
											<td><?php echo htmlentities($row['dp']);?></td>
											<td><?php echo htmlentities($row['sec']);?></td>
                                            <td><?php echo htmlentities($row['sem']);?></td>
											<td><?php echo htmlentities($row['st']);?></td>
											<td><?php echo htmlentities($row['ed']);?></td>
                                            <td><?php echo htmlentities($row['cd']);?></td>
                                            <td>
  <a href="semester.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
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
