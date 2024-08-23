<?php
// Start the session
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "";
    $catg = $_POST['cboViewCat'];
    $stats = $_POST['cboViewStat'];
    $start = $_POST['startDate'];
    $end = $_POST['endDate'];

     //checkbox function
                       if(isset($_POST['chckAll']))
                       {  
                          //check status for query
                          if($stats == "Functional")
                          {
                            if($catg == "all")
                            {
                               $query = "SELECT stockId, Item_Name, remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' ORDER BY Date_Recieved";
                            }
                            else
                            { 
                               $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' ORDER BY Date_Recieved";
                            }
                          }
                          else if($stats == "Defective")
                          {
                             if($catg == "all")
                              {
                                 $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective'";
                              }
                              else
                              { 
                                 $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg'";
                              }
                          }
                          else
                          {
                              if($catg == "all")
                              {
                                 $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' ORDER BY Date_Recieved";
                              }
                              else
                              { 
                                 $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' ORDER BY Date_Recieved";
                              }
                          }
                          ####
                         

                       }
                        else if(isset($_POST['chckLow']) && isset($_POST['chcHigh']) && isset($_POST['chckOut']))
                          { 
                              //check status for query
                   
                
                                  if($stats == "Functional")
                                  {
                                    if($catg == "all")
                                    {
                                       $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' ORDER BY Date_Recieved";
                                    }
                                    else
                                    { 
                                       $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' ORDER BY Date_Recieved";
                                    }
                                  }
                                  else if($stats == "Defective")
                                  {
                                     if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' ORDER BY Date_Recieved";
                                      }
                                  }
                                  else
                                  {
                                      if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' ORDER BY Date_Recieved";
                                      }
                                  } 
                           }

                        ###
                        else if(isset($_POST['chckLow']) && isset($_POST['chcHigh']))
                          { 
                              //check status for query
                   
                
                                  if($stats == "Functional")
                                  {
                                    if($catg == "all")
                                    {
                                       $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty  >'1' ORDER BY Date_Recieved ";
                                    }
                                    else
                                    { 
                                       $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' OR Qty  >'1' ORDER BY Date_Recieved";
                                    }
                                  }
                                  else if($stats == "Defective")
                                  {
                                     if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' OR  Qty  >'1' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' OR  Qty  >'1' ORDER BY Date_Recieved";
                                      }
                                  }
                                  else
                                  {
                                      if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty  >'1' ORDER BY Date_Recieved ";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' WHERE Qty  >'1' ORDER BY Date_Recieved";
                                      }
                                  } 
                           }
                            ###
                        else if(isset($_POST['chckOut']) && isset($_POST['chcHigh']))
                          { 
                              //check status for query
                   
                
                                  if($stats == "Functional")
                                  {
                                    if($catg == "all")
                                    {
                                       $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty  >'3' OR D Qty < '1' ORDER BY Date_Recieved";
                                    }
                                    else
                                    { 
                                       $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' OR  Qty  >'3' OR  Qty < '1' ORDER BY Date_Recieved";
                                    }
                                  }
                                  else if($stats == "Defective")
                                  {
                                     if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Qty  >'3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' AND Qty  >'3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                  }
                                  else
                                  {
                                      if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty < '1' OR Qty  > '3'  ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' WHERE Qty  >'3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                  } 
                           }

                               ###
                        else if(isset($_POST['chckOut']) && isset($_POST['chckLow']))
                          { 
                              //check status for query
                   
                
                                  if($stats == "Functional")
                                  {
                                    if($catg == "all")
                                    {
                                       $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty  <='3' OR D Qty < '1' ORDER BY Date_Recieved";
                                    }
                                    else
                                    { 
                                       $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' OR  Qty  <='3' OR  Qty < '1' ORDER BY Date_Recieved";
                                    }
                                  }
                                  else if($stats == "Defective")
                                  {
                                     if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Qty  <='3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' AND Qty <='3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                  }
                                  else
                                  {
                                      if($catg == "all")
                                      {
                                         $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty <='3'OR Qty  < '1' ORDER BY Date_Recieved";
                                      }
                                      else
                                      { 
                                         $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty  <='3' OR  Qty < '1' ORDER BY Date_Recieved";
                                      }
                                  } 
                           }


                       else if(isset($_POST['chckLow']))
                          { 
                              //check status for query
                              if($stats == "Functional")
                              {
                                if($catg == "all")
                                {
                                   $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                }
                                else
                                { 
                                   $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                }
                              }
                              else if($stats == "Defective")
                              {
                                 if($catg == "all")
                                  {
                                     $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                  }
                              }
                              else
                              {
                                  if($catg == "all")
                                  {
                                     $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' AND Qty > '1' AND Qty <= '3' ORDER BY Date_Recieved";
                                  }
                              } 
                            }


                          else if(isset($_POST['chcHigh']))
                          {
                              //check status for query
                              if($stats == "Functional")
                              {
                                if($catg == "all")
                                {
                                   $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty > '3' ORDER BY Date_Recieved";
                                }
                                else
                                { 
                                   $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' AND Qty > '3' ORDER BY Date_Recieved";
                                }
                              }
                              else if($stats == "Defective")
                              {
                                 if($catg == "all")
                                  {
                                     $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Qty > '3' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' AND Qty >'3' ORDER BY Date_Recieved";
                                  }
                              }
                              else
                              {
                                  if($catg == "all")
                                  {
                                     $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty > '3' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' AND Qty > '3' ORDER BY Date_Recieved";
                                  }
                              } 
                            }

                            else if(isset($_POST['chckOut']))
                          {
                              //check status for query
                              if($stats == "Functional")
                              {
                                if($catg == "all")
                                {
                                   $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Qty < '1' ORDER BY Date_Recieved";
                                }
                                else
                                { 
                                   $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Functional' AND Category ='$catg' AND Qty < '1' ORDER BY Date_Recieved";
                                }
                              }
                              else if($stats == "Defective")
                              {
                                 if($catg == "all")
                                  {
                                     $query = "SELECT stockId, Item_Name,remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Qty <'1' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND status ='Defective' AND Category ='$catg' AND Qty<'1' ORDER BY Date_Recieved";
                                  }
                              }
                              else
                              {
                                  if($catg == "all")
                                  { 
                                     $query = "SELECT stockId, Item_Name,remarks,Qty, total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Qty < '1' ORDER BY Date_Recieved";
                                  }
                                  else
                                  { 
                                     $query = "SELECT stockId, Item_Name, remarks,Qty,total_Recieved, Date_Recieved, Category, Unit, status FROM tblstocks WHERE Date_Recieved BETWEEN '$start' AND '$end' AND Category ='$catg' AND Qty < '1' ORDER BY Date_Recieved";
                                  }
                              } 
                            }

                            else
                            {
                                           

                            }


    $_SESSION["query"] = $query;
    $_SESSION['start'] = $start;
    $_SESSION['end'] = $end;
    header("Location: Reports.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Filter Reports</title>
	 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <link rel="stylesheet" href="../css/tranCSS.css"> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<script>
	          function toggleCheckbox(isChecked) {
            if(isChecked) {
              $('input[id="chck"]').each(function() {
                this.checked = true;
              });
            } else {
              $('input[id="chck"]').each(function() {
                this.checked = false;
              });
            }
          }


            function toggleCheckbox1(isChecked) {
            if(isChecked) {
             
            } 
            else
            {
               $('input[id="chckAll"]').each(function() {
                this.checked =false;
              });
            }
          }
</script>
<body>
		<form method="POST" >
			
				<div class="container mt-5" > 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Select Stock Report
                            <a href="../navigation.php" class="btn btn-dark float-end">Back</a>
                        </h4>

            		</div>
            		<br>
			            <div class = "container">
			           
				           <form id="contact-form" method="POST" action="" enctype="multipart/form-data">
			           
				            <div class="controls">


				             				              		             
				             
				        
				                 <div class="row">
				                    <div class="col-md-6">
				                    	 <div class="form-group">
				                            <label>Start Date</label>
                               				<input type="date" name="startDate" class="form-control" value = ""  required="required">
				                            
				                        </div>
				                        
				                    </div>

				                    <div class="col-md-6">
				                    	<div class="form-group">
				                            <label>End Date</label>
                               				<input type="date" name="endDate" class="form-control" value = "" required="required">
				                            
				                        </div>
				                        
				                    </div>

				                </div>
				                  
				                 <div class="row">	

				                 		<div class="col-md-6">
				                 			<div class="form-group">
				                 				 <label>Select Item</label>
				                 				<select id="form_need"  name="cboViewCat" class="form-control" >
                                 
                                                <option value = "all" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='all') echo "selected='selected'";?>>All Category</option>      
                                                <option value = "AWS" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='AWS') echo "selected='selected'";?>>AWS</option>      
                                                <option value = "Batteries" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Batteries') echo "selected='selected'";?>>Batteries</option>  
                                                <option value = "Battery Charger" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Battery Charger') echo "selected='selected'";?>>Battery Charger</option>         
                                                <option value = "cGPS (GNSS receiver)" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='cGPS (GNSS receiver)') echo "selected='selected'";?>>cGPS (GNSS receiver)</option> 
                                                <option value = "Data Logger" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Data Logger') echo "selected='selected'";?>>Data Logger</option>    
                                                <option value = "Digitizer" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Digitizer') echo "selected='selected'";?>>Digitizer</option>    
                                                <option value = "Generator" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Generator') echo "selected='selected'";?>>Generator</option>      
                                                <option value = "ICT" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='ICT') echo "selected='selected'";?>>ICT</option> 
                                                <option value = "Infrasound Device" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Infrasound Device') echo "selected='selected'";?>>Infrasound Device</option> 
                                                <option value = "IP Camera" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='IP Camera') echo "selected='selected'";?>>IP Camera</option>       
                                                <option value = "Modem/Router" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Modem/Router') echo "selected='selected'";?>>Modem/Router</option>   
                                                <option value = "Network Switch" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Network Switch') echo "selected='selected'";?>>Network Switch</option>
                                                <option value = "Seismometer Borehole Broadband" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Seismometer Borehole Broadband') echo "selected='selected'";?>>Seismometer Borehole Broadband</option>  
                                                <option value = "Seismometer Posthole Broadband" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Seismometer Posthole Broadband') echo "selected='selected'";?>>Seismometer Posthole Broadband</option>                                       
                                                <option value = "Seismometer Short Period" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Seismometer Short Period') echo "selected='selected'";?>>Seismometer Short Period</option>    
                                                <option value = "Solar Charge Controller (MPPT)" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Solar Charge Controller (MPPT)') echo "selected='selected'";?>>Solar Charge Controller (MPPT)</option>  
                                                <option value = "Solar Charge Controller (PWM)" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Solar Charge Controller (PWM)') echo "selected='selected'";?>>Solar Charge Controller (PWM)</option>
                                                <option value = "Solar Panel Monocrystalline" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Solar Panel Monocrystalline') echo "selected='selected'";?>>Solar Panel Monocrystalline</option>
                                                <option value = "Solar Panel Polycrystalline" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Solar Panel Polycrystalline') echo "selected='selected'";?>>SST Radio</option>                    
                                                <option value = "SST Radio" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='SST Radio') echo "selected='selected'";?>>SST Radio</option>
                                                <option value = "Thermal Camera" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Thermal Camera') echo "selected='selected'";?>>Thermal Camera</option>                                                                                                            
                                                <option value = "Tiltmeter" <?php  if(isset($_POST['cboViewCat']) && $_POST['cboViewCat']=='Tiltmeter') echo "selected='selected'";?>>Tiltmeter</option>  
                                  
                             </select>      
				                 			</div>

				                 		</div>			                                                
					                    


					                    <div class="col-md-6">
					                    	<div class="form-group">
					                    		 <label>Select Status</label>
							                    <select id="form_need"  name="cboViewStat" class="form-control" >
				                                  
				                                    <option value = "all" <?php  if(isset($_POST['cboViewStat']) && $_POST['cboViewStat']=='all') echo "selected='selected'";?>>All Items</option>      
				                                    <option value = "Functional" <?php  if(isset($_POST['cboViewStat']) && $_POST['cboViewStat']=='Functional') echo "selected='selected'";?>>Functional</option>      
				                                    <option value = "Defective" <?php  if(isset($_POST['cboViewStat']) && $_POST['cboViewStat']=='Defective') echo "selected='selected'";?>>Defective</option>                                                                                        
				                             	</select>     
					                    	</div>
					                    	 				                        				                        
					                	</div>
				          
				                	
				           		</div>


				                				              
				                <div class="row">
				                    <div class="col-md-12">
				                        <div class="form-group">
				                            <label for="form_message">Select Item Status</label><br>
				                             <div class="form-check form-check-inline">
				                              <input class="form-check-input" type="checkbox" id="chckAll" name="chckAll"  checked value="All"  <?php if(isset($_POST['chckAll'])) echo "checked='checked'";?> onClick="toggleCheckbox(this.checked);">
				                              <label class="form-check-label" >All</label>
				                            </div>
				                            <div class="form-check form-check-inline">
				                              <input class="form-check-input" type="checkbox" id="chck" name="chcHigh"  checked value="High Stocks" <?php if(isset($_POST['chcHigh'])) echo "checked='checked'";?> onClick="toggleCheckbox1(this.checked);">
				                              <label class="form-check-label" >High Stocks</label>
				                            </div>
				                            <div class="form-check form-check-inline">
				                              <input class="form-check-input" type="checkbox" id="chck" name="chckLow"checked value="Low Stocks" <?php if(isset($_POST['chckLow'])) echo "checked='checked'";?> onClick="toggleCheckbox1(this.checked);">
				                              <label class="form-check-label" >Low Stock</label>
				                            </div>
				                            <div class="form-check form-check-inline">
				                              <input class="form-check-input" type="checkbox" id="chck" name="chckOut" checked value="Out of Stocks" <?php if(isset($_POST['chckOut'])) echo "checked='checked'";?> onClick="toggleCheckbox1(this.checked);">
				                              <label class="form-check-label" >Out of Stocks</label>
				                            </div>
								                            
				                            
				                        </div>

				                    </div>

			                				          
				                </div>

				                <div class="row">
				                	<div class="col-md-12">
				                         <input type="submit" name="btnSubmit" class="btn btn-info   pt-2 btn-block
                                    " value="Generate Report" >
				                        
				                    
				                	</div>
				                	

				                </div><br>
				        	</div>
				        	 	</form>

			        	</div>
                </div>
            </div>
        </div>
    	</div>
			
		</form>

    	

</body>
</html>