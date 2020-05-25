<?php
include "db_connect.php";

class test
{
   //You can keep the class empty or declare your success variable here
}

if(isset($_POST['type'])) {
    $type = $_POST['type'];
    $sql = "SELECT * FROM purchase_details_bill WHERE TYPE = '$type' ORDER BY 3 DESC";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            $dataArr = array();
            $resArr = array();
            while ($row = mysqli_fetch_array($result)) {
                $dataArr["S.NO"] = ($i+1);
                $dataArr["DATE"] = $row['PURCHASED_DATE'];  
                $dataArr["TYPE"] = $row['TYPE'];
                $dataArr["Bill No"] = $row['PURCHASE_BILL_NUMBER'];
                $dataArr["STEEL PURCHASED (in KG)"] = $row['weight'];
                $resArr[$i] = $dataArr;
                $i++;
            }
            $sql = "SELECT * FROM available_weight WHERE TYPE = '$type'";
            $result = mysqli_query($conn, $sql);
            $availableWeight = 0;
            while ($row = mysqli_fetch_array($result)) {
                $availableWeight = $row['total'];
            }

            $sql = "SELECT C.PRODUCT_NAME, PSW.SIZE, PSW.STOCK_VALUE, PSW.TYPE, PSW.thickness FROM `product_stock_weight` PSW, category C WHERE 1=1 and C.PRODUCT_ID = PSW.PRODUCT_ID and PSW.TYPE = '$type' ORDER BY 1,2,5";
            $result = mysqli_query($conn, $sql);
            $productStock = array();
            $productStockArr = array();
            $i=0;
            while ($row = mysqli_fetch_array($result)) {
                $productStock["Type"] = $row['TYPE'];
                $productStock["Product Name"] = $row['PRODUCT_NAME'];
                $productStock["Size"] = $row['SIZE'];
                $productStock["Thickness"] = $row['thickness'];
                $productStock["Stock Value"] = $row['STOCK_VALUE'];
                $productStockArr[$i] = $productStock;
                $i++;
            }

            $sql = "SELECT SPD.`QUANTITY` AS QTY, PW.weight AS WGT, (SPD.`QUANTITY` * PW.weight) AS DISPATCHED_WEIGHT
                        FROM sample_pi_details SPD, sample_pi SPI, category C, product_weight PW
                        WHERE 1=1 
                        AND C.PRODUCT_ID = PW.product_id
                        AND C.PRODUCT_NAME = SPD.PRODUCT
                        AND PW.type = SPD.TYPE
                        AND PW.size = SPD.SIZE
                        AND PW.thickness = SPD.THICKNESS
                        AND SPI.SAMPLE_PI_ID = SPD.`SAMPLE_PI_ID`
                        AND SPI.INVOICE_STATUS = 4 
                        AND SPD.`TYPE` = '$type' 
                    ";
            $dispatchedWgt = 0;
            $result = mysqli_query($conn, $sql);
            // $noOfRowsSelected = mysqli_num_rows($result);
            while($row = mysqli_fetch_array($result)) {
                // $qty += $row['QTY'];
                // $weight += $row['WGT'];
                $dispatchedWgt += $row['DISPATCHED_WEIGHT'];
            }

            $sql = "SELECT SUM(SCRAP_WEIGHT) AS SCRAP_VALUE FROM `scrap_value_tracker` WHERE TYPE = '$type'";
            $scrapVal = 0;
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)) {
                $scrapVal += $row['SCRAP_VALUE'];
            }

            $finalArr = array();
            $finalArr["billDetail"] = $resArr;
            $finalArr["availableWeight"] = $availableWeight;
            $finalArr["productStock"] = $productStockArr;
            $finalArr["scrapValue"] = $scrapVal;
            // $finalArr["averageWeight"] = $weightAvg;
            $finalArr["dispatchedWgt"] = $dispatchedWgt;
            print json_encode($finalArr);
        } else {
            print json_encode("No data found");
        }
    }
}

?>