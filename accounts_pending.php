<?php
session_start();
include 'db_connect.php';

$sql = "SELECT S.SAMPLE_PI_ID, S.CUSTOMER_NAME, S.MOBILE, S.DATE, S.REFERENCE_NO, (S.TOTAL_AMOUNT - S.GST_AMOUNT) AS PRODUCT_AMOUNT, S.TOTAL_AMOUNT, S.GST_AMOUNT, 
        (S.TOTAL_AMOUNT - TB.BALANCE) AS ADVANCE, TB.BALANCE, S.INVOICE_STATUS, T.TRANSACTION_ID 
        FROM sample_pi S, transaction T, transaction_balance TB WHERE 1=1 
        AND S.SAMPLE_PI_ID = T.SAMPLE_PI_ID 
        AND S.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
        AND T.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
        AND S.INVOICE_STATUS != 0 
        AND TB.IS_PENDING_AMOUNT = 1 
        AND TB.SHOW_TO_ACCOUNTS = 1 
        GROUP BY T.SAMPLE_PI_ID 
        ";
//$result = mysqli_query($conn,$sql);


?>

  <!DOCTYPE html>
  <head>
  <title>Production View</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
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
td.color-condition.red {
    color: red !important;
}

#report-table > tbody > tr:nth-child(1) {
  color: beige;
}

.bal-0 {
  color: limegreen !important;
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
                           PENDING ACCOUNTS
                    </header>
                    <br>
                    
<?php
if($result = mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S.No</th>
                                    <th style="color:#0c1211";>Ref.No</th>
                                    <th style="color:#0c1211";>Customer Name</th>
                                    <th style="color:#0c1211";>Mobile</th>
                                    <th style="color:#0c1211";>Date</th>
                                    <th style="color:#0c1211";>Product Amount</th>
                                    <th style="color:#0c1211";>GST Amt</th>
                                    <th style="color:#0c1211";>Total</th>
                                    <th style="color:#0c1211";>Advance</th>
                                    <th style="color:#0c1211";>Balance</th>
                                    <th style="color:#0c1211";>Status</th>
                                    <th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
$i = 0;
while($row = mysqli_fetch_array($result)){
  $i++;
?>
                           <tbody>
                              <tr id="sample-pi-id-<?php echo $row['SAMPLE_PI_ID']; ?>">
                                    <td style="color:#0c1211";>
                                          <?php echo $i;?>
                                    </td>
                                    <td>
                                      <a href="accounts_registery.php?isPending=1&invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                        <?php echo $row['REFERENCE_NO']?>
                                      </a>
                                    </td>
                                    <td style="color:#0c1211"; id="custName-<?php echo $row['SAMPLE_PI_ID']; ?>"><?php echo $row['CUSTOMER_NAME']?></td>
                                    <td style="color:#0c1211";><?php echo $row['MOBILE']?></td>       
                                    <td style="color:#0c1211";><?php echo $row['DATE']?></td>        
                                    <td style="color:#0c1211";><?php echo $row['PRODUCT_AMOUNT']?></td>
                                    <td style="color:#0c1211";><?php echo $row['GST_AMOUNT']?></td>
                                    <td style="color:#0c1211";><?php echo $row['TOTAL_AMOUNT']?></td>
                                    <td style="color:#0c1211";>
                                    <!-- href="#myModal" -->
                                      <a data-toggle="modal" class="transaction-info" id="transaction-<?php echo $row['SAMPLE_PI_ID']; ?>" href="">
                                        <?php echo $row['ADVANCE']?>
                                      </a>
                                    </td>
                                    <td style="color:#0c1211";><?php echo $row['BALANCE']?></td>
                                    <td style="color: limegreen;"; class="color-condition" data-balace=<?php echo $row['BALANCE']?>>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php echo $row['BALANCE'] != 0 ? "Pending" : "Settled"?>
                                    </td>
                                    <td>
                                      <span class="<?php echo "bal-".$row['BALANCE'];?>" data-spiId="<?php echo $row['SAMPLE_PI_ID']; ?>" onclick="deleteInvoice(this);">
                                        <i class="fa fa-times <?php echo "bal-".$row['BALANCE'];?>" style="color: red;" aria-hidden="true"></i>
                                      </span>
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

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Transaction Details</h4>
        </div>
        <div class="modal-body">
        <div class="row" style="width: 100%;">
          <table class="table table-striped" id='report-table'>

          </table>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
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
        id: id
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

var deleteInvoice = function(span) {
			if(!$(span).hasClass("bal-0")) {
				return false;
			} else {
				console.log("quotationId: ", span);
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						invoiceIdFromAccounts: $(span).attr("data-spiid")
					},
					success: function (response) {
						$("#sample-pi-id-"+$(span).attr("data-spiid")).hide();
					}
				});
			}
			
		};

var buildTable = function(sizeArray) {
    var columns = addAllColumnHeaders(sizeArray);
    for (var i = 0 ; i < sizeArray.length ; i++) {
        var row$ = $('<tr/>');
        for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
            var cellValue = sizeArray[i][columns[colIndex]];

            if (cellValue == null) { cellValue = ""; }

            row$.append($('<td/>').html(cellValue));
        }
        $("#report-table").append(row$);
    }
}
 
var addAllColumnHeaders = function(sizeArray) {
    var columnSet = [];
    var headerTr$ = $('<tr/>');

    for (var i = 0 ; i < sizeArray.length ; i++) {
        var rowHash = sizeArray[i];
        for (var key in rowHash) {
            if ($.inArray(key, columnSet) == -1){
                columnSet.push(key);
                headerTr$.append($('<th/>').html(key));
            }
        }
    }
    
    $("#report-table").append(headerTr$);
    return columnSet;
};

$(document).ready(function() {
  $(".fa-bars").click();
      $('.transaction-info').click(function(){
      var id = this.id;
      var splitid = id.split('-');
      var userid = splitid[1];

      // AJAX request
      $.ajax({
        url: 'account_transaction.php',
        type: 'post',
        data: {userid: userid},
        success: function(response){ 
          // Add response in Modal body
          $("#modal-title").html('');
          $("#report-table tr").detach();
          let res = JSON.parse(response);
          $("#modal-title").html($("#custName-"+res[1]).text());
          console.log(res[1]);
          buildTable(res[0]);

          // Display Modal
          $('#myModal').modal('show'); 
        }
      });
    });

    $('.color-condition').each(function() {
        var $this = $(this);
        var value = $this.text().trim();
        if(value == "Pending") {
            $(this).children().removeClass("fa-check").addClass("fa-times");
            $this.addClass('red');
        } else {

        }
        console.log(value);
    });
});


</script>

</html>