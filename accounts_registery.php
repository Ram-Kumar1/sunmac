<?php
session_start();
include 'db_connect.php';
if (isset($_GET['invoiceId']) & !empty($_GET['invoiceId'])) {

  $id = $_GET['invoiceId'];
  $sql = "SELECT TB.SAMPLE_PI_ID, S.REFERENCE_NO, S.CUSTOMER_NAME, S.MOBILE, TB.TOTAL_AMOUNT, TB.BALANCE 
            FROM sample_pi S, transaction_balance TB WHERE 1=1
            AND S.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
            AND TB.SAMPLE_PI_ID = " . $id;
  $select = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($select);
}

if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $pendingSql = "UPDATE `transaction_balance` SET IS_PENDING_AMOUNT=1 WHERE SAMPLE_PI_ID=" . $id;
  mysqli_query($conn, $pendingSql);
}

if (isset($_POST['submit'])) {

  $invoiceId = $_POST['INVOICE_ID'];
  $totalAmount = $_POST['totalAmount'];
  $advance = $_POST['advance'];
  $balance = $_POST['new-balance'];


  date_default_timezone_set('Asia/Kolkata');
  $date_1 =  date('d-m-Y H:i');
  $date = date('Y-m-d', strtotime($date_1));

  $updateBalance = "UPDATE transaction_balance SET BALANCE=" . $balance . ", LAST_UPDATE_DATE='" . $date . "' WHERE SAMPLE_PI_ID=" . $id;
  mysqli_query($conn, $updateBalance);

  $update = "INSERT INTO `transaction`(`SAMPLE_PI_ID`, `TOTAL_AMOUNT`, `PAID_AMOUNT`, `BALANCE`, `DATE`) VALUES 
        ($invoiceId,
        $totalAmount,
        $advance,
        $balance,
        '$date')";

  if (mysqli_query($conn, $update)) {
?>
    <script type="text/javascript">
      alert('Transaction completed successfully!');
      window.location.href = 'accounts.php';
    </script>
<?php
  } else {
    echo "Error: " . $update . "" . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>

<head>
  <title>Accounts</title>
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

<script type="text/javascript">
  var userType = null;
  var balance = <?php echo $row['BALANCE']; ?>
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
                ACCOUNTS UPDATE
              </header>
              <div class="panel-body">
                <div class="position-center">




                  <form action="" method="POST">
                    <script type="text/javascript">
                      function demo(val) {

                        if (val == 'sample_invoice' || val == 'drop') {
                          document.getElementById("panel").disabled = true;
                        } else {
                          document.getElementById("panel").disabled = false;
                        }


                      }
                    </script>
                    <div class="form-group">
                      <label for="sample_invoice_id">Refrence No:</label>
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
                      <label for="quotation_date">Total Amount</label>
                      <input type="text" class="form-control" id="totalAmount" name="totalAmount" value='<?php echo $row['TOTAL_AMOUNT'] ?>' required readonly>
                    </div>
                    <div class="form-group">
                      <label for="products">Existing Balance</label>
                      <input type="text" class="form-control" name="balance" id="balance" value='<?php echo $row['BALANCE'] ?>' readonly>
                    </div>
                    <div class="form-group">
                      <label for="products">Amount Paid</label>
                      <input type="number" class="form-control" name="advance" id="advance" value='' onchange="calcBalance(this)" onkeyup="calcBalance(this)">
                    </div>
                    <div class="form-group">
                      <label for="products">New Balance</label>
                      <input type="text" class="form-control" name="new-balance" id="new-balance" value='<?php echo $row['BALANCE']; ?>' readonly>
                    </div>

                    <div class="center" style="text-align: center;">
                      <button type="submit" name="submit" class="btn btn-default pull-right">
                        <i class="fa fa-money" aria-hidden="true" style="color: red"></i>
                        Update
                      </button>
                      <button type="button" name="move-to-pending" id="move-to-pending" onclick="moveToPending()" class="btn btn-warning pull-left">
                        <i class="fa fa-credit-card" aria-hidden="true" style="color: white"></i>
                        Credit
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
  var moveToPending = function() {
    var conform = confirm("Sure to move to Pending Accounts ?");
    if (!conform) {
      return;
    }

    $.ajax({
      type: 'post',
      url: 'accounts_registery.php',
      data: {
        id: $("#INVOICE_ID").val()
      },
      success: function(response) {
        console.log(response);
        alert("Successfully moved to Pending Accounts.")
        window.location.href = 'accounts_pending.php';
      },
      error: function(err) {
        console.log(err);
      }
    });
  };

  var calcBalance = function(input) {
    if ($("#move-to-pending").is(":visible")) {
      $("#move-to-pending").attr("disabled", true);
    }

    let val = $(input).val();
    try {
      val = parseFloat(val);
      let balance = parseFloat($("#balance").val()) - val;
      if (isNaN(balance)) {
        $("#new-balance").val($("#balance").val());
      } else {
        if (balance < 0) {
          alert("Amount Paid must be lesser than or equal to Balance...");
          $("#advance").val("0");
        } else {
          $("#new-balance").val(balance);
        }

      }

    } catch (err) {

    }
  }

  $(document).ready(function() {

    userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
    if (userType == "accountsManager") {
      $("#move-to-pending").hide();
    }
    if (balance == 0) {
      $("#advance").attr("disabled", true);
    }

    const urlParams = new URLSearchParams(window.location.search);
    const isPending = urlParams.get('isPending');
    if (isPending == 1) {
      $("#move-to-pending").hide();
    }
  });
</script>

</html>