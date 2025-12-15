<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wellness Report</title>
    <link rel="stylesheet" href="<?php echo base_url('css/wellness.css') ?>">
</head>
<?php
$reportData = $data;
$patientDetails = $reportData['patientdetails'];

/************** DR SIGNATURE START ***************/
$signature_directory = FCPATH . "/images/drsignature/";
$signature = $data['signature'];
$Doctor1 = $signature['doctor1'] ?? "";
$Doctor1Qualification = $signature['doctor1qualification'] ?? "";
$doctor1signature = $signature['doctor1signature'] ?? "";

if ($doctor1signature) {
    $doctor1signatureImg = base64ToWellnessImage($doctor1signature);
}else{
    $doctor1signatureImg = '';
}
$Doctor2 = $signature['doctor2'] ?? "";
$Doctor2Qualification = $signature['doctor2qualification'] ?? "";
$doctor2signature = $signature['doctor2signature'] ?? "";
if ($doctor2signature) {
    $doctor2signatureImg = base64ToWellnessImage($doctor2signature);
}else{
    $doctor2signatureImg = '';
}

$Doctor3 = $signature['doctor3'] ?? "";
$Doctor3Qualification = $signature['doctor3qualification'] ?? "";
$doctor3signature = $signature['doctor3signature'] ?? "";
if ($doctor3signature) {
    $doctor3signatureImg = base64ToWellnessImage($doctor3signature);
}else{
    $doctor3signatureImg = '';
}
/************** DR SIGNATURE END *****************/
?>
<script>
    function number_pages() {
        var vars={};
        var x=document.location.search.substring(1).split('&');
        for(var i in x) {var z=x[i].split('=',2);vars[z[0]] = decodeURIComponent(z[1]);}
        var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
        for(var i in x) {
            var y = document.getElementsByClassName(x[i]);
            for(var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
        }
    }
</script>
<body onload="number_pages()">
    <div class='report-page'>
        <footer class="footer-cls" style="margin-top: 10px;">
			<table style="width:100%; vertical-align:middle; color:#333; font-size:12px; font-family: 'MagnetaTh', sans-serif !important;">
				<tr>
					<td style="text-align:left;width:15%; padding:0px 5px; border-right:1px solid #00977b;">
						<div style="font-weight:600; padding-bottom:10px; color:#333; font-size:12px;">Proccessed By:</div>
						<div><img src='<?= base_url('images/wellness/footer-logo.png'); ?>' alt="" style="width: 120px;height:40px;"="processed-img"></div>
					</td>
					<td style="text-align:center; padding:0px 5px; width:25%; border-right:1px solid #00977b;">
						<?php if ($patientDetails['is_nabl_accredited']) { ?> 
						<!-- <div style="display: inline-block;">
							<img src='<?= base_url('images/footer-logo-pns-new.png'); ?>'
							alt="" class="demo-dcn-img">
						</div> -->
						   
						<?php } ?>
						<?php if ($patientDetails['is_cap_accredited']) { ?> 
						<div style="display: inline-block; margin-left: 10px;">
							<img src="https://cdn.shop.lifecell.in/reports/wellness/images/logo-cap.png" alt="" class="demo-dcn-img"> 
						</div>
						<?php } ?>
						<div style="color:#000; line-height:10px; font-size: 9px;"><?= $patientDetails['nabl_code'] ?></div>
						<!-- <div style="font-size: 11px; color:#a5247a; font-weight:600;"><?= ucwords(strtolower($patientDetails['patient_name'])); ?> | CRM: <?= $patientDetails['crm']; ?></div> -->
						<!-- <div style="font-size: 12px; color:#a5247a; font-weight:600;">Sample Report | CRM: 00000</div> -->
						<!-- <div style="font-size:10px; color:#a5247a; font-weight:600;">DCN: LC/HCH/STDF-RPT/ENG/1222/V001 </div> -->
						 <div style='font-size: 11px; color:#a5247a; font-weight:600;'><?= ucwords(strtolower($patientDetails['patient_name'])) ?></div>
                                            <div style='font-size: 11px; color:#a5247a; font-weight:600;'> CRM: <?= $patientDetails['crm'] ?></div>
                                            <div style='font-size:10px; color:#a5247a; font-weight:600;'>DCN: LC/HCH/STDF-RPT/ENG/1222/V001 </div>
					</td>
					
					<td style="text-align:center; width:100%; margin:0 auto; display:table;">
						<div style="display:inline-block; width:100%;">
							<div style="display:inline-block; padding:0 3px; width:32%;">
								<div><?= $doctor1signatureImg; ?></div>
								<div style="color:#a5247a; font-weight:600; font-size: 11px;"><?= $Doctor1 ?></div>
								<div style="font-size:10px; color:#333; font-weight:600;"><?= $Doctor1Qualification ?></div>
							</div>
							<div style="display:inline-block; padding:0 3px; width:32%; border-left:1px solid #00977b;">
								<div><?= $doctor2signatureImg; ?></div>
								<div style="color:#a5247a; font-weight:600; font-size: 11px;"><?= $Doctor2 ?></div>
								<div style="font-size:10px; color:#333; font-weight:600;"><?= $Doctor2Qualification ?></div>
							</div>
							<div style="display:inline-block; padding:0 3px; width:32%; border-left:1px solid #00977b;">
								<div><?= $doctor3signatureImg; ?></div>
								<div style="color:#a5247a; font-weight:600; font-size: 11px;"><?= $Doctor3 ?></div>
								<div style="font-size:10px; color:#333; font-weight:600;"><?= $Doctor3Qualification ?></div>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<div class="clear-both">
                <!-- <p class="footer-adress" style="font-size: 11px; padding: 3px 0;"><?= $patientDetails['processing_branch_address']; ?></p> -->
                <p class="footer-adress" style="font-size:11px; padding:2px 5px 5px;">Processed at: <?= $patientDetails['processing_branch_address']; ?></p>
                <p class="electric-g">This is a computer Generated medical diagnostic report that has been validated by Authorized medical practitioner/Doctor, the report does not need physical signature. (Initial report V1)</p>
				<img style="width:100%; display: block; height:auto;"src="https://cdn.shop.lifecell.in/reports/wellness/images/footer-divider.png" alt="" />
            </div>
            <div class="pageno"><span class='page'>1</span> of <span class=''><?= $reportData['pagecount'] ?? 25 ?> </span></div>
		</footer>
    </div>
</body>
</html>