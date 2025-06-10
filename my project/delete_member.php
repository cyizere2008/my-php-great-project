<?php


include 'db_connection.php';

$delete_id=$_GET['delete_id'];
$query=mysqli_query($conn,"DELETE FROM members WHERE memberId =$delete_id");
if($query){
    header("location:./member_report.php");
}

else{
    echo"
    <script> alert('Failed To delete')</script>
    ";
}    
?>