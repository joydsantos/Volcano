<?php
session_start();
include 'database/mydb.php';

function sendInvalid() {
    $response = array("status" => "Invalid", "message" => "Incorrect Credentials");
    exit(json_encode($response));
}
function sendValid() {
    $response = array("status" => "success", "redirect" => "navigation.php");
    exit(json_encode($response));
}
function sendResponseWithError($error_message) {
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}

try 
{
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $username = $_POST["uname"];
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
           sendInvalid();
        }

        $sqlRegex = '/[;\'"\\()|*+--]/';
		if (preg_match($sqlRegex, $username)) {		   
		    sendInvalid();
		}
		if (preg_match($sqlRegex, $password)) {		  
		    sendInvalid();
		}

		$cleanUsername = mysqli_real_escape_string($conn, $username);
		$cleanPassword = mysqli_real_escape_string($conn, $password);

		$select = "SELECT First_Name, Last_Name, password FROM tbl_admin WHERE username = ?";
		$stmt = $conn->prepare($select);

		if ($stmt) {
		    $stmt->bind_param("s", $cleanUsername);
		    $stmt->execute();
		    $stmt->store_result();

		    if ($stmt->num_rows > 0 ) {

		        $stmt->bind_result($First_Name, $Last_Name,$hashedPassword);
		        $stmt->fetch();
		         $stmt->close();
		        if(password_verify($cleanPassword, $hashedPassword))
		        {
		        				        // Password verification would be done here if you're not handling it in the SQL query

			        $_SESSION["logged_in"] = "auth";
			        $_SESSION["firstName"] = $First_Name;
			        $_SESSION["lastName"] = $Last_Name;
			        sendValid();

		        }
		        else
		        {
		        	sendInvalid();
		        }
		     	       		        
		    } else {
		        $stmt->close();
		        sendInvalid();
		    }
		} else {
		    // Handle prepare error
		    $error_message = 'Error in preparing statement';
    		sendResponseWithError($error_message);
		}

    }
    else
    {
        session_destroy(); #destroy all sesssion because its illegal to navigate to this page unless its post
        header("Location: index.php");
        exit;

    }
} 
catch (Exception $e) 
{
    sendResponseWithError($e->getMessage());
}






?>