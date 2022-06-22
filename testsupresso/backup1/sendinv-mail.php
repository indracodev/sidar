<?php
//Dummy
//include "config.php";
//$invCode = "1/20210927";
//$getInvoice = $conn->query("SELECT * FROM daftarorder WHERE nomerorder = '".$invCode."' ");
//$fetchInvoice = $getInvoice->fetch_assoc();
//$thisMemberName 		= $fetchInvoice["namalengkap"];
//$thisMemberEmail 		= $fetchInvoice["email"];
//$resultInvoiceCode  = $fetchInvoice["nomerorder"];
//$resultTglOrder     = $fetchInvoice["tanggalorder"];
//$resultOrderTime    = $fetchInvoice["jamorder"];
//$resultStatus       = $fetchInvoice["status"];
//$resultItemSubtotal = $fetchInvoice["itemsubtotal"];
//$resultPersDiskon   = $fetchInvoice["persdiskon"];
//$resultDiskon       = $fetchInvoice["discon"];
//$resultVoucherPlain = $fetchInvoice["coupon"];
//if($resultVoucherPlain != ""){
	//$resultVoucher = $resultVoucherPlain;
//} else {
	//$resultVoucher = "No Voucher";
//}
//$resultCourier      = $fetchInvoice["shippingprice"];
//$resultOrderTotal   = $fetchInvoice["ordertotal"];



//Transaction Detail
$resultInvoiceCode  = $fetchInvData["nomerorder"];
$resultTglOrder     = $fetchInvData["tanggalorder"];
$resultOrderTime    = $fetchInvData["jamorder"];
$resultStatus       = $fetchInvData["status"];
$resultItemSubtotal = $fetchInvData["itemsubtotal"];
$resultPersDiskon   = $fetchInvData["persdiskon"];
$resultDiskon       = $fetchInvData["discon"];
$resultVoucherPlain = $fetchInvData["coupon"];
if($resultVoucherPlain != ""){
	$resultVoucher = $resultVoucherPlain;
} else {
	$resultVoucher = "No Voucher";
}
$resultCourier      = $fetchInvData["shippingprice"];
$resultOrderTotal   = $fetchInvData["ordertotal"];

//Produk
$bodyProduk = "";
$getProdukAll = $conn->query("SELECT * FROM daftarorderdetail WHERE nomerorder = '".$resultInvoiceCode."' ");
//$getProdukAll = $conn->query("SELECT * FROM daftarorderdetail WHERE nomerorder = '".$invCode."' ");
while($fetchProdukAll = $getProdukAll->fetch_assoc()){
	$produkCoreIMG = $fetchProdukAll["gambar"];
	$produkCoreName = $fetchProdukAll["namaproduk"];
	$produkCoreQty = $fetchProdukAll["qty"];
	$produkDiskon = $fetchProdukAll["discon"];
	$produkCoreDiskonVal = $fetchProdukAll["txtdiskon"];
	$produkCoreBefores = $fetchProdukAll["hargabelumdiskon"] * $produkCoreQty;
	$produkCoreBefore = $produkCoreBefores;
	$produkCoreSubtotal = $fetchProdukAll["subtotalproduk"];
	if($produkDiskon == 0){
		$displayDiskon = "display:none;";
	} else {
		$displayDiskon = "";
	}
	$bodyProdukCore = '<tr>
		<td valign="top" align="left">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; border-bottom: solid 1px #878787;">
				<tbody>
					<tr>

						<td valign="center" align="left">
							<table width="150" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 150px!important;">
								<tbody>
									<tr>
										<td valign="center" align="left">
											<p style="font-size: 0;">
												<img src="https://www.supresso.com/sg/img/'.$produkCoreIMG.'" width="150" style="width: 100%; height: auto; max-width: 150px">
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>

						<td valign="center" align="left">
							<table width="350" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 350px!important;">
								<tbody>
									<tr>
										<td valign="center" align="left">
											<p style="font-family: sans-serif; padding: 0; margin: 0; text-transform: uppercase; max-width: 75%;">
												'.$produkCoreName.'
											</p>
											<p style="font-family: sans-serif; padding: 0; margin-top: 0; margin-bottom: .5em; text-transform: uppercase;">
												<span>60<span style="text-transform: lowercase;">gr</span></span>&nbsp;<span>&#xd7;</span>&nbsp;<span>'.$produkCoreQty.'</span>
											</p>
											<p style=" '.$displayDiskon.' font-family: sans-serif; padding: 0; margin: 0; opacity: .5;">
												<img src="https://supresso.com/sg/img/pricetag.png" width="15" style="width: 100%; height: auto; max-width: 15px;">&nbsp;'.$produkCoreDiskonVal.'
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>

						<td valign="center" align="left">
							<table width="140" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 140px!important;">
								<tbody>
									<tr>
										<td valign="center" align="left">
											<p align="right" style=" '.$displayDiskon.' font-family: sans-serif; padding: 0; margin-top: 0; margin-bottom: .5em; opacity: .5;"><del>$ '.$produkCoreBefore.'</del></p>
											<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;">$ '.$produkCoreSubtotal.'</p>
										</td>
									</tr>
								</tbody>
							</table>
						</td>

					</tr>
				</tbody>
			</table>
		</td>
	</tr>';
	$bodyProduk = $bodyProduk.$bodyProdukCore;
}

