<?php 

session_start();
include 'connect.php';

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="plants-container">
        <!-- Heading -->
        <h3 class="choose-plant">Choose your first plant!</h3>
        
        <!-- Plants Section -->
        <div class="plants">
            <!-- Rose Plant -->
            <div class="plant-box">
                <div class="inner-box">
                <img src="image/plants/rose/4.png" id="enterGame" class="plant-image rose" data-type="rose" alt="Rose">
                    <p class="plant-name">Rose</p>
                </div>
            </div>
            <!-- Sunflower Plant -->
            <div class="plant-box" data-type="sunflower">
                <div class="inner-box">
                    <img src="image/plants/sunflower/4.png" id="enterGame" class="plant-image" data-type="sunflower" alt="Sunflower">
                    <p class="plant-name">Sunflower</p>
                </div>
            </div>
            <!-- Tulip Plant -->
            <div class="plant-box" data-type="tulip">
                <div class="inner-box">
                    <img src="image/plants/tulip/4.png" id="enterGame" class="plant-image" data-type="tulip" alt="Tulip">
                    <p class="plant-name">Tulips</p>
                </div>
            </div>
        </div>

    </div>    

    <!-- User Info at the top right -->
    <div class="user-info">
        <!-- Display the logged-in user's username -->
        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
        <i class="fa-solid fa-circle-user fa-2x" id="user-icon"></i>
    </div>
    <audio class="background-music" id = "audioPlayer" src="<?php echo $song; ?>" loop></audio>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const audioPlayer = document.getElementById('audioPlayer');
            audioPlayer.volume = 0.5; // Optional: Set default volume
            audioPlayer.muted = true; // Start muted to bypass autoplay restrictions
            audioPlayer.play().then(() => {
                audioPlayer.muted = false; // Unmute after playback starts
            }).catch(error => {
                console.error("Autoplay was blocked. Ensure browser settings allow autoplay.");
            });
        });
    </script>
    <script src="js/script.js"></script>
</body>
</html>
