<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
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
    $response = array(
        "status" => "Error",
        "message" => $error_message
    );
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        #check data if valid 
        if (isset($_POST['dateReceived'])) {
            $dateReceived = strtotime($_POST['dateReceived']);
            if ($dateReceived === false || $dateReceived < strtotime("1980-01-01") || $dateReceived > strtotime(date("Y-m-d"))) {
                sendDateResponse();
            }
        } else {
            sendDateResponse();
        }
        #chek item name 
        if (empty($_POST['ItemName'])) {
            sendInvalidInputResponse();
        }
        #check qty
        if (!isset($_POST['qty']) || empty($_POST['qty']) || !is_numeric($_POST['qty']) || $_POST['qty'] < 1) {
            sendInvalidInputResponse();
        }
        #check status
        if (empty($_POST['cboStatus']) || !in_array($_POST['cboStatus'], ['Functional', 'Defective'])) {
            sendInvalidInputResponse();
        }
        #check unit
        if (empty($_POST['cboUnit'])) {
            sendInvalidInputResponse();
        }
        #check qty Type
        if (empty($_POST['qtyType']) || !in_array($_POST['qtyType'], ['Regular', 'Special'])) {
            sendInvalidInputResponse();
        }

        #check category
        if (is_numeric($_POST['cat']) && !empty($_POST['cat']) && $_POST['cat'] > 0) {
            #retrieve the id of category and check if the category is in there
            $getCatID = "SELECT id FROM tbl_equipmentcategory";
            $stmt = mysqli_prepare($conn, $getCatID);

            if ($stmt) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id);

                $equipmentIds = array();
                while (mysqli_stmt_fetch($stmt)) {
                    $equipmentIds[] = $id;
                }

                mysqli_stmt_close($stmt);

                #check if in array
                if (in_array($_POST['cat'], $equipmentIds)) {
                } else {
                    sendInvalidInputResponse();
                }
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
            //sendInvalidInputResponse();
            $rawFileName = "";
            $filename = "";
        }


        $SerialNum = mysqli_real_escape_string($conn, $_POST['SerialNum']);
        $PropertyNum = mysqli_real_escape_string($conn, $_POST['PropertyNum']);
        $mac = mysqli_real_escape_string($conn, $_POST['mac']);
        $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
        $Description = mysqli_real_escape_string($conn, $_POST['description']);
        $qty = intval($_POST['qty']); // Ensure it's an integer
        $qtyType = mysqli_real_escape_string($conn, $_POST['qtyType']);
        $new_dateReceived = date('Y-m-d', $dateReceived);
        $unit = intval($_POST['cboUnit']);
        $status = mysqli_real_escape_string($conn, $_POST['cboStatus']);
        $par = mysqli_real_escape_string($conn, $_POST['par']);
        $rem = mysqli_real_escape_string($conn, $_POST['Remarks']);
        $cat = mysqli_real_escape_string($conn, $_POST['cat']);
        $recordStatus = "Active";

        $isEmpty = false;
        $getLatestTran = "SELECT CONCAT('VMEPD-', 'STOCK', '-', LPAD(id , 4, '0')) as Tran FROM tblstocks";
        $result2 = mysqli_query($conn, $getLatestTran);

        if (mysqli_num_rows($result2) <= 0) {
            $insert = "INSERT INTO tblstocks (`Serial_Number`, `MAC`, `Property_Number`, `Item_Name`, `Description`, `total_Recieved`, `Qty`, `Special_Qty`, `Date_Recieved`, `Par`, `Category`, `unit_id`, `status`, `remarks`, `record_status`, `Filename`, `Filepath`) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?,?, ?,?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("sssssiissssisssss", $SerialNum, $mac, $PropertyNum, $ItemName, $Description, $qty, $qty, $qtyType, $new_dateReceived, $par, $cat, $unit, $status, $rem, $recordStatus, $rawFileName, $filename);
            $isEmpty = true;
        } else {
            $getLatestTran3 = "SELECT CONCAT('VMEPD-', 'STOCK', '-', LPAD(id + 1 , 4, '0')) as Tran FROM tblstocks ORDER BY stockId DESC";
            $result3 = mysqli_query($conn, $getLatestTran3);
            $row3 = mysqli_fetch_assoc($result3);
            $latestTransactionNumber3 = $row3['Tran'];
            $tranNum = $latestTransactionNumber3;

            $insert = "INSERT INTO tblstocks (`stockId`, `Serial_Number`, `MAC`, `Property_Number`, `Item_Name`, `Description`, `total_Recieved`, `Qty`, `Special_Qty`, `Date_Recieved`, `Par`, `Category`, `unit_id`, `status`, `remarks`,`record_status`,`Filename`, `Filepath`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ? , ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("ssssssiissssisssss", $tranNum, $SerialNum, $mac, $PropertyNum, $ItemName, $Description, $qty, $qty, $qtyType, $new_dateReceived, $par, $cat, $unit, $status, $rem, $recordStatus, $rawFileName, $filename);
        }

        if ($stmt->execute()) {
            if ($isEmpty) {
                $getLatestTran1 = "SELECT CONCAT('VMEPD-', 'STOCK', '-', LPAD(id, 4, '0')) as Tran FROM tblstocks";
                $result3 = mysqli_query($conn, $getLatestTran1);
                $row = mysqli_fetch_assoc($result3);
                $latestTransactionNumber1 = $row['Tran'];
                $tranNum = $latestTransactionNumber1;
                $updatetran = "UPDATE tblstocks SET stockId = ?";
                $stmt = $conn->prepare($updatetran);
                $stmt->bind_param("s", $latestTransactionNumber1);
                $stmt->execute();
            }
            $response = array("status" => "Correct");
            exit(json_encode($response));
        } else {
            $error_message = mysqli_error($conn); // Fetch the SQL error message
            sendResponseWithError($error_message);
        }
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
