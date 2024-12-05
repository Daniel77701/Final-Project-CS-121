<?php
session_start();
require_once '../classes/settings_handler.php';

try {
    $settingHandler = new SettingHandler();

    // Handle delete action
    if (isset($_GET['delete'])) {
        try {
            $settingHandler->deleteSetting($_GET['delete']);
            $_SESSION['success'] = "Setting deleted successfully!";
            header("Location: settings.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error deleting setting: " . $e->getMessage();
            header("Location: settings.php");
            exit();
        }
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $school_year = $_POST['schoolYear'];
        $semester = $_POST['semester'];
        
        try {
            $settingHandler->createSetting($school_year, $semester);
            $_SESSION['success'] = "Settings saved successfully!";
            header("Location: settings.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error saving settings: " . $e->getMessage();
            header("Location: settings.php");
            exit();
        }
    }

    // Fetch existing settings
    $settings = $settingHandler->getAllSettings();

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/">
    <link rel="preconnect" href="https://code.jquery.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Scholarship Tracker</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" as="style">
    <link rel="preload" href="admin_css/setting.css" as="style">
    
    <!-- Load CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/setting.css">
    
    <!-- Defer non-critical CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" media="print" onload="this.media='all'">
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
            <a href="#" onclick="confirmLogout()" class="ml-3" style="color: white; text-decoration: none;">
                <i class="fas fa-sign-out-alt"></i>
                <span class="ml-1">Logout</span>
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
                    <li class="nav-item"><a class="nav-link active" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="scholarship-section">
                    <div class="title-box">
                        <h2>Settings</h2>
                        <hr>
                        
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
                            <?php unset($_SESSION['error']); // Clear the error message ?>
                        <?php endif; ?>
                        
                        <?php if(isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
                            <?php unset($_SESSION['success']); // Clear the success message ?>
                        <?php endif; ?>

                        <div class="button-container">
                            <button class="add-featured" data-toggle="modal" data-target="#setSchoolYearModal">Set School Year</button>
                        </div>

                        <div class="table-box">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>School Year</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($settings)): ?>
                                        <?php foreach ($settings as $setting): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($setting['school_year']); ?></td>
                                                <td><?php echo htmlspecialchars($setting['semester']); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $setting['status'] === 'Active' ? 'badge-success' : 'badge-secondary'; ?>">
                                                        <?php echo htmlspecialchars($setting['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="settings.php?delete=<?php echo $setting['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirmDeleteSetting(event, <?php echo $setting['id']; ?>);">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No settings found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="footer">
                                Showing <?php echo count($settings); ?> <?php echo count($settings) === 1 ? 'entry' : 'entries'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Set School Year Modal -->
    <div class="modal fade" id="setSchoolYearModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set School Year</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="settings.php" method="POST" id="settingsForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="schoolYear">School Year:</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="schoolYear" 
                                   name="schoolYear" 
                                   placeholder="YYYY-YYYY" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="semester">Semester:</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                <option value="1st">1st Semester</option>
                                <option value="2nd">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Move scripts to bottom and add defer -->
    <script defer src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap components after page load
        $('#setSchoolYearModal').modal({
            show: false
        });
    });
    </script>

    <!-- Add SweetAlert2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: "Are you sure you want to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, logout",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "html/index.html";
                }
            });
        }

        // For delete confirmation in the table
        function confirmDelete(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'settings_handle.php?delete=' + id;
                }
            });
        }

        // For saving school year settings
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: `Don't save`
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Settings saved successfully"
                    });
                }
            });
        });

        // Show success message if settings were updated
        <?php if(isset($_SESSION['success'])): ?>
            Toast.fire({
                icon: "success",
                title: "<?php echo $_SESSION['success']; ?>"
            });
        <?php endif; ?>
    </script>

    <!-- Add this JavaScript after your existing scripts -->
    <script>
    $(document).ready(function() {
        // Handle form submission
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Save Settings',
                text: 'Are you sure you want to save these settings?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Handle delete button
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

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
                    window.location.href = `settings_handle.php?delete=${id}`;
                }
            });
        });

        // Show success/error messages
        <?php if(isset($_SESSION['error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred',
                icon: 'error'
            });
        <?php endif; ?>
    });
    </script>

    <script>
    function confirmDeleteSetting(event, id) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `settings.php?delete=${id}`;
            }
        });
        
        return false;
    }
    </script>
</body>
</html> 