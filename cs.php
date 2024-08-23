<?php
include 'database/mydb.php';

// Open the CSV file
$dat = fopen('Book1.csv', "r");
if ($dat === FALSE) {
    die("Failed to open CSV file.");
}

// Read each line of the CSV file
while (($data = fgetcsv($dat)) !== FALSE) {


    // Extract data from each row
    $ItemName = $data[1];
    $PropertyNum = $data[2];
    $SerialNum = $data[3];
    $originalDate = $data[4];
    $dateAcq = date('Y-m-d', strtotime($originalDate));
    $qty = $data[5];
    $div = $data[6];
    $consigne = $data[8];
    $accountable = $data[7];
    $remarks = $data[9];
    $station = 12;
    $stationid = 165;



    // Prepare the INSERT statement
    $insert = "INSERT INTO tbl_oldtransaction (Item_Name, Serial_Number, Property_Number, Date_Acquired, qty, Division_id, Transferred_From, Transferred_To, Remarks, Station_Name, station_code_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    if ($stmt === FALSE) {
        die("Failed to prepare statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssiisssii", $ItemName, $SerialNum, $PropertyNum, $dateAcq, $qty, $div, $consigne, $accountable, $remarks, $station, $stationid);

    // Execute the INSERT statement
    if ($stmt->execute()) {
        // Get the last inserted ID
        $insertedId = $stmt->insert_id;
        $stmt->close();

        // Generate the transaction number
        $latestTransactionNumber1 = "VMEPD-PAST-" . str_pad($insertedId, 4, '0', STR_PAD_LEFT);

        // Prepare the UPDATE statement
        $updateTranNum = "UPDATE tbl_oldtransaction SET Transaction_Number = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateTranNum);
        if ($updateStmt === FALSE) {
            die("Failed to prepare update statement: " . $conn->error);
        }

        // Bind parameters
        $updateStmt->bind_param("si", $latestTransactionNumber1, $insertedId);

        // Execute the UPDATE statement
        if ($updateStmt->execute()) {
            echo "Record successfully updated with Transaction Number: $latestTransactionNumber1<br>";
        } else {
            echo "Failed to execute update statement: " . $updateStmt->error . "<br>";
        }

        $updateStmt->close();
    } else {
        // Handle execution error
        echo "Failed to execute insert statement: " . $stmt->error . "<br>";
    }
}

// Close the CSV file
fclose($dat);

// Close the database connection
$conn->close();

echo "All records processed successfully.";
