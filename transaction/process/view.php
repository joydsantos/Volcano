<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
  session_destroy();
  header("Location: ../index.php");
}
include '../../database/mydb.php';

if (isset($_POST['stockid'])) {

  $id =  $_POST['stockid'];
  $output = '';
  $sql = "SELECT * FROM viewtransaction  WHERE id =" . $id;
  $result = mysqli_query($conn, $sql);
  //$row = mysqli_fetch_array($result);


  // if(mysqli_num_rows())

  $output .= '  
    <div class="table-responsive">  
         <table class="table table-bordered" style = "color:black;">';
  while ($row = mysqli_fetch_array($result)) {
    $output .= '
             
              
               <tr>  
                   <td width="20%"><label>Transaction Number:</label></td>  
                    <td width="80%">' . $row["Transaction_Number"] . '</td>   
              </tr>  
               <tr>  
                   <td width="20%"><label>Stock Number:</label></td>  
                    <td width="80%">' . $row["stockId"] . '</td>  
                    
              </tr>
               <tr>  
                   <td width="20%"><label>Serial Number:</label></td>  
                    <td width="80%">' . $row["Serial_Number"] . '</td>  
                    
              </tr>
               <tr>  
                   <td width="20%"><label>Item Name:</label></td>  
                    <td width="80%">' . $row["Item_Name"] . '</td>  
                    
              </tr>
               <tr>  
                   <td width="20%"><label>Qty:</label></td>  
                     <td width="80%">' . $row["qty"] . '</td>  
              </tr>
              <tr>  
                   <td width="20%"><label>Date Acquired</label></td>  
                    <td width="80%">' . $row["Date_Acquired"] . '</td>   
              </tr>
               <tr>  
                   <td width="20%"><label>Transferred From:</label></td>  
                     <td width="80%">' . $row["Transferred_From"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Transferred_To:</label></td>  
                     <td width="80%">' . $row["Transferred_To"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Division:</label></td>  
                     <td width="80%">' . $row["Division"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Station Name:</label></td>  
                     <td width="80%">' . $row["Station"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Station Code:</label></td>  
                    <td width="80%">' . $row["Station_Code"] . '</td>  
                    
              </tr>

               <tr>  
                   <td width="20%"><label>Land Owner:</label></td>  
                     <td width="80%">' . $row["Land_Owner"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Care Taker:</label></td>  
                     <td width="80%">' . $row["Care_Taker"] . '</td>  
              </tr>
               <tr>  
                   <td width="20%"><label>Installation Date</label></td>  
                    <td width="80%">' . $row["Installation_Date"] . '</td>   
              </tr>            
              <tr>  
                   <td width="20%"><label>Warranty Date</label></td>  
                    <td width="80%">' . $row["Warranty_Date"] . '</td>   
              </tr>

              <tr>  
                   <td width="20%"><label>Status</label></td>  
                    <td width="80%">' . $row["Status"] . '</td>   
              </tr>

              <tr>  
                   <td width="20%"><label>Remarks</label></td>  
                    <td width="80%">' . $row["Remarks"] . '</td>   
              </tr>
               <tr>  
                   <td width="20%"><label>Description</label></td>  
                    <td width="80%">' . $row["Description"] . '</td>   
              </tr>


              ';
  }
  $output .= "</table></div>";

  echo $output;
}
