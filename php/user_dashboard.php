<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../html/user_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../icons/logo.png" type="image/x-icon">
    <title>Welcome - Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../user_css/user_dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Store user data first
        const userData = {
            name: '<?php echo htmlspecialchars($_SESSION["user_name"]); ?>',
            email: '<?php echo htmlspecialchars($_SESSION["user_email"]); ?>',
            srcode: '<?php echo htmlspecialchars($_SESSION["user_srcode"]); ?>'
        };
        localStorage.setItem('userData', JSON.stringify(userData));

        // Then show welcome message
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Welcome, ' + userData.name + '!',
                text: 'Login successful',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                window.location.href = '../html/user_dashboard.html';
            });
        });
    </script>
</body>
</html> 