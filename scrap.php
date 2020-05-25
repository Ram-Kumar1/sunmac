<?php
session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $scrap = $_POST['scrap'];
    $type = $_POST['type'];
    $update = "UPDATE `available_weight` SET `total`= total - $scrap WHERE TYPE='$type'";
    mysqli_query($conn, $update);
    date_default_timezone_set('Asia/Kolkata');
    $date_1 =  date('d-m-Y H:i');
    $date = date('Y-m-d', strtotime($date_1));
    $insert = "INSERT INTO `scrap_value_tracker`(`DATE`, `TYPE`, `SCRAP_WEIGHT`) VALUES ('$date', '$type', $scrap)";
    mysqli_query($conn, $insert);
?>
    <script type="text/javascript">
        alert('Update Successfull');
        window.location.href = 'scrap.php';
    </script>
<?php
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Scrap</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Scrap
                            </header>
                            <div class="panel-body">
                                <div class="position-center">
                                    <form action=" " role="form" method="post">

                                        <div class="form-group">
                                            <label for="qty">Type:</label>
                                            <select class="form-control" name="type" id="type-select" onchange="getDataForSelectedType(this); required">
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

                                        <div class="form-group">
                                            <label for="city">Enter the Scrap Value</label>
                                            <input type="number" class="form-control" id="scrap" placeholder="Enter Location" name="scrap" required>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
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

</html>