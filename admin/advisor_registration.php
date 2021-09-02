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
  $AdvisorId=$_POST['AdvisorId'];
  $AdvisorName=$_POST['AdvisorName'];
  $Password=md5($_POST['Password']);
  $DeptId=$_POST['DeptId'];
$ret=mysqli_query($con,"insert into advisors(AdvisorId,AdvisorName, Password,DeptId) values('$AdvisorId','$AdvisorName','$Password','$DeptId')");
if($ret)
{
$_SESSION['msg']="Advisor Registered Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Advisor not Registered";
}
}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from semester where id = '".$_GET['Id']."'");
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
    <title>Admin | Advisor Registration</title>
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
                        <h1 class="page-head-line">Advisor  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Advisor 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="advisors" method="post">
					   
	</div> 
   <div class="form-group">
    <label for="AdvisorId"> Advisor Id  </label>
    <input type="text" class="form-control" id="AdvisorId" name="AdvisorId" placeholder="Advisor Id" required />
  </div>

<div class="form-group">
    <label for="AdvisorName"> Advisor Name  </label>
    <input type="text" class="form-control" id="AdvisorName" name="AdvisorName" placeholder="Advisor Name" required />
  </div>  
  
  <div class="form-group">
    <label for="Password"> Password  </label>
    <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password" required />
  </div>  
					   
					   <div class="form-group">
    <label for="DeptId">Department  </label>
    <select class="form-control" name="DeptId" required="required">
   <option value="">Select Department</option>   
   <?php 
$sql=mysqli_query($con,"select * from Department");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['department']);?></option>
<?php } ?>

    </select> 
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
                            Manage Advisors
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>Advisor Id</th>
                                            <th>Advisor Name</th>
											<th>Department</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"SELECT advisors.AdvisorId as ai, advisors.AdvisorName as an,  department.department as dpt,
advisors.CreationDate as cd from advisors
 join department on department.id=advisors.DeptId");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
											<td><?php echo htmlentities($row['ai']);?></td>
                                            <td><?php echo htmlentities($row['an']);?></td>
                                            <td><?php echo htmlentities($row['dpt']);?></td>
											<td><?php echo htmlentities($row['cd']);?></td>
                                            <td>
  <a href="advisor_registration.php?id=<?php echo $row['Id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
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
