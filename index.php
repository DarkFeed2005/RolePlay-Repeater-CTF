<?php

function login() {
   
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      
        setcookie("role", "guest", time() + 3600, "/"); 
        header("Location: index.php?page=dashboard");
        exit();
    }
}

// Check for login attempt
if (isset($_POST['login'])) {
    login();
}

// Check if the user is "logged in" by the presence of the cookie
$is_logged_in = isset($_COOKIE['role']);

// Router
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Hidden Admin CTF</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        h1, h2 { text-align: center; }
        .flag { background-color: #fdd; padding: 10px; border: 1px dashed #f00; text-align: center; }
        form input { margin-bottom: 10px; padding: 10px; width: 90%; }
        .button { padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>The Hidden Admin CTF</h1>

        <?php if (!$is_logged_in || $page == 'home'): ?>
            <h2>Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="submit" name="login" class="button" value="Log In">
            </form>
            <p>Hint: Any credentials will work to get you into the dashboard, but not the flag!</p>
        
        <?php elseif ($page == 'dashboard'): ?>
            <h2>User Dashboard</h2>
            <p>Welcome, User. You are currently logged in with a privilege level of: **<?php echo $_COOKIE['role']; ?>**</p>
            
            <h3>Challenge 2 Setup: User API</h3>
            <p>You can view a profile through our API.</p>
            <p>
                <a href="/api/profile.php?id=123" target="_blank" class="button">View My Profile (ID 123)</a>
            </p>
            <p>
                **Clue:** The root admin profile is usually ID `1`. Can you find it?
            </p>
            
            <hr>
            <h3>Challenge 1 Clue: Hidden Admin Panel</h3>
            <p>There is a special admin dashboard for internal use, but only staff with the **'admin'** role can access it.</p>
            <p>You'll need to find the correct, unlinked URL and bypass the check.</p>

        <?php endif; ?>
    </div>
</body>
</html>