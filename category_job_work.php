<?php
  session_start();
  include 'db_connect.php';

  $sql1 = mysqli_query($conn,'SELECT MAX(PRODUCT_ID) FROM `category`');

  if(mysqli_num_rows($sql1) > 0){
     $rows = mysqli_fetch_array($sql1);
     $cateId = 1 + $rows['MAX(PRODUCT_ID)']; 
  }else{
  $cateId = 1 ;  
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
                        PRODUCT Job Work
              </header>
                <div class="panel-body">
                    <div class="position-center">

                      <form action="category_php.php" method="post" role="form"  enctype="multipart/form-data">

                                  <div class="form-group">
                                      <label for="p_name">Product Name</label>
                                      <input required type="text" class="form-control" id="product_name" placeholder="Enter product name" name="PRODUCT_NAME"  >
                                  <input type="hidden" name="PRODUCT_ID" id="PRODUCT_ID" value="<?php echo $cateId; ?>" >

                                  </div>
                                  <div class="form-group">
                                      <label for="p_mobile">Product Description</label>
                                      <input required type="text" class="form-control" id="product_desc" placeholder="Enter product description" name="PRODUCT_DESC" >
                                  </div>
                                  <div class="form-group">
                                      <label for="image">Product Image</label>
                                      <input required type="file" class="form-control" id="image" name="PRODUCT_IMAGE" accept="image/JPEG" >
                                  </div>
                                  <div class="form-group">
                                 
                            <input type="hidden" name="JOB_WORKERS" value="1">
                                  </div>
                                  <br>
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
                                      <tr>
                                        <th>Machine Id</th>
                                        <th>Machine Name</th>
                                        <th>Remove</th>
                                        <th>&nbsp;</th>
                                      </tr>
                                    </thead>
                                    <tbody id='table-body'>
                                      
                                    </tbody>
                                  </table>
                                  

                                  

                                  <input type="Submit" class="btn btn-info" value="Submit" onclick="demo()" name="submit">  


    
                            </form>
                          </div>
                          <br>
                          <br>

                           </div>
                        </div>    
                  </section>
                </div>
              </div>
            </div>
  </section>
                            
  


<script type="text/javascript">    

function demo(){

   debugger;
    var categoryId = <?php echo $cateId;  ?>;
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
        insert:'1',
        categoryId:categoryId,
        machineName: machineName.toString(),
        machinecount: machinecount
       },
       success: function (response) {
       alert('Successfully'); 
       }
       });
// end of ajax
  }

function createRow() {
   var table = document.getElementById('product-table');
   var tableBody = document.getElementById('table-body');
   var tr = document.createElement('TR');
   
   var td = document.createElement('TD');
   var tdAmt = document.createElement('TD');
   var tdMachineName = document.createElement('TD');
   var tdDelBtn = document.createElement('TD');
   
   let dropDown = document.getElementById('amount');
   debugger;
   if(dropDown.value == "0") {
      alert("Please select any machine");
      return false;
   } else {

   let cellTextAmt1 = document.createTextNode(dropDown.value);
   let cellTextMachineName = document.createTextNode(dropDown.options[dropDown.selectedIndex].text);
   // let cellTextAmt_value = cellTextAmt1.split(",");
   // let cellTextAmt = cellTextAmt_value[0];
   
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

</script>
</body>
</html>