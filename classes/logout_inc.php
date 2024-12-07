<?php

session_start();
session_unset();
session_destroy();


header("location: ../usersignup.html?message=logoutsuccess");
exit();
?>
