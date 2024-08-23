<?php
include '../../database/mydb.php';
if( $_SESSION["query"] =="")
{
	   header('location: Reports.php');
   		 exit();
}


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
	<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<style type="text/css">
		table#datatableid {
        border-collapse: collapse;
    }
    table#datatableid td,
    table#datatableid th {
    	
        border: 1px solid black;
        padding: 4px; /* Adjust padding as needed */
    }
  
	</style>
</head>
<body >
		<div class="container">	
		<hr> <center><h3>VMEPD OLD TRANSACTION REPORT</h3>		
		<?php  echo "From: " .$_SESSION['start'] ." To: ".  $_SESSION['end'];?>

		</center>
		
	
	<table id="datatableid" name="tableTransaction" border="1">
		<thead class="table-dark">
			<tr>
				<th style="width: 10%">Transaction Number</th>			
				<th style="width: 10%">Equipment Name</th>
				<th style="width: 10%">Serial Number</th>
				
				<th style="width: 5%">Qty</th>
				<th style="width: 10%">Date Acquired</th>
				<th style="width: 10%">Transferred From<</th>
				<th style="width: 10%">Transferred To</th>				
				<th style="width:5%">Station Code</th>
				<th style="width:5%">Station Name</th>				
				<th style="width:5%">Status</th>

			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			while ($row = mysqli_fetch_array($searchResult)) {
			?>
				<tr>
					<td><?php echo $row['Transaction_Number']; ?></td>
					<td><?php echo $row['Item_Name']; ?></td>
					<td><?php echo $row['Serial_Number']; ?></td>
					<td><?php echo $row['qty']; ?></td>
					<td><?php echo $row['Date_Acquired']; ?></td>
					<td><?php echo $row['Transferred_From']; ?></td>
					<td><?php echo $row['Transferred_To']; ?></td>
					
					<td><?php echo $row['Station_Code']; ?></td>
					<td><?php echo $row['Station_Name']; ?></td>
					<td><?php echo $row['Status']; ?></td>
				</tr>
				<?php $count++; ?>
			<?php
			}
			?>
		</tbody>
		
	</table>
	<br>
	<h3 style="text-align: right; margin-right: 100px;">Total: <?php echo $count; ?></h3>

		



</div>
	
</body>
</html>
