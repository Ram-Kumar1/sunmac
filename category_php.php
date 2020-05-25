<?php

session_start();
include 'db_connect.php';

  if(isset($_POST['submit'])){

         $PRODUCT_NAME = $_POST['PRODUCT_NAME'];
        echo $PRODUCT_ID = $_POST['PRODUCT_ID'];
         $PRODUCT_DESC = $_POST['PRODUCT_DESC']; 
         $followUp = $_POST['followUp'];
         $image = addslashes(file_get_contents($_FILES['PRODUCT_IMAGE']['tmp_name']));
         list($width, $height) = getimagesize($_FILES['PRODUCT_IMAGE']['tmp_name']);


if(!empty($_POST['JOB_WORKERS'])){
$JOB_WORKERS = 1;
}
else{
  $JOB_WORKERS = 0;
}

$sql="INSERT INTO `category`(`PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_DESC`, `PRODUCT_IMAGE`, `FOLLOWUP`, `JOB_WORKERS`) VALUES('$PRODUCT_ID','$PRODUCT_NAME','$PRODUCT_DESC','$image', '$followUp', '$JOB_WORKERS')";


  if (mysqli_query($conn, $sql)) {

header("Location: category_view.php");

             } else {
                 echo "Error: " . $sql . "" . mysqli_error($conn);
              }
              $conn->close();
           }

// update

 if(isset($_POST['update'])){

         $PRODUCT_NAME = $_POST['PRODUCT_NAME'];
         $PRODUCT_ID = $_POST['PRODUCT_ID'];
         $PRODUCT_DESC = $_POST['PRODUCT_DESC']; 
         echo $demo = $_POST['PRODUCT_IMAGE'];
         echo $isTouch = empty($demo);

         $image = addslashes(file_get_contents($_FILES['PRODUCT_IMAGE']['tmp_name']));
         list($width, $height) = getimagesize($_FILES['PRODUCT_IMAGE']['tmp_name']);
           
if(!empty($_POST['JOB_WORKERS'])){
$JOB_WORKERS = 1;
}
else{
  $JOB_WORKERS = 0;
}


if($isTouch == '1'){

echo $sql ="UPDATE `category` SET `PRODUCT_NAME`='$PRODUCT_NAME',`PRODUCT_DESC`='$PRODUCT_DESC',`JOB_WORKERS`=$JOB_WORKERS  WHERE PRODUCT_ID = $PRODUCT_ID";
}
else{

echo "image<br>".$sql ="UPDATE `category` SET `PRODUCT_NAME`='$PRODUCT_NAME',`PRODUCT_DESC`='$PRODUCT_DESC',`PRODUCT_IMAGE` = '$image' ,`JOB_WORKERS`=$JOB_WORKERS  WHERE PRODUCT_ID = $PRODUCT_ID";

}
if (mysqli_query($conn, $sql)) {

// header("Location: category_view.php");

             } else {
                 echo "Error: " . $sql . "" . mysqli_error($conn);
              }
              $conn->close();
           }
 ?>
