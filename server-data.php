<?php
session_start();
include('includes/config.php');

if (isset($_GET["session"]) && isset($_GET["syllabus"])) {
    // fetching the available courses depending on the selected syllabus
    $session = $_GET['session'];
    $syllabus = $_GET['syllabus'];
    $data = array();
    $sql = mysqli_query($con, "select * from courses where session_id = '$session' AND level = '$syllabus'");

    while ($row = mysqli_fetch_array($sql)) {
        $data[] = array(
            "id" => $row["id"],
            "courseCode" => $row["courseCode"],
            "courseName" => $row["courseName"],
			"courseCredit" => $row["courseCredit"],
			"courseCodeValue" => $row["courseCodeValue"],
			
        );
    }
    header('Content-type: application/json');
    echo json_encode($data);
}