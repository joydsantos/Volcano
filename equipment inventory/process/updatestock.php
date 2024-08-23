<?php
session_start();
include '../../database/mydb.php';
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
function sendInvalidQty()
{
    $response = array("status" => "qty");
    exit(json_encode($response));
}
function sendInvalidTotalQty()
{
    $response = array("status" => "totalqty");
    exit(json_encode($response));
}
function sendCategoryResponse()
{
    $response = array("status" => "Cat");
    exit(json_encode($response));
}
function sendResponseWithError($error_message)
{
    unset($_SESSION['stock_Id']);
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
        if (!isset($_POST['qty']) || empty($_POST['qty']) || !is_numeric($_POST['qty'])) {
            sendInvalidInputResponse();
        }
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

        #get the selectedtotal qty transacted
        $stocktranid = $_SESSION['stock_Id']; #from fetch_data php
        $selectSum = "SELECT SUM(qty) AS total_sum FROM tbl_transaction WHERE stockId = ?";
        $stmt = mysqli_prepare($conn, $selectSum);
        mysqli_stmt_bind_param($stmt, "s", $stocktranid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        # Check if there are rows in the result
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $totalTranQty = $row['total_sum'];

            mysqli_stmt_close($stmt);

            # Check if the submitted quantity is less than the total transaction quantity
            if ($_POST['qty'] < $totalTranQty) {
                sendInvalidTotalQty();
            }
        } else {
            #update directly
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

        #update
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

        $availQty = $qty - $totalTranQty; #from fetch php

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
                $response = array("status" => "File");
                exit(json_encode($response));
            }

            $update = "UPDATE tblstocks 
            SET Serial_Number = ?, 
               Property_Number = ?, 
               MAC = ?, 
               Item_Name = ?, 
               Description = ?, 
               total_Recieved = ?, 
               Qty = ?, 
               Special_Qty = ?
               Date_Recieved = ?, 
               Par = ?, 
               Category = ?, 
               unit_id = ?, 
               status = ?, 
               Remarks = ? ,
               Filename = ?,
               Filepath = ?
            WHERE stockId = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("sssssiissssisssss", $SerialNum, $PropertyNum, $mac, $ItemName, $Description, $qty, $availQty, $qtyType, $new_dateReceived, $par, $cat, $unit, $status, $rem, $rawFileName, $filename, $stocktranid);
        } else {
            #no file query

            $update = "UPDATE tblstocks 
            SET Serial_Number = ?, 
               Property_Number = ?, 
               MAC = ?, 
               Item_Name = ?, 
               Description = ?, 
               total_Recieved = ?, 
               Qty = ?, 
               Special_Qty = ?,
               Date_Recieved = ?, 
               Par = ?, 
               Category = ?, 
               unit_id = ?, 
               status = ?, 
               Remarks = ?    
            WHERE stockId = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("sssssiissssisss", $SerialNum, $PropertyNum, $mac, $ItemName, $Description, $qty, $availQty, $qtyType,  $new_dateReceived, $par, $cat, $unit, $status, $rem, $stocktranid);
        }

        if ($stmt->execute()) {

            unset($_SESSION['stock_Id']);
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
