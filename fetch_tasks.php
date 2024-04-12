<?php
// Database connection
require_once 'dbcon.php';

// Check if status parameter is set
if (isset($_GET['status'])) {
    $status = $_GET['status'];

    try {
        // Prepare SQL statement to fetch tasks with the specified status
        if ($status == '3') {
            $stmt = $conn->prepare("SELECT * FROM notifications_ajax ORDER BY id DESC");
            $stmt->bindParam(':status', $status);
            $stmt->execute();
    
            // Fetch all rows as an associative array
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Output tasks as JSON
            echo json_encode($tasks);
        }
        else{
            $stmt = $conn->prepare("SELECT * FROM notifications_ajax WHERE finish_status = :status ORDER BY id DESC");
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            // Fetch all rows as an associative array
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output tasks as JSON
            echo json_encode($tasks);
        }
    } catch (PDOException $e) {
        // If there is an error with the database query
        echo "Error: " . $e->getMessage();
    }
} 
?>
