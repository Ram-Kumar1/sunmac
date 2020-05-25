<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

  $CITY_ID= $_POST['CITY_ID'];

  $delete = "DELETE FROM city WHERE CITY_ID = '$CITY_ID'";
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
 
  </style>
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
                          CITY
                      </header>
                      <br>
                      
          
<?php
$sql = "SELECT * FROM city";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
  <div class="table-responsive">
        <table class="table">
    <thead>
      <tr>
        <th style="color:#0c1211"; >S.NO</th>
        <th style="color:#0c1211"; >CITY NAME</th>
        <th style="color:#0c1211"; >DELETE</th>

      </tr>
    </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
    <tbody>
      <tr>

        <td style="color:#0c1211";><?php echo $row['CITY_ID']?></td>
        <td style="color:#0c1211";><?php echo $row['CITY_NAME']?></td>
        <td class="contact-delete">
            <form action=" " method="post">
                <input type="hidden" name="CITY_ID" value="<?php echo $row['CITY_ID']; ?>">
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






