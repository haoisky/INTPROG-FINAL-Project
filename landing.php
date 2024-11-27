<?php
    session_start();
    require_once 'connect.php';

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
            left: 20%;
        }

        /* Ensures the image fits within the modal content */
        .about-content img {
            width: 100%; 
            height: auto; 
            display: block;
            margin: 5px 0;
        }

        .how-to-play-content img {
            width: 100%; 
            height: auto; 
            display: block;
            margin: 5px 0;
        }

        .how-to-play-content h4 {
            font-size: 20px;
            margin: 15px 0px;
            font-weight: bold;
        }

        #firstP {
            margin-top: -8px;
        }


    </style>
</head>
<body>
<audio class="background-music" id="audioPlayer" src="<?php echo $song; ?>" autoplay loop></audio>
    <div class="container">
        <img src="image/icons/SkyGarden.png" class="logo-image"></img>
        <div class="button-group">
            <!-- Button to open Sign In Modal -->
            <button id="openSigninModalBtn" class="mainBtn">Sign In</button>

            <!-- Button to open About Modal -->
            <button id="openAboutModalBtn" class="mainBtn">About</button>

            <!-- Button to open How Tp Play Modal -->
            <button id="openHowToPlayModalBtn" class="mainBtn">How to Play</button>

            <!-- Sign In Modal -->
            <div id="signinModal" class="modal">
                <div class="modal-content">
                    <span id="closeSigninModalBtn" class="close">&times;</span>
                    <h3>Sign In</h3>
                    <form action="login.php" method="POST">
                        <label for="username">Username</label>
                        <input type="text" placeholder="Username" name="username" required>

                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" name="password" required>

                        <button type="submit" id="sign_inBtn">Sign In</button>
                        <p>Don't have an account? <strong id="createAccountLink">Create Now!</strong></p>
                    </form>
                </div>
            </div>

            <!-- About Modal -->
            <div id="aboutModal" class="modal">
                <div class="about-modal-content">
                    <span id="closeAboutModalBtn" class="close">&times;</span>
                    <h3>About</h3>
                    <div class="about-content">
                        <p>Sky Garden is a captivating virtual pet game where you cultivate and care for a unique, ever-evolving plant.  Unlike typical virtual pets, your plant's health and growth are directly influenced by real-time weather conditions detected from your location.</p>
                        <img src="image/pic/pic1.jpg" alt="">
                        <p>  Sunny days might bring vibrant blooms, while rain provides essential moisture, but extreme heat or cold could cause stress and even damage.  You'll need to adapt your care routine to the changing weather patterns, learning to anticipate your plant's needs and providing the optimal environment for thriving growth.  </p>
                        <img src="image/pic/pic2.jpg" alt="">
                        <p> This dynamic interplay between the virtual and real world adds a layer of engaging challenge and realism, making Sky Garden a truly unique and rewarding experience.  Beyond the core gameplay, you can customize your plant's environment, unlocking new decorative items and expanding your virtual garden as your plant flourishes.</p>
                    </div>
                </div>
            </div>

            <!-- How to Play Modal -->
            <div id="howToPlayModal" class="modal">
                <div class="modal-content">
                    <span id="closeHowToPlayModalBtn" class="close">&times;</span>
                    <h3>How to Play</h3>
                    <div class="how-to-play-content">
                        <p>Begin your horticultural adventure by choosing your first plant from three enchanting options: the classic Rose, the sunny Sunflower, or the elegant Tulip.  Each plant offers a unique journey of growth and development.</p>
                        <img src="image/pic/pic3.jpg" alt="">
                        
                        <h4>Getting Started</h4>
                        <p id="firstP">You'll begin with a tiny sprout, your plant's first stage of life.  As you care for it, your plant will level up, evolving through stunning transformations.  Remember, the real-time weather in your location directly impacts the virtual environment where your plant resides.</p>
                        <img src="image/pic/pic4.jpg" alt="">

                        <h4>Maintaining Your Plant's Health</h4>
                        <p id="firstP">Your plant's well-being depends on two key health bars:</p>
                        <p id="firstP">Sun Health: Represents your plant's need for sunlight. Sunny days naturally replenish this bar.</p>
                        <p id="firstP">Water Health: Represents your plant's need for hydration. Rainy days naturally replenish this bar.</p>
                        <img src="image/pic/pic5.jpg" alt="">

                        <p>If either health bar depletes completely, your plant will sadly perish.  Don't let that happen!</p>

                        <h4>Essential Tools</h4>
                        <p id="firstP">To help your plant thrive, you have two essential tools at your disposal:</p>
                        <p id="firstP">Water Can:  Instantly replenishes your plant's Water Health.  Has a 5-minute cooldown after use.</p>
                        <p id="firstP">Fertilizer: Instantly replenishes your plant's Sun Health. Has a 5-minute cooldown after use.</p>
                        <img src="image/pic/pic6.jpg" alt="">

                        <h4>Strategic Gameplay</h4>
                        <p id="firstP"> Monitor your plant's health bars closely and use your tools strategically.  Pay attention to the real-world weather forecast to anticipate your plant's needs.  A sunny day might mean you can focus on growth, while an overcast day might require more frequent watering.  Mastering this balance is key to nurturing a flourishing Sky Garden!</p>
                        <!-- Add more steps or information here -->
                    </div>
                </div>
            </div>

            <!-- Sign Up Modal -->
            <div id="signupModal" class="modal">
                <div class="modal-content">
                    <span id="closeSignupModalBtn" class="close">&times;</span>
                    <h3>Sign Up</h3>
                    <form id="signupForm" action="register.php" method="post">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Email" name="email" required> 

                        <label for="Username">Username</label>
                        <input type="text" placeholder="Username" name="username" required>

                        <label for="Password">Password</label>
                        <input type="password" placeholder="Password" name="password" required>

                        <button type="submit" id="sign_upBtn" >Sign Up</button>
                        <p>Already have an account? <strong id="openSigninLink">Sign In!</strong></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            setTimeout(() => toast.classList.remove('show'), 2000); // Remove after 2 seconds
        }
    </script>

    <!-- Include Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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
