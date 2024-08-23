<?php
// Start the session
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = "";
    $catg = $_POST['cboStatus'];

    $start = $_POST['startDate'];
    $end = $_POST['endDate'];

    if($catg == "All")
    {
        $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquired BETWEEN '$start' AND '$end' ORDER BY Date_Acquired";
    }
    else if($catg =="Damage")
    {
    	 $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquired BETWEEN '$start' AND '$end' AND Status = 'Damage' ORDER BY Date_Acquired";
    }
    else if($catg =="Missing")
    {
    	 $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquirede BETWEEN '$start' AND '$end' AND Status = 'Missing' ORDER BY Date_Acquired";
    }
    else if($catg =="Ongoing Repair")
    {
    	 $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquired BETWEEN '$start' AND '$end' AND Status = 'Ongoing Repair' ORDER BY Date_Acquired";
    }
        else if($catg =="Servicable")
    {
    	 $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquired BETWEEN '$start' AND '$end' AND Status = 'Servicable' ORDER BY Date_Acquired";
    }
            else if($catg =="Pulled Out")
    {
    	 $query = "SELECT * FROM tbl_oldtransaction WHERE Date_Acquired BETWEEN '$start' AND '$end' AND Status = 'Pulled Out' ORDER BY Date_Acquired";
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
	<title>Reports</title>
	 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <link rel="stylesheet" href="../../css/tranCSS.css"> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<script>
	          
</script>
<body>
		<form method="POST" >
			
				<div class="container mt-5" > 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Select Transaction Report
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
				                    <div class="col-md-12">
				                    	 <div class="form-group">
				                            <label>Select Equipment</label>
                               				<select id="form_need"  name="cboStatus" class="form-control" required="required" >
			                            <option value = "All">All Equipment</option> 
			                            <option value = "Damage">Damage</option>    
			                            <option value = "Missing">Missing</option> 
			                            <option value = "Ongoing Repair">Ongoing Repair</option>
			                            <option value = "Servicable">Servicable</option> 
			                            <option value = "Pulled Out">Pulled Out</option> 
		                                   </select>     
				                            
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