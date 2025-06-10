
<?php
include 'db_connection.php';


// receive data from form.....
$memberId=$_POST['memberId'];
$firstname=$_POST['firstname'];
$lastname=mysqli_real_escape_string($conn,$_POST['lastname']);
$address = $_POST['address'];
$clubId=$_POST['clubid'];


// Add datas in the database...
$query=mysqli_query($conn,"UPDATE members SET  firstname='$firstname', lastname= '$lastname', address='$address', clubId='$clubId' WHERE memberId=$memberId");
// check query.......
if($query){
header("location:./member_report.php");
}
else{
    echo"
    <script>
    alert('Failed to be inserted....')
    </script>
    ";
}

?>
