<?php
// add_member.php - Styled to look like the Admin Login page, with redirection to dashboard on success

session_start(); // Start the session if not already started

// Initialize message variables
$message = '';
$message_type = ''; // 'success' or 'error'

// Include database connection file
if (file_exists('db_connection.php')) {
    include 'db_connection.php';
} else {
    $message = "Error: 'db_connection.php' not found. Cannot connect to database.";
    $message_type = 'error';
    // In a real application, you might redirect to an error page or log this.
    // die($message);
}

// PHP logic for form submission and member insertion
if (isset($conn) && $conn && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data safely using mysqli_real_escape_string
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $clubId = $_POST['clubId']; // This should be an integer

    // Basic validation
    if (empty($firstname) || empty($lastname) || empty($address) || empty($clubId)) {
        $message = "Please fill all fields.";
        $message_type = 'error';
    } else {
        // Check if the clubId exists
        $check_club_sql = "SELECT clubId FROM clubs WHERE clubId = ?";
        $stmt_check = mysqli_prepare($conn, $check_club_sql);

        if ($stmt_check === false) {
            $message = 'Database prepare failed for club check: ' . mysqli_error($conn);
            $message_type = 'error';
        } else {
            mysqli_stmt_bind_param($stmt_check, "i", $clubId);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            if (mysqli_num_rows($result_check) == 0) {
                $message = "Invalid club selected. The specified club does not exist.";
                $message_type = 'error';
            }
            mysqli_stmt_close($stmt_check); // Close the check statement
        }

        // If no errors so far, proceed with insertion
        if ($message_type !== 'error') {
            // Insert the new member
            $insert_sql = "INSERT INTO members (firstname, lastname, address, clubId) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_sql);

            if ($stmt_insert === false) {
                $message = 'Database prepare failed for member insertion: ' . mysqli_error($conn);
                $message_type = 'error';
            } else {
                mysqli_stmt_bind_param($stmt_insert, "sssi", $firstname, $lastname, $address, $clubId);
                $insert_result = mysqli_stmt_execute($stmt_insert);

                if ($insert_result) {
                    // --- REDIRECTION LOGIC UPDATED HERE ---
                    $_SESSION['action_success_message'] = "Member '" . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "' registered successfully.";
                    header("Location: dashboard.php"); // Redirect to the dashboard page
                    exit(); // Always call exit() after header() for immediate redirection
                    // --- END REDIRECTION LOGIC ---
                } else {
                    $message = "Failed to register member: " . mysqli_error($conn);
                    $message_type = 'error';
                }
                mysqli_stmt_close($stmt_insert);
            }
        }
    }
} else if (!isset($conn) || !$conn) {
    // If $conn is not set or failed to connect, ensure an error message is set for the initial page load
    if (empty($message)) {
        $message = "Failed to establish database connection for form processing.";
        $message_type = 'error';
    }
}

// Close the connection if it was successfully opened
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Styles to match the Admin Login form */
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #2c3e50; /* Matches login background */
            margin: 0;
        }
        .form-container {
            background-color: #ffffff; /* White background for the form itself */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Same max-width as login form */
            text-align: center;
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
        input[type="password"], /* Included for consistency, though not used here */
        textarea, /* For the address field */
        select { /* For the club dropdown */
            width: calc(100% - 20px); /* Account for padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light grey border */
            border-radius: 4px;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif; /* Ensure Inter font for inputs too */
            color: #333; /* Default text color for inputs */
            background-color: #fff; /* Ensure white background for inputs/select */
        }
        textarea {
            resize: vertical; /* Allow vertical resizing for address */
        }
        select {
            appearance: none; /* Remove default select arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="%23555" d="M7 10l5 5 5-5z"/></svg>'); /* Custom arrow matching label color */
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #155724; /* Dark green, from success message text */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* Space from last input */
        }
        button[type="submit"]:hover {
            background-color: #0e3c17; /* Darker green for hover */
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            font-weight: 600;
            text-align: center;
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

        /* Styling for the "View members" link section to match login's "Register" link vibe */
        .link-section {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #555; /* Match label text color */
        }
        .link-section a {
            color: #007bff; /* A standard blue, common for links */
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .link-section a:hover {
            color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>

<div class="form-container"> <form id="addMemberForm" action="" method="post">
        <h2>Add Member</h2>

        <?php
        // Display messages at the top of the form (only if no redirect happened)
        if ($message) {
            echo '<p class="message ' . htmlspecialchars($message_type) . '-message">' . htmlspecialchars($message) . '</p>';
        }
        ?>

        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstname" placeholder="Enter first name" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastname" placeholder="Enter last name" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3" placeholder="Enter member's address" required></textarea>
        </div>

        <div class="form-group">
            <label for="clubId">Select Club:</label>
            <select id="clubId" name="clubId" required>
                <?php
                // PHP logic to fetch clubs dynamically
                // Re-establish connection for fetching clubs if it was closed or failed previously
                $conn_fetch_clubs = null;
                if (file_exists('db_connection.php')) {
                    include 'db_connection.php'; // Re-include to get $conn
                    $conn_fetch_clubs = $conn;
                }

                if (isset($conn_fetch_clubs) && $conn_fetch_clubs) {
                    $result = mysqli_query($conn_fetch_clubs, "SELECT clubId, clubName FROM clubs ORDER BY clubName ASC");
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['clubId']) . "'>" . htmlspecialchars($row['clubName']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>No clubs found</option>";
                        }
                    } else {
                        echo "<option value=''>Error fetching clubs</option>";
                    }
                    // Close connection used for fetching clubs
                    if (isset($conn_fetch_clubs) && $conn_fetch_clubs) {
                        mysqli_close($conn_fetch_clubs);
                    }
                } else {
                     echo "<option value=''>Database connection error</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit">Add Member</button>

       
    </form>
</div>

</body>
</html>