document.addEventListener("DOMContentLoaded", () => {
    // Get elements for modals
    const signinModal = document.getElementById('signinModal');
    const signupModal = document.getElementById('signupModal');
    const aboutModal = document.getElementById('aboutModal'); // About modal

    // Get elements for opening and closing modals
    const openSigninModalBtn = document.getElementById('openSigninModalBtn');
    const closeSigninModalBtn = document.getElementById('closeSigninModalBtn');
    const closeSignupModalBtn = document.getElementById('closeSignupModalBtn');
    const closeAboutModalBtn = document.getElementById('closeAboutModalBtn'); // Close button for About modal
    const createAccountLink = document.getElementById('createAccountLink');
    const openSigninLink = document.getElementById('openSigninLink');
    const openAboutModalBtn = document.getElementById('openAboutModalBtn'); // About button

    // Open Sign In modal
    if (openSigninModalBtn) {
        openSigninModalBtn.addEventListener('click', () => {
            signinModal.style.display = 'flex';
        });
    }

    // Close Sign In modal
    if (closeSigninModalBtn) {
        closeSigninModalBtn.addEventListener('click', () => {
            signinModal.style.display = 'none';
        });
    }

    // Close Sign Up modal
    if (closeSignupModalBtn) {
        closeSignupModalBtn.addEventListener('click', () => {
            signupModal.style.display = 'none';
        });
    }

    // Open About modal
    if (openAboutModalBtn) {
        openAboutModalBtn.addEventListener('click', () => {
            aboutModal.style.display = 'flex';
        });
    }

    // Close About modal
    if (closeAboutModalBtn) {
        closeAboutModalBtn.addEventListener('click', () => {
            aboutModal.style.display = 'none';
        });
    }

    // Switch to Sign Up modal from Sign In
    if (createAccountLink) {
        createAccountLink.addEventListener('click', () => {
            signinModal.style.display = 'none';
            signupModal.style.display = 'flex';
        });
    }

    // Switch to Sign In modal from Sign Up
    if (openSigninLink) {
        openSigninLink.addEventListener('click', () => {
            signupModal.style.display = 'none';
            signinModal.style.display = 'flex';
        });
    }

    // Additional modal for How to Play
    const howToPlayModal = document.getElementById('howToPlayModal');
    const openHowToPlayModalBtn = document.getElementById('openHowToPlayModalBtn');
    const closeHowToPlayModalBtn = document.getElementById('closeHowToPlayModalBtn');

    // Open the How to Play Modal
    if (openHowToPlayModalBtn) {
        openHowToPlayModalBtn.addEventListener('click', () => {
            howToPlayModal.style.display = 'flex';
        });
    }

    // Close the How to Play Modal
    if (closeHowToPlayModalBtn) {
        closeHowToPlayModalBtn.addEventListener('click', () => {
            howToPlayModal.style.display = 'none';
        });
    }
});

//Sidebar Menu
    document.addEventListener("DOMContentLoaded", () => {
        const userInfo = document.getElementById("users-info"); // The user icon
        const menuBar = document.getElementById("menu-bar"); // The sidebar menu
        const gameTitle = document.querySelector(".menu-bar h1"); // The "Sky Garden" title in the menu

    // Show the menu when user info is clicked
    userInfo.addEventListener("click", () => {
        menuBar.style.display = "block"; // Show sidebar
        userInfo.style.display = "none"; // Hide user info
    });

    // Hide the menu when the title is clicked
    gameTitle.addEventListener("click", () => {
        menuBar.style.display = "none"; // Hide sidebar
        userInfo.style.display = "flex"; // Show user info
    });
});

// Sun & Water Bar
document.addEventListener("DOMContentLoaded", () => {
    const sunlightBar = document.querySelector(".progress.sunlight .progress-fill");
    const waterBar = document.querySelector(".progress.water .progress-fill");

    setTimeout(() => {
        sunlightBar.style.width = "100%";
        waterBar.style.width = "100%";
    }, 1000);
});

setInterval(() => {
    const sunlightBar = document.querySelector(".progress.sunlight .progress-fill");
    const waterBar = document.querySelector(".progress.water .progress-fill");
    const sunlightWidth = parseFloat(sunlightBar.style.width);
    const waterWidth = parseFloat(waterBar.style.width);

    if (sunlightWidth > 0) sunlightBar.style.width = Math.max(sunlightWidth - 1, 0) + "%";
    if (waterWidth > 0) waterBar.style.width = Math.max(waterWidth - 1, 0) + "%";
}, 3000); // Decrease every 3 seconds

document.addEventListener("DOMContentLoaded", () => {
    const plantOptions = document.querySelectorAll(".plant-image"); // Select the clickable plant image elements, not the parent div.
    plantOptions.forEach((plant) => {
        plant.addEventListener("click", () => {
            const selectedPlant = plant.dataset.type; // Get the data-type from the clicked plant image
            fetch("../save-plant.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ plant_type: selectedPlant }),
            })
                .then((response) => response.json())  // Parse the response as JSON
                .then((data) => {
                    console.log("Response data:", data);  // Log the response data to see the structure
                    if (data.success) {
                        showToast(data.message, true);
                        window.location.href = "../garden.php";  // Redirect to the garden page
                    } else {
                        showToast(data.message, false   );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });            
        });
    });
});

function showToast(message, isSuccess) {
    const toast = document.createElement('div');
    toast.className = `toast ${isSuccess ? 'success' : 'error'}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    // Automatically remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 2000);
}

//For SOUND CLICKING
document.addEventListener("click", function(event) {
    const elementClass = event.target.classList;
    const elementID = event.target.id;

    if (
        elementClass.contains("mainBtn") || 
        elementClass.contains("close") ||
        elementClass.contains("fa-solid fa-door-open") ||
        elementClass.contains("game-title") ||
        elementClass.contains("users-info") ||
        elementClass.contains("get-weather-btn") ||
        elementClass.contains("change-location-btn") ||
        elementClass.contains("plant-image") ||
        elementID === "createAccountLink" ||
        elementID === "sign_inBtn" ||
        elementID === "sign_upBtn" ||
        elementID === "openSigninLink" ||
        elementID === "users-info" 

        ) {
        // Play the sound
        let audioClick = new Audio("sounds/click.wav");
        audioClick.play();

    //for elements with navigation

    
    } else if ( elementID === "enterGarden"  ) {
    
        let audioClick = new Audio("sounds/click.wav");
        audioClick.play();

        event.preventDefault();

        // Set a delay of 1 second before navigating
        audioClick.onended = function() {
            setTimeout(function() {
                if (true) {
                    window.location.href = '../plants.php';  // Navigate to the URL
                }
            }, 1000);

        };
    } else if ( elementID === "enterGame"  ) {
    
        let audioClick = new Audio("sounds/click.wav");
        audioClick.play();

        event.preventDefault();

        // Set a delay of 1 second before navigating
        audioClick.onended = function() {
            setTimeout(function() {
                if (true) {
                    window.location.href = '../garden.php';  // Navigate to the URL
                }
            }, 1000);

        };
    } 
});

//For background music

// Get the audio element
const audio = document.getElementById('audioPlayer');

// Check if there's saved playback time in localStorage
const savedTime = localStorage.getItem('audioTime');
if (savedTime) {
  audio.currentTime = savedTime;  // Resume from saved time
  audio.play();  // Start playing
}

// Save the current playback time before leaving the page
window.addEventListener('beforeunload', () => {
  localStorage.setItem('audioTime', audio.currentTime);
});

