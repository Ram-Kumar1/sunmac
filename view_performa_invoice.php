<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));
$sql = "SELECT * FROM `sample_pi` P 
            WHERE 1 = 1 
            AND P.INVOICE_STATUS >= 0 
            AND P.DATE >= DATE('$date') - INTERVAL 20 DAY
            ORDER by 1 desc
        ";

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
                View Performa Invoice
              </header>
              <br>

              <?php
              if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
              ?>
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr style="color:#0c1211" ;>
                          <th style="color:#0c1211" ;>S. NO</th>
                          <th style="color:#0c1211" ;>Date</th>
                          <th style="color:#0c1211" ;>Customer Name</th>

                          <th class="max-30" style="color:#0c1211" ;>Followed By</th>
                          <th style="color:#0c1211" ;>Refrence No</th>
                          <th style="color:#0c1211; text-align: center;">View PDF</th>
                          <th style="color:#0c1211" ;>EDIT</th>
                        </tr>
                      </thead>
                      <?php
                      $i = 1;
                      while ($row = mysqli_fetch_array($result)) {

                      ?>
                        <tbody>
                          <tr>
                            <td>
                              <!-- <a href="productionTeamView.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
                                            <?php echo $i; ?>
                                        </a> -->
                              <?php echo $i; ?>
                            </td>
                            <td style="color:#0c1211" ;><?php echo $row['DATE']; ?></td>
                            <td style="color:#0c1211" ;><?php echo $row['CUSTOMER_NAME']; ?></td>
                            <td style="color:#0c1211" ;><?php echo $row['FOLLOWED_BY_PERSON']; ?></td>
                            <td class="max-30" style="color:#0c1211" ;>
                              <?php echo $row['REFERENCE_NO']; ?>

                            </td>

                            <td style="color:#0c1211; text-align: center;">
                              <button type="button" data-field="<?php echo $row['INVOICE_STATUS']; ?>" class="btn btn-default is-complete" onclick="updateDetails(<?php echo $row['SAMPLE_PI_ID']; ?>)">
                                <i class="material-icons" style="color: #0c1211;">remove_red_eye</i>
                              </button>
                            </td>
                            <td style="color:#0c1211" ;>
                              <a href="javascript:void(0)" class="delete-pi" data-custname="<?php echo $row['CUSTOMER_NAME']; ?>" data-refNo="<?php echo $row['REFERENCE_NO']; ?>" data-invoiceStatus="<?php echo $row['INVOICE_STATUS']; ?>" data-invoiceId="<?php echo $row["SAMPLE_PI_ID"]; ?>" onclick="deleteRec(this);">
                                <i class="material-icons delete-icon">create</i>
                              </a>
                            </td>

                          </tr>
                        </tbody>
                      <?php
                        ++$i;
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
  $(document).ready(function() {
    let userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
    console.log('userType: ' + userType);
    if (userType == "salesManager") {
      $('.delete-icon').bind('click', false);
      $(".delete-pi").css('cursor', "not-allowed");
      // $('.delete-icon').hide();
    }


  });

  var updateDetails = function(id) {
    var conform = confirm("Sure to create?");
    if (!conform) {
      return;
    }
    window.location.href = 'createPerformaInvoice.php?invoiceId=' + id;

  };

  var deleteRec = function(btn) {
    let invoiceStatus = $(btn).attr("data-invoicestatus");
    let samplePiId = $(btn).attr("data-invoiceid");
    let refrenceNo = $(btn).attr("data-refno");
    let custName = $(btn).attr('data-custname');
    if (parseInt(invoiceStatus) <= 3) {
      // 1. <=3 Show alert of the PPI Status
      let cnf = confirm("Sure to go!");
      if (cnf) {
        var insta = "";
        switch (invoiceStatus) {
          case "0":
            insta = "Sure to Delete?";
            break;
          case "1":
            insta = "Advance Amount received sure to delete?";
            break;
          case "2":
            insta = "Production done sure to delete?";
            break;
          case "3":
            insta = "Amount received and Production done sure to delete?";
            break;
        }
        let isDelete = confirm(insta);
        if (isDelete) {
          // 2. If alert is OK delete
          $.ajax({
            type: 'post',
            url: 'deleteSamplePi.php',
            data: {
              samplePiId: samplePiId,
              refrenceNo: refrenceNo,
              custName: custName,
              invoiceStatus: invoiceStatus
            },
            success: function(response) {
              console.log(response);
              window.location.href = "sales_quotation.php";
            }
          });
        }
      } else {
        return false;
      }
    } else {
      alert("Dispatched.\nCannot be deleted!");
      return false;
    }

  }
</script>

</html>