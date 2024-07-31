<?php 
session_start();

if (isset($_SESSION['user_name'])) {
    // Load users from JSON file
    $users = [];
    $usersFile = 'users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true);
    }

    $uname = $_SESSION['user_name'];
    $user = null;

    // Find the user by username
    foreach ($users as $u) {
        if ($u['user_name'] === $uname) {
            $user = $u;
            break;
        }
    }

    if (!$user) {
        // Handle case where username is not found (should not normally happen in a valid session)
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="styling.css">
</head>
<body>
    <h2>Edit Profile</h2>
    <form action="update-profile.php" method="post">
        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>
        
        <label>Username</label>
        <input type="text" name="uname" value="<?php echo $user['user_name']; ?>" disabled><br>
        
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>
        
        <label>Birthday</label>
        <input type="date" name="bday" value="<?php echo $user['birthday']; ?>"><br>
        
        <!-- Add more fields as needed -->
        
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>

<?php 
} else {
    header("Location: index.php");
    exit();
}
?>
