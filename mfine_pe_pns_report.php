<!DOCTYPE html>
<html>

<head>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
    <link rel="stylesheet" href="<?php echo base_url('css/mfine.css') ?>">
    <style>
        .pns-test-report-parameter-assesed.risk .patient-speci-presc-section .patient-speci-presc-tb-def .patient-speci-presc-tb-def-div {
            padding: 0px 3px;
            font-size: 12px !important;
            color: #fff !important;
            display: inline-table;
            width: 100%;
        }
    </style>
</head>
<?php
ini_set('display_errors', 1);
require_once(APPPATH . 'graph_function_mfine.php');
$reportTitle = $reportdata['reportTitle'];
$patientdetails = $reportdata['PatientDetails'];
$prescriptiondetails = $reportdata['PrescriptionDetails'];
$specimendetails = $reportdata['SpecimenDetails'];
$ongoingpregnancy = $reportdata['OngoingPregnancy'];
$sonographydetails = $reportdata['SonographyDetails'];
$riskfactors = $reportdata['RiskFactors'];
$assistdetails = $reportdata['assistdetails'];
$pe_parameterassessed = $reportdata['pe_parameterAssessed'];
$pe_risk_assessment = $reportdata['pe_Risk_Assessment'];
$furtherTesting = $reportdata['furtherTesting'];
$parameterassessed = $reportdata['parameterAssessed'];
$riskassessment = $reportdata['Risk_Assessment'];
$interpretation = $reportdata['Interpretation'];
$ftclass = "first-trimester";

$Risk_Name_flag = '';
if (isset($riskassessment['downsyndrome']['PRDS']['final_risk']) && !empty($riskassessment['downsyndrome']['PRDS']['final_risk'])) {
    $Risk_Name_flag = "T21";
}

$FTS_testgroupCodes = ['FTPLGF', 'FTPLGFNIPT', 'FTSDA', 'FTSDS', 'FTSISD', 'FTSPLGF', 'FTSPLGFWN'];
$testGroupCode =  $reportdata['testgroupcode'];

$Prefix_flag = 0;
if (in_array($testGroupCode, $FTS_testgroupCodes)) {
    $Prefix_flag = 1;
}

?>
<?php $actual_link = base_url(); ?>

