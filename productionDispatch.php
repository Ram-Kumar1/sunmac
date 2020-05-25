<script>
var productStock = {};
var productStockWgt = {};
var productWeight = {};
var productName = undefined;
var productStockVal = undefined;
var productStockWgtVal = undefined;
</script>

<?php
session_start();
include 'db_connect.php';
if(isset($_GET['invoiceId']) & !empty($_GET['invoiceId'])) {
        
  $id = $_GET['invoiceId'];  
  $select=mysqli_query($conn,"SELECT * FROM `sample_pi` where SAMPLE_PI_ID=".$id);
  $row=mysqli_fetch_array($select);

  $isDispatchBtnDisabled = "disabled";
  $transactoinCompletedSql = "select * from transaction_balance WHERE 1=1 AND IS_PENDING_AMOUNT = 0 AND SAMPLE_PI_ID=$id";
  $transactoinCompletedRes = mysqli_query($conn, $transactoinCompletedSql);
  $balance = 0;
  while($row1 = mysqli_fetch_array($transactoinCompletedRes)) {
    $balance = $row1['BALANCE'];
  }
  if($balance == 0) {
    $isDispatchBtnDisabled = "";
  }


  $sql = "SELECT * FROM `sample_pi_details` WHERE `SAMPLE_PI_ID` = ".$id;

  $productStock = "SELECT P.PRODUCT_ID, CAT.PRODUCT_NAME, P.TYPE, P.SIZE, P.thickness, P.STOCK_VALUE FROM product_stock P, category CAT, sample_pi_details S WHERE 1=1 
   AND CAT.PRODUCT_ID = P.PRODUCT_ID
   AND S.PRODUCT = CAT.PRODUCT_NAME
   AND P.TYPE = S.TYPE 
   AND P.SIZE = S.SIZE 
   AND P.thickness = S.THICKNESS 
   AND S.SAMPLE_PI_ID = $id
   AND P.PRODUCT_ID IN (
       SELECT C.PRODUCT_ID FROM sample_pi_details S, category C WHERE 1=1 
       AND LOWER(TRIM(S.PRODUCT)) = LOWER(TRIM(C.PRODUCT_NAME)) 
       AND S.SAMPLE_PI_ID = $id
  )";
  $productStockRes = mysqli_query($conn, $productStock);
  $productStockArray = array();
  while($row1 = mysqli_fetch_array($productStockRes)){ 
    $productNameStk = "";
    $productNameStk = $row1['PRODUCT_NAME'] . $row1['TYPE'] . $row1['SIZE'] . $row1['thickness'];
    $productStockArray[$productNameStk] = $row1['STOCK_VALUE'];
    
?>
<script>    
    productName = <?php echo "'".$row1['PRODUCT_NAME'] . $row1['TYPE'] . $row1['SIZE'] . $row1['thickness']."'"; ?>;
    productStockVal = <?php echo "'".$row1['STOCK_VALUE']."'"; ?>;
    productStock[productName] = productStockVal;
</script>

<?php
  }

$productStockWgt = "SELECT P.PRODUCT_ID, CAT.PRODUCT_NAME, P.TYPE, P.SIZE, P.thickness, P.STOCK_VALUE FROM product_stock_weight P, category CAT, sample_pi_details S WHERE 1=1 
   AND CAT.PRODUCT_ID = P.PRODUCT_ID 
   AND S.PRODUCT = CAT.PRODUCT_NAME
   AND P.TYPE = S.TYPE 
   AND P.SIZE = S.SIZE 
   AND P.thickness = S.THICKNESS 
   AND S.SAMPLE_PI_ID = $id 
   AND P.PRODUCT_ID IN (
       SELECT C.PRODUCT_ID FROM sample_pi_details S, category C WHERE 1=1 
       AND LOWER(TRIM(S.PRODUCT)) = LOWER(TRIM(C.PRODUCT_NAME)) 
       AND S.SAMPLE_PI_ID = $id
  )";
  $productStockWgtRes = mysqli_query($conn, $productStockWgt);
  $productStockWgtArray = array();
  while($row1 = mysqli_fetch_array($productStockWgtRes)){ 
    $productNameStk = "";
    $productNameStk = $row1['PRODUCT_NAME'] . $row1['TYPE'] . $row1['SIZE'] . $row1['thickness'];
    $productStockWgtArray[$productNameStk] = $row1['STOCK_VALUE'];

?>

<script>    
    productName = <?php echo "'".$row1['PRODUCT_NAME'] . $row1['TYPE'] . $row1['SIZE'] . $row1['thickness']."'"; ?>;
    productStockWgtVal = <?php echo "'".$row1['STOCK_VALUE']."'"; ?>;
    productStockWgt[productName] = productStockWgtVal;
</script>

<?php
  }

  $singleProductWeightSql = "SELECT C.PRODUCT_NAME, PW.type, PW.size, PW.thickness, PW.WEIGHT FROM category C, product_weight PW, sample_pi_details SPD WHERE 1=1 
  AND C.PRODUCT_ID = PW.product_id 
  AND PW.type = SPD.TYPE 
  AND PW.size = SPD.SIZE 
  AND PW.thickness = SPD.THICKNESS 
  AND C.PRODUCT_NAME = SPD.PRODUCT 
  AND SPD.SAMPLE_PI_ID = $id 
  ";
 $wgtRes = mysqli_query($conn, $singleProductWeightSql);
 $wgtArray = array();
 while($row1 = mysqli_fetch_array($wgtRes)){ 
  $productNameStk = "";
  $productNameStk = $row1['PRODUCT_NAME'] . $row1['type'] . $row1['size'] . $row1['thickness'];
   $wgtArray[$productNameStk] = $row1['WEIGHT'];
 }
}
?>
<script>
var sampleInvoiceId = <?php echo $id; ?>;
</script>

  <!DOCTYPE html>
  <head>
  <title>DISPATCH</title>
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

