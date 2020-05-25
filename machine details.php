<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

       $MACHINE_NAME = $_POST['MACHINE_NAME'];
       $MACHINE_DESC = $_POST['MACHINE_DESC'];
       $MACHINE_AVG_TIME = $_POST["AVG_WORK_TIME"]; 
       $machineType = $_POST['machine-type'];
       
 $sql = "INSERT INTO machine_details(MACHINE_NAME,AVG_WORK_TIME,MACHINE_DESC, MACHINE_TYPE) VALUES ('$MACHINE_NAME',$MACHINE_AVG_TIME,'$MACHINE_DESC', '$machineType')";

            if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='machine details.php';
        </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
            $conn->close();
         }
      ?>

<!DOCTYPE html>
<head>
<title>Add Machine</title>
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
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        MACHINE DETAILS
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " method="post" role="form">
                                <div class="form-group">
                                    <label for="machine name">Machine Name</label>
                                    <input type="text" class="form-control" id="machine name" placeholder="Enter machine name" name="MACHINE_NAME" required>
                                </div>
                                <div class="form-group">
                                    <label for="machine desc">Machine Description</label>
                                    <input type="text" class="form-control" id="machine desc" placeholder="Enter machine desc" name="MACHINE_DESC">
                                </div>
                                <div class="form-group">
                                    <label for="machine desc">Maximum Output (60 mins)</label>
                                    <input type="number" class="form-control" id="avg-time" placeholder="Enter machine desc" name="AVG_WORK_TIME" required>
                                </div>
                                <div class="form-group">
                                    <label for="machine desc">Machine Type</label>
                                    <select class="form-control" id="machine-type" name="machine-type" required>
                                        <option value="">-- Select Machine Type --</option>
                                        <option value="Count">Count</option>
                                        <option value="Length">Length</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>




<script type="text/javascript">
 
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>

</section>
</body>
</html>
