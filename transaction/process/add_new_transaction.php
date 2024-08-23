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
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        #chek item name 
        if (empty($_POST['NewTran_StockNum'])) {
            sendStockResponse();
        } else {
            $stockNumber = mysqli_real_escape_string($conn, $_POST['NewTran_StockNum']);
            $checkStockNumber = "SELECT Qty FROM tblstocks WHERE stockId = ?";
            $stmt = mysqli_prepare($conn, $checkStockNumber);
            $stmt->bind_param("s", $stockNumber);

            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                #Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    #Record exists
                    $row = mysqli_fetch_assoc($result);
                    $Fetch_Qty = $row['Qty'];
                } else {
                    sendStockResponse();
                }
            } else {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
            }
        }

        if (!isset($_POST['NewTran_Quantity']) || empty($_POST['NewTran_Quantity']) || !is_numeric($_POST['NewTran_Quantity']) || $_POST['NewTran_Quantity'] < 1) {
            sendInvalidInputResponse();
        } else {
            $qty = intval($_POST['NewTran_Quantity']);
            if ($qty > $Fetch_Qty) {
                sendStockQtyResponse();
            }
        }

        #chek  other fields
        if (empty($_POST['NewTran_transFrom']) || empty($_POST['NewTran_transTo'])) {
            sendInvalidInputResponse();
        }


        #installation date
        if ($_POST['NewTran_installDate'] === "") {
            $installDate = null; // or any other default value
        } else if (strtotime($_POST['NewTran_installDate']) === false || strtotime($_POST['NewTran_installDate']) < strtotime("1980-01-01") || strtotime($_POST['NewTran_installDate']) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $installDate = date('Y-m-d', strtotime($_POST['NewTran_installDate']));
        }


        #check data if valid 
        if (isset($_POST['NewTran_dateAcquired'])) {

            if (strtotime($_POST['NewTran_dateAcquired']) === false || strtotime($_POST['NewTran_dateAcquired']) < strtotime("1980-01-01") || strtotime($_POST['NewTran_dateAcquired']) > strtotime(date("Y-m-d"))) {
                sendDateResponse();
            }
        } else {
            sendDateResponse();
        }



        # warranty date
        if ($_POST['NewTran_dateWarranty'] === "") {
            $warrantyDate = null; // or any other default value
        } else if (strtotime($_POST['NewTran_dateWarranty']) === false || strtotime($_POST['NewTran_dateWarranty']) < strtotime("1980-01-01") || strtotime($_POST['NewTran_dateWarranty']) > strtotime(date("Y-m-d"))) {
            // Handle invalid date case
            sendDateResponse();
        } else {
            // Valid date, proceed with conversion
            $warrantyDate = date('Y-m-d', strtotime($_POST['NewTran_dateWarranty']));
        }



        #check station code
        if (
            is_numeric($_POST['New_stationId']) &&
            !empty($_POST['New_stationId']) &&
            $_POST['New_stationId'] > 0 &&
            is_numeric($_POST['New_stationCodeId']) &&
            !empty($_POST['New_stationCodeId']) &&
            $_POST['New_stationCodeId'] > 0
        ) {
            #Check if the id exists 
            $stationId = intval($_POST['New_stationId']);
            $stationCodeId = intval($_POST['New_stationCodeId']);

            $check = "SELECT * FROM tbl_station_code WHERE code_id = ? AND station_id = ?";
            $stmtCheck = mysqli_prepare($conn, $check);
            $stmtCheck->bind_param("ii", $stationCodeId, $stationId);

            if ($stmtCheck->execute()) {
                $result = mysqli_stmt_get_result($stmtCheck);
                $stmtCheck->close();
                #Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    #Record exists


                } else {
                    sendInvalidStation();
                }
            } else {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
            }
        } else {
            sendInvalidStation();
        }

        #check division
        if (
            isset($_POST['NewTran_DivisionId']) &&
            is_numeric($_POST['NewTran_DivisionId']) &&
            !empty($_POST['NewTran_DivisionId']) &&
            $_POST['NewTran_DivisionId'] > 0
        ) {
            #Check if the id exists 
            $divisionId = intval($_POST['NewTran_DivisionId']);

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


        if (isset($_FILES['NewTran_uploadFile']) && $_FILES['NewTran_uploadFile']['size'] > 0) {
            $uploadFile = $_FILES['NewTran_uploadFile'];
            $filename = $uploadFile['name'];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $targetFolder = "../OR/";
            if (!is_dir($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            $rawFileName = $filename; #no unique id
            $filename = uniqid() . '_' . '_' . $filename;
            $targetPath = $targetFolder . $filename;



            if (move_uploaded_file($_FILES['NewTran_uploadFile']['tmp_name'], $targetPath)) {
            } else {
                // Handle the case when the file upload fails
                sendFileResponse();
            }
        } else {
            $rawFileName = "";
            $filename = "";
        }


        $transFrom = mysqli_real_escape_string($conn, $_POST['NewTran_transFrom']);
        $transTo = mysqli_real_escape_string($conn, $_POST['NewTran_transTo']);
        $divisionId = intval($_POST['NewTran_DivisionId']);
        $stationId = intval($_POST['New_stationId']);
        $stationCodeId = intval($_POST['New_stationCodeId']);
        $status = "Serviceable";
        $landOwner = mysqli_real_escape_string($conn, $_POST['NewTran_landOwner']);
        $careTaker = mysqli_real_escape_string($conn, $_POST['NewTran_careTaker']);
        $rem = mysqli_real_escape_string($conn, $_POST['NewTran_Remarks']);
        $description = mysqli_real_escape_string($conn, $_POST['NewTran_Description']);

        $today = date("Y-m-d");
        $dateAcquired = date('Y-m-d', strtotime($_POST['NewTran_dateAcquired']));
        $recordStatus = "Active";

        $insert = "INSERT INTO tbl_transaction 
            (`stockId`,`transaction_date`,`qty` ,`Transferred_From`,`Transferred_To`, `Division_id`,`Station_Name`, `Station_Code`,`Land_Owner`,`Care_Taker`, `Installation_Date`,`Date_Acquired`, `Warranty_Date`, `Status`,`Remarks`,`FileName`, `Filepath`,`Description`, `record_status`) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = mysqli_prepare($conn, $insert);

        if (!$stmt) {
            $error_message = mysqli_error($conn);
            sendResponseWithError($error_message);
            exit();
        }

        $stmt->bind_param("ssissiiisssssssssss", $stockNumber, $today, $qty, $transFrom, $transTo, $divisionId, $stationId, $stationCodeId, $landOwner, $careTaker, $installDate, $dateAcquired, $warrantyDate, $status, $rem, $rawFileName, $filename, $description, $recordStatus);


        if ($stmt->execute()) {
            # Store the result of mysqli_insert_id
            $insertedId = mysqli_insert_id($conn);
            $stmt->close();
            $latestTransactionNumber = "VMEPD-" . date("Ymd") . "-" . str_pad($insertedId, 4, '0', STR_PAD_LEFT);


            #update transaction number
            $latestTransactionNumber = "VMEPD-" . date("Ymd") . "-" . str_pad($insertedId, 4, '0', STR_PAD_LEFT);
            $updateTranNum = "UPDATE tbl_transaction SET Transaction_Number = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateTranNum);

            if (!$updateStmt) {
                $error_message = mysqli_error($conn);
                sendResponseWithError($error_message);
                exit();
            }

            $updateStmt->bind_param("si", $latestTransactionNumber, $insertedId);
            if ($updateStmt->execute()) {
                $updateStmt->close();

                #update stock available quantity
                $updatedQty = $Fetch_Qty - $qty;
                $update_Qty = "UPDATE tblstocks SET Qty = ? WHERE stockId = ?";
                $update_Qty = mysqli_prepare($conn, $update_Qty);

                if (!$update_Qty) {
                    $error_message = mysqli_error($conn);
                    sendResponseWithError($error_message);
                    exit();
                }
                $update_Qty->bind_param("is", $updatedQty, $stockNumber);
                if ($update_Qty->execute()) {
                    $response = array("status" => "Success");
                    exit(json_encode($response));
                    #$update_Qty->close();
                } else {
                    $error_message = mysqli_error($conn); // Fetch the SQL error message
                    sendResponseWithError($error_message);
                }
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

?>





?>