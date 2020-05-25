<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));
$sql = "SELECT count(*) AS CNT 
          FROM quotation Q
          WHERE 1=1
          AND Q.Q_DATE >= '$date' - INTERVAL 20 DAY
        ";
$result = mysqli_query($conn, $sql);
$cnt = 0;
while ($row = mysqli_fetch_array($result)) {
  $cnt = $row['CNT'];
}

$sql = "SELECT Q.QUOTATION_ID, Q.REFERENCE_NO, Q.Q_DATE, Q.CUSTOMER_NAME, Q.CUSTOMER_MOBILE, Q.CUSTOMER_ADDRESS FROM `quotation` Q WHERE Q.Q_DATE >= '$date' - INTERVAL 20 DAY ORDER by 1 desc";
$result = mysqli_query($conn, $sql);

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

  .delete-icon-custom {
    font-size: 35px !important;
    margin-top: 15px;
  }

  .tableFixHead {
    overflow-y: auto !important; 
    max-height: 500px !important;
  }
</style>
<script>
  var id = 0;
</script>

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
                Quotation
                <a href="javascript:void(0)" id="delete-old" class="delete-pi pull-right" onclick="deleteOldRec(<?php echo $cnt; ?>);">
                  <i class="material-icons delete-icon delete-icon-custom" style="display: none;">restore_from_trash</i>
                </a>
              </header>

              <div class="table-responsive max-height-30" style="width: 100%;">
                <table class="table tableFixHead">
                  <thead>
                    <tr style="color:#0c1211" ;>
                      <th style="color:#0c1211" ;>#</th>
                      <th style="color:#0c1211" ;>Refrence No</th>
                      <th style="color:#0c1211" ;>DATE</th>
                      <th style="color:#0c1211" ;>NAME</th>
                      <th style="color:#0c1211" ;>MOBILE</th>
                      <th class="max-30" style="color:#0c1211" ;>ADDRESS</th>
                      <th style="color:#0c1211" ;>PDF</th>
                      <th class="" style="color:#0c1211;">EDIT</th>
                    </tr>
                  </thead>
                  <?php
                  $i = 1;
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                    <tbody>
                      <tr>
                        <td style="color:#0c1211" ;><?php echo $i; ?></td>
                        <td style="color:#0c1211" ;><?php echo $row['REFERENCE_NO'] ?></td>
                        <td style="color:#0c1211" ;><?php echo $row['Q_DATE'] ?></td>
                        <td style="color:#0c1211" ;><?php echo $row['CUSTOMER_NAME'] ?></td>
                        <td style="color:#0c1211" ;><?php echo $row['CUSTOMER_MOBILE'] ?></td>
                        <td class="max-30" style="color:#0c1211" ;><?php echo $row['CUSTOMER_ADDRESS'] ?></td>
                        <td style="color:#0c1211" ;>
                          <!-- <a href="javascript:edt_id('<?php echo $row["QUOTATION_ID"]; ?>')"> -->
                          <a href="javascript:void(0)" onclick="openPDF(<?php echo $row["QUOTATION_ID"]; ?>);">
                            <i class="material-icons">remove_red_eye</i>
                          </a>
                        </td>

                        <td style="color:#0c1211" ;>
                          <!-- <a href="javascript:edt_id('<?php echo $row["QUOTATION_ID"]; ?>')"> -->
                          <a href="javascript:void(0)" class="delete-pi" onclick="deleteRec(<?php echo $row["QUOTATION_ID"]; ?>);">
                            <i class="material-icons delete-icon">create</i>
                          </a>
                        </td>

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
        var deleteOldRec = function(cnt) {
          if(cnt == 0) {
            // Nothing
          } else {
            let cnf = confirm(cnt + " records will be deleted. Sure to delete!");
            if(cnf) {
              $.ajax({
                type: 'post',
                url: 'deleteqtn.php',
                data: {
                  isDeleteOldQuotation: 1
                },
                success: function(response) {
                  alert("Delete Success!");
                  window.location.href = "viewQuotationPDF.php";
                }
              });
            } else {
              return false;
            }
          }
          
        };

        var deleteRec = function(quotationId) {
          $.ajax({
            type: 'post',
            url: 'deleteqtn.php',
            data: {
              quotationId: quotationId
            },
            success: function(response) {
              // debugger;
              window.location.href = "sales_quotation.php";
            }
          });
        };

        var openPDF = function(id1) {
          id = id1;
          <?php $_SESSION["currentQuotationId"] = "<script>document.write(id);</script>"; ?>
          window.open('sunmac_quatation_save.php?quotationId=' + id1, '_blank');
        }

        var updateQuotationStatusInDB = function(id) {
          $.ajax({
            type: 'post',
            url: 'sales_quatation.php',
            data: {
              quotationId: id
            },
            success: function(response) {
              alert();
            }
          });
        };

        function edt_id(id) {
          if (confirm('Sure to GO ?')) {
            updateQuotationStatusInDB(id);
            window.location.href = 'sunmac_sample_invoice.php?quotationId=' + id;
          }
        }
      </script>

    </section>

    <script type="text/javascript">
      $(document).ready(function() {
        $(".fa-bars").click();
        let userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
        console.log('userType: ' + userType);
        if (userType == "salesManager") {
          $('.delete-icon').bind('click', false);
          $(".delete-pi").css('cursor', "not-allowed");
          // $('.delete-icon').hide();
        }

        if(userType != "admin") {
          $("#delete-old").hide();
        }


      });

      function state(val) {
        $.ajax({
          type: 'post',
          url: 'fetch_data.php',
          data: {
            state: val
          },
          success: function(response) {
            document.getElementById("city").innerHTML = response;
          }
        });
      }
    </script>


  </section>

</body>

</html>