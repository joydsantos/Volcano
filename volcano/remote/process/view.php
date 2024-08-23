<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
   session_destroy();
   header("Location: ../../../index.php");

}
if (isset($_POST['remoteId'])) {
   $id = intval($_POST['remoteId']); #Sanitize input as an integer
   $output = '';
   $sql = "SELECT * FROM viewremotestation  WHERE id = ?";
   $stmt = mysqli_prepare($conn, $sql);
   mysqli_stmt_bind_param($stmt, "i", $id);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   $output .= '<div class="table-responsive ">
   <table class="table table-bordered " style = "color:black;">';

   while ($row = mysqli_fetch_array($result)) {
      $output .= '<tr>
               <td width="20%"><label>Station:</label></td>
               <td width="80%">' . htmlspecialchars($row["Station"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Station Name:</label></td>
               <td width="80%">' . htmlspecialchars($row["station_name"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Category:</label></td>
               <td width="80%">' . htmlspecialchars($row["station_type"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Type:</label></td>
               <td width="80%">' . htmlspecialchars($row["category"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Latitude:</label></td>
               <td width="80%">' . htmlspecialchars($row["latitude"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Longitude:</label></td>
               <td width="80%">' . htmlspecialchars($row["longitude"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Elevation:</label></td>
               <td width="80%">' . htmlspecialchars($row["elevation"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Instrument:</label></td>
               <td width="80%">' . htmlspecialchars($row["instrument"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Date Started:</label></td>
               <td width="80%">' . htmlspecialchars($row["date_started"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Date Destroyed:</label></td>
               <td width="80%">' . htmlspecialchars($row["date_destroyed"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Address 1:</label></td>
               <td width="80%">' . htmlspecialchars($row["address1"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Region</label></td>
               <td width="80%">' . htmlspecialchars($row["region"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Province</label></td>
               <td width="80%">' . htmlspecialchars($row["province"]) . '</td>
            </tr>
            <tr>
               <td width="20%"><label>Municipality:</label></td>
               <td width="80%">' . htmlspecialchars($row["municipality"]) . '</td>
            </tr>
            <tr>
                <td width="20%"><label>Barangay:</label></td>
                <td width="80%">' . htmlspecialchars($row["barangay"]) . '</td>
            </tr>
            <tr>
                <td width="20%"><label>Remarks:</label></td>
                <td width="80%">' . htmlspecialchars($row["remarks"]) . '</td>
            </tr>';

   }
   $output .= "</table></div>";
   echo $output;
}
