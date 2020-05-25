<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

  $PURCHASE_PRODUCT_ID= $_POST['PURCHASE_PRODUCT_ID'];

  $delete = "DELETE FROM purchase_product WHERE PURCHASE_PRODUCT_ID = '$PURCHASE_PRODUCT_ID'";
  mysqli_query($conn,$delete);
  ?>

  <script>
    alert("Data Deleted Successfully");
  </script>
<?php
}
?>
  <!DOCTYPE html>
  <head>
  <title>View Raw Material</title>
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
                          VIEW RAW MATERIAL
                      </header>
                      <br>
                      
          
<?php
$sql = "SELECT * FROM purchase_product";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
  <div class="table-responsive">
        <table class="table">
    <thead>
      <tr>
        <th style="color:#0c1211"; >PURCHASE PRODUCT ID</th>
        <th style="color:#0c1211"; >PURCHASE PRODUCT NAME</th>
        <th style="color:#0c1211"; >PURCHASE PRODUCT DESCRIPTION</th>
        <th style="color:#0c1211"; >UPDATE</th>
        <th style="color:#0c1211"; >DELETE</th>


      </tr>
    </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
    <tbody>
      <tr>

        <td style="color:#0c1211";><?php echo $row['PURCHASE_PRODUCT_ID']?></td>
        <td style="color:#0c1211";><?php echo $row['PURCHASE_PRODUCT_NAME']?></td>
        <td style="color:#0c1211";><?php echo $row['PURCHASE_PRODUCT_DESC']?></td>
        <td style="color:#0c1211";><a href="purchase_product_update.php?PURCHASE_PRODUCT_ID=<?php echo $row['PURCHASE_PRODUCT_ID']; ?>"><?php $row['PURCHASE_PRODUCT_ID']?><button type="button" class="btn btn-primary">Update</button></a></td>
        <td class="contact-delete">
          <form action=" " method="post">
            <input type="hidden" name="PURCHASE_PRODUCT_ID" value="<?php echo $row['PURCHASE_PRODUCT_ID']; ?>">
            <input type="submit" name="submit" value="Delete" class="btn btn-primary">
          </form>
        </td>

      </tr>
<?php
}
?>

  </table>
<?php  
mysqli_free_result($result);
} 
else{
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
  </html>