//headernya
$bodyhead1 = '<!DOCTYPE html>
<html lang="en" style="padding: 0; margin: 0; background-color: #ffffff; width: 100%!important">
<head>
	<meta charset="utf-8">
	<title>Supresso - Transaction History</title>
	<link rel="stylesheet icon" type="text" href="https://supresso.com/newsletter/mtemplate/img/logo.png">
</head>
<body style="padding: 0; margin: 0; background-color: #ffffff; width: 100%!important;">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important;">
		<tbody>
			<tr style="display: none; max-height: 0; overflow: hidden">
				<td valign="top" align="left">
					<module name="preheader" label="Preheader">
					</module>
					<editable name="preheader">Supresso - Order Confirmation
					</editable>
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
					&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
					&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top" align="left">
					<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;">
						<tbody>
							<tr>
								<td valign="top" align="left">
									<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
										<tbody>
											<tr>
												<td valign="top" align="left" height="20">
												</td>
											</tr>
											<tr>
												<td valign="top" align="left">
													<p style="font-size: 0;">
														<img src="https://supresso.com/newsletter/mtemplate/img/logo.png" width="71" style="width:100%;height:auto;max-width:71px">
													</p>
												</td>
											</tr>
											<tr>
												<td valign="top" align="left" height="60">
												</td>
											</tr>
											<tr>
												<td valign="top" align="left">
													<h1 style="font-family: sans-serif; padding: 0; margin: 0;">
														<strong>Here is your transaction!</strong>
													</h1>
												</td>
											</tr>
											<tr>
												<td valign="top" align="left" height="20">
												</td>
											</tr>
											<tr>
												<td valign="top" align="left">
													<p style="font-family: sans-serif; padding: 0; margin: 0;">
														Hi&nbsp; <strong>';
$bodyhead2 = $thisMemberName;
$bodyhead3 = '</strong>,
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="10">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">
This is your transaction detail information youve been requested.
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">
<strong>Here<span>&#39;</span>s what you ordered :</strong>
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="10">
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important">
<tbody>

<tr>
<td valign="top" align="left">
<table width="200" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 200px!important">
<tbody>
	<tr>
		<td valign="top" align="left">
			<p style="font-family: sans-serif; padding: 0; margin: 0;">Order Number</p>
		</td>
	</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important">
<tbody>
	<tr>
		<td valign="top" align="left">
			<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">:
			</p>
		</td>
	</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="400" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 400px!important">
<tbody>
	<tr>
		<td valign="top" align="left">
			<p style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyhead4 = $resultInvoiceCode;
$bodyhead5 = '</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="200" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 200px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">Order Time</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">:
</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="400" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 400px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyhead6 = $resultTglOrder." - ".$resultOrderTime;
$bodyhead7 = '</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="200" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 200px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">Status</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">:
</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="400" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 400px!important">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyhead8 = $resultStatus;
$bodyhead9 = '</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>


</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important; border-top: solid 1px #323232; border-bottom: solid 1px #323232;">
<thead>
<tr>
<th valign="top" align="left">
<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
<thead>
<tr>
<th valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin-top: .5em; margin-bottom: .5em;">Item</p>
</th>
</tr>
</thead>
</table>
</th>
<th valign="top" align="left">
<table width="140" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 140px!important;">
<thead>
<tr>
<th valign="top" align="left">
<p align="right" style="font-family: sans-serif; padding: 0; margin-top: .5em; margin-bottom: .5em;">Price</p>
</th>
</tr>
</thead>
</table>
</th>
</tr>
</thead>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>';

