<?php
header("Content-Type: application/json");
session_start();
require "connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$plant_id = $_SESSION['plant_id'];

if (empty($plant_id)) {
    echo json_encode(['success' => false, 'message' => 'Plant ID is not set in session.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input.']);
        exit;
    }

    $stage = $data['stage'];
    $sunlightHealth = $data['sunlightHealth'];
    $waterHealth = $data['waterHealth'];

    $query = "UPDATE plants SET growth_stage = ?, sunlight_health = ?, water_health = ? WHERE plant_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $stage, $sunlightHealth, $waterHealth, $plant_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        error_log("Database error: " . $stmt->error);
        echo json_encode(["success" => false, "message" => "Failed to update plant state."]);
    }

    $stmt->close();
}
?>
