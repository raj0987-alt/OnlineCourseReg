   <?php 
   include('includes/config.php');
$level=$_POST['dept_level']; 
$sql=mysqli_query($con,"select * from advisors where DeptId='$level'");
while($row=mysqli_fetch_array($sql))
{
?>
<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['AdvisorId']);?></option>
<?php } ?>