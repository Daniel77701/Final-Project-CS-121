<?php

session_start();
require_once '../connection/dbh.classes.php';
require_once '../classes/LoginTracker.php';

$loginTracker = new LoginTracker();
$db = new Dbh();
$conn = $db->connect();

// Modified query to join with students table to get more information
$query = "SELECT ul.*, s.name, s.sr_code 
          FROM user_logs ul
          JOIN students s ON s.id = ul.student_id
          ORDER BY ul.login_time DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <i class="fas fa-bell"></i> <span class="badge badge-light ml-2">1</span>
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
            <h1>User Logs <a href="settings.html">
                <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
            </a></h1>
            <hr>
            <button class="delete" id="deleteSelected">Delete Selected</button>
        </div>

        <div class="action-container">
            <button class="print" onclick="window.print()">Print</button>
            <div class="search-container">
                <label for="search">Search:</label>
                <input type="text" id="search" placeholder="Search...">
            </div>
        </div>                
        <div class="table-box">
            <table id="logsTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>SR Code</th>
                        <th>Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
                            url: 'includes/delete_logs.php',
                            type: 'POST',
                            data: {logs: selectedLogs},
                            success: function(response) {
                                location.reload();
                            },
                            error: function() {
                                alert('Error deleting logs');
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>