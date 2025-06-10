<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Minimal styles using only the requested color scheme */
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #2c3e50; /* Neutral background */
            margin: 0;
        }
        .form-container {
            background-color: #ffffff; /* White background for the form itself */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .form-container .my-button{
            background-color: transparent;
            color: black;
        }
        h2 {
            color: #333; /* Dark grey for headings */
            margin-bottom: 20px;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555; /* Slightly lighter grey for labels */
            font-weight: 600;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light grey border */
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #155724; /* Dark green, from success message text */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0e3c17; /* Darker green for hover */
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            font-weight: 600;
        }
        .error-message {
            background-color: #f8d7da; /* Light red, from error message background */
            color: #721c24; /* Dark red, from error message text */
            border: 1px solid #f5c6cb; /* Red border */
        }
        .success-message {
            background-color: #d4edda; /* Light green, from success message background */
            color: #155724; /* Dark green, from success message text */
            border: 1px solid #c3e6cb; /* Green border */
        }
    </style>
</head>
<body>
   
    <div class="form-container">
        <form id="registerForm" action="" method="POST">
            <h2>Admin Register</h2>
            <label for="regUsername">Username:</label>
            <input type="text" id="regUsername" name="userNames" placeholder="Enter username" required>

            <label for="regPassword">Password:</label>
            <input type="password" id="regPassword" name="Password" placeholder="Create a password" required><br>

            <button type="submit" name="register_submit">Register</button>

            <button class="my-button"><a href="login.php">Now you can login!</a></button> 
        </form>
    </div>

    
    <?php
    
    include 'db_connection.php';

    if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['userNames'];
    $password = $_POST['Password'];
    $hashpassword = password_hash($password,PASSWORD_DEFAULT);
    $insert = mysqli_query($conn,"INSERT INTO users VALUES(null,'$name','$hashpassword')");
    if($insert){
        header('location:login.php');
    }
    }
    
    ?>

</body>
</html>