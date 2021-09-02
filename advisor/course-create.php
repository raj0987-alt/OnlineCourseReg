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
$session_id=$_POST['session_id'];
$courseCode =$_POST['courseCode'];

	//$cid=$_POST['cid'];
	// $rat=mysqli_query($con,"select * from syllabuses where courseCode=$courseCode");
	// $row=mysqli_fetch_array($rat);
	// print_r ($row);
// die;


$query = "select * from syllabuses where id=$courseCode";
$result = mysqli_query($con, $query);

/* numeric array *///
//$row = mysqli_fetch_assoc($result);
    while ($row = mysqli_fetch_assoc($result)) {
		$courseName =$row["courseName"];
		$courseCode =$row["id"];
		$courseCodeValue =$row["courseCode"];
		$courseCredit =$row["courseCredit"];
		//$session_id =$row["session_id"];
		$level =$row["level_id"];
		$prerequisite =$row["prerequisite"];
		//$department =$row["department"];
		

    }
	mysqli_query($con,"insert into courses(level,courseName,courseCode,courseCredit,session_id,prerequisite,courseCodeValue) 
values('$level','$courseName','$courseCode','$courseCredit','$session_id','$prerequisite','$courseCodeValue')");



//$courseName=$_POST['courseName'];

//$courseCode=$_POST['courseCredit'];


$ret = 0;

if($ret)
{
$_SESSION['msg']=" ";
}
else
{
  $_SESSION['msg']="Create Succesfully !! ";
}

}
if(isset($_GET['del']))
      {
              mysqli_query($con,"delete from courses where id = '".$_GET['id']."'");
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
                        <h1 class="page-head-line">Offer Courses  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Offer Courses 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
  
 
  
  <div class="form-group">
    <label for="session_id">Sessoin </label>
    <select class="form-control" name="session_id" required="required">
   <option value="">Select Sessoin</option>   
   <?php 
$sql=mysqli_query($con,"select sessions.id as id, sessions.year as ye, department.department as dept, semester_name.semesterType as sems
from sessions join department on department.id=sessions.department_id
join semester_name on semester_name.id=sessions.semester_id");
while($row=mysqli_fetch_array($sql))
{
?>


<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row["dept"]."- ".$row["sems"]." ".$row["ye"]);?></option>
<?php } ?>

    </select> 
  </div> 
  
    
  
  
  
  
  
  
  
  
  
  
  
  <div class="form-group">
                                <label for="courseCode">Course Code</label>
                                <select class="form-control" name="courseCode" id="courseCode" onchange="showCourseDetails()"
                                        
                                        required="required">
                                    <option value="">Select Course Code</option>
									<?php
                                    $sql = mysqli_query($con, "select * from syllabuses");
                                    while ($row = mysqli_fetch_array($sql)) {
                                        ?>


                                        <option data-end="<?php echo htmlentities($row['endDate']) ?>"
                                                value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row["courseCode"]); ?></option>
                                    <?php } ?>

                                </select>
                                <span id="course-availability-status1" style="font-size:12px;">
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
											<th>Session </th>
											
											
											<th>Course Code </th>
                                            
                                           
                                             
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql=mysqli_query($con,"select  
sessions.year as ye, department.department as dept,  semester_name.semesterType as sems, syllabuses.courseCode as cc,
courses.id as id
 from courses
 join sessions on courses.session_id=sessions.id 
join department on department.id=sessions.department_id
join semester_name on sessions.semester_id=semester_name.id
join syllabuses on courses.courseCode=syllabuses.id

");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>
                                       <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row["dept"]."- ".$row["sems"]." ".$row["ye"]);?></td>
											
											
											<td><?php echo htmlentities($row['cc']);?></td>
                                            
											
                                            
                                            <td>
                                                                                   
  <a href="course-create.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
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
    // Showing courses by syllabus
    function showCourses() {
        //const today = new Date();
        //const session = $("#selectCode").val();
        //const syllabus = $("#selectSyllabus").val();
        //const end = $("#selectSession").find(":selected").data("end");
        //let endDate = today;
        // if (session) {
            // let endDateArray = end.split("-");
            // endDate = new Date(endDateArray[0], endDateArray[1] - 1, endDateArray[2]);
        // }
        // if (session) {
            // showHideElements(endDate, today);
        // }
        
            
    }

    // function getCurrentDate() {
        // let date = new Date(), month = date.getMonth() + 1, day = date.getDate();
        // return date.getFullYear() + '-' + (('' + month).length < 2 ? '0' : '') + month + '-' + (('' + day).length < 2 ? '0' : '') + day;
    // }

    // function showHideElements(endDate, today) {
        // const button = $("#submit");
        // const expireMsg = $(".expireMsg");
        // const time = $("#time");
        // if (endDate > today) {
            // //button.show();
            // time.html(endDate);
            // expireMsg.hide();
            // button.prop("disabled", false);
        // } else {
            // //button.hide();
            // time.html(endDate);
            // expireMsg.show();
            // button.prop("disabled", true);
        // }
    // }

    function showCourseDetails() {
		
        const course = $("#courseCode");
        const courseDetails = $(".courseDetails");
        const selectedCourse = $("#courseCode").find(":selected");
        if (course.val()) {
			jQuery.ajax({
                url: "course-data.php?,
                type: 'GET',
                cache: false, // mobile a call dao
                success: function (data) {
                    let html = '<option value="">Select Course</option>';
                    data.forEach(function (item) {
                        html += '<option value="' + item.id + '" data-credit="' + item.courseCredit + '" data-name="' + item.courseName + '">' + item.courseName + '</option>';
                    });
                    $("#course").html(html);
                },
                error: function (error) {
                    console.log("Error while fetching courses " + error);
                }
            
        } 
            courseDetails.show();
            $("#courseName").val(selectedCourse.data("name"));
            $("#courseCredit").val(selectedCourse.data("credit"));
        }
        if (!course.val()) {
            console.log('Dearara');
            courseDetails.hide();
        }
    }
	
	
</script>
</body>
</html>
<?php } ?>
