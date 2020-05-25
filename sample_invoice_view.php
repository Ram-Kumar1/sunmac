<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));
$sql = "SELECT * FROM `sample_pi` where `INVOICE_STATUS`= 0 AND `DATE` >= DATE('$date') - INTERVAL 20 DAY ORDER BY 1 DESC";
//$result = mysqli_query($conn,$sql);

?>

  <!DOCTYPE html>
  <head>
  <title>Generate PPI</title>
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
                    Generate PPI
                    </header>
                    <br>
                    
<?php
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
                 <div class="table-responsive">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211; min-width: 8em;">S.NO</th>
                                    <th style="color:#0c1211; min-width: 8em;">DATE</th>
                                    <th style="color:#0c1211;">CUSTOMER NAME</th>
                                    <th style="color:#0c1211;">MOBILE</th>
                                    <th style="color:#0c1211;">REFERENCE NO</th>
                                    <th style="color:#0c1211;">AMOUNT</th>
                                    <th style="color:#0c1211; min-width: 8em;">Generate PPI</th>
                                </tr>
                             </thead>
<?php 
$i = 0;
while($row = mysqli_fetch_array($result)){
  $i++;
?>
                           <tbody>
                              <tr>
                                    <td style="color:#0c1211";><?php echo $i;?></td>
                                    <td style="color:#0c1211";><?php echo $row['DATE']?></td>
                                    <td style="color:#0c1211";><?php echo $row['CUSTOMER_NAME']?></td>       
                                    <td style="color:#0c1211";><?php echo $row['MOBILE']?></td>        
                                    <td style="color:#0c1211";><?php echo $row['REFERENCE_NO']?></td>
                                    <td style="color:#0c1211";><?php echo $row['TOTAL_AMOUNT']?></td>
                                    
                                    <td style="color:#0c1211";>
                                      <a href="sample_invoice_update.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                        <button type="button" class="btn btn-primary">
                                          <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                      </a>
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






