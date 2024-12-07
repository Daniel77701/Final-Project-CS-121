<?php
function getUnreadNotifications($userId) {
    return [
        [
            "id" => 1,
                "message" => "🎓 Congratulations! Your Academic Excellence Scholarship application for 2024 has been approved!",
            "type" => "success",
            "is_read" => false,
            "created_at" => date('Y-m-d H:i:s')
            ],
            [
            "id" => 2,
                "message" => "📚 New Scholarship Alert: BSU Merit Scholarship 2024 is now accepting applications. Apply before June 30!",
            "type" => "info",
            "is_read" => false,
            "created_at" => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ],
            [
            "id" => 3,
                "message" => "⚠️ Reminder: Please submit your Grade Report for the Academic Excellence Scholarship within 3 days.",
            "type" => "warning",
            "is_read" => false,
            "created_at" => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
            "id" => 4,
                "message" => "🎯 Important: Scholarship interview scheduled for June 5, 2024 at 10:00 AM. Location: Admin Building.",
            "type" => "important",
            "is_read" => false,
            "created_at" => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
            "id" => 5,
                "message" => "💰 Scholarship Grant: Your stipend of 3,000 pesos has been processed and will be released next week.",
            "type" => "info",
            "is_read" => false,
            "created_at" => date('Y-m-d H:i:s', strtotime('-2 days'))
        ]
    ];
}
?> 