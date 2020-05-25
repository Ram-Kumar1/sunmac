<?php
session_start();
include 'db_connect.php';

$sql = "SELECT * FROM `purchase_details_bill` WHERE REMAINING_AMOUNT > 0 ORDER by PURCHASED_DATE desc";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>

<head>
    <title>OUTSTANDING PAYMENT</title>
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
                                Outstanding Payment
                            </header>

                            <div class="table-responsive max-height-30" style="width: 100%;">
                                <table class="table tableFixHead">
                                    <thead>
                                        <tr style="color:#0c1211" ;>
                                            <th style="color:#0c1211" ;>#</th>
                                            <th style="color:#0c1211" ;>Refrence No</th>
                                            <th style="color:#0c1211" ;>DATE</th>
                                            <th style="color:#0c1211" ;>NAME</th>
                                            <th style="color:#0c1211" ;>REMAINING AMOUNT</th>
                                            <th class="" style="color:#0c1211;">UPDATE</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tbody>
                                            <tr>
                                                <td style="color:#0c1211" ;><?php echo $i; ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['PURCHASE_BILL_NUMBER'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['PURCHASED_DATE'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['CUSTOMER_NAME'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['REMAINING_AMOUNT'] ?></td>

                                                <td style="color:#0c1211" ;>
                                                    <!-- <a href="javascript:edt_id('<?php echo $row["PURCHASE_DETAILS_BILL_ID"]; ?>')"> -->
                                                    <a href="javascript:void(0)" class="delete-pi" onclick="updateRec(<?php echo $row["PURCHASE_DETAILS_BILL_ID"]; ?>);">
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
                var updateRec = function(purchaseDetailId) {
                    window.location.href = 'updatePurchseAmount.php?purchaseDetailId=' + purchaseDetailId;

                };
            </script>

        </section>


    </section>

</body>

</html>