//Body Footer
$bodyFooter1 = '</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
	<tr>
		<td valign="top" align="left" height="10">
		</td>
	</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
	<tr>
		<td valign="top" align="left">
			<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
				<tbody>
					<tr>
						<td valign="top" align="left">
							<p style="font-family: sans-serif; padding: 0; margin: 0;">Subtotal</p>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		<td valign="top" align="left">
			<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important;">
				<tbody>
					<tr>
						<td valign="top" align="left">
							<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">$</p>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		<td valign="top" align="left">
			<table width="100" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100px!important;">
				<tbody>
					<tr>
						<td valign="top" align="left">
							<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyFooter2 = $resultItemSubtotal;
$bodyFooter3 = '<span>&#42;</span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important; border-bottom: solid 1px #878787;">
<tbody>
<tr>
<td valign="top" align="left" height="10">
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left" height="20">
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">
	<img src="https://supresso.com/sg/img/pricetag.png" width="15" style="width: 100%; height: auto; max-width: 15px;">&nbsp;Coupon&nbsp;<span>&#40;</span>-$';
$bodyFooter4 = $resultPersDiskon;
$bodyFooter5 = '<span>&#41;</span>
</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">$</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="100" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyFooter6 = $resultDiskon;
$bodyFooter7 = '<span style="opacity: 0; visibility: hidden;">&#42;</span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td valign="top" align="left">
<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">Shipping Cost</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">$</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="100" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;">';
$bodyFooter8 = $resultCourier;
$bodyFooter9 = '<span style="opacity: 0; visibility: hidden;">&#42;</span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td valign="top" align="left">
<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">GST included in Price (Approx.)</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;">$</p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="100" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;"><span>&#40;</span>';
$bodyFooter10 = $resultCourier;
$bodyFooter11 = '<span>&#41;</span><span style="opacity: 0; visibility: hidden;">&#42;</span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left" height="20">
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="500" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 500px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;"><strong>Total</strong></p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="40" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 40px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0;"><strong>$</strong></p>
</td>
</tr>
</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="100" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p align="right" style="font-family: sans-serif; padding: 0; margin: 0;"><strong>';
$bodyFooter12 = $resultOrderTotal;
$bodyFooter13 = '<span>&#42;</span></strong></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left" height="10">
</td>
</tr>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">
If there is any mistake with the details above, please contact us at ecommerce@supresso.com. Visit online <a href="#" target="_blank" style="text-decoration: none; color: #fd4f00;">My Orders</a> to view the most up-to-date status of your order.
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="20">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0; font-size: 60%;">
&#42; Prices are inclusive of GST
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p style="font-family: sans-serif; padding: 0; margin: 0;">
Best Regards,
<br>
<strong>Supresso</strong>
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; background-color: #fafafb">
<tbody>
<tr>
<td valign="top" align="left">
<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<p style="font-size: 0">
	<img src="https://supresso.com/newsletter/mtemplate/img/signature_light.png" width="640" style="width: 100%; height: auto; max-width: 640px">
