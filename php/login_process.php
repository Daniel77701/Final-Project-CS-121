<?php

// When logging in a student
if ($loginSuccessful) {
    $_SESSION['student_id'] = $studentId; // Make sure this is set
    $loginTracker = new LoginTracker();
    $loginTracker->logLogin($studentId);
    // ... rest of login code
} 