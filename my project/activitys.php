<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Activity</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #2c3e50;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }

        textarea,
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        button {
            background-color: #155724;
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
            background-color: #0e3c17;
        }

        .php-message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            font-weight: 600;
            text-align: center;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<?php
// Include database connection at the very top to prevent "headers already sent" errors
include 'db_connection.php';

// Initialize variables for messages
$message = '';
$message_type = ''; // 'error' or 'success'

if (!$conn) {
    die("<div class='php-message error-message'>Connection failed: " . mysqli_connect_error() . "</div>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $clubId = $_POST['clubId'];

    if (empty($description) || empty($clubId)) {
        $message = "Please fill all fields.";
        $message_type = 'error';
    } else {
        // Check if the clubId exists
        $check_club_sql = "SELECT * FROM clubs WHERE clubId = ?";
        $stmt_check = mysqli_prepare($conn, $check_club_sql);

        if ($stmt_check === false) {
            $message = 'Prepare failed for club check: ' . mysqli_error($conn);
            $message_type = 'error';
        } else {
            mysqli_stmt_bind_param($stmt_check, "i", $clubId);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            if (mysqli_num_rows($result_check) == 0) {
                $message = "Invalid clubId. The specified club does not exist.";
                $message_type = 'error';
            } else {
                // Insert the new activity
                $insert_sql = "INSERT INTO activities (description, clubId) VALUES (?, ?)";
                $stmt_insert = mysqli_prepare($conn, $insert_sql);

                if ($stmt_insert === false) {
                    $message = 'Prepare failed for activity insert: ' . mysqli_error($conn);
                    $message_type = 'error';
                } else {
                    mysqli_stmt_bind_param($stmt_insert, "si", $description, $clubId);

                    $insert_result = mysqli_stmt_execute($stmt_insert);

                    if ($insert_result) {
                        // Redirect on successful submission
                        header("Location: dashboard.php");
                        exit(); // Crucial to stop further script execution after redirect
                    } else {
                        $message = "Activity is not recorded.";
                        $message_type = 'error';
                    }
                    mysqli_stmt_close($stmt_insert);
                }
            }
            mysqli_stmt_close($stmt_check);
        }
    }
}
// Close the connection after all database operations for the page load are complete
mysqli_close($conn);
?>

<div class="form-container">
    <h2>Submit Your Activity Description</h2>

    <form action="activitys.php" method="post">
        <?php if ($message): ?>
            <div class="php-message <?php echo $message_type === 'error' ? 'error-message' : 'success-message'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="mb-8">
            <label for="description">Activity Description</label>
            <textarea
                id="description"
                name="description"
                rows="8"
                placeholder="Enter a detailed description of your activity here. What is it about? What are the key points?"
                aria-label="Activity Description"
            ></textarea>
        </div>

        <select name="clubId">
            <?php
            // Re-open connection for this part if needed, or better, pass results from above.
            // For simplicity and assuming typical page load, we'll re-open if needed.
            // In a larger app, you'd fetch clubs once and pass to display logic.
            include 'db_connection.php'; // Include again if connection was closed, or make connection global
            if ($conn) { // Check if connection is still valid
                $result = mysqli_query($conn, "SELECT clubId, clubName FROM clubs");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['clubId'] . "'>" . $row['clubName'] . "</option>";
                }
                mysqli_close($conn); // Close connection after fetching clubs
            }
            ?>
        </select><br><br>

        <div class="flex items-center justify-between">
            <button
                type="submit"
                aria-label="Submit Description"
            >
                Submit Description
            </button>
        </div>
    </form>
</div>
</body>
</html>