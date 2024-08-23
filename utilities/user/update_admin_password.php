<?php
session_start();
include '../../database/mydb.php';

function sendInvalid() {
    $response = array("status" => "Invalid", "message" => "Incorrect Input");
    exit(json_encode($response));
}

function sendValid() {
    $response = array("status" => "success");
    exit(json_encode($response));
}
function sendResponseWithError($error_message) {
    $response = array("status" => "Error", "error" => $error_message);
   exit(json_encode($response));
}

try 
{
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth" && $_SERVER["REQUEST_METHOD"] == "POST")
    {
        $password = $_POST["updatePassword"];
        $userId= $_POST["userID"];

        if (!is_numeric($userId) && $userId < 1) {
		   sendInvalid();
		} 

        if (empty($password)) {
           sendInvalid();
        }

        $sqlRegex = '/[;\'"\\()|*+--]/';
		if (preg_match($sqlRegex, $password)) {		  
		    sendInvalid();
		}
		$cleanPassword = mysqli_real_escape_string($conn, $password);
		$hashedPassword = password_hash($cleanPassword, PASSWORD_DEFAULT);
		$cleanId = intval($userId);

		$select = "SELECT password FROM tbl_admin WHERE id = ?";
		$stmt = $conn->prepare($select);

		if ($stmt) {
		    $stmt->bind_param("i", $cleanId);
		    $stmt->execute();
		    $stmt->store_result();

		    if ($stmt->num_rows === 1) {		      
		        $stmt->close();	
		        
		        #update password   
		        $update = "UPDATE tbl_admin set password = ? WHERE id = ?";
		        $stmt_update = $conn->prepare($update);
		        $stmt_update->bind_param("si",$hashedPassword, $cleanId);
		       
		       	if($stmt_update->execute())
		       	{	$stmt_update->close();
		       		sendValid();
		       	}
		       	else
		       	{
		       		sendResponseWithError();
		       	}
		        
		    } else {
		        sendInvalid();
		    }
		} else {
		    // Handle prepare error
		    sendResponseWithError();
		}
		$conn->close();
    }
    else
    {
        session_destroy(); #destroy all sesssion because its illegal to navigate to this page unless its post
        header("Location: ../../index.php");
        exit;

    }
} 
catch (Exception $e) 
{
    // Handle any exceptions here
}






?>