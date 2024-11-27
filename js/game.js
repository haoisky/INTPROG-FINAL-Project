// Updated Weather Form Submission
const weatherForm = document.querySelector(".weatherForm");
const cityInput = document.querySelector(".cityInput");
const getWeatherBtn = document.createElement("button");
getWeatherBtn.textContent = "Get Weather";
getWeatherBtn.className = "get-weather-btn";
weatherForm.appendChild(getWeatherBtn); // Add the button next to the input

const card = document.querySelector(".card");
const changeLocationBtn = document.createElement("button");
changeLocationBtn.textContent = "Change Location";
changeLocationBtn.className = "change-location-btn";
const apiKey = "4912a36c4f56f47df37ba5c0d78c14dd";

card.innerHTML = `<p class="placeholder-text">Enter a city and click "Get Weather" to see the details.</p>`;

// Handle Get Weather button click
getWeatherBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    const city = cityInput.value.trim();

    if (city) {
        try {
            // Hide input and button without affecting layout
            card.innerHTML = "";
            weatherForm.style.visibility = "hidden";
            weatherForm.style.pointerEvents = "none";

            const weatherData = await getWeatherData(city);
            const forecastData = await getFiveDayForecast(city);

            displayWeatherInfo(weatherData, forecastData);
            card.appendChild(changeLocationBtn);

            // Show the card
            card.style.visibility = "visible";
            card.style.display = "flex";
        } catch (error) {
            console.error("Error:", error.message);
            showToast("Invalid city. Please enter a valid city name.", false);  // Show toast if error occurs
            weatherForm.style.visibility = "visible";
            weatherForm.style.pointerEvents = "all";
            card.innerHTML = `<p class="placeholder-text">Enter a city and click "Get Weather" to see the details.</p>`;
        }
    } else {
        showToast("Please enter a city.", false);  // Show toast if no city is entered
    }
});

// Toast notification function
function showToast(message, isSuccess = true) {
    const toast = document.createElement("div");
    toast.classList.add("toast", isSuccess ? "success" : "error");
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);  // Remove after 3 seconds
}

changeLocationBtn.addEventListener("click", () => {
    // Restore visibility without re-rendering layout
    weatherForm.style.visibility = "visible";
    weatherForm.style.pointerEvents = "all";
    card.style.visibility = "visible";
    card.innerHTML = `<p class="placeholder-text">Enter a city and click "Get Weather" to see the details.</p>`;  // Clear card content
});


// Fetch current weather
async function getWeatherData(city) {
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;
    const response = await fetch(apiUrl);

    if (!response.ok) throw new Error("Failed to fetch weather data.");
    return response.json();
}