<body>

    <div class='report-page' style="padding-top: 15px;">
        <div class='report-page-main-container'>
            <section class='pns-test-report-body'>
                <div class='patient-speci-presc-section'>
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='20' cellpadding='7'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr'>Patient Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Specimen Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Prescription Details</td>
                        </tr>
                        <tr>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr style='font-size:14px;'>
                                        <td>Client Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($patientdetails['Patient_name'])) > 25) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?= ucwords($patientdetails['Title']); ?><?= ucwords(($patientdetails['Patient_name'])) ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Husband Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($patientdetails['husband_name'])) > 18) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?= $patientdetails['husband_name'] ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>:</td>
                                        <td><?= $patientdetails['Patient_gender']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>DOB</td>
                                        <td>:</td>
                                        <td class='number'><?= $patientdetails['patient_Dob']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Height/Weight</td>
                                        <td>:</td>
                                        <td class='number'><?= $patientdetails['height']  ?> / <?= $patientdetails['weight']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ethnicity</td>
                                        <td>:</td>
                                        <td><?= $patientdetails['Ethnicity']  ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Specimen</td>
                                        <td>:</td>
                                        <td><?= $specimendetails['Specimen']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Collected on</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Collected_on']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Received on</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Receivedon']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Report Date</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['ReportDate']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>CRM</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Crm_id']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lab ID</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Lab_id']  ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Test</td>
                                        <td>:</td>
                                        <td><?php echo $reportTitle; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Clinician</td>
                                        <td>:</td>
                                        <td>DR.<?= ucwords(($prescriptiondetails['Clinician']))  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hospital</td>
                                        <td>:</td>
                                        <td><?= $prescriptiondetails['Hospital']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td>:</td>
                                        <td><?= $prescriptiondetails['City']  ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <div class='pns_marker_fixed_content'>This is a screening test to assess the risk of having a baby with the
                most common genetic conditions. The probability is determined by measuring levels of specific
                hormones/proteins in the maternal blood, age, prior health factors, and ultrasound examinations.</div>
            <section class='pns-test-report-body personal-details'>
                <div class='patient-speci-presc-section'>
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='5' cellpadding='7'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr'>Ongoing Pregnancy</td>
                            <td class='patient-speci-presc-tb-hdr'>Sonography Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Prior Risk Factors</td>
                        </tr>
                        <tr>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Last Menstrual Period</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['lastMenstrualPeriod'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Conception Method</td>
                                        <td>:</td>
                                        <td><?= $ongoingpregnancy['Conception_Method'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Number of Foetus</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['NumberofFoetus'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>EDD <em>(By <?= $ongoingpregnancy['type_of_measure'] ?>)</em></td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['expectedduedate'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Maternal Age at Term</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['MaternalAgeatTerm'] ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <?php $no_of_whimb = "";
                                        if ($ongoingpregnancy['NumberofFoetus'] == 2) {
                                            $no_of_whimb = "(1,2)";
                                        } else {
                                            $no_of_whimb = "(mm)";
                                        } ?>
                                        <td>Crown Rump Length<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class="number"><?= $sonographydetails['CrownRumpLength'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Biparietal Diameter<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['BiparietalDiameter'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nasal Bone</td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['NasalBon'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Scan Date</td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['ScanDate'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>GA at Collection</td>
                                        <td>:</td>
                                        <td class='number'><?php echo $sonographydetails['ga_at_collection'];
                                                            $fontsize = "font-size: 11px;";
                                                            if ($ongoingpregnancy['type_of_measure'] == "Ass Rep.") {
                                                                $fontsize = "font-size: 9px;";
                                                            } ?>
                                            <em style="<?php echo $fontsize ?>"><?php echo !empty($sonographydetails['ga_at_collection']) ? "(By " . $ongoingpregnancy['type_of_measure'] . " )" : "" ?></em>
                                        </td>
                                    </tr>
                                    <?php if ($ongoingpregnancy['NumberofFoetus'] == 2) {
                                    ?>
                                        <tr>
                                            <td>Chorionicity</td>
                                            <td>:</td>
                                            <td class='number'><?= $sonographydetails['chorionicity'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <?php foreach ($riskfactors['prior_risk'] as $rKey => $riskRow) { ?>
                                        <tr>
                                            <td><?= $rKey ?> : <?= $riskRow ?> </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class='pns_test-report-body assistance-details'>
                <div class='patient-speci-presc-section'>
                    <table style='width:99%; border-radius:10px; border:1px solid #0a81a0; background:#fff; margin:10px auto;' border='0' cellspacing='0' cellpadding='5'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr' style="font-size:14px;">Assistance Details</td>
                            <td class="assistance-details">Method<p class='number'>
                                    <?= $assistdetails['Method'] ?>
                                </p>
                            </td>
                            <td class="assistance-details">Egg Extraction Date<p class='number'><?= $assistdetails['EggExtractionDate'] ?></p>
                            </td>
                            <td class="assistance-details">Transfer Date<p class='number'><?= $assistdetails['TransferDate'] ?></p>
                            </td>
                            <td class="assistance-details">Age At Extraction<p class='number'><?= $assistdetails['AgeAtExtraction'] ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
        <div class='range-info'><span class='title'>Parameters Assessed</span><span class='within_range'>Within
                Range</span><span class='out_of_range'>Out of range</span></div>
        <div class="parameter-graph-section" style=" float:left; width:100%;">
            <section class="pns-test-report-parameter-assesed parameters">
                <div class="patient-speci-presc-section">
                    <?php $table_size = "";
                    $fontsize = "";
                    if (count($parameterassessed['printingnames']) == 6) {
                        $table_size = "width:120px !important;font-size:10px !important;";
                        $fontsize = "font-size:10px !important;";
                    } ?>
                    <table style="width:100%;<?php echo $table_size; ?>border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 5px 0;" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <?php $i = 0;
                            $markerreport = "report";
                            foreach ($parameterassessed['printingnames'] as $key => $printingobj) {
                                $printingName = $printingobj['printing_name'];
                                $parameterMethod = $printingobj['parametermethod'];
                            ?>
                                <td class="patient-speci-presc-tb-parameter"><?php echo $printingName ?><span class="test-title"> (<?php echo $parameterMethod; ?> )</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>

                            <?php foreach ($parameterassessed['resultvalues'] as $key => $testResults) { ?>
                                <td class="patient-speci-presc-tb-def">
                                    <table class="patient-speci-presc-tb-def-div" style="color:#333333;font-size:12px;<?= $table_size; ?>" cellpadding="0">
                                        <tr>
                                            <td>Result : <span class="number"><?php echo round($testResults['result_value'], 2); ?><?php echo " " ?><?php echo $testResults['uom_value']; ?> </span></td>
                                        </tr>
                                        <tr>
                                            <td>Multiple of Median : <span class="number"><?php echo round((float)$testResults['mom_value'], 2); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <div class="progress-bar-container">
                                        <div id="currentProgressRange" class="current-progress-range" data_id="<?php echo $i ?>">
                                            <div id="pnsValues<?php echo $markerreport . $i ?>" class="pns-report-score">
                                                <span id="pnsValues-value<?php echo $markerreport . $i ?>" class="number"><?php echo isset($testResults['mom_value']) && !empty($testResults['mom_value']) ? round((float)$testResults['mom_value'], 2) : 0; ?></span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div below-criteria">
                                            <div class="points number">
                                                <span class="left">0</span>
                                                <span class="right">0.5</span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div border-line">
                                            <div class="points number">
                                                <span class="right">2.0</span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div above-criteria">
                                            <div class="points number">
                                                <span class="right">5.0+</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php $i++;
                            } ?>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
        <!-- Graph changes -->

        <div class="range-info">
            <span class="title">Risk Assessment - Aneuploidy <br>
                <?php $txt_line = "";
                if ($riskassessment['risksoftwaremethod'] == "LIFECYCLE") {
                    $txt_line = "Results Were Analyzed by Lifecycle S/W - Version 7.0";
                }
                if ($riskassessment['risksoftwaremethod'] == "PRISCA") {
                    $txt_line = "Results Were Analyzed by PRISCA S/W - Version 5.2";
                } ?>
                <span class="test-title">(<?= $txt_line ?>)</span></span>
            <span class="increased_risk">Increased Risk</span>
            <span class="intermediate_risk">Intermediate Risk</span>
            <span class="low_risk">Low Risk</span>
        </div>
        <!-- New Graph -->

        <?php $page_break_css = "";

        if ($riskassessment['showBR'] == 1 || $no_of_whimb == 2) {
            $page_break_css = "page-break-after: always";
        }

        if (!empty($riskassessment['printingnamesofrisk'])) { ?>

            <div class="risk-graph-section" style=" float:  left; width:100%;">
                <section class="pns-test-report-parameter-assesed risk" style="float:left;<?= $page_break_css ?>">
                    <div class="patient-speci-presc-section">
                        <table style="width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 0;" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php foreach ($riskassessment['printingnamesofrisk'] as $key => $printingName) {
                                    $css_color = "";
                                    if ($key == "down") {
                                        $css_color = $riskassessment['style_color']['downsyndrome_border_color'] . " " . $riskassessment['style_color']['downsyndrome_risk_color'];
                                    }
                                    if ($key == "edward") {
                                        $css_color =  $riskassessment['style_color']['edward_border_color'] . " " . $riskassessment['style_color']['edward_risk_color'];
                                    }
                                    if ($key == "patau") {
                                        $css_color = $riskassessment['style_color']['patau_border_color'] . " " . $riskassessment['style_color']['patau_risk_color'];
                                    }
                                    if ($key == "ntsyndrome") {
                                        $css_color = $riskassessment['style_color']['ntsyndrome_border_color'] . " " . $riskassessment['style_color']['ntsyndrome_risk_color'];
                                    }
                                ?>
                                    <td class="patient-speci-presc-tb-parameter <?= $ftclass ?> number <?= $css_color ?>"><?php echo $printingName; ?></td>
                                <?php } ?>
                            </tr>
                            <?php
                            $temp_prisca_Syndrome_age_risk = [];
                            $BR_Risk_flag = '0:0';
                            $FR_Risk_flag = '0:0';
                            $FR_Risk_Word_flag = '';
                            ?>
                            <tr>
                                <?php if (!empty($riskassessment['downsyndrome'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['downsyndrome_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($riskassessment['downsyndrome']) == 2) {
                                                $keys = array_keys($riskassessment['downsyndrome']); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['downsyndrome'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['downsyndrome'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Age Risk(AR) - <?php echo $riskassessment['downsyndrome'][$keys[0]]['age_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $riskassessment['downsyndrome'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $riskassessment['downsyndrome'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['downsyndrome'] as $Syndrome) {
                                                    $temp_prisca_Syndrome_age_risk[] = $Syndrome['age_risk']; ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                        <?php $FR_Risk_flag = $Syndrome['final_risk'] ?? '0:0'; ?>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        if ($riskassessment['showBR'] == 1) { ?>
                                                            <td><span class="risk-graph-font">Biochemical Risk (BR) - <?php echo $Syndrome['biochemical_risk']; ?> </span></td>
                                                            <?php $BR_Risk_flag = $Syndrome['biochemical_risk'] ?? '0:0'; ?>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo $Syndrome['age_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                        <?php $FR_Risk_Word_flag = $Syndrome['risk_result'] ?? ''; ?>
                                                    </tr>
                                            <?php }
                                            } ?>

                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['edwardSyndrome'])) { ?>
                                    <td class="<?= $riskassessment['style_color']['edward_risk_color'] ?> patient-speci-presc-tb-def">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            $i = 0;
                                            if (count($riskassessment['edwardSyndrome']) == 2) {
                                                $keys = array_keys($riskassessment['edwardSyndrome']); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['edwardSyndrome'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['edwardSyndrome'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Age Risk(AR) - <?php echo ($riskassessment['risksoftwaremethod'] == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $riskassessment['edwardSyndrome'][$keys[0]]['age_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $riskassessment['edwardSyndrome'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $riskassessment['edwardSyndrome'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['edwardSyndrome'] as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo ($riskassessment['risksoftwaremethod'] == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $Syndrome['age_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['patueSyndrome'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['patau_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                             $i = 0;
                                            if (count($riskassessment['patueSyndrome']) == 2) {
                                                $keys = array_keys($riskassessment['patueSyndrome']); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['patueSyndrome'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['patueSyndrome'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $riskassessment['patueSyndrome'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $riskassessment['patueSyndrome'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $riskassessment['patueSyndrome'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['patueSyndrome'] as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo ($riskassessment['risksoftwaremethod'] == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $Syndrome['age_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['ntSyndrome'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['ntsyndrome_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" cellpadding="0">
                                            <?php foreach ($riskassessment['ntSyndrome'] as $Syndrome) {
                                                $momValue = $Syndrome['final_risk']; ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">AFP MOM - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk Result - <?php $Syndrome['risk_result']; ?></span></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['pe32'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['pe_32_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($riskassessment['pe32']) == 2) {
                                                $keys = array_keys($riskassessment['pe32']); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['pe32'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['pe32'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 Result - <?php echo $riskassessment['pe32'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 Result - <?php echo $riskassessment['pe32'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['pe32'] as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['pe34'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['pe_34_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($riskassessment['pe34']) == 2) {
                                                $keys = array_keys($riskassessment['pe34']); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['pe34'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['pe34'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 Result - <?php echo $riskassessment['pe34'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 Result - <?php echo $riskassessment['pe34'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['pe34'] as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($riskassessment['pe37'])) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $riskassessment['style_color']['pe_37_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($riskassessment['pe37']) == 2) {
                                                $keys = array_keys($patueSyndrome); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $riskassessment['pe37'][$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $riskassessment['pe37'][$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 Result - <?php echo $riskassessment['pe37'][$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 Result - <?php echo $riskassessment['pe37'][$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($riskassessment['pe37'] as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php $j = 0;
                                foreach ($riskassessment['printingnamesofrisk'] as $key => $printingName) {
                                    if ($key == "down" && (count($riskassessment['downsyndrome']) == 1)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['downsyndrome_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <?php
                                                        //  if ($riskassessment['showBR'] == 1 && !empty($Syndrome['biochemical_risk'])) {
                                                        //     echo riskGraph($riskassessment['downsyndrome'], $ftclass);
                                                        // } else {
                                                        //     echo riskGraphWithoutBR($riskassessment['downsyndrome'], $ftclass);
                                                        // }
                                                        if ($riskassessment['showBR'] == 1 && !empty($riskassessment['downsyndrome']['PRDS']['biochemical_risk']) || !empty($riskassessment['downsyndrome']['PNSDMDS']['biochemical_risk'])) {
                                                            if ($riskassessment['risksoftwaremethod'] == "PRISCA") {
                                                                echo riskGraphPrisca($riskassessment['downsyndrome'], $ftclass);
                                                            } else {

                                                                echo riskGraph($riskassessment['downsyndrome'], $ftclass);
                                                            }
                                                        } else {
                                                            if ($riskassessment['risksoftwaremethod'] == "PRISCA") {
                                                                echo riskGraphPriscaWithoutBR($riskassessment['downsyndrome'], $ftclass);
                                                            } else {
                                                                echo riskGraphWithoutBR($riskassessment['downsyndrome'], $ftclass);
                                                        }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "down" && (count($riskassessment['downsyndrome']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['downsyndrome_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php if ($riskassessment['showBR'] == 1) {
                                                            echo riskGraphTwin($riskassessment['downsyndrome'], $ftclass);
                                                        } else {
                                                            echo riskGraphForDownSydromeTwin($riskassessment['downsyndrome'], $ftclass);
                                                        } ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "edward" && (count($riskassessment['edwardSyndrome']) == 1)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['edward_border_color']; ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($riskassessment['edwardSyndrome'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "edward" && (count($riskassessment['edwardSyndrome']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['edward_border_color']; ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($riskassessment['edwardSyndrome'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "patau" && (count($riskassessment['patueSyndrome']) == 1)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['patau_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($riskassessment['patueSyndrome'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "patau" && (count($riskassessment['patueSyndrome']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['patau_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($riskassessment['patueSyndrome'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "ntsyndrome" && (count($riskassessment['ntSyndrome']) == 1)) {
                                    ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['ntsyndrome_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php
                                                        if ($ongoingpregnancy['NumberofFoetus'] == 2) {
                                                            echo riskGraphForNTDTwin($momValue, $ftclass);
                                                        } else {
                                                            echo riskGraphForNTD($momValue, $ftclass);
                                                        }
                                                        ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "ntsyndrome" && (count($riskassessment['ntSyndrome']) == 2)) {
                                    ?>
                                        <td class="graph-main-div  <?= $riskassessment['style_color']['ntsyndrome_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForNTDTwin($momValue, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_32" && (count($riskassessment['pe32']) == 1)) { ?>
                                        <td class="graph-main-div  <?= $riskassessment['style_color']['pe_32_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($riskassessment['pe32']); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_32" && (count($riskassessment['pe32']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['pe_32_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($riskassessment['pe32'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_34" && (count($riskassessment['pe34']) == 1)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['pe_34_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($riskassessment['pe34'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_34" && (count($riskassessment['pe34']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['pe_34_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($riskassessment['pe34'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_37" && (count($riskassessment['pe37']) == 1)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['pe_37_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($riskassessment['pe37'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_37" && (count($riskassessment['pe37']) == 2)) { ?>
                                        <td class="graph-main-div <?= $riskassessment['style_color']['pe_37_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($riskassessment['pe37'], $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } ?>
                                <?php $j++;
                                } ?>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>

            <?php

            // if($specimendetails['Lab_id'] == "20900101676" || $specimendetails['Lab_id'] =="20900200213"){
            $interpretation_css = "float:left;width:100%;";
            // }else{
            //     $interpretation_css = "float:left;width:100%;";
            // }
            ?>
            <table style="<?= $interpretation_css; ?>;">

            <?php } else { ?>
                <table style="margin-top:1%;padding-top:30px;">
                <?php } ?>
                <tr class='interpretation-main'>
                    <td class='interpretation-img'><img style="width: 45px; margin-top: 0px;"  src='<?= base_url('images/pns-interpretation-new.png'); ?>' alt='' /></td>
                    <td class='interpretation-details'>
                        <p class='title'>Interpretation</p>
                        <p class='interpretation' style="font-size:10px"><?php echo $reportdata['pe_pentainterwope_interpretation'] ?></p>
                        <?php if ($riskassessment['showBioComment'] == 1) { ?>
                            <p class='interpretation' style="font-size:14px"> The above risk has been calculated based on Biochemistry values alone.
                                Biochemistry based Screening offers detection rate of 60% (5% FPR)</p>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                if (!function_exists('find_ratio_result')) {
                function find_ratio_result($value, $min, $max)
                {
                    if (preg_match('/(\d+):(\d+)/', $value, $matches)) {
                        $denominator = (int)$matches[2];
                        return ($denominator >= $min && $denominator <= $max) ? true : false;
                    }
                    return false;
                }
               }
                ?>
                <?php if ($Prefix_flag == 1 && $Risk_Name_flag == "T21" && find_ratio_result($BR_Risk_flag, 1, 1000) && find_ratio_result($FR_Risk_flag, 1000, 100000) && $FR_Risk_Word_flag == "Low Risk") { ?>
                    <tr class='interpretation-main'>
                        <td class='interpretation-img'><img style="width: 45px; margin-top: 0px;" src='<?= base_url('images/pns-interpretation-new.png'); ?>' alt='' /></td>
                        <td class='interpretation-details'>
                            <p class='title'>Comment</p>
                            <p class='interpretation' style="font-size:10px">
                               If in case increased biochemical risk (1 to 250), further testing is recommended-non-invasive or invasive testing, along with a detailed anomaly scan between 18 to 20 weeks.
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                <table>
    </div>

    <div class='report-page' style="margin-top:5%;padding-top:15px;page-break-before:always;">
        <div class='report-page-main-container'>
            <section class='pns-test-report-body'>
                <div class='patient-speci-presc-section'>
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='20' cellpadding='7'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr'>Patient Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Specimen Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Prescription Details</td>
                        </tr>
                        <tr>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <!-- <tr >
                                        <td>Client Name</td>
                                        <td>:</td>
                                        <?php $patientdetails = $reportdata['PatientDetails'];
                                        if (strlen(trim($patientdetails['Patient_name'])) > 25) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block"> <?= ucwords(($patientdetails['Patient_name'])) ?>
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block"> <?= ucwords(($patientdetails['Patient_name'])) ?>
                                            <?php } ?>
                                            </td>
                                    </tr> -->
                                    <tr style='font-size:14px;'>
                                        <td>Client Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($patientdetails['Patient_name'])) > 25) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?= ucwords($patientdetails['Title']); ?><?= ucwords(($patientdetails['Patient_name'])) ?>
                                            </td>
                                    </tr>
                                   
                                    <tr>
                                        <td>Husband Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($patientdetails['husband_name'])) > 18) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?= $patientdetails['husband_name'] ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>:</td>
                                        <td> <?= $patientdetails['Patient_gender'] ?> </td>
                                    </tr>
                                    <tr>
                                        <td>DOB</td>
                                        <td>:</td>
                                        <td class='number'><?= $patientdetails['patient_Dob'] ?> </td>
                                    </tr>
                                    <tr>
                                        <td>Height & Weight</td>
                                        <td>:</td>
                                        <td class='number'><?= $patientdetails['height']  ?> , <?= $patientdetails['weight']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ethnicity</td>
                                        <td>:</td>
                                        <td><?= $patientdetails['Ethnicity'] ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Specimen</td>
                                        <td>:</td>
                                        <td><?php
                                            $specimendetails = $reportdata['SpecimenDetails'];
                                            echo $specimendetails['Specimen'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Collected on</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Collected_on'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Received on</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Receivedon'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Report Date</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['ReportDate'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>CRM</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Crm_id'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lab ID</td>
                                        <td>:</td>
                                        <td class='number'><?= $specimendetails['Lab_id'] ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Test</td>
                                        <td>:</td>
                                        <td><?php echo $reportdata['reportTitle']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Clinician</td>
                                        <td>:</td>
                                        <td>DR.<?= ucwords(($prescriptiondetails['Clinician'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hospital</td>
                                        <td>:</td>
                                        <td><?= $prescriptiondetails['Hospital'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td>:</td>
                                        <td><?= $prescriptiondetails['City'] ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <div class='pns_marker_fixed_content'>This is a screening test to assess the risk of having a baby with the
                most common genetic conditions. The probability is determined by measuring levels of specific
                hormones/proteins in the maternal blood, age, prior health factors, and ultrasound examinations.</div>
            <section class='pns-test-report-body personal-details'>
                <div class='patient-speci-presc-section'>
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='5' cellpadding='7'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr'>Ongoing Pregnancy</td>
                            <td class='patient-speci-presc-tb-hdr'>Sonography Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Prior Risk Factors</td>
                        </tr>
                        <tr>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Last Menstrual Period</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['lastMenstrualPeriod'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Conception Method</td>
                                        <td>:</td>
                                        <td><?= $ongoingpregnancy['Conception_Method'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Number of Foetus</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['NumberofFoetus'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>EDD <em>(By <?= $ongoingpregnancy['type_of_measure'] ?>)</em></td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['expectedduedate'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Maternal Age at Term</td>
                                        <td>:</td>
                                        <td class='number'><?= $ongoingpregnancy['MaternalAgeatTerm'] ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <?php $no_of_whimb = "";
                                        if ($ongoingpregnancy['NumberofFoetus'] == 2) {
                                            $no_of_whimb = "(1,2)";
                                        } else {
                                            $no_of_whimb = "(mm)";
                                        } ?>
                                        <td>Crown Rump Length<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class="number"><?= $sonographydetails['CrownRumpLength'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Biparietal Diameter<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['BiparietalDiameter'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nasal Bone</td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['NasalBon'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Scan Date</td>
                                        <td>:</td>
                                        <td class='number'><?= $sonographydetails['ScanDate'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>GA at Collection</td>
                                        <td>:</td>
                                        <td class='number'><?php echo $sonographydetails['ga_at_collection'];
                                                            $fontsize = "font-size: 11px;";
                                                            if ($ongoingpregnancy['type_of_measure'] == "Ass Rep.") {
                                                                $fontsize = "font-size: 9px;";
                                                            } ?>
                                            <em style="<?php echo $fontsize ?>"><?php echo !empty($sonographydetails['ga_at_collection']) ? "(By " . $ongoingpregnancy['type_of_measure'] . " )" : "" ?></em>
                                        </td>
                                    </tr>
                                    <?php if ($ongoingpregnancy['NumberofFoetus'] == 2) {
                                    ?>
                                        <tr>
                                            <td>Chorionicity</td>
                                            <td>:</td>
                                            <td class='number'><?= $sonographydetails['chorionicity'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <?php foreach ($riskfactors['pe_prior_risk'] as $rKey => $riskRow) { ?>
                                        <tr>
                                            <td><?= $rKey ?> : <?= $riskRow ?> </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class='pns_test-report-body assistance-details'>
                <div class='patient-speci-presc-section'>
                    <table style='width:99%; border-radius:10px; border:1px solid #0a81a0; background:#fff; margin:10px auto;' border='0' cellspacing='0' cellpadding='5'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr' style="font-size:14px;">Assistance Details</td>
                            <td class="assistance-details">Method<p class='number'>
                                    <?= $assistdetails['Method'] ?>
                                </p>
                            </td>
                            <td class="assistance-details">Transfer Date<p class='number'><?= $assistdetails['TransferDate'] ?></p>
                            </td>
                            <td class="assistance-details">Egg Extraction Date<p class='number'><?= $assistdetails['EggExtractionDate'] ?></p>
                            </td>
                            <td class="assistance-details">Age At Extraction<p class='number'><?= $assistdetails['AgeAtExtraction'] ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
        <div class='range-info'><span class='title'>Parameters Assessed</span><span class='within_range'>Within
                Range</span><span class='out_of_range'>Out of range</span></div>
        <div class="parameter-graph-section" style=" float:left; width:100%;">
            <section class="pns-test-report-parameter-assesed parameters">
                <div class="patient-speci-presc-section">
                    <?php $table_size = "";
                    $fontsize = "";
                    if (count($pe_parameterassessed['printingnames']) == 6) {
                        $table_size = "width:120px !important;font-size:10px !important;";
                        $fontsize = "font-size:10px !important;";
                    } ?>
                    <table style="width:100%;<?php echo $table_size; ?>border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 5px 0;" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <?php $i = 0;
                            $marker = "pereport";
                            foreach ($pe_parameterassessed['printingnames'] as $key => $printingName) { ?>
                                <td class="patient-speci-presc-tb-parameter"><?php echo $printingName['printing_name'] ?>
                                    <span class="test-title"> (<?php echo $printingName['parametermethod']; ?> )</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php foreach ($pe_parameterassessed['resultvalues'] as $key => $testResults) { ?>
                                <td class="patient-speci-presc-tb-def">
                                    <table class="patient-speci-presc-tb-def-div" style="color:#333333;font-size:12px;<?= $table_size; ?>" cellpadding="0">
                                        <tr>
                                            <?php
                                            if ($testResults['printing_name'] == "UTPi MoM" || $testResults['printing_name'] == "MAP MoM") {
                                            ?>
                                                <td><br></td>
                                            <?php } else { ?>
                                                <td>Result : <span class="number">
                                                        <?php echo round($testResults['result_value'], 2); ?>
                                                        <?php echo " " ?><?php echo  $testResults['uom_value']; ?> </span>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td>Multiple of Median : <span class="number"><?php echo round((float)$testResults['mom_value'], 2); ?></span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <div class="progress-bar-container">
                                        <div id="currentProgressRange" class="current-progress-range" data_id="<?php echo $i ?>">
                                            <div id="pnsValues<?php echo $marker . $i ?>" class="pns-report-score">
                                                <span id="pnsValues-value<?php echo $marker . $i ?>" class="number"><?php echo isset($testResults['mom_value']) && !empty($testResults['mom_value']) ? round((float)$testResults['mom_value'], 2) : 0; ?></span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div below-criteria">
                                            <div class="points number">
                                                <span class="left">0</span>
                                                <span class="right">0.5</span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div border-line">
                                            <div class="points number">
                                                <span class="right">2.0</span>
                                            </div>
                                        </div>
                                        <div class="rangebar-div above-criteria">
                                            <div class="points number">
                                                <span class="right">5.0+</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php $i++;
                            } ?>
                        </tr>
                    </table>
                </div>
            </section>
        </div>
        <!-- Graph changes -->

        <div class="range-info">
            <span class="title">Risk Assessment - Preeclampsia <br>
                <!-- <span class="test-title">(<?= $reportdata['risk_software_txt_line'] ?>)</span></span> -->
                <?php $txt_line = "";
                if ($riskassessment['risksoftwaremethod'] == "LIFECYCLE") {
                    // $txt_line = "These results were analyzed with LifeCycle software from PerkinElmer Life and Analytical Sciences";
                    $txt_line = "Results Were Analyzed by Lifecycle S/W - Version 7.0";
                }
                if ($riskassessment['risksoftwaremethod'] == "PRISCA") {
                    // $txt_line = "These results were analyzed with PRISCA software from siemens";
                    $txt_line = "Results Were Analyzed by PRISCA S/W - Version 5.2";
                } ?>
                <span class="test-title">(<?= $txt_line ?>)</span></span>
            <span class="increased_risk">Increased Risk</span>
            <span class="intermediate_risk">Intermediate Risk</span>
            <span class="low_risk">Low Risk</span>
        </div>
        <!-- New Graph -->

        <?php $page_break_css = "";
        $showBR = $reportdata['Risk_Assessment']['showBR'];
        $showBioComment = $reportdata['Risk_Assessment']['showBioComment'];
        $caution_css = "";
        if (!empty($pe_risk_assessment['printingnamesofrisk'])) { ?>
            <div class="risk-graph-section" style=" float:  left; width:100%;">
                <section class="pns-test-report-parameter-assesed risk" style="float:left;<?= $page_break_css ?>">
                    <div class="patient-speci-presc-section">
                        <table style="width:25%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 0;" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php
                                $styleColor = $pe_risk_assessment['style_color'];
                                foreach ($pe_risk_assessment['printingnamesofrisk'] as $key => $printingName) {
                                    $css_color = "";
                                    if ($key == "pe_32") {
                                        $css_color = $styleColor['pe_32_border_color'] . " " . $styleColor['pe_32_risk_color'];
                                    }
                                    if ($key == "pe_34") {
                                        $css_color = $styleColor['pe_34_border_color'] . " " . $styleColor['pe_34_risk_color'];
                                    }
                                    if ($key == "pe_37") {
                                        $css_color = $styleColor['pe_37_border_color'] . " " . $styleColor['pe_37_risk_color'];
                                    }
                                ?>
                                    <td class="patient-speci-presc-tb-parameter <?= $ftclass ?> number <?= $css_color ?>"><?php echo $printingName; ?></td>
                                <?php } ?>
                            </tr>
                            <tr>

                                <?php if (!empty($pe_risk_assessment['pe32'])) {
                                    $pe32 = $pe_risk_assessment['pe32']; ?>
                                    <td class="patient-speci-presc-tb-def <?= $styleColor['pe_32_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($pe32) == 2) {
                                                $keys = array_keys($pe32); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $pe32[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $pe32[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $pe32[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $pe32[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($pe32 as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php
                                $pe34 = $pe_risk_assessment['pe34'];
                                if (!empty($pe34)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $styleColor['pe_34_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($pe34) == 2) {
                                                $keys = array_keys($pe34); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $pe34[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $pe34[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $pe34[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $pe34[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($pe34 as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php
                                $pe37 = $pe_risk_assessment['pe37'];
                                if (!empty($pe37)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $styleColor['pe_37_risk_color'] ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number" style="color:#333333;font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($pe37) == 2) {
                                                $keys = array_keys($patueSyndrome); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $pe37[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $pe37[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $pe37[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $pe37[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($pe37 as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk(FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php $j = 0;
                                foreach ($pe_risk_assessment['printingnamesofrisk'] as $key => $printingName) {
                                    if ($key == "pe_32" && (count($pe32) == 1)) { ?>
                                        <td class="graph-main-div  <?= $styleColor['pe_32_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe32, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_32" && (count($pe32) == 2)) { ?>
                                        <td class="graph-main-div <?= $styleColor['pe_32_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe32, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_34" && (count($pe34) == 1)) { ?>
                                        <td class="graph-main-div <?= $styleColor['pe_34_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe34, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_34" && (count($pe34) == 2)) { ?>
                                        <td class="graph-main-div <?= $styleColor['pe_34_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe34, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_37" && (count($pe37) == 1)) { ?>
                                        <td class="graph-main-div <?= $styleColor['pe_37_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe37, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_37" && (count($pe37) == 2)) { ?>
                                        <td class="graph-main-div <?= $styleColor['pe_37_border_color'] ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe37, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } ?>
                                <?php $j++;
                                } ?>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
            <?php
            $interpretation_css = "margin-top:10px;float:left;width:100%;";
            ?>
            <table style="<?= $interpretation_css; ?>">
                <?php } else {
                if (!empty(trim($reportdata['pe_pentainterpe_interpretation']))) { ?>
                    <table style="margin-top:1%;page-break-after: always;">
                    <?php } else { ?>

                        <table style="margin-top:1%;;">
                        <?php } ?>
                    <?php } ?>
                    <tr class='interpretation-main'>
                        <td class='interpretation-img'><img class='inter-img' src='<?= base_url('images/pns-interpretation-new.png'); ?>' alt='' /></td>
                        <td class='interpretation-details'>
                            <p class='title'>Interpretation</p>
                            <p class='interpretation' style="font-size:14px"><?php echo $reportdata['pe_pentainterpe_interpretation'] ?></p>
                            <?php if ($showBioComment == 1) { ?>
                                <p class='interpretation' style="font-size:14px"> The above risk has been calculated based on Biochemistry values alone.
                                    Biochemistry based Screening offers detection rate of 60% (5% FPR)</p>
                            <?php } ?>
                        </td>
                    </tr>
                        </table>
                        <?php
                        $margin = 1;
                        $padding = 1;
                        $caution_css = "page-break-before: always;";
                        if (empty(trim($reportdata['pe_pentainterpe_interpretation'])) && count($pe_risk_assessment['printingnamesofrisk']) == 0) {
                            $caution_css = "page-break-after: always;";
                        }

                        ?>
                        <table style="margin-top: 30px;padding-top: -20px; padding-bottom: 30px;">
                            <tr class='caution-main'>
                                <td class='caution-img'><img class='caut-img' src='<?= base_url('images/pns-caution-new.png'); ?>' alt='' /></td>
                                <td class='caution-details'>
                                    <p class='title'>Caution</p>
                                    <p class='caution'>It must be clearly understood that this is a screening test, and therefore cannot
                                        be used to reach a definitive diagnosis. A low-risk result doesn't guarantee that your baby won't
                                        have one of these conditions. Likewise, an increased-risk result doesn't guarantee that your
                                        baby will be born with one of these conditions, and that further confirmatory tests must be
                                        performed in consultation with your healthcare provider.</p>
                                </td>
                            </tr>
                        </table>
    </div><!-- Page 2 Start -->
    <?php

    if (empty($furtherTesting)) { ?>
        <div class='report-page page2' style="background: #fffbf3;page-break-after: always;">
        <?php } else {  ?>
            <div class='report-page page2' style="background: #fffbf3;page-break-after: always;">
            <?php } ?>
            <div class='report-page-main-container'>
                <div class='page-two-main-container'>
                    <?php if (!empty($furtherTesting)) {
                        $furtherTesting = array_values($furtherTesting);
                        usort($furtherTesting, function ($a, $b) {
                            return $a['sort'] <=> $b['sort'];
                        });
                    ?>
                        <section class='pns-test-report-parameter-assesed testing-options' style="margin-top:5px ">
                            <div class='patient-speci-presc-section'>
                                <table style='width:100%;border-radius: 10px;border-spacing: 15px 0px;padding-top: 10px; vertical-align:top; display: inline-block;' border='0' cellspacing='5' cellpadding='10'>
                                    <p class='title'>Further Testing Options:</p>
                                    <tr>
                                        <?php foreach ($furtherTesting as $fRow) { ?>
                                            <td class='patient-speci-presc-tb-parameter'><?= $fRow['name']; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php $width = 100 / count($furtherTesting);
                                        foreach ($furtherTesting as $fRow) { ?>
                                            <td class='patient-speci-presc-tb-def' style="width:<?= $width ?>%">
                                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                                    <tr>
                                                        <td><?= $fRow['resultvalue'] ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </section>
                    <?php } ?>
                    <section class='pns-test-report-parameter-assesed final-risk'>
                        <div class='patient-speci-presc-section'>
                            <?php if (strtoupper($reportdata['risk_type']) == "3LEVEL") {
                                $lowCutoff = '1:250';
                                $highCutoff = '1:250';
                            } elseif (strtoupper($reportdata['risk_type']) == "2LEVEL") {
                                $lowCutoff = '1:250';
                                $highCutoff = '1:250';
                            ?>
                                <style type="text/css">
                                    .pns-test-report-parameter-assesed.final-risk .patient-speci-presc-section .risk-detail {
                                        text-align: center;
                                        padding: 0 40px;
                                        margin: 0 auto;
                                        font-size: 12px;
                                        width: 180px;
                                    }
                                </style>
                            <?php
                            }  ?>


                            <table style='width:100%;border-radius: 10px; height:250px;' border='0' cellspacing='10' cellpadding='10' class="pechange">
                                <p class='title'>Understanding Reported Final Risk:</p>
                                <p class='content'>Prenatal screening gives a risk estimate after analyzing. The risk
                                    estimate is in the form of a ratio. For example, if the reported final risk is <span class='number'>1:1280,</span>
                                    it means that of <span class='number'>1280</span> pregnancies with similar values, one baby is likely to be affected with the screened condition
                                </p>
                                <p class="risk-title title" style="text-align:left;font-size: 13px;margin-top: 1px !important; margin-bottom: -40px;"> Trisomy T21 Cuttoff
                                <p>
                                <tr>
                                    <td class='risk-1'>
                                        <p class='risk-title' style="font-size: 12px;">Increased Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Screen Positive” when the
                                                probability ratio is greater than <span class='number'><?php echo $lowCutoff ?></span> births.</p>
                                    </td>
                                    <?php if (strtoupper($reportdata['risk_type']) != "2LEVEL") { ?>
                                            <td class='risk-2'>
                                                <p class='risk-title' style="font-size: 12px;">Intermediate Risk: </p>
                                                <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Intermediate Probability” when
                                                the probability ratio is within <span class='number'>1:251</span> and <span class='number'>1:1000</span> births.</p>
                                        </td>
                                    <?php } ?>
                                    <td class='risk-3'>
                                        <p class='risk-title' style="font-size: 12px;">Low Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as "Screen Negative" when the probability ratio is lesser&nbsp; than <span class='number'><?php echo $lowCutoff ?></span> births.
                                        </p>
                                    </td>
                                </tr>

                                    <?php if ($marker == "pereport") {
                                        $pelowCutoff = '1:100';
                                        $pehighCutoff = '1:100';
                                    ?>
                                        <style type="text/css">
                                            .pns-test-report-parameter-assesed.final-risk .patient-speci-presc-section .risk-detail {
                                                text-align: center;
                                                /* padding: 0 20px; */
                                                margin: 0 auto;
                                                font-size: 12px;
                                                width: 180px;
                                            }
                                        </style>
                                    <?php
                                    } ?>
                            </table>
                            <table style='width:100%;border-radius: 10px; height:250px;' border='0' cellspacing='10' cellpadding='10' class="pechange">
                                <?php if (count($furtherTesting) > 2) { ?>
                                    <p class="risk-title title" style="text-align:left;font-size: 13px;margin-top: 1px; margin-bottom: -40px;"> Trisomy 13,18 and Preeclampsia Cuttoff
                                    <p>
                                    <?php } else { ?>
                                    <p class="risk-title title" style="text-align:left;font-size: 13px;margin-top: 1px !important; margin-bottom: -40px;"> Trisomy 13,18 and Preeclampsia Cuttoff
                                    <p>
                                    <?php } ?>
                                    <tr>
                                        <td class='risk-1'>
                                            <p class='risk-title'style="font-size: 12px;">Increased Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Screen Positive” when the
                                                probability ratio is greater than <span class='number'><?php echo $pehighCutoff ?></span> births.</p>
                                        </td>
                                        <td class='risk-3'>
                                            <p class='risk-title'style="font-size: 12px;">Low Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as "Screen Negative" when the probability ratio is lesser&nbsp; than <span class='number'><?php echo $pelowCutoff ?></span> births.
                                            </p>
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </section>
                    <table style="margin-top: -5px;">
                        <tr class='disclaimer-main'>
                            <td class='disclaimer-img'><img height="70px;" class='discl-img' src='<?= base_url('images/pns-disclaimer-new.png'); ?>' alt='' /></td>
                            <td class='disclaimer-details'>
                                <p class='title'>Disclaimer</p>
                                <p><span class='number'>1.</span> This interpretation assumes that patient and specimen
                                    details are accurate and correct.</p>
                                <p><span class='number'>2.</span> Ultrasound observations / measurements if not performed as
                                    per imaging guidelines may lead to erroneous risk assessments, and LifeCell does not
                                    bear responsibility for results arising due to such errors</p>
                                <p><span class='number'><b>3.</b></span><b> As per FMF Guidelines, if Down Syndrome final risk is between 251 to 1000, it will be considered as intermediate risk and further testing will be required for confirmation. </b></p>
                            </td>
                        </tr>
                    </table>
                    <p style='text-align: center;margin-bottom: 0rem'>End of Report</p>
                </div>
            </div>
            </div>
</body>

</html>
<script>
    var i = 0;
    var all = $(".current-progress-range").map(function() {
        var i = this.getAttribute('data_id');
        var id = 'pnsValues-value' + "<?php echo $marker ?>" + i;
        var barid = 'pnsValues' + "<?php echo $marker ?>" + i;
        var pnsValues = document.getElementById(id).innerHTML;
        console.log(pnsValues)
        var pnsValuesinput = document.getElementById(id).innerHTML;
        console.log(pnsValuesinput)
        var pnsValuesconverted = pnsValues / 3 * 99;
        //alert('value is =' +pnsValuesconverted);
        var lowlimit = 0;
        var midlimit = 0.5;
        var highlimit = 2;
        var lowrange = 0.5;
        var midrange = 1.5;
        var highrange = 3;
        console.log(pnsValues);
        if (pnsValues < 0.5) {
            if (pnsValues <= 0) {
                pnsValuesconverted = (pnsValues * 33) / lowrange;
            } else if (pnsValues >= 0.25 && pnsValues < 0.4) {
                pnsValuesconverted = (pnsValues * 33) / lowrange - 10;
            } else {
                pnsValuesconverted = (pnsValues * 33) / lowrange - 8;
            }
        } else if (pnsValues >= 0.5 && pnsValues <= 2) {
            if (pnsValues > 0.5 && pnsValues <= 1) {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 35;
            } else if (pnsValues >= 1.5 && pnsValues < 2) {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 25;
            } else {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 29;
            }
        } else if (pnsValues > 2) {

            if (pnsValues >= 2.5 && pnsValues <= 4) {
                pnsValues = pnsValues - highlimit;
                pnsValuesconverted = (pnsValues * 33) / highrange;
                pnsValuesconverted += 68;
            } else {
                pnsValues = pnsValues - highlimit;
                pnsValuesconverted = (pnsValues * 33) / highrange;
                pnsValuesconverted += 71;
            }
        }


        if (pnsValuesconverted >= 95) {
            document.getElementById(barid).style.left = '92%';
        } else if (pnsValuesconverted == 0) {
            document.getElementById(barid).style.left = '0.5%';
        } else {
            document.getElementById(barid).style.left = (pnsValuesconverted) + '%';
        }
        if (pnsValuesinput < 0.5 || pnsValuesinput > 2.0) {
            var element = document.getElementById(id);
            element.classList.add('pns-below-average-content');
        } else {
            var element = document.getElementById(id);
            element.classList.add('pns-above-average-content-green');
        }
    }).get();
    /* If score is below average */
</script>
<script>
    var i = 0;
    var all = $(".current-progress-range").map(function() {
        var i = this.getAttribute('data_id');
        var id = 'pnsValues-value' + "<?php echo $markerreport ?>" + i;
        var barid = 'pnsValues' + "<?php echo $markerreport ?>" + i;
        var pnsValues = document.getElementById(id).innerHTML;
        console.log(pnsValues)
        var pnsValuesinput = document.getElementById(id).innerHTML;
        console.log(pnsValuesinput)
        var pnsValuesconverted = pnsValues / 3 * 99;
        //alert('value is =' +pnsValuesconverted);
        var lowlimit = 0;
        var midlimit = 0.5;
        var highlimit = 2;
        var lowrange = 0.5;
        var midrange = 1.5;
        var highrange = 3;
        console.log(pnsValues);
        if (pnsValues < 0.5) {
            if (pnsValues <= 0) {
                pnsValuesconverted = (pnsValues * 33) / lowrange;
            } else if (pnsValues >= 0.25 && pnsValues < 0.4) {
                pnsValuesconverted = (pnsValues * 33) / lowrange - 10;
            } else {
                pnsValuesconverted = (pnsValues * 33) / lowrange - 8;
            }
        } else if (pnsValues >= 0.5 && pnsValues <= 2) {
            if (pnsValues > 0.5 && pnsValues <= 1) {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 35;
            } else if (pnsValues >= 1.5 && pnsValues < 2) {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 25;
            } else {
                pnsValues = pnsValues - midlimit;
                pnsValuesconverted = (pnsValues * 33) / midrange;
                pnsValuesconverted += 29;
            }
        } else if (pnsValues > 2) {

            if (pnsValues >= 2.5 && pnsValues <= 4) {
                pnsValues = pnsValues - highlimit;
                pnsValuesconverted = (pnsValues * 33) / highrange;
                pnsValuesconverted += 68;
            } else {
                pnsValues = pnsValues - highlimit;
                pnsValuesconverted = (pnsValues * 33) / highrange;
                pnsValuesconverted += 71;
            }
        }


        if (pnsValuesconverted >= 95) {
            document.getElementById(barid).style.left = '92%';
        } else if (pnsValuesconverted == 0) {
            document.getElementById(barid).style.left = '0.5%';
        } else {
            document.getElementById(barid).style.left = (pnsValuesconverted) + '%';
        }
        if (pnsValuesinput < 0.5 || pnsValuesinput > 2.0) {
            var element = document.getElementById(id);
            element.classList.add('pns-below-average-content');
        } else {
            var element = document.getElementById(id);
            element.classList.add('pns-above-average-content-green');
        }
    }).get();
    /* If score is below average */
</script>
<style>
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(2) .patient-speci-presc-tb-def-div tr td,
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(3) .patient-speci-presc-tb-def-div tr td {
        color: #fff !important;
    }

    /* .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(2), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(2), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(3), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(3) {
    background: #ee2915;
    color: #fff !important;
    border: 1px solid #ee2915;
} */

    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(1) .patient-speci-presc-tb-def-div tr td {
        color: #fff !important;
    }

    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(1),
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(1) {
        /* background: #35a382; */
        color: #000 !important;
    }
</style>