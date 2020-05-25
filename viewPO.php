<?php
session_start();
include 'db_connect.php';

$sql = "SELECT * FROM `sample_po`";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>

<head>
    <title>View PO</title>
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
<script>
    var id = 0;
    var userType = "";
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
                                View PO
                            </header>

                            <div class="table-responsive max-height-30">
                                <table class="table tableFixHead">
                                    <thead>
                                        <tr style="color:#0c1211" ;>
                                            <th style="color:#0c1211" ;>S.NO</th>
                                            <th style="color:#0c1211" ;>DATE</th>
                                            <th style="color:#0c1211" ;>PO NO</th>
                                            <th style="color:#0c1211" ;>CUSTOMER NAME</th>
                                            <th style="color:#0c1211" ;>MOBILE NUMBER</th>
                                            <th class="max-30" style="color:#0c1211" ;>ADDRESS</th>
                                            <th style="color:#0c1211" ;>PDF</th>
                                            <th style="color:#0c1211" ;>DELETE</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tbody>
                                            <tr>
                                                <td style="color:#0c1211" ;><?php echo $i; ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['DATE'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['REFERENCE_NO'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['CUSTOMER_NAME'] ?></td>
                                                <td style="color:#0c1211" ;><?php echo $row['MOBILE'] ?></td>
                                                <td class="max-30" style="color:#0c1211" ;><?php echo $row['ADDRESS'] ?></td>
                                                <td style="color:#0c1211" ;>
                                                    <!-- <a href="javascript:edt_id('<?php echo $row["SAMPLE_PO_ID"]; ?>')"> -->
                                                    <a href="javascript:void(0)')" onclick="openPDF(<?php echo $row["SAMPLE_PO_ID"]; ?>);">
                                                        <i class="material-icons">remove_red_eye</i>
                                                    </a>
                                                </td>
                                                <td style="color:#0c1211" ;>
                                                    <!-- <a href="javascript:edt_id('<?php echo $row["SAMPLE_PO_ID"]; ?>')"> -->
                                                    <a class="delete-icon" href="javascript:void(0)')" onclick="deleteRecord(<?php echo $row["SAMPLE_PO_ID"]; ?>);">
                                                        <i class="material-icons delete-po">delete_outline</i>
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
                var openPDF = function(id1) {
                    id = id1;
                    <?php $_SESSION["currentQuotationId"] = "<script>document.write(id);</script>"; ?>
                    window.open('sunmac_po_save.php?invoiceId=' + id1);
                }

                var deleteRecord = function(id) {
                    if(userType == "admin") {
                        let cfm = confirm("Sure to delete");
                        if (cfm) {
                            $.ajax({
                                type: 'post',
                                url: 'deletePO.php',
                                data: {
                                    id: id
                                },
                                success: function(response) {
                                    alert("Record Deleted Successfully!");
                                    location.reload();
                                }
                            });
                        }
                    }
                    
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
                userType = <?php echo "'" . $_SESSION['admin'] . "'"; ?>;
                console.log('userType: ' + userType);
                if (userType != "admin") {
                    // $('.delete-icon').unbind('click', true);
                    $('.delete-icon').click(function () {return false;});
                    $(".delete-po").css('cursor', "not-allowed");
                    // $('.delete-icon').hide();
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