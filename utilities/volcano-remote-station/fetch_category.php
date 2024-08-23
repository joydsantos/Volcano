<?php
session_start();
include '../../database/mydb.php';

function sendResponseWithError($error_message)
{
    $response = array("status" => "Error", "error" => $error_message);
    exit(json_encode($response));
}
function Error()
{
    $response = array("status" => "Error", "error" => "Invalid Request");
    exit(json_encode($response));
}

try {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth" && $_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['selectedId']) && $_POST['selectedId'] > 0) {

            $id = intval($_POST['selectedId']);
            $query = "SELECT id, category FROM tbl_remotestation_equip_category WHERE stationtype_id = ?";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($result_id, $result_code);

                $result = array();
                while ($stmt->fetch()) {
                    $result[] = array('id' => $result_id, 'category' => $result_code);
                }

                $stmt->close();

                $response = array('status' => 'success', 'result' => $result);
                echo json_encode($response);
            } else {

                Error();
            }

        } else {
            Error();
        }

    } else {

        session_destroy();
        header("Location: ../../index.php");
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}

?>