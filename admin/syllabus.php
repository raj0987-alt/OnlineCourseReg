<?php
error_reporting(0);
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$department=$_POST['department'];
$level_id=$_POST['level_id'];
$courseCode=$_POST['courseCode'];
$courseName=$_POST['courseName'];
$courseCredit=$_POST['courseCredit'];
$prerequisite=$_POST['prerequisite'];

$ret=mysqli_query($con,"insert into syllabuses(department,level_id,courseCode,courseName,courseCredit,prerequisite) 
values('$department','$level_id','$courseCode','$courseName','$courseCredit','$prerequisite')");
if($ret)
{
$_SESSION['msg']="Syllabus Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Syllabus not created";
}
}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from syllabuses where id = '".$_GET['id']."'");
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
                        <h1 class="page-head-line">Syllabus  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Syllabus 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
					   
					   <div class="form-group">
    <label for="department">Department  </label>
    <select class="form-control" name="department" id="dept_id" required="required">
   <option value="">Select Depertment</option>   
   <?php 
$sql=mysqli_query($con,"select * from department");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>" ><?php echo htmlentities($row['department']);?></option>
<?php } ?>

    </select> 
  </div>
					   
					   <div class="form-group">
    <label for="level_id">Syllabus Version  </label>
    <select class="form-control" name="level_id" id="level" required="required">
   <option value="">Select  syllabus version</option>  

    </select> 
  </div> 
  
   <div class="form-group">
    <label for="courseCode">Course Code  </label>
    <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Course Code" required />
  </div>

 <div class="form-group">
    <label for="courseName">Course Name  </label>
    <input type="text" class="form-control" id="courseName" name="courseName" placeholder="Course Name" required />
  </div>
  
  
  
  

<div class="form-group">
    <label for="courseCredit">Course Credit  </label>
    <input type="text" class="form-control" id="courseCredit" name="courseCredit" placeholder="Course Credit" required />
  </div> 

<div class="form-group">
    <label for="prerequisite">Prerequisite </label>
    <input type="text" class="form-control" id="prerequisite" name="prerequisite" placeholder="Prerequisite" required />
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
                            Manage Syllabus
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Name </th>
											<th>Department Name </th>
											<th>Syllabus Version </th>
                                            <th>Course Credit</th>
                                            <th>Prerequisite</th>
                                             <th>Creation Date</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select syllabuses.id as id, syllabuses.creationDate as creationDate, syllabuses.courseCode as cc, syllabuses.courseName as cm, syllabuses.courseCredit as cd,
 level.level as sb,syllabuses.prerequisite as ps, department.department as dm
 from syllabuses join department on department.id=syllabuses.department join level on syllabuses.level_id=level.id
 ORDER BY dm ASC, cc ASC");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['cc']);?></td>
                                            <td><?php echo htmlentities($row['cm']);?></td>
											<td><?php echo htmlentities($row['dm']);?></td>
											<td><?php echo htmlentities($row['sb']);?></td>
                                            <td><?php echo htmlentities($row['cd']);?></td>
                                             <td><?php echo htmlentities($row['ps']);?></td>
											 <td><?php echo htmlentities($row['creationDate']);?></td>
                                            
                                            <td>
                                            <a href="syllabus-edit.php?id=<?php echo $row['id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>                                        
  <a href="syllabus.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
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
    <script>
$(document).ready(function(){
    $('#dept_id').on('change', function(){
        var dept_id = $(this).val();
        if(dept_id){
            $.ajax({
                type:'POST',
                url:'dept_level.php',
                data:'dept_level='+dept_id,
                success:function(html){
                    $('#level').html(html);
                    
                }
            });
        }else{
            $('#level').html('<option value="">Select Department first</option>');
        }
    });

});

</script>
</body>
</html>
<?php } ?>
