<?php
session_start();
include 'db_connect.php';

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
	   

$query = "SELECT * FROM `sales_customer` WHERE S_NAME = '$S_NAME'  ";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * FROM `sales_customer` WHERE S_MOBILE = $S_MOBILE ";
$result1 = mysqli_query($conn, $query1);
$demo = mysqli_num_rows ( $result );
$demo1 = mysqli_num_rows ( $result1 );

if ( mysqli_num_rows ( $result ) == 0 && mysqli_num_rows ( $result1 ) == 0 )
{

$sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', '$S_REGISTRATION_DATE')";
if (mysqli_query($conn, $sql)) {
                
                ?>
      <script type="text/javascript">
          alert("Customer Added Successfully");
      </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            } 

}else{

if ( mysqli_num_rows ( $result ) > 0){
?>
<script type="text/javascript">
alert('This Customer Name already exists');
</script>
<?php
}
if ( mysqli_num_rows ( $result1 )  > 0 ) {
?>
<script type="text/javascript">
alert('This Customer Mobile No already exists');
</script>
<?php 
}  


}       
}

  ?>

<!DOCTYPE html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<title>Add Customer</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<?php
include 'demo.css';
?>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery2.0.3.min.js"></script><script src="js/raphael-min.js"></script>
<script src="js/morris.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>

</head>
<style type="text/css">
  .email-max-width {
    word-wrap: break-word;
    max-width: 150px;
  }

</style>

<script type="text/javascript">
  var validateInput = function(input) {

    let parentElement = input.parentElement;
    let inputId = input.id;
    let inputValue = input.value;
    
    if(inputId == "mob_no" || inputId == "alter_mob_no") {
      if(inputValue.length != 11) {
        parentElement.className += " has-error";
        alert('Mobile Number is Not equal to 11 Digit')
      } else {
        parentElement.classList.remove("has-error");
      }

    } else if(inputId == "s_mail") {
      let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
       if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputValue) == false) {
            parentElement.className += " has-error";
        } else {
            parentElement.classList.remove("has-error");
        }

    }

  };

  var validate = function() {
    debugger;
    let mobile = document.getElementById('mob_no').value;
    let alternateMobile = document.getElementById('alter_mob_no').value;
    let mail = document.getElementById('s_mail').value;
    let city = document.getElementById('sel1').value;
     
     if(city == "") {
        alert("City is mandatory field. Please choose it");
        return false;
     }

     if(mobile.length != 11) {
        alert('Mobile Number is incorrect. Please correct it.');
        return false;
     }

     if(alternateMobile != "") {
      if(alternateMobile.length != 11) {
        alert('Alternate Mobile Number is incorrect. Please correct it.');
        return false;
      }
     }

     let reg = /(.+)@(.+){2,}\.(.+){2,}/;
     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail) == false) {
        alert('Invalid Mail Address');
        return false;
     } 
     return true;

  };
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
                           CUSTOMER DETAILS
                    </header>
                    <div class="panel-body">


                        <div class="position-center">
                            <form  name="myForm"  data-toggle="validator"  method="post" role="form" onsubmit="return validate(this)">
                                
                              <div class="form-group">
                                    <label for="s_name">Customer Name * </label>
                                    <input required type="text" class="form-control" id="s_custname" placeholder="Enter customername" name="S_NAME">
                                </div>
                                <div class="form-group">
                                    <label for="mob_no">Mobile Number *</label>
                                    <input type="number" class="form-control" id="mob_no" onchange="validateInput(this);" placeholder="Enter mobile number" name="S_MOBILE" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="mob_no">Alternate Mobile Number </label>
                                    <input type="number" class="form-control" id="alter_mob_no" placeholder="Enter mobile number" name="S_ALTERNATE_MOBILE" onchange="validateInput(this);">
                                </div>

                                <div class="form-group">
                                    <label for="mail">Email *</label>
                                    <input required type="email" class="form-control" id="s_mail" placeholder="Enter email" name="S_MAIL" onchange="validateInput(this);" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="adrress">Adress *</label>
                                    <input required type="text" class="form-control" id="address" placeholder="Enter address" name="S_ADDRESS">
                                </div>
<?php
$selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
?>
                                <div class="form-group">
                                    <label for="sel1">Location *</label>
                                    <select type="text" class="form-control" id="sel1" name="S_CITY">
                                      <option value="">-- SELECT Location --</option>
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
                              <button type="submit" class="btn btn-info" name="submit" onClick="return validate();" >Submit</button>
                            </form>
                            <br>
                            <br>
                        </div>
<?php
$sql = "SELECT S_ID,S_NAME,S_MOBILE,S_MAIL,S_CITY FROM sales_customer where S_NEED_TO_FOLLOWED = '0' ";
if($result = mysqli_query($conn, $sql)){
    //if(mysqli_num_rows($result) > 0){ 
?>
<div class="table-responsive">
        <table class="table">
          <thead>
           <tr style="color:#0c1211";>
                <th style="color:#0c1211";>S NO</th>
                <th style="color:#0c1211";>CUSTOMER NAME</th>
                <th style="color:#0c1211";>MOBILE NUMBER</th>
                <th class="email-max-width" style="color:#0c1211";>EMAIL</th>
                <th style="color:#0c1211";>LOCATION</th>
                <th style="color:#0c1211";>Manuf. & Dealer</th>
                <th style="color:#0c1211";>Edit</th>
                <th style="color:#0c1211";>Delete</th>
            </tr>
         </thead>
       <?php 
       $i=1;
       while($row = mysqli_fetch_array($result)){
       ?>
       <tbody>
          <tr>
               <td style="color:#0c1211";><?php echo $i++ ?></td>
               <td style="color:#0c1211";><?php echo $row['S_NAME']?></td>
               <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
               <td class="email-max-width" style="color:#0c1211";><?php echo $row['S_MAIL']?></td>
               <td style="color:#0c1211";><?php echo $row['S_CITY']?></td>
               <td>
                <a href="javascript:edt_id('<?php echo $row["S_ID"]; ?>')">
                  <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                    <i class="material-icons" style="margin-left: -5px;">update</i>
                  </button>
                </a>
              </td>
              <td>
                <a href="javascript:edt_id1('<?php echo $row["S_ID"]; ?>')">
                  <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                    <i class="material-icons" style="margin-left: -5px;">edit</i>
                  </button>
                </a>
               </td>
               <td>
                <a href="javascript:deleteCustomer(<?php echo $row["S_ID"]; ?>)">
                  <button type="button" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                    <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
                  </button>
                </a>
               </td>
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

function edt_id(id)
{
    if(confirm('Sure to GO ?'))
    {
        window.location.href='S_manufacture_dealer.php?edit_id='+id;
    }
}

function edt_id1(id)
{
    if(confirm('Sure to GO ?'))
    {
        window.location.href='sales_customer_update.php?edit_id1='+id;
    }
}

var deleteCustomer = function(sNo) {
    let del = confirm("Are you Sure to delete?");
    if(!del) {
      return false;
    }
    debugger;
    // let cityName = $(deleteButton).attr('data-city-name');
     $.ajax({
       type: 'post',
       url: 'deleteCustomer.php',
       data: {
        S_NO: sNo,
       },
       success: function (response) {
       alert('Customer is deleted Successfully');
       // window.location.reload();
       window.location.href = "sales_customer.php"
       }
    });
  }


</script>

</section>


<script type="text/javascript">

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


</section>

</body>
</html>


