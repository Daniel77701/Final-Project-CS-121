<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

if (!file_exists('uploads/photos')) {
    mkdir('uploads/photos', 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->begin_transaction();

        $application_no = 'APP' . time() . rand(100, 999);

        $photo_path = '';
        if (isset($_FILES['photo'])) {
            $photo_path = 'uploads/photos/' . time() . '_' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }

        $stmt = $conn->prepare("INSERT INTO applications (
            application_no, schema_id, scholarship_type, photo_path, applicant_name, 
            date_of_birth, gender, mobile_number, email, 
            sr_code, year_level, status, apply_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");

        $scholarship_type = $_POST['scholarship_type'];
        $stmt->bind_param("sssssssssss",
            $application_no,
            $_POST['schema_id'],
            $scholarship_type,
            $photo_path,
            $_POST['name'],
            $_POST['dob'],
            $_POST['gender'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['srcode'],
            $_POST['year']
        );
        
        $stmt->execute();
        $application_id = $conn->insert_id;

        if (isset($_FILES['documents'])) {
            $stmt = $conn->prepare("INSERT INTO application_documents (
                application_id, document_path, document_type
            ) VALUES (?, ?, ?)");

            foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
                $doc_path = 'uploads/documents/' . time() . '_' . $_FILES['documents']['name'][$key];
                move_uploaded_file($tmp_name, $doc_path);
                
                $doc_type = pathinfo($_FILES['documents']['name'][$key], PATHINFO_EXTENSION);
                
                $stmt->bind_param("iss", $application_id, $doc_path, $doc_type);
                $stmt->execute();
            }
        }

        $conn->commit();
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'applicationId' => $application_id
        ]);
        exit;

    } catch (Exception $e) {
        if (isset($conn)) {
            $conn->rollback();
        }
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

$query = $conn->prepare("SELECT * FROM scholarship_schema ORDER BY submission_deadline DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
    <title>Scholarship Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../user_css/user_schema.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Header Section -->
    <header id="header" class="d-flex justify-content-between align-items-center p-3" style="background-color: #d1182d !important;">
        <div class="logo d-flex align-items-center">
            <img src="../icons/logo.png" alt="Logo" width="40">
            <span class="ml-2" style="color: white;">Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center">
            <div class="notification-bell">
                <button class="btn" type="button" style="background: none;">
                        <i class="fas fa-bell" style="color: white; font-size: 20px;"></i>
                        <span class="badge rounded-pill bg-danger" id="notificationCount">0</span>
                    </button>
                <div class="notification-list">
                    <h6 class="notification-header">Notifications</h6>
                        <div id="notificationList">
                            <!-- Notifications will be loaded here -->
                    </div>
                </div>
            </div>
            <span class="ml-4" id="userName" style="color: white;"></span>
            <i class="fas fa-user-circle" style="color: white; font-size: 40px; margin-left: 10px;"></i>
        </div>
    </header>

    <script>
    const userData = JSON.parse(localStorage.getItem('userData'));
    if (userData && userData.name) {
        document.getElementById('userName').textContent = userData.name;
    } else {
        window.location.href = 'user_login.html';
    }
    </script>

<div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar bg-light p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../html/user_dashboard.html">
                            <img src="../icons_user/dashboard.png" alt="Dashboard Icon"> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../php/user_schema.php">
                            <img src="../icons_user/view schema.png" alt="View Schema Icon"> View Schema
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/user_application-history.php">
                            <img src="../icons_user/application history.png" alt="Application History Icon"> Application History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/user_profile.html">
                            <img src="../icons_user/profile.png" alt="Profile Icon"> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/user_settings.html">
                            <img src="../icons_user/setting.png" alt="Setting Icon"> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/user_logout.html">
                            <img src="../icons_user/logout.png" alt="Logout Icon"> Logout
                        </a>
                    </li>
                </ul>
            </nav>
  

            <main class="main-content col-12 col-md-9 col-lg-10">
                <div class="content-card">
                    <h2 style="font-size: 36px;">View Schema</h2>
                    <hr class="hr">                      
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Application no.</th>
                                    <th>Scholarship Type</th>
                                    <th>Scholarship Grade</th>
                                    <th>Last date of submission</th>
                                    <th>Published date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
    $query->execute();
    $rows = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($rows) {
        do {
    ?>
        <tr>
            <td><?php echo htmlspecialchars($rows['schema_id']); ?></td>
            <td><?php echo htmlspecialchars($rows['scholarship_type']); ?></td>
            <td><?php echo htmlspecialchars($rows['grade_campus']); ?></td>
            <td><?php echo date('F j, Y', strtotime($rows['submission_deadline'])); ?></td>
            <td><?php echo date('F j, Y', strtotime($rows['published_date'])); ?></td>
            <td><?php echo htmlspecialchars($rows['status']); ?></td>
            <td>
                <button class="view-details-btn" 
                        onclick='showDetailsModal(<?php echo json_encode($rows); ?>)'>
                    VIEW DETAILS
                </button>
            </td>
        </tr>
    <?php
        } while ($rows = $query->fetch(PDO::FETCH_ASSOC));
    } else {
        echo "<tr><td colspan='7'>No scholarships available</td></tr>";
    }
    ?>
</tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
        
        <div class="modal" id="detailsModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>View Details</h2>
                    <span onclick="hideDetailsModal()" style="cursor: pointer;">✕</span>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Scholarship Type</td>
                            <td>Academic Excellence</td>
                        </tr>
                        <tr>
                            <td>Grade and Campus</td>
                            <td>1st Year BSU-Lipa</td>
                        </tr>
                        <tr>
                            <td>Year Scholarship</td>
                            <td>2024-2025</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>Merit-based</td>
                        </tr>
                        <tr>
                            <td>Criteria</td>
                            <td>Applicants must have an overall average of <strong>90%</strong> or above in their most recent academic year or term.</td>
                        </tr>
                        <tr>
                            <td>Last date of submission</td>
                            <td>November 15, 2024</td>
                        </tr>
                        <tr>
                            <td>Document Required</td>
                            <td>Birth Certificate, Report Card, Enrollment Form</td>
                        </tr>
                        <tr>
                            <td>Scholarship Description</td>
                            <td>Rewards outstanding students who consistently achieve high grades</td>
                        </tr>
                        <tr>
                            <td>Scholarship Amount (per sem)</td>
                            <td>3000 pesos</td>
                        </tr>
                    </table>
                    <button class="apply-button" onclick="showApplyModal()">Apply Now</button>
                </div>
            </div>
        </div>

        <div id="applyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Apply Now</h2>
            <span onclick="hideApplyModal()" style="cursor: pointer;">✕</span>
        </div>
        <div class="modal-body">
            <form id="applicationForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">Profile Picture:</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <div class="photo-preview-container">
                        <img id="photoPreview" src="#" alt="Profile Preview" 
                             style="display: none; max-width: 150px; height: 150px; 
                                    border-radius: 50%; object-fit: cover; margin: 10px auto;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile no:</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="srcode">Sr-Code:</label>
                    <input type="text" id="srcode" name="srcode" required>
                </div>
                <div class="form-group">
                    <label for="year">Year Level:</label>
                    <select id="year" name="year" required>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-close" onclick="hideApplyModal()">Close</button>
                    <button type="submit" class="btn btn-submit">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>
    function showDetailsModal(scholarshipData) {
        const modal = document.getElementById('detailsModal');
        modal.style.display = 'block';
        
        document.querySelector('#detailsModal .table').innerHTML = `
            <tr>
                <td>Scholarship Type</td>
                <td>${scholarshipData.scholarship_type}</td>
            </tr>
            <tr>
                <td>Grade and Campus</td>
                <td>${scholarshipData.grade_campus}</td>
            </tr>
            <tr>
                <td>Year Scholarship</td>
                <td>${scholarshipData.year_scholarship}</td>
            </tr>
            <tr>
                <td>Category</td>
                <td>${scholarshipData.category}</td>
            </tr>
            <tr>
                <td>Criteria</td>
                <td>${scholarshipData.criteria}</td>
            </tr>
            <tr>
                <td>Last date of submission</td>
                <td>${new Date(scholarshipData.submission_deadline).toLocaleDateString()}</td>
            </tr>
            <tr>
                <td>Document Required</td>
                <td>${scholarshipData.required_documents}</td>
            </tr>
            <tr>
                <td>Scholarship Description</td>
                <td>${scholarshipData.description}</td>
            </tr>
            <tr>
                <td>Scholarship Amount (per sem)</td>
                <td>${scholarshipData.amount_per_sem} pesos</td>
            </tr>
        `;
        
        document.getElementById('schema_id').value = scholarshipData.schema_id;
    }

    function hideDetailsModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    function showApplyModal() {
        hideDetailsModal();
        document.getElementById('applyModal').style.display = 'block';
    }

    function hideApplyModal() {
        document.getElementById('applyModal').style.display = 'none';
    }

    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const photoPreview = document.getElementById('photoPreview');
            photoPreview.src = e.target.result;
            photoPreview.style.display = 'block';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('applicationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Submit Application?',
            text: 'Are you sure you want to submit this scholarship application?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const reader = new FileReader();
                if (document.getElementById('photo').files[0]) {
                    reader.readAsDataURL(document.getElementById('photo').files[0]);
                    reader.onload = function(e) {
                        const applicationData = {
                            photo: e.target.result,
                            name: document.getElementById('name').value,
                            dob: document.getElementById('dob').value,
                            gender: document.getElementById('gender').value,
                            mobile: document.getElementById('mobile').value,
                            email: document.getElementById('email').value,
                            srcode: document.getElementById('srcode').value,
                            year: document.getElementById('year').value,
                            application_no: "APP" + Math.floor(Math.random() * 90000 + 10000),
                            status: "Pending",
                            apply_date: new Date().toISOString().split('T')[0]
                        };

                        let applications = JSON.parse(localStorage.getItem('applications') || '[]');
                        applications.push(applicationData);
                        localStorage.setItem('applications', JSON.stringify(applications));

                        Swal.fire({
                            title: 'Success!',
                            text: 'Your application has been submitted successfully',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'user_application-history.php';
                            }
                        });
                    };
                }
            }
        });
    });
    </script>
    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add the notifications script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBell = document.querySelector('.notification-bell');
            const notificationList = document.querySelector('.notification-list');
            
            // Show/hide notifications when clicking the bell
            notificationBell.querySelector('.btn').addEventListener('click', function(e) {
                e.stopPropagation();
                notificationList.style.display = notificationList.style.display === 'block' ? 'none' : 'block';
            });
            
            // Hide notifications when clicking outside
            document.addEventListener('click', function(e) {
                if (!notificationBell.contains(e.target)) {
                    notificationList.style.display = 'none';
                }
            });
        });

        // Update the loadNotifications function
        function loadNotifications() {
            fetch('../php/get_notifications.php')
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');
                    const notificationCount = document.getElementById('notificationCount');
                    
                    if (data.success && data.notifications && data.notifications.length > 0) {
                        notificationCount.textContent = data.notifications.length;
                        
                        notificationList.innerHTML = data.notifications.map(notification => `
                            <div class="notification-item">
                                    <div class="d-flex align-items-center">
                                    <div class="notification-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    <div class="notification-content">
                                            <div class="notification-message">
                                                ${notification.message}
                                            </div>
                                        <small class="text-muted">
                                            ${new Date(notification.timestamp).toLocaleString()}
                                        </small>
                                    </div>
                                        </div>
                                    </div>
                        `).join('');
                        
                    } else {
                        notificationCount.textContent = '0';
                        notificationList.innerHTML = `
                            <div class="notification-item text-center text-muted">
                                No new notifications
                            </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.getElementById('notificationList').innerHTML = `
                        <div class="notification-item text-center text-danger">
                            Error loading notifications
                        </div>`;
                    document.getElementById('notificationCount').textContent = '0';
                });
        }
    </script>

    <!-- Initialize the dropdown -->
    <script>
    $(document).ready(function() {
        // Initialize all dropdowns
        $('.dropdown-toggle').dropdown();
        
        // Load notifications
        loadNotifications();
        
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });
    </script>
    <style>
    .notification-bell {
        position: relative;
        margin-right: 20px;
    }

    .notification-bell .btn {
        background: none;
        border: none;
        padding: 0;
        position: relative;
    }

    .notification-bell .btn:focus {
        box-shadow: none;
    }

    .notification-list {
        position: absolute;
        top: 100%;
        right: 0;
        width: 300px;
        background: white;
        border: 1px solid #eee;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 10px;
        z-index: 1000;
        display: none;
    }

    .notification-header {
        background: white;
        color: #333;
        font-weight: bold;
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
        margin: 0;
        font-size: 13px;
    }

    .notification-item {
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
        color: #333;
        text-decoration: none;
        display: block;
        background: white;
        font-size: 12px;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .notification-message {
        margin-bottom: 3px;
        color: #333;
        font-size: 15px;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 11px !important;
    }

    .notification-item .fas.fa-graduation-cap {
        color: #333;
        font-size: 1.1em;
        margin-right: 8px;
    }
    </style>
</body>
</html>