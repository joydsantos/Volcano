<?php
session_start();
include '../../database/mydb.php';

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../../index.php");
}
function sendInvalidInputResponse()
{
    $response = array("status" => "Input");
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
function sendDeleteError($error_message)
{
    $response = array(
        "status" => "Error",
        "message" => $error_message
    );
    exit(json_encode($response));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if (!isset($_POST['folder_image']) || !isset($_POST['del_id'])) {
            sendInvalidInputResponse();
        }
        $id = intval($_POST['del_id']);
        $filename = $_POST['folder_image'];
        //deltee sa folder
        $filePath = 'uploads/' . $filename;



        #add security layer where the file name and id must match in database to avoid manipulating in user end
        $insert = "SELECT name FROM tbl_obs_image WHERE id = ?";
        $stmt = $conn->prepare($insert);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($name);
        $stmt->fetch();
        $resultName = $name;

        #check if its match
        if ($resultName !== $filename) {
            sendInvalidInputResponse();
        }


        if (file_exists($filePath) && unlink($filePath)) {

        } else {
            sendDeleteError("Can not delete image in the folder");
        }



        $stmt->close();
        $delete = "DELETE FROM tbl_obs_image WHERE id = ?";
        $stmt = $conn->prepare($delete);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
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

?>