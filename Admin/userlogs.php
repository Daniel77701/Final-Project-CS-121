<?php

session_start();
require_once '../connection/dbh.classes.php';
require_once '../classes/LoginTracker.php';

$loginTracker = new LoginTracker();
$db = new Dbh();
$conn = $db->connect();

if (!isset($_SESSION['last_activity_check'])) {
    $_SESSION['last_activity_check'] = time();
}

function updateActiveSessions($loginTracker, $conn) {
    $query = "SELECT ul.*, s.name, s.sr_code 
              FROM user_logs ul
              JOIN students s ON s.id = ul.student_id
              WHERE ul.logout_time IS NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $activeSessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($activeSessions as $session) {
        $duration = time() - strtotime($session['login_time']);
        $query = "UPDATE user_logs SET duration = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$duration, $session['id']]);
    }
}

function cleanupStaleSessions($conn) {
    try {
        $query = "UPDATE user_logs 
                 SET logout_time = NOW(), 
                     duration = TIMESTAMPDIFF(SECOND, login_time, NOW())
                 WHERE logout_time IS NULL 
                 AND TIMESTAMPDIFF(HOUR, login_time, NOW()) > 24";
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        error_log("Cleaned up " . $stmt->rowCount() . " stale sessions");
    } catch (PDOException $e) {
        error_log("Error cleaning stale sessions: " . $e->getMessage());
    }
}

cleanupStaleSessions($conn);

updateActiveSessions($loginTracker, $conn);

// Update the query to join with the correct student record
$query = "SELECT 
    ul.id, 
    ul.login_time, 
    ul.logout_time, 
    ul.duration,
    ul.student_id,
    s.sr_code,
    s.name,
    CASE 
        WHEN ul.logout_time IS NULL THEN 'Active'
        ELSE 'Completed'
    END as status
    FROM user_logs ul
    LEFT JOIN students s ON s.id = ul.student_id
    WHERE ul.student_id IS NOT NULL
    ORDER BY ul.login_time DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$statsQuery = "SELECT 
    COUNT(DISTINCT student_id) as total_students,
    COUNT(*) as total_sessions,
    SEC_TO_TIME(AVG(duration)) as avg_duration
    FROM user_logs 
    WHERE logout_time IS NOT NULL";
$statsStmt = $conn->query($statsQuery);
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

