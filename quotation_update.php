<?php
session_start();
include 'db_connect.php';
if(isset($_GET['QUOTATION_ID']) & !empty($_GET['QUOTATION_ID'])){
        
          $id3 = $_GET['QUOTATION_ID'];  
          $show=mysqli_query($conn,"SELECT q.QUOTATION_ID, q.CUSTOMER_ID,q.Q_DATE,q.Q_STATUS, q.NEXT_FOLLOWUP_DATE,q.QUOTATION_PRODUCT_ID,q.CUSTOMER_STATUS, q.REMARKS, sc.S_NAME,sc.S_MOBILE from quotation q, sales_customer sc where q.QUOTATION_ID=$id3");
                 $row=mysqli_fetch_array($show);
                 $CUST = $row['CUSTOMER_ID'];
       
           }


if(isset($_POST['submit'])){

        $Q_STATUS=$_POST['Q_STATUS'];
        $NEXT_FOLLOWUP_DATE=$_POST['NEXT_FOLLOWUP_DATE'];
		date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$Q_DATE = date('Y-m-d', strtotime($date_1));
		
        $REMARKS=$_POST['REMARKS'];
        $CUSTOMER_ID=$CUST;

if(!empty($_POST['check_list'])) {
     $checkbox = array();
    foreach($_POST['check_list'] as $check) {
        $checkbox[] = $check;
    }
   $PRODUCT_ID = implode(',', $checkbox);
}

        $update="UPDATE `quotation` SET Q_STATUS = '$Q_STATUS' ,NEXT_FOLLOWUP_DATE = '$NEXT_FOLLOWUP_DATE',Q_DATE = '$Q_DATE',REMARKS = '$REMARKS',QUOTATION_PRODUCT_ID = '$PRODUCT_ID',CUSTOMER_STATUS='1' WHERE QUOTATION_ID=$id3";
           
  if (mysqli_query($conn, $update)) {

  header("Location: quotation.php");

} else {
    echo "Error: " . $sql . "" . mysqli_error($conn);
        }

  $conn->close();


// function sample_invoice(status){
//             var form = document.getElementById('quotation-form');
//             if(status == 'sample_invoice'){
//               form.action = 'sample_invoice.php';
//             }else{
//               form.action = '';
//             }
//           }



        /*//INSERT INTO sample_invoice
        if($row['Q_STATUS'] == 'sample_invoice'){
        echo $insertQuery = "INSERT INTO `sample_invoice`(`QUOTATION_ID`, `CUSTOMER_ID`, `QUOTATION_DATE`,`PRODUCTS`) VALUES ($id3,$CUSTOMER_ID,'$Q_DATE',$PRODUCT_ID)";
        mysqli_query($conn,$insertQuery);
        }*/
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
  <script type="text/javascript">
  var productId = [];
  var productName = [];
</script>
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
                          QUOTATION UPDATE  
                      </header>
                      
                    <?php if($row['CUSTOMER_STATUS'] == '1' AND $row['Q_STATUS'] != "drop") { ?>
                      <div class="table-responsive">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>Quotation Date</th>
                                    <th style="color:#0c1211";>Quotation Status</th>
                                    <th style="color:#0c1211";>Remarks</th>  
                                    <th style="color:#0c1211";>Quotation Product</th>
                                </tr>
                             </thead>
            
                           <tbody>
                              <tr>
                                   <td  style="color:#0c1211";><?php echo $row['Q_DATE']?></td>
                                   <td  style="color:#0c1211";><?php echo $row['Q_STATUS']?></td>
                                   <td  style="color:#0c1211";><?php echo $row['REMARKS']?></td>
                                   <td  style="color:#0c1211";><?php  
                                  $man = $row['QUOTATION_PRODUCT_ID'];
                                  $man =  str_replace('"',"", $man);
                                  $man =  explode(',',$man);
                                  $size = sizeof($man);
                                  for($i=0; $i<$size; $i++) {
                                  $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' ";
                                  $insert = mysqli_query($conn, $pur);
                                  $rows = mysqli_fetch_array($insert);
                                  echo $rows['PRODUCT_NAME'];
                                  echo "<br>";
                                  }
                                   ?></td>
                                  
                               </tr>
                            </tbody>

                      <?php
                      } 
                      ?>

                            </table>                    
                            <br>
                            <br>





<div class="panel-body">
  <div class="position-center">
    <form action="" method="POST" id="quotation-form">
      <div class="form-group">
          <label for="mail">Status</label>
           <select class="form-control" name="Q_STATUS" onchange="demo(this.value),sample_invoice(this.value)"  required>
                <option value="">Select status</option>
                <option value="sample_invoice" id="sample_invoice">Sample Invoice</option>
                <option value="followUp">Followup</option>
                <option value="drop">Drop</option>
            </select>
      </div>   

        <script type="text/javascript">
          function demo(val){

            if(val == 'sample_invoice' || val == 'drop'){
             document.getElementById("panel").disabled = true;
            } else{
             document.getElementById("panel").disabled = false;
            }
          }
          
        </script>
         <div class="form-group">
            <input type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_ID'] ?>" value='<?php echo $row['PRODUCT_ID'] ?>' HIDDEN>
        </div>
       <div class="form-group">
            <label for="mail">Next Followup Date</label>
            <input disabled id="panel" class="form-control" id="textinput-name" name="NEXT_FOLLOWUP_DATE" placeholder="Date" class="form-control input-md" type="date" >
        </div>                                

     
        <div class="form-group">
            <label for="date">Current Date</label>

    <input type="text" class="form-control" id="date" value="<?php echo date('d-m-Y');?>" name="Q_DATE" disabled//  >
        </div>


        <div class="form-group">
            <label for="mail">Remark</label>
            <input type="text" name="REMARKS" class="form-control" id="s_mail"  required >
        </div> 


      <?php if($row['Q_STATUS'] != "drop") { ?>


          <div class="form-group">
           <!--  <input type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_ID'] ?>" value='<?php echo $row['PRODUCT_ID'] ?>' HIDDEN> -->
            <label for="sel2">PRODUCT'S</label>

        <?php
        $select=mysqli_query($conn,"SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE 1");
        while($row=mysqli_fetch_array($select))
        {
        ?>
         <br>
        <div>
          
            <input type="checkbox" name="check_list[]" value="<?php echo $row['PRODUCT_ID'] ?>">
          <label for="sel2" value="<?php echo $row['PRODUCT_ID'] ?>" ><h4><?php echo $row['PRODUCT_NAME'] ?></h4></label>
          <br>
          </div>
      <?php
      }
      ?>
      <?php
      }
      ?>
      <br><br>
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </div> 
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
    // function showPage()
    // {
    //   var sel=document.getElementById('sample_invoice');
    //   var option=sel.options[sel.selectedIndex].value;
    //   window.open(option + "sample_invoice.php");
    // }
  </script>


  </body>
  </html>


