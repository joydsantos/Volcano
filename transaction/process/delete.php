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
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);


        if ($id === false || $id === null) {
            sendResponseWithError("Invalid Record");
        }

        $status = "Archived";

        // Update address status
        $updateQuery = "UPDATE tbl_transaction SET record_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);

        if (!$stmt) {
            sendResponseWithError("Failed to prepare statement");
        }

        $stmt->bind_param("si", $status, $id);

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
?>