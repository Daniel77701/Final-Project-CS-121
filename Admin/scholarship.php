<?php
require_once "scholarship_handler.php";

$handler = new ScholarshipHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $handler->create($_POST['name'], $_POST['description'], $_POST['requirements'], $_POST['deadline']);
    } elseif ($action === 'update') {
        $handler->update($_POST['scholarship_id'], $_POST['name'], $_POST['description'], $_POST['requirements'], $_POST['deadline']);
    } elseif ($action === 'delete') {
        $handler->delete($_POST['scholarship_id']);
    }
}

$scholarships = $handler->read();
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
    <link rel="stylesheet" href="admin_css/scholarship.css"> <!-- Your custom CSS -->
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
                    <li class="nav-item"><a class="nav-link active" href="scholarship.php"><img src="icons_admin/scholarship.png" alt="Scholarship Icon"> Scholarship</a></li>
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

            <!-- Main Content -->
            <main class="col-9 col-md-8 col-lg-6 p-3 main-content">
                <div class="scholarship-section">
                    <div class="title-box d-flex justify-content-between align-items-center">
                        <h2>Scholarships</h2>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addScholarshipModal">Add Scholarship</button>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Requirements</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scholarships as $scholarship): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($scholarship['name']) ?></td>
                                        <td><?= htmlspecialchars($scholarship['description']) ?></td>
                                        <td><?= htmlspecialchars($scholarship['requirements']) ?></td>
                                        <td><?= htmlspecialchars($scholarship['deadline']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editScholarship(<?= $scholarship['scholarship_id'] ?>)">Edit</button>
                                            <form method="POST" style="display: inline-block;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="scholarship_id" value="<?= $scholarship['scholarship_id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Scholarship Modal -->
    <div class="modal fade" id="addScholarshipModal" tabindex="-1" aria-labelledby="addScholarshipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addScholarshipModalLabel">Add Scholarship</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="create">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements:</label>
                            <textarea class="form-control" id="requirements" name="requirements" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline:</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Scholarship Modal -->
    <div class="modal fade" id="editScholarshipModal" tabindex="-1" aria-labelledby="editScholarshipModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editScholarshipModalLabel">Edit Scholarship</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="scholarship_id" id="edit_scholarship_id">
                        <div class="form-group">
                            <label for="edit_name">Name:</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description:</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_requirements">Requirements:</label>
                            <textarea class="form-control" id="edit_requirements" name="requirements" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_deadline">Deadline:</label>
                            <input type="date" class="form-control" id="edit_deadline" name="deadline" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function editScholarship(scholarship_id) {
            const scholarship = <?= json_encode($scholarships) ?>.find(s => s.scholarship_id === scholarship_id);

            document.getElementById('edit_scholarship_id').value = scholarship.scholarship_id;
            document.getElementById('edit_name').value = scholarship.name;
            document.getElementById('edit_description').value = scholarship.description;
            document.getElementById('edit_requirements').value = scholarship.requirements;
            document.getElementById('edit_deadline').value = scholarship.deadline;

            $('#editScholarshipModal').modal('show');
        }
    </script>
</body>
</html>
