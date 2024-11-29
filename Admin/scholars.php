<?php
    include_once 'scholars_handler.php';
    $scholars = new Scholars();
    $scholarList = $scholars->getScholars();
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
    <link rel="stylesheet" href="admin_css/scholars.css">
</head>
<body>
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
                    <li class="nav-item"><a class="nav-link active" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarship.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.html"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.html"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.html"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.html"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>
    
            <!-- Main Content (Dashboard) -->
            <main class="col-md-9 col-lg-10 px-md-4" id="main-content">
                <div class="dashboard-section">
                    <h1 class="mt-4">Scholars <a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a></h1>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="table-controls d-flex justify-content-between align-items-center">
                                <div class="form-select-container">
                                    <label for="file-upload" class="form-label">Choose file</label>
                                    <input type="file" id="file-upload" class="form-control mb-2" />
                                </div>
                                <div class="button-group">
                                    <button class="btn btn-primary">Import</button>
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#addScholarModal">Add Scholar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- List of Scholars Section -->
                <div class="dashboard-section">
                    <h2>List of Scholars in Batangas State University</h2>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="print-btn">Print</button>
                        <div class="d-flex align-items-center">
                            <label for="entries" class="me-2 mb-0">Show</label>
                            <select id="entries" class="form-select me-3 mb-0"> 
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <input type="text" placeholder="Search... " class="form-control mb-0" />
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Student SR Code</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Scholarship</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scholarList as $scholar): ?>
                            <tr>
                                <td><?php echo $scholar['sr_code']; ?></td>
                                <td><?php echo $scholar['name']; ?></td>
                                <td><?php echo $scholar['course']; ?></td>
                                <td><?php echo $scholar['year_level']; ?></td>
                                <td><?php echo $scholar['scholarship']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateScholarModal"
                                    data-sr_code="<?php echo $scholar['sr_code']; ?>"
                                    data-name="<?php echo $scholar['name']; ?>"
                                    data-course="<?php echo $scholar['course']; ?>"
                                    data-year_level="<?php echo $scholar['year_level']; ?>"
                                    data-scholarship="<?php echo $scholar['scholarship']; ?>">Edit</button>
                                    <a href="scholars.php?delete_sr_code=<?php echo $scholar['sr_code']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this scholar?');">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Showing <?php echo count($scholarList); ?> entries</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Scholar Modal -->
    <div class="modal fade" id="addScholarModal" tabindex="-1" role="dialog" aria-labelledby="addScholarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScholarModalLabel">Add Scholar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="scholars.php">
                        <div class="form-group">
                            <label for="sr_code">Student SR Code</label>
                            <input type="text" name="sr_code" id="sr_code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" name="course" id="course" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <input type="text" name="year_level" id="year_level" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="scholarship">Scholarship</label>
                            <input type="text" name="scholarship" id="scholarship" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_scholar">Add Scholar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Scholar Modal -->
    <div class="modal fade" id="updateScholarModal" tabindex="-1" role="dialog" aria-labelledby="updateScholarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateScholarModalLabel">Update Scholar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="scholars.php">
                        <input type="hidden" name="sr_code" id="sr_code">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" name="course" id="course" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <input type="text" name="year_level" id="year_level" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="scholarship">Scholarship</label>
                            <input type="text" name="scholarship" id="scholarship" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_scholar">Update Scholar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Prepopulate the Update Modal with the Scholar's current details
        $('#updateScholarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var sr_code = button.data('sr_code');
            var name = button.data('name');
            var course = button.data('course');
            var year_level = button.data('year_level');
            var scholarship = button.data('scholarship');
            
            var modal = $(this);
            modal.find('#sr_code').val(sr_code);
            modal.find('#name').val(name);
            modal.find('#course').val(course);
            modal.find('#year_level').val(year_level);
            modal.find('#scholarship').val(scholarship);
        });
    </script>
</body>
</html>
