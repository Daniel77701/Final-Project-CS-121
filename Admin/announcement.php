<?php
require_once '../classes/announcement_handler.php';
session_start();
// Add any authentication checks here if needed
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
    <link rel="stylesheet" href="admin_css/announcement.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
            <!-- Sidebar (Left Column) -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="schema.php"><img src="icons_admin/view schema.png" alt="Schema Icon"> Schema</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link active" href="announcement.php"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="scholarship-section col-md-7 col-lg-5">
                <div class="title-box">
                    <h2>
                        Announcement 
                        <a href="settings.html">
                            <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                        </a>
                    </h2>
                    <hr>
                    <button onclick="showAddAnnouncementForm()" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Announcement
                    </button>
                </div>
            
                <div class="table-box">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Announcement</th>
                                    <th>Date Posted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Announcements will be loaded here dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div class="footer text-center">Showing 0 to 0 of 0 entries</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Helper function for security
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Fetch announcements
        function fetchAnnouncements() {
            $.post('../classes/announcement_handler.php', { action: 'get_announcements' }, function(response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }
                
                let rows = '';
                response.forEach(a => {
                    // Format the date
                    const date = new Date(a.date_posted);
                    const formattedDate = date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    
                    rows += `<tr>
                        <td>${escapeHtml(a.subject)}</td>
                        <td>${escapeHtml(a.announcement)}</td>
                        <td>${formattedDate}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editAnnouncement('${a.id}', '${escapeHtml(a.subject)}', '${escapeHtml(a.announcement)}', '${a.date_posted}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAnnouncement('${a.id}')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>`;
                });
                $('tbody').html(rows);
                $('.footer').text(`Showing 1 to ${response.length} of ${response.length} entries`);
            }).fail(function(xhr, status, error) {
                alert('Error: ' + error);
            });
        }

        // Add announcement
        function showAddAnnouncementForm() {
            Swal.fire({
                title: 'Add New Announcement',
                html: `
                    <form id="addAnnouncementForm">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="announcement">Announcement</label>
                            <textarea class="form-control" id="announcement" name="announcement" rows="4" required></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add Announcement',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('addAnnouncementForm');
                    const formData = new FormData(form);
                    return {
                        subject: formData.get('subject'),
                        announcement: formData.get('announcement')
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../classes/announcement_handler.php',
                        type: 'POST',
                        data: {
                            action: 'add_announcement',
                            subject: result.value.subject,
                            announcement: result.value.announcement
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Success!', response.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error!', response.error, 'error');
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON || {};
                            Swal.fire('Error!', response.error || 'Failed to add announcement', 'error');
                        }
                    });
                }
            });
        }

        // Edit announcement
        function editAnnouncement(id, title, content, date) {
            Swal.fire({
                title: 'Edit Announcement',
                html: `
                    <form id="editAnnouncementForm">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="${title}" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required>${content}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="${date}" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('editAnnouncementForm');
                    const formData = new FormData(form);
                    return Object.fromEntries(formData);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../classes/announcement_handler.php',
                        type: 'POST',
                        data: {
                            action: 'edit_announcement',
                            id: id,
                            ...result.value
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Announcement updated successfully',
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update announcement',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        // Delete announcement
        function deleteAnnouncement(id) {
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
                        url: '../classes/announcement_handler.php',
                        type: 'POST',
                        data: {
                            action: 'delete_announcement',
                            id: id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Announcement has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Failed to delete announcement.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        // Show PHP messages with SweetAlert
        <?php if(isset($_SESSION['success'])): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['success']; ?>',
                icon: 'success'
            });
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['error']; ?>',
                icon: 'error'
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        // Initialize announcements on page load
        $(document).ready(function() {
            fetchAnnouncements();
        });
    </script>
</body>
</html> 