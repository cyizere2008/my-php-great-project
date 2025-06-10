<?php

include 'db_connection.php';

$delete_id=$_GET['delete_id'];
$query=mysqli_query($conn,"DELETE FROM leaders WHERE leaderId=$delete_id");
if($query){
    header("location:./leaders_report.php");
}

else{
    echo"
    <script> alert('Failed To delete')</script>
    ";
}    ?>
?>