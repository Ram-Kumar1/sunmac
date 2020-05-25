<?php
session_start();
include 'db_connect.php';

if(isset($_POST['S_ID'])){

  $S_ID= $_POST['S_ID'];

  $delete = "DELETE FROM `sales_customer` WHERE S_ID = '$S_ID'";
  mysqli_query($conn,$delete);
  print json_encode("success");
  ?>
  <script>
    alert("Data Deleted Successfully");
  </script>
<?php
}
if(isset($_POST['submit'])){

       $S_NAME= $_POST['S_NAME'];
       $S_MOBILE= $_POST['S_MOBILE'];
       $S_ALTERNATE_MOBILE= $_POST['S_ALTERNATE_MOBILE'];
       $S_MAIL= $_POST['S_MAIL'];
       $S_ADDRESS= $_POST['S_ADDRESS'];
       $S_CITY= $_POST['S_CITY'];
	   
	   
		date_default_timezone_set('Asia/Kolkata');
		$date_1 =  date('d-m-Y H:i');
		$S_REGISTRATION_DATE = date('Y-m-d', strtotime($date_1));
		   

    if(strlen($S_MOBILE)  == 10 && strlen($S_ALTERNATE_MOBILE)  == 10){
          
 $sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', '$S_REGISTRATION_DATE')";
if (mysqli_query($conn, $sql)) {
                ?>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }

       }   else{

 ?>
        <script type="text/javascript">
         alert("Phone number is invalid");
        document.form1.S_MOBILE.focus();
       </script>
        
        <?php


         }
       }

function startsWith ($string, $startString) 
                  { 
                      $len = strlen($startString); 
                      return (substr($string, 0, $len) === $startString); 
                  } 
                  

      ?>

<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
<style type="text/css">
  .email-max-width {
    word-wrap: break-word;
    max-width: 150px;
  }

  .max-10 {
    max-width: 10em;
  }

  .bg-red {
    color: red !important;
  }

</style>


<script type="text/javascript">
  var deleteRecords = function(deleteButton) {
    debugger;
    let sId = $(deleteButton).attr('data-s-id');
     $.ajax({
       type: 'post',
       url: 'sales_customer_all.php',
       data: {
        S_ID:sId,
       },
       success: function (response) {
       alert('Data is deleted Successfully');
       window.location.reload();
       //window.location.href = "sales_customer_all.php"
       }
    });
  }

</script>

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
                        ADD NEW PRODUCT TO CUSTOMER
                    </header>
