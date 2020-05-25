<?php
session_start();
include 'db_connect.php';

if(isset($_POST['submit'])){

  $PRODUCT_ID= $_POST['PRODUCT_ID'];

  $delete = "DELETE FROM category WHERE PRODUCT_ID = '$PRODUCT_ID'";
  mysqli_query($conn,$delete);

  $delete1 = "DELETE FROM category_machine WHERE CATEGORY_ID = '$PRODUCT_ID'";
  mysqli_query($conn,$delete1);

  $delete1 = "SELECT * FROM `sales_customer` WHERE `S_MANUFACTURER_PRODUCTS` LIKE '%$PRODUCT_ID%'";
  $result = mysqli_query($conn,$delete1);
  while($row = mysqli_fetch_array($result)){
    $customerId = $row['S_ID'];
    $productId = $row['S_MANUFACTURER_PRODUCTS'];
    $productId =  str_replace('"',"", $productId);
    $productId =  str_replace('[',"", $productId);
    $productId =  str_replace(']',"", $productId);
    $productId = explode(',',$productId); // 1,2,3

    if(($key = array_search($PRODUCT_ID,$productId))!== false ){
      unset($productId[$key]);
      //print_r($productId);
      $productId = implode(",",$productId); // 1,3,5 [Converted String]
      $productId = str_replace(',','","', $productId); // 1","3","5
      $productId = '["'.$productId.'"]';

       $update = "update sales_customer set S_MANUFACTURER_PRODUCTS = '$productId' WHERE S_ID = $customerId";
       mysqli_query($conn,$update);

    }

    //for dealer product

     $deaerId = $row['S_DEALER_PRODUCTS'];
    $deaerId =  str_replace('"',"", $deaerId);
    $deaerId =  str_replace('[',"", $deaerId);
    $deaerId =  str_replace(']',"", $deaerId);
    $deaerId = explode(',',$deaerId); // 1,2,3

    if(($key = array_search($PRODUCT_ID,$deaerId))!== false ){
      unset($deaerId[$key]);
      //print_r($deaerId);
      $deaerId = implode(",",$deaerId); // 1,3,5 [Converted String]
      $deaerId = str_replace(',','","', $deaerId); // 1","3","5
      $deaerId = '["'.$deaerId.'"]';

       $update = "update sales_customer set S_DEALER_PRODUCTS = '$deaerId' WHERE S_ID = $customerId";
       mysqli_query($conn,$update);

    }


  }


  ?>
  <script>
    alert("Data Deleted Successfully");
  </script>
<?php
}
?>

  <!DOCTYPE html>                          
  <head>
  <title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
  Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>

  
  </head>
  <body>
  <?php include 'header.php'; ?>
  <!-- sidebar menu end-->

  <section id="main-content">
    <section class="wrapper">
      <div class="form-w3layouts">
          <!-- page start-->

 <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                           PRODUCT VIEW 
                    </header>
                    <br>
                  
<?php
$sql = "SELECT c.PRODUCT_ID,c.PRODUCT_NAME,c.PRODUCT_DESC,c.PRODUCT_IMAGE,c.JOB_WORKERS,cm.MACHINE_ALLOCATION,cm.CATEGORY_ID from category c, category_machine cm WHERE c.PRODUCT_ID = cm.CATEGORY_ID";
 $demo="SELECT MACHINE_ALLOCATION FROM `category_machine`";
  $find=mysqli_query($conn,$demo);

if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
                 <div class="table-responsive">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                  <th style="color:#0c1211";>S No</th>
                                  <th style="color:#0c1211";>PRODUCT NAME</th>
                                  <th style="color:#0c1211";>PRODUCT DESCRIPTION</th>
                                  <th style="color:#0c1211";>PRODUCT IMAGE</th>
                                  <th style="color:#0c1211";>WORK TYPE</th>
                                  <th style="color:#0c1211";>MACHINE_ALLOCATON</th>
                                  <th style="color:#0c1211";>UPDATE</th>
                                 


                                </tr>
                             </thead>
<?php 
$sno=1;
while($row = mysqli_fetch_array($result)){
?>
                           <tbody>
                              <tr>
                                <td style="color:#0c1211";><?php echo $sno; $sno++;?></td>
                                <td style="color:#0c1211";><?php echo $row['PRODUCT_NAME']?></td>
                                <td style="color:#0c1211";><?php echo $row['PRODUCT_DESC']?></td>

                                <td style="color:#0c1211";><?php echo '<img  class="img-responsive" style="width:100%;height:250px" src="data:image/jpeg;base64,'.base64_encode($row['PRODUCT_IMAGE']).'"/ '?></td>

                                <td style="color:#0c1211";><?php 
                                if ($row['JOB_WORKERS'] == '1') {
                                  echo "job work";
                                }else{
                                  echo "production";
                                }
                                 
                                ?></td>
                                <td style="color:#0c1211";><?php 
                                  $man = $row['MACHINE_ALLOCATION'];
                                  $man =  str_replace('"',"", $man);
                                  $man =  explode(',',$man);
                                  $size = sizeof($man);
                                  for($i=0; $i<$size; $i++) {
                                  $pur  = "SELECT `MACHINE_ID`, `MACHINE_NAME` FROM `machine_details` WHERE MACHINE_ID = '$man[$i]' ";
                                  $insert = mysqli_query($conn, $pur);
                                  $rows = mysqli_fetch_array($insert);
                                  echo $rows['MACHINE_NAME'];
                                  echo "<br>";
                                  } ?>
                                </td>


                                <td class="contact-delete">

                        <?php
                        if($row['JOB_WORKERS'] ==  '0' ){
                        ?>
                        <a href="category_update.php?PRODUCT_ID=<?php echo $row['PRODUCT_ID']; ?>"><?php $row['PRODUCT_ID']?>    <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
      <i class="material-icons" style="margin-left: -5px;">
        edit
      </i>
    </button></a>


                        <?php
                        }else{
                        ?>
                        <a href="category_job_work_update.php?PRODUCT_ID=<?php echo $row['PRODUCT_ID']; ?>"><?php $row['PRODUCT_ID']?>    <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
      <i class="material-icons" style="margin-left: -5px;">
        edit
      </i>
    </button></a>
                        <?php
                         }
                        ?>
<br><br>
                                  <form action=" " method="post">
                                    <input type="hidden" name="PRODUCT_ID" value="<?php echo $row['PRODUCT_ID']; ?>">
                                   <!--  <input type="submit" name="submit" value="Delete" class="btn btn-primary" > -->
<button type="submit" name="submit" name="Delete" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
<i class="material-icons" style="margin-left: -5px;">delete_forever</i>
</button>
                                  </form>

       

                                </td>
                                
                              </tr>
                            </tbody>
<?php
}
?>

                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
  }

?>                    
                            <br>
                            <br>
                    
        </div>
      </div>
    </section>
  </div>
</div>
</div>




</body>
</html>






