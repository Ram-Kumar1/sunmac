<?php
session_start();
include 'db_connect.php';
if(isset($_GET['invoiceId']) & !empty($_GET['invoiceId'])) {
        
  $id = $_GET['invoiceId'];  
  $select=mysqli_query($conn,"SELECT * FROM `sample_pi` where SAMPLE_PI_ID=".$id);
  $row=mysqli_fetch_array($select);

  $sql = "SELECT * FROM `sample_pi_details` WHERE `SAMPLE_PI_ID` = ".$id;
}
?>
<script>
var sampleInvoiceId = <?php echo $id; ?>;
</script>

  <!DOCTYPE html>
  <head>
  <title>Production PPI</title>
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
  <script>
    var invoiceStatus = <?php echo $row['INVOICE_STATUS']; ?>
  </script>  
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
                          <div class="position-center">


    
    
    <form action="" method="POST">
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
        <label for="sample_invoice_id">Refrence No</label>
        <input type="text" class="form-control" name="REFRENCE_NO" id="REFRENCE_NO" value='<?php echo $row['REFERENCE_NO'] ?>' readonly>
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
      <table class="table table-striped table-hover">
        <thead>
            <tr style="color:#0c1211";>
                <th style="color:#0c1211";>Size</th>
                <th style="color:#0c1211";>Finishing</th>
                <th style="color:#0c1211";>Type</th>
                <th style="color:#0c1211";>Thickness</th>
                <th style="color:#0c1211";>Product</th>
                <th style="color:#0c1211";>Quantity</th>
            </tr>
        </thead>
        <?php 
            while($row = mysqli_fetch_array($result)){
        ?>
        <tbody>
            <tr>
                <td style="color:#0c1211";><?php echo $row['SIZE']?></td>
                <td style="color:#0c1211";><?php echo $row['FINISHING']?></td>       
                <td style="color:#0c1211";><?php echo $row['TYPE']?></td>
                <td style="color:#0c1211";><?php echo $row['THICKNESS']?></td>        
                <td style="color:#0c1211";><?php echo $row['PRODUCT']?></td>
                <td style="color:#0c1211";><?php echo $row['QUANTITY']?></td>
                
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
        <button type="button" name="button" class="btn btn-default pull-left" onclick="location.href = 'productionTeam_SPI.php';">
          <i class="fa fa-backward" aria-hidden="true" style="color: black"></i>
          Back
        </button>
        <button type="submit" name="submit" onclick="updateDetails()" class="btn btn-default pull-right">
          <i class="fa fa-check" aria-hidden="true" style="color: mediumspringgreen"></i>
          Complete
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
var updateDetails = function() {
    var conform = confirm("Sure to update the status?");
    if(!conform) {
        return;
    } else {
      $(':input[type="submit"]').prop('disabled', true);
      $.ajax({
        type: 'post',
        url: 'updateProduction_SPI.php',
        data: {
          id: sampleInvoiceId
        },
        success: function (response) {
            //  console.log(response);
            //  alert("Update Successfull.")
            //  window.location.href='productionTeam_SPI.php'; 
        },
        error: function(err) {
            console.log(err);
        }
      });
      setTimeout(function() {
        alert("Update Successfull.")
        window.location.href='productionTeam_SPI.php';  
      }, 100);
    }
 
}

$(document).ready(function() {
  let userName = <?php echo "'".$_SESSION["admin"]."'"; ?>;
  if(userName == "admin") {
    // $("button[name='submit']").hide();
    // $("button[name='button']").hide();
  }
  if(invoiceStatus > 1) {
    $(':input[type="submit"]').prop('disabled', true);
  }
});

</script>

  </html>

