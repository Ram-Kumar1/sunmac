<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){
       $PURCHASE_PRODUCT_NAME= $_POST['PURCHASE_PRODUCT_NAME'];
       $PURCHASE_PRODUCT_DESC= $_POST['PURCHASE_PRODUCT_DESC'];

       $sql="INSERT INTO purchase_product(PURCHASE_PRODUCT_NAME,PURCHASE_PRODUCT_DESC) VALUES ('$PURCHASE_PRODUCT_NAME','$PURCHASE_PRODUCT_DESC')";
       if(mysqli_query($conn,$sql)){
        ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='purchase_product.php';
        </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
       }
?>

<!DOCTYPE html>
<head>
<title>Purchase Product</title>
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

  <style type="text/css">
      .filterable {
      margin-top: 15px;
  }
  .filterable .panel-heading .pull-right {
      margin-top: -20px;
  }
  .filterable .filters input[disabled] {
      background-color: transparent;
      border: none;
      cursor: auto;
      box-shadow: none;
      padding: 0;
      height: auto;
  }
  .filterable .filters input[disabled]::-webkit-input-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]::-moz-placeholder {
      color: #333;
  }
  .filterable .filters input[disabled]:-ms-input-placeholder {
      color: #333;
  }
  </style>
</head>
<body>
<?php include 'header.php'; ?>

<section id="main-content">
	<section class="wrapper">
       <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Raw Maerials
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " method="post" role="form">

                               <div class="form-group">
                                    <label for="product name">Product Name</label>
                                    <input type="text" class="form-control" id="product Name" placeholder="Enter product Name" name="PURCHASE_PRODUCT_NAME" required>
                                </div>
                        
                               <div class="form-group">
                                    <label for="product description">Product Descripition</label>
                                    <input type="text" class="form-control" id="Product Descripition" placeholder="Enter Product Descripition" name="PURCHASE_PRODUCT_DESC" required>
                                </div>
                                
                                
                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
                            </form>
                        </div>
                      </div>


</section>


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

