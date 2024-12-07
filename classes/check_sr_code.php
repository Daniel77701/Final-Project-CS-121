<?php
require_once '../connection/dbh.classes.php';

class SRCodeChecker extends Dbh {
    public function checkSRCode($code) {
        try {
            $stmt = $this->connect()->prepare("SELECT sr_code FROM scholars WHERE sr_code = ?");
            $stmt->execute([$code]);
            return [
                'exists' => $stmt->rowCount() > 0
            ];
        } catch (PDOException $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}

if (isset($_GET['code'])) {
    $checker = new SRCodeChecker();
    header('Content-Type: application/json');
    echo json_encode($checker->checkSRCode($_GET['code']));
}