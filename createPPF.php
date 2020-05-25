<?php
session_start();
include 'db_connect.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    echo $sql = "SELECT * FROM `sample_pi` WHERE SAMPLE_PI_ID=".$id;
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {

}
//$result = mysqli_query($conn,$sql);

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .mytable { border-collapse: collapse; width:100%; background-color:white; }
    .mytable-head { border:1px solid black;margin-bottom:0;padding-bottom:0; }
    .mytable-head td { border:1px solid black; }
    .mytable-body { border:1px solid black;border-top:0;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0; }
    .mytable-body td { border:1px solid black;border-top:0;}
    .mytable-footer { border:1px solid black;border-top:0;margin-top:0;padding-top:0; }
    .mytable-footer td { border:1px solid black;border-top:0;}
	
	.table1 {
		margin: 0px;
		margin-top: -50px;
		border-left: none;
	}
	
	.border-left-none {
		border-left: none !important;
	}
	
	.border-right-none {
		border-right: none !important;
	}
	
	.border-none {
		border: none !important;
	}
	
	.border-bottom-none {
		border-bottom: none !important;
	}

	
    </style>
</head>
<script>
var piId = <?php echo $row['SAMPLE_PI_ID']; ?>
</script>
<body>
    <div class="invoice-box">
        <table class="mytable mytable-head">
    <tr>
        <td width="50%">
			<b>SUNMAC ENTERPRICES</b></br>
			325, NANJUNDAPURAM ROAD,</br>
			NEAR PARSAN APARMENTS,</br>
			COIMBATORE 641 036.</br>
			GSTIN: 33AA12345</br>
			Phone: 9877654331</br>
			Cell No: 324324324, 3242344</br>
			E-Mail: admin@sunmac.co.in</br>
			
		</td>
        <td width="50%">
		<table class="mytable table1">
			<tr>
				<td class="50% border-left-none">PI No: <span id="pi-id"><?php echo $row['SAMPLE_PI_ID']; ?> </span></td>
				<td class="50% border-right-none">Date: <span id="pi-date"><?php echo $row['DATE']; ?></td>
			</tr>
			<tr>
				<td class="99% border-none"> 
					<b>CUSTOMER</b>
					<span id="to-address"><?php echo $row['TO_ADDRESS']?>
				</td>
				<td class="1% border-none">&nbsp; </td>
				
			</tr>
		</table>
		
		</td>
    </tr>
</table>
<table class="mytable mytable-body">
    <tr>
        <td width="50%">
			<b> Refrences: </b></br>
			XXXXXX</br>
			XXXXXX</br>
		</td>
        <td width="50%">
			<b> Delivary At: </b></br>
			<span id="delivary-address"><?php echo $row['TO_ADDRESS']?>
		</td>
    </tr>
</table>
<table class="mytable mytable-body">
    <tr>
        <td width="5%">S.No</td>
        <td width="60%">Description Of Goods</td>
        <td width="5%">HSN/SAC</td>
		<td width="5%">Qty</td>
		<td width="10%">Rate</td>
		<td width="5%">Per</td>
		<td width="10%">Amount</td>
    </tr>

	<tr>
		<td width="5%" style="border-bottom: none;">1</td>
        <td width="60%" style="border-bottom: none;">ksadksksdk sakdkahdi ksndkasd a sdksadhkad aks ksadkashd kasdhksahdka</td>
        <td width="5%" style="border-bottom: none;">7306</td>
		<td width="5%" style="border-bottom: none;">3</td>
		<td width="10%" style="border-bottom: none;">3700</td>
		<td width="5%" style="border-bottom: none;">Each</td>
		<td width="10%" style="border-bottom: none;">11,100</td>
	</tr>
	<tr>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
        <td width="60%" style="border-bottom: none;">OUTPUT SGST@9%</td>
        <td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="10%" style="border-bottom: none;">&nbsp;</td>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="10%" style="border-bottom: none;">999</td>
	</tr>
	<tr>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
        <td width="60%" style="border-bottom: none;">OUTPUT CGST@9%</td>
        <td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="10%" style="border-bottom: none;">&nbsp;</td>
		<td width="5%" style="border-bottom: none;">&nbsp;</td>
		<td width="10%" style="border-bottom: none;">999</td>
	</tr>
	
	<tr>
		<td width="5%">&nbsp;</td>
        <td width="60%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="5%">&nbsp;</td>
        <td width="60%">TOTAL</td>
        <td width="5%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
		<td width="10%">1234</td>
	</tr>
	
</table>

<table class="mytable mytable-body">
    <tr>
        <td width="5%">Amount (in words) INR</td>
        
    </tr>
</table>
<table class="mytable mytable-body">
    <tr>
        <td width="60%">HSN/SAC</td>
        <td width="10%">TAXABLE VALUE</td>
        <td width="10%">
			<table class="mytable">
				<tr>
					<td class="50% border-left-none" style="border-left: none; border-right: none; text-align: end;">Central</td>
					<td class="50% border-right-none" style="border-left: none; border-right: none;">Tax</td>
				</tr>
				<tr>
					<td class="50% border-left-none" style="border-left: none; border-bottom: none;">Rate</td>
					<td class="50% border-right-none" style="border-left: none; border-bottom: none;">Amount</td>
				</tr>
			</table>
		</td>
        <td width="10%">
			<table class="mytable">
				<tr>
					<td class="50% border-left-none" style="border-left: none; border-right: none; text-align: end;">State</td>
					<td class="50% border-right-none" style="border-left: none; border-right: none;">Tax</td>
				</tr>
				<tr>
					<td class="50% border-left-none" style="border-left: none; border-bottom: none;">Rate</td>
					<td class="50% border-right-none" style="border-left: none; border-bottom: none;">Amount</td>
				</tr>
			</table>
		</td>
        
    </tr>
	<tr>
        <tr>
			<td width="60%">Light Pole</td>
			<td width="10%">11000</td>
			<td width="10%">
				<table class="mytable">
					<tr>
						<td class="50%" style="border-left: none; border-bottom: none;">9%&nbsp;&nbsp;</td>
						<td class="50% border-right-none" style="border-left: none; border-bottom: none;">1000</td>
					</tr>
				</table>
			</td>
			<td width="10%">
				<table class="mytable">
					<tr>
						<td class="50%" style="border-left: none; border-bottom: none;">9%</td>
						<td class="50%" style="border-left: none; border-bottom: none;">1000</td>
					</tr>
				</table>
			</td>
        
		</tr>
    </tr>
	<tr>
        <tr>
			<td width="60%">TOTAL</td>
			<td width="10%">11000</td>
			<td width="10%">
				<table class="mytable">
					<tr>
						<td class="50%" style="border-left: none; border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</td>
						<td class="50% border-right-none" style="border-left: none; border-bottom: none;">1000</td>
					</tr>
				</table>
			</td>
			<td width="10%">
				<table class="mytable">
					<tr>
						<td class="50%" style="border-left: none; border-bottom: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td class="50%" style="border-left: none; border-bottom: none;">1000</td>
					</tr>
				</table>
			</td>
        
		</tr>
    </tr>
</table>
<table class="mytable mytable-body">
    <tr>
        <td width="5%" style="border-bottom: none;">Tax Amount (in words) INR</td>
	</tr>
	<tr>
        <td width="5%" style="border: none;">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%" style="border: none;">
			Declaration:</br>
			Content
		</td>
    </tr>
</table>

<table class="mytable mytable-footer">
    <tr>
        <td width="20%">20</td>
        <td width="30%">30</td>
        <td width="50%">50</td>
    </tr>
</table>
    </div>
</body>

<?php 
}
?>

</html>