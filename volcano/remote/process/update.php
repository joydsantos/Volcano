<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../../index.php");
}
function sendInvalidInputResponse()
{
    $response = array("status" => "Input");
    exit(json_encode($response));
}
function sendCategoryResponse()
{
    $response = array("status" => "Cat");
    exit(json_encode($response));
}
function sendResponseWithError($error_message)
{
    $response = array(
        "status" => "Error",
        "message" => $error_message
    );
    exit(json_encode($response));
}
function sendDateResponse()
{
    $response = array("status" => "date");
    exit(json_encode($response));
}


try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['dateStarted'])) {
            $dateStarted = strtotime($_POST['dateStarted']);
            if ($dateStarted === false || $dateStarted < strtotime("1980-01-01") || $dateStarted > strtotime(date("Y-m-d"))) {
                sendDateResponse();
            }
        } else {
            sendDateResponse();
        }

        $dateDestroyed = $_POST['dateDestroyed'];
        if ($dateDestroyed !== "") {
            $timestamp = strtotime($dateDestroyed);

            if ($timestamp === false || $timestamp < strtotime("1980-01-01") || $timestamp > strtotime(date("Y-m-d"))) {
                sendDateResponse();
            } else {
                $dateDestroyed = date('Y-m-d', $timestamp);
            }
        } else {
            $dateDestroyed = null;
        }


        if (empty($_POST['stationName']) || empty($_POST['instrument'])) {
            sendInvalidInputResponse();
        }

        if (!isset($_POST['station']) || empty($_POST['station']) || !is_numeric($_POST['station']) || $_POST['station'] < 1) {
            sendInvalidInputResponse();
        }
        if (!isset($_POST['stationType']) || empty($_POST['stationType']) || !is_numeric($_POST['stationType']) || $_POST['stationType'] < 1) {
            sendInvalidInputResponse();
        }
        if (!isset($_POST['stationCategory']) || empty($_POST['stationCategory']) || !is_numeric($_POST['stationCategory']) || $_POST['stationCategory'] < 1) {
            sendInvalidInputResponse();
        }

        if (empty($_POST['region']) || empty($_POST['province']) || empty($_POST['municipality']) || empty($_POST['barangay'])) {
            sendInvalidInputResponse();
        }

        #sanitize
        $station = intval($_POST['station']);
        $stationType = intval($_POST['stationType']);
        $stationCategory = intval($_POST['stationCategory']);
        $stationName = mysqli_real_escape_string($conn, $_POST['stationName']);
        $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
        $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
        $elevation = mysqli_real_escape_string($conn, $_POST['elevation']);
        $instrument = mysqli_real_escape_string($conn, $_POST['instrument']);
        $dateStarted = $_POST['dateStarted'];
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $region = mysqli_real_escape_string($conn, $_POST['region']);
        $province = mysqli_real_escape_string($conn, $_POST['province']);
        $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
        $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
        $remoteId = intval($_SESSION['remote_station_Id']);
        $update = "UPDATE tbl_remote_station SET 
            `station` = ?,
            `station_type` = ?, 
            `station_category` = ?, 
            `station_name` = ?, 
            `latitude` = ?, 
            `longitude` = ?, 
            `elevation` = ?, 
            `instrument` = ?, 
            `date_started` = ?, 
            `date_destroyed` = ?, 
            `remarks` = ?
            WHERE `id` = ?";

        $stmt = $conn->prepare($update);
        $stmt->bind_param("iiissssssssi", $station, $stationType, $stationCategory, $stationName, $latitude, $longitude, $elevation, $instrument, $dateStarted, $dateDestroyed, $remarks, $remoteId);

        if ($stmt->execute()) {
            $updatedRows = $stmt->affected_rows; // Check if any rows were updated

            if ($updatedRows >= 0) {
                // Continue with the update for tbl_remote_address
                $updateAddress = "UPDATE tbl_remote_address SET 
                          `address1` = ?, 
                          `region` = ?, 
                          `province` = ?, 
                          `municipality` = ?, 
                          `barangay` = ? 
                          WHERE `remote_station_id` = ?";

                $stmtAddress = $conn->prepare($updateAddress);
                $stmtAddress->bind_param("sssssi", $address, $region, $province, $municipality, $barangay, $remoteId);

                if ($stmtAddress->execute()) {
                    $stmtAddress->close();
                    $stmt->close();
                    $response = array("status" => "success");
                    exit(json_encode($response));
                } else {
                    $error_message = mysqli_error($conn); // Fetch the SQL error message
                    sendResponseWithError($error_message);
                }
            } else {
                $stmt->close();
                $response = array("status" => "no_changes");
                exit(json_encode($response));
            }
        } else {
            $error_message = mysqli_error($conn); // Fetch the SQL error message
            sendResponseWithError($error_message);
        }


    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}


?>