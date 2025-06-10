<?php

include 'db_connection.php';

$delete_id=$_GET['delete_id'];
$query=mysqli_query($conn,"DELETE FROM activities WHERE activityNo=$delete_id");
if($query){
    header("location:./activitys_report.php");
}

else{
    echo"
    <script> alert('Failed To delete')</script>
    ";
}    ?>
?>