// Fetch 5-day forecast
async function getFiveDayForecast(city) {
    const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric`;
    const response = await fetch(apiUrl);

    if (!response.ok) throw new Error("Failed to fetch forecast data.");
    return response.json();
}

// Global audio instance
const audioPlayer = new Audio();
audioPlayer.loop = true; // Set audio to loop

// Display main weather info and forecast
function displayWeatherInfo(data, forecastData) {
    const { name, main: { temp }, weather } = data;
    const weatherId = weather[0].id;

    // Update background based on weather
    const gameContainer = document.querySelector(".game-container"); // Your game container element

    // Stop the current audio if playing
    audioPlayer.pause();
    audioPlayer.currentTime = 0; // Reset to the start

    if (weatherId >= 200 && weatherId < 300) { 
        gameContainer.style.backgroundImage = "url('../image/backgrounds/stormy.jpg')";
        audioPlayer.src = "../sounds/heavy-rain.wav";
        audioPlayer.volume = 0.5;

    }
    else if (weatherId >= 300 && weatherId < 600) { 
        gameContainer.style.backgroundImage = "url('../image/backgrounds/rainy.jpg')";
        audioPlayer.src = "../sounds/light-rain.wav";
        audioPlayer.volume = 0.5;
    }
    else if (weatherId >= 600 && weatherId < 700) { 
        gameContainer.style.backgroundImage = "url('../image/backgrounds/rainy.jpg')";
        audioPlayer.src = "../sounds/light-rain.wav";
        audioPlayer.volume = 0.5;
    }
    else if (weatherId === 800) { 
        gameContainer.style.backgroundImage = "url('../image/backgrounds/sunny.jpg')";
        audioPlayer.src = "../sounds/sunny.wav";
        audioPlayer.volume = 0.5;
    }
    else if (weatherId >= 801) { 
        gameContainer.style.backgroundImage = "url('../image/backgrounds/cloudy.jpg')";
        audioPlayer.src = "../sounds/Stardew Valley Overture.wav";
        audioPlayer.volume = 0;
    }

        // Stop any currently playing audio and play the new one
        audioPlayer.play().catch((error) => {
            console.error("Error playing audio:", error.message);
        });

    applyWeatherEffects(weatherId);

    // Highlighted Weather Section
    const todayElem = document.createElement("div");
    todayElem.className = "highlighted-weather";
    todayElem.innerHTML = `
        <h1>${name}</h1>
        <div class="weather-emoji">${getWeatherEmoji(weather[0].id)}</div>
        <p class="highlighted-condition">${weather[0].main}</p>
        <p class="highlighted-temp">${temp.toFixed(1)}°C</p>
    `;

    gameContainer.appendChild(todayElem);

    // Forecast Section
    const forecastContainer = document.createElement("div");
    forecastContainer.className = "forecast-container";

    const dailyForecasts = forecastData.list.filter((_, index) => index % 8 === 0).slice(1, 5);
    dailyForecasts.forEach((day) => {
        const { dt_txt, main: { temp_min, temp_max }, weather } = day;
        const dayOfWeek = new Date(dt_txt).toLocaleString("en-US", { weekday: "short" });

        const forecastItem = document.createElement("div");
        forecastItem.className = "forecast-item";
        forecastItem.innerHTML = `
            <p>${dayOfWeek}</p>
            <div class="forecast-emoji">${getWeatherEmoji(weather[0].id)}</div>
            <p>${temp_max.toFixed(1)}°C</p>
        `;

        forecastContainer.appendChild(forecastItem);
    });

    card.appendChild(todayElem);
    card.appendChild(forecastContainer);
}

// Get weather emoji
function getWeatherEmoji(weatherId) {
    if (weatherId >= 200 && weatherId < 300) return "⛈️";
    if (weatherId >= 300 && weatherId < 400) return "🌧️";
    if (weatherId >= 500 && weatherId < 600) return "🌧️";
    if (weatherId >= 600 && weatherId < 700) return "❄️";
    if (weatherId === 800) return "☀️";
    if (weatherId >= 801 && weatherId < 810) return "☁️";
    return "❓";
}


let plantLevel = 1; // Initialize plantLevel
let timePassed = 0;

// Check if `plantType` is provided from your server
if (typeof plantType === "undefined" || !plantType) {
    console.error("Plant type is not defined. Please check your PHP injection.");
}

// Wait for DOM to load
document.addEventListener("DOMContentLoaded", () => {
    const plants = {
        rose: [
            "image/plants/rose/1.png",
            "image/plants/rose/2.png",
            "image/plants/rose/3.png",
            "image/plants/rose/4.png",
        ],
        sunflower: [
            "image/plants/sunflower/1.png",
            "image/plants/sunflower/2.png",
            "image/plants/sunflower/3.png",
            "image/plants/sunflower/4.png",
        ],
        tulip: [
            "image/plants/tulip/1.png",
            "image/plants/tulip/2.png",
            "image/plants/tulip/3.png",
            "image/plants/tulip/4.png",
        ],
    };

    // Ensure plantType is valid
    if (!plants[plantType]) {
        console.error("Invalid plant type:", plantType);
        return;
    }

    const plantContainer = document.querySelector(".plant-container img");
    if (!plantContainer) {
        console.error("Plant container not found in the DOM.");
        return;
    }

    // Initialize plant display
    updatePlantImage(getStageFromLevel(plantLevel));
    updatePlantPosition(getStageFromLevel(plantLevel), plantType, plantContainer);
});

// Level up plant function
function levelUpPlant() {
    if (plantLevel >= 20) return; // Max level

    const sunlightBar = document.querySelector(".progress.sunlight .progress-fill");
    const waterBar = document.querySelector(".progress.water .progress-fill");

    if (!sunlightBar || !waterBar) {
        console.error("Sunlight or water bar elements not found.");
        return;
    }

    const sunlightWidth = parseFloat(sunlightBar.style.width) || 0;
    const waterWidth = parseFloat(waterBar.style.width) || 0;

    if (sunlightWidth > 0 && waterWidth > 0) {
        timePassed += 1;

        let levelTime = 10 + (plantLevel - 1) * 0;
        if (timePassed >= levelTime) {
            plantLevel++;
            timePassed = 0;

            const stage = getStageFromLevel(plantLevel);
            updatePlantImage(stage);
            updatePlantPosition(stage, plantType, document.querySelector(".plant-container img"));

            // Save state with sunlight and water values
            savePlantState(stage, sunlightWidth, waterWidth);

            // Show toast for level-up or evolution
            if (plantLevel === 5 || plantLevel === 12 || plantLevel === 20) {
                showToast("Your plant has evolved to the next stage!", true);  // Success toast for evolution
            } else {
                showToast(`Your plant is now Level ${plantLevel}! Keep it up!`, true);  // Success toast for level-up
            }
        }
    } else {
        timePassed = 0; // Reset time if health is too low
    }
    setTimeout(levelUpPlant, 1000);
}


// Function to determine stage from level
function getStageFromLevel(level) {
    if (level <= 4) return 1;
    if (level <= 11) return 2;
    if (level <= 19) return 3;
    return 4;
}

// Function to update plant image
function updatePlantImage(stage) {
    const plantImage = document.querySelector(".plant-stage");

    if (!plantImage) {
        console.error("Plant image not found in the DOM.");
        return;
    }

    const path = `../image/plants/${plantType}/${stage}.png`;
    plantImage.src = path;
    plantImage.alt = `Plant Stage ${stage}`;
    console.log(`Plant image updated to: ${path}`);
}

// Function to update plant position and size
function updatePlantPosition(stage, plantType, plantContainer) {
    if (!plantContainer) {
        console.error("Plant container not found for positioning.");
        return;
    }

    const positions = {
        rose: [
            { left: "53%", width: "65px", bottom: "90px" },
            { left: "50%", width: "75px", bottom: "90px" },
            { left: "50%", width: "100px", bottom: "90px" },
            { left: "50%", width: "155px", height: "250px", bottom: "105px" },
        ],
        sunflower: [
            { left: "47%", width: "65px", bottom: "90px" },
            { left: "50%", width: "85px", bottom: "90px" },
            { left: "50%", width: "100px", bottom: "90px" },
            { left: "50%", width: "155px", height: "250px", bottom: "90px" },
        ],
        tulip: [
            { left: "50%", width: "55px", height: "55px", bottom: "90px" },
            { left: "50%", width: "60px", height: "70px", bottom: "90px" },
            { left: "50%", width: "85px", height: "150px", bottom: "90px" },
            { left: "50%", width: "100px", height: "250px", bottom: "90px" },
        ],
    };

    const styles = positions[plantType][stage - 1];
    for (const [key, value] of Object.entries(styles)) {
        plantContainer.style[key] = value;
    }

    console.log(`Plant position updated:`, styles);
}

function savePlantState(stage, sunlightHealth, waterHealth) {
    fetch("update-growth-stage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            stage,
            sunlightHealth,
            waterHealth,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Response:", data);
            if (data.success) {
                console.log("Plant growth updated successfully!");
            } else {
                console.error("Error:", data.message);
            }
        })
        .catch(error => console.error("Fetch error:", error));     
}

// Water & Fertilizer Events
let waterCooldown = false;
let fertilizerCooldown = false;

document.querySelector("#waterButton").addEventListener("click", () => {
    if (!waterCooldown) {
        updateHealth("water");
        showToast("Plant watered successfully!", true);  // Success toast for watering
        startCooldown("water");
    } else {
        showToast("Please wait before watering again.", false);  // Error toast for cooldown
    }
});

document.querySelector("#fertilizerButton").addEventListener("click", () => {
    if (!fertilizerCooldown) {
        updateHealth("sun");
        showToast("Fertilizer applied successfully!", true);  // Success toast for fertilizing
        startCooldown("fertilizer");
    } else {
        showToast("Please wait before fertilizing again.", false);  // Error toast for cooldown
    }
});

function updateHealth(type) {
    // Select the corresponding progress bar
    const progressBar = type === "water" ? document.querySelector(".progress.water .progress-fill")
        : document.querySelector(".progress.sunlight .progress-fill");

    // Get current width and calculate new width
    const currentWidth = parseFloat(progressBar.style.width) || 0;
    const newWidth = Math.min(currentWidth + 10, 100); // Cap at 100%

    // Update the progress bar visually
    progressBar.style.width = `${newWidth}%`;

    // Send updated values to the database
    saveHealthToDatabase(type, newWidth);
}

function startCooldown(type) {
    const button = type === "water" ? document.querySelector("#waterButton") : document.querySelector("#fertilizerButton");
    const timerDisplay = document.querySelector(`#${type}TimerDisplay`);

    // Disable the button
    button.disabled = true;

    let timeRemaining = 5 * 60; // 5 minutes in seconds
    const countdown = setInterval(() => {
        if (timeRemaining <= 0) {
            clearInterval(countdown);
            button.disabled = false; // Re-enable the button
            timerDisplay.innerText = ""; // Clear the timer display
            if (type === "water") waterCooldown = false;
            if (type === "fertilizer") fertilizerCooldown = false;
        } else {
            timeRemaining--;
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerDisplay.innerText = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        }
    }, 1000);

    if (type === "water") waterCooldown = true;
    if (type === "fertilizer") fertilizerCooldown = true;
}

