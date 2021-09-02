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
$studentname=$_POST['studentname'];
$studentregno=$_POST['studentregno'];
$department=$_POST['department'];
$level_id=$_POST['level_id'];
$password=md5($_POST['password']);
$batch=($_POST['batch']);
$advisor=($_POST['advisor']);
$pincode = rand(100000,999999);
$ret=mysqli_query($con,"insert into students(studentName,advisor,department,StudentRegno,password,pincode,batch,level_id) 
values('$studentname','$advisor','$department','$studentregno','$password','$pincode','$batch','$level_id')");
if($ret)
{
$_SESSION['msg']="Student Registered Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Student  not Register";
}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Student Registration</title>
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
                        <h1 class="page-head-line">Student Registration  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Student Registration
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
   <div class="form-group">
    <label for="studentname">Student Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname" placeholder="Student Name" required />
  </div>

 <div class="form-group">
    <label for="studentregno">Student Id No   </label>
    <input type="text" class="form-control" id="studentregno" name="studentregno" onBlur="userAvailability()" placeholder="Student Id no" required />
     <span id="user-availability-status1" style="font-size:12px;">
  </div>

<div class="form-group">
    <label for="department">Department  </label>
    <select class="form-control" name="department" id="dept_id" required="required">
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
    <label for="advisor">Adviser  </label>
    <select class="form-control" name="advisor" id="advisor" required="required">
   <option value="">Select Adviser</option>   
   <?php 
$sql=mysqli_query($con,"select * from advisors");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['AdvisorId']);?></option>
<?php } ?>

    </select> 
  </div>
  
  <div class="form-group">
    <label for="batch">Batch   </label>
    <input type="text" class="form-control" id="batch" name="batch" onBlur="userAvailability()" placeholder="Batch" required />
     <span id="user-availability-status1" style="font-size:12px;">
  </div>
  
  <div class="form-group">
                                <label for="level_id">Syllabus Version </label>
                                <select id="level" class="form-control" name="level_id" required>
                                    <option value="">Select Syllabus Version</option>
                                    

                                </select>
                            </div>
  
   

<div class="form-group">
    <label for="password">Password  </label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required />
  </div>   

 <button type="submit" name="submit" id="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>

            </div>





        </div>
    </div>
  <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'regno='+$("#studentregno").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
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
	    $('#dept_id').on('change', function(){
        var dept_id = $(this).val();
		console.log(dept_id);
        if(dept_id){
            $.ajax({
                type:'POST',
                url:'dept_advisor.php',
                data:'dept_level='+dept_id,
                success:function(html){
                    $('#advisor').html(html);
                    
                }
            });
        }else{
            $('#advisor').html('<option value="">Select Department first</option>');
        }
    });

});

</script>

</body>
</html>
<?php } ?>
