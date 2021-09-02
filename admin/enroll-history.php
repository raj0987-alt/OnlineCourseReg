<?php
error_reporting(0);
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{



?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registration History</title>
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
                        <h1 class="page-head-line">Registration History  </h1>
                    </div>
                </div>
                <div class="row" >
            
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Registration History
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Season </th>
                                                 <th>Student Name </th>
                                                    <th>Student Id no </th>
													<th>Syllabus Version </th>
                                            <th>Course Code </th>
											<th>Course Name </th>
											<th>Course Credit </th>
                                            
                                            
                                                
                                             <th>Registration Date</th>
											 <th>Status</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select courseenrolls.id as eid, courseenrolls.course as cid, courseenrolls.status as status, 
courseenrolls.enrollDate as enrollDate, courses.courseName as courname,
syllabuses.courseCode as cd, courses.courseCredit as cr, level.level as lvl, department.department as dept,
 semester_name.semesterType as sems, sessions.year as ye, courseenrolls.enrollDate as edate , courseenrolls.id as eid ,
 students.studentName as sname,students.StudentRegno as sregno, courseenrolls.status as status 
 from courseenrolls join courses on courses.id=courseenrolls.course join syllabuses on courses.courseCode=syllabuses.id 
 join level on level.id=syllabuses.level_id join department on level.department=department.id join sessions on sessions.id=courses.session_id 
 join semester_name on semester_name.id=sessions.semester_id join students on students.StudentRegno=courseenrolls.studentRegno
");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
											<td><?php echo htmlentities($row["dept"]."- ".$row["sems"]." ".$row["ye"]);?></td>
											
											<td><?php echo htmlentities($row['sname']);?></td>
											<td><?php echo htmlentities($row['sregno']);?></td>
											<td><?php echo htmlentities($row['lvl']);?></td>
											<td><?php echo htmlentities($row['cd']);?></td>
											<td><?php echo htmlentities($row['courname']);?></td>
											<td><?php echo htmlentities($row['cr']);?></td>
                                            
                                             <td><?php echo htmlentities($row['enrollDate']);?></td>
											 <td><?php echo htmlentities(ucwords($row['status']));?></td>
                                            <td>
											<?php
	if($row['status']=="pending")
	{
                echo'<a href="print.php?id='.$row["cid"].'&status=approved&eid='.$row["eid"].'">
        <button class="btn btn-success btn-sm"><i class="fa fa-print "></i> Approve</button> </a> 
        
        <a href="print.php?id='.$row["cid"].'&status=rejected&eid='.$row["eid"].'">
        <button class="btn btn-warning btn-sm"><i class="fa fa-print "></i> Reject</button> </a>';
	}	

										
	// if($row['status']=="pending")
	// {
                // echo'<a href="print.php?id='.$row["cid"].'&status=approved&eid='.$row["eid"].'">
        // <button class="btn btn-success btn-sm"><i class="fa fa-print "></i> Approve</button> </a> 
        
        // <a href="delete.php?did='.$row["eid"].'">
        // <button class="btn btn-warning btn-sm"><i class="fa fa-print "></i> Reject</button> </a>';
	// }		
											
											
											
											?>
                                             
                                       
<a href="new-print.php?id=<?php echo $row['cid']?>" target="_blank">
<button class="btn btn-primary btn-sm"><i class="fa fa-print "></i> Print</button> </a>

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