function saveHealthToDatabase(type, newHealthValue) {
    // Get session data directly from the injected sessionData variable
    const { userId, plantId, plantType, plantLevel } = sessionData;

    // Get the current health values of both bars
    const sunlightHealth = parseFloat(document.querySelector(".progress.sunlight .progress-fill").style.width.replace('%', ''));
    const waterHealth = parseFloat(document.querySelector(".progress.water .progress-fill").style.width.replace('%', ''));

    const currentTime = new Date().toISOString(); // Get current timestamp

    // Send both current values of water and sunlight health
    fetch("../update-health.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            userId: userId,
            plantId: plantId,
            plantType: plantType,
            plantLevel: plantLevel, // Use plantLevel here
            sunlightHealth: sunlightHealth,  // Current sunlight health
            waterHealth: waterHealth,  // Current water health
            type: type,
            newHealthValue: newHealthValue,
            timestamp: currentTime,
        }),
    })
    .then((response) => response.text())
    .then((data) => {
        console.log(data);  // Log the raw response
        try {
            const jsonData = JSON.parse(data);  // Try to parse the response as JSON
            if (jsonData.success) {
                console.log("Success");
            } else {
                console.error("Error saving health to database:", jsonData.message);
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
        }
    })
    .catch((error) => console.error("Error:", error));
}

