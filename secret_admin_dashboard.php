<?php
// Check for the "role" cookie
$role = $_COOKIE['role'] ?? 'guest';

// --- VULNERABILITY: Access Control based on easily manipulated cookie value ---
if ($role === 'admin') {
    $message = '
        <h2>🎉 Congratulations! Access Granted! 🎉</h2>
        <p>You successfully manipulated your session privileges.</p>
        <div class="flag">
            FLAG-1{SGV5IS4gd2VsY29tZSB0byA/ZGFya2ZlZWQyMDA1Pw==}
        </div>
    ';
} else {
    $message = '
        <h2>🚫 Access Denied 🚫</h2>
        <p>Your current role is **' . htmlspecialchars($role) . '**. This page is restricted to **admin** roles only.</p>
        <p>Try capturing and modifying your request using Burp Suite Repeater.</p>
    ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secret Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background-color: #f4f4f4;}
        .container { max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #ccc; border-radius: 8px; background-color: white; }
        .flag { background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center; font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Internal Staff Dashboard</h1>
        <?php echo $message; ?>
        <p><a href="index.php?page=dashboard">Back to Dashboard</a></p>
    </div>
</body>
</html>