<style>
  .td-calc {
    background: #dde6ef !important;
  }
</style>

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
                          INVOICE DETAILS  
                      </header>
                      <div class="panel-body">
                          <!-- <div class="position-center"> -->


    
    
    
        <script type="text/javascript">
          function demo(val){

            if(val == 'sample_invoice' || val == 'drop'){
             document.getElementById("panel").disabled = true;
            } else {
             document.getElementById("panel").disabled = false;
            }


          }
        </script>

<div class="form-group">
        <label for="sample_invoice_id">Refrence No</label>
        <input type="text" class="form-control" name="REFRENCE_NUMBER" id="REFRENCE_NUMBER" value='<?php echo $row['REFERENCE_NO'] ?>' required readonly>
      </div>

       <div class="form-group">
        <label for="sample_invoice_id">Sample Invoice Id</label>
        <input type="number" class="form-control" name="INVOICE_ID" id="INVOICE_ID" value='<?php echo $row['SAMPLE_PI_ID'] ?>' required readonly>
      </div>  
      <div class="form-group">
        <label for="quotation_id">Customer Name</label>
        <input type="text" class="form-control" name="QUOTATION_ID" value='<?php echo $row['CUSTOMER_NAME'] ?>' required readonly>
      </div>
      <?php
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0) { 
      ?>      
      <div class="table-responsive">
      <table id="data-table" class="table table-striped table-hover">
        <thead>
            <tr style="color:#0c1211";>
            <th style="color:#0c1211;">Old Stock</th>
            <th style="color:#0c1211;">Old Weight</th>
                <th style="color:#0c1211;">Size</th>
                <th style="color:#0c1211;">Product Weight</th>

                <th style="color:#0c1211;">Finishing</th>
                <th style="color:#0c1211;">Type</th>
                <th style="color:#0c1211;">Thickness</th>
                <th style="color:#0c1211;">Product</th>
                <th style="color:#0c1211;">Quantity</th>
                <th style="color:#0c1211;">Dispatch Weight</th>
                
                <th style="color:#0c1211;">Current Stock</th>
                
                <th style="color:#0c1211;">Current Weight</th>
            </tr>
        </thead>
        <?php 
            while($row = mysqli_fetch_array($result)){
        ?>
        <tbody>
            <tr>
            <td class="td-calc" style="color:#0c1211;"><?php echo $productStockArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']]; ?></td>
                
            <td class="td-calc" style="color:#0c1211;"><?php echo $productStockWgtArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']]; ?></td>
                
                <td style="color:#0c1211;" class="sizeCell"><?php echo $row['SIZE']?></td>
                <td class="" style="color:#0c1211;"><?php echo $wgtArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']]; ?></td>
                <td style="color:#0c1211";><?php echo $row['FINISHING']?></td>       
                <td style="color:#0c1211;" class="typeCell"><?php echo $row['TYPE']?></td>
                <td style="color:#0c1211;" class="thicknessCell"><?php echo $row['THICKNESS']?></td>        
                <td style="color:#0c1211;" class="productCell"><?php echo $row['PRODUCT']?></td>
                <td style="color:#0c1211;"><?php echo $row['QUANTITY']?></td>
                
                <td class="" style="color:#0c1211;"><?php echo ($wgtArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']] * $row['QUANTITY']) ; ?></td>
                <td class="td-calc remainingCell" style="color:#0c1211;"><?php echo ($productStockArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']] - $row['QUANTITY']); ?></td>
                <td class="td-calc remainingCellWeight" style="color:#0c1211;"><?php echo ($productStockWgtArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']] - ($row['QUANTITY'] * $wgtArray[$row['PRODUCT'] . $row['TYPE'] . $row['SIZE'] . $row['THICKNESS']]) ); ?></td>
            
            </tr>
        </tbody>
        <?php
            }
        ?>
       </table>
       <?php  
        mysqli_free_result($result);
        } else {
            echo "No records matching your query were found.";
        }
       }
        ?>
      </div>

      <div class="center" style="text-align: center;">
        <button type="button" name="button" class="btn btn-default pull-left" onclick="location.href = 'sales_ppf.php';">
          <i class="fa fa-backward" aria-hidden="true" style="color: black"></i>
          Back
        </button>
        <button type="submit" name="submit" <?php echo $isDispatchBtnDisabled; ?> onclick="updateDetails()" class="btn btn-default pull-right">
          <i class="fa fa-check" aria-hidden="true" style="color: mediumspringgreen"></i>
          Dispatch
        </button> 
      </div> 
    
                        <!-- </div> -->
                      </div>

  
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>

  </body>
<script>
var updateDetails = function() {
    var conform = confirm("Sure to update the status?");
    if(!conform) {
        return;
    }
    var i=0;
    let sizeArr = [];
    let typeArr = [];
    let thicknessArr = [];
    let productArr = [];
    let remainingArr = [];
    let remainingWeightArr = [];
    let isUpdate=true;

    $("button[name='submit']").attr("disabled", true);
    $('#data-table tr').each(function() {
        if(!$(this).find(".sizeCell").html()) {
            
        } else {
          var sizeCell = $(this).find(".sizeCell").html();
          var typeCell = $(this).find(".typeCell").html();
          var thicknessCell = $(this).find(".thicknessCell").html();
          var productCell = $(this).find(".productCell").html();
          var remainingCell = $(this).find(".remainingCell").html();
          var remainingCellWeight = $(this).find(".remainingCellWeight").html();

          if(parseInt(remainingCell)<0){
            alert("Not enough quantity to dispatch");
            isUpdate=false;
            return false;
          }
          sizeArr[i] = sizeCell;
          typeArr[i] = typeCell;
          thicknessArr[i] = thicknessCell;
          productArr[i] = productCell;
          remainingArr[i] = remainingCell;
          remainingWeightArr[i] = remainingCellWeight
          i++;
        }
        
    });
    if(isUpdate){
      $.ajax({
         type: 'post',
         url: 'updateStock.php',
         async: true,
         data: {
          sampleInvoiceId: sampleInvoiceId,
          refrenceNo: $("#REFRENCE_NUMBER").val(),
          count: i,
          sizeArr: sizeArr.toString(),
          typeArr: typeArr.toString(),
          thicknessArr: thicknessArr.toString(),
          productArr: productArr.toString(),
          remainingArr: remainingArr.toString(),
          remainingWeightArr: remainingWeightArr.toString()
         },
         success: function (response) {
             console.log(response);
             
             alert("Dispatch Successfull.\nYou can view the Invoice in View Invoice Page")
             window.location.href='view_invoice.php'; 
         },
         error: function(err) {
             console.log(err);
         }
      });
    } else {
      return false;
    }
    
    
    // alert("Dispatch Successfull.\nYou can view the Invoice in View Invoice Page")
    // window.location.href='sales_ppf.php'; 
    
    
}

$(document).ready(function() {
  $(".fa-bars").click();
  let userName = <?php echo "'".$_SESSION["admin"]."'"; ?>;
  if(userName == "admin") {
    // $("button[name='submit']").hide();
    // $("button[name='button']").hide();
  }
});

</script>

  </html>

