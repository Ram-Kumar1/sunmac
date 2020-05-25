<?php
session_start();
include 'db_connect.php';

$sql = "SELECT * FROM `sample_pi` where `INVOICE_STATUS`=1 OR `INVOICE_STATUS`=2 ORDER BY 1 DESC"; // 1 stands for PRODUCTION TEAM
//$result = mysqli_query($conn,$sql);

?>

  <!DOCTYPE html>
  <head>
  <title>Production View</title>
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
                           Production PPI
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
                                    <th style="color:#0c1211";>S.NO</th>
                                    <th style="color:#0c1211";>REFERENCE NO</th>
                                    <th style="color:#0c1211";>DATE</th>
                                    <th style="color:#0c1211";>CUSTOMER NAME</th>
                                    <th style="color:#0c1211";>MOBILE</th>
                                    <th class="max-30" style="color:#0c1211";>ADDRESS</th>
                                    <th style="color:#0c1211";>Status</th>
                                </tr>
                             </thead>
<?php 
$i = 0;
while($row = mysqli_fetch_array($result)){
  $i++;
?>
                           <tbody>
                              <tr>
                              <td style="color:#0c1211";><?php echo $i; ?></td>
                                    <td>
                                        <a href="productionTeamView.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                            <?php echo $row['REFERENCE_NO']?>
                                        </a>
                                    </td>
                                    <td style="color:#0c1211";><?php echo $row['DATE']?></td>
                                    <td style="color:#0c1211";><?php echo $row['CUSTOMER_NAME']?></td>       
                                    <td style="color:#0c1211";><?php echo $row['MOBILE']?></td>        
                                    <td class="max-30" style="color:#0c1211";><?php echo $row['TO_ADDRESS']?></td>
                                    
                                    <td style="color:#0c1211";>
                                      <button type="button" data-field="<?php echo $row['INVOICE_STATUS']?>" class="btn btn-default is-complete" onclick="updateDetails(<?php echo $row['SAMPLE_PI_ID']; ?>)">
                                          <i class="fa fa-check" style="color: mediumspringgreen;"></i>
                                        </button>
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

<script>
var updateDetails = function(id) {
    var conform = confirm("Sure to update the status?");
    if(!conform) {
        return;
    }

    $.ajax({
       type: 'post',
       url: 'updateProduction_SPI.php',
       data: {
        quotationId: id
       },
       success: function (response) {
           console.log(response);
           alert("Notification sent to Sales team.")
           window.location.href='productionTeam_SPI.php'; 
       },
       error: function(err) {
           console.log(err);
       }
    });
};

$('.is-complete').each(function() {
    var $this = $(this);
    var value = $this.attr("data-field").trim();
    if(value == "1") {
        $(this).children().removeClass("fa-check").addClass("fa-times red");
        // $this.addClass('red');
        $this.attr("disabled", true);
    } else {

    }
    console.log(value);
});


</script>

</html>






