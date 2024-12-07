<?php
require_once '../classes/FAQ\'S_handler.php';

header('Content-Type: application/json');

try {
    $faq = new FAQ();
    $faqs = $faq->getFAQs(); // This already filters for active FAQs only
    
    echo json_encode([
        'success' => true,
        'faqs' => $faqs
    ]);
} catch (Exception $e) {
    error_log("Error getting FAQs: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Failed to load FAQs'
    ]);
}
?> 