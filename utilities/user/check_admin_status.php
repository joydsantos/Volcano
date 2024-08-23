<?php
require '../../database/mydb.php';
session_start();
function sendInvalid() {
    $response = array("status" => "Invalid", "message" => "Invalid Request");
    exit(json_encode($response));
}
function sendResponseWithError($error_message) {
    $response = array("status" => "Error", "error" => $error_message);
   exit(json_encode($response));
}
try {

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth"&& $_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["admin_id"]) && is_numeric($_POST["admin_id"])) {
            // Validate and sanitize the "id" parameter
            $id = intval($_POST["admin_id"]);
        } else {
           sendInvalid();
        }
    } else {
        session_destroy();
        header("Location: .../../index.php");
    }

    // Query
    $query = "SELECT status FROM tbl_admin WHERE id = ?";  
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    // Execute the query
    if ($stmt->execute()) {
        $stmt->bind_result($acc_status);
        $stmt->fetch();
        $stmt->close();

        if ($acc_status !== null)
        {
        	$response = array(
            "status" => "success",
            "acc_status" => $acc_status,          
        	);
        	echo json_encode($response);
        	exit;
            
        } 
        else {
            sendInvalid();
        }
    } else {
        sendResponseWithError();
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    /*
    $error_message = $e->getMessage();
    $response = array("status" => "error", "message" => $error_message);
    echo json_encode($response);
    */
    exit;
}
?>
