<?php
require_once '../includes/getCount.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/admin.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
    <!-- Header Section -->
    <header id="header">
        <div class="logo">
            <img src="icons_admin/logo.png" alt="Logo" width="40">
            <span>Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center position-relative">
            <i class="fas fa-bell notification-icon" style="cursor: pointer;"></i>
            <span class="badge badge-light ml-2 notification-badge">0</span>
            <div class="dropdown-menu notifications-dropdown">
                <ul id="notifications-list"></ul>
            </div>
            <span class="ml-4">Welcome, Admin</span>
            <i class="fas fa-user ml-2"></i>
            <a href="settings.html">
                <img src="icons_admin/white_settings.png" alt="Settings Icon" style="width: 30px; height: 30px; margin-left: 10px;">
            </a>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
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
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content (Dashboard) -->
            <main class="col-md-9 col-lg-10 px-md-4" id="main-content">
                <div class="dashboard-section">
                    <h1 class="mt-4">Dashboard
                        <a href="settings.html">
                            <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                        </a>
                    </h1>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $scholarsCount; ?> Scholars</h5>
                                    <a href="scholars.php" class="btn btn-link custom-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $scholarshipsCount; ?> Scholarships</h5>
                                    <a href="scholarship.php" class="btn btn-link custom-link">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5><?php echo $announcementsCount; ?> Announcements</h5>
                                    <a href="announcement.php" class="btn btn-link custom-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-section">
                    <h1>The data of Red Spartan Scholars</h1>
                    <div id="year-level-chart" style="width:100%; height:400px;"></div>
                    <hr>
                </div>
            </main>
        </div>
    </div>

    <!-- Sidebar Toggle Button for smaller screens -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

    <!-- Notification Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notificationIcon = document.querySelector('.notification-icon');
            const notificationBadge = document.querySelector('.notification-badge');
            const notificationsDropdown = document.querySelector('.notifications-dropdown');
            const notificationsList = document.querySelector('#notifications-list');
    
            function fetchNotifications() {
                fetch('notifications.php?action=fetch')
                    .then(response => response.json())
                    .then(data => {
                        let unreadCount = 0;
                        notificationsList.innerHTML = ''; // Clear the list
    
                        data.forEach(notification => {
                            const listItem = document.createElement('li');
                            listItem.textContent = notification.message;
    
                            if (!notification.is_read) {
                                listItem.style.fontWeight = 'bold';
                                unreadCount++;
                            }
    
                            listItem.addEventListener('click', () => markAsRead(notification.id));
                            notificationsList.appendChild(listItem);
                        });
    
                        notificationBadge.textContent = unreadCount;
                        notificationBadge.style.display = unreadCount > 0 ? 'inline' : 'none';
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }
    
            notificationIcon.addEventListener('click', () => {
                notificationsDropdown.style.display = 
                    notificationsDropdown.style.display === 'block' ? 'none' : 'block';
            });
    
            function markAsRead(notificationId) {
                fetch('notifications.php?action=mark', {
                    method: 'POST',
                    body: JSON.stringify({ id: notificationId }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(() => fetchNotifications()); // Reload notifications after marking as read
            }
    
            fetchNotifications(); // Fetch notifications when the page loads
        });
    </script>

    <!-- Highcharts Pie Chart Script -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../includes/piechart_data.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.error) {
                        alert(data.error);
                    } else {
                        Highcharts.chart('year-level-chart', {
                            chart: {
                                type: 'pie'
                            },
                            title: {
                                text: 'Scholarship Year Levels'
                            },
                            series: [{
                                name: 'Number of Scholars',
                                colorByPoint: true,
                                data: data
                            }]
                        });
                    }
                },
                error: function() {
                    alert('Error loading chart data');
                }
            });
        });
    </script>
</body>

</html>