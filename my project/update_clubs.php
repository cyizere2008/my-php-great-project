
<?php
include 'db_connection.php';

// receive data from form.....
$clubId=$_POST['clubId'];
$clubname=mysqli_real_escape_string($conn,$_POST['clubname']);


// Add datas in the database...
$query=mysqli_query($conn,"UPDATE clubs SET  clubname='$clubname' WHERE clubId=$clubId");
// check query.......
if($query){
header("location:./clubs_report.php");
}
else{
    echo"
    <script>
    alert('Failed to be inserted....')
    </script>
    ";
}

?>
