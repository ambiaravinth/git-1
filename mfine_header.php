<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PNS Reprot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" > -->
    <link rel="stylesheet" href="<?php echo base_url('css/mfine.css') ?>">
</head>

<body style="background: #FFFBF3 !important;">
    <?php
    /* get POST Data into file */
    $json_data = $postdata;
    /* get Lab ID Primary key for generate report */
    $lab_id = $json_data->PatientDetails[0]->LAB_ID;

    /*Parameter Asses test codes*/
    $testGroupCode = $json_data->TestGroupDetails[0]->TEST_GROUP_CODE;
    //======================= BRANCH ADDRESS START =======================//
    $branch_address = $json_data->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS  ?? "";
    helper('mfine');
    $bracnhAddress = getBranchAddress($branch_address, $setaddressflag, $lab_id, $lims_slims);
    $companyname = $bracnhAddress['companyname'];
    $companyaddress  = $bracnhAddress['companyaddress'];
    $setaddressflag = $bracnhAddress['setaddressflag'];
    //======================= BRANCH ADDRESS END =======================//

    // Load the StoreConfig model to fetch the email recipients
    $configModel = new \App\Models\StoreConfig();

    // Fetch the config value for 'CB_EMAIL_RECIPIENTS'
    $configValue = $configModel->getConfigValue('R_CELL_PROCESSING_CODE');

    // Split the email recipients into an array
    $R_CELL_PROCESSING_CODE = isset($configValue['config_value']) ? explode(',', $configValue['config_value']) : [];

    $reportTitle = '';
    if ($marker != "pereport") {
        unset($reportdata);
    }

    if ((strtolower($setaddressflag) == "no") && !empty($companyaddress)) {
        $reportTitle = $reportdata['reportTitle'] ?? $reportTitle;
        if ($marker == "pereport") {
            $pe = 1;
            if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
                if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                    $reportTitle = 'First Trimester Combined +  Preeclampsia Screening Report';
                    //$doubleMarker = 1;
                } elseif (in_array($testGroupCode, ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE)) {

                    $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
                } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {

                    $reportTitle = 'Second Trimester Triple Marker Screening Report';
                } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {
                    if (substr($testGroupCode, 0, 1) === 's') {
                        $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
                    } else {
                        $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
                    }
                } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {

                    $reportTitle = 'First Trimester Penta Marker Screening Report';
                }
            } else {
                if (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                    $reportTitle = 'First Trimester Combined +  Preeclampsia Screening Report';
                } elseif (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {
                    $reportTitle = 'Second Trimester Triple Marker Screening Report';
                } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {

                    $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
                } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {

                    $reportTitle = 'First Trimester Penta Marker Screening Report';
                } elseif (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
                    $pe = 1;
                }
            }
        } else {
            if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                $reportTitle = 'First Trimester Combined + Preeclampsia Screening Report';
            } elseif (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                $NT_VALUE = isset($json_data->PatientRiskDetails[0]->NT_VALUE) ? $json_data->PatientRiskDetails[0]->NT_VALUE : "";
                if ($testGroupCode == 'DMDELM' || $testGroupCode == 'DMDELMM') {
                    $reportTitle = 'First Trimester Double marker screening';
                } elseif ($NT_VALUE != "") {
                    $reportTitle = 'First Trimester Combined Screening Report ';
                    $showBR = 1;
                } else {
                    $reportTitle = 'First Trimester Double Marker Screening ';
                    $showBioComment = 1;
                }
            } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {

                $reportTitle = 'Second Trimester Triple Marker Screening Report';
            } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {

                $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
            } elseif (in_array($testGroupCode, ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE)) {

                $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
            } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {

                $reportTitle = 'First Trimester Penta Marker Screening Report';
            }
        }
        $reportTitle = $reportdata['reportTitle'] ?? $reportTitle;
        $reportTitle = str_replace("Report", "", $reportTitle);

        if (strpos($reportTitle, "Preeclampsia") !== false) {
            $reportTitle = str_replace("First Trimester Combined +", "First Trimester Combined +\n", $reportTitle);
        } else {
            $reportTitle = str_replace("First Trimester", "First Trimester\n", $reportTitle);
        }
        $reportTitle = str_replace("Second Trimester Quadruple ", "Second Trimester Quadruple\n", $reportTitle);
        $filename = strtolower($testGroupCode) . "_" . "report-" . $lab_id . "-ver-" . $json_data->TestGroupDetails[0]->VERSION_NO;
    }


    ?>


    <?php $actual_link = base_url() . "/";

    ?>
    <div class='report-page' style="padding-bottom:10px;">
        <header class='pns-test-report-header'>
            <table style='width:100%;vertical-align:middle;margin-bottom:15px;'>
                <?php if ((strtolower($setaddressflag) == "no") && !empty($companyaddress)) { ?>
                    <tbody>
                        <tr>
                            <td style='width:40%'>
                                <div class='prod-logo'>
                                    <div class='qrcode-img' style='float:left'>
                                        <?php if ($marker == "pereport" && $pegen == '') { ?>
                                            <img src='<?php echo $actual_link . "qr_codes/pns/mfine/" . $filename; ?>-pe.png' width='100px' height='100px' style='float:left' />
                                        <?php
                                        }
                                        if ($marker == "report") {

                                        ?>
                                            <img src='<?php echo $actual_link . "qr_codes/pns/mfine/" . $filename ?>.png' width='100px' height='100px' style='float:left' />
                                        <?php } ?>

                                    </div>

                                    <div class='qrcode-img' style='float:left'>
                                        <?php if ($marker == "pereport" && $pegen == "pe") { ?>
                                            <img src="<?php echo $qrcode ?>" width='100px' height='100px' style='float:left' />
                                        <?php
                                        } ?>

                                    </div>
                                    <div class='title' style='float:left;display:inline-block;font-weight:bolder'><?php echo nl2br($reportTitle); ?></div>
                                </div>
                            </td>
                            <td style='width:60%;'>
                                <table style='border:none;float:right;' class='comp-logo-details-para'>
                                    <!-- SARAL LOGO -->
                                    <?php if ($json_data->PatientDetails[0]->HOSPITAL_CODE === 'bs8946') { ?>
                                        <tr>
                                            <td>
                                                <div style="font-size:12px;margin-top: -3rem; margin-left:50px;">Processed at:</div>
                                                <img src="<?= base_url('images/pns/mfine-logo.png'); ?>" style='float:right;width:120px;margin-top:5px'>
                                            </td>
                                            <td style="font-size:11px;width:50%">
                                                LifeCell International private Limited</br>
                                                New No.16/9,</br>
                                                Vijayaraghava 1st Lane,</br>
                                                Vijayaraghava Road,</br>
                                                T.Nagar Chennai -</br>
                                                600017.
                                            </td>
                                            <td>
                                                <img src="<?= base_url('images/pns/saral-logo.png'); ?>" style='float:right;width:120px;'>
                                            </td>
                                            <td style="font-size:11px;width:50%">
                                                55B sector 0,,</br>
                                                Sachiwalaya Colony,</br>
                                                Kankarrbagh, Patna-</br>
                                                800020.</br>
                                            </td>
                                            <!-- IHR LOGO -->
                                        <?php } elseif ($json_data->PatientDetails[0]->HOSPITAL_CODE === 'BS3487') { ?>
                                        <tr>
                                            <td>
                                                <div style="font-size:12px;margin-top: -2.25rem; margin-left:50px;">Processed at:</div>
                                                <img src="<?= base_url('images/pns/mfine-logo.png'); ?>" style='float:right;width:120px;margin-top:5px'>
                                            </td>
                                            <td style="font-size:11px;width:50%">
                                                LifeCell International private Limited</br>
                                                New No.16/9,</br>
                                                Vijayaraghava 1st Lane,</br>
                                                Vijayaraghava Road,</br>
                                                T.Nagar Chennai -</br>
                                                600017.</br>
                                            </td>
                                            <td>
                                                <img src="<?= base_url('images/pns/IHR-logo.png'); ?>" style='float:right;width:120px;'>
                                            </td>
                                            <td style="font-size:10px;width:50%">
                                                INSTITUTE OF HUMAN</br>
                                                REPRODUCTION</br>
                                                (A unit of Goenka Nursing Home Pvt. Ltd.)</br>
                                                Guwaha - 781009,</br>
                                                Assam, India,</br>
                                            </td>
                                            <!-- R Cell Logo based on PROCESSING_LOCATION_CODE -->
                                        <?php   } elseif (in_array($json_data->TestGroupDetails[0]->PROCESSING_LOCATION_CODE, $R_CELL_PROCESSING_CODE)) { ?>
                                        <tr>
                                            <td style="width:25%; text-align:left; vertical-align:top; padding-left:300px;">
                                                <table>
                                                    <tr>
                                                        <td style="text-align:left;">
                                                            <img src="<?= base_url('images/pns/R_Cell_logo.png'); ?>" style="width:130px; vertical-align:middle;">
                                                        </td>
                                                        <td style="width:1px; background-color:rgba(0, 0, 0, 0.1); box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);"></td>
                                                        <td style="text-align:left; padding-left:10px;">
                                                            <img src="<?= base_url('images/pns/lc-logo.png'); ?>" style="width:130px; vertical-align:middle;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                         <!-- GENESIS LOGO -->
                                        <?php } elseif($json_data->PatientDetails[0]->BRANCH_CODE == 875) { ?>
                                        <tr>
                                            <td>
                                                <img src="<?= base_url('images/pns/genesis-pns-new.png'); ?>" style='float:right;width:100%;'>
                                            </td>
                                        </tr>    
                                            <!-- LIFECELL LOGO -->
                                        <tr>
                                            <?php   } else { ?>
                                            <td>
                                                <!-- <?php $font_size = "12px;";
                                                        if (strlen(trim($companyaddress)) > 72) {
                                                            $font_size = "12px;";
                                                        }; ?>
                                                <span style='display:inline-block;vertical-align: middle;padding-top:0px;padding-left: 0px;font-size:<?= $font_size ?>;text-align: right; color:#000;margin-right:20px;padding-right:20px;border-right: 2px solid #0a81a0;'>
                                                    <img src="<?= base_url('images/pns/Location.png'); ?>" style='width:12px;margin:0px 0px 0px 8px;'>
                                                    <?= $companyname; ?>
                                                    <?= $companyaddress; ?>
                                                    <br><span><img src="<?= base_url('images/pns/Web.png'); ?>" style='width:16px;margin:0px 0px 0px 8px;'>www.lifecell.in
                                                    </span></span> -->
                                            </td>
                                            <td>
                                                <img src="<?= base_url('images/pns/lc-logo.png'); ?>" style='float:right;'>
                                            </td>
                                            <?php  } ?>
                                        </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        </header>
    </div>
</body>

</html>