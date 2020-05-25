<?php
session_start();
include 'db_connect.php';
if (isset($_GET['MACHINE_ID']) & !empty($_GET['MACHINE_ID'])) {
    $id3 = $_GET['MACHINE_ID'];
    $show = mysqli_query($conn, "select * from machine_details where MACHINE_ID = '$id3' ");
    $row = mysqli_fetch_array($show);
}

if (isset($_POST['submit'])) {
    $MACHINE_NAME = $_POST['MACHINE_NAME'];
    $MACHINE_DESC = $_POST['MACHINE_DESC'];
    $MACHINE_AVG_TIME = $_POST["AVG_WORK_TIME"];
    $machineType = $_POST["MACHINE_TYPE"];

    $update = "UPDATE `machine_details` SET `MACHINE_NAME`='$MACHINE_NAME',`AVG_WORK_TIME`=$MACHINE_AVG_TIME,`MACHINE_DESC`='$MACHINE_DESC', `MACHINE_TYPE`='$machineType' WHERE MACHINE_ID = $id3";
    if (mysqli_query($conn, $update)) {
?>
        <script type="text/javascript">
            alert('Data Updated Successfully');
            window.location.href = 'machine_details_view.php';
        </script>

<?php
    } else {
        echo "Error: " . $update . "" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>

<head>
    <title>Machine Update</title>
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
    .Length {
        color: red;
    }
</style>    

<script>
    var machineType = <?php echo "'" . $row['MACHINE_TYPE'] . "'"; ?>;
</script>

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
                                MACHINE DETAILS UPDATE
                            </header>
                            <div class="panel-body">
                                <div class="position-center">



                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="machine_id">Machine Id</label>
                                            <input type="number" class="form-control" id="machine_id" placeholder="Enter machineid" name="MACHINE_ID" value="<?php echo $MACHINE_ID = $row['MACHINE_ID'] ?>" required disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="machine_name">Machine Name</label>
                                            <input type="text" class="form-control <?php echo $row['MACHINE_TYPE']; ?>" id="machine_name" placeholder="Enter machinename" name="MACHINE_NAME" value="<?php echo $MACHINE_ID = $row['MACHINE_NAME'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="machine_desc">Machine Description</label>
                                            <input type="text" class="form-control" id="machine_desc" placeholder="Enter MachineDescription" name="MACHINE_DESC" value="<?php echo $MACHINE_ID = $row['MACHINE_DESC'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="machine desc">Average Work Time (In Hrs)</label>
                                            <input type="number" class="form-control" id="avg-time" placeholder="Enter machine desc" name="AVG_WORK_TIME" value="<?php echo $MACHINE_ID = $row['AVG_WORK_TIME'] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="machine desc">Machine Type</label>
                                            <select class="form-control" id="machine-type" name="MACHINE_TYPE" required>
                                                <option value="">-- Select Machine Type </option>
                                                <option value="Count">Count</option>
                                                <option value="Length">Length</option>
                                            </select>
                                        </div>

                                        <br><br>
                                        <button type="submit" name="submit" class="btn btn-success">Update</button>
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
    $(document).ready(function() {
        $("#machine-type").val(machineType);
    });
</script>

</html>