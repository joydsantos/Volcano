<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
include '../../../database/mydb.php';
if (isset($_POST['oldtranId'])) {
    $id =  $_POST['oldtranId'];
    $output = '';
    $sql = "SELECT * FROM viewoldtransaction WHERE id =?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    $output .= '  
    <div class="table-responsive">  
         <table class="table table-bordered" style = "color:black;">';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '
      <tr>
          <td width="20%"><label>Transaction Number:</label></td>
          <td width="80%">' . htmlspecialchars($row["Transaction_Number"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Item Name:</label></td>
          <td width="80%">' . htmlspecialchars($row["Item_Name"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Serial Number:</label></td>
          <td width="80%">' . htmlspecialchars($row["Serial_Number"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Property Number:</label></td>
          <td width="80%">' . htmlspecialchars($row["Property_Number"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Qty:</label></td>
          <td width="80%">' . htmlspecialchars($row["qty"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Transferred_From:</label></td>
          <td width="80%">' . htmlspecialchars($row["Transferred_From"]) . '</td>
      </tr>
      
      <tr>
          <td width="20%"><label>Transferred_To:</label></td>
          <td width="80%">' . htmlspecialchars($row["Transferred_To"]) . '</td>
      </tr>
       <tr>
          <td width="20%"><label>Division:</label></td>
          <td width="80%">' . htmlspecialchars($row["Division"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Station Name:</label></td>
          <td width="50%">' . htmlspecialchars($row["Station"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Station Code:</label></td>
          <td width="80%">' . htmlspecialchars($row["Station_Code"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Land Owner:</label></td>
          <td width="80%">' . htmlspecialchars($row["Land_Owner"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Care Taker:</label></td>
          <td width="80%">' . htmlspecialchars($row["Care_Taker"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Installation Date</label></td>
          <td width="80%">' . htmlspecialchars($row["Installation_Date"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Date Acquired</label></td>
          <td width="80%">' . htmlspecialchars($row["Date_Acquired"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Warranty Date</label></td>
          <td width="80%">' . htmlspecialchars($row["Warranty_Date"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Status</label></td>
          <td width="80%">' . htmlspecialchars($row["Status"]) . '</td>
      </tr>
      <tr>
          <td width="20%"><label>Remarks</label></td>
          <td width="80%">' . htmlspecialchars($row["Remarks"]) . '</td>
      </tr>';
    }
    $output .= "</table></div>";
    echo $output;
    exit;
}
