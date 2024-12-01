<?php
require_once 'database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();

    if (!$conn) {
        throw new Exception("Database connection failed");
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

$show_details = isset($_GET['id']) ? $_GET['id'] : null;

$query = "SELECT 
    application_id,
    scholarship_type,
    applicant_name,
    mobile_number,
    apply_date,
    status,
    date_of_birth,
    gender,
    email,
    sr_code,
    year_level,
    photo_path
FROM application 
ORDER BY apply_date DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">
    <title>Application History - Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/user_css/user_application-history.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <header id="header" class="d-flex justify-content-between align-items-center p-3 bg-light">
        <div class="logo d-flex align-items-center">
            <img src="/icons/logo.png" alt="Logo" width="40">
            <span class="ml-2">Scholarship Tracker System</span>
        </div>
        <div class="welcome d-flex align-items-center">
            <i class="fas fa-bell"></i> 
            <span class="badge badge-light ml-2">3</span>
            <span class="ml-4" id="userName"></span>
            <i class="fas fa-user-circle" style="font-size: 40px; margin-left: 10px;"></i>
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
                        <a class="nav-link" href="../php/user_schema.php">
                            <img src="../icons_user/view schema.png" alt="View Schema Icon"> View Schema
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../php/user_application-history.php">
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
            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 ml-sm-auto px-md-4">
                <div class="content-card">
                    <h2 style="font-size: 36px;">Application History</h2>
                    <hr class="hr">                      
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Application no.</th>
                                    <th>Scholarship Type</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Apply date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="applicationTableBody">
                                <!-- Will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div class="modal" id="studentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Student Applicant</h2>
                <span onclick="hideModal()" style="cursor: pointer;">✕</span>
            </div>
            <img src="icons_user/Formal Pic.jpeg" alt="Student Photo" class="student-photo">
            <div class="scholarship-type">Academic Excellence</div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" id="modal-name" readonly>
                </div>
                <div class="form-group">
                    <label>Date of birth:</label>
                    <input type="text" id="modal-dob" readonly>
                </div>
                <div class="form-group">
                    <label>Gender:</label>
                    <input type="text" id="modal-gender" readonly>
                </div>
                <div class="form-group">
                    <label>Mobile no:</label>
                    <input type="text" id="modal-mobile" readonly>
                </div>
                <div class="form-group">
                    <label>Application no:</label>
                    <input type="text" id="modal-app-no" readonly>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" id="modal-email" readonly>
                </div>
                <div class="form-group">
                    <label>Sr-Code:</label>
                    <input type="text" id="modal-srcode" readonly>
                </div>
                <div class="form-group">
                    <label>Year Level:</label>
                    <input type="text" id="modal-year" readonly>
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <input type="text" id="modal-status" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button class="close-btn" onclick="hideModal()">Close</button>
                <button class="print-btn" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script>
    function loadApplications() {
        const applications = JSON.parse(localStorage.getItem('applications') || '[]');
        const tableBody = document.getElementById('applicationTableBody');
        
        if (applications.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7">No applications found</td></tr>';
            return;
        }
        
        tableBody.innerHTML = applications.map(app => `
            <tr>
                <td>${app.application_no}</td>
                <td>${app.scholarship_type || 'Academic Excellence'}</td>
                <td>${app.name}</td>
                <td>${app.mobile}</td>
                <td>${app.apply_date}</td>
                <td>${app.status}</td>
                <td>
                    <button class="view-details-btn" onclick='showModal(${JSON.stringify(app)})'>
                        VIEW DETAILS
                    </button>
                    <button class="delete-btn" onclick='deleteApplication("${app.application_no}")'>
                        DELETE
                    </button>
                </td>
            </tr>
        `).join('');
    }

    document.addEventListener('DOMContentLoaded', loadApplications);

    function showModal(application) {
        document.querySelector('.student-photo').src = application.photo || 'icons_user/Formal Pic.jpeg';
        document.querySelector('.scholarship-type').textContent = application.scholarship_type || 'Academic Excellence';
        
        document.getElementById('modal-name').value = application.name;
        document.getElementById('modal-dob').value = application.dob;
        document.getElementById('modal-gender').value = application.gender;
        document.getElementById('modal-mobile').value = application.mobile;
        document.getElementById('modal-email').value = application.email;
        document.getElementById('modal-srcode').value = application.srcode;
        document.getElementById('modal-year').value = application.year;
        document.getElementById('modal-app-no').value = application.application_no;
        document.getElementById('modal-status').value = application.status;

        document.getElementById('studentModal').style.display = 'block';
    }

    function hideModal() {
        const modal = document.getElementById('studentModal');
        modal.style.display = 'none';
    }
   document.head.insertAdjacentHTML('beforeend', `
       <style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
        overflow-y: auto;
        padding: 1px;
    }

    .modal-content {
        background-color: white;
        width: 90%;
        max-width: 700px;
        margin: 20px auto;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
        padding-bottom: 0px;
        border-bottom: 1px solid #e0e0e0;
    }

    .modal-header h2 {
        font-size: 20px;
        color: #2c3e50;
        margin: 0;
    }

    .student-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 15px;
        display: block;
        border: 3px solid #f8f9fa;
    }

    .scholarship-type {
        text-align: center;
        font-size: 1.2em;
        margin-bottom: 20px;
        font-weight: bold;
        color: #2c3e50;
        padding: 8px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    .modal-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px;
        padding: 10px 0;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
        color: #495057;
        font-size: 0.9em;
    }

    .form-group input[readonly] {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #212529;
        font-size: 0.9em;
        line-height: 1.5;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }

    .close-btn, .print-btn {
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9em;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            padding: 15px;
            margin: 10px auto;
        }
        
        .modal-body {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        
        .form-group {
            margin-bottom: 8px;
        }
    }

    /* Add this to ensure text is visible */
    .form-group input[readonly] {
        background-color: #ffffff;
        border: 1px solid #ced4da;
    }

    /* Add hover effect to show it's clickable */
    .form-group input[readonly]:hover {
        background-color: #f8f9fa;
    }

    /* Add these new styles */
    .delete-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 5px;
        font-size: 0.9em;
    }

    .delete-btn:hover {
        background-color: #c82333;
    }

    /* Update the table cell styling to accommodate both buttons */
    .table td:last-child {
        white-space: nowrap;
    }
    </style>
    `);

    function deleteApplication(applicationNo) {
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
                let applications = JSON.parse(localStorage.getItem('applications') || '[]');
                
                applications = applications.filter(app => app.application_no !== applicationNo);
                
                localStorage.setItem('applications', JSON.stringify(applications));
                
                loadApplications();
                
                Swal.fire(
                    'Deleted!',
                    'Your application has been deleted.',
                    'success'
                );
            }
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>