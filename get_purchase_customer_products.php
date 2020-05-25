<?php
include "db_connect.php";
if(isset($_POST['customerId'])) {
	// VARIABLE DECLARATION
	$customerId = $_POST['customerId'];
	$res = array();
	$productArray = array();

	$find=mysqli_query($conn,"SELECT * FROM `purchase_customer` WHERE P_ID=$customerId");
	$productDetails = "";
	while($row=mysqli_fetch_array($find)) {
		$res["MOBILE"] = $row['P_MOBILE'];
		$res["EMAIL"] = $row['P_EMAIL'];
		$res["ADDRESS"] = $row['P_ADDRESS'];
		$res["GST"] = $row['GST_NUMBER'];
		$productDetails = $row['P_PRODUCT_DETAILS']; //OUTPUT SAMPLE: 1,2,3
	}
	$productDetailsArray = explode(',', $productDetails);
	$sql="SELECT PURCHASE_PRODUCT_ID, PURCHASE_PRODUCT_NAME from purchase_product where PURCHASE_PRODUCT_ID IN(";
	for ($x = 0; $x < sizeof($productDetailsArray); $x++) {
		$sql .= $productDetailsArray[$x];
		if($x != (sizeof($productDetailsArray) -1) ) {
			$sql .=",";
		}
	}
	$sql .= ")"; 
	if($result = mysqli_query($conn, $sql)) {
		if(mysqli_num_rows($result) > 0) {
			$productDetails = "";
			while($row=mysqli_fetch_array($result)) {
				$productId = $row['PURCHASE_PRODUCT_ID'];
				$productDetails = $row['PURCHASE_PRODUCT_NAME']; //OUTPUT SAMPLE: 1,2,3
				$productArray[$productId] = $productDetails;
			}
			$res["PRODUCTS"] = $productArray;
		}
	}
	
	print json_encode($res);
}
?>