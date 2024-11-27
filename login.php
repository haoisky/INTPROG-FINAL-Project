<?php 
session_start();
include 'connect.php'; // Connect the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if no fields are empty
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=All fields are required");
        exit;
    }

    // Check the database according to the inputted username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Password verification
        if (password_verify($password, $row['password'])) {
            // Login success
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: home.php?success=Login successful!");
            exit;
        } else {
            // Incorrect password
            header("Location: landing.php?error=Incorrect password!");
            exit;
        }
    } else {
        // Username not found
        header("Location: landing.php?error=Username not found!");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
