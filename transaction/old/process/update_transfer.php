<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
include '../../../database/mydb.php';


function sendDateResponse()
{
    $response = array("status" => "date");
    exit(json_encode($response));
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
    unset($_SESSION['update_transaction_id']);
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upId'])) {

        #check data if valid 
        if (isset($_POST['dateAcquired'])) {
            $dateReceived = strtotime($_POST['dateAcquired']);
            if ($dateReceived === false || $dateReceived < strtotime("1980-01-01") || $dateReceived > strtotime(date("Y-m-d"))) {
                sendDateResponse();
            }
        } else {
            sendDateResponse();
        }

        #installation date       
        $installDate = $_POST['installDate'];
        if ($installDate === "") {
            // Set a default value or take appropriate action
            $installDateConverted = null; // or any other default value
        } else if (strtotime($installDate) === false || strtotime($installDate) < strtotime("1960-01-01") || strtotime($installDate) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $installDateConverted = date('Y-m-d', strtotime($installDate));
        }


        if (empty($_POST['transFrom']) || empty($_POST['transTo'])) {
            sendInvalidInputResponse();
        }
        #check status
        if (empty($_POST['cboEquipStatus']) || !in_array($_POST['cboEquipStatus'], ['Damage', 'Missing', 'Ongoing Repair', 'Serviceable', 'Pulled Out', 'For Disposal', 'Unrepairable'])) {
            sendInvalidInputResponse();
        }


        #check station code
        if (
            is_numeric($_POST['stationId']) &&
            !empty($_POST['stationId']) &&
            $_POST['stationId'] > 0 &&
            is_numeric($_POST['stationCodeId']) &&
            !empty($_POST['stationCodeId']) &&
            $_POST['stationCodeId'] > 0
        ) {
            #Check if the id exists 
            $stationId = intval($_POST['stationId']);
            $stationCodeId = intval($_POST['stationCodeId']);

            $check = "SELECT * FROM tbl_station_code WHERE code_id = ? AND station_id = ?";
            $stmt = mysqli_prepare($conn, $check);
            $stmt->bind_param("ii", $stationCodeId, $stationId);

            if ($stmt) {
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                #Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    #Record exists

                } else {
                    sendInvalidInputResponse();
                }

                mysqli_free_result($result);
            } else {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
            }
        } else {
            sendInvalidInputResponse();
        }

        #check division
        if (
            isset($_POST['divisionId']) &&
            is_numeric($_POST['divisionId']) &&
            !empty($_POST['divisionId']) &&
            $_POST['divisionId'] > 0
        ) {
            #Check if the id exists 
            $divisionId = intval($_POST['divisionId']);

            $check = "SELECT * FROM tbl_division WHERE id = ?";
            $stmt = mysqli_prepare($conn, $check);
            $stmt->bind_param("i", $divisionId);

            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                #Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    #Record exists

                } else {
                    sendInvalidInputResponse();
                }

                mysqli_free_result($result);
            } else {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
            }
        } else {
            sendInvalidInputResponse();
        }

        $id = intval($_POST['upId']);
        $SerialNum = mysqli_real_escape_string($conn, $_POST['SerialNum']);
        $transFrom = mysqli_real_escape_string($conn, $_POST['transFrom']);
        $transTo = mysqli_real_escape_string($conn, $_POST['transTo']);
        $divisionId = intval($_POST['divisionId']);
        $stationId = intval($_POST['stationId']);
        $stationCodeId = intval($_POST['stationCodeId']);
        $status = mysqli_real_escape_string($conn, $_POST['cboEquipStatus']);
        // $installDate = date('Y-m-d', strtotime($_POST['installDate']));
        $dateAcquired = date('Y-m-d', strtotime($_POST['dateAcquired']));
        $rem = mysqli_real_escape_string($conn, $_POST['Remarks']);


        $update = "UPDATE tbl_oldtransaction_transfer_history 
        SET `Serial_Number` = ?, 
        `Transferred_From` = ?, `Transferred_To` = ?, `Division_id` = ?, 
        `Station_Name` = ?, `station_code_id` = ?, `Date_Transferred` = ?, 
        `Installation_Date` = ?, `Status` = ?, `remarks` = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update);


        mysqli_stmt_bind_param(
            $stmt,
            "sssiiissssi",
            $SerialNum,
            $transFrom,
            $transTo,
            $divisionId,
            $stationId,
            $stationCodeId,
            $dateAcquired,
            $installDateConverted,
            $status,
            $rem,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            $stmt->close();

            $response = array("status" => "Success");
            exit(json_encode($response));
        } else {
            $error_message = mysqli_error($conn); // Fetch the SQL error message
            sendResponseWithError($error_message);
        }
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
