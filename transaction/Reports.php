<?php
include '../database/mydb.php';


require '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
session_start();

$qry =  $_SESSION["query"]; 
$searchResult = mysqli_query($conn, $qry);


// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	ob_start();

	require('print.php');
	$html = ob_get_contents();
	ob_get_clean();
	$dompdf->loadHtml($html);

		
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper([0, 0, 612, 936], 'landscape');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream('Report.pdf',['Attachment'=>false]); 


?>
	