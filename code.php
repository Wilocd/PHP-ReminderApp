<?php
session_start();
require 'dbcon.php';

if(isset($_POST['save_notification']))
{

    // Escape input
    $title = htmlspecialchars($_POST['title']);
    $remark = htmlspecialchars($_POST['remark']);

    if(empty($title) || empty($remark))
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO notifications_ajax (title, remark) VALUES (:title, :remark)");
        
        // Bind parameters
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':remark', $remark, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();

        $res = [
            'status' => 200,
            'message' => '已成功新增提醒!'
        ];
        echo json_encode($res);
        return;
    } catch (PDOException $e) {
        $res = [
            'status' => 500,
            'message' => '未成功新增提醒: ' . $e->getMessage()
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['update_notification']))
{    
    // Escape input
    $notification_id = htmlspecialchars($_POST['notification_id']);

    $title = htmlspecialchars($_POST['title']);
    $remark = htmlspecialchars($_POST['remark']);


    if(empty($title) || empty($remark))
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    try {
        // Prepare the SQL queryf
        $stmt = $conn->prepare("UPDATE notifications_ajax SET title=:title, remark=:remark WHERE id=:id");
        
        // Bind parameters
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':remark', $remark, PDO::PARAM_STR);
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();

        $res = [
            'status' => 200,
            'message' => '已成功更新提醒!'
        ];
        echo json_encode($res);
        return;
    } catch (PDOException $e) {
        $res = [
            'status' => 500,
            'message' => '未成功更新提醒: ' . $e->getMessage()
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_GET['notification_id']))
{

    // Escape input
    $notification_id = htmlspecialchars($_GET['notification_id']);

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("SELECT * FROM notifications_ajax WHERE id=:id");
        
        // Bind parameters
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();

        // Fetch the notification data
        $notification = $stmt->fetch(PDO::FETCH_ASSOC);

        if($notification)
        {
            $res = [
                'status' => 200,
                'message' => 'Notification Fetch Successfully by id',
                'data' => $notification
            ];
            echo json_encode($res);
            return;
        }
        else
        {
            $res = [
                'status' => 404,
                'message' => 'Notification Id Not Found'
            ];
            echo json_encode($res);
            return;
        }
    } catch (PDOException $e) {
        $res = [
            'status' => 500,
            'message' => 'Error fetching notification: ' . $e->getMessage()
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_notification']))
{
    $notification_id = htmlspecialchars($_POST['notification_id']);

    try {
        // Prepare the SQL query
        $stmt = $conn->prepare("DELETE FROM notifications_ajax WHERE id=:id");
        
        // Bind parameters
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();

        $res = [
            'status' => 200,
            'message' => '已成功刪除提醒!'
        ];
        echo json_encode($res);
        return;
    } catch (PDOException $e) {
        $res = [
            'status' => 500,
            'message' => '未成功刪除提醒: ' . $e->getMessage()
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['notification_id'])) {
    $notification_id = htmlspecialchars($_POST['notification_id']);

    // Update the status in the database
    try {
        $stmt = $conn->prepare("UPDATE notifications_ajax SET finish_status = 1 WHERE id = :id");
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        $stmt->execute();

        $res = [
            'status' => 200,
            'message' => '提醒標記為已完成'
        ];
        echo json_encode($res);
        return;
    } catch (PDOException $e) {
        $res = [
            'status' => 500,
            'message' => '錯誤: ' . $e->getMessage()
        ];
        echo json_encode($res);
        return;
    }
} else {
    $res = [
        'status' => 400,
        'message' => '缺少提醒ID'
    ];
    echo json_encode($res);
    return;
}


// if(isset($_GET['notification_id'])) {
//     // Function to fetch and display tasks based on status
//     function getTasksByStatus($pdo, $status) {
//         // Prepare SQL statement to fetch tasks with the specified status
//         $stmt = $pdo->prepare("SELECT * FROM notifications_ajax WHERE finish_status = :finish_status ORDER BY id DESC");

//         // Bind parameter
//         $stmt->bindParam(':status', $status);

//         // Execute the prepared statement
//         $stmt->execute();

//         // Fetch all rows as an associative array
//         $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         // Return tasks as JSON
//         return json_encode($tasks);
//     }

//     // Check if the status parameter is set
//     if (isset($_GET['status'])) {
//         $status = $_GET['status'];
//         echo getTasksByStatus($pdo, $status);
//     }
// }


?>
