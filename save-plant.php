<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['plant_type'])) {
    $plant_type = $input['plant_type'];
    $user_id = $_SESSION['user_id'];

    // Debug: Output received plant type and user ID
    error_log("Received plant_type: $plant_type for user_id: $user_id");

    // Check if the plant already exists for the user
    $stmt = $conn->prepare("SELECT plant_id, growth_stage FROM plants WHERE user_id = ? AND plant_type = ?");
    $stmt->bind_param("is", $user_id, $plant_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Plant already exists, fetch the existing plant_id and growth_stage
        $row = $result->fetch_assoc();
        $plant_id = $row['plant_id'];
        $growth_stage = $row['growth_stage'];
        $_SESSION['plant_id'] = $plant_id;
        $_SESSION['plant_type'] = $plant_type;
        $_SESSION['growth_stage'] = $growth_stage;
    } else {
        // Insert new plant into the database
        $stmt = $conn->prepare("INSERT INTO plants (user_id, plant_type, growth_stage, sunlight_health, water_health) VALUES (?, ?, 1, 100, 100)");
        $stmt->bind_param("is", $user_id, $plant_type);

        if ($stmt->execute()) {
            $plant_id = $stmt->insert_id; // Get the new plant_id
            $_SESSION['plant_id'] = $plant_id;
            $_SESSION['plant_type'] = $plant_type;
            $_SESSION['growth_stage'] = $growth_stage; // Default to initial growth stage
            // Debug: Log the new plant_id
            error_log("New plant inserted with plant_id: $plant_id");
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert plant: ' . $stmt->error]);
            exit;
        }
    }

    // Save or update plant data
    $stmt = $conn->prepare("UPDATE plants SET growth_stage = 1, sunlight_health = 100, water_health = 100 WHERE plant_id = ?");
    $stmt->bind_param("i", $plant_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true, 
            'plant_id' => $plant_id, 
            'plant_type' => $plant_type,
            'growth_stage' => $_SESSION['growth_stage'],
            'message' => 'Plant saved successfully'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update plant data: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Plant type not provided']);
}
?>
