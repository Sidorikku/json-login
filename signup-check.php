<?php
session_start();

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
    && isset($_POST['email']) && isset($_POST['bday'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $bday = validate($_POST['bday']);

    // Additional validation can be added for email format and birthday format if required

    if (empty($uname) || empty($pass) || empty($re_pass) || empty($name) || empty($email) || empty($bday)) {
        header("Location: signup.php?error=All fields are required");
        exit();
    } elseif ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match");
        exit();
    } else {
        // hashing the password
        $pass = md5($pass);

        // Load existing users from JSON file
        $users = [];
        $usersFile = 'users.json';
        if (file_exists($usersFile)) {
            $users = json_decode(file_get_contents($usersFile), true);
        }

        // Check if username is already taken
        foreach ($users as $user) {
            if ($user['user_name'] === $uname) {
                header("Location: signup.php?error=The username is taken, please try another");
                exit();
            }
        }

        // Add new user to the array
        $newUser = [
            'user_name' => $uname,
            'password' => $pass,
            'name' => $name,
            'email' => $email,
            'birthday' => $bday
        ];
        $users[] = $newUser;

        // Save updated array back to JSON file
        file_put_contents($usersFile, json_encode($users));

        // Redirect with success message
        header("Location: signup.php?success=Your account has been created successfully");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
