<?php
require '../../database/mydb.php';
session_start();

function sendInvalid() {
    $response = array("status" => "Invalid", "message" => "Invalid Request");
    exit(json_encode($response));
}
try {

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth" && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["userID"]) && is_numeric($_POST["userID"]) ) {
            // Validate and sanitize the "id" parameter
            $id = intval($_POST["userID"]);
            $accStatus = $_POST["accStatus"];
           

            $accStatus = isset($_POST["accStatus"]) ? mysqli_real_escape_string($conn, $_POST["accStatus"]) : "";
                     

            if($accStatus === "Active")
            {
                 $stat = "Active";
            }
            else if($accStatus === "Inactive")
            {
                $stat = "Inactive";
            }
            else
            {
               sendInvalid();
            }
                
        } 
        else {
           sendInvalid();
        }
            
    } else {
            session_destroy();
          header("Location: ../../index.php");
    }



    #update
    $update = "UPDATE tbl_admin SET status=? WHERE id = ?";
    $stmt = $conn->prepare($update);

    if ($stmt === false) 
    {
        $response = array("status" => "Error in preparing the statement");
         echo json_encode($response);
        die("Error in preparing the statement: " . $connection->error);
    }
    $stmt->bind_param("si", $stat, $id);

    if ($stmt->execute()) 
    {
       
         $response = array("status" => "success");
         echo json_encode($response);
           
    } else
    {
       sendInvalid();
         
    }
    $stmt->close();
    exit;
    $conn->close();
} 
catch (Exception $e) {
    /*
    $error_message = $e->getMessage();
    $response = array("status" => "error", "message" => $error_message);
    echo json_encode($response); */
    exit;
}
?>
