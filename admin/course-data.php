<?php
session_start();
include('includes/config.php');

if (isset($_GET["code"])) {
    // fetching the available courses depending on the selected syllabus
    $code = $_GET['code'];
    
    $data = array();
    $sql = mysqli_query($con, "select * from syllabuses where courseCode = '$code'");

    while ($row = mysqli_fetch_array($sql)) {
        $data[] = array(
            "id" => $row["id"],
            "courseCode" => $row["courseCode"],
            "courseName" => $row["courseName"],
			"courseCredit" => $row["courseCredit"]
        );
    }
    header('Content-type: application/json');
    echo json_encode($data);
}