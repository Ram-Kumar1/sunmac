<?php
include_once 'db_connect.php';
session_start();

if(isset($_GET['edit_id']))
{

$id3 = $_GET['edit_id'];  

	$sql_query="SELECT * FROM sales_customer WHERE S_ID=".$_GET['edit_id'];
	$result_set=mysqli_query($conn,$sql_query);
	$fetched_row=mysqli_fetch_array($result_set);
  $manufArray = $fetched_row['S_MANUFACTURER_PRODUCTS'];
  gettype($manufArray);
  $dealerArray = $fetched_row['S_DEALER_PRODUCTS'];

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

          
 $sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', '$S_REGISTRATION_DATE')";
if (mysqli_query($conn, $sql)) {
                ?>
      <script type="text/javascript">
        alert('Update Successfully');
        window.location.href='sales_customer.php';
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
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="js/jquery2.0.3.min.js"></script>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
.form-radio
{
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     display: inline-block;
     position: relative;
     background-color: #f1f1f1;
     color: #666;
     top: 10px;
     height: 30px;
     width: 30px;
     border: 0;
     border-radius: 50px;
     cursor: pointer;     
     margin-right: 7px;
     outline: none;
}
.form-radio:checked::before
{
     position: absolute;
     font: 13px/1 'Open Sans', sans-serif;
     left: 11px;
     top: 7px;
     content: '\02143';
     transform: rotate(40deg);
}
.form-radio:hover
{
     background-color: #f7f7f7;
}
.form-radio:checked
{
     background-color: #f1f1f1;
}
label
{
     font: 300 16px/1.7 'Open Sans', sans-serif;
     color: #666;
     cursor: pointer;
} 


/*Style */

</style>
</head>
<script type="text/javascript">
  var manufArray = <?php echo $manufArray ?>;
  var dealerArray = <?php echo $dealerArray ?>;
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
                        CUSTOMER Update
                    </header>
                    <div class="panel-body">
                        <div class="position-center"> 

<script>
var productId = [];
var productName = [];
</script>
                                <div class="form-group">
                                    <label for="mail">Customer Name</label>
                          <input type="text" class="form-control" value="<?php echo $fetched_row['S_NAME']; ?>" id="S_NAME" required >
                                     <input type="hidden" class="form-control" id="S_ID" id="S_ID" value="<?php echo $fetched_row['S_ID']; ?>" disabled >
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mobile no1</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MOBILE']; ?>" id="S_MOBILE" required >
                                </div>

                                

                                <div class="form-group">
                                    <label for="mail">Customer Mail</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MAIL']; ?>" id="S_MAIL" required >
                                </div>
                                      
                                  <div class="form-group">
                                    <label for="mail">Customer Address</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_ADDRESS']; ?>" id="S_ADDRESS" required >
                                  </div>

                                    <?php
                                    $CITY = $fetched_row['S_CITY'];
$selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
?>
                                <div class="form-group">
                                    <label for="sel1">LOCATION </label>
                                    <select type="text" class="form-control" id="S_CITY" name="S_CITY">
                                      <option value="">-- SELECT LOCATION --</option>
                                      <?php
                                        if($result = mysqli_query($conn, $selectCity)){
                                          if(mysqli_num_rows($result) > 0){ 
                                            while($row = mysqli_fetch_array($result)) {
                                      ?>
                                              <option value="<?php echo $row['CITY_NAME']?>" ><?php echo  $row['CITY_NAME'] ?></option>
                                      <?php
                                            }
                                          }
                                        }
                                      ?>
                                    </select>
                              </div>
<script type="text/javascript">
  $("#city").val('<?php echo $fetched_row['S_NAME']; ?>');
</script>
                                <div class="form-group">
                                <label for="sel2">PRODUCT'S</label>
                                
                                <?php

                                $select=mysqli_query($conn,"SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE JOB_WORKERS = 0");
                                while($row=mysqli_fetch_array($select))
                                {

                                  ?>
                                  <script>
                                  productId.push(<?php echo $row['PRODUCT_ID'] ?>);
                                  productName.push('<?php echo $row['PRODUCT_NAME'] ?>');
                                  </script>

                                  
                                <br>
                                <div>

                                <label for="sel2" value="<?php echo $row['PRODUCT_ID'] ?>" ><h4><?php echo $row['PRODUCT_NAME'] ?></h4></label>
                                <br>

                                <input id="radio-one" class="form-radio" type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_NAME'] ?>" value='<?php echo $row['PRODUCT_ID']."_Manufacturer" ?>' required >

                                <label for="<?php echo $row['PRODUCT_ID'] ?>" >Manufacturer</label>

                                <input id="radio-one" class="form-radio" type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_NAME'] ?>" value='<?php echo $row['PRODUCT_ID']."_Dealer" ?>' >

                                <label for="<?php echo $row['PRODUCT_ID'] ?>">Dealer</label>

                                </div>
                                <?php

                                }
                                ?>
                                </div>    
                                    <input type="button" class="btn btn-primary" onclick="update_demo()" value="Submit" />

                            <br>
                            <br>
                        </div>
<p id="city"></p>
      </div>
    </section>
  </div>
</div>
</div>


</section>

<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/jquery.scrollTo.js"></script>

<script type="text/javascript">


$(document).ready(function() {
  debugger;
    document.getElementById('S_CITY').value = "<?php echo $CITY; ?>";
});

function update_demo (){
debugger;
let s_id = document.getElementById('S_ID').value;
let s_name = document.getElementById('S_NAME').value;
let s_mobile = document.getElementById('S_MOBILE').value;
let S_MAIL = document.getElementById('S_MAIL').value;
let s_address = document.getElementById('S_ADDRESS').value;
let s_city = document.getElementById('S_CITY').value;
let s_update=1;

 if(s_name == "") {
      alert('Name is mandatory. Please fill it');
      return false;
    } else if(s_mobile == "") {
      alert('Mobile Number is mandatory. Please fill it');
      return false;
    } else if(s_city == "") {
      alert('City is mandatory. Please fill it');
      return false;
    }else if(s_address == "") {
      alert('Address is mandatory. Please fill it');
      return false;
    }  
    else if(S_MAIL == "") {
      alert('Mail Id is mandatory. Please fill it');
      return false;
    } else if(s_mobile != "") {
      if(s_mobile.length != 11) {
        alert('11 numbers must be there for Alternate Mobile Number');
        return false;
      }
    } 


 var value1 = [];
  for(let i=0; i<productName.length; i++) {
     var choosenVal = $("input[name='" + productName[i] + "']:checked").val(); // 18_Manufacturer | steel_Dealer
      if (choosenVal == undefined || choosenVal == null || choosenVal == '' ) {
        alert('Please choose value '+ productName[i]);
        return false;
      }else{
         value1.push(choosenVal);
      }
  }

var machinecount = value1.length;
console.log(value1);
debugger;


      $.ajax({
       type: 'post',
       url: 'fetch_data.php',
       data: {
        s_id_up:s_id,
        s_update:s_update,
        s_name:s_name,
        s_mobile:s_mobile,
        S_MAIL:S_MAIL,
        s_address:s_address,
        s_city:s_city,
        machineName: value1.toString(),
        machinecount: machinecount
       },
       success: function (response) {
       alert('Update Successfully');
       window.location.href = "sales_customer_all.php"
       }
       });

  }



  var checkRadioButton = function() {
    let mArr = [];
    let dArr = [];

    if(manufArray && manufArray.length > 0) {
      for(let i=0; i<manufArray.length; i++) {
        mArr.push(parseInt(manufArray[i]));
        $('input[type="radio"][value="' + manufArray[i] + '_Manufacturer"]').prop("checked", true);
      }
    }
    
    if(dealerArray && dealerArray.length > 0) {
      for(let j=0; j<dealerArray.length; j++) {
        dArr.push(parseInt(dealerArray[j]));
        $('input[type="radio"][value="' + dealerArray[j] + '_Dealer"]').prop("checked", true);
      }
    }

    let productIdDuplicate = productId;
    let filteredArray = productIdDuplicate.filter(function(x) { 
          return mArr.indexOf(x) < 0;
        });
        filteredArray = filteredArray.filter(function(x) { 
          return dArr.indexOf(x) < 0;
        });
        debugger;
    for(let z = 0; z<filteredArray.length;z++){
        $('input[type="radio"][id="' + filteredArray[z] + '"]').parent().remove();

    
         
    }
    
  }
  checkRadioButton();

</script>

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

$(document).ready(function(){
  $("#S_CITY").val('<?php echo $fetched_row['S_CITY']; ?>');
});


</script>


</section>

</body>
</html>


