<?php
session_start();
include 'db_connect.php';

$sql = "SELECT Q.QUOTATION_ID, Q.Q_DATE, C.S_NAME, C.S_MOBILE, C.S_ADDRESS, C.S_CITY, C.S_STATE FROM `quotation_followup` Q, sales_customer C WHERE 1 = 1 AND Q.Q_STATUS = '0' AND Q.CUSTOMER_ID = C.S_ID";
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
                       Quotation FollowUp 
                    </header>
                  
                      <div class="table-responsive max-height-30">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                  <th style="color:#0c1211";>S. NO</th>
                                  <th style="color:#0c1211; min-width: 8em;">DATE</th>
                                  <th style="color:#0c1211";>CUSTOMER NAME</th>
                                  <th style="color:#0c1211";>MOBILE NUMBER</th>
                                  <th style="color:#0c1211";>ADDRESS</th> 
                                  <th style="color:#0c1211";>UPDATE</th>
                                  <th style="color:#0c1211";>DELETE</th>  
                                </tr>
                             </thead>
                           <?php 
                           $i = 1;
                           while($row = mysqli_fetch_array($result)){
                           ?>
                           <tbody>
                              <tr>
                                   <td style="color:#0c1211";><?php echo $i; ?></td> 
                                   <td style="color:#0c1211; min-width: 8em;"><?php echo $row['Q_DATE']?></td>
                                   <td style="color:#0c1211";><?php echo $row['S_NAME']?></td>
                                   <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
                                   <td style="color:#0c1211";><?php echo $row['S_ADDRESS'].$row['S_CITY']?></td>
                                   <td style="color:#0c1211";><a href="javascript:edt_id('<?php echo $row["QUOTATION_ID"]; ?>')"><i class="material-icons">update</i></a></td>
                                   <td style="color:#0c1211";><a class="delete-pi delete-icon" href="javascript:deleteId('<?php echo $row["QUOTATION_ID"]; ?>')"><i class="material-icons">delete</i></a></td>

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

$(document).ready(function() {
        $(".fa-bars").click();
        let userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
        console.log('userType: ' + userType);
        let canView = ["admin", "generalManager"];
        if (canView.indexOf(userType) == -1) {
          $('.delete-icon').bind('click', false);
          $(".delete-pi").css('cursor', "not-allowed");
          // $('.delete-icon').hide();
        }

        if(userType != "admin") {
          $("#delete-old").hide();
        }


      });

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
        window.location.href='sunmac_quatation.php?quotationId='+id;
    }
}

function deleteId(id, isFromRemainderTable) {
    if (confirm('Sure to GO ?')) {
      $.ajax({
        type: 'post',
        url: 'followupDelete.php',
        data: {
          id: id
          // isFromRemainderTable: isFromRemainderTable
        },
        success: function(response) {
          window.location.href = 'sales_quotation.php';
        }
      });
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