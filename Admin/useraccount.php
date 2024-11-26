<?php include 'useraccount_handler.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/user_account.css">
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
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3 collapse d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.html"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.html"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.html"><img src="icons_admin/scholarship.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.html"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.html"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.html"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.html"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.html"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link active" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.html"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <div class="scholarship-section">
                <div class="title-box">
                    <h2>User Account</h2>
                    <hr>
                    <div class="add-scholarship-container">
                        <button class="add-scholarship" data-toggle="modal" data-target="#addUserModal">Add Student User</button>
                    </div>
                </div>
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Sr-Code</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td><?= htmlspecialchars($user['sr_code']); ?></td>
                                    <td><?= htmlspecialchars($user['full_name']); ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#editUserModal" 
                                            data-id="<?= $user['id']; ?>" 
                                            data-name="<?= htmlspecialchars($user['full_name']); ?>" 
                                            data-email="<?= htmlspecialchars($user['email']); ?>" 
                                            data-sr_code="<?= htmlspecialchars($user['sr_code']); ?>" 
                                            data-mobile="<?= htmlspecialchars($user['mobile_number']); ?>">Edit</button>
                                        <form method="post" style="display: inline-block;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                            <button type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="footer">Showing <?= count($users); ?> entries</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Student User</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="sr_code" placeholder="Sr-Code" required>
                        <input type="text" name="mobile_number" placeholder="Mobile Number" required>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id">
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="sr_code" placeholder="Sr-Code" required>
                        <input type="text" name="mobile_number" placeholder="Mobile Number" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            modal.find('input[name="id"]').val(button.data('id'));
            modal.find('input[name="full_name"]').val(button.data('name'));
            modal.find('input[name="email"]').val(button.data('email'));
            modal.find('input[name="sr_code"]').val(button.data('sr_code'));
            modal.find('input[name="mobile_number"]').val(button.data('mobile'));
        });
    </script>
</body>
</html>
