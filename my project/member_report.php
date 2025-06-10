<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIMS Dashboard Prototype</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* Basic Reset & Body Styles */
        body {
            margin: 0;
            font-family: 'Inter', sans-serif; /* Using Google Font */
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }

        /* Dashboard Container (Flexbox for Layout) */
        .dashboard-container {
            display: flex;
            min-height: 100vh; /* Full viewport height */
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50; /* Dark blue/grey */
            color: #ecf0f1; /* Light text */
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .club-logo {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .club-logo i {
            font-size: 28px;
            color: #1abc9c; /* Accent color */
        }

        .main-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1; /* Pushes user-info to bottom */
        }

        .main-nav li {
            margin-bottom: 10px;
        }

        .main-nav a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .main-nav a:hover,
        .main-nav a.active {
            background-color: #34495e;
            color: #1abc9c;
        }

        .main-nav a i {
            margin-right: 15px;
            font-size: 18px;
        }

        .user-info {
            margin-top: auto; /* Pushes it to the bottom of the sidebar */
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .user-info i {
            font-size: 36px;
            color: #ecf0f1;
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1; /* Takes up remaining space */
            padding: 30px;
            background-color: #f4f7f6;
            display: flex; /* Make main-content a flex container */
            flex-direction: column; /* Arrange content and footer vertically */
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 15px;
            color: #2c3e50;
        }

        .header-actions .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }
        .header-actions button a{
            text-decoration: none;
            color: white;
        }

        .btn i {
            margin-right: 8px;
        }

        .primary-btn {
            background-color: #1abc9c; /* Accent color */
            color: white;
        }

        .primary-btn:hover {
            background-color: #18a085;
        }

        .secondary-btn {
            background-color:rgb(247, 106, 81);
            color: #2c3e50;
            border: 1px solid #bdc3c7;
        }

        .secondary-btn:hover {
            background-color:rgb(243, 127, 127);
        }

        /* KPI Section */
        .kpi-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Responsive grid */
            gap: 20px;
            margin-bottom: 30px;
        }

        .kpi-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .kpi-icon {
            font-size: 40px;
            color: #1abc9c; /* Default icon color */
            opacity: 0.7;
        }

        /* Specific KPI card colors */
        .kpi-card:nth-child(1) .kpi-icon { color: #2ecc71; /* Green */ }
        .kpi-card:nth-child(2) .kpi-icon { color: #3498db; /* Blue */ }
        .kpi-card:nth-child(3) .kpi-icon { color: #e74c3c; /* Red */ }
        .kpi-card:nth-child(4) .kpi-icon { color: #f39c12; /* Orange */ }


        .kpi-details {
            display: flex;
            flex-direction: column;
        }
        .kpi-card:hover{
            transform: scale(0.9);
        }

        .kpi-value {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .kpi-title {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .kpi-trend {
            font-size: 12px;
            color: #95a5a6;
        }

        /* Main Widgets Section */
        .main-widgets {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            flex-grow: 1; /* Allow widgets section to grow and push footer down */
        }

        .widget {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            min-height: 200px; /* Base height */
        }

        .widget h2 {
            font-size: 20px;
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .large-widget {
            grid-column: span 2; /* Spans two columns on larger screens */
        }

        /* Placeholder for charts */
        .chart-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #95a5a6;
            font-style: italic;
            font-size: 14px;
            border: 1px dashed #ccc;
        }

        /* List styles for Recent Activity and Upcoming Events */
        .widget ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .widget ul li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }

        .widget ul li:last-child {
            border-bottom: none;
        }

        .widget ul li i {
            color: #1abc9c; /* Accent color for list icons */
        }

        /* Footer Styles */
        .dashboard-footer {
            margin-top: 30px; /* Space above the footer */
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9em;
        }

        /* --- Report Specific Styles --- */
        .report-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px; /* Space before footer */
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .report-header h1 {
            font-size: 24px;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .report-header h1 i {
            color: #1abc9c;
        }

        .back-button {
            background-color: #34495e; /* Darker blue/grey */
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background-color: #2c3e50;
        }

        .overflow-x-auto {
            overflow-x: auto; /* Ensures table is scrollable on small screens */
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Removes space between table cells */
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden; /* Ensures border-radius applies to table */
        }

        table thead tr {
            background-color: #f8f8f8; /* Light grey for header */
            border-bottom: 2px solid #e0e0e0;
        }

        table th,
        table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0; /* Lighter border for rows */
            font-size: 15px;
            color: #555;
        }

        table th {
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table tbody tr:hover {
            background-color: #f2fcfb; /* Very light accent on hover */
        }

        /* Action Buttons in table */
        .action-group {
            white-space: nowrap; /* Keep buttons on one line */
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-right: 8px; /* Space between buttons */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .action-button i {
            margin-right: 6px;
        }

        .action-button.delete {
            background-color: #e74c3c; /* Red */
            color: white;
        }

        .action-button.delete:hover {
            background-color: #c0392b;
        }

        .action-button.update {
            background-color: #3498db; /* Blue */
            color: white;
        }

        .action-button.update:hover {
            background-color: #2980b9;
        }

        /* Message styling */
        .message {
            margin-bottom: 20px;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message.success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column; /* Stack sidebar and main content */
            }

            .sidebar {
                width: 100%;
                height: auto; /* Allow height to adjust */
                padding: 15px;
                flex-direction: row; /* Layout for smaller screens */
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }

            .club-logo {
                margin-bottom: 0;
                font-size: 20px;
            }

            .main-nav {
                display: none; /* Hide main nav on small screens, could replace with a hamburger menu */
            }

            .user-info {
                display: none; /* Hide user info on small screens */
            }

            .main-content {
                padding: 20px;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .header-actions .btn {
                margin-left: 0; /* Remove left margin */
            }

            .kpi-section,
            .main-widgets {
                grid-template-columns: 1fr; /* Single column layout for all widgets */
            }

            .large-widget {
                grid-column: span 1; /* Reset span for single column */
            }

            .dashboard-footer {
                margin-top: 20px; /* Adjust margin for smaller screens */
                padding-top: 15px;
            }

            .report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            table th,
            table td {
                padding: 10px 15px; /* Adjust padding for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="club-logo">
                <i class="fas fa-users-cog"></i> <span>CIMS Admin</span>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="dashboard.php" ><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a href="member_report.php" class="active"><i class="fas fa-users"></i> Members</a></li>
                    <li><a href="clubs_report.php"><i class="fas fa-users"></i> Clubs</a></li>
                    <li><a href="activitys_report.php"><i class="fas fa-calendar-alt"></i> Activity</a></li>
                    <li><a href="leaders_report.php"><i class="fas fa-money-bill-wave"></i> Leaders</a></li>
                    <li><a href="logout.php"><i class="fas fa-cog"></i> Logout</a></li>
                </ul>
            </nav>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Admin User</span>
            </div>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <h1>Dashboard Overview</h1>
                <div class="header-actions">
                    <button class="btn primary-btn"><i class="fas fa-plus"></i> <a href="members.php">Add New Member</a></button>
                    
                    <button class="btn secondary-btn"><i class="fa fa-sign-out" aria-hidden="true"></i><a href="logout.php"> Logout</a></button>
                </div>
            </header>

            <?php
            // Start session to access messages
            // session_start(); // Uncomment this if not started elsewhere
            

            // Display success message if set in session
            $dashboard_message = '';
            if (isset($_SESSION['action_success_message'])) {
                $dashboard_message = $_SESSION['action_success_message'];
                unset($_SESSION['action_success_message']); // Clear the message after displaying
            }

            // You might want to add styling for this message
            if ($dashboard_message) {
                echo '<div class="message success-message">' . htmlspecialchars($dashboard_message) . '</div>';
            }
            ?>

            <div class="report-container">
                <header class="report-header">
                    <h1><i class="fas fa-calendar-alt"></i> Member Report Overview</h1>
                    <a href="dashboard.php" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </header>

                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Member Id</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Address</th>
                                <th>Club ID</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // PHP code for database connection and data retrieval
                            // Ensure 'db_connection.php' correctly establishes $conn
                            include 'db_connection.php';

                            // Check if $conn is set and valid before querying
                            if (isset($conn) && $conn) {
                                // Order by activityNo in descending order to show newest activities first
                                $query = mysqli_query($conn, "SELECT * FROM members ORDER BY memberId DESC");

                                if ($query) {
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($records = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($records['memberId']); ?></td>
                                                <td><?php echo htmlspecialchars($records['firstname']); ?></td>
                                                <td><?php echo htmlspecialchars($records['lastname']); ?></td>
                                                <td><?php echo htmlspecialchars($records['address']); ?></td>
                                                <td><?php echo htmlspecialchars($records['clubId']); ?></td>
                                                <td class="action-group">
                                                    <a href="./delete_member.php?delete_id=<?php echo $records['memberId']; ?>" class="action-button delete">
                                                        <i class="fas fa-trash-alt"></i> DELETE
                                                    </a>
                                                    <a href="./update_member.php?update_id=<?php echo $records['memberId']; ?>" class="action-button update">
                                                        <i class="fas fa-edit"></i> UPDATE
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' style='text-align: center; padding: 20px; color: #7f8c8d;'>No activities found.</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align: center; padding: 20px; color: #e74c3c;'>Error retrieving data: " . htmlspecialchars(mysqli_error($conn)) . "</td></tr>";
                                }
                                // Close connection after all queries are done
                                mysqli_close($conn);
                            } else {
                                echo "<tr><td colspan='4' style='text-align: center; padding: 20px; color: #e74c3c;'>Database connection not established.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <footer class="dashboard-footer">
                &copy; <?php echo date('Y'); ?> CIMS Dashboard. All rights reserved.
            </footer>
        </main>
    </div>
</body>
</html>