<?php
$sql = "SELECT * FROM sales_customer where S_NEED_TO_FOLLOWED = '1' ORDER BY S_NAME ";
if($result = mysqli_query($conn, $sql)){
    //if(mysqli_num_rows($result) > 0){ 
?>
<div class="table-responsive">
        <table class="table" id="productTable">
          <thead>
           <tr style="color:#0c1211";>
                <th style="color:#0c1211";>S NO</th>
                <th style="color:#0c1211;"  class="max-10">CUSTOMER NAME</th>
                <th style="color:#0c1211";>MOBILE NUMBER</th>
                <th style="color:#0c1211"; class="email-max-width">EMAIL</th>
                <th style="color:#0c1211";>PRODUCT NEED TO BE ADDED</th>
                
                <th style="color:#0c1211";>Update</th>
                <!-- <th style="color:#0c1211";>Delete</th> -->
            </tr>
         </thead>
       <?php 
       $i=1;
       while($row = mysqli_fetch_array($result)){
       ?>
       <tbody>
          <tr>
               <td style="color:#0c1211";><?php echo $i++ ?></td>
               <td style="color:#0c1211;" class="max-10"><?php echo $row['S_NAME']?></td>
               <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
               <td style="color:#0c1211;" class="email-max-width <?php echo $row['S_MAIL'] == 'sample@gmail.com' ? 'bg-red' : ''  ?>"><?php echo $row['S_MAIL']?></td>
               
               <td style="color:#0c1211";>

                <?php 

                    
                  // Main function 
                  // if(startsWith("abcde","c")) 
                  //     echo "True"; 
                  // else
                  //     echo "False"; 

                  $manufProducts = $row['S_MANUFACTURER_PRODUCTS'];
                  $dealerProducts = $row['S_DEALER_PRODUCTS'];
                  
                  $manufProducts =  str_replace('"',"", $manufProducts);
                  $manufProducts =  str_replace('[',"", $manufProducts);
                  $manufProducts =  str_replace(']',"", $manufProducts); //1,2,3
                  $dealerProducts =  str_replace('"',"", $dealerProducts);
                  $dealerProducts =  str_replace('[',"", $dealerProducts);
                  $dealerProducts =  str_replace(']',"", $dealerProducts);//4,5,6
                  $dealerProductsConcat = ','.$dealerProducts;
                  if($dealerProductsConcat ==  ',') {
                     $dealerProductsConcat = '';
                  }
                  $concatString = $manufProducts . $dealerProductsConcat;
                  if (startsWith($concatString, ",")) {
                    $concatString = $dealerProducts;
                  }

                  $sql = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID NOT IN (".$concatString.") AND `JOB_WORKERS` != 1 AND FOLLOWUP = 'YES'";
                  $select = mysqli_query($conn, $sql);
                  $productName = '';
                  while($rows = mysqli_fetch_array($select)){
                    $productName = $productName . $rows['PRODUCT_NAME'] . "<br>";
                  }
                  
                  
                  if ($productName == '') {
                      echo "NILL";     
                    }else{
                      echo $productName;
                      echo "<br>";
                    }

                ?>
                  

                </td>

               <td style="color:#0c1211";><a href="javascript:edt_id('<?php echo $row["S_ID"]; ?>')">
                <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                  <i class="material-icons" style="margin-left: -5px;">
                    edit
                  </i>
                </button></a></td>

              <!-- <td class="contact-delete">
                
                  <input type="hidden" name="S_ID" value="<?php echo $row['S_ID']; ?>">
                    <input type="submit" name="Delete" value="Delete" class="btn btn-primary"> -->
                    <!-- <i class="material-icons">
                    delete_forever
                    </i> 

                    <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-s-id="<?php echo $row['S_ID']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                      <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
                    </button>
                
              </td> -->

           </tr>
        </tbody>

<?php
} }
?>
        </table>
                
</div>
 </div>

      </div>
    </section>
  </div>
</div>
</div>

<script>

function edt_id(id) {
    if(confirm('Sure to GO ?')) {
        window.location.href='sales_customer_assign_update.php?edit_id='+id;
    }
}

function Vcount() {
var oTable = document.getElementById('productTable');
var totalRows = document.getElementById("productTable").rows.length;
var totalCol = 3; // enter the number of columns in the table minus 1 (first column is 0 not 1)
//To display all values
for (var x = 0; x <= totalRows; x++) {
    if(oTable && oTable.rows[x] && oTable.rows[x].cells[4]) { // WHERE 4 IS THE PRODUCT NEED TO BE ADDED COLUMN
      let text = oTable.rows[x].cells[4].innerHTML;
      if(text.trim() == 'NILL') {
        oTable.deleteRow(x);
        Vcount();
      }
    }
    
  }

  let sNo = 1;
  for (var x = 1; x <= totalRows; x++) {
    if(oTable && oTable.rows[x] && oTable.rows[x].cells[0]) { // WHERE 3 IS THE PRODUCT NEED TO BE ADDED COLUMN
      oTable.rows[x].cells[0].innerHTML = sNo;
      sNo = sNo + 1;
    }
  }
}


$(document).ready(function(){
  Vcount(); //DELETE THE NILL VALUES COLUMN FORM THE TABLE
});


</script>

</section>




</section>

</body>
</html>


