<?php 

session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=Please log in to access your account.");
    exit;
}
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the session is not set
    header("Location: login.php?error=Please log in first.");
    exit;
}

$song = "sounds/Stardew Valley Overture.wav"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Garden</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <style>
        /* CSS for Toast Notification */
        .toast {
            visibility: hidden;
            position: fixed;
            top: 30px;
            left: 10%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
        }

        .toast.show {
            visibility: visible;
            animation: fadeInOut 3s forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }

        .toast.success {
            background-color: #4CAF50; /* Green */
        }

        .toast.error {
            background-color: #f44336; /* Red */
        }
    </style>
</head>
<body>
    <div class="home-container">
        <!-- Centered Logo and Button -->
        <div class="main-content">
            <img src="image/icons/SkyGarden.png" class="logo-image hli"></img>
            <a href="plants.php"><button id="enterGarden" class="gardenBtn">Enter Garden</button></a>
        </div>
    </div>
        <!-- User Info at the top right -->
        <div class="user-info">
            <!-- Display the logged-in user's username -->
            <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
            <i class="fa-solid fa-circle-user fa-2x" id="user-icon"></i>
        </div>
        <audio class="background-music" id = "audioPlayer" src="<?php echo $song; ?>" loop></audio>

    <!-- Toast notification div -->
    <div id="toast" class="toast"></div>

    <!-- JavaScript for Toast handling -->
    <script>
        // Check for error or success messages passed via URL
        <?php if (isset($_GET['error'])): ?>
            showToast("<?php echo $_GET['error']; ?>", false);
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            showToast("<?php echo $_GET['success']; ?>", true);
        <?php endif; ?>

        // Toast function
        function showToast(message, isSuccess) {
            const toast = document.getElementById('toast');
            toast.innerText = message;
            toast.classList.add('show');
            toast.classList.add(isSuccess ? 'success' : 'error');
            setTimeout(() => toast.classList.remove('show'), 4000); // Remove after 4 seconds
        }
    </script>

    <!-- Include Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="js/game.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
