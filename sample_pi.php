<?php
session_start();
include 'db_connect.php';

$sql = "SELECT Q.QUOTATION_ID, Q.REFERENCE_NO, Q.Q_DATE, Q.CUSTOMER_NAME, Q.CUSTOMER_MOBILE, Q.CUSTOMER_ADDRESS FROM `quotation` Q WHERE 1 = 1 AND Q.Q_STATUS = '1' ORDER BY 1 DESC";
$result = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<head>
<title>QUOTATION</title>
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
<link href="sunmac.css" rel='stylesheet' type='text/css' />
</head>

<style>



.max-30 {
    max-width: 15em;
}
</style>

<body>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<section id="main-content">
  <section class="wrapper">
       <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                       Performa Invoice
                    </header>
                  
                      <div class="table-responsive max-height-30">
                            <table class="table tableFixHead">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S.NO</th>
                                    <th style="color:#0c1211";>DATE</th>
                                    <th style="color:#0c1211";>REFERENCE NO</th>
                                    <th style="color:#0c1211";>CUSTOMER NAME</th>
                                    <th style="color:#0c1211";>MOBILE NUMBER</th>
                                    <th class="max-30" style="color:#0c1211";>ADDRESS</th> 
                                    <th style="color:#0c1211";>CREATE</th>  
                                </tr>
                             </thead>
                           <?php 
                           $i = 1;
                           while($row = mysqli_fetch_array($result)){
                           ?>
                           <tbody>
                              <tr>
                                   <td style="color:#0c1211";><?php echo $i; ?></td>            
                                   <td style="color:#0c1211";><?php echo $row['Q_DATE']?></td>
                                   <td style="color:#0c1211";><?php echo $row['REFERENCE_NO']?></td>
                                   <td style="color:#0c1211";><?php echo $row['CUSTOMER_NAME']?></td>
                                   <td style="color:#0c1211";><?php echo $row['CUSTOMER_MOBILE']?></td>
                                   <td class="max-30" style="color:#0c1211";><?php echo $row['CUSTOMER_ADDRESS']?></td>
                                   <td style="color:#0c1211";><a href="javascript:edt_id('<?php echo $row["QUOTATION_ID"]; ?>')"><i class="material-icons">create</i></a></td>

                               </tr>
                            </tbody>

                      <?php
                      $i++;
                      }
                      ?>

                            </table>                    
                            <br>

      </div>
    </section>
  </div>
</div>
</div>

<script>

var updateQuotationStatusInDB = function(id) {
    $.ajax({
       type: 'post',
       url: 'sales_quatation.php',
       data: {
          quotationId:id
       },
       success: function (response) {
        alert(); 
       }
    });
};

function edt_id(id)
{
    if(confirm('Sure to GO ?'))
    {
        updateQuotationStatusInDB(id);
        window.location.href='sunmac_sample_invoice.php?quotationId='+id;
    }
}

</script>

</section>

<script type="text/javascript">

function state(val)
{
 $.ajax({
 type: 'post',
 url: 'fetch_data.php',
 data: {
  state:val
 },
 success: function (response) {
  document.getElementById("city").innerHTML=response; 
 }
 });
}
</script>


</section>

</body>
</html>