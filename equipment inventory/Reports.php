<?php
include '../database/mydb.php';
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\option;
session_start();


if(isset($_GET['id']) == "stock")#check kung clinick ung dashboard flex
{
	$qry = "SELECT * FROM tbl_stocks ORDER BY Date_Recieved";
}
else if($_SESSION["query"] == "")
{
	 header("Location: filterReport.php");
	 exit();
}
else
{
	$qry =  $_SESSION["query"]; 
}


$searchResult = mysqli_query($conn, $qry);


// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html = '<html><body><p>This is the content of the PDF.</p></body></html>';

// Load the HTML content into the Dompdf object
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper([0, 0, 612, 936], 'landscape');

// Enable PHP code in the footer
$dompdf->set_option('isPhpEnabled', true);

// Set a custom footer with the page number
$dompdf->set_option('footer_html', '<div style="text-align:center; font-size: 10px;">Page {PAGE_NUM} of {PAGE_COUNT}</div>');
$dompdf->set_option('footer_spacing', '5');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to the browser
$dompdf->stream('Report.pdf', ['Attachment' => false]);
?>

	
	