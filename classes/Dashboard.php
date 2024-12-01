<?php
require_once 'Database.php';

class Dashboard extends Database {
    public function render() {
        echo "Rendering Dashboard...\n";
    }

    public function renderUserDashboard($user) {
        echo "Rendering User Dashboard for: " . $user['name'] . "\n";
        echo "Email: " . $user['email'] . "\n";
    }

    public function renderApplicationHistory($applications) {
        echo "Application History:\n";
        foreach ($applications as $app) {
            echo "ID: " . $app['id'] . ", Name: " . $app['name'] . ", Status: " . $app['status'] . "\n";
        }
    }
}
?>
