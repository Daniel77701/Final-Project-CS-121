<?php
require_once '../classes/dbh.classes.php';

try {
    $sql = "SELECT year_level, COUNT(*) AS count FROM scholars GROUP BY year_level";
    $stmt = (new Dbh())->connect()->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
        echo json_encode(['error' => 'No data found']);
        exit;
    }

    $chartData = [];
    foreach ($data as $row) {
        $chartData[] = [
            'name' => $row['year_level'],
            'y' => (int) $row['count']
        ];
    }

    echo json_encode($chartData);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
