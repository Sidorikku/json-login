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
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="styling.css">
</head>
<body>
    <h1>Hello, <?php echo $user['name']; ?>! Welcome</h1>

    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <div class="buttons">
        <form action="edit-profile.php" method="get">
            <button type="submit" class="update-btn">Edit Profile</button>
        </form>
        
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Log Out</button>
        </form>
    </div>
</body>
</html>

<?php 
} else {
    header("Location: index.php");
    exit();
}
?>
