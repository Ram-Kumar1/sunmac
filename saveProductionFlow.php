<?php

include "db_connect.php";
if(isset($_POST['categoryId']))
{
	$categoryId = $_POST['categoryId']; // 1
	$type = $_POST['type'];
	$size = $_POST['size'];
	$thickness = $_POST['thickness'];
	$arrayLength = $_POST['arrayLength'];
	$machineIdArray = $_POST['machineIdArray']; // 5
	$unProcessedArray = $_POST['unProcessedArray'];
	$stockArray = $_POST['stockArray'];
	$productStock = $_POST['productStock'];
	$productStockWeight = $_POST['productStockWeight'];
	$isFlowCompleted = $_POST['isFlowCompleted'];
	$lastUpdatedDate = $_POST['lastUpdatedDate'];
	$remainingWeight = $_POST['remainingWeight'];

	$oldStockProduct = $_POST['oldStock'];
	$producedStock = $_POST['producedStock'];
	$totalStockProduct = $_POST['totalStock'];
	$oldWeight = $_POST['oldWeight'];
	$producedWeight = $_POST['producedWeight'];
	$totalWeight = $_POST['totalWeight'];

// for new
	$upInputArray = $_POST['upInputArray'];
	$givenInputArray = $_POST['givenInputArray'];
	$totalInputArray = $_POST['totalInputArray'];
	$givenOutputArray = $_POST['givenOutputArray'];
	$processedArray = $_POST['processedArray'];
	$totalProccesedArray = $_POST['totalProccesedArray'];
	$oldStockArray = $_POST['oldStockArray'];
	$updateTabelName = $_POST['updateTabelName'];
	$oldCatName = $_POST['oldCatName'];
	$machineUnProcessedArray;
	$machineStockArray;

	$idArray;
	$upInput;
	$givenInput;
	$totalInput;
	$givenOutput;
	$processed;
	$oldStock;
	$totalProccesed;
	$totalStock;
	$unProcessedOutput;

	$currentDate;
	if($lastUpdatedDate == "") {
		$currentDate = date("Y/m/d");
	} else {
		$currentDate = $lastUpdatedDate;
	}
	
	$count = 0;
	$selectSql = "SELECT COUNT(*) AS CNT FROM available_weight WHERE type='$type'";
	$selectSqlRes = mysqli_query($conn, $selectSql);
	while($row=mysqli_fetch_array($selectSqlRes)) {
		$count = $row['CNT'];
	}
	if($count == 0) {
	   $insertSql = "INSERT INTO `available_weight` (type, total) VALUES ('$type', $remainingWeight)";
	   mysqli_query($conn, $insertSql);
	} else {
		mysqli_query($conn, "UPDATE `available_weight` SET `total`= $remainingWeight WHERE type='$type'");
	}
	
	$countStock = "SELECT COUNT(*) AS CNT FROM `production_stock_report` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness' AND LAST_UPDATED_DATE = '$currentDate'";
		$stockTotal = 0;
		$result = mysqli_query($conn, $countStock);
	 	while($row = mysqli_fetch_array($result)) {
	 		$stockTotal = $row['CNT'];
	 	}

	if($stockTotal > 0 ){
		$query = "DELETE FROM `production_stock_report` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness' AND LAST_UPDATED_DATE = '$currentDate'";
		$result = mysqli_query($conn, $query);
	}
	
		$idArray = explode(',', $machineIdArray);
		$upInput = explode(',', $upInputArray);
		$givenInput = explode(',', $givenInputArray);
		$totalInput = explode(',', $totalInputArray);
		$givenOutput = explode(',', $givenOutputArray);
		$processed = explode(',', $processedArray);
		$oldStock = explode(',', $oldStockArray);
		$totalProccesed = explode(',', $totalProccesedArray);
		$totalStock = explode(',', $stockArray);
		$unProcessedOutput = explode(',', $unProcessedArray);
		for($i=0; $i<$arrayLength; $i++) {

		$currentDate;
		if($lastUpdatedDate == "") {
			
			date_default_timezone_set('Asia/Kolkata');
			$date_1 =  date('d-m-Y H:i');
			$currentDate = date('Y-m-d', strtotime($date_1));
		} else {
			$currentDate = $lastUpdatedDate;
		}
		echo $i;
		echo $insertQuery = "INSERT INTO `production_stock_report`(`CATEGORY_ID`, `MACHINE_ID`, `UP_INPUT`, `GIVEN_INPUT`, `TOTAL_INPUT`, `GIVEN_OUTPUT`, `PROCESSED`, `OLD_STOCK`, `TOTAL_PROCESSED`, `TOTAL_STOCK`, `UNPROCESSED_OUTPUT`, `LAST_UPDATED_DATE`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId,$idArray[$i],$upInput[$i],$givenInput[$i],$totalInput[$i],$givenOutput[$i],$processed[$i],$oldStock[$i],$totalProccesed[$i],$totalStock[$i],$unProcessedOutput[$i],'$currentDate', '$type', '$size', '$thickness')";
		mysqli_query($conn, $insertQuery);
		}

		$isPresentSql = "SELECT COUNT(*) AS CNT FROM `production_flow_status` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		$totalCount_new = 0;
		$result = mysqli_query($conn, $isPresentSql);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCount_new = $row['CNT'];
	 	}

	if($isFlowCompleted == 1) { // FLOW IS COMPLETED
		//INSERT INTO MACHINE_STOCK
		$idArray = explode(',', $machineIdArray);
		$machineUnProcessedArray = explode(',', $unProcessedArray);
		$machineStockArray =  explode(',', $stockArray);

		$selectQuery = "SELECT COUNT(*) AS CNT FROM machine_stock WHERE 1=1 AND CATEGORY_ID=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		$totalCount = 0;
		$result = mysqli_query($conn, $selectQuery);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCount = $row['CNT'];
	 	}	

	 	/*	TO SET THE MACHINE STOCK IN `machine_stock` TABLE	*/
		for($i=0; $i<$arrayLength; $i++) {
			if($totalCount > 0) {
				//UPDATE
				$updateQuery = "UPDATE `machine_stock` SET `MACHINE_STOCK`=$machineStockArray[$i],`UNPROCESSED`=$machineUnProcessedArray[$i] WHERE `MACHINE_ID`=$idArray[$i] AND `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'" ;
				mysqli_query($conn, $updateQuery);
			} else {
				//INSERT
				$insertQuery = "INSERT INTO `machine_stock`(`MACHINE_ID`, `CATEGORY_ID`, `MACHINE_STOCK`, `UNPROCESSED` , `TYPE`, `SIZE`, `thickness`) VALUES ($idArray[$i],$categoryId,$machineStockArray[$i],$machineUnProcessedArray[$i],  '$type', '$size', '$thickness')";
				mysqli_query($conn, $insertQuery);
			}	
		}
		// UPDATE THE PRODUCT STOCK IN PRODUCT_STOCK TABEL
		$selectQuery = "SELECT COUNT(*) AS CNT , STOCK_VALUE FROM product_stock WHERE 1=1 AND PRODUCT_ID=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		$totalCount = 0;
		$result = mysqli_query($conn, $selectQuery);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCount = $row['CNT'];
	 		$STOCK_VALUE = $row['STOCK_VALUE'];
	 	}	
		/*	TO SET THE PRODUCT STOCK IN `product_stock` TABLE	*/

		if($totalCount > 0) {
			//UPDATE
			$productStock = $productStock + $STOCK_VALUE ; 
 			$updateQuery = "UPDATE `product_stock` SET `STOCK_VALUE`=$productStock  WHERE `PRODUCT_ID`= $categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			mysqli_query($conn, $updateQuery);
		} else {
			//INSERT
		    $insertQuery = "INSERT INTO `product_stock`(`PRODUCT_ID`, `STOCK_VALUE`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId,$productStock, '$type', '$size', '$thickness')";
			mysqli_query($conn, $insertQuery);
		}
		echo "inserted successfully";
		// UPDATE THE PRODUCT WEIGHT IN PRODUCT_STOCK_WEIGHT TABEL
		$selectQuery = "SELECT COUNT(*) AS CNT , STOCK_VALUE FROM product_stock_weight WHERE 1=1 AND PRODUCT_ID=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		$totalCount = 0;
		$result = mysqli_query($conn, $selectQuery);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCountForWeight = $row['CNT'];
	 		$STOCK_VALUE_WEIGHT = $row['STOCK_VALUE'];
	 	}	
		/*	TO SET THE PRODUCT WEIGHT IN `product_stock_weight` TABLE	*/

		if($totalCountForWeight > 0) {
			//UPDATE
			$productStockWeight = $productStockWeight + $STOCK_VALUE_WEIGHT ; 
 			$updateQuery = "UPDATE `product_stock_weight` SET `STOCK_VALUE`=$productStockWeight  WHERE `PRODUCT_ID`= $categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			mysqli_query($conn, $updateQuery);
		} else {
			//INSERT
		    $insertQuery = "INSERT INTO `product_stock_weight`(`PRODUCT_ID`, `STOCK_VALUE`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId, $productStockWeight, '$type', '$size', '$thickness')";
			mysqli_query($conn, $insertQuery);
		}
		echo "Weight Update Successfull";
	 	if( $totalCount_new > 0 ) {
	 		//UPDATE
	 		$updateStatus = "UPDATE `production_flow_status` SET `complision_status`='YES' WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
            mysqli_query($conn, $updateStatus);

	 	} else {
	 		//INSERT
	 		$updateStatus = "INSERT INTO `production_flow_status`(`CATEGORY_ID`, `complision_status`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId, 'YES', '$type', '$size', '$thickness')";
	 	    mysqli_query($conn, $updateStatus);

	 	}
	 	/*	DELETE THE UNCOMPLETED_MACHINE STOCK TABLE */
	 	$deleteSql = "DELETE FROM `uncompleted_machine_stock` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		 mysqli_query($conn, $deleteSql);
		 $deleteSql = "DELETE FROM `uncompleted_machine_time` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
	 	mysqli_query($conn, $deleteSql);

		 /*	INSERT INTO daily_production_tracker FOR REPORT	*/
		$insertProductionStockTracker = "INSERT INTO `daily_production_tracker`(`PRODUCT_ID`, `TYPE`, `SIZE`, `THICKNESS`, `OLD_STOCK`, `PRODUCTION`, `TOTAL_STOCK`, `DATE`, `OLD_WEIGHT`, `PRODUCTION_WEIGHT`, `TOTAL_WEIGHT`) VALUES ($categoryId, '$type', '$size', '$thickness', $oldStockProduct, $producedStock, $totalStockProduct , '$lastUpdatedDate', $oldWeight, $producedWeight, $totalWeight)";
		mysqli_query($conn, $insertProductionStockTracker);

	} else {
		//INSERT INTO UNCOMPLETED_MACHINE_STOCK

		$idArray = explode(',', $machineIdArray);
		$upInput = explode(',', $upInputArray);
		$givenInput = explode(',', $givenInputArray);
		$totalInput = explode(',', $totalInputArray);
		$givenOutput = explode(',', $givenOutputArray);
		$processed = explode(',', $processedArray);
		$oldStock = explode(',', $oldStockArray);
		$totalProccesed = explode(',', $totalProccesedArray);
		$totalStock = explode(',', $stockArray);
		$unProcessedOutput = explode(',', $unProcessedArray);

		$selectQuery = "SELECT COUNT(*) AS CNT FROM uncompleted_machine_stock WHERE 1=1 AND CATEGORY_ID=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
		$totalCount = 0;
		$result = mysqli_query($conn, $selectQuery);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCount = $row['CNT'];
	 	}

			if($totalCount > 0) {
				$deleteSql = "DELETE FROM `uncompleted_machine_stock` WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
	 			mysqli_query($conn, $deleteSql);
			}
	 	/*	TO SET THE MACHINE STOCK IN `machine_stock` TABLE	*/
		for($i=0; $i<$arrayLength; $i++) {
			
			$currentDate;
			if($lastUpdatedDate == "") {
				date_default_timezone_set('Asia/Kolkata');
				$date_1 =  date('d-m-Y H:i');
				$currentDate = date('Y-m-d', strtotime($date_1));
			} else {
				$currentDate = $lastUpdatedDate;
			}
			
			echo $i;
			echo $insertQuery = "INSERT INTO `uncompleted_machine_stock`(`CATEGORY_ID`, `MACHINE_ID`, `UP_INPUT`, `GIVEN_INPUT`, `TOTAL_INPUT`, `GIVEN_OUTPUT`, `PROCESSED`, `OLD_STOCK`, `TOTAL_PROCESSED`, `TOTAL_STOCK`, `UNPROCESSED_OUTPUT`, `LAST_UPDATED_DATE`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId,$idArray[$i],$upInput[$i],$givenInput[$i],$totalInput[$i],$givenOutput[$i],$processed[$i],$oldStock[$i],$totalProccesed[$i],$totalStock[$i],$unProcessedOutput[$i],'$currentDate', '$type', '$size', '$thickness')";
			mysqli_query($conn, $insertQuery);
		}

		if( $totalCount_new > 0 ) {
	 		//UPDATE
	 		$updateStatus = "UPDATE `production_flow_status` SET `complision_status`='NO' WHERE `CATEGORY_ID`=$categoryId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
	 		mysqli_query($conn, $updateStatus);
	 	} else {
	 		//INSERT
	 		$updateStatus = "INSERT INTO `production_flow_status`(`CATEGORY_ID`, `complision_status`, `TYPE`, `SIZE`, `thickness`) VALUES ($categoryId, 'NO', '$type', '$size', '$thickness')";
	 		mysqli_query($conn, $updateStatus);
	 	}
	}

	if($oldCatName != 'NILL') {
		$catIdQ = "SELECT `PRODUCT_ID` FROM `category` WHERE `PRODUCT_NAME`= '$oldCatName'";
		$findCatId = mysqli_query($conn, $catIdQ);
		$row = mysqli_fetch_array($findCatId);
		$catId = $row['PRODUCT_ID'];
		if($updateTabelName == 'machine_stock') {
			$idArray = explode(',', $machineIdArray);
			$machineUnProcessedArray = explode(',', $unProcessedArray);
			$machineStockArray =  explode(',', $stockArray);

			$updateTabelQuery = "UPDATE `machine_stock` SET `UNPROCESSED`= $machineUnProcessedArray[0], `MACHINE_STOCK`=$machineStockArray[0] WHERE `MACHINE_ID`= $idArray[0] AND `CATEGORY_ID`=$catId AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			mysqli_query($conn, $updateTabelQuery);

		} else if($updateTabelName == 'uncompleted_machine_stock') {
			$processed = explode(',', $processedArray);
			$oldStock = explode(',', $oldStockArray);
			$totalProccesed = explode(',', $totalProccesedArray);
			$totalStock = explode(',', $stockArray);
			$unProcessedOutput = explode(',', $unProcessedArray);

			$currentDate;
			if($lastUpdatedDate == "") {
				
				date_default_timezone_set('Asia/Kolkata');
				$date_1 =  date('d-m-Y H:i');
				$currentDate = date('Y-m-d', strtotime($date_1));
			} else {
				$currentDate = $lastUpdatedDate;
			}
			echo $updateTabelQuery = "UPDATE `uncompleted_machine_stock` SET `PROCESSED`=$processed[0],`OLD_STOCK`=$oldStock[0],`TOTAL_PROCESSED`=$totalProccesed[0],`TOTAL_STOCK`=$totalStock[0],`UNPROCESSED_OUTPUT`=$unProcessedOutput[0],`LAST_UPDATED_DATE`='$currentDate' WHERE `CATEGORY_ID`=$catId AND `MACHINE_ID`=$idArray[0] AND `TYPE`='$type' AND `SIZE`='$size' AND `thickness` = '$thickness'";
			mysqli_query($conn, $updateTabelQuery);
		}
	}	
}

