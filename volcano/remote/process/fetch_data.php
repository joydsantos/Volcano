<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../../index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #Get the ID from the POST data
    $id = intval($_POST['id']);

    $query = "SELECT * FROM viewremotestation WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    mysqli_data_seek($result, 0);
    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Define the data to be returned as JSON
        $data = array(
            'station' => $row['Station'],
            'station_name' => $row['station_name'],
            'station_type' => $row['station_type'],
            'category' => $row['category'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'elevation' => $row['elevation'],
            'instrument' => $row['instrument'],
            'date_started' => $row['date_started'],
            'date_destroyed' => $row['date_destroyed'],
            'remarks' => $row['remarks'],
            'address1' => $row['address1'],
            'region' => $row['region'],
            'province' => $row['province'],
            'municipality' => $row['municipality'],
            'barangay' => $row['barangay'],
        );
        #session for id of remote station
        $_SESSION['remote_station_Id'] = $row['id'];
        // Return the data as JSON
        echo json_encode($data);
    } else {
        // Handle the case when no data is found for the given ID
        echo json_encode(array('error' => 'No data found for this Stock'));
    }

    // Close the statement and the connection
    $stmt->close();

} else {
    // Handle other HTTP request methods if needed
}

?>