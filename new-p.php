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

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Enrollment Print</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:20px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:18px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:10px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:30px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
<?php
$cid=intval($_GET['id']);
$sql=mysqli_query($con,"select courses.courseName as courname,courses.courseCode as ccode,courses.courseCredit as cunit,
department.department as dept,level.level as level,courseenrolls.enrollDate as edate,
students.studentName as studentname,students.studentPhoto as photo,
students.creationdate as studentregdate, courses.courseCodeValue as courseCode, courseenrolls.status as st 
from courseenrolls 
join courses on courses.id=courseenrolls.course  
join level on level.id=courses.level
join students on students.StudentRegno=courseenrolls.StudentRegno
JOIN department on department.id=level.department
where courseenrolls.studentRegno='".$_SESSION['login']."'
AND courseenrolls.status='approved'");
$cnt=1;?>
<b> Reg No: </b><?php echo htmlentities($_SESSION['login']);?><br>
                               
<?php  while($row=mysqli_fetch_array($sql))
{?>



        <table cellpadding="0" cellspacing="0">
            
      
            <tr class="heading">
                <td>
                   Course Details
                </td>
                
                <td>
                   
                </td>
            </tr>
            
            <tr class="details">
                <td>
                  Course Code
                </td>
                
                <td>
                  <?php echo htmlentities($row['courseCode']);?>
                </td>
            </tr>

            <tr class="details">
                <td>
                  Course Name
                </td>
                
                <td>
                  <?php echo htmlentities($row['courname']);?>
                </td>
            </tr>


            <tr class="details">
                <td>
                  Course Credit
                </td>
                
                <td>
                  <?php echo htmlentities($row['cunit']);?>
                </td>
            </tr>
			
			
            
            
         
        </table>
        <?php } ?>
    </div>
	 <button class="print_btn" onclick="window.print()">Print</button>
</body>
</html>
<?php } ?>