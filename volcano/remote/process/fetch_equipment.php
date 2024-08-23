<?php
include '../../../database/mydb.php';
session_start();
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
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["catID"])) {
		$catId = intval($_POST["catID"]);
		$query = "SELECT id, stationtype_id, category FROM tbl_remotestation_equip_category WHERE stationtype_id = ?";
		$stmt = mysqli_prepare($conn, $query);
		$stmt->bind_param("i", $catId);

		$response = array(); //store the results
		if ($stmt) {
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $id, $stationtype_id, $category);

			while (mysqli_stmt_fetch($stmt)) {
				$response[] = array(
					'id' => $id,
					'stationtype_id' => $stationtype_id,
					'category' => $category
				);
			}


			mysqli_stmt_close($stmt);

			exit(json_encode(["status" => "Success", "response" => $response]));

		} else {
			$error_message = mysqli_error($conn);
			sendResponseWithError($error_message);
		}
	}
} catch (Exception $e) {
	sendResponseWithError($e->getMessage());
}


?>