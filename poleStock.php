<?php
    session_start();
    include 'db_connect.php';
?>

<!DOCTYPE html>
<head>
<title>Pole Stock</title>
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
                        Pole Stock
                    </header>
                    <div class="panel-body">
                        
                        <div class="row position-center"  style="width: 100%;">
                  <div class="col-sm-12" id="stock-div"> 
                      <div class="row">
                          <div class="col-sm-3">
                              <div class="form-group">
                              <label for="sel1">PRODUCT NAME</label>
                              <select class="form-control" id="productName" > 
                                  <option value="">-- SELECT PRODUCT --</option>
                                  <?php
                                  $sqlSelect = "SELECT PRODUCT_ID, PRODUCT_NAME FROM `category` ORDER BY 2";
                                  $result = mysqli_query($conn, $sqlSelect);
                                  if(mysqli_num_rows($result) > 0){ 
                                  while($row = mysqli_fetch_array($result)) {
                                  ?>
                                  <option value="<?php echo $row['PRODUCT_ID']?>" ><?php echo $row['PRODUCT_NAME'] ?></option>
                                  <?php
                                  }
                                  }
                                  ?>
                                </select>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="form-group">
                                  <label for="sel1">TYPE</label>
                                      <select class="form-control" id="product-type" > 
                                      <option value="">-- SELECT TYPE --</option>
                                      <?php
                                      $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                                      $result = mysqli_query($conn, $sqlSelect);
                                      if(mysqli_num_rows($result) > 0){ 
                                      while($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                                          <?php
                                          }
                                          }
                                      ?>
                                      </select>
                              </div>
                          </div>

                          <div class="col-sm-3">
                              <div class="form-group">
                                  <label for="sel1">SIZE</label>
                                          <select class="form-control" id="product-size" > 
                                          <option value="">-- SELECT SIZE --</option>
                                          <?php
                                          $sqlSelect = "SELECT `SIZE` FROM `production_size` ORDER BY 1";
                                          $result = mysqli_query($conn, $sqlSelect);
                                          if(mysqli_num_rows($result) > 0){ 
                                          while($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <option value="<?php echo $row['SIZE']?>" ><?php echo $row['SIZE'] ?></option>
                                          <?php
                                          }
                                          }
                                          ?>
                                          </select>
                                  </div>
                              </div>
                                          
                              <div class="col-sm-3">
                              <div class="form-group">
                                  <label for="sel1">THICKNESS</label>
                                      <select class="form-control" id="product-thickness" > 
                                      <option value="">-- SELECT THICKNESS --</option>
                                      <?php
                                      $sqlSelect = "SELECT `thickness` FROM `production_thickness` ORDER BY 1";
                                      $result = mysqli_query($conn, $sqlSelect);
                                      if(mysqli_num_rows($result) > 0){ 
                                      while($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <option value="<?php echo $row['thickness']?>" ><?php echo $row['thickness'] ?></option>
                                          <?php
                                          }
                                          }
                                      ?>
                                      </select>
                              </div>
                          </div>              
                            <div class="col-sm-3">
                                <div class="form-group">
                                <label for="example-date-input">Date</label>
                                <input class="form-control" type="date" id="input-date">
                                </div>  
                            </div>

                        </div> 
                        <button type="submit" class="btn btn-info" name="submit" onclick="getStockDetails()" style="margin-left: 45%;">Show Report</button>
              

              </div>
                    </div>




<script type="text/javascript">
 
var getStockDetails = function() {
    let type = $("#product-type").val();
    let size = $("#product-size").val();
    let id = document.getElementById('productName').value; 
    let thickness = $("#product-thickness").val();
    let date = $("#input-date").val();
    window.location.replace("poleStockReport.php?productId="+id+"&type="+type+"&size="+size+"&thickness="+thickness+"&date="+date+"&productName="+$("#productName option:selected").text());
};

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
