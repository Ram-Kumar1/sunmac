<?php
session_start();
include 'db_connect.php';

$availableWeight = 0;
$wgt = "SELECT * FROM `available_weight`";
$res = mysqli_query($conn, $wgt);
while ($row = mysqli_fetch_array($res)) {
    $availableWeight = $row['total'];
}
?>

<!DOCTYPE html>

<head>
    <title>Current Steel Stock</title>
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
    /* FOR TABLE FIXED HEADER */
    .tableFixHead {
        overflow-y: auto;
        max-height: 400px;
    }

    .tableFixHead table {
        border-collapse: collapse;
        width: 100%;
    }

    .tableFixHead th,
    .tableFixHead td {
        padding: 8px 16px;
    }

    .tableFixHead th {
        position: sticky;
        top: 0;
    }
    /* ENDS HERE */
    
    th {
        color: #0c1211 !important;
        background: #428bca !important;
    }

    td {
        color: black !important;
    }

    .pad25 {
        padding-left: 25%;
        padding-right: 25%;
    }

    .pad1EM {
        margin: 1em;
    }

    .table-25 {
        max-height: 20em;
        overflow-y: auto;
    }
</style>
<script src="jquery.table.marge.js"></script>

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
                                Current Steel Stock
                            </header>
                            <br>
                            <div class="pad25" style="clear: both">
                                <h5 style="float: left;">Current Steel Stock <span id="available-stock" class="badge badge-success">0</span></h5>
                                <h5 style="text-align: center;">Product Stock <span id="production-stock" class="badge badge-primary">0</span></h5>
                            </div>
                            <br><br>
                            <div class="pad25" style="clear: both">
                                <h5 style="float: right;">Scrap <span id="scrap-stock" class="badge" style="background-color: #cc2b66;">0</span></h5>
                                <h5 style="float: left;">In Process <span id="remaining-stock" class="badge badge-warning">0</span></h5>
                                <h5 style="text-align: center;">Dispatched Weight <span id="dispatch-weight" class="badge" style="background-color: #cf03f4;">0</span></h5>
                                <h5 style="text-align: right; display: none;">In Process - Product Stock <span id="thirdMinusSecond-stock" class="badge">0</span></h5>
                            </div>
                            <br><br>
                            <div class="pad25" style="clear: both">
                                
                            </div>
                            <br>
                            <div class="form-group pad1EM">
                                <label for="qty">Type:</label>
                                <select class="form-control" id="type-select" onchange="getDataForSelectedType(this);">
                                    <option value="">-- SELECT TYPE --</option>
                                    <?php
                                    $sqlSelect = "SELECT * FROM `production_type`";
                                    $result = mysqli_query($conn, $sqlSelect);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                            <option><?php echo $row['type_name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <?php
                            $sql = "SELECT * FROM `purchase_details_bill`";
                            if ($result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                            ?>
                                    <div class="table-responsive table-25 pad1EM" id="purchase-div">
                                        <table id="purchase-table" class="table tableFixHead table-striped">
                                            <thead>
                                                <tr>
                                                    <th data-field="S.NO" style="color:#0c1211;">S.NO</th>
                                                    <th data-field="DATE" style="color:#0c1211;">DATE</th>
                                                    <th data-field="TYPE" style="color:#0c1211;">TYPE</th>
                                                    <th data-field="TYPE" style="color:#0c1211;">BILL NO</th>
                                                    <th data-field="STEEL PURCHASED (in KG)" style="color:#0c1211;">STEEL PURCHASED (in KG)</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <tbody id="purchase-table-body">
                                                    <tr>
                                                        <td style="color:#0c1211" ;><?php echo $i++; ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $row['PURCHASED_DATE']; ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $row['TYPE']; ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $row['PURCHASE_BILL_NUMBER']; ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $row['weight']; ?></td>
                                                    </tr>
                                                <?php
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
                                    </div>
                                    </br></br>
                                    <?php
                                    $sql = "SELECT C.PRODUCT_NAME, PSW.STOCK_VALUE, PSW.TYPE, PSW.SIZE, PSW.thickness FROM `product_stock_weight` PSW, category C WHERE 1=1 and C.PRODUCT_ID = PSW.PRODUCT_ID ";
                                    if ($result = mysqli_query($conn, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                    ?>
                                            <div class="table-responsive table-25 pad1EM" id="stock-div">
                                                <table id="stock-table" class="table tableFixHead table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th data-field="S.NO" style="color:#0c1211;">Product Name</th>
                                                            <th data-field="DATE" style="color:#0c1211;">Type</th>
                                                            <th data-field="TYPE" style="color:#0c1211;">Size</th>
                                                            <th data-field="TYPE" style="color:#0c1211;">Thickness</th>
                                                            <th data-field="STEEL PURCHASED (in KG)" style="color:#0c1211;">Stock Value</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $i = 1;
                                                    while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tbody id="purchase-table-body">
                                                            <tr>
                                                                <td style="color:#0c1211" ;><?php echo $row['PRODUCT_NAME']; ?></td>
                                                                <td style="color:#0c1211" ;><?php echo $row['TYPE']; ?></td>
                                                                <td style="color:#0c1211" ;><?php echo $row['SIZE']; ?></td>
                                                                <td style="color:#0c1211" ;><?php echo $row['thickness']; ?></td>
                                                                <td style="color:#0c1211" ;><?php echo $row['STOCK_VALUE']; ?></td>
                                                            </tr>
                                                        <?php
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
    var buildTable = function(arr, divId) {
        var columns = addAllColumnHeaders(arr, divId);

        for (var i = 0; i < arr.length; i++) {
            var row$ = $('<tr/>');
            for (var colIndex = 0; colIndex < columns.length; colIndex++) {
                var cellValue = arr[i][columns[colIndex]];

                if (cellValue == null) {
                    cellValue = "";
                }

                row$.append($('<td/>').html(cellValue));
            }
            $("#" + divId).append(row$);
        }
    }

    // Adds a header row to the table and returns the set of columns.
    // Need to do union of keys from all records as some records may not contain
    // all records
    var addAllColumnHeaders = function(arr, divId) {
        var columnSet = [];
        var headerTr$ = $('<tr/>');

        // for (var i = 0 ; i < sizeArray.length ; i++) {
        //     var rowHash = Object.keys(sizeArray[i]);
        //     rowHash.sort();
        //     for (var key in rowHash) {
        //         columnSet.push(rowHash[key]);
        //         headerTr$.append($('<th/>').html(rowHash[key]));
        //     }
        // }

        for (var i = 0; i < arr.length; i++) {
            var rowHash = arr[i];
            for (var key in rowHash) {
                if ($.inArray(key, columnSet) == -1) {
                    columnSet.push(key);
                    headerTr$.append($('<th/>').html(key));
                }
            }
        }

        $("#" + divId).append(headerTr$);

        return columnSet;
    }

    var merge = function(divId) {
        $('#' + divId).margetable({
            type: 2,
            colindex: [0, 1, 2]
        });
    };

    var getDataForSelectedType = function(select) {
        let val = $(select).val();
        $("#available-stock").text(0);
        $("#production-stock").text(0);
        $("#remaining-stock").text(0);
        $("#thirdMinusSecond-stock").text(0);
        $("#dispatch-weight").text(0);

        $.ajax({
            type: 'post',
            url: 'getSteelStockForType.php',
            data: {
                type: val
            },
            success: function(response) {
                debugger;
                console.log(response);
                let sum = 0;
                let process = 0;
                $("#purchase-table").html('');
                let arr = JSON.parse(response)["billDetail"];
                arr.forEach(rec => process += parseInt(rec["STEEL PURCHASED (in KG)"]));
                buildTable(arr, "purchase-table");

                $("#stock-table").html('');
                arr = JSON.parse(response)["productStock"];
                $.when(buildTable(arr, "stock-table")).then(function() {
                    merge('stock-table');
                });

                arr.forEach(rec => sum += parseInt(rec["Stock Value"]));
                let availableWeight = parseInt(JSON.parse(response)["availableWeight"]);
                let dispatchedWgt = parseInt(JSON.parse(response)["dispatchedWgt"]);
                let scrapValue = parseInt(JSON.parse(response)["scrapValue"]);
                $("#available-stock").text(availableWeight);
                $("#production-stock").text(sum);
                $("#scrap-stock").text(scrapValue);
                // let spanVal = process - availableWeight - sum - dispatchedWgt - scrapValue;
                let spanVal = process - availableWeight - (sum + dispatchedWgt) - scrapValue; // In Process
                // let spanVal = process - availableWeight - sum;
                $("#remaining-stock").text(isNaN(spanVal) ? 0 : spanVal);
                // spanVal = process - availableWeight - sum - sum - dispatchedWgt;
                spanVal = process - availableWeight - sum - sum;
                $("#thirdMinusSecond-stock").text(isNaN(spanVal) ? 0 : spanVal);
                $("#dispatch-weight").text(dispatchedWgt);

            }
        });
    };
</script>

</html>