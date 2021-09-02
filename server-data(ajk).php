<?php
session_start();
include('includes/config.php');

if (isset($_GET["session"]) && isset($_GET["syllabus"])) {
    // fetching the available courses depending on the selected syllabus
    $session = $_GET['session'];
    $syllabus = $_GET['syllabus'];
    $data = array();
    $sql = mysqli_query($con, "select  from courses where session_id = '$session' AND level = '$syllabus'");
    // $sql = mysqli_query($con, "select courses.id as id, courses.session_id as session_id, courses.level as level, 
	// courses.courseCredit as courseCredit, courses.courseName as courseName, syllabuses.courseCode as courseCode from courses 
	// join syllabuses on syllabuses.id = courses.courseCode
	// where session_id = '$session' AND level = '$syllabus'");

    while ($row = mysqli_fetch_array($sql)) {
        $data[] = array(
            "id" => $row["id"],
			//"department"=> $row["department"],
            "courseCode" => $row["courseCode"],
            "courseName" => $row["courseName"],
			"courseName" => $row["courseCredit"],
        );
    }
    header('Content-type: application/json');
    echo json_encode($data);
}