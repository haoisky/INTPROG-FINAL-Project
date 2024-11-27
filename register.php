<?php 

session_start();
include 'connect.php'; // Include your database connection

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form contents
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if any field is empty
    if (empty($username) || empty($email) || empty($password)) {
        header("Location: landing.php?error=All fields are required.");
        exit;
    }

    // Check if email or username already exists in the database
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username or email already exists
        header("Location: landing.php?error=Username or email is already taken.");
    } else {
        // Hash the password before storing it for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert values into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Account created successfully
            header("Location: landing.php?success=Account created successfully!");
        } else {
            // Error while creating account
            header("Location: landing.php?error=Failed to create account. Please try again.");
        }
    }

    $stmt->close();
    $conn->close();
}
?>
