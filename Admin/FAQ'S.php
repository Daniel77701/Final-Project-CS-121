<?php
require_once "FAQ'S_handler.php";
$faq = new FAQ();
$faqs = $faq->getFAQs(); // Fetch FAQs

// Fetch the number of unread notifications
$unreadNotificationsCount = $faq->getUnreadNotificationsCount();

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $faq->deleteFAQ($id);
    $faq->addNotification("FAQ #$id deleted.");
    header("Location: FAQ'S.php");
    exit();
}   

// Handle edit action
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    // Fetch the FAQ to edit
    $faqItem = $faq->getFAQById($id);
}

// Handle adding FAQ via form submission
if (isset($_POST['add'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq->addFAQ($question, $answer);
    $faq->addNotification("New FAQ added.");
    header("Location: FAQ'S.php");
    exit();
}

// Handle updating FAQ
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq->updateFAQ($id, $question, $answer);
    $faq->addNotification("FAQ #$id updated.");
    header("Location: FAQ'S.php");
    exit();
}
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
    <!-- Include your external CSS file -->
    <link rel="stylesheet" href="admin_css/FAQ'S.css">
</head>
<body>
    <header id="header" class="d-flex justify-content-between" style="background-color: #d1182d; padding: 8px 20px;">
        <div class="logo d-flex align-items-center">
            <img src="icons_admin/logo.png" alt="Logo" width="40">
            <span>Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center">
            <!-- Notification Dropdown -->
            <div class="notification">
                <a href="#" id="notificationDropdown" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell" style="font-size: 24px;"></i> 
                    <span class="badge badge-light ml-2" style="font-size: 14px; position: relative; top: -10px;">
                        <?php echo $unreadNotificationsCount; ?>
                    </span>
                </a>
            </div>
            <div>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown" style="max-height: 300px; overflow-y: auto;">
                <!-- Loop through notifications here -->
                    <?php foreach ($faqs as $faqItem): ?>
                        <a class="dropdown-item" href="#" data-id="<?php echo $faqItem['id']; ?>">
                            <i class="fas fa-info-circle"></i> <?php echo $faqItem['question']; ?> - <?php echo $faqItem['answer']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <span class="ml-4">Welcome, Admin</span>
            <i class="fas fa-user ml-2"></i>
            <a href="settings.html">
                <img src="icons_admin/white_settings.png" alt="Settings Icon" style="width: 30px; height: 30px; margin-left: 10px;">
            </a> 
        </div>
    </header>
    
    <!-- Main Container to hold sidebar and main content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Left Column) -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.html"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarship.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.html"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link active" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.html"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.html"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.html"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content (Right Column) -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="title-box">
                    <h1>Scholarship FAQ's</h1>
                    <hr>
                    <div class="add-question-container">
                        <button class="add-question btn btn-primary" data-toggle="modal" data-target="#addFAQModal">Add Question</button>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-title-box">
                    <div class="accordion-container"> 
                        <!-- Loop through FAQs and display them -->
                        <?php foreach ($faqs as $faqItem): ?>
                            <button class="accordion btn btn-light text-left"><?php echo $faqItem['question']; ?></button>
                            <div class="panel">
                                <p><?php echo $faqItem['answer']; ?></p>
                                <a href="FAQ'S.php?edit=<?php echo $faqItem['id']; ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editFAQModal">Edit</a>
                                <a href="FAQ'S.php?delete=<?php echo $faqItem['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div> 
        </div>
    </div> 

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFAQModal" tabindex="-1" role="dialog" aria-labelledby="addFAQModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFAQModalLabel">Add New FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" id="answer" name="answer" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add" class="btn btn-primary">Add FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFAQModal" tabindex="-1" role="dialog" aria-labelledby="editFAQModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Edit FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $faqItem['id']; ?>">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control" id="question" name="question" value="<?php echo $faqItem['question']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea class="form-control" id="answer" name="answer" required><?php echo $faqItem['answer']; ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Accordion Script -->
    <script>
        var acc = document.getElementsByClassName("accordion");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
    <script>
     $(document).ready(function () {
        $('#notificationDropdown').dropdown();
        
        // AJAX to mark notifications as read
        $(document).on('click', '.dropdown-item', function() {
            var notificationId = $(this).data('id');
            
            $.ajax({
                url: 'notifications.php?action=mark',
                method: 'POST',
                data: { id: notificationId },
                success: function(response) {
                    $('#notificationDropdown .badge').text('0'); 
                }
            });
        });
    });
    </script>
</body>
</html>
