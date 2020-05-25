<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>

<head>
    <title>Machine Stock</title>
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

<body>
    <?php include 'header.php'; ?>
    <!-- sidebar menu end-->

    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Machine Stock
                            </header>
                            <div class="panel-body">

                                <div class="row position-center" style="width: 100%;">
                                    <div class="col-sm-12" id="stock-div">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="sel1">MACHINE NAME</label>
                                                    <select class="form-control" id="machineName">
                                                        <option value="">-- SELECT MACHINE --</option>
                                                        <?php
                                                        $sqlSelect = "SELECT `MACHINE_ID`, `MACHINE_NAME` FROM `machine_details` ORDER BY 2";
                                                        $result = mysqli_query($conn, $sqlSelect);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                                <option value="<?php echo $row['MACHINE_ID'] ?>"><?php echo $row['MACHINE_NAME'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="sel1">TYPE</label>
                                                    <select class="form-control" id="product-type">
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
                                        <button type="submit" class="btn btn-info" name="submit" onclick="getStockDetails()" style="margin-left: 45%;">Show Report</button>


                                    </div>
                                </div>




                                <script type="text/javascript">
                                    var getStockDetails = function() {
                                        let type = $("#product-type").val();
                                        let id = document.getElementById('machineName').value;
                                        if(id == undefined || id == "") {
                                            alert("Machine Name is mandatory");
                                            return false;
                                        }
                                        if(type == undefined || type == "") {
                                            alert("Type is mandatory!");
                                            return false;
                                        }
                                        window.location.replace("machineStockReport.php?machineId=" + id + "&type=" + type + "&machineName=" + $("#machineName option:selected").text());
                                    };

                                    $(document).ready(function() {

                                    });
                                </script>

                        </section>
</body>

</html>