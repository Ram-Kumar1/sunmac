<?php
include "db_connect.php";
if(isset($_POST['categoryId']))
{
 $categoryId = $_POST['categoryId'];
 $type = $_POST['type'];
 $size = $_POST['size'];
 $thickness = $_POST['thickness'];

 $availableWeightSql = "SELECT * FROM `available_weight` where type='$type'";
 $res = mysqli_query($conn, $availableWeightSql);
 $availableWeight = 0;
 while($rows = mysqli_fetch_array($res)) {
	$availableWeight = $rows['total'];
 }

 $queryProductStock="SELECT * FROM `product_stock` WHERE `PRODUCT_ID` = $categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
 $find=mysqli_query($conn,$queryProductStock);
 $stockValue = "";
 while($rows=mysqli_fetch_array($find)) {
  $stockValue = $rows['STOCK_VALUE'];
 }

 $queryProductStock="SELECT * FROM `product_stock_weight` WHERE `PRODUCT_ID` = $categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
 $find=mysqli_query($conn,$queryProductStock);
 $stockValueWeight = "";
 while($rows=mysqli_fetch_array($find)) {
  $stockValueWeight = $rows['STOCK_VALUE'];
 }

 $queryProductStock="SELECT * FROM `product_weight` WHERE `PRODUCT_ID` = $categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
 $find=mysqli_query($conn,$queryProductStock);
 $productWeight = "0";
 while($rows=mysqli_fetch_array($find)) {
  $productWeight = $rows['weight'];
 }
 
 $demo="SELECT MACHINE_ALLOCATION FROM `category_machine` WHERE CATEGORY_ID=$categoryId";
 $find=mysqli_query($conn,$demo);
 $machineDetails = "";
 while($row=mysqli_fetch_array($find)) {
  $machineDetails = $row['MACHINE_ALLOCATION']; //OUTPUT SAMPLE: 1,2,3
 }
 $machineDetailsArray = explode(',', $machineDetails);

// print_r($machineDetailsArray);
	$i = 0;
	$machineName = []; 
	$machineId = []; 
	$machineType = [];
	$j =0;
	$machineStock = []; //TOTAL-STOCK(UNCOMPLETE)
	$unProcessed = []; //UP-INPUT(UNCOMPLETE)
	$givenInput = [];
	$totalInput = [];
	$givenOutput = [];
	$processed = [];
	$totalProccesed = [];
	$oldStock = [];
	$unProcessedOutput = [];
	// first machine stock
	$firstMachineId = [];
	$firstproductId = [];
	$firstMachinestockUP = [];
	$firstproductName = [];
	$firstMachineStock = [];

	$machineMinutes = [];
	$machineNumbers = [];
	$machineTimeCount = [];
 	$machineTimeLength = [];



	$isFlowCompleted;
	$completeionStatus = "SELECT IFNULL((SELECT `complision_status` FROM `production_flow_status` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'), 0) As COMPLETION_STATUS";
	$selQuery = mysqli_query($conn, $completeionStatus);
	$rowSelect = mysqli_fetch_array($selQuery);
	 $isFlowCompleted = $rowSelect['COMPLETION_STATUS'];

	for ($x = 0; $x < sizeof($machineDetailsArray); $x++) {
		$sql="SELECT MACHINE_ID,MACHINE_NAME,MACHINE_TYPE from machine_details where MACHINE_ID  = $machineDetailsArray[$x] "; 
		$find1 = mysqli_query($conn, $sql);
		$rows=mysqli_fetch_array($find1);
		$machineName[$x] = $rows['MACHINE_NAME'];
		$machineId[$x] = $rows['MACHINE_ID'];
		$machineType[$x] = $rows['MACHINE_TYPE'];
	 }

	if($isFlowCompleted == "NO" ) {	
			for($x=0; $x<sizeof($machineDetailsArray); $x++) {
			$sql = "SELECT  `UP_INPUT`, `GIVEN_INPUT`, `TOTAL_INPUT`, `GIVEN_OUTPUT`, `PROCESSED`, `OLD_STOCK`, `TOTAL_PROCESSED`, `TOTAL_STOCK`, `UNPROCESSED_OUTPUT` FROM `uncompleted_machine_stock` WHERE `CATEGORY_ID` = $categoryId AND `MACHINE_ID` = $machineDetailsArray[$x] AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			$find2 = mysqli_query($conn, $sql);
		 	$row=mysqli_fetch_array($find2);
			$unProcessed[$x] = $row['UP_INPUT'];
			$givenInput[$x] = $row['GIVEN_INPUT'];
			$totalInput[$x] = $row['TOTAL_INPUT'];
			$givenOutput[$x] = $row['GIVEN_OUTPUT'];
			$processed[$x] = $row['PROCESSED'];
			$totalProccesed[$x] = $row['TOTAL_PROCESSED'];
			$oldStock[$x] = $row['OLD_STOCK'];
			$machineStock[$x] = $row['TOTAL_STOCK'];
			$unProcessedOutput[$x] = $row['UNPROCESSED_OUTPUT'];
			
			$sqlTime = "SELECT `minutes`, `numbers`, `count`, `length` FROM `uncompleted_machine_time` WHERE `CATEGORY_ID` = $categoryId AND `MACHINE_ID` = $machineDetailsArray[$x] AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			$findTime = mysqli_query($conn, $sqlTime);
			$rowTime=mysqli_fetch_array($findTime);

			$machineMinutes[$x] = $rowTime['minutes'];
			$machineNumbers[$x] = $rowTime['numbers'];
			$machineTimeCount[$x] = $rowTime['count'];
			$machineTimeLength[$x] = $rowTime['length'];
			
		} 		
	} else {

		for ($x = 0; $x < sizeof($machineDetailsArray); $x++) {
			$sqlStock = "SELECT IFNULL((SELECT MACHINE_STOCK FROM `machine_stock` WHERE `MACHINE_ID`=$machineDetailsArray[$x] AND `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'), 0) As MACHINE_STOCK, IFNULL((SELECT UNPROCESSED FROM `machine_stock` WHERE `MACHINE_ID`=$machineDetailsArray[$x] AND `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'), 0) As `UNPROCESSED`";
		  	$find2 = mysqli_query($conn, $sqlStock);
		 	$row=mysqli_fetch_array($find2);
		 	$machineStock[$x] = $row['MACHINE_STOCK'];
			$unProcessed[$x] = $row['UNPROCESSED'];
			  


			// $sqlTime = "SELECT `minutes`, `numbers`, `count`, `length` FROM `machine_time_record` WHERE `CATEGORY_ID` = $categoryId AND `MACHINE_ID` = $machineDetailsArray[$x] AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";

			// if($findTime = mysqli_query($conn, $sqlTime)) {
			//     if(mysqli_num_rows($findTime) > 0) {
			// 		$rowTime=mysqli_fetch_array($findTime);
			// 		$machineMinutes[$x] = $rowTime['minutes'];
			// 		$machineNumbers[$x] = $rowTime['numbers'];
			// 		$machineTimeCount[$x] = $rowTime['count'];
			// 		$machineTimeLength[$x] = $rowTime['length'];    	
			//     }
			// }
			
		}

	}
  	
// for first machine stock
$z = 0;
$firstMachineNameAndUnprocessed = array();
$firstMachineNameAndStock = array();
$updateTabelName = array();

// $machineCategories = "SELECT `CATEGORY_ID` FROM `category_machine` WHERE `MACHINE_ALLOCATION` LIKE '%,$machineId[0],%' OR `MACHINE_ALLOCATION` LIKE '$machineId[0],%' OR `MACHINE_ALLOCATION` LIKE '%,$machineId[0]'";
 
// $machineCategories = "SELECT `CATEGORY_ID` FROM `category_machine` WHERE `MACHINE_ALLOCATION` LIKE '%,$machineId[0],%'";
$machineCategories =  "SELECT `CATEGORY_ID` FROM `category_machine` CM, product_weight PW WHERE 1=1 
AND PW.product_id = CM.CATEGORY_ID 
AND PW.type = '$type' 
AND PW.size = '$size' 
AND PW.thickness = '$thickness' 
AND PW.weight = '$productWeight' 
AND CM.`MACHINE_ALLOCATION` LIKE '%,$machineId[0],%'";
$findCat = mysqli_query($conn, $machineCategories);
while($row = mysqli_fetch_array($findCat)) {
	$catId = $row['CATEGORY_ID'];
	if($categoryId != $catId) {

		$associatedCatSelect = "SELECT IFNULL((SELECT `complision_status` FROM `production_flow_status` WHERE `CATEGORY_ID`=$catId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'), 'NILL') As `complision_status`";
		$findAssociate = mysqli_query($conn, $associatedCatSelect);
		while($rowAss = mysqli_fetch_array($findAssociate)) {
			$isAssociated =  $rowAss["complision_status"];
			if($isAssociated == "YES") {
				// TAKE FROM MACHINE_STOCK TABLE
				$machineStockSelect = "SELECT * FROM `machine_stock` WHERE `MACHINE_ID`=$machineId[0] AND `CATEGORY_ID`=$catId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
				$find = mysqli_query($conn,$machineStockSelect);
				while($row=mysqli_fetch_array($find)) {
					$firstMachineId[$z] = $row['MACHINE_ID']; 
					$firstproductId[$z] = $row['CATEGORY_ID'];
					$demos="SELECT PRODUCT_NAME FROM `category` WHERE PRODUCT_ID=$firstproductId[$z]";
					$finds=mysqli_query($conn,$demos);
					$res=mysqli_fetch_array($finds);

					$firstMachineNameAndUnprocessed[$res['PRODUCT_NAME']] = $row['UNPROCESSED'];	
					$firstMachineNameAndStock[$res['PRODUCT_NAME']] = $row['MACHINE_STOCK'];
					$updateTabelName[$res['PRODUCT_NAME']] = "machine_stock";
				
					$firstproductName[$z] = $res['PRODUCT_NAME'];
					$firstMachinestockUP[$z] = $row['UNPROCESSED']; 
					$firstMachineStock[$z] = $row['MACHINE_STOCK']; 
					$z++;
				}
			} else if($isAssociated == "NO") {
				// TAKE FROM UNCOMPLETED_MACHINE_STOCK TABEL
				$machineStockSelect = "SELECT * FROM `uncompleted_machine_stock` WHERE `MACHINE_ID`=$machineId[0] AND `CATEGORY_ID`=$catId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
				$find = mysqli_query($conn,$machineStockSelect);
				while($row=mysqli_fetch_array($find)) {
					$givenOutput = $row['GIVEN_OUTPUT'];
					if($givenOutput > 0) {
						$unProcessedOutputUncomplete = $row['UNPROCESSED_OUTPUT'];
						$totalStockUncomplete = $row['TOTAL_STOCK'];
					} else {
						$unProcessedOutputUncomplete = $row['UP_INPUT'];
						$totalStockUncomplete = $row['OLD_STOCK'];
					}
					$firstMachineId[$z] = $row['MACHINE_ID']; 
					$firstproductId[$z] = $row['CATEGORY_ID'];

					$demos="SELECT PRODUCT_NAME FROM `category` WHERE PRODUCT_ID=$firstproductId[$z]";
					$finds=mysqli_query($conn,$demos);
					$res=mysqli_fetch_array($finds);

					$firstMachineNameAndUnprocessed[$res['PRODUCT_NAME']] = $unProcessedOutputUncomplete;	
					$firstMachineNameAndStock[$res['PRODUCT_NAME']] = $totalStockUncomplete;
					$updateTabelName[$res['PRODUCT_NAME']] = "uncompleted_machine_stock";

					$firstproductName[$z] = $res['PRODUCT_NAME'];
					$firstMachinestockUP[$z] = $unProcessedOutputUncomplete; 
					$firstMachineStock[$z] = $totalStockUncomplete; 
					$z++;
				}
			} else if($isAssociated == "NILL") {
				// DO NOTHING
			}
	}
  }
}

// $demo="SELECT * FROM `machine_stock` WHERE `MACHINE_ID`=$machineId[0]";
//  $find=mysqli_query($conn,$demo);
//  $firstmachineDate = "";
//  $z = 0;
// 	 while($row=mysqli_fetch_array($find)) {
// 		$firstMachineId[$z] = $row['MACHINE_ID']; 
// 		$firstproductId[$z] = $row['CATEGORY_ID'];
// 		$demos="SELECT PRODUCT_NAME FROM `category` WHERE PRODUCT_ID=$firstproductId[$z]";
// 		$finds=mysqli_query($conn,$demos);
// 		$res=mysqli_fetch_array($finds);
// 		$firstproductName[$z] = $res['PRODUCT_NAME'];
// 		$firstMachinestockUP[$z] = $row['UNPROCESSED'];  
// 		$z++;
// 	 }

//print json_encode($unProcessed);

    $machineDetails = [];
	$machineDetails['isFlowCompleted'] = $isFlowCompleted;	
	$machineDetails['name'] = $machineName;
	$machineDetails['id'] = $machineId;
	$machineDetails['machineType'] = $machineType;
	$machineDetails['unProcessed'] = $unProcessed;
	$machineDetails['stock'] = $machineStock;
	$machineDetails['givenInput'] = $givenInput;
	$machineDetails['totalInput'] = $totalInput;
	$machineDetails['givenOutput'] = $givenOutput;
	$machineDetails['processed'] = $processed;
	$machineDetails['totalProccesed'] = $totalProccesed;
	$machineDetails['oldStock'] = $oldStock;
	$machineDetails['unProcessedOutput'] = $unProcessedOutput;
	//first machine stock
	$machineDetails['firstMachineId'] = $firstMachineId;
	$machineDetails['firstproductId'] = $firstproductId;
	$machineDetails['firstMachinestockUP'] = $firstMachinestockUP;
	$machineDetails['firstproductName'] = $firstproductName;
	$machineDetails['firstMachineStock'] = $firstMachineStock;
	$machineDetails['firstMachineNameAndUnprocessed'] = $firstMachineNameAndUnprocessed;
	$machineDetails['firstMachineNameAndStock'] = $firstMachineNameAndStock;
	$machineDetails['updateTabelName'] = $updateTabelName;
	$machineDetails['stockValue'] = $stockValue;
	$machineDetails['stockValueWeight'] = $stockValueWeight;
	$machineDetails['productWeight'] = $productWeight;

	$machineDetails['machineMinutes'] = $machineMinutes;
	$machineDetails['machineNumbers'] = $machineNumbers;
	$machineDetails['machineTimeCount'] = $machineTimeCount;
	$machineDetails['machineTimeLength'] = $machineTimeLength;
	 
	$machineDetails['availableWeight'] = $availableWeight;
	// print_r($machineDetails);

	// print_r($firstMachineNameAndUnprocessed);
	// print_r($firstMachineNameAndStock);
	// print_r($firstproductName);
	// print_r($firstMachinestockUP);
	// print_r($firstMachineStock);

	print json_encode($machineDetails);
}
?>