<?php

//this is for fetching the data for updating meanwhile the fetch_transfer is for data table 
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
include '../../../database/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    #Get the ID  of old transaction
    $id = intval($_POST['id']);
    $query = "SELECT * FROM viewoldtransactiontransferhistory WHERE transfer_history_id = ? AND transfer_status != 'Archived' ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        /*
            'Land_Owner' => $row['Land_Owner'],
            'Care_Taker' => $row['Care_Taker'],
            'Installation_Date' => $row['Installation_Date'],
                 'Station' => $row['Station'],
 'code' => $row['code'],
        */

        // 

        $data[] = array(
            'transfer_history_id' => $row['transfer_history_id'],
            'id' => $row['id'],
            'Transaction_Number' => $row['Transaction_Number'],
            'Serial_Number' => $row['Serial_Number'],
            'Item_Name' => $row['Item_Name'],
            'division' => $row['division'],
            'Station' => $row['Station'],
            'code' => $row['code'],
            'Transferred_From' => $row['Transferred_From'],
            'Transferred_To' => $row['Transferred_To'],
            'Date_Transferred' => $row['Date_Transferred'],
            'Installation_Date' => $row['Installation_Date'],
            'Status' => $row['Status'],
            'remarks' => $row['remarks']
        );


        // Return the data as JSON
        echo json_encode($data);
    } else {
        // Handle the case when no data is found for the given ID
        echo json_encode(["status" => "No Data"]);
    }

    // Close the statement and the connection
    $stmt->close();
} else {
    // Handle other HTTP request methods if needed
}
