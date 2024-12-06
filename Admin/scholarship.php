<?php
require_once '../classes/scholarship_handler.php';

try {
    $scholarships = new ScholarshipHandler();
    $scholarshipList = $scholarships->getScholarships();
} catch (Exception $e) {
    error_log("Scholarship page error: " . $e->getMessage());
    die("Unable to connect to the database. Please try again later or contact support.");
}

// Handle Add Scholarship
if (isset($_POST['add_scholarship'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $requirements = $_POST['requirements'];
    $status = $_POST['status'];

    if ($scholarships->createScholarship($name, $description, $deadline, $requirements, $status)) {
        header("Location: scholarship.php?success=created");
        exit();
    } else {
        header("Location: scholarship.php?error=create_failed");
        exit();
    }
}

// Handle Update Scholarship
if (isset($_POST['update_scholarship'])) {
    $id = $_POST['scholarship_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $requirements = $_POST['requirements'];
    $status = $_POST['status'];

    if ($scholarships->updateScholarship($id, $name, $description, $deadline, $requirements, $status)) {
        header("Location: scholarship.php?success=updated");
        exit();
    } else {
        header("Location: scholarship.php?error=update_failed");
        exit();
    }
}

// Handle Delete Scholarship
if (isset($_GET['delete_scholarship_id'])) {
    $id = $_GET['delete_scholarship_id'];
    
    if ($scholarships->deleteScholarship($id)) {
        header("Location: scholarship.php?success=deleted");
        exit();
    } else {
        header("Location: scholarship.php?error=delete_failed");
        exit();
    }
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
    <link rel="stylesheet" href="admin_css/scholarship.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Add SweetAlert2 in head section -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php"><img src="icons_admin/dashboard.png" alt="Dashboard Icon"> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link active" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship-request.php"><img src="icons_admin/scholarship_request.png" alt="Scholarship Request Icon"> Scholarship Request</a></li>
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
                <div class="dashboard-section">
                    <h1 class="mt-4">Scholarships<a href="settings.html">
                        <img src="icons_admin/setting.png" alt="Settings Icon" style="width: 30px; height: 30px;">
                    </a> </h1>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" onclick="showAddScholarshipForm()">Add Scholarship</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- List of Scholarships Section -->
                <div class="dashboard-section">
                    <h2>Available Scholarships</h2>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="print-btn" onclick="printScholarships()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <div class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="text" id="searchInput" placeholder="Search... " class="form-control mb-0">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Scholarship ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Requirements</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scholarshipList as $scholarship): ?>
                            <tr>
                                <td><?php echo $scholarship['scholarship_id']; ?></td>
                                <td><?php echo $scholarship['name']; ?></td>
                                <td><?php echo $scholarship['description']; ?></td>
                                <td><?php echo $scholarship['requirements']; ?></td>
                                <td><?php echo $scholarship['deadline']; ?></td>
                                <td><?php echo $scholarship['status']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editScholarship(this)"
                                    data-scholarship_id="<?php echo $scholarship['scholarship_id']; ?>"
                                    data-name="<?php echo $scholarship['name']; ?>"
                                    data-description="<?php echo $scholarship['description']; ?>"
                                    data-requirements="<?php echo $scholarship['requirements']; ?>"
                                    data-deadline="<?php echo $scholarship['deadline']; ?>"
                                    data-status="<?php echo $scholarship['status']; ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" 
                                            onclick="confirmScholarshipDelete('<?php echo $scholarship['scholarship_id']; ?>')">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="noResults" style="display: none;" class="alert alert-info text-center">
                        No scholarships found matching your search.
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Scholarship Modal -->
    <div class="modal fade" id="addScholarshipModal" tabindex="-1" role="dialog" aria-labelledby="addScholarshipModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScholarshipModalLabel">Add Scholarship</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="scholarship.php">
                        <div class="form-group">
                            <label for="scholarship_id">Scholarship ID</label>
                            <input type="text" name="scholarship_id" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea name="requirements" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" name="deadline" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_scholarship">Add Scholarship</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Scholarship Modal -->
    <div class="modal fade" id="updateScholarshipModal" tabindex="-1" role="dialog" aria-labelledby="updateScholarshipModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateScholarshipModalLabel">Update Scholarship</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="scholarship.php">
                        <input type="hidden" name="scholarship_id" id="scholarship_id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea name="requirements" id="requirements" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_scholarship">Update Scholarship</button>
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
        // Prepopulate the Update Modal with the Scholarship's current details
        $('#updateScholarshipModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var scholarship_id = button.data('scholarship_id');
            var name = button.data('name');
            var description = button.data('description');
            var requirements = button.data('requirements');
            var status = button.data('status');
            
            var modal = $(this);
            modal.find('#scholarship_id').val(scholarship_id);
            modal.find('#name').val(name);
            modal.find('#description').val(description);
            modal.find('#requirements').val(requirements);
            modal.find('#status').val(status);
        });

        function searchScholarships() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.querySelector('.table');
            let tr = table.getElementsByTagName('tr');
            let noResults = document.getElementById('noResults');
            let visibleRows = 0;

            // Loop through all table rows, starting from index 1 to skip the header
            for (let i = 1; i < tr.length; i++) {
                let found = false;
                // Get all cells in the row
                let td = tr[i].getElementsByTagName('td');
                
                // Loop through all cells in the row
                for (let j = 0; j < td.length - 1; j++) { // -1 to skip the Actions column
                    let cell = td[j];
                    if (cell) {
                        let textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                // Show/hide the row based on whether the search term was found
                if (found) {
                    tr[i].style.display = '';
                    visibleRows++;
                } else {
                    tr[i].style.display = 'none';
                }
            }

            // Show/hide the "No results" message
            noResults.style.display = (visibleRows === 0 && filter !== '') ? 'block' : 'none';
        }

        // Add event listener for real-time search
        document.getElementById('searchInput').addEventListener('input', function() {
            searchScholarships();
        });

        // Add this function to your existing JavaScript
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            searchScholarships();
        }

        function printScholarships() {
            // Add current date
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            document.querySelector('.dashboard-section').setAttribute('data-print-date', dateStr);
            
            // Print
            window.print();
        }

        // Add this in the script section
        function confirmScholarshipDelete(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this scholarship deletion!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'scholarship_handle.php?delete=' + id;
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "The scholarship has been deleted.",
                        icon: "success"
                    });
                }
            });
        }

        function saveScholarship(form) {
            Swal.fire({
                title: "Save Scholarship",
                text: "Do you want to save these scholarship details?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Save",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Scholarship saved successfully"
                    });
                }
            });
            return false;
        }

        function showAddScholarshipForm() {
            Swal.fire({
                title: 'Add New Scholarship',
                html: `
                    <form id="addScholarshipForm">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements *</label>
                            <textarea class="form-control" name="requirements" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select class="form-control" name="status" required>
                                <option value="">Select status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline *</label>
                            <input type="date" class="form-control" name="deadline" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add Scholarship',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('addScholarshipForm');
                    const name = form.querySelector('[name="name"]').value.trim();
                    const description = form.querySelector('[name="description"]').value.trim();
                    const requirements = form.querySelector('[name="requirements"]').value.trim();
                    const status = form.querySelector('[name="status"]').value.trim();
                    const deadline = form.querySelector('[name="deadline"]').value.trim();

                    // Check for empty fields
                    if (!name) {
                        Swal.showValidationMessage('Scholarship name is required');
                        return false;
                    }
                    if (!description) {
                        Swal.showValidationMessage('Description is required');
                        return false;
                    }
                    if (!requirements) {
                        Swal.showValidationMessage('Requirements are required');
                        return false;
                    }
                    if (!status) {
                        Swal.showValidationMessage('Please select a status');
                        return false;
                    }
                    if (!deadline) {
                        Swal.showValidationMessage('Deadline is required');
                        return false;
                    }

                    // Validate deadline is not in the past
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const selectedDate = new Date(deadline);
                    if (selectedDate < today) {
                        Swal.showValidationMessage('Deadline cannot be in the past');
                        return false;
                    }

                    // If all validations pass, return the data
                    return {
                        add_scholarship: true,
                        name: name,
                        description: description,
                        requirements: requirements,
                        status: status,
                        deadline: deadline
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'scholarship.php';

                    for (const [key, value] of Object.entries(result.value)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    form.submit();

                    // Show success message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Scholarship added successfully'
                    });
                }
            });
        }

        function editScholarship(button) {
            const scholarshipData = {
                scholarship_id: button.dataset.scholarship_id,
                name: button.dataset.name,
                description: button.dataset.description,
                requirements: button.dataset.requirements,
                deadline: button.dataset.deadline,
                status: button.dataset.status
            };

            Swal.fire({
                title: 'Edit Scholarship',
                html: `
                    <form id="editScholarshipForm">
                        <input type="hidden" name="scholarship_id" value="${scholarshipData.scholarship_id}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="${scholarshipData.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" required>${scholarshipData.description}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="requirements">Requirements</label>
                            <textarea class="form-control" name="requirements" required>${scholarshipData.requirements}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="Active" ${scholarshipData.status === 'Active' ? 'selected' : ''}>Active</option>
                                <option value="Inactive" ${scholarshipData.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" name="deadline" value="${scholarshipData.deadline}" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('editScholarshipForm');
                    const formData = new FormData(form);
                    return Object.fromEntries(formData);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'scholarship.php';

                    for (const [key, value] of Object.entries(result.value)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    const updateButton = document.createElement('input');
                    updateButton.type = 'hidden';
                    updateButton.name = 'update_scholarship';
                    updateButton.value = '1';
                    form.appendChild(updateButton);

                    document.body.appendChild(form);
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
                        title: 'Scholarship updated successfully'
                    });
                }
            });
        }

        function confirmScholarshipDelete(scholarship_id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Delete Scholarship',
                text: 'Are you sure you want to delete this scholarship?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `scholarship.php?delete_scholarship_id=${scholarship_id}`;
                    swalWithBootstrapButtons.fire({
                        title: 'Deleted!',
                        text: 'The scholarship has been deleted.',
                        icon: 'success'
                    });
                }
            });
        }
    </script>
</body>
</html>