<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}

function sendResponseWithError($error_message)
{
    $response = array(
        "status" => "Error",
        "message" => $error_message
    );
    exit(json_encode($response));
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);


        if ($id === false || $id === null) {
            sendResponseWithError("Invalid Record");
        }

        $status = "Archived";

        // Update address status
        $updateQuery = "UPDATE tblstocks SET record_status = ? WHERE stockId = ?";
        $stmt = $conn->prepare($updateQuery);

        if (!$stmt) {
            sendResponseWithError("Failed to prepare statement");
        }

        $stmt->bind_param("ss", $status, $id);

        if ($stmt->execute()) {
            $response = array("status" => "success");
            exit(json_encode($response));
        } else {
            $error_message = mysqli_error($conn); // Fetch the SQL error message
            sendResponseWithError($error_message);
        }
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
