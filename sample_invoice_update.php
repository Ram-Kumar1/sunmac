<?php
session_start();
include 'db_connect.php';
if(isset($_GET['invoiceId']) & !empty($_GET['invoiceId'])) {
        
  $id = $_GET['invoiceId'];  
  $select=mysqli_query($conn,"SELECT * FROM `sample_pi` where SAMPLE_PI_ID=".$id);
  $row=mysqli_fetch_array($select);
}


if(isset($_POST['submit'])){

        $invoiceId = $_POST['INVOICE_ID'];
        $totalAmount = $_POST['totalAmount'];
        $advance = $_POST['advance'];
        $balance = $_POST['balance'];
		 date_default_timezone_set('Asia/Kolkata');
		 $date_1 =  date('d-m-Y H:i');
		 $date = date('Y-m-d', strtotime($date_1));
 
        $query = "UPDATE `sample_pi` SET `INVOICE_STATUS`= 1 WHERE `SAMPLE_PI_ID` = ".$invoiceId;
        mysqli_query($conn,$query);

        $updateBalance = "INSERT INTO `transaction_balance`(`SAMPLE_PI_ID`, `TOTAL_AMOUNT`, `BALANCE`, `LAST_UPDATE_DATE`) 
        VALUES (
          $invoiceId,
          $totalAmount,
          $balance,
          '$date'
        )";
        //TODO:
        mysqli_query($conn,$updateBalance);

        $update="INSERT INTO `transaction`(`SAMPLE_PI_ID`, `TOTAL_AMOUNT`, `PAID_AMOUNT`, `BALANCE`, `DATE`) VALUES 
        ($invoiceId,
        $totalAmount,
        $advance,
        $balance,
        '$date')";
           
             if (mysqli_query($conn,$update)) {
                  ?>
         <script type="text/javascript">
          alert('Notification sent to Sales & Account Team and ADMIN!');
          window.location.href='sample_invoice_view.php';
        </script>         
          <?php
              } else {
                 echo "Error: " . $update . "" . mysqli_error($conn);
              }
             
           }
        ?>

  <!DOCTYPE html>
  <head>
  <title>Generate PPI</title>
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
                          SAMPLE INVOICE UPDATE  
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


    
    
    <form action="" id="main-form" method="POST">
        <script type="text/javascript">
          function demo(val){

            if(val == 'sample_invoice' || val == 'drop'){
             document.getElementById("panel").disabled = true;
            } else{
             document.getElementById("panel").disabled = false;
            }


          }
        </script>
        <div class="form-group">
        <label for="sample_invoice_id">Reference Number</label>
        <input type="text" class="form-control" name="REF_NO" id="REF_NO" value='<?php echo $row['REFERENCE_NO'] ?>' required readonly>
      </div>
       <div class="form-group">
        <label for="sample_invoice_id">Sample Invoice Id</label>
        <input type="number" class="form-control" name="INVOICE_ID" id="INVOICE_ID" value='<?php echo $row['SAMPLE_PI_ID'] ?>' required readonly>
      </div>  
      <div class="form-group">
        <label for="quotation_id">Customer Name</label>
        <input type="text" class="form-control" name="QUOTATION_ID" value='<?php echo $row['CUSTOMER_NAME'] ?>' required readonly>
      </div>
      <div class="form-group">
        <label for="quotation_date">Total amount</label>
        <input type="text" class="form-control" id="totalAmount" name="totalAmount" value='<?php echo $row['TOTAL_AMOUNT'] ?>' required readonly>
      </div>
      <div class="form-group">
        <label for="products">Advance</label>
        <input type="number" class="form-control" name="advance" id="advance" value='' onchange="calcBalance(this)" onkeyup="calcBalance(this)">
      </div>
      <div class="form-group">
        <label for="products">Balance</label>
        <input type="text" class="form-control" name="balance" id="balance" readonly>
      </div>
      
      <div class="center" style="text-align: center;">
        <button type="submit" name="submit" class="btn btn-default">
          <i class="fa fa-money" aria-hidden="true" style="color: red"></i>
          Update
        </button> 
      </div> 
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
<script>
$('#main-form').on('submit', function () {
    if($('#advance').val() == ""){
        alert("Kindly enter the Advance amount!");
        return false;
    } else {
        return true;
    }
});


var calcBalance = function(input) {
  let val = $(input).val();
  try {
    val = parseFloat(val);
    let balance = parseFloat($("#totalAmount").val()) - val;
    if(isNaN(balance)) {
      $("#balance").val($("#totalAmount").val());
    } else if(balance < 0) {
      $("#advance").val('');
      $("#balance").val($("#totalAmount").val());
      alert("Advance Amount must be greater than or equal to Total Amount");
    } else {
      $("#balance").val(balance);
    }
    
  } catch(err) {

  }
}


</script>

  </html>

