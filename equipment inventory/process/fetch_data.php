<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
include '../../database/mydb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #Get the ID from the POST data
    $id = intval($_POST['id']);

    $query = "SELECT * FROM viewstocks WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Define the data to be returned as JSON
        $data = array(
            'stockId' => $row['stockId'],
            'SerialNum' => $row['Serial_Number'],
            'PropertyNum' => $row['Property_Number'],
            'MAC' => $row['MAC'],
            'ItemName' => $row['Item_Name'],
            'Description' => $row['Description'],
            'qty' => $row['total_Recieved'],
            'avqty' => $row['Qty'],
            'typeQty' => $row['Special_Qty'],
            'dateRecieved' => $row['Date_Recieved'],
            'par' => $row['Par'],
            'unit' => $row['Unit'],
            'category' => $row['Category'],
            'status' => $row['status'],
            'remarks' => $row['remarks'],
            'Filename' => $row['Filename'],
            'Filepath' => $row['Filepath']
        );
        #session for stock ID
        $_SESSION['stock_Id'] = $row['stockId'];
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
