<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

  $MACHINE_ID= $_POST['MACHINE_ID'];

  $delete = "DELETE FROM machine_details WHERE MACHINE_ID = '$MACHINE_ID'";
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
  <title>Machine View</title>
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
td.length {
    color: red !important;
}
</style>

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
                      <br>
                      
          
<?php
$sql = "SELECT * FROM machine_details";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>
  <div class="table-responsive">
        <table class="table">
    <thead>
      <tr>
        <th style="color:#0c1211"; >MACHINE ID</th>
        <th style="color:#0c1211"; >MACHINE NAME</th>
        <th style="color:#0c1211"; >MACHINE DESCRIPTION</th>
        <th style="color:#0c1211"; >AVG TIME</th>
        <th style="color:#0c1211"; >UPDATE</th>
        <th style="color:#0c1211"; >DELETE</th>


      </tr>
    </thead>
<?php 
$i = 1;
while($row = mysqli_fetch_array($result)){
?>
    <tbody>
      <tr>

        <td style="color:#0c1211";><?php echo $i++; ?></td>
        <td class="<?php echo $row['MACHINE_TYPE']=='Length' ? 'length' : 'count' ?>" style="color:#0c1211;"><?php echo $row['MACHINE_NAME']?></td>
        <td style="color:#0c1211";><?php echo $row['MACHINE_DESC']?></td>
        <td style="color:#0c1211";><?php echo $row['AVG_WORK_TIME']?></td>
        <td style="color:#0c1211";>
          <a href="machine_details_update.php?MACHINE_ID=<?php echo $row['MACHINE_ID']; ?>"><?php $row['MACHINE_ID']?>
            <button type="button" class="btn btn-primary">
              Update
            </button>
          </a>
        </td>
        <td class="contact-delete">
          <form action=" " method="post">
            <input type="hidden" name="MACHINE_ID" value="<?php echo $row['MACHINE_ID']; ?>">
              <input type="submit" name="submit" value="Delete" class="btn btn-primary fa-input">
              <!-- <button type="submit" class="btn btn-success">
                  <i class="fa fa-arrow-circle-right fa-lg"></i> Next
              </button> -->
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






