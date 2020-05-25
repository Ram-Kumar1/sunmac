<?php
include_once 'db_connect.php';
session_start();

if(isset($_GET['edit_id']))
{
  $sql_query="SELECT * FROM sales_customer WHERE S_ID=".$_GET['edit_id'];
  $result_set=mysqli_query($conn,$sql_query);
  $fetched_row=mysqli_fetch_array($result_set);
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

</style>
</head>
<script type="text/javascript">
  var productId = [];
  var productName = [];
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
                        CUSTOMER 
                    </header>
                    <div class="panel-body">
                        <div class="position-center">

                                
                                <div class="form-group">
                                    <label for="mail">Customer Name</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_NAME']; ?>" name="today_date" required disabled>
                                     <input type="hidden" class="form-control" id="S_ID" value="<?php echo $fetched_row['S_ID']; ?>"  disabled>
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mobile no1</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MOBILE']; ?>" name="S_MOBILE" required disabled>
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mobile no2</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_ALTERNATE_MOBILE']; ?>" name="S_ALTERNATE_MOBILE" required disabled>
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mail</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MAIL']; ?>" name="S_MAIL" required disabled>
                                </div>


                               <div class="form-group">
                                <label for="sel2">PRODUCT'S</label>
                                
                                <?php

                                $select=mysqli_query($conn,"SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE JOB_WORKERS = 0 AND FOLLOWUP='YES'");
                                while($row=mysqli_fetch_array($select))
                                {

                                  ?>
                                 <script>
                                    productId.push(<?php echo $row['PRODUCT_ID'] ?>);
                                    productName.push('<?php echo $row['PRODUCT_NAME'] ?>');
                                  </script>
                                <br>
                                <div class="rad">

                                <label for="sel2" value="<?php echo $row['PRODUCT_ID'] ?>" ><h4><?php echo $row['PRODUCT_NAME'] ?></h4></label>
                                <br>

                                <input id="radio-one" class="form-radio"  type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_NAME'] ?>" value='<?php echo $row['PRODUCT_ID']."_Manufacturer" ?>' required >

                                <label class="rad-lab" for="<?php echo $row['PRODUCT_ID'] ?>">Manufacturer</label>


                                <input id="radio-one" class="form-radio" type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_NAME'] ?>" value='<?php echo $row['PRODUCT_ID']."_Dealer" ?>' required >

                                <label class="rad-lab" for="<?php echo $row['PRODUCT_ID'] ?>">Dealer</label>

                                </div>
                                <?php
                                
                                }
                                ?>
                                </div>   

  
          
   <input type="button" class="btn btn-primary" onclick="demo()" value="Submit" />
                   

            
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


function demo(){
 
let s_id = document.getElementById('S_ID').value;
 var value1 = [];


  for(let i=0; i<productName.length; i++) {
    debugger;

        var choosenVal = $("input[name='" + productName[i] + "']:checked").val(); // 18_Manufacturer | steel_Dealer
        if (choosenVal == undefined || choosenVal == null || choosenVal == '' ) {
          alert('Please choose value '+ productName[i]);
          return false;
        }else{
           value1.push(choosenVal);
        }
    
  }
  
var machinecount = value1.length;
debugger;
console.log(s_id);


      $.ajax({
       type: 'post',
       url: 'fetch_data.php',
       data: {
        s_id:s_id,
        machineName: value1.toString(),
        machinecount: machinecount
       },
       success: function (response) {
          
       }
       });
window.location.href='sales_customer.php';
  }


</script>


</section>

</body>
</html>


