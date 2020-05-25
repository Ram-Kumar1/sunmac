<?php

include 'db_connect.php';
require('pdf/fpdf.php');
require('pdf/html2pdf.php');
require('pdf/wordwrap.php');
session_start();

$currentQuotationId = 0;
if(isset($_GET['quotationId'])) {
	$currentQuotationId = $_GET['quotationId'];
}

// $currentQuotationId = $_SESSION['currentQuotationId'];
// $currentQuotationId = 48;
$sql = "SELECT * FROM `billing_address`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
	$address = $row['address'];
}
$refNo = "";
$note1 = "";
$pdfName = "";
$sql = "SELECT * FROM `quotation` where quotation_id = $currentQuotationId";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
	$pdfName = $row['CUSTOMER_NAME'].".pdf";
	$address = $row['CUSTOMER_NAME'] . "\n" . str_replace($row['CUSTOMER_NAME'],"",$row['CUSTOMER_ADDRESS']);
	$refNo = $row['REFERENCE_NO'];
	$followedBy = $row['FOLLOWED_BY_PERSON'];
	$note1 = $row['NOTE_1'];
}
$toAddress = $address;

$sql = "SELECT * FROM `quotation_details` where quotation_id = $currentQuotationId";
$result = mysqli_query($conn, $sql);
$count = 0;
$sizeArray = [];
$thicknessArray = [];
$finishingArray = [];
$typeArray = [];
$productArray = [];
$priceArray = [];
while ($row=mysqli_fetch_array($result)) {
	$sizeArray[$count] = $row['SIZE'];
	$thicknessArray[$count] = $row['thickness'];
	$finishingArray[$count] = $row['FINISHING'];
	$typeArray[$count] = $row['TYPE'];
	$productArray[$count] = $row['PRODUCT'];
	$priceArray[$count] = $row['PRICE'];
	$count++;
}

$qutation =[];
$j=1;
for($i=0;$i<$count;$i++) {
    $qutation[$i] = $j.") ".$sizeArray[$i]."M Long ".$finishingArray[$i]." ".$thicknessArray[$i]."mm ".$typeArray[$i]." ".$productArray[$i]." Rs. ".$priceArray[$i];
    $j++;
 }



// $qutation = $_SESSION["qutation"];
// $toAddress = $_SESSION["toAddress"];

$pdf=new PDF('P','mm','A4','demo','murali',false);
$pdfs=new PDFS();
$pdf->AddPage();
$pdf->SetFontSize(22);
$pdf->SetStyle('B',true);
$pdf->Ln(4);
$pdf->SetFontSize(12);
$pdf->SetFont('Times','',12);
$pdf->mySetTextColor(-1);

// address

// $pdf->SetTextColor(0,0,0);
// $pdf->SetFont('Times','',10);
// $pdf->SetFontSize(14);
// $pdf->MultiCell(180, 7,$address,0,'C');
// $pdf->Ln(12);
// $pdf->SetFontSize(12);
// $pdf->SetFont('Times','',12);
// $pdf->mySetTextColor(-1);

// time

$pdf->SetFontSize(12);
$pdf->SetStyle('B',true);
// $pdf->Cell(0,5,"Date = ".date('d.m.Y'),0,1,'R');
$pdf->MultiCell(0,5,utf8_decode("Date: ".date('d.m.Y'). chr(10) . $refNo . chr(10) . $followedBy),0, 'R');

$pdf->SetFontSize(6);
$pdf->Ln(4);

// heading

$pdf->SetFontSize(12);
$pdf->SetStyle('B',true);
$pdf->Cell(0,5,'To:',0,1,'L');
$pdf->SetFontSize(12);

// address

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',10);
$pdf->SetFontSize(14);
$pdf->MultiCell(180, 7,$toAddress,0);
$pdf->Ln(6);
$pdf->SetFontSize(12);
$pdf->SetFont('Times','',12);
$pdf->mySetTextColor(-1);


// heading

$pdf->SetFontSize(12);
$pdf->SetStyle('B',true);
// $pdf->MultiCell(0,5,utf8_decode("Ram" . chr(10) . "Kumar"),0);
// $pdf->Cell(0,5,'Dear Sir, We are pleased to supply our products with the following price details.',0,1,'L');
$pdf->MultiCell(0,5,utf8_decode('Dear Sir,'. chr(10) .'We are pleased to supply our products with the following price details.'),0);
$pdf->SetFontSize(12);
$pdf->Ln(10);


// for each

foreach($qutation as$text)
 {
if(ini_get('magic_quotes_gpc')=='1')
$text=stripslashes($text);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',10);
$pdf->SetFontSize(12);
$pdf->MultiCell(180, 7,$text,0);
$pdf->Ln(2);
$pdf->SetFontSize(12);
$pdf->SetFont('Times','',12);
$pdf->mySetTextColor(-1);
}
$pdf->SetFontSize(12);
$pdf->SetStyle('U',true);
$pdf->Ln(10);
$pdf->Cell(0,5,'Notes: '.$note1,0,1,'L');
$pdf->SetFontSize(12);
$pdf->Ln(4);

// heading

$pdf->SetFontSize(12);
$pdf->SetStyle('U',true);
$pdf->Ln(10);
$pdf->Cell(0,5,'Terms and Conditions:',0,1,'L');
$pdf->SetFontSize(12);
$pdf->Ln(4);

// terms

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',10);
$pdf->SetFontSize(12);
$pdf->Ln(5);
$pdf->Cell(0,0,'18% GST extra for street light poles ',0,0,'L');
$pdf->Ln(6);
$pdf->Cell(0,0,'Delivery based on quantity ',0,0,'L');
$pdf->Ln(6);
$pdf->Cell(0,0,'Transportation costs extra',0,0,'L');
$pdf->Ln(6);
$pdf->Cell(0,0,'payment Terms:50% on purchase order.Balance before delivery of goods.',0,0,'L');
$pdf->Ln(6);
$pdf->Ln(4);
$pdf->Cell(0,0,'Trust on offer is in-line with your requirement and if you require any further clarification in pdf regard,',0,0,'L');
$pdf->Ln(6);
$pdf->Cell(0,0,'please feel free to contact us.',0,0,'L');
$pdf->Ln(6);
$pdf->Ln(4);
$pdf->Cell(0,0,'Thanking you and assuring you of our best and personalized services at all times and looking forward',0,0,'L');
$pdf->Ln(6);
$pdf->Cell(0,0,'your valuable order.',0,0,'L');
$pdf->Ln(6);

$pdf->SetFontSize(12);
$pdf->SetFont('Times','',12);
$pdf->mySetTextColor(-1);

$pdf->Output('', $pdfName);


?>