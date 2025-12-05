<?php
header('Content-Type: application/json');

// Get the user ID from the request parameter
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "ID parameter is missing."]);
    exit();
}

// --- VULNERABILITY: Predictable Parameter & Insecure Direct Object Reference (IDOR) ---
// Simulates a simple database lookup based on ID.
switch ($user_id) {
    case '1':
        // The root admin's profile, containing the flag
        $profile_data = [
            "id" => 1,
            "username" => "RootAdmin",
            "access_level" => "MAX",
            "secret_note" => "The second flag is: FLAG-2{YnJ1dGVfZm9yY2VfaXNfeW91cl9mcmllbmQ=}"
        ];
        break;
    case '123':
        // A standard user's profile
        $profile_data = [
            "id" => 123,
            "username" => "standard_user_123",
            "access_level" => "LOW",
            "secret_note" => "You must be logged in to view profiles."
        ];
        break;
    default:
        if ($user_id > 0 && $user_id <= 10) {
            // A placeholder for other "test" users
            $profile_data = [
                "id" => (int)$user_id,
                "username" => "TestUser_" . $user_id,
                "access_level" => "MEDIUM",
                "secret_note" => "This is not the admin you are looking for."
            ];
        } else {
            // ID not found
            $profile_data = [
                "status" => "error",
                "message" => "Profile ID " . htmlspecialchars($user_id) . " not found in the system."
            ];
        }
        break;
}

echo json_encode($profile_data, JSON_PRETTY_PRINT);
?>