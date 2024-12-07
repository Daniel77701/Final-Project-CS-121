<?php
require_once '../classes/schema_handler.php';

$schema = new Schema();
$result = $schema->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons_admin/logo.png" type="image/x-icon">
    <title>Scholarship Schema</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_css/schema.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <header id="header">
    <div class="logo">
        <img src="icons_admin/logo.png" alt="Logo" width="40">
        <span>Scholarship Tracker System</span>
    </div>
    <div class="welcome d-flex align-items-center">
        <span class="ml-4">Welcome, Admin</span>
        <i class="fas fa-user ml-1"></i>
        <a href="settings.php">
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
                <li class="nav-item"><a class="nav-link" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
                <li class="nav-item"><a class="nav-link active" href="schema.php"><img src="icons_admin/view schema.png" alt="Schema Icon"> Schema</a></li>
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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="content-wrapper">
                    <div class="table-section">
                        <div class="section-header">
                            <h2>Scholarship Schema <a href="settings.html">
                    <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                </a></h2>
                            <hr class="divider">
                            <div class="button-container">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applicationModal">
                                    <i class="fas fa-plus"></i> Add New Schema
                                </button>
                            </div>
                        </div>

                        <div class="table-box-container">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Scholarship Type</th>
                                            <th>Grade/Campus</th>
                                            <th>Year</th>
                                            <th>Category</th>
                                            <th>Submission Deadline</th>
                                            <th>Amount per Sem</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $row): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['scholarship_type']); ?></td>
                                                <td><?php echo htmlspecialchars($row['grade_campus']); ?></td>
                                                <td><?php echo htmlspecialchars($row['year_scholarship']); ?></td>
                                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($row['submission_deadline'])); ?></td>
                                                <td>₱<?php echo number_format($row['amount_per_sem'], 2); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $row['status'] === 'Open' ? 'bg-success' : 'bg-danger'; ?>">
                                                        <?php echo htmlspecialchars($row['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" onclick="viewDetails('<?php echo $row['schema_id']; ?>')">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                    <button class="btn btn-sm btn-primary" onclick="editSchema('<?php echo $row['schema_id']; ?>')">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteSchema('<?php echo $row['schema_id']; ?>')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="table-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        Total Entries: <?php echo count($result); ?>
                                    </div>
                                    <div>
                                        Last Updated: <?php echo date('M d, Y'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function viewDetails(schemaId) {
        $.ajax({
            url: '../includes/schema_operations.php',
            type: 'GET',
            data: { 
                action: 'get',
                id: schemaId 
            },
            success: function(response) {
                try {
                    // Parse response if it's a string
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (data.error) {
                        Swal.fire('Error!', data.error, 'error');
                        return;
                    }

                    // Populate modal fields
                    $('#viewScholarshipType').text(data.scholarship_type);
                    $('#viewGradeCampus').text(data.grade_campus);
                    $('#viewYear').text(data.year_scholarship);
                    $('#viewCategory').text(data.category);
                    $('#viewAmount').text('₱' + parseFloat(data.amount_per_sem).toFixed(2));
                    $('#viewStatus').text(data.status);
                    $('#viewDeadline').text(new Date(data.submission_deadline).toLocaleDateString());
                    $('#viewCriteria').text(data.criteria);
                    $('#viewDocuments').text(data.required_documents);
                    $('#viewDescription').text(data.description);
                    
                    // Show the modal
                    $('#viewDetailsModal').modal('show');
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire('Error!', 'Failed to parse server response', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire('Error!', 'Failed to fetch schema details', 'error');
            }
        });
    }
    </script>
    <script>
    // Check for URL parameters and show appropriate messages
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            if (urlParams.get('success') === 'added') {
                Swal.fire({
                    title: 'Success!',
                    text: 'New schema has been added successfully.',
                    icon: 'success',
                    confirmButtonColor: '#d1182d'
                });
            }
        } else if (urlParams.has('error')) {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add new schema. Please try again.',
                icon: 'error',
                confirmButtonColor: '#d1182d'
            });
        }
    });
    </script>
    <!-- Add New Schema Modal -->
    <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicationModalLabel">Add New Schema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSchemaForm" method="POST" action="../classes/schema_handler.php">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="scholarshipType" class="form-label">Scholarship Type</label>
                                <input type="text" class="form-control" id="scholarshipType" name="scholarshipType" required>
                            </div>
                            <div class="col-md-6">
                                <label for="gradeCampus" class="form-label">Grade/Campus</label>
                                <input type="text" class="form-control" id="gradeCampus" name="gradeCampus" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="yearScholarship" class="form-label">Year</label>
                                <input type="text" class="form-control" id="yearScholarship" name="yearScholarship" placeholder="e.g., 2024-2025" required>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Merit-based">Merit-based</option>
                                    <option value="Need-based">Need-based</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Cultural">Cultural</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="submissionDeadline" class="form-label">Submission Deadline</label>
                                <input type="date" class="form-control" id="submissionDeadline" name="submissionDeadline" required>
                            </div>
                            <div class="col-md-6">
                                <label for="amountPerSem" class="form-label">Amount per Semester</label>
                                <input type="number" step="0.01" class="form-control" id="amountPerSem" name="amountPerSem" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="criteria" class="form-label">Criteria</label>
                            <textarea class="form-control" id="criteria" name="criteria" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requiredDocuments" class="form-label">Required Documents</label>
                            <textarea class="form-control" id="requiredDocuments" name="requiredDocuments" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Schema</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function deleteSchema(schemaId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d1182d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../includes/schema_operations.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: schemaId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success')
                            .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message || 'Failed to delete', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong', 'error');
                    }
                });
            }
        });
    }
    </script>
    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Scholarship Schema Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Scholarship Type:</strong> <span id="viewScholarshipType"></span></p>
                            <p><strong>Grade/Campus:</strong> <span id="viewGradeCampus"></span></p>
                            <p><strong>Year:</strong> <span id="viewYear"></span></p>
                            <p><strong>Category:</strong> <span id="viewCategory"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amount per Semester:</strong> <span id="viewAmount"></span></p>
                            <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                            <p><strong>Submission Deadline:</strong> <span id="viewDeadline"></span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Criteria:</h6>
                            <p id="viewCriteria"></p>
                            <h6>Required Documents:</h6>
                            <p id="viewDocuments"></p>
                            <h6>Description:</h6>
                            <p id="viewDescription"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Schema Modal -->
    <div class="modal fade" id="editSchemaModal" tabindex="-1" aria-labelledby="editSchemaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSchemaModalLabel">Edit Schema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSchemaForm" method="POST" action="../includes/schema_operations.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" id="editSchemaId" name="schema_id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editScholarshipType" class="form-label">Scholarship Type</label>
                                <input type="text" class="form-control" id="editScholarshipType" name="scholarshipType" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editGradeCampus" class="form-label">Grade/Campus</label>
                                <input type="text" class="form-control" id="editGradeCampus" name="gradeCampus" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editYearScholarship" class="form-label">Year</label>
                                <input type="text" class="form-control" id="editYearScholarship" name="yearScholarship" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editCategory" class="form-label">Category</label>
                                <select class="form-select" id="editCategory" name="category" required>
                                    <option value="Merit-based">Merit-based</option>
                                    <option value="Need-based">Need-based</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Cultural">Cultural</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editSubmissionDeadline" class="form-label">Submission Deadline</label>
                                <input type="date" class="form-control" id="editSubmissionDeadline" name="submissionDeadline" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editAmountPerSem" class="form-label">Amount per Semester</label>
                                <input type="number" step="0.01" class="form-control" id="editAmountPerSem" name="amountPerSem" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editCriteria" class="form-label">Criteria</label>
                            <textarea class="form-control" id="editCriteria" name="criteria" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editRequiredDocuments" class="form-label">Required Documents</label>
                            <textarea class="form-control" id="editRequiredDocuments" name="requiredDocuments" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function editSchema(schemaId) {
        $.ajax({
            url: '../includes/schema_operations.php',
            type: 'GET',
            data: { 
                action: 'get',
                id: schemaId 
            },
            success: function(response) {
                try {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (data.error) {
                        Swal.fire('Error!', data.error, 'error');
                        return;
                    }

                    // Populate edit form fields
                    $('#editSchemaId').val(data.schema_id);
                    $('#editScholarshipType').val(data.scholarship_type);
                    $('#editGradeCampus').val(data.grade_campus);
                    $('#editYearScholarship').val(data.year_scholarship);
                    $('#editCategory').val(data.category);
                    $('#editSubmissionDeadline').val(data.submission_deadline);
                    $('#editAmountPerSem').val(data.amount_per_sem);
                    $('#editCriteria').val(data.criteria);
                    $('#editRequiredDocuments').val(data.required_documents);
                    $('#editDescription').val(data.description);
                    $('#editStatus').val(data.status);

                    // Show the edit modal
                    $('#editSchemaModal').modal('show');
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire('Error!', 'Failed to parse server response', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire('Error!', 'Failed to fetch schema details', 'error');
            }
        });
    }
    </script>
    <script>
    // Update the form submission for editing
    $('#editSchemaForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../includes/schema_operations.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#editSchemaModal').modal('hide');
                    Swal.fire('Success!', 'Schema updated successfully', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error!', response.message || 'Update failed', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Something went wrong', 'error');
            }
        });
    });
    </script>
</body>
</html>

