<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: user_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">
    <title>Welcome - Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="new_style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!',
                text: 'Login successful',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                const userData = {
                    name: '<?php echo htmlspecialchars($_SESSION["user_name"]); ?>',
                    email: '<?php echo htmlspecialchars($_SESSION["user_email"]); ?>',
                    srcode: '<?php echo htmlspecialchars($_SESSION["user_srcode"]); ?>'
                };
                localStorage.setItem('userData', JSON.stringify(userData));
                
                window.location.href = 'user_dashboard.html';
            });
        });
    </script>
</body>
</html> 