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
          
 $sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', $S_REGISTRATION_DATE')";
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
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>  
<?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>
<style type="text/css">
::-webkit-input-placeholder{
  color: #ddede0 !important;
  opacity: 1; /* Firefox */
}

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
/*
td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
*/
       table td { width:200px; word-wrap:break-word;}

</style>
<style type="text/css">
  .email-max-width {
    word-wrap: break-word;
    max-width: 150px;
  }

</style>
</head>



<script type="text/javascript">

var addSerialNumber = function () {
    $('table tr:visible').each(function(index) {
        $(this).find('td:nth-child(1)').html(index);
    });
};




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
  <?php
$sql = "SELECT * FROM sales_customer where S_NEED_TO_FOLLOWED = '1' ORDER BY S_NAME ";
if($result = mysqli_query($conn, $sql)){
    //if(mysqli_num_rows($result) > 0){ 
?>
<?php include 'header.php'; ?>

<section id="main-content">
  <section class="wrapper">
       <div class="form-w3layouts">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Customers
                    </header>
<br>
 
<div class="row">

  <div class="col-sm-6">
    <center>
    <label> Product :  <span id="product_view"></span></label>
     <select type="text" class="form-control" placeholder="Dealer" id="product" name="product" >
      <option value="">-- SELECT Product --</option>
      <?php
       $selectCity = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE JOB_WORKERS = 0";
        if($results = mysqli_query($conn, $selectCity)){
          if(mysqli_num_rows($results) > 0){
            while($rows = mysqli_fetch_array($results)) {
      ?>
              <option value="<?php echo $rows['PRODUCT_NAME']?>" ><?php echo $rows['PRODUCT_NAME'] ?></option>
      <?php
            }
          }
        }
      ?>
    </select>
    </center>
  </div>


  <div class="col-sm-6">
    <center>
    <label>Dealer / Manufacture :  <span id="type"></span> </label>
     <select type="text" id="customer-select" class="form-control" placeholder="Manufacture"  onchange="man(this)" name="CITY">
      <option value="">-- SELECT --</option>
              <option value="Dealer" >Dealer</option>
              <option value="Manufacture" >Manufacture</option>
    </select>
    </center>
  </div> 
<div class="row">

    <div class="col-sm-3">
      &nbsp;
    </div>

        <div class="col-sm-6" style="margin-top: 15px;">
        <center>
        <label> Location : <span id="location_view"> </label>
         <select type="text" class="form-control"  name="location" id="locationValue" onchange="locationChange(this);" >
          <option value="">-- SELECT Location --</option>
          <?php
         $selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
            if($results = mysqli_query($conn, $selectCity)){
              if(mysqli_num_rows($results) > 0){
                while($rows = mysqli_fetch_array($results)) {
          ?>
                  <option value="<?php echo $rows['CITY_NAME']?>" ><?php echo $rows['CITY_NAME'] ?></option>
          <?php
                }
              }
            }
          ?>
        </select>
        </center>
      </div>

    <div class="col-sm-3">
      
      <input style="margin-top: 15px;" class="btn-primary" type="button" value="View All Customer" onClick="window.location.reload()">
    </div>
</div>


</div>

<script type="text/javascript">


     function locationChange(bb){
          debugger;
              var product = bb.value;
              let value = document.getElementById('location').value = product;
              // document.getElementById('locationValue').value = "";
              document.getElementById('man').value = "";
              document.getElementById('Dealer').value = "";
              document.getElementById('location_view').innerHTML = value;
              $('#location').keyup();
      }
      

  function man(aaa){
      debugger;
      $('#Dealer').val("");
      $('#man').val("");
      var product = document.getElementById('product').value;
      if(product == "") {
        document.getElementById('customer-select').value = "";
        alert("Please choose any products to perform the action");
        return;
      } else {
        $("#locationValue").val("");
        $("#location_view").text('');
        var type = aaa.value;
        if(type == 'Manufacture' ){
          let value = document.getElementById('man').value = product;
          document.getElementById('customer-select').value = "";
          document.getElementById('product').value = "";
          document.getElementById('location').value = "";
          document.getElementById('product_view').innerHTML = value;
                    document.getElementById('type').innerHTML = "Manufacture";
          $('#man').keyup();
        } else {
          let value = document.getElementById('Dealer').value = product;
          document.getElementById('customer-select').value = "";
          document.getElementById('product').value = "";
          document.getElementById('location').value = "";
          document.getElementById('product_view').innerHTML = value;
                    document.getElementById('type').innerHTML = "Dealer";
          $('#Dealer').keyup();
        }
      }
  }

 
</script>

  
                   
        <div class="panel panel-primary filterable" >
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table" style="height:300px;overflow: scroll;">
                <thead>
                    <tr class="filters">
                    <th><input type="text" class="form-control col-sm-1" placeholder="S NO" disabled></th>
                    <th><input type="text" class="form-control col-sm-1" placeholder="NAME" disabled></th>
                    <th><input type="text" class="form-control col-sm-1" placeholder="EMAIL" disabled></th>
                    <th><input type="text" class="form-control col-sm-3" id="man" placeholder="Manufacture" disabled>

                    </th>
                    <th><input type="text" class="form-control col-sm-3" id="Dealer" placeholder="Dealer" disabled></th>
                    <th><input type="text" class="form-control col-sm-1" id="location" placeholder="Location" disabled></th>
                    <th><input type="text" class="form-control col-sm-1" placeholder="Update" disabled></th>                
                    </tr>
                </thead>
                <tbody>
       
<?php 
$jj=1;
while($row = mysqli_fetch_array($result)){
?>

<tr>
  <td class="col-sm-1" style="color:#0c1211";><?php echo $jj; ?></td> <?php $jj=$jj+1; ?>
  <td class="col-sm-1" style="color:#0c1211";><?php echo $row['S_NAME']; ?> </td>
 
  <?php
   $mail_id = $row['S_MAIL'];
   if($mail_id == 'sample@gmail.com'){
    ?>

<td class="col-sm-1" style="color:#0c1211;" >
  <i class='fas fa-phone'></i>
  <?php echo $row['S_MOBILE'];  echo"<br>
<p style='color:red';> ".$row['S_MAIL']."</p>"; ?>
</td>
   <?php
   }else{
    ?>
   <td class="col-sm-1" style="color:#0c1211;max-width:50px;table-layout: auto">
     <i class='fas fa-phone'></i>
  <?php echo $row['S_MOBILE'];  echo"<br>
     <p> ".$row['S_MAIL']."</p>"; ?>

   </td>
   <?php
   }
?>
   
  <td class="col-sm-3" style="color:#0c1211";><?php 
                $man = $row['S_MANUFACTURER_PRODUCTS'];
                $man =  str_replace('"',"", $man);
                $man =  str_replace('[',"", $man);
                $man =  str_replace(']',"", $man);
                $man = explode(',',$man); // 1,2,3
                $size = sizeof($man);
                if($man ==  ',') {
                $man = '';
                }

                for($i=0; $i<$size; $i++) {
                $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                $insert = mysqli_query($conn, $pur);
                $rows = mysqli_fetch_array($insert);
                if (mysqli_num_rows($insert)==0) { 
                  $productName = "";
                } else {
                  $productName = $rows['PRODUCT_NAME'];
                }
                
                if ($productName == '') {
                echo "NILL";     
                }else{
                echo $productName;
                echo "<br>";
                }
                }

                ?></td>
  <td class="col-sm-3" style="color:#0c1211";><?php 
                  $man = $row['S_DEALER_PRODUCTS'];
               $man =  str_replace('"',"", $man);
                $man =  str_replace('[',"", $man);
                $man =  str_replace(']',"", $man);
                $man = explode(',',$man); // 1,2,3
                $size = sizeof($man);

                if($man ==  ',') {
                     $man = '';
                  }

                for($i=0; $i<$size; $i++) {
                $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                $insert = mysqli_query($conn, $pur);
                $rows = mysqli_fetch_array($insert);
                $productName = $rows['PRODUCT_NAME'];
                if ($productName == '') {
                echo "NILL";     
                }else{
                echo $productName;
                echo "<br>";
                }
                }

                ?></td>
                <td class="col-sm-1" style="color:#0c1211";><?php echo $row['S_CITY']; ?> </td>

  <td class="col-sm-1">
    <a href="javascript:edt_id('<?php echo $row["S_ID"]; ?>')">
    <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
      <i class="material-icons" style="margin-left: -5px;">
        edit
      </i>
    </button></a>
        <br><br>
      <input type="hidden" name="S_ID" value="<?php echo $row['S_ID']; ?>">
        <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-s-id="<?php echo $row['S_ID']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
          <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
        </button>
        <br><br>
<a href="javascript:edt_id1('<?php echo $row["S_ID"]; ?>')">
    <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
      <i class="material-icons" style="margin-left: -5px;">
        remove_red_eye
      </i>
    </button></a>
    <br><br>
    <a href="javascript:followUp('<?php echo $row["S_ID"]; ?>')">
    <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
      <i class="material-icons" style="margin-left: -5px;">
        perm_phone_msg
      </i>
     </button></a>
  </td>
</tr>

<?php
} 
}
?>
                </tbody>
            </table>
        </div>
               