error_log("Total Students: " . $stats['total_students']);
error_log("Total Sessions: " . $stats['total_sessions']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/userlogs.css">

</head>
<body>
    <!-- Header Section -->
    <header id="header">
        <div class="logo">
            <img src="icons_admin/logo.png" alt="Logo" width="40">
            <span>Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center">
            <span class="ml-4">Welcome, Admin</span>
            <i class="fas fa-user ml-2"></i>
            <a href="settings.php">
                <img src="icons_admin/white_settings.png" alt="Settings Icon" style="width: 30px; height: 30px; margin-left: 10px;">
            </a> 
        </div>
    </header>

    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="schema.php"><img src="icons_admin/view schema.png" alt="Schema Icon"> Schema</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.php"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link active" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>
    
    <main>
        <div class="title-box">
            <h1>User Logs</h1>
            <div class="right-content">
                <div class="button-group">
                    <button class="delete" id="deleteSelected">Delete Selected</button>
                    <button class="print" onclick="printTable()">
                        <i class="fas fa-print"></i> Print Logs
                    </button>
                </div>
                <div class="stats-group">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="card-title">Total Students</div>
                            <div class="card-text"><?php echo $stats['total_students']; ?></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="card-title">Total Sessions</div>
                            <div class="card-text"><?php echo $stats['total_sessions']; ?></div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="card-title">Average Duration</div>
                            <div class="card-text"><?php echo $stats['avg_duration']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-container">
            <div class="search-container">
                <label for="search">Search:</label>
                <input type="text" id="search" placeholder="Search...">
            </div>
        </div>

        <div class="table-box">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="logsTable">
                    <thead class="thead-dark">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>SR Code</th>
                            <th>Name</th>
                            <th>Login Time</th>
                            <th>Logout Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): 
                                $duration = $loginTracker->formatDuration($log['duration'] ?? 0);
                            ?>
                                <tr>
                                    <td><input type="checkbox" class="log-checkbox" value="<?php echo $log['id']; ?>"></td>
                                    <td><?php echo htmlspecialchars($log['sr_code']); ?></td>
                                    <td><?php echo htmlspecialchars($log['name']); ?></td>
                                    <td><?php echo date('M d, Y h:i A', strtotime($log['login_time'])); ?></td>
                                    <td><?php echo $log['logout_time'] ? date('M d, Y h:i A', strtotime($log['logout_time'])) : 'Active'; ?></td>
                                    <td><?php echo $duration; ?></td>
                                    <td>
                                        <span class="badge <?php echo $log['status'] === 'Active' ? 'badge-success' : 'badge-secondary'; ?>">
                                            <?php echo $log['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No logs found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Existing scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    <!-- Add new script for functionality -->
    <script>
        $(document).ready(function() {
            // Enhanced search functionality
            $("#search").on("keyup", function() {
                var searchText = $(this).val().toLowerCase();
                var noResults = true;
                
                $("#logsTable tbody tr").each(function() {
                    var srCode = $(this).find("td:eq(1)").text().toLowerCase();
                    var name = $(this).find("td:eq(2)").text().toLowerCase();
                    var loginTime = $(this).find("td:eq(3)").text().toLowerCase();
                    var logoutTime = $(this).find("td:eq(4)").text().toLowerCase();
                    var duration = $(this).find("td:eq(5)").text().toLowerCase();
                    
                    if (srCode.includes(searchText) || 
                        name.includes(searchText) || 
                        loginTime.includes(searchText) ||
                        logoutTime.includes(searchText) ||
                        duration.includes(searchText)) {
                        $(this).show();
                        noResults = false;
                    } else {
                        $(this).hide();
                    }
                });
                
                // Show/hide "No results found" message
                if (noResults) {
                    if ($("#no-results-message").length === 0) {
                        $("#logsTable tbody").append(
                            '<tr id="no-results-message">' +
                            '<td colspan="6" class="text-center">' +
                            'No matching records found' +
                            '</td></tr>'
                        );
                    }
                } else {
                    $("#no-results-message").remove();
                }
            });

            // Clear search when the input is cleared
            $("#search").on("search", function() {
                if ($(this).val() === "") {
                    $("#logsTable tbody tr").show();
                    $("#no-results-message").remove();
                }
            });

            // Select all checkbox
            $("#selectAll").change(function() {
                $(".log-checkbox").prop('checked', $(this).prop('checked'));
            });

            // Delete selected logs
            $("#deleteSelected").click(function() {
                if(confirm('Are you sure you want to delete the selected logs?')) {
                    var selectedLogs = [];
                    $('.log-checkbox:checked').each(function() {
                        selectedLogs.push($(this).val());
                    });

                    if(selectedLogs.length > 0) {
                        $.ajax({
                            url: '../includes/delete_logs.php',
                            type: 'POST',
                            data: {logs: selectedLogs},
                            success: function(response) {
                                try {
                                    const result = JSON.parse(response);
                                    if (result.success) {
                                        location.reload();
                                    } else {
                                        alert('Error: ' + (result.error || 'Unknown error occurred'));
                                    }
                                } catch (e) {
                                    alert('Error processing server response');
                                }
                            },
                            error: function() {
                                alert('Error connecting to server');
                            }
                        });
                    }
                }
            });
        });
    </script>

    <script>
    function updateActiveDurations() {
        $('.table-active').each(function() {
            const row = $(this);
            const loginTime = new Date(row.find('.duration').data('login-time')).getTime();
            const now = new Date().getTime();
            const durationSeconds = Math.floor((now - loginTime) / 1000);
            
            // Format duration
            let duration = '';
            if (durationSeconds < 60) {
                duration = durationSeconds + ' seconds';
            } else if (durationSeconds < 3600) {
                duration = Math.floor(durationSeconds / 60) + ' minutes';
            } else if (durationSeconds < 86400) {
                const hours = Math.floor(durationSeconds / 3600);
                const minutes = Math.floor((durationSeconds % 3600) / 60);
                duration = hours + ' hours ' + minutes + ' minutes';
            } else {
                const days = Math.floor(durationSeconds / 86400);
                const hours = Math.floor((durationSeconds % 86400) / 3600);
                duration = days + ' days ' + hours + ' hours';
            }
            
            row.find('.duration').text('Active (' + duration + ')');
        });
    }

    // Update active sessions every 30 seconds
    setInterval(updateActiveDurations, 30000);
    updateActiveDurations(); // Initial update

    // Refresh the page every 5 minutes to catch any new sessions
    setInterval(() => {
        location.reload();
    }, 300000);
    </script>

    <script>
    function printTable() {
        // Create a window for printing
        const printWindow = window.open('', '_blank');
        
        // Add the content to be printed
        printWindow.document.write(`
            <html>
            <head>
                <title>User Logs Report</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <style>
                    body { padding: 20px; }
                    .stats-container {
                        display: flex;
                        justify-content: space-around;
                        margin-bottom: 20px;
                    }
                    .stat-item {
                        text-align: center;
                        padding: 10px;
                    }
                    .table { margin-top: 20px; }
                    @media print {
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <h2 class="text-center mb-4">User Logs Report</h2>
                <div class="stats-container">
                    <div class="stat-item">
                        <h5>Total Students</h5>
                        <p>${document.querySelector('.stat-card:nth-child(1) .card-text').textContent}</p>
                    </div>
                    <div class="stat-item">
                        <h5>Total Sessions</h5>
                        <p>${document.querySelector('.stat-card:nth-child(2) .card-text').textContent}</p>
                    </div>
                    <div class="stat-item">
                        <h5>Average Duration</h5>
                        <p>${document.querySelector('.stat-card:nth-child(3) .card-text').textContent}</p>
                    </div>
                </div>
                ${document.querySelector('.table-responsive').outerHTML}
            </body>
            </html>
        `);
        
        // Print the window
        printWindow.document.close();
        printWindow.focus();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }
    </script>
</body>
</html>