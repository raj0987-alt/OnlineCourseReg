<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0 or strlen($_SESSION['pcode']) == 0)
{
    header('location:index.php');
}
else{

if (isset($_POST['submit'])) {
    $studentregno = $_POST['studentregno'];
    $pincode = $_POST['Pincode'];
    $session = $_POST['session'];
    $dept = $_POST['department'];
    //$level = $_POST['level'];
    $course = $_POST['course'];
    //$semester = $_POST['semester'];

    $ret = mysqli_query($con, "insert into courseenrolls(studentRegno,pincode,session,department,course) 
values('$studentregno','$pincode','$session','$dept','$course')");
    if ($ret) {
        $_SESSION['msg'] = "Enroll Successfully !!";
    } else {
        $_SESSION['msg'] = "Error : Not Enroll";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Course Enroll</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <link href="assets/css/style.css" rel="stylesheet"/>
</head>

<body>
<?php include('includes/header.php'); ?>
<!-- LOGO HEADER END-->
<?php if ($_SESSION['login'] != "") {
    include('includes/menubar.php');
}
?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Pre-registration </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Pre-registration
                    </div>
                    <font color="green"
                          align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                    <?php $sql = mysqli_query($con, "select * from students where StudentRegno='" . $_SESSION['login'] . "'");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($sql))
                    { ?>

                    <div class="panel-body">
                        <form name="dept" method="post" enctype="multipart/form-data">
                            <input id="selectSyllabus" type="hidden" value="<?php echo $_SESSION['level_id']; ?>" name="level_id"/>
                            <div class="form-group">
                                <label for="studentname">Student Name </label>
                                <input type="text" class="form-control" id="studentname" name="studentname"
                                       value="<?php echo htmlentities($row['studentName']); ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="studentregno">Student Reg No </label>
                                <input type="text" class="form-control" id="studentregno" name="studentregno"
                                       value="<?php echo htmlentities($row['StudentRegno']); ?>"
                                       placeholder="Student Reg no" readonly/>

                            </div>


                            <div class="form-group">
                                <label for="Pincode">Pincode </label>
                                <input type="text" class="form-control" id="Pincode" name="Pincode" readonly
                                       value="<?php echo htmlentities($row['pincode']); ?>" required/>
                            </div>
							
							<div class="form-group">
                                <label for="department"> </label>
                                <input type="hidden" class="form-control" id="department" name="department" 
                                       value="<?php echo htmlentities($row['department']); ?>" />
                            </div>


                            


                            <?php } ?>

                            <div class="form-group">
                                <label for="session">Sessoin </label>
                                <select id="selectSession" class="form-control" name="session" required="required"
                                        onchange="showCourses()">
                                    <option value="">Select Sessoin</option>
                                    <?php
                                    $sql = mysqli_query($con, "select sessions.id as id, sessions.year as ye, sessions.regiEndDate as endDate, department.department as dept, semester_name.semesterType as sems
from sessions join department on department.id=sessions.department_id
join semester_name on semester_name.id=sessions.semester_id");
                                    while ($row = mysqli_fetch_array($sql)) {
                                        ?>


                                        <option data-end="<?php echo htmlentities($row['endDate']) ?>"
                                                value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row["dept"] . "- " . $row["sems"] . " " . $row["ye"]); ?></option>
                                    <?php } ?>

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="Course">Course </label>
                                <select class="form-control" name="course" id="course" onchange="showCourseDetails()"
                                        onBlur="courseAvailability()"
                                        required="required">
                                    <option value="">Select Course</option>

                                </select>
                                <span id="course-availability-status1" style="font-size:12px;">
                            </div>

                            <div class="courseDetails form-group" style="display: none;">
                                <label for="Course">Course Name</label>
                                <input id="courseName" type="text" value="" readonly>
                                <label for="Course">Course Credit</label>
                                <input id="courseCredit" type="text" value="" readonly>
								
                            </div>


                            <button type="submit" name="submit" id="submit" class="btn btn-default">Submit Pre-Registration</button>
                            <p class="expireMsg lead text-danger small" style="margin-top: 1em; display: none">
                                Registration time for this session has been expired at <span id="time"></span></p>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>


</div>
</div>
<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery-1.11.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script>
    // Showing courses by syllabus
    function showCourses() {
        const today = new Date();
        const session = $("#selectSession").val();
        const syllabus = $("#selectSyllabus").val();
        const end = $("#selectSession").find(":selected").data("end");
        let endDate = today;
        if (session) {
            let endDateArray = end.split("-");
            endDate = new Date(endDateArray[0], endDateArray[1] - 1, endDateArray[2]);
        }
        if (session) {
            showHideElements(endDate, today);
        }
        if (session) {
            jQuery.ajax({
                url: "server-data.php?session=" + session + "&syllabus=" + syllabus,
                type: 'GET',
                cache: false,
                success: function (data) {
                    let html = '<option value="">Select Course</option>';
                    data.forEach(function (item) {
                        html += '<option value="' + item.id + '" data-credit="' + item.courseCredit + '" data-name="' + item.courseName + '">' + item.courseCodeValue + '</option>';
                    });
                    $("#course").html(html);
                },
                error: function (error) {
                    console.log("Error while fetching courses " + error);
                }
            });
        } else {
            $("#course").html("");
            console.log("Has noting");
        }
    }

    function getCurrentDate() {
        let date = new Date(), month = date.getMonth() + 1, day = date.getDate();
        return date.getFullYear() + '-' + (('' + month).length < 2 ? '0' : '') + month + '-' + (('' + day).length < 2 ? '0' : '') + day;
    }

    function showHideElements(endDate, today) {
        const button = $("#submit");
        const expireMsg = $(".expireMsg");
        const time = $("#time");
        if (endDate > today) {
            //button.show();
            time.html(endDate);
            expireMsg.hide();
            button.prop("disabled", false);
        } else {
            //button.hide();
            time.html(endDate);
            expireMsg.show();
            button.prop("disabled", true);
        }
    }

    function showCourseDetails() {
        const course = $("#course");
        const courseDetails = $(".courseDetails");
        const selectedCourse = $("#course").find(":selected");
        if (course.val()) {
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
<?php } ?>
