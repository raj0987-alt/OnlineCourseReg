<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$coursecode=$_POST['coursecode'];
$coursename=$_POST['coursename'];
$department=$_POST['department'];
$SyllabusVersion=$_POST['SyllabusVersion'];
$courseunit=$_POST['courseunit'];
$seatlimit=$_POST['seatlimit'];
$syid=$_POST['syid'];
$offerbatch=$_POST['offerbatch'];
$seid=$_POST['seid'];
$yid=$_POST['yid'];
$ret=mysqli_query($con,"insert into course(coursecode,coursename,department,SyllabusVersion,courseUnit,noofSeats,syid,offerbatch,seid,yid) 
values('$coursename','$coursename',$department','$SyllabusVersion','$courseunit','$seatlimit','$syid','$offerbatch','$seid','$yid')");
if($ret)
{
$_SESSION['msg']="Course Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Course not created";
}
}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from course where id = '".$_GET['id']."'");
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
    <title>Admin | Course</title>
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
                        <h1 class="page-head-line">Course  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Course 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
  
 
  
  <div class="form-group">
    <label for="syid">Course Code  </label>
    <select class="form-control" name="syid" required="required">
   <option value="">Select Course</option>   
   <?php 
$sql=mysqli_query($con,"select * from syllabuses");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['courseName']);?></option>
<?php } ?>

    </select> 
  </div> 
  <div class="form-group">
    <label for="yid">Year  </label>
    <select class="form-control" name="yid" required="required">
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
    <label for="courseCode">Course Name  </label>
    <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Syllabus Version" required />
  </div>
  
 
  <div class="form-group">
    <label for="courseName">Course Name  </label>
    <input type="text" class="form-control" id="courseName" name="courseName" placeholder="Syllabus Version" required />
  </div>

  <div class="form-group">
    <label for="seid">semester  </label>
    <select class="form-control" name="seid" required="required">
   <option value="">Select semester</option>   
   <?php 
$sql=mysqli_query($con,"select * from semester");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['semester']);?></option>
<?php } ?>

    </select> 
  </div> 
  
  <div class="form-group">
    <label for="offerbatch">Batch  </label>
    <input type="text" class="form-control" id="offerbatch" name="offerbatch" placeholder="Batch" required />
  </div>
  
   
  
  <div class="form-group">
    <label for="SyllabusVersion">Syllabus Version  </label>
    <input type="text" class="form-control" id="SyllabusVersion" name="SyllabusVersion" placeholder="Syllabus Version" required />
  </div>

<div class="form-group">
    <label for="courseunit">Course Credit  </label>
    <input type="text" class="form-control" id="courseunit" name="courseunit" placeholder="Course Credit" required />
  </div> 

<div class="form-group">
    <label for="seatlimit">Seat limit  </label>
    <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat limit" required />
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
                            Manage Course
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Department Name </th>
											<th>Year  </th>
											<th>Semester Name </th>
											<th>Batch Name </th>
                                            <th>Course Code</th>
                                            
											
											<th>Syllabus Version </th>
                                            <th>Course Credit</th>
                                            <th>Seat limit</th>
                                             <th>Creation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select course.SyllabusVersion as sVersion,  department.department as dept,
 course.courseUnit as cUnit,course.courseName as su,course.courseCode as su course.noofSeats as nSeats, course.offerbatch as of, session.session as ss,
semester.semester as smm, course.creationDate as cDate
from course join department on department.id=course.department join semester on semester.id=course.seid
join session on session.id=course.yid");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['su']);?></td>
											<td><?php echo htmlentities($row['ss']);?></td>
											<td><?php echo htmlentities($row['smm']);?></td>
                                            <td><?php echo htmlentities($row['of']);?></td>
											<td><?php echo htmlentities($row['dept']);?></td>
											<td><?php echo htmlentities($row['sVersion']);?></td>
                                            <td><?php echo htmlentities($row['cUnit']);?></td>
                                             <td><?php echo htmlentities($row['nSeats']);?></td>
                                            <td><?php echo htmlentities($row['cDate']);?></td>
                                            <td>
                                            <a href="edit-course.php?id=<?php echo $row['id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>                                        
  <a href="course.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
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
