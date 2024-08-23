<?php 
include '../../database/mydb.php';

if(isset($_POST['stockid'])){

  $id = $_POST['stockid'];
$output = '';
$sql = "SELECT * FROM tblremote WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    // fetch rows from $result

  $output .= '  
    <div class="table-responsive">  
         <table class="table table-bordered">';  
    while($row = mysqli_fetch_array($result))  
    {  
         $output = '
             
              
               <tr>  
                   <td width="30%"><label>Volcano Name:</label></td>  
                    <td width="50%">'.$row["VolcanoName"].'</td>   
              </tr>  
               <tr>  
                   <td width="30%"><label>Station Name:</label></td>  
                    <td width="50%">'.$row["StationName"].'</td>  
                    
              </tr>
               <tr>  
                   <td width="30%"><label>Station Code:</label></td>  
                    <td width="50%">'.$row["StationCode"].'</td>  
                    
              </tr>
               <tr>  
                   <td width="30%"><label>Location:</label></td>  
                    <td width="50%">'.$row["Location"].'</td>  
                    
              </tr>
               <tr>  
                   <td width="30%"><label>Latitude:</label></td>  
                     <td width="50%">'.$row["Latitude"].'</td>  
              </tr>
              <tr>  
                   <td width="30%"><label>Longitude:</label></td>  
                    <td width="50%">'.$row["Longitude"].'</td>   
              </tr>
               <tr>  
                   <td width="30%"><label>Elevation:</label></td>  
                     <td width="50%">'.$row["Elevation"].'</td>  
              </tr>
               <tr>  
                   <td width="30%"><label>Station Type:</label></td>  
                     <td width="50%">'.$row["StationType"].'</td>  
              </tr>
               <tr>  
                   <td width="30%"><label>Instruments:</label></td>  
                     <td width="50%">'.$row["Instrument"].'</td>  
              </tr>
               <tr>  
                   <td width="30%"><label>Date Started:</label></td>  
                    <td width="50%">'.$row["StartDate"].'</td>  
                    
              </tr>

               <tr>  
                   <td width="30%"><label>Category:</label></td>  
                     <td width="50%">'.$row["Category"].'</td>  
              </tr>
               <tr>  
                   <td width="30%"><label>Date Destroyed By Eruption:</label></td>  
                     <td width="50%">'.$row["DestroyedByEruptionDate"].'</td>  
              </tr>
            
              <tr>  
                   <td width="30%"><label>Remarks</label></td>  
                    <td width="50%">'.$row["Remarks"].'</td>   
              </tr>
             

              ';

              
    }  
    $output .= "</table></div>"; 

    echo $output;   
    
    mysqli_stmt_close($stmt);
} else {
    // Handle the error
}

}

