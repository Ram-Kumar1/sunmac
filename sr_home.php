<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>

<head>
    <title>Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>
<script src="https://cdn.rawgit.com/mkoryak/floatThead/master/dist/jquery.floatThead.min.js"></script>
<?php
include './demo.css';
?>
<?php
include './demo.js';
?>
<style type="text/css">
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<body>
    <?php include 'header.php'; ?>

    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Report
                            </header>
                            <div class="panel-body">
                                <div>
                                    <div class="row position-center" style="width: 100%;">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="sel1">Select Report Type:</label>
                                                <select class="form-control" id="reports" onchange="reportSelectBoxChange(this)">
                                                    <option value="">-- SELECT REPORT TYPE --</option>
                                                    <option value="salesProdStock">Count - Sales Vs Production Vs Stock</option>
                                                    <option value="salesProdStockWeight">Weight - Sales Vs Production Vs Stock</option>
                                                    <option value="dispatchReport">Dispatch Report</option>
                                                    <option value="salesProdCount">Count - Total Sales Vs Production</option>
                                                    <option value="salesProdWeight">Weight - Total Sales Vs Production</option>
                                                    <!-- <option value="salesVsPurchase">Sales Vs Purchase Report</option>
                                                    <option value="scrap">Weight</option> -->
                                                    <option value="quotation">Quotation</option>
                                                    <option value="performaInvoice">Performa Invoice</option>
                                                    <option value="invoice">Invoice</option>
                                                </select>
                                            </div>
                                            <div id="from-to-date-div" style="display: none;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="usr">From Date:</label>
                                                        <input type="date" class="form-control" id="from-date-input">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="usr">To Date:</label>
                                                        <input type="date" class="form-control" id="to-date-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="type-div" style="display: none;">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="sel1">TYPE</label>
                                                        <select class="form-control" id="productTypeSelect">
                                                            <option value="">-- SELECT TYPE --</option>
                                                            <?php
                                                            $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                                                            $result = mysqli_query($conn, $sqlSelect);
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                                    <option value="<?php echo $row['type_name'] ?>"><?php echo $row['type_name'] ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </br></br>
                                        <button type="submit" class="btn btn-info" name="submit" onclick="showReport()" style="margin-left: 45%;">Show Report</button>

                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script>
        var reportSelectBoxChange = function(select) {
            let selectedVal = $("#reports").val();
            if (selectedVal == "salesProdStock" || selectedVal == "salesProdStockWeight" || selectedVal == "scrap") {
                $("#from-to-date-div").show();
                $("#type-div").show();
            } else if (selectedVal == "dispatchReport" 
                        || selectedVal == "salesProdCount" 
                        || selectedVal == "salesProdWeight" 
                        || selectedVal == "salesVsPurchase"
                        || selectedVal == "quotation"
                        || selectedVal == "performaInvoice"
                        || selectedVal == "invoice"
                    ) {
                $("#from-to-date-div").show();
                $("#type-div").hide();
            }
        };

        var validate = function(fromDate, toDate, type, isValidateType) {
            if (isValidateType && (fromDate == undefined || fromDate == null || fromDate == "")) {
                alert("Fromdate is mandatory!");
                return false;
            }
            if (isValidateType && (toDate == undefined || toDate == null || toDate == "")) {
                alert("Todate is mandatory!");
                return false;
            }
            if (isValidateType && (type == undefined || type == null || type == "")) {
                alert("Type is mandatory!");
                return false;
            }
            return true;
        };

        var showReport = function() {
            let selectedVal = $("#reports").val();
            let fromDate = $("#from-date-input").val();
            let toDate = $("#to-date-input").val();
            switch (selectedVal) {
                case "salesProdStock": {
                    let type = $("#productTypeSelect").val();
                    let canShowReport = validate(fromDate, toDate, type, true);
                    if (canShowReport) {
                        window.location.replace("sr_salesProdStockReport.php?fromDate=" + fromDate + "&toDate=" + toDate + "&type=" + type);
                    } else {
                        break;
                    }
                    break;
                }
                case "salesProdStockWeight": {
                    let type = $("#productTypeSelect").val();
                    let canShowReport = validate(fromDate, toDate, type, true);
                    if (canShowReport) {
                        window.location.replace("sr_salesProdStockReportWeight.php?fromDate=" + fromDate + "&toDate=" + toDate + "&type=" + type);
                    } else {
                        break;
                    }
                    break;
                }
                case "dispatchReport": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_dispatchReport.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;

                }
                case "salesProdCount": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_salesProdCount.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }
                case "salesProdWeight": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_salesProdWeight.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }
                case "salesVsPurchase": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_salesVsProdReport.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }
                case "scrap": {
                    let type = $("#productTypeSelect").val();
                    let canShowReport = validate(fromDate, toDate, type, true);
                    if (canShowReport) {
                        window.location.replace("sr_weightReport.php?fromDate=" + fromDate + "&toDate=" + toDate + "&type=" + type);
                    } else {
                        break;
                    }
                    break;
                }
                case "quotation": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_quotation.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }
                case "performaInvoice": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_performaInvoice.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }
                case "invoice": {
                    let canShowReport = validate(fromDate, toDate, undefined, false);
                    if (canShowReport) {
                        window.location.replace("sr_invoice.php?fromDate=" + fromDate + "&toDate=" + toDate);
                    } else {
                        break;
                    }
                    break;
                }

            } //EOSwitch
        };
    </script>
</body>

</html>