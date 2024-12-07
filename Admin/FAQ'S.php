<?php
session_start();
require_once "../classes/FAQ'S_handler.php";

// Initialize FAQ object
$faq = new FAQ();

// At the top of your file, after session_start()
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Before form handling
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST Data: " . print_r($_POST, true));

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $question = trim($_POST['question'] ?? '');
        $answer = trim($_POST['answer'] ?? '');
        
        // Debug
        error_log("Adding FAQ - Question: " . $question . ", Answer: " . $answer);
        
        $result = $faq->addFAQ($question, $answer);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header("Location: FAQ'S.php");
        exit();
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'] ?? '';
        $question = trim($_POST['question'] ?? '');
        $answer = trim($_POST['answer'] ?? '');
        
        $result = $faq->updateFAQ($id, $question, $answer);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header("Location: FAQ'S.php");
        exit();
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = $faq->deleteFAQ($id);
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
    }
    header("Location: FAQ'S.php");
    exit();
}

// Get all FAQs for display
$faqs = $faq->getFAQs();
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header id="header" class="d-flex justify-content-between" style="background-color: #d1182d; padding: 8px 20px;">
        <div class="logo d-flex align-items-center">
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
    
    <!-- Main Container -->
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
                    <li class="nav-item"><a class="nav-link active" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.php"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="title-box">
                    <h1>Scholarship FAQ's <a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a></h1>
                    <hr>
                    <div class="add-question-container">
                        <button class="btn btn-primary" onclick="showAddFAQForm()">
                            <i class="fas fa-plus"></i> Add FAQ
                        </button>
                    </div>
                </div>

                <!-- Add this right after the title-box div -->
                <div class="messages">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php 
                                echo $_SESSION['success']; 
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                                echo $_SESSION['error']; 
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- FAQ Section -->
                <div class="faq-title-box">
                    <div class="accordion-container">
                        <?php 
                        if (empty($faqs)) {
                            error_log("No FAQs available for display");
                        }
                        if (!empty($faqs)): 
                            foreach ($faqs as $faqItem): 
                                // Debug each FAQ item
                                error_log("Processing FAQ: " . print_r($faqItem, true));
                        ?>
                            <div class="faq-item">
                                <button class="accordion">
                                    <span class="question-text"><?php echo htmlspecialchars($faqItem['question']); ?></span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="panel">
                                    <div class="panel-content">
                                        <?php echo $faqItem['formatted_answer']; ?>
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-sm" 
                                                    onclick="editFAQ(<?php echo $faqItem['id']; ?>, '<?php echo addslashes($faqItem['question']); ?>', '<?php echo addslashes($faqItem['answer']); ?>')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                    onclick="deleteFAQ(<?php echo $faqItem['id']; ?>)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> No FAQs available yet. Click "Add Question" to create your first FAQ.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($faqItem['id']); ?>">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" class="form-control" id="question" name="question" value="<?php echo htmlspecialchars($faqItem['question']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="answer">Answer</label>
                                <textarea class="form-control" id="answer" name="answer" required><?php echo htmlspecialchars($faqItem['answer']); ?></textarea>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Accordion Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var acc = document.getElementsByClassName("accordion");
        
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                // Close all other accordions
                var allAccordions = document.getElementsByClassName("accordion");
                for (var j = 0; j < allAccordions.length; j++) {
                    if (allAccordions[j] !== this) {
                        allAccordions[j].classList.remove("active");
                        var otherPanel = allAccordions[j].nextElementSibling;
                        otherPanel.style.maxHeight = null;
                    }
                }
                
                // Toggle current accordion
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    });

    function editFAQ(id, question, answer) {
        // Populate and show edit modal
        document.querySelector('#editFAQModal input[name="id"]').value = id;
        document.querySelector('#editFAQModal input[name="question"]').value = question;
        document.querySelector('#editFAQModal textarea[name="answer"]').value = answer;
        $('#editFAQModal').modal('show');
    }

    function deleteFAQ(id) {
        if (confirm('Are you sure you want to delete this FAQ?')) {
            window.location.href = `FAQ'S.php?delete=${id}`;
        }
    }
    </script>

    <!-- Add SweetAlert2 in the head section -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add this JavaScript -->
    <script>
    function showAddFAQForm() {
        Swal.fire({
            title: 'Add New FAQ',
            html: `
                <form id="addFAQForm">
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add FAQ',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const form = document.getElementById('addFAQForm');
                if (!form.checkValidity()) {
                    Swal.showValidationMessage('Please fill in all fields');
                    return false;
                }
                return {
                    question: form.querySelector('#question').value.trim(),
                    answer: form.querySelector('#answer').value.trim()
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../includes/faq_handler.php',
                    type: 'POST',
                    data: {
                        action: 'add',
                        question: result.value.question,
                        answer: result.value.answer
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to connect to server', 'error');
                    }
                });
            }
        });
    }

    function editFAQ(id, question, answer) {
        Swal.fire({
            title: 'Edit FAQ',
            html: `
                <form id="editFAQForm">
                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" class="form-control" id="question" name="question" value="${question}" required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="4" required>${answer}</textarea>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const form = document.getElementById('editFAQForm');
                if (!form.checkValidity()) {
                    Swal.showValidationMessage('Please fill in all fields');
                    return false;
                }
                return {
                    id: id,
                    question: form.querySelector('#question').value.trim(),
                    answer: form.querySelector('#answer').value.trim()
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../includes/faq_handler.php',
                    type: 'POST',
                    data: {
                        action: 'edit',
                        id: result.value.id,
                        question: result.value.question,
                        answer: result.value.answer
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to connect to server', 'error');
                    }
                });
            }
        });
    }

    function deleteFAQ(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../includes/faq_handler.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to connect to server', 'error');
                    }
                });
            }
        });
    }

    // Show success/error messages from PHP
    <?php if(isset($_SESSION['success_message'])): ?>
        Swal.fire({
            title: 'Success!',
            text: '<?php echo $_SESSION['success_message']; ?>',
            icon: 'success'
        });
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error_message'])): ?>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo $_SESSION['error_message']; ?>',
            icon: 'error'
        });
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    </script>
</body>
</html>