// Start the Level-Up Process
levelUpPlant(); 

function applyWeatherEffects(weatherId) {
    const sunlightBar = document.querySelector(".progress.sunlight .progress-fill");
    const waterBar = document.querySelector(".progress.water .progress-fill");

    let sunlightChange = 0;
    let waterChange = 0;

    // Define weather effects
    if (weatherId === 800) { 
        // Sunny
        sunlightChange = 30;
        waterChange = -5;
    } else if (weatherId >= 300 && weatherId < 700) { 
        // Rainy
        sunlightChange = -5;
        waterChange = 30;
    } else if (weatherId >= 801) { 
        // Cloudy
        sunlightChange = 15;
        waterChange = 15;
    } else if (weatherId >= 200 && weatherId < 300) { 
        // Stormy
        sunlightChange = -30;
        waterChange = -10;
    }

    // Update bar widths
    const updatedSunlightWidth = Math.min(Math.max(parseFloat(sunlightBar.style.width || 0) + sunlightChange, 0), 100);
    const updatedWaterWidth = Math.min(Math.max(parseFloat(waterBar.style.width || 0) + waterChange, 0), 100);

    sunlightBar.style.width = `${updatedSunlightWidth}%`;
    waterBar.style.width = `${updatedWaterWidth}%`;
}

// Function to show the confirmation toast
function showLogoutConfirmation() {
    const toast = document.getElementById('logoutToast');
    toast.classList.add('show');
}

// Function to confirm logout
document.getElementById('confirmLogoutBtn').addEventListener('click', function() {
    // Perform the logout process (you can redirect to logout.php or any logout script)
    window.location.href = '../logout.php'; // Replace with your actual logout script
});

// Function to cancel logout
document.getElementById('cancelLogoutBtn').addEventListener('click', function() {
    // Close the toast without logging out
    const toast = document.getElementById('logoutToast');
    toast.classList.remove('show');
});

// Function to trigger the logout confirmation
function confirmLogout(event) {
    event.preventDefault();  // Prevent the default logout action
    showLogoutConfirmation(); // Show the confirmation toast
}
