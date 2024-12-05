<?php
 include '../classes/useraccount_handler.php'; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/user_account.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="schema.php"><img src="icons_admin/view schema.png" alt="Schema Icon"> Schema</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.php"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link active" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <div class="scholarship-section">
                <div class="title-box">
                    <h2>User Account <a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a></h2>
                    <hr>
                    <div class="add-scholarship-container">
                        <button class="add-scholarship" data-toggle="modal" data-target="#addUserModal">Add Student User</button>
                    </div>
                </div>

                <!-- Search bar moved outside -->
                <div class="search-box">
                    <div class="search-container">
                        <form class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                    placeholder="Search by name, email or SR-Code" 
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <?php if (isset($_GET['search'])): ?>
                                <a href="useraccount.php" class="btn btn-secondary ml-2">Clear</a>
                            <?php endif; ?>
                        </form>
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
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">No users found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['email']); ?></td>
                                        <td><?= htmlspecialchars($user['sr_code']); ?></td>
                                        <td><?= htmlspecialchars($user['full_name']); ?></td>
                                        <td class="button-cell">
                                            <button class="edit-btn" data-toggle="modal" data-target="#editUserModal" 
                                                data-id="<?= $user['id']; ?>" 
                                                data-name="<?= htmlspecialchars($user['full_name']); ?>" 
                                                data-email="<?= htmlspecialchars($user['email']); ?>" 
                                                data-sr_code="<?= htmlspecialchars($user['sr_code']); ?>">
                                                Edit
                                            </button>
                                            <form method="post" style="display: inline-block;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing <?= count($student) ?> of <?= $total_records ?> entries
                    </div>
                    <?php if ($total_pages > 1): ?>
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=1">&laquo; First</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);

                            for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $total_pages ?>">Last &raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="sr_code" placeholder="Sr-Code" required>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id">
                        <input type="text" name="full_name" placeholder="Full Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="text" name="sr_code" placeholder="Sr-Code" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        $('#editUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            modal.find('input[name="id"]').val(button.data('id'));
            modal.find('input[name="full_name"]').val(button.data('name'));
            modal.find('input[name="email"]').val(button.data('email'));
            modal.find('input[name="sr_code"]').val(button.data('sr_code'));
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.onclick = function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
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
                        form.submit();
                    }
                });
            };
        });

        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                icon: '<?php echo $_SESSION['message_type'] ?? 'success'; ?>',
                title: '<?php echo $_SESSION['message']; ?>',
                showConfirmButton: false,
                timer: 1500
            });
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>

        // Add these validation functions
        function validateEmail(email) {
            const pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return pattern.test(email);
        }

        function validateSrCode(srCode) {
            const pattern = /^\d{2}-\d{1,5}$/;
            return pattern.test(srCode);
        }

        // Check for duplicates using AJAX
        async function checkDuplicate(field, value) {
            try {
                const response = await fetch('check_duplicate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `field=${field}&value=${value}`
                });
                const data = await response.json();
                return data.exists;
            } catch (error) {
                console.error('Error:', error);
                return false;
            }
        }

        // Update the add user form validation
        document.querySelector('#addUserModal form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[name="email"]').value;
            const srCode = this.querySelector('input[name="sr_code"]').value;
            
            // Format validation
            if (!validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (!validateSrCode(srCode)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid SR Code',
                    text: 'SR Code must be in format XX-XXXXX (e.g., 21-12345)',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Duplicate checks
            const emailExists = await checkDuplicate('email', email);
            if (emailExists) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Email',
                    text: 'This email address is already registered',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            const srCodeExists = await checkDuplicate('sr_code', srCode);
            if (srCodeExists) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate SR Code',
                    text: 'This SR Code is already registered',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // If all validations pass, submit the form
            this.submit();
        });

        // Add form submission handling for the edit user form
        document.querySelector('#editUserModal form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = this.querySelector('input[name="password"]');
            if (password && !password.value.trim()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Required',
                    text: 'Please enter a password for the user account',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // If validation passes, submit the form
            this.submit();
        });
    </script>
</body>
</html>
