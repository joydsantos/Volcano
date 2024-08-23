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
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
        } else if (strtotime($installDate) === false || strtotime($installDate) < strtotime("1980-01-01") || strtotime($installDate) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $installDateConverted = date('Y-m-d', strtotime($installDate));
        }
        #chek item name 
        if (empty($_POST['ItemName']) || empty($_POST['transFrom']) || empty($_POST['transTo'])) {
            sendInvalidInputResponse();
        }
        #check qty
        if (!isset($_POST['qty']) || empty($_POST['qty']) || !is_numeric($_POST['qty']) || $_POST['qty'] < 1) {
            sendInvalidInputResponse();
        }
        #check status
        if (empty($_POST['cboEquipStatus']) || !in_array($_POST['cboEquipStatus'], ['Damage', 'Missing', 'Ongoing Repair', 'Serviceable', 'Pulled Out', 'For Disposal', 'Unrepairable', 'Others'])) {
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


        if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['size'] > 0) {
            $uploadFile = $_FILES['uploadFile'];
            $filename = $uploadFile['name'];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $targetFolder = "../OR/";
            if (!is_dir($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            $rawFileName = $filename; #no unique id
            $filename = uniqid() . '_' . '_' . $filename;
            $targetPath = $targetFolder . $filename;
            if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $targetPath)) {
            } else {
                // Handle the case when the file upload fails
                sendInvalidInputResponse();
            }
        } else {
            $rawFileName = "";
            $filename = "";
        }

        $SerialNum = mysqli_real_escape_string($conn, $_POST['SerialNum']);
        $PropertyNum = mysqli_real_escape_string($conn, $_POST['PropertyNum']);
        $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
        $qty = intval($_POST['qty']); // Ensure it's an integer
        $transFrom = mysqli_real_escape_string($conn, $_POST['transFrom']);
        $transTo = mysqli_real_escape_string($conn, $_POST['transTo']);
        $divisionId = intval($_POST['divisionId']);
        $stationId = intval($_POST['stationId']);
        $stationCodeId = intval($_POST['stationCodeId']);
        $status = mysqli_real_escape_string($conn, $_POST['cboEquipStatus']);
        $landOwner = mysqli_real_escape_string($conn, $_POST['landOwner']);
        $careTaker = mysqli_real_escape_string($conn, $_POST['careTaker']);
        $dateAcquired = date('Y-m-d', strtotime($_POST['dateAcquired']));
        $rem = mysqli_real_escape_string($conn, $_POST['Remarks']);
        $recordStatus = "Active";

        $insert = "INSERT INTO tbl_oldtransaction 
            (`Item_Name`, `Serial_Number`, `Property_Number`, `qty`, `Transferred_From`, `Transferred_To`, `Division_id`, `Station_Name`, `station_code_id`, `Land_Owner`, `Care_Taker`, `Installation_Date`, `Date_Acquired`, `Status`, `Remarks`,`Filename`, `Filepath`, record_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?,?)";

        $stmt = mysqli_prepare($conn, $insert);

        if (!$stmt) {
            $error_message = mysqli_error($conn);
            sendResponseWithError($error_message);
            exit();
        }

        $stmt->bind_param("sssissiiisssssssss", $ItemName, $SerialNum, $PropertyNum, $qty, $transFrom, $transTo, $divisionId, $stationId, $stationCodeId, $landOwner, $careTaker, $installDateConverted, $dateAcquired, $status, $rem, $rawFileName, $filename, $recordStatus);

        if ($stmt->execute()) {
            // Store the result of mysqli_insert_id($conn) in a variable
            $insertedId = mysqli_insert_id($conn);
            $stmt->close();

            $latestTransactionNumber1 = "VMEPD-PAST-" . str_pad($insertedId, 4, '0', STR_PAD_LEFT);
            $updateTranNum = "UPDATE tbl_oldtransaction SET Transaction_Number = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateTranNum);

            if (!$updateStmt) {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
                exit();
            }

            $updateStmt->bind_param("si", $latestTransactionNumber1, $insertedId);

            if (mysqli_stmt_execute($updateStmt)) {
                $response = array("status" => "Success");
                exit(json_encode($response));
            } else {
                $error_message = mysqli_error($conn); // Fetch the SQL error message
                sendResponseWithError($error_message);
            }
        } else {
            $error_message = mysqli_error($conn); // Fetch the SQL error message
            sendResponseWithError($error_message);
        }
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
