<?php 
session_start(); 

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=Username is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // hashing the password
        $pass = md5($pass);

        // Load users from JSON file
        $users = [];
        $usersFile = 'users.json';
        if (file_exists($usersFile)) {
            $users = json_decode(file_get_contents($usersFile), true);
        }

        // Check if user exists and credentials match
        $loggedIn = false;
        foreach ($users as $user) {
            if ($user['user_name'] === $uname && $user['password'] === $pass) {
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['id'] = $user['id']; // Add user ID if available
                $loggedIn = true;
                break;
            }
        }

        if ($loggedIn) {
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=Incorrect User name or password");
            exit();
        }
    }
    
} else {
    header("Location: index.php");
    exit();
}
?>
