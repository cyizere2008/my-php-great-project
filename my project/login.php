<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Minimal styles using only the requested color scheme */
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #2c3e50; /* Neutral background, similar to previous */
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
    <?php
    session_start();

    include 'db_connection.php';

   

    $loginError = '';
    $loginSuccess = '';

    // Handle Login Form Submission
    if (isset($_POST['login_submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['userNames']);
        $password = mysqli_real_escape_string($conn, $_POST['Password']);

        $sql = "SELECT * FROM users WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['userId'] = $user['UserId'];
                $_SESSION['Usernames'] = $user['UserNames'];
                $loginSuccess = "Login successful. Welcome, " . htmlspecialchars($user['UserNames']) . "!";
                header("Location: dashboard.php");
                exit();
            } else {
                $loginError = "Invalid password.";
            }
        } else {
            $loginError = "No account found with that username.";
        }
    }

    mysqli_close($conn);
    ?>

    <div class="form-container">
        <form id="loginForm" action="" method="POST">
            <h2>Admin Login</h2>

            <label for="loginUsername">Username:</label>
            <input type="text" id="loginUsername" name="userNames" placeholder="Enter your username" required><br><br>

            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="Password" placeholder="Enter your password" required><br><br>

            <button type="submit" name="login_submit">Login</button><br><br>   
            <button class="my-button"><a href="insert.php">Don't have an account? Register</a></button> 
        </form>
    </div>
</body>
</html>