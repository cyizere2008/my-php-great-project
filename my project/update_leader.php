
<?php
include 'db_connection.php';


// receive data from form.....
$leaderId=$_POST['leaderId'];
$firstname=$_POST['firstname'];
$lastname=mysqli_real_escape_string($conn,$_POST['lastname']);
$position = $_POST['position'];
$clubId=$_POST['clubid'];
$memberid = $_POST['memberid'];


// Add datas in the database...
$query=mysqli_query($conn,"UPDATE leaders SET  firstname='$firstname', lastname= '$lastname', position='$position', clubId='$clubId', memberId='$memberid' WHERE leaderId=$leaderId");
// check query.......
if($query){
header("location:./leaders_report.php");
}
else{
    echo"
    <script>
    alert('Failed to be inserted....')
    </script>
    ";
}

?>
