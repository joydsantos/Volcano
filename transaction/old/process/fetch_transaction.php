<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
include '../../../database/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #Get the ID from the POST data
    $id = intval($_POST['id']);

    $query = "SELECT * FROM viewoldtransaction WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Define the data to be returned as JSON
        $data = array(
            'TranNum' => $row['Transaction_Number'],
            'SerialNum' => $row['Serial_Number'],
            'PropertyNum' => $row['Property_Number'],
            'ItemName' => $row['Item_Name'],
            'qty' => $row['qty'],
            'TransFrom' => $row['Transferred_From'],
            'TransTo' => $row['Transferred_To'],
            'Division' => $row['Division'],
            'StationName' => $row['Station'],
            'StationCode' => $row['Station_Code'],
            'LandOwer' => $row['Land_Owner'],
            'careTaker' => $row['Care_Taker'],
            'DateAcquired' => $row['Date_Acquired'],
            'InstallationDate' => $row['Installation_Date'],
            'Eqstatus' => $row['Status'],
            'remarks' => $row['Remarks'],
            'FileName' => $row['FileName'],
        );
        #session for stock ID
        $_SESSION['update_transaction_id'] = $row['id'];
        #$_SESSION['availQty'] = $row['Qty'];
        // Return the data as JSON
        echo json_encode($data);
    } else {
        // Handle the case when no data is found for the given ID
        echo json_encode(array('error' => 'No data found for this ID'));
    }

    // Close the statement and the connection
    $stmt->close();
} else {
    // Handle other HTTP request methods if needed
}
