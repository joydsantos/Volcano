<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}
include '../../database/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #Get the ID from the POST data
    $id = intval($_POST['id']);

    $query = "SELECT * FROM viewtransaction WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Define the data to be returned as JSON
        $data = array(
            'FetchTranNum' => $row['Transaction_Number'],
            'FetchStockNumber' => $row['stockId'],
            'FetchSerialNum' => $row['Serial_Number'],
            'FetchItemName' => $row['Item_Name'],
            'Fetchqty' => $row['qty'],
            'FetchDate' => $row['transaction_date'],
            'FetchTransFrom' => $row['Transferred_From'],
            'FetchTransTo' => $row['Transferred_To'],
            'FetchDivision' => $row['Division'],
            'FetchStationName' => $row['Station'],
            'FetchStationCode' => $row['Station_Code'],
            'FetchLandOwer' => $row['Land_Owner'],
            'FetchcareTaker' => $row['Care_Taker'],
            'FetchDateAcquired' => $row['Date_Acquired'],
            'FetchInstallationDate' => $row['Installation_Date'],
            'FetchWarrantyDate' => $row['Warranty_Date'],
            'FetchEqstatus' => $row['Status'],
            'Fetchremarks' => $row['Remarks'],
            'FetchDescription' => $row['Description'],
            'FetchFileName' => $row['FileName'],
        );
        #session for stock ID
        $_SESSION['update_new_transaction_id'] = $row['id'];
        $_SESSION['update_new_transaction_stock_id'] = $row['stockId'];
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
