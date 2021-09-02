<?php
error_reporting(0);
session_start();
include('includes/config.php');
if(strlen($_SESSION['tlogin'])==0)
    {   
header('location:index.php');
}
else{
$id=intval($_GET['id']);
date_default_timezone_set('Asia/Dhaka');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
if(isset($_POST['submit']))
{
$regiStartDate=$_POST['regiStartDate'];
$regiEndDate=$_POST['regiEndDate'];
//$courseCredit=$_POST['courseCredit'];
//$seatlimit=$_POST['seatlimit'];
$ret=mysqli_query($con,"update  sessions set regiStartDate='$regiStartDate', regiEndDate='$regiEndDate'  where id='$id'");
if($ret)
{
$_SESSION['msg']="Sessions Updated Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Sessions not Updated";
}
}
?>

<!DOCTYPE html>syllabuses
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
                        <h1 class="page-head-line">Session Edit  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Session Edit 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
<?php
$sql=mysqli_query($con,"select * from sessions where id='$id'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>

   <div class="form-group">
    <label for="regiStartDate">Update Registration Start Date  </label>
    <input type="date" class="form-control" id="regiStartDate" name="regiStartDate" placeholder="Registration Start Date" value="<?php echo htmlentities($row['regiStartDate']);?>" required />
  </div>

 <div class="form-group">
    <label for="regiEndDate">Update Registration Start Date </label>
    <input type="date" class="form-control" id="regiEndDate" name="regiEndDate" placeholder="Registration End Date" value="<?php echo htmlentities($row['regiEndDate']);?>" required />
  </div>

 

 


<?php } ?>
 <button type="submit" name="submit" class="btn btn-default"><i class=" fa fa-refresh "></i> Update</button>
</form>
                            </div>
                            </div>
                    </div>
                  
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
