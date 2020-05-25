<?php
session_start();
include 'db_connect.php';

if (isset($_POST['quotationId'])) {
	$ct = 0;
	$S_ID  = 0;
	$S_NAME = '';
	$REFERENCE_NO = '';
	$a = $_POST['quotationId'];
	$sql = "SELECT CUSTOMER_NAME, REFERENCE_NO, Q_STATUS FROM quotation WHERE QUOTATION_ID=$a";
	$result = mysqli_query($conn, $sql);
	$quotationStatus = 0;
	while ($row = mysqli_fetch_array($result)) {
		$S_NAME = $row['CUSTOMER_NAME'];
		$REFERENCE_NO = $row['REFERENCE_NO'];
		$quotationStatus = $row['Q_STATUS'];
	}
	//Q_STATUS - 1 Does not persent in sample_pi
	//Q_STATUS = 0 Present in sample_pi
	$sql = "SELECT count(S_NAME) as ct,S_ID  FROM sales_customer WHERE S_NAME='$S_NAME'";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$ct = $row['ct'];
		$S_ID = $row['S_ID'];
	}
	date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));
	if ($ct > 0) {
		echo "Inside isAdvanceReceived";
		echo $isAdvanceReceived = "SELECT count(*) AS CNT FROM sample_pi WHERE REFERENCE_NO='$REFERENCE_NO' AND INVOICE_STATUS = 0";
		$result = mysqli_query($conn, $isAdvanceReceived);
		$count = 0;
		$isDeletedFromSampleInvoice = 0;
		while ($row = mysqli_fetch_array($result)) {
			$count = $row['CNT'];
		}
		if ($count > 0) {
			echo "\n";
			echo $sql = "DELETE FROM sample_pi WHERE REFERENCE_NO='$REFERENCE_NO'";
			mysqli_query($conn, $sql);
			$isDeletedFromSampleInvoice = 1;
		}
		echo "isDeletedFromSampleInvoice: $isDeletedFromSampleInvoice";
		echo "\nquotationStatus: $quotationStatus";
		if ($isDeletedFromSampleInvoice == 1) {
			echo $sql = "DELETE FROM quotation WHERE QUOTATION_ID=$a AND `Q_STATUS`=0";
			mysqli_query($conn, $sql);
			echo $sql = "INSERT INTO `quotation_followup`(`CUSTOMER_ID`, `Q_STATUS`, `Q_DATE`, `SHOW_TO_ADMIN`) VALUES ($S_ID,0,'$date',1)";
			mysqli_query($conn, $sql);
		} else if ($isDeletedFromSampleInvoice == 0 && $quotationStatus == 1) { // TODO: check $ct status here
			echo $sql = "DELETE FROM quotation WHERE QUOTATION_ID=$a AND `Q_STATUS`=1";
			mysqli_query($conn, $sql);
			echo $sql = "INSERT INTO `quotation_followup`(`CUSTOMER_ID`, `Q_STATUS`, `Q_DATE`, `SHOW_TO_ADMIN`) VALUES ($S_ID,0,'$date',1)";
			mysqli_query($conn, $sql);
		}
	} else { // Direct Quotation
		echo $isAdvanceReceived = "SELECT count(*) AS CNT FROM sample_pi WHERE REFERENCE_NO='$REFERENCE_NO' AND INVOICE_STATUS = 0";
		$result = mysqli_query($conn, $isAdvanceReceived);
		$count = 0;
		$isDeletedFromSampleInvoice = 0;
		while ($row = mysqli_fetch_array($result)) {
			$count = $row['CNT'];
		}
		if ($count > 0) {
			echo "\n";
			echo $sql = "DELETE FROM sample_pi WHERE REFERENCE_NO='$REFERENCE_NO'";
			mysqli_query($conn, $sql);
			$isDeletedFromSampleInvoice = 1;
		}
		echo "isDeletedFromSampleInvoice: $isDeletedFromSampleInvoice";
		echo "\nquotationStatus: $quotationStatus";
		if ($isDeletedFromSampleInvoice == 1) {
			echo $sql = "DELETE FROM quotation WHERE QUOTATION_ID=$a AND `Q_STATUS`=0";
			mysqli_query($conn, $sql);
			
		} else if ($isDeletedFromSampleInvoice == 0 && $quotationStatus == 1) { // TODO: check $ct status here
			echo $sql = "DELETE FROM quotation WHERE QUOTATION_ID=$a AND `Q_STATUS`=1";
			mysqli_query($conn, $sql);
			
		}
	}
} else if (isset($_POST['isDeleteOldQuotation'])) {
	date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));
	echo $sql = "DELETE FROM quotation WHERE Q_DATE < '$date' - INTERVAL 10 DAY";
	mysqli_query($conn, $sql);
	print(json_encode("success"));
}

?>