</section>
</section>

<script>

function edt_id(id) {
    if(confirm('Sure to GO ?')) {
        window.location.href='sales_customer_all_update.php?edit_id='+id;
    }
}

function edt_id1(id) {
    if(confirm('Sure to GO ?')) {
        window.location.href='sales_customer_all_view.php?edit_id='+id;
    }
}
var followUp = function(id) {
  $.ajax({
       type: 'post',
       url: 'insertFollowUp.php',
       data: {
        S_ID:id,
       },
       success: function (response) {
       alert('Data is added to followUp Successfully');
       // window.location.reload();
       debugger
       console.log(response);
       //window.location.href = "sales_customer_all.php"
       }
    });
};

function setNillValues() {
  debugger;
  var oTable = document.getElementById('productTable');
  var totalRows = document.getElementById("productTable").rows.length;
  var totalCol = 3; // enter the number of columns in the table minus 1 (first column is 0 not 1)
  //To display all values
  for (var x = 0; x <= totalRows; x++) {
    if(oTable && oTable.rows[x] && oTable.rows[x].cells[4]) { // WHERE 3 IS THE PRODUCT NEED TO BE ADDED COLUMN
      let text = oTable.rows[x].cells[4].innerHTML;
      debugger;
      if(text.trim() == '') {
        oTable.rows[x].cells[4].innerHTML = "NILL";
      }
    }
  }

  for (x = 0; x <= totalRows; x++) {
    if(oTable && oTable.rows[x] && oTable.rows[x].cells[5]) { // WHERE 3 IS THE PRODUCT NEED TO BE ADDED COLUMN
      let text = oTable.rows[x].cells[5].innerHTML;
      debugger;
      if(text.trim() == '') {
        oTable.rows[x].cells[4].innerHTML = "NILL";
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

$( document ).ready(function() {
    $(":input").bind("keyup", function(e) {
      addSerialNumber();
    });
});


</script>

</section>




</section>

</body>
</html>


