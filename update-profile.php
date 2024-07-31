<?php
session_start();

if (isset($_SESSION['user_name']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['bday'])) {
    $uname = $_SESSION['user_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];

    // Load users from JSON file
    $users = [];
    $usersFile = 'users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true);
    }

    $updated = false;

    // Update the user's information in the JSON data
    foreach ($users as &$user) {
        if ($user['user_name'] === $uname) {
            $user['name'] = $name;
            $user['email'] = $email;
            $user['birthday'] = $bday;
            $updated = true;
            break;
        }
    }

    // Save updated JSON data back to file
    file_put_contents($usersFile, json_encode($users));

    if ($updated) {
        // Redirect to home page after successful update
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating record: User not found";
    }
} else {
    // Redirect to edit profile page if session or POST data is not set
    header("Location: edit-profile.php");
    exit();
}
?>
