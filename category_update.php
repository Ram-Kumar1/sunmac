<?php
session_start();
include 'db_connect.php';
if(isset($_GET['PRODUCT_ID']) & !empty($_GET['PRODUCT_ID'])){
        
      $id3 = $_GET['PRODUCT_ID'];    
     $show=mysqli_query($conn,"select * from category where PRODUCT_ID = '$id3' ");
         $row=mysqli_fetch_array($show);     
           }
        ?>
  <script>
    var followUp =  <?php echo "'" . $row['FOLLOWUP']. "'"; ?>;
  </script>
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
  <body>
  <?php include 'header.php'; ?>

  <section id="main-content">
    <section class="wrapper">
        <div class="form-w3layouts">
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                             CATEGORY UPDATE
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


    <form action="categoryUpdateDetails.php" method="post" role="form"  enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="product_name"><h4>Product Name</h4></label>
            <input type="text" class="form-control" id="product_name" placeholder="Enter productname" name="PRODUCT_NAME" value="<?php echo $PRODUCT_ID = $row['PRODUCT_NAME']?>">
          <input type="hidden" name="PRODUCT_ID" id="PRODUCT_ID" value="<?php echo $row['PRODUCT_ID']?>" >
        </div>


        <div class="form-group">
            <label for="prod_desc"><h4>Product Description</h4></label>
            <input type="text" class="form-control" id="product_desc" placeholder="Enter ProductDescription" name="PRODUCT_DESC" value="<?php echo $PRODUCT_ID = $row['PRODUCT_DESC']?>">
        </div>
        <div class="form-group">
               <input type="hidden" name="JOB_WORKERS" value="">
        </div>

        <div class="form-group">
            <label for="prod_image"><h4>Product Image</h4></label>
            <?php echo '<img class="img-responsive" src="data:image/jpeg;base64,'.base64_encode($row['PRODUCT_IMAGE']).'"/>'?>
            <br>
            <input type="file" class="form-control" placeholder="Enter ProductImage" name="PRODUCT_IMAGE" value=" ">
        </div>

        <div class="col-sm-12">
                                      <div class="form-group">
                                      <label for="sel1">Show On Followup</label>
                                      <select class="form-control" id="follow-up" name="followUp">
                                        <option value="">-- SELECT --</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                      </select>
                                    </div>
                                    </div>
        <div class="form-group">
                                    <div class="row">
                                    <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for="amt">Machine's:</label>
                                        <select type="text" class="form-control" id="amount" name="MACHINE_NAME" required >
                                          <option value="0">-- SELECT MACHINE --</option>
                                          <?php
                                          $selectCity = "SELECT MACHINE_NAME,MACHINE_ID FROM `machine_details`";
                                          if($result = mysqli_query($conn, $selectCity)){
                                            if(mysqli_num_rows($result) > 0){ 
                                              while($row = mysqli_fetch_array($result)) {

                                              $data =  $row['MACHINE_NAME'];
                                              $id =   $row['MACHINE_ID'] ;

                                                ?>
                                                <option value="<?php echo $id =   $row['MACHINE_ID'] ; ?>" ><?php echo $data ?></option>
                                                <?php
                                              }
                                            }
                                          }
                                          ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                        <button style="margin-top: 25px;" type="button" class="btn btn-primary" id="btn-create" onclick="createRow()">
                                        <i class="material-icons">add</i>
                                        </button>
                                      </div>
                                    </div>
                                    </div>
                                   </div>
                                   <table class="table" id="product-table">
                                    <thead>
                                      <tr style="color:#0c1211";>
                                        <th style="color:#0c1211";>Machine Id</th>
                                        <th style="color:#0c1211";>Machine Name</th>
                                        <th style="color:#0c1211";>Remove</th>
                                        <th>&nbsp;</th>
                                      </tr>
                                    </thead>
                                    <tbody id='table-body'>
                                      
                                    </tbody>
                                  </table>
                                  


                                    
        <button type="submit" name="update" class="btn btn-primary" onclick="demo()" > Update </button>  

    </form>
                        </div>
                      </div>

  
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>
  <script type="text/javascript">    