else if(isset($_POST['forTime'])) {
	$size = $_POST['size'];
	$lastUpdatedDate = $_POST['lastUpdatedDate'];
	$isFlowCompleted = $_POST['isFlowCompleted'];
	$arrayLength = $_POST['arrayLength'];
	$machineIdArray = $_POST['machineIdArray'];
	$macineNameArray = $_POST['macineNameArray'];
	$minutesArray = $_POST['minutesArray'];
	$numbersArray = $_POST['numbersArray'];
	$countArray = $_POST['countArray'];
	$lengthArray = $_POST['lengthArray'];

	$machineId = explode(',', $machineIdArray);
	$macineName = explode(',', $macineNameArray);
	$minutes = explode(',', $minutesArray);
	$numbers = explode(',', $numbersArray);
	$count = explode(',', $countArray);
	$length = explode(',', $lengthArray);

	$categoryId1 = $_POST['categoryId1']; // 1
	$type = $_POST['type'];
	$size = $_POST['size'];
	$thickness = $_POST['thickness'];
	

	if($isFlowCompleted == 0) {
		// Insert into uncompleted_machine_time
		$selectQuery = "SELECT COUNT(*) AS CNT FROM uncompleted_machine_time WHERE `category_id` = $categoryId1 AND `type` = '$type' AND `thickness` = '$thickness' AND `size` = '$size'";
		$totalCount = 0;
		$result = mysqli_query($conn, $selectQuery);
	 	while($row = mysqli_fetch_array($result)) {
	 		$totalCount = $row['CNT'];
		 }
		 if($totalCount > 0) {
			 // UPDATE
			 $delete = "delete from uncompleted_machine_time where `category_id` = $categoryId1 AND `type` = '$type' AND `thickness` = '$thickness' AND `size` = '$size'";
			 mysqli_query($conn, $delete);
		} 
		// INSERT
		for ($i=0; $i<$arrayLength; $i++) {
			$insert = "INSERT INTO `uncompleted_machine_time`
				(`category_id`, `type`, `thickness`, `size`, `machine_id`, `minutes`, `numbers`, `count`, `length`) VALUES 
				($categoryId1, '$type', '$thickness', '$size', $machineId[$i], $minutes[$i], $numbers[$i], $count[$i], $length[$i])";
			mysqli_query($conn, $insert);
		}

	} else {
		// Insert into completed_machine_time
		for ($i=0; $i<$arrayLength; $i++) {
			echo $insert = "INSERT INTO `machine_time_record`
				(`category_id`, `type`, `thickness`, `size`, `machine_id`, `minutes`, `numbers`, `count`, `length`, `date`) VALUES 
				($categoryId1, '$type', '$thickness', '$size', $machineId[$i], $minutes[$i], $numbers[$i], $count[$i], $length[$i], '$lastUpdatedDate')";
			mysqli_query($conn, $insert);
		}
	}

}



// DELETE FROM `production_stock_report` WHERE 1
// DELETE FROM `machine_stock` WHERE 1
// DELETE FROM `production_flow_status` WHERE 1
// DELETE FROM `uncompleted_machine_stock` WHERE 1


?>