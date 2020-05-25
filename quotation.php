<?php
session_start();
include 'db_connect.php';

$new_sql_query = "SELECT q.QUOTATION_ID, q.CUSTOMER_ID,q.Q_STATUS, q.NEXT_FOLLOWUP_DATE,q.CUSTOMER_STATUS,sc.S_NAME,sc.S_MOBILE,sc.S_ALTERNATE_MOBILE,sc.S_MAIL from quotation q, sales_customer sc where q.CUSTOMER_ID=sc.S_ID AND Q_STATUS = '0' " ;

$result = mysqli_query($conn, $new_sql_query);

$new_data_count = mysqli_num_rows($result);

// old data

date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date_cur = date('Y-m-d', strtotime($date_1));

$old_sql_query = "SELECT q.QUOTATION_ID, q.CUSTOMER_ID,q.Q_STATUS, q.NEXT_FOLLOWUP_DATE,q.CUSTOMER_STATUS,sc.S_NAME,sc.S_MOBILE,sc.S_ALTERNATE_MOBILE,sc.S_MAIL,q.NEXT_FOLLOWUP_DATE from quotation q, sales_customer sc where q.CUSTOMER_ID=sc.S_ID AND q.Q_STATUS = 'followUp' AND q.NEXT_FOLLOWUP_DATE <= '$date_cur' " ;

$result_old = mysqli_query($conn,$old_sql_query);
$old_data_count = mysqli_num_rows($result_old);


  ?>
  <!DOCTYPE html>
  <head>
  <title>Quotation</title>
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

 <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                       Old QUOTATION 
                    </header>
                  
                      <?php                          
                      if( $old_data_count > 0){ 
                      ?>
                      <div class="table-responsive">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S No</th>
                                    <th style="color:#0c1211";>CUSTOMER NAME</th>
                                    <th style="color:#0c1211";>CUSTOMER MOBILE NUMBER</th>
                                    <th style="color:#0c1211";>ALTERNATE MOBILE NUMBER</th>
                                    <th style="color:#0c1211";>CUSTOMER EMAIL</th>
                                    <th style="color:#0c1211";>UPDATE</th>  
                                </tr>
                             </thead>
                           <?php 
                           $a=1;
                           while($row = mysqli_fetch_array($result_old)){
                           ?>
                           <tbody>
                              <tr>
                                    <td style="color:#0c1211";><?php echo $a ; $a++;?></td>        
                                    <td style="color:#0c1211";><?php echo $row['S_NAME']?></td>
                                    <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
                                    <td style="color:#0c1211";><?php echo $row['S_ALTERNATE_MOBILE']?></td>
                                    <td style="color:#0c1211";><?php echo $row['S_MAIL']?></td>
                                    <td><a href="quotation_update.php?QUOTATION_ID=<?php echo $row['QUOTATION_ID']; ?>" ><button type="button" class="btn btn-primary">Update</button></a></td>


                               </tr>
                            </tbody>

                      <?php
                      } }
                      ?>

                            </table>                    
                            <br>
                            <br>
                    <header class="panel-heading">
                        New QUOTATION 
                    </header>
                          <?php
                          if( $new_data_count > 0){ 
                          ?>
                          <div class="table-responsive">
                              <table class="table">
                                <thead>
                                 <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S No</th>
                                    <th style="color:#0c1211";>CUSTOMER NAME</th>
                                    <th style="color:#0c1211";>CUSTOMER MOBILE NUMBER</th>
                                    <th style="color:#0c1211";>ALTERNATE MOBILE NUMBER</th>
                                    <th style="color:#0c1211";>CUSTOMER EMAIL</th>
                                    <th style="color:#0c1211";>UPDATE</th>
                                  </tr>
                               </thead>
                             <?php 
                             $b=1;
                             while($rows = mysqli_fetch_array($result)){
                             ?>
                             <tbody>
                                <tr>
                                    <td style="color:#0c1211";><?php echo $b; $b++;?></td>        
                                    <td style="color:#0c1211";><?php echo $rows['S_NAME']?></td>
                                    <td style="color:#0c1211";><?php echo $rows['S_MOBILE']?></td>
                                    <td style="color:#0c1211";><?php echo $rows['S_ALTERNATE_MOBILE']?></td>
                                    <td style="color:#0c1211";><?php echo $rows['S_MAIL']?></td>
                                    <td><a href="quotation_update.php?QUOTATION_ID=<?php echo $rows['QUOTATION_ID']; ?>" ><button type="button" class="btn btn-primary">Update</button></a></td>

                                 </tr>
                              </tbody>

                          <?php
                          } }
                          ?>
                           </table>
                            <br>
                            <br>
                     

        </div>
      </div>
    </section>
  </div>
</div>
</div>




</body>
</html>






