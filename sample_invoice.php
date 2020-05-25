<?php
session_start();
include 'db_connect.php';
$select=mysqli_query($conn,"SELECT q.QUOTATION_ID,q.Q_DATE,q.Q_STATUS,q.REMARKS,sc.S_ID,q.QUOTATION_PRODUCT_ID FROM quotation q, sales_customer sc  WHERE q.CUSTOMER_ID = sc.S_ID");
$row=mysqli_fetch_array($select);

if(isset($_POST['submit'])){

       $QUOTATION_ID= $row['QUOTATION_ID'];
       $Q_DATE= $row['Q_DATE'];
       $PRODUCTS= $_POST['PRODUCTS'];
       $CUSTOMER_ID= $row['S_ID'];



  $sql = "INSERT INTO sample_invoice(QUOTATION_ID,CUSTOMER_ID,QUOTATION_DATE,PRODUCTS) VALUES ($QUOTATION_ID,$CUSTOMER_ID,'$Q_DATE','$PRODUCTS')";

            if (mysqli_query($conn, $sql)) {
                ?>
        <!-- <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='sample_invoice.php';
        </script> -->
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
            $conn->close();
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
                        SAMPLE INVOICE
                    </header>

                    <?php if($row['Q_STATUS'] == "sample_invoice") { ?>
                      <div class="table-responsive">
                            <table class="table">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>Quotation Id</th>
                                    <th style="color:#0c1211";>Quotation Date</th>
                                    <th style="color:#0c1211";>Quotation Status</th>
                                    <th style="color:#0c1211";>Remarks</th>  
                                </tr>
                             </thead>
            
                           <tbody>
                              <tr>
                                   <td style="color:#0c1211";><?php echo $row['QUOTATION_ID']?></td>
                                   <td style="color:#0c1211";><?php echo $row['Q_DATE']?></td>
                                   <td style="color:#0c1211";><?php echo $row['Q_STATUS']?></td>
                                   <td style="color:#0c1211";><?php echo $row['REMARKS']?></td>
                                  
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
  
                            <form action=" " method="post" role="form">
                                
                                <div class="form-group">
                                    <label for="quotation_id">Quotation_Id</label>
                                    <input type="number" class="form-control" name="QUOTATION_ID" value='<?php echo $row['QUOTATION_ID'] ?>' required disabled>
                                </div>
                                <div class="form-group">
                                    <label for="quotation_date">Quotation Date</label>
                                    <input type="date" class="form-control"  name="Q_DATE" value='<?php echo $row['Q_DATE'] ?>' required disabled>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="<?php echo $row['S_ID'] ?>" name="<?php echo $row['S_ID'] ?>" value='<?php echo $row['S_ID'] ?>' hidden>
                                </div>

                              <div class="form-group">
                                <input type="radio" id="<?php echo $row['PRODUCT_ID'] ?>" name="<?php echo $row['PRODUCT_ID'] ?>" value='<?php echo $row['PRODUCT_ID'] ?>' HIDDEN>
                                <label for="sel2">PRODUCT'S</label>
<?php
$select=mysqli_query($conn,"SELECT distinct P.PRODUCT_ID, p.PRODUCT_NAME,q.QUOTATION_PRODUCT_ID FROM category p,quotation q WHERE p.PRODUCT_ID = q.QUOTATION_PRODUCT_ID");
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
                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
                            
                            </form>
                        </div>



<script type="text/javascript">
 
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>

</section>
</body>
</html>