function demo(){

    var categoryId = document.getElementById('PRODUCT_ID').value;
    var machineName = [];  
    var count = 0;
    var oTable = document.getElementById('product-table');

    //gets rows of table
    var rowLength = oTable.rows.length;
    //loops through rows    
    for (i = 1; i < rowLength; i++){
      //gets cells of current row  
       var oCells = oTable.rows.item(i).cells;
       //gets amount of cells of current row
       var cellLength = oCells.length;
       //loops through each cell in current row
       for(var j = 0; j < cellLength; j++){
              if(j === 0){
                  machineName[count] = oCells.item(j).innerHTML;
                  count++;
              }
              // get your cell info here
              /*var cellVal = oCells.item(j).innerHTML;*/            
           }
    }
        console.log(machineName);
        var machinecount = machineName.length;

      $.ajax({

       type: 'post',
       url: 'fetch_data.php',
       data: {
        updateupdate:'1',
        categoryid:categoryId,
        machineName: machineName.toString(),
        machinecount: machinecount,
       },
       success: function (response) {
       alert('Successfully'); 
       }
       });
// end of ajax
  }

function createRow(machineId, machineName) {
   var table = document.getElementById('product-table');
   var tableBody = document.getElementById('table-body');
   var tr = document.createElement('TR');
   
   var td = document.createElement('TD');
   var tdAmt = document.createElement('TD');
   var tdMachineName = document.createElement('TD');
   var tdDelBtn = document.createElement('TD');
   
   let dropDown;
   if(machineId && machineName) {
      // DO NOTHING
      dropDown = "1";
   } else {
      dropDown = document.getElementById('amount');
   }

   if(dropDown.value == "0" && !machineId && !machineName) {
      alert("Please select any machine");
      return false;
   } else {

   let cellTextAmt1;
   let cellTextMachineName;

   if(machineId && machineName) {
      cellTextAmt1 = document.createTextNode(machineId);
      cellTextMachineName = document.createTextNode(machineName);
   } else {
      cellTextAmt1 = document.createTextNode(dropDown.value);
      cellTextMachineName = document.createTextNode(dropDown.options[dropDown.selectedIndex].text); 
   }
   
   var btn = document.createElement("BUTTON");
   btn.className ="btn btn-primary btn-xs";
   btn.onclick = function() {
    deleteRow(this);
   };
   btn.setAttribute('id', 'btn-create');
   let i = document.createElement('i');
   i.className = 'material-icons material-icons-fonts';
   let text = document.createTextNode('delete');
   i.appendChild(text);
   btn.appendChild(i);
   
   tdAmt.appendChild(cellTextAmt1);
   tdMachineName.appendChild(cellTextMachineName);
   tdDelBtn.appendChild(btn);
   
   tr.appendChild(tdAmt);
   tr.appendChild(tdMachineName);
   tr.appendChild(tdDelBtn)
   
   tableBody.appendChild(tr);
   table.appendChild(tableBody);
   document.getElementById("amount").value = 0;
}
}

function deleteRow(row) {
  var i = row.parentNode.parentNode.rowIndex;
  document.getElementById('product-table').deleteRow(i);
}

var createMachineTableOnUpdate = function() {

};

</script>


<script type="text/javascript">
  $( document ).ready(function() {
      $("#follow-up").val(followUp);

      <?php
          $select = "select * from category_machine where CATEGORY_ID = '$id3' ";
          $machineIdQuery = mysqli_query($conn,$select);
          $row = mysqli_fetch_array($machineIdQuery);
          $machines = $row['MACHINE_ALLOCATION'];
          $machineArr = explode(",", $machines);
          
          foreach ($machineArr as $machineId) {
            $machineNameQuery = mysqli_query($conn, "SELECT * FROM `machine_details` WHERE `MACHINE_ID`= $machineId");
            $data = mysqli_fetch_array($machineNameQuery);
            $machineName = $data['MACHINE_NAME'];

?>
            createRow(<?php echo $machineId.", '".$machineName."'"; ?>);
<?php

          }


      ?>
     createMachineTableOnUpdate();
  });


</script>


  </body>
  </html>

