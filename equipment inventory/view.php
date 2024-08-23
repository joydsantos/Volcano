<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
   session_destroy();
   header("Location: ../index.php");
}
include '../database/mydb.php';
if (isset($_POST['stockid'])) {
   $id = intval($_POST['stockid']); #Sanitize input as an integer
   $output = '';
   $sql = "SELECT * FROM viewstocks  WHERE id = ?";
   $stmt = mysqli_prepare($conn, $sql);
   mysqli_stmt_bind_param($stmt, "i", $id);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   $output .= '<div class="table-responsive ">
   <table class="table table-bordered " style = "color:black;">';

   while ($row = mysqli_fetch_array($result)) {
      $output .= '<tr>
               <td width="20%"><label>Stock Number:</label></td>
               <td width="80%">' . htmlspecialchars($row["stockId"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Serial Number:</label></td>
               <td width="80%">' . htmlspecialchars($row["Serial_Number"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>MAC:</label></td>
               <td width="80%">' . htmlspecialchars($row["MAC"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Property Number:</label></td>
               <td width="80%">' . htmlspecialchars($row["Property_Number"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Equipment Name:</label></td>
               <td width="80%">' . htmlspecialchars($row["Item_Name"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Description:</label></td>
               <td width="80%">' . htmlspecialchars($row["Description"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Total Received:</label></td>
               <td width="80%">' . htmlspecialchars($row["total_Recieved"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Available:</label></td>
               <td width="80%">' . htmlspecialchars($row["Qty"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Date Received:</label></td>
               <td width="80%">' . htmlspecialchars($row["Date_Recieved"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>PAR/ICS Assignee:</label></td>
               <td width="80%">' . htmlspecialchars($row["Par"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Category:</label></td>
               <td width="80%">' . htmlspecialchars($row["Category"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Unit:</label></td>
               <td width="80%">' . htmlspecialchars($row["Unit"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Status:</label></td>
               <td width="80%">' . htmlspecialchars($row["status"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Remarks:</label></td>
               <td width="80%">' . htmlspecialchars($row["remarks"]) . '</td>
            </tr>';
   }
   $output .= "</table></div>";
   echo $output;
}
