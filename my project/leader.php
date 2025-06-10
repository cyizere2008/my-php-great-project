<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leader Registration Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Styles copied and adapted from your Admin Login page */
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #2c3e50; /* Background from login page */
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .form-container {
            background-color: #ffffff; /* White background for the form */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px; /* Increased max-width slightly for the longer form */
            text-align: center;
        }
        .form-container .my-button {
            background-color: transparent;
            color: black;
            border: 1px solid #ddd; /* Added a light border for visibility */
            margin-top: 10px;
        }
        .form-container .my-button a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
        }
        h2 {
            color: #333; /* Dark grey for headings */
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555; /* Slightly lighter grey for labels */
            font-weight: 600;
        }
        input[type="text"],
        input[type="password"],
        select { /* Added 'select' to style dropdowns consistently */
            width: 100%; /* Changed from calc() to 100% for better alignment */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light grey border */
            border-radius: 4px;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif; /* Ensure font is inherited */
        }
        button {
            background-color: #155724; /* Dark green from login button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        button:hover {
            background-color: #0e3c17; /* Darker green for hover */
        }
        .message {
            margin-top: 15px; /* Changed from margin-bottom to top */
            padding: 10px;
            border-radius: 4px;
            font-weight: 600;
            text-align: center;
        }
        .error-message {
            background-color: #f8d7da; /* Light red for error */
            color: #721c24; /* Dark red for error text */
            border: 1px solid #f5c6cb;
        }
        .success-message {
            background-color: #d4edda; /* Light green for success */
            color: #155724; /* Dark green for success text */
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register Your Team Leaders</h2>

        <form action="" method="post">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstname" required>
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastname" required>
                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>
                <label for="clubId">Club</label>
                <select id="clubId" name="clubId" required>
                    <?php
                    include 'db_connection.php';
                    $result = mysqli_query($conn, "SELECT clubId, clubName FROM clubs");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['clubId']) . "'>" . htmlspecialchars($row['clubName']) . "</option>";
                    }
                    // Connection closed in the logic below
                    ?>
                </select>
                <label for="memberId">Member</label>
                <select id="memberId" name="memberId" required>
                    <?php
                    // Re-include for this block or ensure connection is persistent
                    include 'db_connection.php';
                    $result = mysqli_query($conn, "SELECT memberId, firstname FROM members");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['memberId']) . "'>" . htmlspecialchars($row['firstname']) . "</option>";
                    }
                    // Connection closed in the logic below
                    ?>
                </select>

            <button type="submit">Register Leader</button>

            </button>
        </form>

        <?php
        // PHP logic remains the same, but echoes are now styled divs
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'db_connection.php';

            if (!$conn) {
                echo "<div class='message error-message'>Connection failed: " . mysqli_connect_error() . "</div>";
            } else {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $position = $_POST['position'];
                $clubId = $_POST['clubId'];
                $memberId = $_POST['memberId'];

                if (empty($firstname) || empty($lastname) || empty($position) || empty($clubId) || empty($memberId)) {
                    echo "<div class='message error-message'>Please fill all fields.</div>";
                } else {
                    // Using prepared statements for security
                    $insert_sql = "INSERT INTO leaders (firstname, lastname, position, clubId, memberId) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $insert_sql);
                    
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "sssii", $firstname, $lastname, $position, $clubId, $memberId);
                        if (mysqli_stmt_execute($stmt)) {
                            echo "<div class='message success-message'>Leader registered successfully.</div>";
                        } else {
                            echo "<div class='message error-message'>Error: Leader not registered.</div>";
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<div class='message error-message'>Database error.</div>";
                    }
                }
                mysqli_close($conn);
            }
        }
        ?>
    </div>
</body>
</html>