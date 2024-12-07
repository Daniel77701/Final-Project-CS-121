<?php session_start(); // Check if user is logged in if (!isset($_SESSION['user_id'])) { header("Location: user_login.html"); exit(); } // Database connection $conn = new mysqli("localhost", "root", "", "scholarship_db"); if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); } // Add this after the database connection $upload_dir = "uploads/"; if (!file_exists($upload_dir)) { mkdir($upload_dir, 0777, true); } // Handle profile updates if ($_SERVER["REQUEST_METHOD"] == "POST") { $user_id = $_SESSION['user_id']; // Handle profile picture upload if (isset($_FILES['profilePicture'])) { $target_dir = "uploads/"; $file_extension = strtolower(pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION)); $new_filename = "profile_" . $user_id . "." . $file_extension; $target_file = $target_dir . $new_filename; if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) { $sql = "UPDATE users SET profile_picture = ? WHERE id = ?"; $stmt = $conn->prepare($sql); $stmt->bind_param("si", $target_file, $user_id); $stmt->execute(); } } // Handle other profile updates if (isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['contactNumber'])) { $fullName = $_POST['fullName']; $email = $_POST['email']; $contactNumber = $_POST['contactNumber']; $username = $_POST['username']; $sql = "UPDATE users SET full_name = ?, email = ?, contact_number = ?, username = ? WHERE id = ?"; $stmt = $conn->prepare($sql); $stmt->bind_param("ssssi", $fullName, $email, $contactNumber, $username, $user_id); if ($stmt->execute()) { $_SESSION['message'] = "Profile updated successfully!"; $_SESSION['user_name'] = $fullName; // Update session with new name } else { $_SESSION['error'] = "Error updating profile!"; } } } // Fetch user data $user_id = $_SESSION['user_id']; $sql = "SELECT * FROM users WHERE id = ?"; $stmt = $conn->prepare($sql); $stmt->bind_param("i", $user_id); $stmt->execute(); $result = $stmt->get_result(); $user = $result->fetch_assoc(); ?> 
<!DOCTYPE html> 
<html lang="en"> <head> 
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
     <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon"> 
     <title>Scholarship Tracker System</title> 
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
     <link rel="stylesheet" href="../user_css/user_profile.css">
     </head> 
     <body> 
        <!-- Header Section --> 
         <header id="header" class="d-flex justify-content-between align-items-center p-3 bg-light"> 
        <div class="logo d-flex align-items-center"> 
        <img src="../icons_user/logo.png" alt="Logo" width="40">
         <span class="ml-2">Scholarship Tracker System</span> </div> 
         <div class="welcome d-flex align-items-center"> 
            <i class="fas fa-bell"></i> 
            <span class="badge badge-light ml-2">3</span> 
            <span class="ml-4" id="userName">
                <?php echo htmlspecialchars($user['full_name']); ?></span>
                 <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'icons_user/default-profile.png'); ?>" alt="Profile" class="header-profile-pic" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;"> 
                  </div> 
                </header>

<div class="container-fluid">
    <main class="main-content">
        <div class="card">
            <h2 style="font-size: 36px;">Profile</h2>
            <hr class="hr">
            <form id="profileForm" method="POST" enctype="multipart/form-data">
                <div class="profile-content">
                    <div class="profile-image-container">
                        <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'icons_user/default-profile.png'); ?>" 
                             alt="Profile" 
                             class="profile-image-large" 
                             id="profilePreview">
                        <div class="mt-2">
                            <label for="profilePicture" class="btn btn-secondary">Change Picture</label>
                            <input type="file" name="profilePicture" id="profilePicture" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    <div class="profile-details">
                        <div class="grid grid-cols-2">
                            <div class="form-group">
                                <label for="fullName">Full name:</label>
                                <input type="text" name="fullName" id="fullName" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['full_name']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="contactNumber">Contact Number:</label>
                                <input type="tel" name="contactNumber" id="contactNumber" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['contact_number']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="registrationDate">Registration Date:</label>
                                <input type="date" name="registrationDate" id="registrationDate" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['registration_date']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            </div>
                        </div>
                        <div style="text-align: right;" class="mt-3">
                            <button type="button" class="btn btn-secondary" id="editBtn">Edit Profile</button>
                            <button type="submit" class="btn btn-primary" id="updateBtn" style="display: none;">Update</button>
                            <button type="button" class="btn btn-danger" id="cancelBtn" style="display: none;">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </main>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('editBtn');
        const updateBtn = document.getElementById('updateBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const profilePicInput = document.getElementById('profilePicture');
        const profilePreview = document.getElementById('profilePreview');
        const headerProfilePic = document.querySelector('.header-profile-pic');
        const inputs = document.querySelectorAll('.form-control');
        let originalValues = {};

        inputs.forEach(input => {
            originalValues[input.id] = input.value;
        });

        profilePicInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                    headerProfilePic.src = e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        editBtn.addEventListener('click', function() {
            inputs.forEach(input => {
                if (input.id !== 'registrationDate') {
                    input.disabled = false;
                }
            });
            editBtn.style.display = 'none';
            updateBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'inline-block';
        });

        cancelBtn.addEventListener('click', function() {
            inputs.forEach(input => {
                input.value = originalValues[input.id];
                input.disabled = true;
            });
            editBtn.style.display = 'inline-block';
            updateBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('user_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('userName').textContent = formData.get('fullName');
                
                inputs.forEach(input => {
                    input.disabled = true;
                    originalValues[input.id] = input.value;
                });

                editBtn.style.display = 'inline-block';
                updateBtn.style.display = 'none';
                cancelBtn.style.display = 'none';

                alert('Profile updated successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating profile!');
            });
        });
    });
</script>
</body> </html>