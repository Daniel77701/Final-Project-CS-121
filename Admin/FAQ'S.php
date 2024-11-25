<?php
require_once "FAQ.php";
$faq = new FAQ();
$faqs = $faq->getFAQs(); // Fetch FAQs

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $faq->deleteFAQ($id);
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
    header("Location: FAQ'S.php"); 
    exit();
}

// Handle updating FAQ
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq->updateFAQ($id, $question, $answer);
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
    <link rel="stylesheet" href="admin_css/FAQ'S.css">
</head>
<body>
    <header id="header" class="d-flex justify-content-between" style="background-color: #d1182d; padding: 8px 20px;">
        <div class="logo d-flex align-items-center">
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
    
    <!-- Main Container to hold sidebar and main content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Left Column) -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin-dashboard.html">
                            <img src="icons_admin/dashboard.png" alt="Dashboard Icon" width="20">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="scholars.html">
                            <img src="icons_admin/scholars.png" alt="Scholars Icon" width="20">
                            Scholars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="scholarship.html">
                            <img src="icons_admin/scholarship.png" alt="Scholarship Icon" width="20">
                            Scholarship
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="scholarship-request.html">
                            <img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon" width="20">
                            Scholarship Request
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="FAQ'S.php">
                            <img src="icons_admin/exam_management.png" alt="FAQ'S Icon" width="20">
                            FAQ'S
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="announcement.html">
                            <img src="icons_admin/announcement.png" alt="Announcement Icon" width="20">
                            Announcement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback.html">
                            <img src="icons_admin/feedback.png" alt="Feedback Icon" width="20">
                            Feedback
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="featured-scholars.html">
                            <img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon" width="20">
                            Featured Scholars
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.html">
                            <img src="icons_admin/setting.png" alt="Settings Icon" width="20">
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="useraccount.html">
                            <img src="icons_admin/useraccount.png" alt="User Account Icon" width="20">
                            User Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userlogs.html">
                            <img src="icons_admin/userlogs.png" alt="User Logs Icon" width="20">
                            User Logs
                        </a>
                    </li>
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
            </div> <!-- End Main Content -->
        </div> <!-- End Row -->
    </div> <!-- End Main Container -->

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
                        <button type="submit" name="add" class="btn btn-primary">Save FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <?php if (isset($faqItem)): ?>
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
    <?php endif; ?>

    <!-- Include Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Accordion Functionality Script -->
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
</body>
</html>
