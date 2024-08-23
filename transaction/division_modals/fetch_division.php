<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
include '../../database/mydb.php';
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

        $query = "SELECT * FROM tbl_division";
        $stmt = mysqli_prepare($conn, $query);
        $response = array(); //store the result
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $division);

            while (mysqli_stmt_fetch($stmt)) {
                $response[] = array(
                    'id' => $id,
                    'division' => $division
                );
            }
            mysqli_stmt_data_seek($stmt, 0);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit(json_encode(["status" => "Success", "response" => $response]));
        } else {
            $error_message = mysqli_error($conn);
            sendResponseWithError($error_message);
        }
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
