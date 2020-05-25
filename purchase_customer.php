<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

       $P_COMPANY_NAME= $_POST['P_COMPANY_NAME'];
       $P_MOBILE= $_POST['P_MOBILE'];
       $P_ALTERNATE_MOBILE= $_POST['P_ALTERNATE_MOBILE'];
       $P_EMAIL= $_POST['P_EMAIL'];
       $P_ADDRESS= $_POST['P_ADDRESS'];
       $P_CITY= $_POST['P_CITY'];
       $P_PRODUCT_DETAILS= $_POST['PRODUCTS'];
       $GST_NUMBER= $_POST['GST_NUMBER'];


$sql="INSERT INTO purchase_customer(P_COMPANY_NAME,P_MOBILE,P_ALTERNATE_MOBILE,P_EMAIL,P_ADDRESS,P_CITY,P_PRODUCT_DETAILS,GST_NUMBER)VALUES('$P_COMPANY_NAME','$P_MOBILE','$P_ALTERNATE_MOBILE','$P_EMAIL','$P_ADDRESS','$P_CITY','$P_PRODUCT_DETAILS','$GST_NUMBER')";
if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='purchase_customer.php';
        </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
         }
      ?>

<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
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
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                            ADD SUPPLIER
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action="" method="post" role="form" id="frm">

                              <div class="form-group">
                                    <label for="p_name">Supplier Name</label>
                                    <input type="text" class="form-control" id="p_custname" placeholder="Enter companyname" name="P_COMPANY_NAME">
                                </div>
                                <div class="form-group">
                                    <label for="p_mobile">Mobile Number</label>
                                    <input type="number" class="form-control" id="mob_no" placeholder="Enter mobile number" name="P_MOBILE">
                                  </div>

                                  <div class="form-group">
                                    <label for="mob_no">Alternate Mobile Number</label>
                                    <input type="number" class="form-control" id="mob_no" placeholder="Enter mobile number" name="P_ALTERNATE_MOBILE">
                                </div>

                                <div class="form-group">
                                    <label for="P_EMAIL">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email" name="P_EMAIL">
                                </div>

                                <div class="form-group">
                                <label for="p_address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter Adrress" name="P_ADDRESS">
                              </div>
<?php
$selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
?>
                              <div class="form-group">
                                    <label for="sel1">City</label>
                                    <select type="text" class="form-control" id="sel1" name="P_CITY">
                                      <option value="">-- SELECT CITY --</option>
                                      <?php
                                        if($result = mysqli_query($conn, $selectCity)){
                                          if(mysqli_num_rows($result) > 0){ 
                                            while($row = mysqli_fetch_array($result)) {
                                      ?>
                                              <option value="<?php echo $row['CITY_NAME']?>" ><?php echo $row['CITY_NAME'] ?></option>
                                      <?php
                                            }
                                          }
                                        }
                                      ?>
                                    </select>
                              </div>
                                
                              <div class="form-group">
                                  <label for="p_product_details">GST Number </label>
                                <input type="text" class="form-control" id=" gstNumber" placeholder="Enter GST Nmuber" name="GST_NUMBER">
                              </div>
<?php
$selectProduct = 'SELECT * FROM `purchase_product`';
?>
                              <div class="form-group">
                                  <label for="p_product_details">Product Details</label>
                                    <select type="text" class="form-control" id="product" name="product">
                                      <option value="">-- SELECT PRODUCT --</option>
                                      <?php
                                        if($result = mysqli_query($conn, $selectProduct)){
                                          if(mysqli_num_rows($result) > 0){ 
                                            while($row = mysqli_fetch_array($result)) {
                                      ?>
                                              <option value="<?php echo $row['PURCHASE_PRODUCT_ID']?>" ><?php echo $row['PURCHASE_PRODUCT_NAME']; ?></option>
                                      <?php
                                            }
                                          }
                                        }
                                      ?>
                                    </select>
                              </div>
                              <button type="button" class="btn btn-info" onclick="addProduct()" >Add</button>  

                              <table class="table" id="product-table">
                                <thead>
                                  <tr>
                                    <th style="color:#0c1211"; >RAW MATERIAL ID</th>
                                    <th style="color:#0c1211"; >RAW MATERIAL NAME</th>
                                    <th style="color:#0c1211"; >DELETE</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                              <div class="form-group">
                                  <label for="p_product_details"></label>
                                <input type="text" class="form-control" id="products" placeholder="Enter GST Nmuber" name="PRODUCTS" style="display: none;">
                              </div>
                              <button type="submit" class="btn btn-info" name="submit">Submit</button>
                            </form>
                        </div>
                      </div>
    
</section>


<script type="text/javascript">

$('#frm').on('submit', function () {
  let arr= [];
  $("tr").each(function() {
    var id = $(this).find(".product-id").text();
    if(id=="") {

    } else {
      arr.push(id);
    }
    
  });
  $("#products").val(arr.toString());

    return true;
});

var addProduct = function() {
  $("#product-table").append('<tr><td class="product-id">'+$("#product").val()+'</td><td>'+$("#product option:selected").text()+'</td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
};

function state(val)
{
 $.ajax({
 type: 'post',
 url: 'fetch_data.php',
 data: {
  state:val
 },
 success: function (response) {
  document.getElementById("city").innerHTML=response; 
 }
 });
}
</script>
 
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

    $("#product-table").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });

});
</script>
</section>

</body>
</html>







