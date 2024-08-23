<?php
session_start();
include '../../database/mydb.php';

function sendInvalid() {
    $response = array("status" => "Invalid", "message" => "Incorrect Input");
    exit(json_encode($response));
}
function sendDuplicate() {
    $response = array("status" => "Invalid", "message" => "Username already exists");
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
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["uname"];
        $password = $_POST["password"];

        if (empty($username) || empty($password) || empty($firstname) || empty($lastname)) {
           sendInvalid();
        }

        $sqlRegex = '/[;\'"\\()|*+--]/';
		if (preg_match($sqlRegex, $username)) {		   
		    sendInvalid();
		}
		if (preg_match($sqlRegex, $password)) {		  
		    sendInvalid();
		}
		if (preg_match($sqlRegex, $firstname)) {		  
		    sendInvalid();
		}

		if (preg_match($sqlRegex, $lastname)) {		   
		    sendInvalid();
		}
		

		$cleanUsername = mysqli_real_escape_string($conn, $username);
		$cleanPassword = mysqli_real_escape_string($conn, $password);
		$hashedPassword = password_hash($cleanPassword, PASSWORD_DEFAULT);
		$cleanFirstName =  mysqli_real_escape_string($conn, $firstname);
		$cleanLastName =  mysqli_real_escape_string($conn, $lastname);


		$select = "SELECT username FROM tbl_admin WHERE username = ?";
		$stmt = $conn->prepare($select);

		if ($stmt) {
		    $stmt->bind_param("s", $cleanUsername);
		    $stmt->execute();
		    $stmt->store_result();

		    if ($stmt->num_rows > 0) {		      
		        $stmt->fetch();
		        $stmt->close();	
		        sendDuplicate();	      
		        
		    } else {
		        $stmt->close();
		        
		        #valid add
		        $insert = "INSERT INTO tbl_admin (First_Name, Last_Name, username, password, status) VALUES(?,?,?,?,?)";
		        $stmt_insert = $conn->prepare($insert);
		        $stat = "Active";
		        if($stmt_insert)
		        {
		        	$stmt_insert->bind_param("sssss", $cleanFirstName, $cleanLastName, $cleanUsername, $hashedPassword, $stat);
		    		if($stmt_insert->execute())
		    		{
		    			$stmt_insert->close();
		    			sendValid();
		    		}
		    		else
		    		{
		    			sendResponseWithError();
		    		}

		        }
		        else
		        {
		        	sendResponseWithError();
		        }


		    }
		} else {
		    // Handle prepare error
		    sendResponseWithError();
		}

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