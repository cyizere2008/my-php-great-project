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
                    <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a href="member_report.php"><i class="fas fa-users"></i> Members</a></li>
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
            //  session_start(); // Uncomment this if not started elsewhere
            
            // Display success message if set in session
            $dashboard_message = '';
            if (isset($_SESSION['action_success_message'])) {
                $dashboard_message = $_SESSION['action_success_message'];
                unset($_SESSION['action_success_message']); // Clear the message after displaying
            }

            // You might want to add styling for this message
            if ($dashboard_message) {
                echo '<div class="message success-message" style="margin-bottom: 20px; padding: 10px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">' . htmlspecialchars($dashboard_message) . '</div>';
            }
            ?>

            <section class="kpi-section">
                <?php
                // Ensure db_connection.php is included only once and $conn is available
                // If it's already included at the very top of the PHP script, you can remove this include statement.
                // Assuming this entire PHP block is within the dashboard.php file.
                if (!isset($conn)) {
                    include 'db_connection.php';
                }

                // Check if connection is successful before querying
                if (isset($conn) && $conn) {
                    // Total Members
                    $select_members = mysqli_query($conn, "SELECT COUNT(*) AS total_members FROM members");
                    $row_member = mysqli_fetch_assoc($select_members);
                    $select_member = $row_member['total_members'];

                    // Total Users
                    $select_users = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
                    $row_users = mysqli_fetch_assoc($select_users);
                    $select_row = $row_users['total_users'];

                    // Total Activities
                    $select_activities_count = mysqli_query($conn, "SELECT COUNT(*) AS total_activities FROM activities");
                    $row_activity = mysqli_fetch_assoc($select_activities_count);
                    $select_activity = $row_activity['total_activities'];

                    // Total Leaders
                    $select_leaders = mysqli_query($conn, "SELECT COUNT(*) AS total_leaders FROM leaders");
                    $row_leader = mysqli_fetch_assoc($select_leaders);
                    $select_leader = $row_leader['total_leaders'];

                    // Recent Members
                    $recent_members = mysqli_query($conn, "SELECT * FROM members ORDER BY memberId DESC LIMIT 4"); // Changed to DESC to show latest

                    // Recent Activities
                    $recent_activities = mysqli_query($conn, "SELECT * FROM activities ORDER BY activityNO DESC LIMIT 3"); // Changed to DESC
                    
                    // Close connection after all queries are done
                    mysqli_close($conn);
                } else {
                    // Handle case where database connection failed
                    $select_member = $select_row = $select_activity = $select_leader = "N/A";
                    $recent_members = false; // Indicate no results
                    $recent_activities = false; // Indicate no results
                    echo '<p class="message error-message" style="margin-bottom: 20px; padding: 10px; border-radius: 5px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">Error: Could not connect to database for dashboard data.</p>';
                }
                ?>
                
                

                <div class="kpi-card">
                    <div class="kpi-icon"><i class="fas fa-users"></i></div>
                    <div class="kpi-details" data-registered="2023-10-24T14:30:00Z" id="user_info">
                        <span class="kpi-value"><?php echo $select_member?></span>
                        <span class="kpi-title">Total Members</span>
                        <span class="kpi-trend">Active Member</span>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon"><i class="fas fa-calendar-alt"></i></div> <div class="kpi-details" data-registered="2023-10-24T14:30:00Z" id="user_info">
                        <span class="kpi-value"><?php echo $select_activity?></span>
                        <span class="kpi-title">Total Activities</span>
                        <span class="kpi-trend">Active Activities</span>
                    </div>
                </div>
                
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="fas fa-user-tie"></i></div> <div class="kpi-details" data-registered="2023-10-24T14:30:00Z" id="user_info">
                        <span class="kpi-value"><?php echo $select_leader?></span>
                        <span class="kpi-title">Total Leaders</span>
                        <span class="kpi-trend">Active Leaders</span>
                    </div>
                </div>
            </section>

            <div class="header-actions" style="justify-content: flex-start; margin-bottom: 20px;">
                <button class="btn primary-btn"><i class="fas fa-plus"></i> <a href="leader.php">Add New Leader</a></button>
                <button class="btn primary-btn" style="background-color: #e67e22;"><i class="fas fa-plus"></i> <a href="activitys.php">Add New Activity</a></button>
                <button class="btn primary-btn"><i class="fas fa-plus"></i> <a href="clubs.html">Add New club</a></button>
            </div>

            <section class="main-widgets">
                <div class="widget medium-widget">
                    <h2>Recent Members</h2>
                    <?php if ($recent_members && mysqli_num_rows($recent_members) > 0) : ?>
                        <ul>
                            <?php while($recent = mysqli_fetch_assoc($recent_members)) : ?>
                                <li><i class="fas fa-user-plus"></i> <?php echo htmlspecialchars($recent['firstname'] . ' ' . $recent['lastname']); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else : ?>
                        <p style="text-align: center; color: #7f8c8d;">No recent members to display.</p>
                    <?php endif; ?>
                </div>

                <div class="widget medium-widget">
                    <h2>Recent Activities</h2>
                    <?php if ($recent_activities && mysqli_num_rows($recent_activities) > 0) : ?>
                        <ul>
                            <?php while($activity = mysqli_fetch_assoc($recent_activities)) : ?>
                                <li><i class="fas fa-calendar-check"></i> <?php echo htmlspecialchars($activity['description']); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else : ?>
                        <p style="text-align: center; color: #7f8c8d;">No recent activities to display.</p>
                    <?php endif; ?>
                </div>
            </section>

            <footer class="dashboard-footer">
                &copy; <?php echo date('Y'); ?> CIMS Dashboard. All rights reserved.
            </footer>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname.split('/').pop(); // Gets the filename (e.g., "dashboard.php")
            const navLinks = document.querySelectorAll('.main-nav a');

            navLinks.forEach(link => {
                const linkHref = link.getAttribute('href');
                if (linkHref === currentPath) {
                    link.classList.add('active');
                } else if (currentPath === '' && linkHref === 'dashboard.php') {
                    // Handle case where base URL might go to dashboard
                    link.classList.add('active');
                } else {
                    link.classList.remove('active'); // Ensure other links are not active
                }
            });
        });
    </script>
</body>
</html>