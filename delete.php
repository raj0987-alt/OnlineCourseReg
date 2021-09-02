<?php
session_start();
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

?>

<?php
if(isset($_GET['did'])) {
    $delete_id = mysql_real_escape_string($_GET['did']);
    $sql = mysql_query("DELETE FROM courseenrolls WHERE id = '".$delete_id."'");
    if($sql) {
      header('location:enroll-history.php');
    } else {
        echo "ERROR";
    }
}
?>
<?php } ?>