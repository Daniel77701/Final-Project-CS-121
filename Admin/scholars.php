<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../classes/scholars_handler.php';
$scholars = new ScholarsHandler();

// Debug POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log('POST data received: ' . print_r($_POST, true));
    
    if (isset($_POST['add_scholar'])) {
        $result = $scholars->addScholar(
            $_POST['sr_code'],
            $_POST['name'],
            $_POST['course'],
            $_POST['year_level'],
            $_POST['scholarship']
        );
        if (!$result) {
            error_log('Failed to add scholar');
        }
    } elseif (isset($_POST['update_scholar'])) {
        $scholars->updateScholar(
            $_POST['sr_code'],
            $_POST['name'],
            $_POST['course'],
            $_POST['year_level'],
            $_POST['scholarship']
        );
    }
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Handle DELETE requests
if (isset($_GET['delete_sr_code'])) {
    $scholars->deleteScholar($_GET['delete_sr_code']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Get list of scholars for display
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
    <!-- Add SweetAlert2 in the head section -->
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
                    <li class="nav-item"><a class="nav-link active" href="scholars.php"><img src="icons_admin/scholars.png" alt="Scholars Icon"> Scholars</a></li>
                    <li class="nav-item"><a class="nav-link" href="scholarship.php"><img src="icons_admin/scholarships.png" alt="Scholarship Icon"> Scholarship</a></li>
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
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label for="entries" class="me-2 mb-0">Show</label>
                            <select id="entries" class="form-select me-3 mb-0"> 
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <div class="input-group" style="width: 250px;">
                                <input type="text" id="searchInput" placeholder="Search... " class="form-control mb-0">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="noResults" style="display: none;" class="alert alert-info text-center">
                        No scholars found matching your search.
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
                                    <button class="btn btn-warning btn-sm" onclick="editScholar(this)"
                                    data-sr_code="<?php echo $scholar['sr_code']; ?>"
                                    data-name="<?php echo $scholar['name']; ?>"
                                    data-course="<?php echo $scholar['course']; ?>"
                                    data-year_level="<?php echo $scholar['year_level']; ?>"
                                    data-scholarship="<?php echo $scholar['scholarship']; ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" 
                                            onclick="confirmScholarDelete('<?php echo $scholar['sr_code']; ?>')">Delete</button>
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
                            <label for="add_sr_code">Student SR Code</label>
                            <input type="text" name="sr_code" id="add_sr_code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="add_name">Name</label>
                            <input type="text" name="name" id="add_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="add_course">Course</label>
                            <input type="text" name="course" id="add_course" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="add_year_level">Year Level</label>
                            <input type="text" name="year_level" id="add_year_level" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="add_scholarship">Scholarship</label>
                            <input type="text" name="scholarship" id="add_scholarship" class="form-control" required>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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

        function searchScholars() {
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
                
                // Loop through all cells in the row except the Actions column
                for (let j = 0; j < td.length - 1; j++) {
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
            searchScholars();
        });

        // Function to clear the search
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            searchScholars();
        }

        // Add these functions to your script section
        function editScholar(button) {
            const scholarData = {
                sr_code: button.dataset.sr_code,
                name: button.dataset.name,
                course: button.dataset.course,
                year_level: button.dataset.year_level,
                scholarship: button.dataset.scholarship
            };

            Swal.fire({
                title: 'Edit Scholar',
                html: `
                    <form id="editScholarForm">
                        <input type="hidden" name="sr_code" value="${scholarData.sr_code}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="${scholarData.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" class="form-control" name="course" value="${scholarData.course}" required>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <input type="text" class="form-control" name="year_level" value="${scholarData.year_level}" required>
                        </div>
                        <div class="form-group">
                            <label for="scholarship">Scholarship</label>
                            <input type="text" class="form-control" name="scholarship" value="${scholarData.scholarship}" required>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('editScholarForm');
                    const formData = new FormData(form);
                    return Object.fromEntries(formData);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'scholars.php';

                    // Add hidden inputs for all fields
                    for (const [key, value] of Object.entries(result.value)) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value;
                        form.appendChild(input);
                    }

                    // Add update_scholar button
                    const updateButton = document.createElement('input');
                    updateButton.type = 'hidden';
                    updateButton.name = 'update_scholar';
                    updateButton.value = '1';
                    form.appendChild(updateButton);

                    document.body.appendChild(form);
                    form.submit();

                    // Show success toast
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Scholar updated successfully'
                    });
                }
            });
        }

        function confirmScholarDelete(sr_code) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Delete Scholar',
                text: 'Are you sure you want to remove this scholar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `scholars.php?delete_sr_code=${sr_code}`;
                    swalWithBootstrapButtons.fire({
                        title: 'Deleted!',
                        text: 'The scholar has been removed.',
                        icon: 'success'
                    });
                }
            });
        }

        // Update the showAddScholarForm function
        function showAddScholarForm() {
            Swal.fire({
                title: 'Add New Scholar',
                html: `
                    <form id="addScholarForm">
                        <div class="form-group">
                            <label for="sr_code">SR Code</label>
                            <input type="text" class="form-control" name="sr_code" required>
                        </div>
                        <!-- rest of the form fields -->
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add Scholar',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const form = document.getElementById('addScholarForm');
                    const formData = new FormData(form);
                    return Object.fromEntries(formData);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Check if SR Code exists
                    const sr_code = result.value.sr_code;
                    
                    fetch(`check_sr_code.php?code=${sr_code}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            Swal.fire({
                                title: 'Warning!',
                                text: 'This SR Code already exists. Please use a different code.',
                                icon: 'warning',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            // Proceed with form submission
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'scholars.php';

                            for (const [key, value] of Object.entries(result.value)) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = value;
                                form.appendChild(input);
                            }

                            const addButton = document.createElement('input');
                            addButton.type = 'hidden';
                            addButton.name = 'add_scholar';
                            addButton.value = '1';
                            form.appendChild(addButton);

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
                                title: 'Scholar added successfully'
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>