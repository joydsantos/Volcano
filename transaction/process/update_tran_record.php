<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}
include '../../database/mydb.php';


function sendDateResponse()
{
    $response = array("status" => "date", "message" => "Invalid Date");
    exit(json_encode($response));
}
function sendInvalidInputResponse()
{
    $response = array("status" => "Input", "message" => "Invalid Input");
    exit(json_encode($response));
}
function sendStockResponse()
{
    $response = array("status" => "Stock", "message" => "Invalid Stock Number");
    exit(json_encode($response));
}
function sendStockQtyResponse()
{
    $response = array("status" => "StockQty", "message" => "Insufficient Quantity");
    exit(json_encode($response));
}
function sendInvalidStation()
{
    $response = array("status" => "Station", "message" => "Station Can not be found");
    exit(json_encode($response));
}
function sendFileResponse()
{
    $response = array("status" => "File", "message" => "There's an error in uploading the file");
    exit(json_encode($response));
}
function sendResponseWithError($error_message)
{
    unset($_SESSION['update_new_transaction_id']);
    unset($_SESSION['update_new_transaction_stock_id']);
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['update_new_transaction_id']) && isset($_SESSION['update_new_transaction_stock_id'])) {

        #id of stock
        $stockNumber = $_SESSION['update_new_transaction_stock_id'];

        #check data if valid 
        $checkStockNumber = "SELECT Qty FROM tblstocks WHERE stockId = ?";
        $stmt = mysqli_prepare($conn, $checkStockNumber);
        $stmt->bind_param("s", $stockNumber);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            #Check if any rows were returned
            if ($result->num_rows > 0) {
                # Record exists
                $row = $result->fetch_assoc();
                $Fetch_Qty = $row['Qty'];
            } else {
                sendStockResponse();
            }
            $stmt->close();
        } else {
            $error_message = mysqli_error($conn);
            sendResponseWithError($error_message);
        }

        #check status
        if (empty($_POST['UpdateTran_cboEquipStatus']) || !in_array($_POST['UpdateTran_cboEquipStatus'], ['Damage', 'Missing', 'Ongoing Repair', 'Serviceable', 'Pulled Out', 'For Disposal', 'Unrepairable'])) {
            sendInvalidInputResponse();
        }

        #chek names
        if (empty($_POST['UpdateTran_transFrom']) || empty($_POST['UpdateTran_transFrom'])) {
            sendInvalidInputResponse();
        }
        #check station code
        if (
            is_numeric($_POST['UpdateTran_stationId']) &&
            !empty($_POST['UpdateTran_stationId']) &&
            $_POST['UpdateTran_stationId'] > 0 &&
            is_numeric($_POST['UpdateTran_stationCodeId']) &&
            !empty($_POST['UpdateTran_stationCodeId']) &&
            $_POST['UpdateTran_stationCodeId'] > 0
        ) {
            #Check if the id exists 
            $stationId = intval($_POST['UpdateTran_stationId']);
            $stationCodeId = intval($_POST['UpdateTran_stationCodeId']);

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

        #installation date
        if ($_POST['UpdateTran_installDate'] === "") {
            $installDate = null; // or any other default value
        } else if (strtotime($_POST['UpdateTran_installDate']) === false || strtotime($_POST['UpdateTran_installDate']) < strtotime("1980-01-01") || strtotime($_POST['UpdateTran_installDate']) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $installDate = date('Y-m-d', strtotime($_POST['UpdateTran_installDate']));
        }


        #check data if valid 
        if (isset($_POST['UpdateTran_dateAcquired'])) {

            if (strtotime($_POST['UpdateTran_dateAcquired']) === false || strtotime($_POST['UpdateTran_dateAcquired']) < strtotime("1980-01-01") || strtotime($_POST['UpdateTran_dateAcquired']) >  strtotime(date("Y-m-d"))) {
                sendDateResponse();
            }
        } else {
            sendDateResponse();
        }

        # warranty date
        if ($_POST['UpdateTran_warrantDate'] === "") {
            $warrantyDate = null; // or any other default value
        } else if (strtotime($_POST['UpdateTran_warrantDate']) === false || strtotime($_POST['UpdateTran_warrantDate']) < strtotime("1980-01-01") || strtotime($_POST['UpdateTran_warrantDate']) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $warrantyDate = date('Y-m-d', strtotime($_POST['UpdateTran_warrantDate']));
        }


        #check division
        if (
            isset($_POST['UpdateTran_Division']) &&
            is_numeric($_POST['UpdateTran_Division']) &&
            !empty($_POST['UpdateTran_Division']) &&
            $_POST['UpdateTran_Division'] > 0
        ) {
            #Check if the id exists 
            $divisionId = intval($_POST['UpdateTran_Division']);

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
        #id of transaction 
        $transId = $_SESSION['update_new_transaction_id'];
        $transFrom = mysqli_real_escape_string($conn, $_POST['UpdateTran_transFrom']);
        $transTo = mysqli_real_escape_string($conn, $_POST['UpdateTran_transTo']);
        $divisionId = intval($_POST['UpdateTran_Division']);
        $stationId = intval($_POST['UpdateTran_stationId']);
        $stationCodeId = intval($_POST['UpdateTran_stationCodeId']);
        $status = mysqli_real_escape_string($conn, $_POST['UpdateTran_cboEquipStatus']);

        $landOwner = mysqli_real_escape_string($conn, $_POST['UpdateTran_landOwner']);
        $careTaker = mysqli_real_escape_string($conn, $_POST['UpdateTran_careTaker']);
        $rem = mysqli_real_escape_string($conn, $_POST['UpdateTran_Remarks']);
        $description = mysqli_real_escape_string($conn, $_POST['UpdateTran_Description']);
        $dateAcquired = date('Y-m-d', strtotime($_POST['UpdateTran_dateAcquired']));


        #upload file  
        if (isset($_FILES['UpdateTran_uploadFile']) && $_FILES['UpdateTran_uploadFile']['size'] > 0) {
            $uploadFile = $_FILES['UpdateTran_uploadFile'];
            $filename = $uploadFile['name'];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $targetFolder = "../OR/";
            if (!is_dir($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            $rawFileName = $filename; #no unique id
            $filename = uniqid() . '_' . '_' . $filename;
            $targetPath = $targetFolder . $filename;



            if (move_uploaded_file($_FILES['UpdateTran_uploadFile']['tmp_name'], $targetPath)) {
            } else {
                // Handle the case when the file upload fails
                $response = array("status" => "File");
                exit(json_encode($response));
            }


            $update = "UPDATE tbl_transaction 
               SET  `Transferred_From` = ?, `Transferred_To` = ?, `Division_id` =? , `Station_Name` = ?, `station_Code` = ?, `Land_Owner` = ?, `Care_Taker` = ?, `Installation_Date` = ?, `Date_Acquired` = ?,`Warranty_Date` = ?, `Status` = ?, `Remarks` = ?, `Description` = ?, `Filename` = ?, `Filepath` = ?
               WHERE `id` = ?";
            $stmt = mysqli_prepare($conn, $update);
            $stmt->bind_param("ssiiissssssssssi", $transFrom, $transTo, $divisionId, $stationId, $stationCodeId, $landOwner, $careTaker, $installDate, $dateAcquired, $warrantyDate, $status, $rem, $description, $rawFileName, $filename, $transId);
        } else {
            #no file query
            $update = "UPDATE tbl_transaction 
               SET  `Transferred_From` = ?, `Transferred_To` = ?, `Division_id` = ?, `Station_Name` = ?, `station_Code` = ?, `Land_Owner` = ?, `Care_Taker` = ?, `Installation_Date` = ?, `Date_Acquired` = ?,`Warranty_Date` = ?, `Status` = ?, `Remarks` = ?, `Description` = ?
               WHERE `id` = ?";
            $stmt = mysqli_prepare($conn, $update);
            $stmt->bind_param("ssiiissssssssi", $transFrom, $transTo, $divisionId, $stationId, $stationCodeId, $landOwner, $careTaker, $installDate, $dateAcquired, $warrantyDate, $status, $rem, $description, $transId);
        }

        if ($stmt->execute()) {
            $stmt->close();
            unset($_SESSION['update_new_transaction_id']);
            unset($_SESSION['update_new_transaction_stock_id']);

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
