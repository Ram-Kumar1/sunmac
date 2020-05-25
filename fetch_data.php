<?php

include "db_connect.php";

if(isset($_POST['state']))
{

 $state = $_POST['state'];
 $find=mysqli_query($conn,"select CITY_NAME FROM city where STATE_NAME='$state'");
 ?>
<option value=""> Select City</option>
 <?php
 while($row=mysqli_fetch_array($find))

 {
  echo "<option>".$row['CITY_NAME']."</option>";
 }
 exit;
}



// for Update


if(isset($_POST['updateupdate'])){  


     $categoryid = $_POST['categoryid'];
     $machinecount = $_POST['machinecount'];
     $machineName = $_POST['machineName']; 

if($machinecount != '0'){

    echo $sql = "UPDATE `category_machine` SET `MACHINE_ALLOCATION`='$machineName' WHERE CATEGORY_ID ='$categoryid'";

      if (mysqli_query($conn, $sql)) {

             } else {
                 echo "Error: " . $sql . "" . mysqli_error($conn);
              }
}
else{

}
?>
<script>
 window.location.href='sales_customer.php';
</script>
<?php
}


// for insert


if(isset($_POST['insert'])){  
  $categoryId = $_POST['categoryId'];
    $machinecount = $_POST['machinecount'];
     $machineName = $_POST['machineName'];  //1,2,3
      $sql = "INSERT INTO `category_machine`(`CATEGORY_ID`, `MACHINE_ALLOCATION`) VALUES ($categoryId,'$machineName')";
      $sql2=mysqli_query($conn,$sql); 
    }





if(isset($_POST['s_id'])){ 

    $s_id = $_POST['s_id'];
    $machinecount = $_POST['machinecount'];
     $machineName = $_POST['machineName']; 

    $machineNameArray = explode(',', $machineName);

$d = 0;
$e = 0;

$manu = [];
$delu = [];

for($i=0; $i<$machinecount; $i++) {

      if(strpos($machineNameArray[$i],"_Manufacturer") > 0 ){
            $manu[$d] =str_replace("_Manufacturer","", $machineNameArray[$i]) ;
          $d++;
      }

      if(strpos($machineNameArray[$i],"_Dealer") > 0 ){
            $delu[$e] = str_replace("_Dealer","", $machineNameArray[$i]);
          $e++;
      }

 }

 echo count($manu);

 $a = null;
 $b = null;

  "<br>json"+$a =  json_encode($manu);
  "<br>json"+$b =  json_encode($delu);



   $sql_query = "UPDATE `sales_customer` SET `S_MANUFACTURER_PRODUCTS`= '$a' ,`S_DEALER_PRODUCTS`='$b' ,`S_NEED_TO_FOLLOWED`= '1' WHERE S_ID ='$s_id' ";

  $insert = mysqli_query($conn, $sql_query);


   echo $sql_query1 = "INSERT INTO `followup`(`S_ID`,`CUSTOMER_STATUS`) VALUES ('$s_id','0')";

  $insert1 = mysqli_query($conn, $sql_query1);
?>
    <script>
  debugger;
 window.location.href='sales_customer.php';
</script>
<?php
      
exit;

}









if(isset($_POST['empId']))
{

 $empId = $_POST['empId'];
 $find=mysqli_query($conn,"select * FROM employee_details where EMPLOYEE_ID='$empId'");
 ?>
<option value=""> Select City</option>
 <?php
 while($row=mysqli_fetch_array($find))

 {
  echo "<option>".$row['EMPLOYEE_MOBILE']."</option>";
 }
 exit;
}








//update of sales custometr



if(isset($_POST['s_update'])){ 

    $s_id = $_POST['s_id_up'];
    $s_name = $_POST['s_name'];
    $s_mobile = $_POST['s_mobile'];
    $S_MAIL = $_POST['S_MAIL'];
    $s_address = $_POST['s_address'];
    $s_city = $_POST['s_city'];


  echo  $machinecount = $_POST['machinecount'];
  echo  $machineName = $_POST['machineName']; 

        $machineNameArray = explode(',', $machineName);

$d = 0;
$e = 0;

$manu = [];
$delu = [];

for($i=0; $i<$machinecount; $i++) {

      if(strpos($machineNameArray[$i],"_Manufacturer") > 0 ){
            $manu[$d] =str_replace("_Manufacturer","", $machineNameArray[$i]) ;
          $d++;
      }

      if(strpos($machineNameArray[$i],"_Dealer") > 0 ){
            $delu[$e] = str_replace("_Dealer","", $machineNameArray[$i]);
          $e++;
      }

 }

 echo count($manu);

 $a = null;
 $b = null;

  "<br>json"+$a =  json_encode($manu);
  "<br>json"+$b =  json_encode($delu);



 echo   $sql_query1 = "UPDATE `sales_customer` SET `S_NAME`='$s_name' ,`S_MOBILE`= '$s_mobile',`S_MAIL`= '$S_MAIL' ,`S_ADDRESS`='$s_address' ,`S_STATE`= '$s_state',`S_CITY`= '$s_city' , `S_MANUFACTURER_PRODUCTS`= '$a' ,`S_DEALER_PRODUCTS`='$b' WHERE S_ID ='$s_id' ";

    $insert = mysqli_query($conn, $sql_query1);
    ?>
    <script>
 window.location.href='sales_customer.php';
</script>
<?php
exit;

}


?>