<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
	session_destroy();
	header("Location: ../../../index.php");
}
include '../../../database/mydb.php';

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
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["catId"])) {

		$catId = intval($_POST["catId"]);
		$query = "SELECT code_id, code FROM tbl_station_code WHERE station_id = ?";
		$stmt = mysqli_prepare($conn, $query);
		$stmt->bind_param("i", $catId);

		$response = array(); //store the results

		if ($stmt) {
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $id, $code);


			while (mysqli_stmt_fetch($stmt)) {
				$response[] = array(
					'code_id' => $id,
					'code' => $code
				);
			}
			mysqli_stmt_data_seek($stmt, 0);
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
