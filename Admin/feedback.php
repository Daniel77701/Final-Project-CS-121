<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/feedback.css">
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
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.html"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarship.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.html"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.html"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link active" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.html"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.html"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 px-md-4" id="main-content">
                <div class="dashboard-section">
                    <h1 class="mt-4">Feedback <a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a> </h1>
                    <hr>
                </div>

                <!-- Feedback Table -->
                <div class="table-box">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Scholarship</th>
                                <th>Message</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("feedback_handler.php");
                            foreach ($feedbacks as $feedback):
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($feedback['scholarship']); ?></td>
                                    <td><?= htmlspecialchars($feedback['message']); ?></td>
                                    <td><?= htmlspecialchars($feedback['name']); ?></td>
                                    <td><?= htmlspecialchars($feedback['course']); ?></td>
                                    <td><?= htmlspecialchars($feedback['created_at']); ?></td>
                                    <td><?= htmlspecialchars($feedback['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Showing <?= count($feedbacks); ?> feedback entries</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</body>
</html>
