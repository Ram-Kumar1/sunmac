<?php
session_start();
include 'db_connect.php';

// echo $sql = "SELECT * FROM `transaction_balance` T, `sample_pi` P WHERE 1 = 1 AND T.SAMPLE_PI_ID = P.`SAMPLE_PI_ID` AND P.INVOICE_STATUS = 3 AND (T.BALANCE = 0 OR T.SHOW_IN_ACCOUNTS = 1"; // 1 stands for PRODUCTION TEAM
$sql = "SELECT * FROM `sample_pi` P WHERE 1 = 1 AND P.INVOICE_STATUS = 3 ORDER BY 1 DESC";

//$result = mysqli_query($conn,$sql);

?>

  <!DOCTYPE html>
  <head>
  <title>Production View</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
.red {
    color: red !important;
}

.max-30 {
    max-width: 15em;
}
</style>

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
                           Finished Products
                    </header>
                    <br>
                    
<?php
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
                 <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S. NO</th>
                                    <th style="color:#0c1211";>Date</th>
                                    <th style="color:#0c1211";>Customer Name</th>
                                    <th class="max-30" style="color:#0c1211";>Followed By</th>
                                    <th style="color:#0c1211";>Refrence No</th>
                                    <!-- <th style="color:#0c1211; text-align: center;">Create Invoice</th> -->
                                </tr>
                             </thead>
<?php 
$i = 1;
while($row = mysqli_fetch_array($result)) {
  
?>
                           <tbody>
                              <tr>
                                    <td style="color:#0c1211";>
                                        <!-- <a href="productionTeamView.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                            <?php echo $i; ?>
                                        </a> -->
                                        <?php echo $i; ?>
                                    </td>
                                    <td style="color:#0c1211";><?php echo $row['DATE']; ?></td>
                                    <td style="color:#0c1211";><?php echo $row['CUSTOMER_NAME']; ?></td>       
                                    <td style="color:#0c1211";><?php echo $row['FOLLOWED_BY_PERSON']; ?></td>        
                                    <td class="max-30" style="color:#0c1211";>
                                      
                                      <a href="productionDispatch.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                      <?php echo $row['REFERENCE_NO']; ?>
                                        </a>
                                    </td>
                                    
                                    <!-- <td style="color:#0c1211; text-align: center;">
                                      <button type="button" data-field="<?php echo $row['INVOICE_STATUS']; ?>" class="btn btn-default is-complete" onclick="updateDetails(<?php echo $row['SAMPLE_PI_ID']; ?>)">
                                          <i class="fa fa-check" style="color: mediumspringgreen;"></i> 
                                          <i class="material-icons" style="color: springgreen;">create</i>
                                        </button>
                                    </td> -->


                               </tr>
                            </tbody>
 <?php
 ++$i;
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

<script>
var updateDetails = function(id) {
    var conform = confirm("Sure to create?");
    if(!conform) {
        return;
    }
    //window.location.href='createPPF.php?id='+id; 
    
};

</script>

</html>






