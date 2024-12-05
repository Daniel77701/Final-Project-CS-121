<?php
require_once '../includes/scholarship-request_handler.php';
$requests = getAllRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_css/scholarship-request.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Header Section -->
    <header id="header">
        <div class="logo">
            <img src="icons_admin/logo.png" alt="Logo" width="40">
            <span>Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center">
            <i class="fas fa-bell"></i>
            <span class="badge badge-light ml-2">1</span>
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
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link active" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                    <li class="nav-item"><a class="nav-link" href="schema.php"><img src="icons_admin/view schema.png" alt="Schema Icon"> Schema</a></li>
                    <li class="nav-item"><a class="nav-link" href="FAQ'S.php"><img src="icons_admin/exam_management.png" alt="FAQ'S Icon"> FAQ'S</a></li>
                    <li class="nav-item"><a class="nav-link" href="announcement.php"><img src="icons_admin/announcement.png" alt="Announcement Icon"> Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php"><img src="icons_admin/feedback.png" alt="Feedback Icon"> Feedback</a></li>
                    <li class="nav-item"><a class="nav-link" href="featured-scholars.html"><img src="icons_admin/featured_scholars.png" alt="Featured Scholars Icon"> Featured Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><img src="icons_admin/setting.png" alt="Settings Icon"> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="useraccount.php"><img src="icons_admin/useraccount.png" alt="User Account Icon"> User Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="userlogs.php"><img src="icons_admin/userlogs.png" alt="User Logs Icon"> User Logs</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 px-md-4" id="main-content">
                <?php 
                // Display approval message if it exists
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear the message after displaying
                }
                ?>
                
                <div class="table-container">
                    <div class="page-title">
                        <h2>Scholarship Requests <a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a></h2>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addEditModal">
                            <i class="fas fa-plus"></i> Add Students
                        </button>
                    </div>

                    <!-- Status Messages -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: '<?php echo $_SESSION['success_message']; ?>',
                                icon: 'success'
                            });
                        </script>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <script>
                            Swal.fire({
                                title: 'Error!',
                                text: '<?php echo $_SESSION['error_message']; ?>',
                                icon: 'error'
                            });
                        </script>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <!-- Request Table -->
                    <table class="table table-bordered table-hover" id="requestTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Type</th>
                                <th>Scholarship</th>
                                <th>Student No</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $row): ?>
                            <tr>
                                <td><?php echo isset($row['type']) ? htmlspecialchars($row['type']) : ''; ?></td>
                                <td><?php echo isset($row['scholarship']) ? htmlspecialchars($row['scholarship']) : ''; ?></td>
                                <td><?php echo isset($row['student_no']) ? htmlspecialchars($row['student_no']) : ''; ?></td>
                                <td><?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?></td>
                                <td><?php echo isset($row['course']) ? htmlspecialchars($row['course']) : ''; ?></td>
                                <td><?php echo isset($row['year_level']) ? htmlspecialchars($row['year_level']) : ''; ?></td>
                                <td><?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Pending'; ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-warning btn-sm editBtn" 
                                            data-id="<?php echo isset($row['scholarship_id']) ? htmlspecialchars($row['scholarship_id']) : ''; ?>"
                                            data-type="<?php echo isset($row['type']) ? htmlspecialchars($row['type']) : ''; ?>"
                                            data-scholarship="<?php echo isset($row['scholarship']) ? htmlspecialchars($row['scholarship']) : ''; ?>"
                                            data-student_no="<?php echo isset($row['student_no']) ? htmlspecialchars($row['student_no']) : ''; ?>"
                                            data-name="<?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?>"
                                            data-course="<?php echo isset($row['course']) ? htmlspecialchars($row['course']) : ''; ?>"
                                            data-year_level="<?php echo isset($row['year_level']) ? htmlspecialchars($row['year_level']) : ''; ?>"
                                            data-status="<?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Pending'; ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form method="POST" class="d-inline" name="delete_request">
                                            <input type="hidden" name="id" value="<?php echo isset($row['scholarship_id']) ? $row['scholarship_id'] : ''; ?>">
                                            <input type="hidden" name="delete_request" value="1">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEditModalLabel">Add Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="requestForm" method="POST">
                        <input type="hidden" name="requestId" id="requestId" value="">
                        <div class="form-group">
                            <label for="type">Request Type</label>
                            <input type="text" class="form-control" name="type" id="type" required>
                        </div>
                        <div class="form-group">
                            <label for="scholarship">Scholarship Name</label>
                            <input type="text" class="form-control" id="scholarship" name="scholarship" required>
                        </div>
                        <div class="form-group">
                            <label for="student_no">Student Number</label>
                            <input type="text" class="form-control" id="student_no" name="student_no" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" class="form-control" id="course" name="course" required>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <input type="text" class="form-control" id="year_level" name="year_level" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="Approved">Approved</option>
                                <option value="Not Approved">Not Approved</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        let table = $('#requestTable').DataTable();

        // Form submission handler
        $('#requestForm').on('submit', function(e) {
            e.preventDefault();
            
            let isEdit = $(this).data('edit') === true;
            let formData = new FormData(this);

            if (isEdit) {
                formData.append('edit_request', '1');
            } else {
                formData.append('save_request', '1');
            }

            Swal.fire({
                title: isEdit ? 'Update Request' : 'Add Request',
                text: 'Are you sure you want to save these changes?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
            $.ajax({
                url: 'scholarship-request.php',
                type: 'POST',
                data: Object.fromEntries(formData),
                success: function(response) {
                    $('#requestForm')[0].reset();
                    $('#addEditModal').modal('hide');
                    
                            Swal.fire({
                                title: 'Success!',
                                text: isEdit ? 'Request updated successfully!' : 'Request added successfully!',
                                icon: 'success'
                            }).then(() => {
                    location.reload();
                            });
                },
                error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: isEdit ? 'Error updating request' : 'Error adding request',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

        // Reset form when modal is closed
        $('#addEditModal').on('hidden.bs.modal', function() {
            $('#requestForm')[0].reset();
            $('#requestId').val('');
            $('#addEditModalLabel').text('Add Students');
        });

        // Status change handler
        $(document).on('change', '.status-select', function() {
            let form = $(this).closest('form');
            let newStatus = $(this).val();
            
            Swal.fire({
                title: 'Update Status',
                text: `Are you sure you want to change the status to ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
            form.submit();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Status updated successfully'
                    });
                } else {
                    // Reset select to previous value if cancelled
                    $(this).val($(this).find('option[selected]').val());
                }
            });
        });

        // Add delete handler
        $(document).on('submit', 'form[name="delete_request"]', function(e) {
            e.preventDefault();
            
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
                let form = $(this);
                let row = form.closest('tr');
                
                $.ajax({
                    url: 'scholarship-request.php',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Remove the row from DataTable
                        table.row(row).remove().draw();
                        
                            Swal.fire(
                                'Deleted!',
                                'Request has been deleted.',
                                'success'
                            );
                    },
                    error: function() {
                            Swal.fire(
                                'Error!',
                                'Failed to delete request.',
                                'error'
                            );
                    }
                });
            }
            });
        });

        // Edit button click handler
        $(document).on('click', '.editBtn', function() {
            // Reset form state first
            $('#requestForm')[0].reset();
            $('#requestForm').data('edit', false);
            
            let id = $(this).data('id');
            let row = $(this).closest('tr');
            
            // Get data from the row
            let scholarship = row.find('td:eq(0)').text().trim();
            let type = row.find('td:eq(1)').text().trim();
            let student_no = row.find('td:eq(2)').text().trim();
            let name = row.find('td:eq(3)').text().trim();
            let course = row.find('td:eq(4)').text().trim();
            let year_level = row.find('td:eq(5)').text().trim();
            let status = row.find('td:eq(6)').text().trim();

            // Populate the modal form
            $('#requestId').val(id);
            $('#type').val(type);
            $('#scholarship').val(scholarship);
            $('#student_no').val(student_no);
            $('#name').val(name);
            $('#course').val(course);
            $('#year_level').val(year_level);
            $('#status').val(status);

            // Change modal title and button text
            $('#addEditModalLabel').text('Edit Student');
            $('#saveBtn').text('Update');
            
            // Set edit flag
            $('#requestForm').data('edit', true);
            
            // Show the modal
            $('#addEditModal').modal('show');
        });

        // Update the modal close handler
        $('#addEditModal').on('hidden.bs.modal', function() {
            $('#requestForm')[0].reset();
            $('#requestId').val('');
            $('#addEditModalLabel').text('Add Students');
            $('#saveBtn').text('Save');
            $('#requestForm').data('edit', false);
        });
    });
    </script>
</body>
</html> 