</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p align="justify" style="font-family: sans-serif; padding: 0; margin: 0; font-size: 60%; color: #fd4f00;">
Important warning and disclaimer :
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="5">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p align="justify" style="font-family: sans-serif; padding: 0; margin: 0; font-size: 60%; color: #bcbec0;">
This message and any attachments are intended for the named and correctly identified addressee only. This message may contain confidential, proprietary, legally privileged or commercially sensitive information. No waiver of confidentiality or privilege is intended or authorized by this transmission. If you are not the intended recipient of this message you must not directly or indirectly use, reproduce, distribute, disclose, print, reply on, disseminate, or copy any part of the message or its attachments and if you have received this message in error, please notify the sender immediately by return e-mail and delete it from your system. The accuracy of the information in this e-mail is not guaranteed. Any opinions contained in this message are those of the author and are not given or endorsed unless otherwise clearly indicated in this message, and the authority of the author to act for and on behalf of Indraco Pte. Ltd. and its Subsidiaries is duly verified.
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="30">
</td>
</tr>
<tr>
<td valign="top" align="left">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tbody>
<tr>
<td valign="top" align="left">
<table width="248.5" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 248.5px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
				<p style="font-size: 0">
					<a href="https://web.facebook.com/supressocoffee/" target="_blank" style="text-decoration: none">
						<img src="https://supresso.com/newsletter/mtemplate/img/ikon_fb_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
					</a>
				</p>
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
				<p style="font-size:0">
					<a href="https://www.instagram.com/supressocoffee/" target="_blank" style="text-decoration: none">
						<img src="https://supresso.com/newsletter/mtemplate/img/ikon_ig_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
					</a>
				</p>
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
				<p style="font-size: 0">
					<a href="https://api.whatsapp.com/send?phone=6281219998998&text=Hi%20Supresso," target="_blank" style="text-decoration: none">
						<img src="https://supresso.com/newsletter/mtemplate/img/ikon_phone_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
					</a>
				</p>
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="13" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 13px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="26" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 26px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
				<p style="font-size: 0">
					<a href="https://g.page/supressocoffeegallery?share" target="_blank" style="text-decoration: none">
						<img src="https://supresso.com/newsletter/mtemplate/img/ikon_map_dark.png" width="26" style="width: 100%; height: auto; max-width: 26px">
					</a>
				</p>
			</td>
		</tr>
	</tbody>
</table>
</td>
<td valign="top" align="left">
<table width="248.5" cellpadding="0" cellspacing="0" border="0" align="0" style="width: 248.5px!important;">
	<tbody>
		<tr>
			<td valign="top" align="left">
			</td>
		</tr>
	</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td valign="top" align="left" height="20">
</td>
</tr>
<tr>
<td valign="top" align="left">
<p align="center" style="font-family: sans-serif; padding: 0; margin: 0">
<a href="https://supresso.com/sg/emailtemplate/orderConfirmation.html" target="_blank" style="text-decoration: none; color: #000000; display: inline-block; vertical-align: middle; padding-right: 1rem; margin-right: 1rem; border-right: solid 1px #565656">
<small><small>View Web Version</small></small>
</a>
<a href="https://www.supresso.com/sg/pp.php" target="_blank" style="text-decoration: none; color: #000000; display: inline-block; vertical-align: middle; padding-right: 1rem; margin-right: 1rem; border-right: solid 1px #565656">
<small><small>Privacy Policy</small></small>
</a>
<a href="https://www.supresso.com/sg/unsubscribed/?email=';
$bodyFooter14 = $thisMemberEmail;
$bodyFooter15 = '" target="_blank" style="text-decoration: none; color: #000000">
	<small><small>Unsubscribe</small></small>
</a>
</p>
</td>
</tr>
<tr>
<td valign="top" align="left" height="20">
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr>
<td valign="top" align="left">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 100%!important; border-top: solid 1px #d4d4d4;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="720" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 720px!important;">
<tbody>
<tr>
<td valign="top" align="left">
<table width="640" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 640px!important;">
<tbody>
	<tr>
		<td valign="top" align="left" height="20">
		</td>
	</tr>
	<tr>
		<td valign="top" align="left">
			<p align="center" style="font-family: sans-serif; padding: 0; margin: 0">
				<small><small>
					Copyright &copy; 2021 Supresso. All rights reserved.
					<br>
					333A Orchard Road #03-11 Mandarin Gallery Singapore 238897
				</small></small>
			</p>
		</td>
	</tr>
	<tr>
		<td valign="top" align="left" height="20">
		</td>
	</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</body>';

//echoing Mail
$echoHead = $bodyhead1.$bodyhead2.$bodyhead3.$bodyhead4.$bodyhead5.$bodyhead6.$bodyhead7.$bodyhead8.$bodyhead9;
$echoFooter = $bodyFooter1.$bodyFooter2.$bodyFooter3.$bodyFooter4.$bodyFooter5.$bodyFooter6.$bodyFooter7.$bodyFooter8.$bodyFooter9.$bodyFooter10.$bodyFooter11.$bodyFooter12.$bodyFooter13.$bodyFooter14.$bodyFooter15;
$echoPage = $echoHead.$bodyProduk.$echoFooter;
//echo $echoPage;
//exit();
?>
