<?php
// Function to generate a random password
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
    $password = '';
    $charLength = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[mt_rand(0, $charLength)];
    }

    return $password;
}

// Sample user data array with specific usernames, IDs, and generated passwords
$usersData = array(
    array('id' => 1, 'username' => 'user1', 'password' => generateRandomPassword()),
    array('id' => 2, 'username' => 'user2', 'password' => generateRandomPassword()),
    
);

foreach ($usersData as $userData) {
    // Get user input
    $id = $userData['id'];
    $username = $userData['username'];
    $password = $userData['password'];

    // Validate inputs (you should perform more thorough validation)
    if (empty($id) || empty($username) || empty($password)) {
        die("ID, username, and password are required.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $pdo->prepare("INSERT INTO users (id, username, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$id, $username, $hashedPassword]);

    echo "ID: $id, Username: $username, Password: $password<br>";
}

echo "User accounts created successfully!";
?>
