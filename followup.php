<?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date_cur = date('Y-m-d', strtotime($date_1));

/*$sql = "SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_ALTERNATE_MOBILE,SC.S_MAIL FROM followup F, sales_customer SC
WHERE 1=1
AND F.S_ID = SC.S_ID
AND F.CUSTOMER_STATUS = 0
AND F.CURRENT_FOLLOWUP_DATE = '$date_cur' 
UNION 
SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_ALTERNATE_MOBILE,SC.S_MAIL FROM followup F, sales_customer SC 
WHERE 1=1
AND F.S_ID = SC.S_ID
AND F.F_STATUS = \"\"
AND F.CURRENT_FOLLOWUP_DATE < '$date_cur'
" 
;*/

$sql = "SELECT DISTINCT F_ID, S_ID, S_NAME, S_MOBILE, S_CITY, S_ALTERNATE_MOBILE, S_MAIL, S_MANUFACTURER_PRODUCTS, S_DEALER_PRODUCTS FROM ( 
  SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_CITY,SC.S_ALTERNATE_MOBILE,SC.S_MAIL, SC.S_MANUFACTURER_PRODUCTS, SC.S_DEALER_PRODUCTS
  FROM followup F, sales_customer SC 
  WHERE 1=1 
  AND F.S_ID = SC.S_ID 
  AND F.CUSTOMER_STATUS = 0 
  AND F.CURRENT_FOLLOWUP_DATE = '$date_cur' 
  UNION 
  SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_CITY,SC.S_ALTERNATE_MOBILE,SC.S_MAIL, SC.S_MANUFACTURER_PRODUCTS, SC.S_DEALER_PRODUCTS
  FROM followup F, sales_customer SC 
  WHERE 1=1 
  AND F.S_ID = SC.S_ID 
  AND F.CUSTOMER_STATUS = 0 
  AND F.F_STATUS = \"\" 
  AND F.CURRENT_FOLLOWUP_DATE < '$date_cur' ) 
  AS T GROUP BY S_NAME, S_MOBILE";
$result = mysqli_query($conn, $sql);
$new_data = mysqli_num_rows($result);

$sqlRem = "SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_ALTERNATE_MOBILE, SC.S_CITY, SC.S_MAIL, SC.S_MANUFACTURER_PRODUCTS, SC.S_DEALER_PRODUCTS FROM remainder_followup F, sales_customer SC
WHERE 1=1
AND F.S_ID = SC.S_ID
AND F.CUSTOMER_STATUS = 0 
AND F.FOLLOWUP_DATE <= '$date_cur' ";
$resultRem = mysqli_query($conn, $sqlRem);
$old_data = mysqli_num_rows($resultRem);


?>
<!DOCTYPE html>

<head>
  <title>Follow Up</title>
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
<style>
  .tableFixHead {
    overflow-y: auto;
    max-height: 400px;
  }

  .tableFixHead table {
    border-collapse: collapse;
    width: 100%;
  }

  .tableFixHead th,
  .tableFixHead td {
    padding: 8px 16px;
  }

  .tableFixHead th {
    position: sticky;
    top: 0;
  }
</style>

