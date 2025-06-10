
<?php
include 'db_connection.php';

// receive data from form.....
$id=$_POST['id'];
$description=mysqli_real_escape_string($conn,$_POST['description']);
$clubId=$_POST['clubid'];


// Add datas in the database...
$query=mysqli_query($conn,"UPDATE activities SET  description='$description' WHERE activityNo=$id");
// check query.......
if($query){
header("location:./activitys_report.php");
}
else{
    echo"
    <script>
    alert('Failed to be inserted....')
    </script>
    ";
}

?>
