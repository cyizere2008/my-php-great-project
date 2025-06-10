<?php

include 'db_connection.php';

if($_SERVER ['REQUEST_METHOD'] = 'POST'){

    $clubname = $_POST['clubname'];

    $sql = "INSERT INTO clubs(clubName)  VALUES ('$clubname')";

    $result = mysqli_query($conn, $sql);


    if(!$result){
        echo ' clubs is not registered';
    }
    else{
        header('location:dashboard.php');
    }
}

mysqli_close($conn);

?>