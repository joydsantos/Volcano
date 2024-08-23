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

try {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {


		if (!isset($_POST['caption'])) {
			sendInvalidInputResponse();
		}

		if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['size'] > 0) {

			$uploadFile = $_FILES['uploadFile'];
			$filename = $uploadFile['name'];

			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$targetFolder = "uploads/";
			if (!is_dir($targetFolder)) {
				mkdir($targetFolder, 0777, true);
			}

			$rawFileName = $filename; #no unique id
			$filename = uniqid() . '_' . '_' . $filename;
			$targetPath = $targetFolder . $filename;



			if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $targetPath)) {

			} else {
				// Handle the case when the file upload fails
				sendInvalidInputResponse();
			}

		} else {
			sendInvalidInputResponse();
		}


		$caption = mysqli_real_escape_string($conn, $_POST['caption']);

		$insert = "INSERT INTO tbl_data_acquisition (`name`, `caption`) VALUES ( ? , ?)";
		$stmt = $conn->prepare($insert);
		$stmt->bind_param("ss", $filename, $caption);

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