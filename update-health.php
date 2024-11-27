<?php
header("Content-Type: application/json");
require "connect.php";

$data = json_decode(file_get_contents("php://input"), true);

// Debug log the received data
error_log("Received data: " . print_r($data, true));

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];
$plantId = $_SESSION['plant_id'];
$plantType = $_SESSION['plant_type'];
$growthStage = $_SESSION['growth_stage'];
$sunlightHealth = $data['sunlightHealth'];
$waterHealth = $data['waterHealth'];
$type = $data['type'];
$newHealthValue = $data['newHealthValue'];
$timestamp = $data['timestamp']; // This timestamp should already be in ISO format

// Columns to update
$lastWaterColumn = $type === "water" ? $timestamp : "last_water"; // Update last_water if "water"
$lastSunColumn = $type === "sun" ? $timestamp : "last_sun"; // Update last_sun if "sun"

// SQL Query to update both sunlight and water health
$query = "
    UPDATE plants 
    SET 
        sunlight_health = ?, 
        water_health = ?, 
        last_water = IF(? = 'water', ?, last_water), 
        last_sun = IF(? = 'sun', ?, last_sun), 
        plant_type = ?, 
        growth_stage = ? 
    WHERE 
        plant_id = ? 
        AND user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "iissssssii", 
    $sunlightHealth, 
    $waterHealth, 
    $type, 
    $timestamp, 
    $type, 
    $timestamp, 
    $plantType, 
    $growthStage, 
    $plantId, 
    $userId
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Health updated successfully"]);
} else {
    error_log("Error executing query: " . $stmt->error);
    echo json_encode(["success" => false, "message" => "Error updating health"]);
}

$stmt->close();
$conn->close();
?>
