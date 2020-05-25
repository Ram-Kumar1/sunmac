<?php
session_start();
include 'db_connect.php';
if(isset($_GET['P_ID']) & !empty($_GET['P_ID'])){
        
            $id3 = $_GET['P_ID'];  

          
             $show=mysqli_query($conn,"select * from purchase_customer where P_ID = '$id3' ");
                 $row=mysqli_fetch_array($show);
                 
           }
if(isset($_POST['submit'])){

        $P_COMPANY_NAME=$_POST['P_COMPANY_NAME'];
        $P_MOBILE=$_POST['P_MOBILE'];
        $P_ALTERNATE_MOBILE=$_POST['P_ALTERNATE_MOBILE'] == null || $_POST['P_ALTERNATE_MOBILE'] == "" ? "" : $_POST['P_ALTERNATE_MOBILE'];
        // echo "Empty String: ".empty($P_ALTERNATE_MOBILE);
        $P_EMAIL=$_POST['P_EMAIL'];
        $P_ADDRESS=$_POST['P_ADDRESS'];
        $P_CITY=$_POST['P_CITY'];
        $P_PRODUCT_DETAILS=$_POST['PRODUCTS'];
        $GST_NUMBER=$_POST['GST_NUMBER'];

        $update ="UPDATE `purchase_customer` SET `P_COMPANY_NAME`='$P_COMPANY_NAME',`P_MOBILE`=$P_MOBILE,`P_EMAIL`='$P_EMAIL',`P_ADDRESS`='$P_ADDRESS',`P_CITY`='$P_CITY',`P_PRODUCT_DETAILS`='$P_PRODUCT_DETAILS',`GST_NUMBER`=$GST_NUMBER";
        if(!empty($P_ALTERNATE_MOBILE)) {
          $update = $update . ", `P_ALTERNATE_MOBILE`=$P_ALTERNATE_MOBILE ";
        }
        $update = $update . "WHERE P_ID = $id3";

             if (mysqli_query($conn,$update)) {
                  ?>
          <script type="text/javascript">
          alert('Data Updated Successfully');
          window.location.href='purchase_customer_view.php';
          </script>
          
          <?php
              } else {
                 echo "Error: " . $update . "" . mysqli_error($conn);
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
                              SUPPLIER UPDATE
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


    
    <form action="" method="POST">
        <div class="form-group">
            <label for="supplier_id">Supplier Id</label>
            <input type="number" class="form-control" id="supplier_id" placeholder="Enter supplierid" name="P_ID" value="<?php echo $P_ID = $row['P_ID']?>" required disabled>
        </div>
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" class="form-control" id="company_name" placeholder="Enter comapnyname" name="P_COMPANY_NAME" value="<?php echo $P_ID = $row['P_COMPANY_NAME']?>">
        </div>
        <div class="form-group">
            <label for="mobile number">Mobile Number</label>
            <input type="number" class="form-control" id="mobile number" placeholder="Enter Mobile Number" name="P_MOBILE" value="<?php echo $P_ID = $row['P_MOBILE']?>">
        </div>
        <div class="form-group">
            <label for="alternate_mobile">Alternate Mobile</label>
            <input type="number" class="form-control" id="alternate_mobile" placeholder="Enter alternate Mobile" name="P_ALTERNATE_MOBILE" value="<?php echo $P_ID = $row['P_ALTERNATE_MOBILE']?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="P_EMAIL" value="<?php echo $P_ID = $row['P_EMAIL']?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" placeholder="Enter Address" name="P_ADDRESS" value="<?php echo $P_ID = $row['P_ADDRESS']?>" >
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" placeholder="Enter city" name="P_CITY" value="<?php echo $P_ID = $row['P_CITY']?>" >
        </div>
        <script>
        var productArray = "<?php echo $row['P_PRODUCT_DETAILS']; ?>";
        </script>
        
        <div class="form-group">
            <label for="gst_number">GST Number</label>
            <input type="number" class="form-control" id="GST Number" placeholder="Enter GST Number" name="GST_NUMBER" value="<?php echo $P_ID = $row['GST_NUMBER']?>">
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
                              <button type="button" class="btn btn-info" id="add-btn" onclick="addProduct()" >Add</button>  

                              <table class="table" id="product-table">
                                <thead>
                                  <tr>
                                    <th style="color:#0c1211"; >PURCHASE PRODUCT ID</th>
                                    <th style="color:#0c1211"; >PURCHASE PRODUCT NAME</th>
                                    <th style="color:#0c1211"; >DELETE</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                              <div class="form-group">
                                  <label for="p_product_details"></label>
                                <input type="text" class="form-control" id="products" name="PRODUCTS" style="display: none;">
                              </div>
        <br><br>
          <button type="submit" name="submit" class="btn btn-default">Update</button>  
    </form>
                        </div>
                      </div>

  
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>

<script>
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

$(document).ready(function(){
    $("#products").val(productArray);
    let arr = productArray.split(",");
    for(let i=0; i<arr.length; i++) {
        $("#product").val(arr[i]);
        $("#add-btn").click();
    }

    $("#product-table").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
});
</script>
</body>
  </html>

