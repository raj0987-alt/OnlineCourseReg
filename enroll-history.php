<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
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
<?php if($_SESSION['login']!="")
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
											<th>Session </th>
                                             <th>Syllabus Version</th>
											 <th>Course Code </th>
											 <th>Course Name </th>
											 <th>Course Credit </th>
                                                
                                             <th>Registration Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con," select courseenrolls.status as status, courseenrolls.enrollDate as edate, department.department as department, 
semester_name.semesterType as semesterType, sessions.year as year, level.level as level,
courses.courseName as courseName, syllabuses.courseCode as courseCode, 
courses.courseCredit as courseCredit
from courseenrolls
join courses on courses.id=courseenrolls.course
join syllabuses on courses.courseCode=syllabuses.id
join level on level.id=syllabuses.level_id
join department on level.department=department.id
join sessions on sessions.id=courses.session_id
join semester_name on semester_name.id=sessions.semester_id
where courseenrolls.studentRegno='".$_SESSION['login']."'

 ");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
										
										<td><?php echo $cnt;?></td>
										<td><?php echo htmlentities($row["department"]."- ".$row["semesterType"]." ".$row["year"]);?></td>
                                            <td><?php echo htmlentities(ucwords($row['level']));?></td>
											<td><?php echo htmlentities(ucwords($row['courseCode']));?></td>
											<td><?php echo htmlentities(ucwords($row['courseName']));?></td>
											<td><?php echo htmlentities(ucwords($row['courseCredit']));?></td>
                                            
											<td><?php echo htmlentities(ucwords($row['edate']));?></td>
                                            <td><?php echo htmlentities(ucwords($row['status']));?></td>
                                            
                                        </tr>
										
										
<?php 
$cnt++;
} ?>

                                        
                                    </tbody>
                                </table>
                            </div>
							<div id="divToPrint" style="display:none;">
  <div style="width:200px;height:300px;">
           <?php echo $html; ?>      
  </div>
</div>
<a href="new-print.php?id=<?php echo $row['cid']?>" target="_blank">
<button class="btn btn-primary btn-sm"><i class="fa fa-print "></i> Print</button> </a>


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
	<script type="text/javascript">     
    var prtContent = document.getElementById("your div id");
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
 </script>
</body>
</html>
<?php } ?>
