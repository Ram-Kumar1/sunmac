<?php

session_start();
include 'db_connect.php';

 if(isset($_POST['update'])) {

     $PRODUCT_NAME = $_POST['PRODUCT_NAME'];
     $PRODUCT_ID = $_POST['PRODUCT_ID'];
     $PRODUCT_DESC = $_POST['PRODUCT_DESC']; 
          
	if(!empty($_POST['JOB_WORKERS'])){
	  $JOB_WORKERS = 1;
	} else {
	  $JOB_WORKERS = 0;
	}

	if(!isset($_FILES['PRODUCT_IMAGE']) || $_FILES['PRODUCT_IMAGE']['error'] == UPLOAD_ERR_NO_FILE) {
	    // Error no file selected 
	    echo "FILE IS NOT SELECTED";
	    $sql ="UPDATE `category` SET `PRODUCT_NAME`='$PRODUCT_NAME',`PRODUCT_DESC`='$PRODUCT_DESC',`JOB_WORKERS`=$JOB_WORKERS  WHERE PRODUCT_ID = $PRODUCT_ID";
	} else {
	    // FILE IS SELECTED
	    $image = addslashes(file_get_contents($_FILES['PRODUCT_IMAGE']['tmp_name']));
    	list($width, $height) = getimagesize($_FILES['PRODUCT_IMAGE']['tmp_name']);
     
	    echo "FILE IS SELECTED";
	    $sql ="UPDATE `category` SET `PRODUCT_NAME`='$PRODUCT_NAME',`PRODUCT_DESC`='$PRODUCT_DESC',`PRODUCT_IMAGE` = '$image' ,`JOB_WORKERS`=$JOB_WORKERS  WHERE PRODUCT_ID = $PRODUCT_ID";
	}
	//echo $sql;

	if (mysqli_query($conn, $sql)) {
	header("Location: category_view.php");
	} else {
	  echo "Error: " . $sql . "" . mysqli_error($conn);
	}
	$conn->close();
}



?>