<body>
  <?php include 'header.php'; ?>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <section id="main-content">
    <section class="wrapper">
      <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Remainder FollowUp
              </header>

              <?php
              if ($old_data > 0) {
              ?>
                <div class="table-responsive" style="max-height: 30em;">
                  <table class="table tableFixHead">
                    <thead>
                      <tr style="color:#0c1211" ;>
                        <th style="color:#0c1211" ;>#</th>
                        <th style="color:#0c1211" ;>NAME</th>
                        <th style="color:#0c1211" ;>EMAIL</th>
                        <th style="color:#0c1211" ;>LOCATION</th>
                        <!-- <th style="color:#0c1211";>EMAIL</th>  -->
                        <th style="color:#0c1211" ;>MANUFACTURER</th>
                        <th style="color:#0c1211" ;>DEALER</th>
                        <th style="color:#0c1211" ;>UPDATE</th>
                        <th style="color:#0c1211" ;>DELETE</th>

                      </tr>
                    </thead>
                    <?php
                    $inc = 0;
                    while ($rowRem = mysqli_fetch_array($resultRem)) {
                      $inc++;
                    ?>
                      <tbody>
                        <tr>
                          <td style="color:#0c1211" ;><?php echo $inc; ?></td>
                          <td id="name-<?php echo $rowRem["F_ID"]; ?>" style="color:#0c1211" ;><?php echo $rowRem['S_NAME'] ?></td>
                          <!-- <td style="color:#0c1211";><?php echo $rowRem['S_MOBILE'] ?></td> -->
                          <?php
                          $mail_id = $rowRem['S_MAIL'];
                          if ($mail_id == 'sample@gmail.com') {
                          ?>

                            <td class="col-sm-1" style="color:#0c1211;">
                              <i class='fa fa-phone'></i>
                              <?php echo $rowRem['S_MOBILE'];
                              echo "<br>
<p style='color:red';> " . $rowRem['S_MAIL'] . "</p>"; ?>
                            </td>
                          <?php
                          } else {
                          ?>
                            <td class="col-sm-1" style="color:#0c1211;max-width:50px;table-layout: auto">
                              <i class='fa fa-phone'></i>
                              <?php echo $rowRem['S_MOBILE'];
                              echo "<br>
     <p> " . $rowRem['S_MAIL'] . "</p>"; ?>

                            </td>
                          <?php
                          }
                          ?>
                          <td style="color:#0c1211" ;><?php echo $rowRem['S_CITY'] ?></td>
                          <!-- <td style="color: <?php echo $rowRem['S_MAIL'] == "sample@gmail.com" ? "red" : "#0c1211"; ?>">
                                      <?php echo $rowRem['S_MAIL'] ?>
                                   </td> -->
                          <td class="col-sm-3" style="color:#0c1211" ;><?php
                                                                        $man = $rowRem['S_MANUFACTURER_PRODUCTS'];
                                                                        $man =  str_replace('"', "", $man);
                                                                        $man =  str_replace('[', "", $man);
                                                                        $man =  str_replace(']', "", $man);
                                                                        $man = explode(',', $man); // 1,2,3
                                                                        $size = sizeof($man);
                                                                        if ($man ==  ',') {
                                                                          $man = '';
                                                                        }

                                                                        for ($i = 0; $i < $size; $i++) {
                                                                          $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                                                                          $insert = mysqli_query($conn, $pur);
                                                                          $rows2 = mysqli_fetch_array($insert);
                                                                          if (mysqli_num_rows($insert) == 0) {
                                                                            $productName = "";
                                                                          } else {
                                                                            $productName = $rows2['PRODUCT_NAME'];
                                                                          }

                                                                          if ($productName == '') {
                                                                            echo "NILL";
                                                                          } else {
                                                                            echo $productName;
                                                                            echo "<br>";
                                                                          }
                                                                        }

                                                                        ?></td>
                          <td class="col-sm-3" style="color:#0c1211" ;><?php
                                                                        $man = $rowRem['S_DEALER_PRODUCTS'];
                                                                        $man =  str_replace('"', "", $man);
                                                                        $man =  str_replace('[', "", $man);
                                                                        $man =  str_replace(']', "", $man);
                                                                        $man = explode(',', $man); // 1,2,3
                                                                        $size = sizeof($man);

                                                                        if ($man ==  ',') {
                                                                          $man = '';
                                                                        }

                                                                        for ($i = 0; $i < $size; $i++) {
                                                                          $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                                                                          $insert = mysqli_query($conn, $pur);
                                                                          $rows2 = mysqli_fetch_array($insert);
                                                                          $productName = $rows2['PRODUCT_NAME'];
                                                                          if ($productName == '') {
                                                                            echo "NILL";
                                                                          } else {
                                                                            echo $productName;
                                                                            echo "<br>";
                                                                          }
                                                                        }

                                                                        ?></td>
                          <td style="color:#0c1211" ;>
                            <a href="javascript:edt_id('<?php echo $rowRem["F_ID"]; ?>', 1)">
                              <button type="button" class="btn btn-primary"> <i class="material-icons">edit</i></button>
                            </a>
                          </td>
                          <td style="color:#0c1211" ;>
                            <a href="javascript:deleteId('<?php echo $rowRem["F_ID"]; ?>', 1)">
                              <button type="button" class="btn btn-primary"> <i class="material-icons">delete</i></button>
                            </a>
                          </td>

                        </tr>
                      </tbody>

                  <?php
                    }
                  }
                  ?>

                  </table>
                </div>
                </br> </br>
                </br> </br>
                <header class="panel-heading">
                  Default FollowUp
                </header>
                </br>
                <?php
                if ($new_data > 0) {
                ?>
                  <div class="table-responsive" style="max-height: 30em;">
                    <table class="table tableFixHead">
                      <thead>
                        <tr style="color:#0c1211" ;>
                          <th style="color:#0c1211" ;>#</th>
                          <th style="color:#0c1211" ;>NAME</th>
                          <th style="color:#0c1211" ;>EMAIL</th>
                          <th style="color:#0c1211" ;>LOCATION</th>
                          <!-- <th style="color:#0c1211";>EMAIL</th>  -->
                          <th style="color:#0c1211" ;>MANUFACTURER</th>
                          <th style="color:#0c1211" ;>DEALER</th>

                          <th style="color:#0c1211" ;>UPDATE</th>
                          <th style="color:#0c1211" ;>DELETE</th>

                        </tr>
                      </thead>
                      <?php
                      $inc = 1;
                      while ($rows = mysqli_fetch_array($result)) {
                      ?>
                        <tbody>
                          <tr>
                            <td style="color:#0c1211" ;><?php echo $inc++ ?></td>
                            <td id="name-<?php echo $rows["F_ID"]; ?>" style="color:#0c1211" ;><?php echo $rows['S_NAME'] ?></td>
                            <!-- <td style="color:#0c1211;"><?php echo $rows['S_MOBILE'] ?></td> -->

                            <?php
                            $mail_id = $rows['S_MAIL'];
                            if ($mail_id == 'sample@gmail.com') {
                            ?>

                              <td class="col-sm-1" style="color:#0c1211;">
                                <i class='fa fa-phone'></i>
                                <?php echo $rows['S_MOBILE'];
                                echo "<br>
<p style='color:red';> " . $rows['S_MAIL'] . "</p>"; ?>
                              </td>
                            <?php
                            } else {
                            ?>
                              <td class="col-sm-1" style="color:#0c1211;max-width:50px;table-layout: auto">
                                <i class='fa fa-phone'></i>
                                <?php echo $rows['S_MOBILE'];
                                echo "<br>
     <p> " . $rows['S_MAIL'] . "</p>"; ?>

                              </td>
                            <?php
                            }
                            ?>
                            <td style="color:#0c1211" ;><?php echo $rows['S_CITY'] ?></td>
                            <!-- <td style="color: <?php echo $rows['S_MAIL'] == "sample@gmail.com" ? "red" : "#0c1211"; ?>">
                                      <?php echo $rows['S_MAIL'] ?>
                                     </td> -->

                            <td class="col-sm-3" style="color:#0c1211" ;><?php
                                                                          $man = $rows['S_MANUFACTURER_PRODUCTS'];
                                                                          $man =  str_replace('"', "", $man);
                                                                          $man =  str_replace('[', "", $man);
                                                                          $man =  str_replace(']', "", $man);
                                                                          $man = explode(',', $man); // 1,2,3
                                                                          $size = sizeof($man);
                                                                          if ($man ==  ',') {
                                                                            $man = '';
                                                                          }

                                                                          for ($i = 0; $i < $size; $i++) {
                                                                            $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                                                                            $insert = mysqli_query($conn, $pur);
                                                                            $rows1 = mysqli_fetch_array($insert);
                                                                            if (mysqli_num_rows($insert) == 0) {
                                                                              $productName = "";
                                                                            } else {
                                                                              $productName = $rows1['PRODUCT_NAME'];
                                                                            }

                                                                            if ($productName == '') {
                                                                              echo "NILL";
                                                                            } else {
                                                                              echo $productName;
                                                                              echo "<br>";
                                                                            }
                                                                          }

                                                                          ?>
                            </td>
                            <td class="col-sm-3" style="color:#0c1211" ;><?php
                                                                          $man = $rows['S_DEALER_PRODUCTS'];
                                                                          $man =  str_replace('"', "", $man);
                                                                          $man =  str_replace('[', "", $man);
                                                                          $man =  str_replace(']', "", $man);
                                                                          $man = explode(',', $man); // 1,2,3
                                                                          $size = sizeof($man);

                                                                          if ($man ==  ',') {
                                                                            $man = '';
                                                                          }

                                                                          for ($i = 0; $i < $size; $i++) {
                                                                            $pur  = "SELECT `PRODUCT_ID`, `PRODUCT_NAME` FROM `category` WHERE PRODUCT_ID = '$man[$i]' AND JOB_WORKERS = 0";
                                                                            $insert = mysqli_query($conn, $pur);
                                                                            $rows1 = mysqli_fetch_array($insert);
                                                                            $productName = $rows1['PRODUCT_NAME'];
                                                                            if ($productName == '') {
                                                                              echo "NILL";
                                                                            } else {
                                                                              echo $productName;
                                                                              echo "<br>";
                                                                            }
                                                                          }

                                                                          ?>
                            </td>
                            <td style="color:#0c1211" ;>
                              <a href="javascript:edt_id('<?php echo $rows["F_ID"]; ?>', 0)">
                                <button type="button" class="btn btn-primary">
                                  <i class="material-icons">edit</i>
                                </button>
                              </a>
                            </td>

                            <td style="color:#0c1211" ;>
                              <a href="javascript:deleteId('<?php echo $rows["F_ID"]; ?>', 0)">
                                <button type="button" class="btn btn-primary">
                                  <i class="material-icons">delete</i>
                                </button>
                              </a>
                            </td>

                          </tr>
                        </tbody>

                    <?php
                      }
                    }
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







    <script>
      function edt_id(id, isFromRemainderTable) {
        if (confirm('Sure to GO ?')) {
          window.location.href = 'followup_update.php?edit_id=' + id + '&name=' + $('#name-' + id).text() + '&isFromRemainderTable=' + isFromRemainderTable;
        }
      }

      function deleteId(id, isFromRemainderTable) {
        if (confirm('Sure to GO ?')) {
          $.ajax({
            type: 'post',
            url: 'followupDelete.php',
            data: {
              id: id,
              isFromRemainderTable: isFromRemainderTable
            },
            success: function(response) {
              window.location.href = 'followup.php';
            }
          });
        }
      }
    </script>

  </section>

  <script type="text/javascript">
    function state(val) {
      $.ajax({
        type: 'post',
        url: 'fetch_data.php',
        data: {
          state: val
        },
        success: function(response) {
          document.getElementById("city").innerHTML = response;
        }
      });
    }

    $(document).ready(function() {
      $(".fa-bars").click();
    });
  </script>


  </section>

</body>

</html>