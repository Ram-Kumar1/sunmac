<?php
session_start();
include 'db_connect.php';
if(isset($_GET['PURCHASE_PRODUCT_ID']) & !empty($_GET['PURCHASE_PRODUCT_ID'])){
        
            $id3 = $_GET['PURCHASE_PRODUCT_ID'];  

          
             $show=mysqli_query($conn,"select * from purchase_product where PURCHASE_PRODUCT_ID = '$id3' ");
                 $row=mysqli_fetch_array($show);
                 
           }
if(isset($_POST['submit'])){

        $PURCHASE_PRODUCT_NAME=$_POST['PURCHASE_PRODUCT_NAME'];
        $PURCHASE_PRODUCT_DESC=$_POST['PURCHASE_PRODUCT_DESC'];
        

          $update ="UPDATE `purchase_product` SET `PURCHASE_PRODUCT_NAME`='$PURCHASE_PRODUCT_NAME',`PURCHASE_PRODUCT_DESC`='$PURCHASE_PRODUCT_DESC' WHERE PURCHASE_PRODUCT_ID = $id3";
             if (mysqli_query($conn,$update)) {
                  ?>
          <script type="text/javascript">
          alert('Data Updated Successfully');
          window.location.href='purchase_product_view.php';
          </script>
          
          <?php
              } else {
                 echo "Error: " . $update . "" . mysqli_error($conn);
              }
           }
        ?>

  <!DOCTYPE html>
  <head>
  <title>Update Raw Material</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
  Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                        PURCHASE PRODUCT DETAILS
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


    
    <form action="" method="POST">
        <div class="form-group">
            <label for="purchase product id">Purchase Id</label>
            <input type="number" class="form-control" id="purchase_product_id" placeholder="Enter purchase product id" name="PURCHASE_PRODUCT_ID" value="<?php echo $PURCHASE_PRODUCT_ID = $row['PURCHASE_PRODUCT_ID']?>" readonly>
        </div>
        <div class="form-group">
            <label for="purchase_product_name">Purchase Product Name</label>
            <input type="text" class="form-control" id="purchase_product_name" placeholder="Enter purchase product name" name="PURCHASE_PRODUCT_NAME" value="<?php echo $PURCHASE_PRODUCT_ID = $row['PURCHASE_PRODUCT_NAME']?>">
        </div>
        <div class="form-group">
            <label for="purchase_product_desc">Purchase Product Description</label>
            <input type="text" class="form-control" id="purchase_product_desc" placeholder="Enter PurchaseProductDescriptioj" name="PURCHASE_PRODUCT_DESC" value="<?php echo $PURCHASE_PRODUCT_ID = $row['PURCHASE_PRODUCT_DESC']?>">
        </div>
        
        <br><br>
          <button type="submit" name="submit" class="btn btn-default">Update</button>  
    </form>
                        </div>
                      </div>

  
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>

  </body>
  </html>

