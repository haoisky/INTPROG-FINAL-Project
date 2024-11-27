<?php
session_start();
require_once 'connect.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please log in to access your account.");
    exit;
}

// Retrieve plant data from sessionStorage or database
$plant_id = $_SESSION['plant_id'];
$selectedPlant = $_SESSION['plant_type'];

$song = "sounds/Stardew Valley Overture.wav"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Garden</title>
    <link rel="stylesheet" href="css/game.css?v=2">
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body class="game-container">
    <!-- User Icon -->
    <div class="users-info" id="users-info" data-user-id="<?php echo $_SESSION['user_id']; ?>">
        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
        <i class="fa-solid fa-circle-user fa-2x" id="user-icon"></i>
    </div>

    <!-- Logo -->
    <div class="logo">
        <img src="image/icons/game-logo.png" alt="Sky Garden Logo">
    </div>

    <!-- Sidebar Menu -->
    <div class="menu-bar" id="menu-bar">
        <h1 class="game-title">Sky Garden</h1>
        <ul class="menu-list fa-ul">
            <li class="menu-item user-name"><span class="fa-li"><i class="fa-solid fa-circle-user"></i></span><?php echo htmlspecialchars($_SESSION['username']); ?></li>
            <li class="menu-item active"><span class="fa-li"><i class="fa-solid fa-seedling"></i></span>Garden</li>
            <li class="menu-item"><span class="fa-li"><i class="fa-solid fa-cubes"></i></span>Collections</li>
            <li class="menu-item"><span class="fa-li"><i class="fa-solid fa-gear"></i></span>Settings</li>
            <li class="menu-item logout"><span class="fa-li"><i class="fa-solid fa-door-open"></i></span><a href="#" onclick="showLogoutConfirmation()">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="status-bars">
            <div class="bar">
                <div class="bar-label">Sunlight</div>
                <img src="image/icons/sun.png" alt="Sun Icon">
                <div class="progress sunlight">
                    <div class="progress-fill"></div>
                </div>
            </div>

            <div class="bar">
                <div class="bar-label">Water</div>
                <img src="image/icons/water.png" alt="Water Icon">
                <div class="progress water">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </div>

        <div class="plant-phase">
            <div class="plant-container" 
                data-plant-id="<?php echo $plant_id; ?>" 
                data-plant-type="<?php echo $selectedPlant; ?>" 
                data-plant-level="<?php echo $plantLevel; ?>">
                <img src="" alt="Plant Image" class="plant-stage">
                <img src="image/icons/pot.png" alt="Pot" class="pot-image">
            </div>
        </div>

        <!-- Weather Form -->
        <form class="weatherForm" id="weatherForm">
            <input type="text" class="cityInput" placeholder="Enter city" id="cityInput" />
        </form>

        <div class="left-sidebar">
            <!-- Weather Info Card -->
            <div class="card" style="display: flex" id="weatherCard"></div>
            
            <!-- Plant Care Container -->
            <div class="plant-care">
                <div class="controls">
                    <span class="btn-label water-label">Water</span>
                    <button class="icon-btn" id="waterButton">
                        <img src="image/icons/watering-can.png" alt="Watering Can Icon">
                    </button>
                    <div id="waterTimerDisplay"></div>
                    
                    <span class="btn-label fertilizer-label">Fertilizer</span>
                    <button class="icon-btn" id="fertilizerButton">
                        <img src="image/icons/fertilizer.png" alt="Fertilizer Icon">
                    </button>
                    <div id="fertilizerTimerDisplay"></div>
                </div>
            </div>
        </div>

    <audio id="waterSound" src="sounds/water-can.wav"></audio>
    <audio id="fertilizerSound" src="sounds/click.wav"></audio>

    </div>
    <script>
        // Inject session data into JavaScript
        const sessionData = <?php echo json_encode([
            'userId' => $_SESSION['user_id'],
            'plantId' => $_SESSION['plant_id'],
            'plantType' => $_SESSION['plant_type'],
        ]); ?>;
        const plantType = "<?php echo $_SESSION['plant_type']; ?>";
    </script>

    <!-- Toast notification for logout confirmation -->
    <div id="logoutToast" class="logoutToast">
        <p>Are you sure you want to log out?</p>
        <button class="btn confirm-btn" id="confirmLogoutBtn">Yes, Log Out</button>
        <button class="btn cancel-btn" id="cancelLogoutBtn">No, Stay Logged In</button>
    </div>
    
    <audio class="background-music" id = "audioPlayer" src="<?php echo $song; ?>" loop></audio>
    <script src="js/game.js"></script>
    <script src="js/script.js"></script>
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
</body>
</html>