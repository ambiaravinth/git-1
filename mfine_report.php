<!DOCTYPE html>
<html>

<head>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
    <link rel="stylesheet" href="<?php echo base_url('css/mfine.css') ?>">
    <style>
        .pns-test-report-parameter-assesed.risk .patient-speci-presc-section .patient-speci-presc-tb-def .patient-speci-presc-tb-def-div {
            padding: 0px 3px;
            font-size: 12px !important;
            /* color: #000 !important; */
            display: inline-table;
            width: 100%;
        }
    </style>
</head>
<?php
ini_set('display_errors', 1);

require_once(APPPATH . 'graph_function_mfine.php');
helper('mfine');
/* get POST Data into file */
$json_data = $postdata;
/* get Lab ID Primary key for generate report */
$lab_id = $json_data->PatientDetails[0]->LAB_ID;

/* Risk Assessment graph requiered variable declation */
$ageRisk = "";
$bioChemicalRisk = "";
$bioChemicalRiskGrph = "";
$riskResultValue = "";
$ageGrph = "";
$footerContent = "";
/* Risk Assessment Test Codes */
$riskTestCodesParams = ['FTSER', 'FTSPR', 'FTSR'];
//Need to get value for age risk ,biobank risk
$riskResult = ['FTSER', 'FTSPR', 'FTSR', 'STSDR', 'STSPR', 'STSER', 'STSNR', 'EPE', 'PRER34', 'PRER37'];
$riskResultTwin = ['FTSRT', 'FTSPT', 'FTSET'];
$ageRiskResult = ['AGERISK', 'AGERISK13', 'AGERISK18', 'AGERISK21'];
$biochemicalRisk = ['BIOCHEMRISK', 'BIOCHEMRISKLC'];


/*STS NT Risk,Pre-Eclampsia <32 Weeks,Pre-Eclampsia <32 Weeks Risk,Pre-Eclampsia <34 Weeks,Pre-Eclampsia <34 Weeks Risk,Pre-Eclampsia <37 Weeks,Pre-Eclampsia <37 Weeks Risk
*/
/*FTS Risk,FTS Risk Twin,STS Down's Risk */
$downSyndomeRisk = ['FTSR', 'STSDR', 'AGERISK', 'AGERISK21', 'BIOCHEMRISK', 'BIOCHEMRISKLC'];

$downSyndomeRiskTwin = ['FTSRT'];

/*FTS Edward Risk,FTS Edward Risk Twin,STS Edward Risk */
$edwardSyndomeRisk = ['FTSER', 'STSER', 'AGERISK18', 'BIOCHEMRISKLC'];
$edwardSyndomeRiskTwin = ['FTSET',];
/*FTS Patau Risk,FTS Patau Risk Twin,STS Patau Risk*/
$patueSyndomeRisk = ['FTSPR', 'STSPR', 'AGERISK13', 'BIOCHEMRISKLC'];
$patueSyndomeRiskTwin = ['FTSPT'];
$ntSyndromeRisk = ['STSNR'];
$ntSyndromeRiskTwin = ['STSNT'];
$peSyndrome32 = ['EPE'];
$peSyndrome34 = ['PRER34'];
$peSyndrome37 = ['PRER37'];
$data = [];
$testCodes = [];

// FTS Flag
$Risk_Name_flag = "";
$FTS_testgroupCodes = ['FTPLGF', 'FTPLGFNIPT', 'FTSDA', 'FTSDS', 'FTSISD', 'FTSPLGF', 'FTSPLGFWN'];

/*Parameter Asses test codes*/
$testGroupCode = $json_data->TestGroupDetails[0]->TEST_GROUP_CODE;

$Prefix_flag = 0;
if (in_array($testGroupCode, $FTS_testgroupCodes)) {
    $Prefix_flag = 1;
}

//$marker = 'pereport';
$TYPE_OF_MEASURE =  $json_data->PatientDetails[0]->TYPE_OF_MEASURE ?? "";
$CONCEPTION = $json_data->PatientDetails[0]->CONCEPTION ?? "";
if ($TYPE_OF_MEASURE == "USG EDD") {
    $TYPE_OF_MEASURE = str_replace("EDD", "", $TYPE_OF_MEASURE);
}
if ($CONCEPTION == "A") {
    $CONCEPTION = "Assisted";
    $TYPE_OF_MEASURE = "Ass Rep.";
}
//** IF RISK_TYPE IS NULL THEN SET DEFAULT 3 LEVEL */
$risk_type =  $json_data->PatientDetails[0]->RISK_TYPE ?? "2LEVEL";
$branch_address = $json_data->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS  ?? "";
$uk_neqas_logo = str_contains(strtolower($branch_address), 'chennai');
if ($risk_type == "") {
    $risk_type = "2LEVEL";
}

$doubleMarker = 0;
$tripleMarker = 0;
$quadrapleMarker = 0;
$onetquadrapleMarker = 0;
$pentaMarker = 0;
$pe = 0;
$reportTitle = '';
$showBR = 0;
$showBioComment = 0;
$pereport = 0;
if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
    $pereport = 1;
}
if ($marker == "pereport") {
    $pe = 1;
    if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
        $pe = 1;
        if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
            $reportTitle = 'First Trimester Combined +  Preeclampsia Screening ';
            //$doubleMarker = 1;
        } elseif (in_array($testGroupCode, ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE)) {
            $onetquadrapleMarker = 1;

            $reportTitle = 'First Trimester Quadruple Marker Screening  ';
        } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {

            $reportTitle = 'Second Trimester Triple Marker Screening ';
        } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {
            if (substr($testGroupCode, 0, 1) === 's') {
                $reportTitle = 'Second Trimester Quadruple Marker Screening ';
            } else {
                $reportTitle = 'First Trimester Quadruple Marker Screening  ';
            }
        } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {

            $reportTitle = 'First Trimester Penta Marker Screening ';
        }
    } else {
        if (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
            $reportTitle = 'First Trimester Combined +  Preeclampsia Screening ';
            $doubleMarker = 1;
        } elseif (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
            $doubleMarker = 1;
        } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {
            $tripleMarker = 1;
            $reportTitle = 'Second Trimester Triple Marker Screening ';
        } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {

            $reportTitle = 'Second Trimester Quadruple Marker Screening ';
        } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {
            $pentaMarker = 1;

            $reportTitle = 'First Trimester Penta Marker Screening ';
        } elseif (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
            $pe = 1;
        }
    }
} else {
    if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
        $reportTitle = 'First Trimester Combined +  Preeclampsia Screening ';
        $doubleMarker = 1;
    } elseif (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
        $NT_VALUE = isset($json_data->PatientRiskDetails[0]->NT_VALUE) ? $json_data->PatientRiskDetails[0]->NT_VALUE : "";
        if ($testGroupCode == 'DMDELM' || $testGroupCode == 'DMDELMM') {
            $reportTitle = 'First Trimester Double marker screening';
        } elseif ($NT_VALUE != "") {
            $reportTitle = 'First Trimester Combined Screening ';
            $showBR = 1;
        } else {
            $reportTitle = 'First Trimester Double Marker Screening ';
            $showBioComment = 1;
        }
        $doubleMarker = 1;
    } elseif (in_array($testGroupCode, TRIPLE_MARKER_TEST_GROUP_CODE)) {
        $tripleMarker = 1;

        $reportTitle = 'Second Trimester Triple Marker Screening ';
    } elseif (in_array($testGroupCode, QUADRUPLE_MARKER_TEST_GROUP_CODE)) {
        $quadrapleMarker = 1;

        $reportTitle = 'Second Trimester Quadruple Marker Screening ';
    } elseif (in_array($testGroupCode, ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE)) {
        $onetquadrapleMarker = 1;

        $reportTitle = 'First Trimester Quadruple Marker Screening  ';
    } elseif (in_array($testGroupCode, PENTA_MARKER_TEST_GROUP_CODE)) {
        $pentaMarker = 1;

        $reportTitle = 'First Trimester Penta Marker Screening ';
    }
}
if ($doubleMarker) {
    $testCodes = DOUBLE_MARKER_PARAMETERS_ASSESED;
    $momCodes = DOUBLE_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
} elseif ($tripleMarker) {
    $testCodes = TRIPLE_MARKER_PARAMETERS_ASSESED;
    $momCodes = TRIPLE_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
} elseif ($quadrapleMarker) {
    $testCodes = QUADRUPLE_MARKER_PARAMETERS_ASSESED;
    $momCodes = QUADRUPLE_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
} elseif ($onetquadrapleMarker) {

    $testCodes = ONET_QUADRUPLE_MARKER_PARAMETERS_ASSESED;
    $momCodes = ONET_QUADRUPLE_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
} elseif ($pentaMarker) {
    $testCodes = PENTA_MARKER_PARAMETERS_ASSESED;
    $momCodes = PENTA_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
}
if ($pe) {

    $testCodes = PENTA_PE_MARKER_PARAMETERS_ASSESED;
    $momCodes = PENTA_PE_MARKER_MOM_PARAMETERS_ASSESED;
    $data['parameter_assed'] = $testCodes;
}

/* Start Risk Assessment Test code merge based on Test Group*/
$riskTestCodes = [];

if (!isset($pe) || $pe == 0) {

    $riskTestCodes = array_merge($riskTestCodes, DOWN_SYNDROME);
    $riskTestCodes = array_merge($riskTestCodes, EDWARD_SYNDROME);
    $riskTestCodes = array_merge($riskTestCodes, PATAU_SYNDROME);
    $riskTestCodes = array_merge($riskTestCodes, NEURAL_TUBE_DEFECTS);
} else {

    $riskTestCodes = array_merge($riskTestCodes, PE_32);
    $riskTestCodes = array_merge($riskTestCodes, PE_34);
    $riskTestCodes = array_merge($riskTestCodes, PE_37);
}

$data["risk_test_codes"] = $riskTestCodes;
$fts_flag = $fts_penta_flag = $sts_flag = 0;
$testresults = array();
$printingName = array();
$testresultsparameter = array();
$printingNameparameter = array();
$momTestResults = $json_data->TestResultDetails;
$data['no_of_foetus'] = isset($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB) ? ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB) : '';
if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRE-ECLAMPSIA") {
    $json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME = "LIFECYCLE";
}
$data['risk_software_method'] = isset($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME) ? ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME) : '';

/* Interpretation variable declared */
$comment = "";
$comment_flag = 0;
$interpretation = "";
$furtherTesting = [];
$CEDD = [];
$GA = [];
$GA_CODES = ['GAATSAMPLELC', 'GAATSCANLC', 'GAATSAMPLE', 'GAATSAMPLEDAYS', 'GAATSCAN', 'GAATSCANDAYS'];
if (isset($json_data->TestResultDetails)) {
    $finalOutPut = [];
    $riskType = $json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME;
    foreach ($json_data->TestResultDetails as $resultData) {
        if ($riskType === 'LIFECYCLE') {
            if ($resultData->TEST_CODE === "FTSC1" && !empty($resultData->RESULT_VALUE)) {
                $comment .= $resultData->RESULT_VALUE . "\n";
                $comment_flag = 1;
            }
        }
        if ($riskType === 'LIFECYCLE') {
            if ($resultData->TEST_CODE === "STSC1" && !empty($resultData->RESULT_VALUE)) {
                $comment .= $resultData->RESULT_VALUE . "\n";
                $comment_flag = 1;
            }
        }
        if ($riskType === 'PRISCA') {
            if ($resultData->TEST_CODE === "FTSC1" && !empty($resultData->RESULT_VALUE)) {
                $comment .= $resultData->RESULT_VALUE . "\n";
                $comment_flag = 1;
            }
        }
        if (in_array($resultData->TEST_CODE, $GA_CODES)) {
            $GA[$resultData->TEST_CODE]['print_name'] = $resultData->TEST_NAME;
            $GA[$resultData->TEST_CODE]['result_value'] = $resultData->RESULT_VALUE;
        }

        if ($resultData->TEST_NAME === "Calculated EDD") {
            $CEDD[$resultData->TEST_CODE] = $resultData->RESULT_VALUE;
        }

        if ($resultData->TEST_NAME === "NIPT comment" && !empty($resultData->RESULT_VALUE)) {
            $furtherTesting[$resultData->TEST_CODE]['resultvalue'] = $resultData->RESULT_VALUE;
            $furtherTesting[$resultData->TEST_CODE]['name'] = "Non-Invasive Prenatal Testing";
            $furtherTesting[$resultData->TEST_CODE]['sort'] = 1;
        }

        if ($resultData->TEST_NAME === "USG comment" && !empty($resultData->RESULT_VALUE)) {
            $furtherTesting[$resultData->TEST_CODE]['resultvalue'] = $resultData->RESULT_VALUE;
            $furtherTesting[$resultData->TEST_CODE]['name'] = "Genetic Sonogram /Anomaly Scan";
            $furtherTesting[$resultData->TEST_CODE]['sort'] = 2;
        }

        if ($resultData->TEST_NAME == "CVS/AF comment" && !empty($resultData->RESULT_VALUE)) {
            $furtherTesting[$resultData->TEST_CODE]['resultvalue'] = $resultData->RESULT_VALUE;
            $furtherTesting[$resultData->TEST_CODE]['name'] = "Chorionic Villi Sampling /Amniocentesis";
            $furtherTesting[$resultData->TEST_CODE]['sort'] = 3;
        }

        if ($resultData->TEST_NAME == "Clinical Comments" && !empty($resultData->RESULT_VALUE)) {
            $furtherTesting[$resultData->TEST_CODE]['resultvalue'] = $resultData->RESULT_VALUE;
            $furtherTesting[$resultData->TEST_CODE]['name'] = "Clinical comments";
            $furtherTesting[$resultData->TEST_CODE]['sort'] = 4;
        }

        if ($resultData->TEST_NAME == "FTS Interpretation" && $fts_flag == 0) {
            $interpretation .= $resultData->RESULT_VALUE . "\n";
            $fts_flag = 1;
        }

        if ($resultData->TEST_CODE == "PENTAINTERPE" && $fts_penta_flag == 0 && $marker == "pereport") {
            $interpretation .= $resultData->RESULT_VALUE . "\n";
            $interpretation .= str_replace(["Trimester/", "Trimester"], "", $resultData->RESULT_VALUE) . "\n";
            $fts_penta_flag = 1;
        }

        if ($resultData->TEST_CODE == "PENTAINTERWOPE" && $fts_penta_flag == 0 && $pereport == 1  && $marker == "report") {
            $interpretation .= str_replace(["/", "Preeclampsia"], "", $resultData->RESULT_VALUE) . "\n";
            $fts_penta_flag = 1;
        }

        // if ($resultData->TEST_NAME == "FTS Penta Interpretation" && $fts_penta_flag == 0) {
        //     $interpretation .= $resultData->RESULT_VALUE . "\n";
        //     $fts_penta_flag = 1;
        // }
        if ($resultData->TEST_NAME == "STS Interpretation" && $sts_flag == 0) {
            $interpretation .= $resultData->RESULT_VALUE . "\n";
            $sts_flag = 1;
        }

        $momValue = "";
        if (in_array($resultData->TEST_CODE, $testCodes)) {

            $momValue = "";
            foreach ($momTestResults as $momtestResult) {
                $momTestCode = trim($momCodes[$resultData->TEST_CODE]);
                if (trim($momtestResult->TEST_CODE) == $momTestCode) {
                    $momValue = $momtestResult->RESULT_VALUE;
                }
            }
            $data[$resultData->TEST_CODE] = [
                'result_value' => $resultData->RESULT_VALUE,
                'mom_value' => $momValue,
                'printing_name' => $resultData->PRINTING_NAME,
                'uom_value' => $resultData->UOM,
            ];
            if (array_key_exists($resultData->TEST_CODE, FOOTER_ABBREVATION)) {
                $footerAbbrevation = FOOTER_ABBREVATION;
                $resultValue = $footerAbbrevation[$resultData->TEST_CODE];
                $footerContent .= $resultData->PRINTING_NAME . ":" . $resultValue . " | ";
            }
            if ($resultData->TEST_CODE == 'DIA') {
                $footerContent .= 'ELISA:' . 'Enzyme-linked immunoassay |';
            }
        }

        /*Risk Assesment data*/
        if (in_array($resultData->TEST_CODE, $riskTestCodes)) {
            $ageRisk = "";
            $finalRiskGrph = "";
            $bioChemicalRisk = "";
            $ageGrph = "";
            if (in_array($resultData->TEST_CODE, DOWN_SYNDROME)) {
                $riskResultValueTwin = "";
                $riskResultValue = "";
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'biochemical_risk' => '',
                    'biochemical_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'risk_result' => '',
                    'risk_result_twin' => '',
                    'syndrome' => 'down'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $downSyndomeRisk)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            $agegraphValue = explode(":", $ageRisk);
                            if (count($agegraphValue) == 2) {
                                if (isset($agegraphValue[1]) && !empty($agegraphValue[1]) && $agegraphValue[1] != "N/A") {
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } else {
                                    updateFailedReportLog($lab_id, 2, "Incorrect Age graph value");
                                    echo "ageriskissue";
                                    return;
                                }
                            } else {
                                $ageGrph = $agegraphValue[0];
                            }
                        } elseif (in_array($momtestResult->TEST_CODE, $biochemicalRisk)) {
                            $bioChemicalRisk = $momtestResult->RESULT_VALUE;
                            $bioChemicalgraphValue = explode(":", $bioChemicalRisk);
                            if ($bioChemicalgraphValue != '') {
                                if (count($bioChemicalgraphValue) == 2) {
                                    if ($bioChemicalgraphValue[0] == "<1") {
                                        $bioChemicalgraphValue[0] = 1;
                                    }
                                    if ($bioChemicalgraphValue[0] == ">1") {
                                        $bioChemicalgraphValue[0] = 1;
                                    }
                                    if (is_numeric($bioChemicalgraphValue[0]) && is_numeric($bioChemicalgraphValue[1])) {
                                        $bioChemicalRiskGrph = $bioChemicalgraphValue[0] / $bioChemicalgraphValue[1];
                                    } else {
                                        $bioChemicalRiskGrph = $bioChemicalgraphValue[0] / $bioChemicalgraphValue[1];
                                    }
                                } else {
                                    $bioChemicalRiskGrph = $bioChemicalgraphValue[0];
                                }
                            }
                        }
                    }
                    if ($data['no_of_foetus'] == 2) {
                        if (strpos($resultData->PRINTING_NAME, 'Twin') !== false) {
                            if (in_array($momtestResult->TEST_CODE, $downSyndomeRiskTwin)) {
                                if (in_array($momtestResult->TEST_CODE, $riskResultTwin)) {
                                    $riskResultValueTwin = $momtestResult->RESULT_VALUE;
                                } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                                    $ageRisk = $momtestResult->RESULT_VALUE;
                                    $agegraphValue = explode(":", $ageRisk);
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } elseif (in_array($momtestResult->TEST_CODE, $biochemicalRisk)) {
                                    $bioChemicalRisk = $momtestResult->RESULT_VALUE;
                                    $bioChemicalgraphValue = explode(":", $bioChemicalRisk);
                                    $bioChemicalRiskGrph = $bioChemicalgraphValue[0] / $bioChemicalgraphValue[1];
                                }
                            }
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 10), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'biochemical_risk' => $showBR == 0 ? '' : $bioChemicalRisk,
                    'biochemical_risk_graph_value' => $showBR == 0 ? '' : $bioChemicalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'risk_result_twin' => $riskResultValueTwin,
                    'syndrome' => 'down'
                ];
            } elseif (in_array($resultData->TEST_CODE, EDWARD_SYNDROME)) {
                $riskResultValueTwin = "";
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'risk_result' => '',
                    'risk_result_twin' => '',
                    'syndrome' => 'edward'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $edwardSyndomeRisk)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            if ($ageRisk != '') {
                                $agegraphValue = explode(":", $ageRisk);
                                if (isset($agegraphValue[1]) && !empty($agegraphValue[1]) && $agegraphValue[1] != "N/A") {
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } else {
                                    updateFailedReportLog($lab_id, 2, "Incorrect Age Risk");
                                    echo "ageriskissue";
                                    return;
                                }
                            }
                        }
                    }

                    if ($data['no_of_foetus'] == 2) {
                        if (strpos($resultData->PRINTING_NAME, 'Twin') !== false) {
                            if (in_array($momtestResult->TEST_CODE, $edwardSyndomeRiskTwin)) {
                                if (in_array($momtestResult->TEST_CODE, $riskResultTwin)) {
                                    $riskResultValueTwin = $momtestResult->RESULT_VALUE;
                                } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                                    $ageRisk = $momtestResult->RESULT_VALUE;
                                    $agegraphValue = explode(":", $ageRisk);
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } elseif (in_array($momtestResult->TEST_CODE, $biochemicalRisk)) {
                                    $bioChemicalRisk = $momtestResult->RESULT_VALUE;
                                    $bioChemicalgraphValue = explode(":", $bioChemicalRisk);
                                    $bioChemicalRiskGrph = $bioChemicalgraphValue[0] / $bioChemicalgraphValue[1];
                                }
                            }
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);

                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 100), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'risk_result' => $riskResultValue,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result_twin' => $riskResultValueTwin,
                    'syndrome' => 'edward'
                ];
            } elseif (in_array($resultData->TEST_CODE, PATAU_SYNDROME)) {
                $riskResultValueTwin = "";
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'syndrome' => 'patau'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $patueSyndomeRisk)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            if ($ageRisk != '') {
                                $agegraphValue = explode(":", $ageRisk);
                                if (isset($agegraphValue[1]) && !empty($agegraphValue[1]) && $agegraphValue[1] != "N/A") {
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } else {
                                    updateFailedReportLog($lab_id, 2, "Incorrect Age Risk");
                                    echo "ageriskissue";
                                    return;
                                }
                            }
                        }
                    }

                    if ($data['no_of_foetus'] == 2) {
                        if (strpos($resultData->PRINTING_NAME, 'Twin') !== false) {
                            if (in_array($momtestResult->TEST_CODE, $patueSyndomeRiskTwin)) {
                                if (in_array($momtestResult->TEST_CODE, $riskResultTwin)) {
                                    $riskResultValueTwin = $momtestResult->RESULT_VALUE;
                                } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                                    $ageRisk = $momtestResult->RESULT_VALUE;
                                    $agegraphValue = explode(":", $ageRisk);
                                    $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                } elseif (in_array($momtestResult->TEST_CODE, $biochemicalRisk)) {
                                    $bioChemicalRisk = $momtestResult->RESULT_VALUE;
                                    $bioChemicalgraphValue = explode(":", $bioChemicalRisk);
                                    $bioChemicalRiskGrph = $bioChemicalgraphValue[0] / $bioChemicalgraphValue[1];
                                }
                            }
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 10), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'risk_result_twin' => $riskResultValueTwin,
                    'syndrome' => 'patau'
                ];
            } elseif (in_array($resultData->TEST_CODE, NEURAL_TUBE_DEFECTS)) {
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'syndrome' => 'ntsyndrome'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $ntSyndromeRisk)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            $agegraphValue = explode(":", $ageRisk);
                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 100), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }

                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'syndrome' => 'ntsyndrome'
                ];
            } elseif (in_array($resultData->TEST_CODE, PE_32)) {
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'syndrome' => 'ntsyndrome'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $peSyndrome32)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            $agegraphValue = explode(":", $ageRisk);
                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 100), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }

                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'syndrome' => 'pe_32'
                ];
            } elseif (in_array($resultData->TEST_CODE, PE_34)) {
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'syndrome' => 'ntsyndrome'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $peSyndrome34)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            $agegraphValue = explode(":", $ageRisk);
                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 100), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }

                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'syndrome' => 'pe_34'
                ];
            } elseif (in_array($resultData->TEST_CODE, PE_37)) {
                $data[$resultData->TEST_CODE] = [
                    'final_risk' => '',
                    'final_risk_graph_value' => '',
                    'age_risk' => '',
                    'age_risk_graph_value' => '',
                    'syndrome' => 'ntsyndrome'
                ];
                foreach ($momTestResults as $momtestResult) {
                    if (in_array($momtestResult->TEST_CODE, $peSyndrome37)) {
                        if (in_array($momtestResult->TEST_CODE, $riskResult)) {
                            $riskResultValue = $momtestResult->RESULT_VALUE;
                        } elseif (in_array($momtestResult->TEST_CODE, $ageRiskResult)) {
                            $ageRisk = $momtestResult->RESULT_VALUE;
                            $agegraphValue = explode(":", $ageRisk);
                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                        }
                    }
                }
                $finalRiskGrphValue = explode(":", $resultData->RESULT_VALUE);
                if (count($finalRiskGrphValue) == 2) {

                    $finalRiskGrphValue[0] = str_replace('>', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrphValue[0] = str_replace('<', 0, $finalRiskGrphValue[0]);
                    $finalRiskGrph = number_format($finalRiskGrphValue[0] / $finalRiskGrphValue[1], 7);
                    if ($finalRiskGrph > '0.01') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] * 2), 7);
                    } elseif ($finalRiskGrph < '0.0001') {
                        $finalRiskGrph = number_format($finalRiskGrphValue[0] / ($finalRiskGrphValue[1] / 100), 7);
                    }
                } else {

                    $finalRiskGrph = 0;
                }

                $data[$resultData->TEST_CODE] = [
                    'final_risk' => $resultData->RESULT_VALUE,
                    'final_risk_graph_value' => $finalRiskGrph,
                    'age_risk' => $ageRisk,
                    'age_risk_graph_value' => $ageGrph,
                    'risk_result' => $riskResultValue,
                    'syndrome' => 'pe_37'
                ];
            }
        }
    }

    if (in_array("NT", $testCodes)) {
        $momValue2 = "";
        foreach ($momTestResults as $momtestResult) {

            if ($data['no_of_foetus'] == 2) {
                $momTestCode1 = trim($momCodes["NT"]);
                if (trim($momtestResult->TEST_CODE) == $momTestCode1) {
                    $momValue = $momtestResult->RESULT_VALUE;
                }
                $momTestCode2 = trim($momCodes["NT2"]);
                if (trim($momtestResult->TEST_CODE) == $momTestCode2) {
                    $momValue2 = $momtestResult->RESULT_VALUE;
                }
            } else {
                $momTestCode = trim($momCodes["NT"]);
                if (trim($momtestResult->TEST_CODE) == $momTestCode) {
                    $momValue = $momtestResult->RESULT_VALUE;
                }
            }
        }
        $data['NT'] = [
            'result_value' => $json_data->PatientRiskDetails[0]->NT_VALUE ?? "N/A",
            'mom_value' => $momValue ? $momValue : 0,
            'printing_name' => 'NT',
            'uom_value' => 'mm',
        ];
        if ($data['no_of_foetus'] == 2 && !empty($momValue2)) {
            $data['NT2'] = [
                'result_value' => $json_data->PatientRiskDetails[0]->NT_VALUE_2 ?? "N/A",
                'mom_value' => $momValue2 ? $momValue2 : 0,
                'printing_name' => 'NT2',
                'uom_value' => 'mm',
            ];
        }
        if (array_key_exists('NT', FOOTER_ABBREVATION)) {
            $footerAbbrevation = FOOTER_ABBREVATION;
            $resultValue = $footerAbbrevation['NT'];
            $footerContent .= "NT:" . $resultValue . " | ";
        }
    }
    if (array_key_exists('MoM', FOOTER_ABBREVATION)) {
        $footerAbbrevation = FOOTER_ABBREVATION;
        $resultValue = $footerAbbrevation['MoM'];
        $footerContent .= 'MoM' . ":" . $resultValue . " | ";
    }
    if ($data['risk_software_method'] == 'LIFECYCLE') {
        $footerContent .= 'TRF:Time Resolved Fluroimmunoassay on Auto-Delfia | ';
    } else {
        $footerContent .= 'CLIA:Chemi Luminescence | ';
    }

    $GA_MAPPING = "";
    if ($data['risk_software_method'] == "LIFECYCLE") {
        if (isset($GA['GAATSAMPLELC']['result_value']) && !empty($GA['GAATSAMPLELC']['result_value'])) {
            $result_value = ($GA['GAATSAMPLELC']['result_value']) / 7;
            if (is_float($result_value)) {
                list($weeks, $days) = explode('.', $result_value);
                $days_in_decimal = $result_value - $weeks;
                $GA_MAPPING .= $weeks . " WEEKS " . round(($days_in_decimal * 7)) . " DAYS";
            } else {
                $GA_MAPPING .= $result_value . " WEEKS " . "0 DAYS";
            }
        }

        if (empty($GA_MAPPING)) {
            if (isset($GA['GAATSCANLC']['result_value']) && !empty($GA['GAATSCANLC']['result_value'])) {
                $result_value = ($GA['GAATSCANLC']['result_value']) / 7;
                list($weeks, $days) = explode('.', $result_value);
                $GA_MAPPING .= $weeks . " WEEKS " . $days[0] . " DAYS";
            }
        }
    }

    if ($data['risk_software_method'] == "PRISCA") {
        if (isset($GA['GAATSAMPLE']['result_value']) && !empty($GA['GAATSAMPLE']['result_value'])) {
            $GA_MAPPING .= $GA['GAATSAMPLE']['result_value'] . " WEEKS ";
        }

        if (isset($GA['GAATSAMPLEDAYS']['result_value']) && !empty($GA['GAATSAMPLEDAYS']['result_value'])) {
            $GA_MAPPING .= $GA['GAATSAMPLEDAYS']['result_value'] . " DAYS";
        }

        if (empty($GA_MAPPING)) {
            if (isset($GA['GAATSCAN']['result_value']) && !empty($GA['GAATSCAN']['result_value'])) {
                $GA_MAPPING .= $GA['GAATSCAN']['result_value'] . " WEEKS";
            }

            if (isset($GA['GAATSCANDAYS']['result_value']) && !empty($GA['GAATSCANDAYS']['result_value'])) {
                $GA_MAPPING .= $GA['GAATSCANDAYS']['result_value'] . " DAYS";
            }
        }
    }

    if (isset($data['parameter_assed'])) {
        foreach ($data['parameter_assed'] as $parametertestCode) {
            if (isset($data[$parametertestCode]) && !empty($data[$parametertestCode]['result_value'])) {
                $testresultsparameter[$parametertestCode] = $data[$parametertestCode];
                $printingNameparameter[] = $data[$parametertestCode]['printing_name'];
            }
        }
    }
    $finalOutPut['codes']  = $testresultsparameter;
    $finalOutPut['printingNames']  = $printingNameparameter;
    $parameterResult = $finalOutPut['codes'];


    foreach ($data['risk_test_codes'] as $risktestCode) {
        if (isset($data[$risktestCode])) {
            if ($data[$risktestCode]['syndrome'] == 'down' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['down'][$risktestCode] = $data[$risktestCode];
                $downsyndrome_risk_color = "low_risk";
                $downsyndrome_border_color = "low_risk_border";
                $downsyndrome_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $downsyndrome_risk_color = "low_risk";
                //     $downsyndrome_border_color = "low_risk_border";
                //     $downsyndrome_risk_text = "low_risk_text";
                // }
                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $downsyndrome_risk_color = "intermediate_risk";
                    $downsyndrome_border_color = "intermediate_risk_border";
                    $downsyndrome_risk_text = "intermediate_risk_text";
                }
                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $downsyndrome_risk_color = "increased_risk";
                    $downsyndrome_border_color = "increased_risk_border";
                    $downsyndrome_risk_text = "increased_risk_text";
                }

                $printingName['down'] = 'Down Syndrome (T21)';
                $Risk_Name_flag = "T21";
            } else if ($data[$risktestCode]['syndrome'] == 'edward' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['edward'][$risktestCode] = $data[$risktestCode];
                $edward_risk_color = "low_risk";
                $edward_border_color = "low_risk_border";
                $edward_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $edward_risk_color = "low_risk";
                //     $edward_border_color = "low_risk_border";
                //     $edward_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $edward_risk_color = "intermediate_risk";
                    $edward_border_color = "intermediate_risk_border";
                    $edward_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $edward_risk_color = "increased_risk";
                    $edward_border_color = "increased_risk_border";
                    $edward_risk_text = "increased_risk_text";
                }
                $printingName['edward'] = 'Edward Syndrome (T18)';
            } else if ($data[$risktestCode]['syndrome'] == 'patau' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['patau'][$risktestCode] = $data[$risktestCode];
                $patau_risk_color = "low_risk";
                $patau_border_color = "low_risk_border";
                $patau_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $patau_risk_color = "low_risk";
                //     $patau_border_color = "low_risk_border";
                //     $patau_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $patau_risk_color = "intermediate_risk";
                    $patau_border_color = "intermediate_risk_border";
                    $patau_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $patau_risk_color = "increased_risk";
                    $patau_border_color = "increased_risk_border";
                    $patau_risk_text = "increased_risk_text";
                }

                $printingName['patau'] = 'Patau Syndrome (T13)';
            } elseif ($data[$risktestCode]['syndrome'] == 'ntsyndrome' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['ntsyndrome'][$risktestCode] = $data[$risktestCode];
                $ntsyndrome_risk_color = "low_risk";
                $ntsyndrome_border_color = "low_risk_border";
                $ntsyndrome_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $ntsyndrome_risk_color = "low_risk";
                //     $ntsyndrome_border_color = "low_risk_border";
                //     $ntsyndrome_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $ntsyndrome_risk_color = "intermediate_risk";
                    $ntsyndrome_border_color = "intermediate_risk_border";
                    $ntsyndrome_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $ntsyndrome_risk_color = "increased_risk";
                    $ntsyndrome_border_color = "increased_risk_border";
                    $ntsyndrome_risk_text = "increased_risk_text";
                }

                $printingName['ntsyndrome'] = 'Neural Tube Defects (NTD)';
            } elseif ($data[$risktestCode]['syndrome'] == 'pe_32' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['pe_32'][$risktestCode] = $data[$risktestCode];
                $pe_32_risk_color = "low_risk";
                $pe_32_border_color = "low_risk_border";
                $pe_32_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $pe_32_risk_color = "low_risk";
                //     $pe_32_border_color = "low_risk_border";
                //     $pe_32_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $pe_32_risk_color = "intermediate_risk";
                    $pe_32_border_color = "intermediate_risk_border";
                    $pe_32_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $pe_32_risk_color = "increased_risk";
                    $pe_32_border_color = "increased_risk_border";
                    $pe_32_risk_text = "increased_risk_text";
                }

                $printingName['pe_32'] = 'PE <32 weeks';
            } elseif ($data[$risktestCode]['syndrome'] == 'pe_34' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['pe_34'][$risktestCode] = $data[$risktestCode];
                $pe_34_risk_color = "low_risk";
                $pe_34_border_color = "low_risk_border";
                $pe_32_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $pe_34_risk_color = "low_risk";
                //     $pe_34_border_color = "low_risk_border";
                //     $pe_32_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $pe_34_risk_color = "intermediate_risk";
                    $pe_34_border_color = "intermediate_risk_border";
                    $pe_32_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $pe_34_risk_color = "increased_risk";
                    $pe_34_border_color = "increased_risk_border";
                    $pe_32_risk_text = "increased_risk_text";
                }

                $printingName['pe_34'] = 'PE <34 weeks';
            } elseif ($data[$risktestCode]['syndrome'] == 'pe_37' && !empty($data[$risktestCode]['final_risk'])) {
                $testresults['pe_37'][$risktestCode] = $data[$risktestCode];
                $pe_37_risk_color = "low_risk";
                $pe_37_border_color = "low_risk_border";
                $pe_32_risk_text = "low_risk_text";
                // if(strtolower($data[$risktestCode]['risk_result']) == "low risk"){
                //     $pe_37_risk_color = "low_risk";
                //     $pe_37_border_color = "low_risk_border";
                //     $pe_32_risk_text = "low_risk_text";
                // }

                if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                    $pe_37_risk_color = "intermediate_risk";
                    $pe_37_border_color = "intermediate_risk_border";
                    $pe_32_risk_text = "intermediate_risk_text";
                }

                if (strtolower($data[$risktestCode]['risk_result']) == "increased risk") {
                    $pe_37_risk_color = "increased_risk";
                    $pe_37_border_color = "increased_risk_border";
                    $pe_32_risk_text = "increased_risk_text";
                }

                $printingName['pe_37'] = 'PE <37 weeks';
            }
        }
    }
    $finalRiskData['codes']  = $testresults;
    $finalRiskData['printingNames']  = $printingName;
    $finalRiskData['risk_software_method'] = $data['risk_software_method'];
}


$riskResult = $finalRiskData['codes'];

/**Ticket:SR-263 */

$risk_result = 1;
if ($data['no_of_foetus'] == 2) {
    $risk_result = checkRiskMatrixTwin($lab_id, $riskResult, $json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME, $reportTitle, $is_pdf, $testGroupCode);
} else {
    $risk_result = checkRiskMatrix($lab_id, $riskResult, $json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME, $reportTitle, $is_pdf, $testGroupCode);
}

// if($risk_result!=1){
//     echo $risk_result;
//     return $risk_result;
// }



$riskSoftwareMethod = $finalRiskData['risk_software_method'];
$riskSoftwareMethodByPrint = $finalRiskData['risk_software_method'];
if ($riskSoftwareMethod == 'LIFECYCLE') {
    $riskSoftwareMethod = $riskSoftwareMethod . " v7.0";
} else {
    $riskSoftwareMethod = $riskSoftwareMethod . " v5.0";
}
$downSyndrome = isset($riskResult['down']) ? $riskResult['down'] : [];
$edwardSyndrome = isset($riskResult['edward']) ? $riskResult['edward'] : [];
$patueSyndrome = isset($riskResult['patau']) ? $riskResult['patau'] : [];
$ntSyndrome = isset($riskResult['ntsyndrome']) ? $riskResult['ntsyndrome'] : [];

$ftclass = "first-trimester";
if (!empty($downSyndrome) && !empty($edwardSyndrome) && !empty($patueSyndrome) && !empty($ntSyndrome)) {
    $ftclass = "";
}

$pe32 = isset($riskResult['pe_32']) ? $riskResult['pe_32'] : [];
$pe34 = isset($riskResult['pe_34']) ? $riskResult['pe_34'] : [];
$pe37 = isset($riskResult['pe_37']) ? $riskResult['pe_37'] : [];
$printingNamesOfRisk = $finalRiskData['printingNames'];
$printingNamesOfParameter = $finalOutPut['printingNames'];
$prior_risk = "";

// twin case Down Syndrome (T21), Edward Syndrome (T18), Patau Syndrome (T13), ntSyndrome,pe32,pe34,pe37 color code
if($data['no_of_foetus'] == 2){
    $keys = array_keys($downSyndrome);
    $count_key = count($keys);
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $downSyndrome[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $downsyndrome_risk_color = "increased_risk";
                $downsyndrome_border_color = "increased_risk_border";
                $downsyndrome_risk_text = "increased_risk_text";
            } elseif (
                $downSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $downsyndrome_risk_color = "intermediate_risk";
                $downsyndrome_border_color = "intermediate_risk_border";
                $downsyndrome_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $downsyndrome_risk_color = "low_risk";
                $downsyndrome_border_color = "low_risk_border";
                $downsyndrome_risk_text = "low_risk_text";
            }
    }else{
            if (
                $downSyndrome[$keys[0]]['risk_result'] == "Increased Risk" ||
                $downSyndrome[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $downsyndrome_risk_color = "increased_risk";
                $downsyndrome_border_color = "increased_risk_border";
                $downsyndrome_risk_text = "increased_risk_text";
            } elseif (
                $downSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $downSyndrome[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $downsyndrome_risk_color = "intermediate_risk";
                $downsyndrome_border_color = "intermediate_risk_border";
                $downsyndrome_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $downsyndrome_risk_color = "low_risk";
                $downsyndrome_border_color = "low_risk_border";
                $downsyndrome_risk_text = "low_risk_text";
            }
    
        }
    }



    $keys = array_keys($edwardSyndrome);
    $count_key = count($keys);
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $edwardSyndrome[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $edward_risk_color = "increased_risk";
                $edward_border_color = "increased_risk_border";
                $edward_risk_text = "increased_risk_text";
            } elseif (
                $edwardSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $edward_risk_color = "intermediate_risk";
                $edward_border_color = "intermediate_risk_border";
                $edward_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $edward_risk_color = "low_risk";
                $edward_border_color = "low_risk_border";
                $edward_risk_text = "low_risk_text";
            }
    }
    else{
            if (
                $edwardSyndrome[$keys[0]]['risk_result'] == "Increased Risk" ||
                $edwardSyndrome[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $edward_risk_color = "increased_risk";
                $edward_border_color = "increased_risk_border";
                $edward_risk_text = "increased_risk_text";
            } elseif (
                $edwardSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $edwardSyndrome[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $edward_risk_color = "intermediate_risk";
                $edward_border_color = "intermediate_risk_border";
                $edward_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $edward_risk_color = "low_risk";
                $edward_border_color = "low_risk_border";
                $edward_risk_text = "low_risk_text";
            }
    
        }
    }
    $keys = array_keys($patueSyndrome);
    $count_key = count($keys);
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $patueSyndrome[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $patau_risk_color = "increased_risk";
                $patau_border_color = "increased_risk_border";
                $patau_risk_text = "increased_risk_text";
            } elseif (
                $patueSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $patau_risk_color = "intermediate_risk";
                $patau_border_color = "intermediate_risk_border";
                $patau_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $patau_risk_color = "low_risk";
                $patau_border_color = "low_risk_border";
                $patau_risk_text = "low_risk_text";
            }
    }else{
            if (
                $patueSyndrome[$keys[0]]['risk_result'] == "Increased Risk" ||
                $patueSyndrome[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $patau_risk_color = "increased_risk";
                $patau_border_color = "increased_risk_border";
                $patau_risk_text = "increased_risk_text";
            } elseif (
                $patueSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $patueSyndrome[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $patau_risk_color = "intermediate_risk";
                $patau_border_color = "intermediate_risk_border";
                $patau_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $patau_risk_color = "low_risk";
                $patau_border_color = "low_risk_border";
                $patau_risk_text = "low_risk_text";
            }
    
        }
    
    }
    $keys = array_keys($ntSyndrome);
    $count_key = count($keys);
    
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $ntSyndrome[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $ntsyndrome_risk_color = "increased_risk";
                $ntsyndrome_border_color = "increased_risk_border";
                $ntsyndrome_risk_text = "increased_risk_text";
            } elseif (
                $ntSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $ntsyndrome_risk_color = "intermediate_risk";
                $ntsyndrome_border_color = "intermediate_risk_border";
                $ntsyndrome_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $ntsyndrome_risk_color = "low_risk";
                $ntsyndrome_border_color = "low_risk_border";
                $ntsyndrome_risk_text = "low_risk_text";
            }
    }
    else{
            if (
                $ntSyndrome[$keys[0]]['risk_result'] == "Increased Risk" ||
                $ntSyndrome[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $ntsyndrome_risk_color = "increased_risk";
                $ntsyndrome_border_color = "increased_risk_border";
                $ntsyndrome_risk_text = "increased_risk_text";
            } elseif (
                $ntSyndrome[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $ntSyndrome[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $ntsyndrome_risk_color = "intermediate_risk";
                $ntsyndrome_border_color = "intermediate_risk_border";
                $ntsyndrome_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $ntsyndrome_risk_color = "low_risk";
                $ntsyndrome_border_color = "low_risk_border";
                $ntsyndrome_risk_text = "low_risk_text";
            }
        }
    }

    $keys = array_keys($pe32);
    $count_key = count($keys);
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $pe32[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_32_risk_color = "increased_risk";
                $pe_32_border_color = "increased_risk_border";
                $pe_32_risk_text = "increased_risk_text";
            } elseif (
                $pe32[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_32_risk_color = "intermediate_risk";
                $pe_32_border_color = "intermediate_risk_border";
                $pe_32_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_32_risk_color = "low_risk";
                $pe_32_border_color = "low_risk_border";
                $pe_32_risk_text = "low_risk_text";
            }
    }else{
            if (
                $pe32[$keys[0]]['risk_result'] == "Increased Risk" ||
                $pe32[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_32_risk_color = "increased_risk";
                $pe_32_border_color = "increased_risk_border";
                $pe_32_risk_text = "increased_risk_text";
            } elseif (
                $pe32[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $pe32[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_32_risk_color = "intermediate_risk";
                $pe_32_border_color = "intermediate_risk_border";
                $pe_32_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_32_risk_color = "low_risk";
                $pe_32_border_color = "low_risk_border";
                $pe_32_risk_text = "low_risk_text";
            }
    
        }
    }

    $keys = array_keys($pe34);
    $count_key = count($keys);
    if(!empty($keys)){
    if($count_key == 1){
            if (
                $pe34[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_34_risk_color = "increased_risk";
                $pe_34_border_color = "increased_risk_border";
                $pe_34_risk_text = "increased_risk_text";
            } elseif (
                $pe34[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_34_risk_color = "intermediate_risk";
                $pe_34_border_color = "intermediate_risk_border";
                $pe_34_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_34_risk_color = "low_risk";
                $pe_34_border_color = "low_risk_border";
                $pe_34_risk_text = "low_risk_text";
            }
    }else{
            if (
                $pe34[$keys[0]]['risk_result'] == "Increased Risk" ||
                $pe34[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_34_risk_color = "increased_risk";
                $pe_34_border_color = "increased_risk_border";
                $pe_34_risk_text = "increased_risk_text";
            } elseif (
                $pe34[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $pe34[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_34_risk_color = "intermediate_risk";
                $pe_34_border_color = "intermediate_risk_border";
                $pe_34_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_34_risk_color = "low_risk";
                $pe_34_border_color = "low_risk_border";
                $pe_34_risk_text = "low_risk_text";
            }
    
        }
    }

    $keys = array_keys($pe37);
    $count_key = count($keys);

    if(!empty($keys)){
    if($count_key == 1){
            if (
                $pe37[$keys[0]]['risk_result'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_37_risk_color = "increased_risk";
                $pe_37_border_color = "increased_risk_border";
                $pe_37_risk_text = "increased_risk_text";
            } elseif (
                $pe37[$keys[0]]['risk_result'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_37_risk_color = "intermediate_risk";
                $pe_37_border_color = "intermediate_risk_border";
                $pe_37_risk_text = "intermediate_risk_text";
    } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_37_risk_color = "low_risk";
                $pe_37_border_color = "low_risk_border";
                $pe_37_risk_text = "low_risk_text";
        
       
            }
    }else{
            if (
                $pe37[$keys[0]]['risk_result'] == "Increased Risk" ||
                $pe37[$keys[1]]['final_risk'] == "Increased Risk"
            ) {
                // Increased Risk if any value is "Increased Risk"
                $pe_37_risk_color = "increased_risk";
                $pe_37_border_color = "increased_risk_border";
                $pe_37_risk_text = "increased_risk_text";
            } elseif (
                $pe37[$keys[0]]['risk_result'] == "Intermediate Risk" ||
                $pe37[$keys[1]]['final_risk'] == "Intermediate Risk"
            ) {
                // Intermediate Risk if any value is "Intermediate Risk"
                $pe_37_risk_color = "intermediate_risk";
                $pe_37_border_color = "intermediate_risk_border";
                $pe_37_risk_text = "intermediate_risk_text";
        } else{
                //  Low Risk only if both values are "Low Risk"
                $pe_37_risk_color = "low_risk";
                $pe_37_border_color = "low_risk_border";
                $pe_37_risk_text = "low_risk_text";
            
           
            }
    
        }
    }
}

if (isset($json_data->PatientRiskDetails)) {
    $prior_risk = "";
    if ($json_data->PatientRiskDetails[0]->SMOKING == "Y") {
        $prior_risk .= "<strong>Smoker</strong><br/>";
    }

    if ($json_data->PatientRiskDetails[0]->CHRONIC_HYPERTENSION == "3") {
        $prior_risk .= "<strong>Chronic hypertension</strong><br/>";
        }

    if ($json_data->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "1") {
        $prior_risk .= "<strong>Patient had  Preeclampsia</strong><br/>";
        }

    if ($json_data->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "2") {
        $prior_risk .= "<strong>Mother of Patient had  Preeclampsia</strong><br/>";
        }

    if ($json_data->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "3") {
        $prior_risk .= "<strong>Mother of Patient & Patient had  Preeclampsia</strong><br/>";
        }

    if ($json_data->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "Y") {
        $prior_risk .= "<strong> Preeclampsia in previous pregnancy</strong><br/>";
        }

        if ($json_data->PatientRiskDetails[0]->DIABETETS == "Y") {
            $type = "";
            if ($json_data->PatientRiskDetails[0]->DIABETIC_TYPE == "1") {
                $type = "I";
            }
            if ($json_data->PatientRiskDetails[0]->DIABETIC_TYPE == "2") {
                $type = "II";
            }
            $prior_risk .= "<strong>Diabetes Type $type</strong><br/>";
        }


    $prev_history = "";

    if ($json_data->PatientRiskDetails[0]->PREVIOUS_DOWN == "Y") {
        $prev_history .= "Down syndrome";
    }

    if ($json_data->PatientRiskDetails[0]->PATAUS_SYNDROME == "Y") {
        $prev_history .= ",Patau Syndrome";
    }
    if ($json_data->PatientRiskDetails[0]->PREVIOUS_EDWARDS == "Y") {
        $prev_history .= ",EDWARDS Syndrome";
    }

    if (!empty($prev_history)) {
        $prior_risk .= "<strong> $prev_history in previous pregnancy</strong><br/>";
    }

    if ($prior_risk == "") {
        $prior_risk = "None";
    }
}
$filename = "report-" . $lab_id . "-ver-" . $json_data->PatientDetails[0]->VERSION_NO;
$update_filter['risk_assesment'] = "";
?>
<?php $actual_link = base_url(); ?>

<body>

    <div class='report-page' style="padding-top: 15px;">
        <div class='report-page-main-container'>
            <section class='pns-test-report-body'>
                <div class='patient-speci-presc-section'>
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='10' cellpadding='8'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr'>Patient Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Specimen Details</td>
                            <td class='patient-speci-presc-tb-hdr'>Prescription Details</td>
                        </tr>
                        <tr>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr style='font-size:14px'>
                                        <td>Client Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($json_data->PatientDetails[0]->PATIENT_NAME)) > 25) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?php echo (($json_data->PatientDetails[0]->TITLE != '') ?
                                                        $json_data->PatientDetails[0]->TITLE : '') ?>
                                            <?php echo (isset($json_data->PatientDetails[0]->PATIENT_NAME) && ($json_data->PatientDetails[0]->PATIENT_NAME != '') ?
                                                ucwords(($json_data->PatientDetails[0]->PATIENT_NAME)) : "") ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Husband Name</td>
                                        <td>:</td>
                                        <?php if (strlen(trim($json_data->PatientDetails[0]->PARENT_NAME)) > 18) { ?>
                                            <td style="font-size:10px;width:100%; display:inline-block;">
                                            <?php } else { ?>
                                            <td style="width:100%; display:inline-block;">
                                            <?php } ?>
                                            <?php echo (isset($json_data->PatientDetails[0]->PARENT_NAME) && ($json_data->PatientDetails[0]->PARENT_NAME != '') ?
                                                $json_data->PatientDetails[0]->PARENT_NAME : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>:</td>
                                        <td><?php
                                            $gender = "";
                                            if (trim($json_data->PatientDetails[0]->GENDER) == 'F') {
                                                $gender = 'Female';
                                            } else if (trim($json_data->PatientDetails[0]->GENDER) == 'M') {
                                                $gender = 'Male';
                                            }
                                            echo $gender ?></td>
                                    </tr>
                                    <tr>
                                        <td>DOB</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->BIRTH_DATE != '') ?
                                                                date("d-m-Y", strtotime($json_data->PatientDetails[0]->BIRTH_DATE)) : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Height/Weight</td>
                                        <td>:</td>
                                        <td class='number'>
                                            <!-- <?php //echo isset($json_data->PatientRiskDetails[0]->HEIGHT) ? $json_data->PatientRiskDetails[0]->HEIGHT . "cm" : "NM" 
                                                    ?> -->
                                            <?php echo ($json_data->PatientDetails[0]->HEIGHT != '') ?
                                                $json_data->PatientDetails[0]->HEIGHT . "cm" : ($json_data->PatientDetails[0]->PATIENT_HEIGHT != '' ?
                                                    $json_data->PatientDetails[0]->PATIENT_HEIGHT . "cm" : "NM"); ?> /
                                            <?php echo isset($json_data->PatientRiskDetails[0]->WEIGHT) ? $json_data->PatientRiskDetails[0]->WEIGHT . "Kg" : "" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ethnicity</td>
                                        <td>:</td>
                                        <td><?php echo $json_data->PatientDetails[0]->ETHNICITY ?? "" ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td>Specimen</td>
                                        <td>:</td>
                                        <td><?php echo (($json_data->PatientDetails[0]->SAMPLE_ID != '') ?
                                                $json_data->PatientDetails[0]->SAMPLE_ID : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Collected on</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->SAMPLE_DATE != '') ?
                                                                formatDate($json_data->PatientDetails[0]->SAMPLE_DATE) : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Received on</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->RECEIVED_DATE != '') ?
                                                                formatDate($json_data->PatientDetails[0]->RECEIVED_DATE) : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Report Date</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->TestGroupDetails[0]->APPROVED_ON != '') ?
                                                                formatDate($json_data->TestGroupDetails[0]->APPROVED_ON) : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>CRM</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->PATIENT_ID != '') ?
                                                                $json_data->PatientDetails[0]->PATIENT_ID : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lab ID</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->LAB_ID != '') ?
                                                                $json_data->PatientDetails[0]->LAB_ID : "") ?></td>
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
                                        <td>DR.<?php echo (($json_data->PatientDetails[0]->REFERRED_BY != '') ?
                                                    ucwords(($json_data->PatientDetails[0]->REFERRED_BY)) : "") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hospital</td>
                                        <td>:</td>
                                        <td><?php echo ((trim($json_data->PatientDetails[0]->HOSPITAL_NAME) != '') ?
                                                $json_data->PatientDetails[0]->HOSPITAL_NAME : ((trim($json_data->PatientDetails[0]->HOSPITAL_CODE) != '') ?
                                                    $json_data->PatientDetails[0]->HOSPITAL_CODE : "")) ?></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td>:</td>
                                        <td><?php echo (($json_data->PatientDetails[0]->CENTER_CODE != '') ?
                                                $json_data->PatientDetails[0]->CENTER_CODE : "") ?></td>
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
                    <table style='width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;' border='0' cellspacing='5' cellpadding='10'>
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
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->LMP_DATE != '') ?
                                                                date('d-m-Y', strtotime($json_data->PatientDetails[0]->LMP_DATE)) : "NA"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Conception Method</td>
                                        <td>:</td>
                                        <td><?php if ($json_data->PatientDetails[0]->CONCEPTION != '') {
                                                if ($json_data->PatientDetails[0]->CONCEPTION == 'N') {
                                                    echo "Natural";
                                                } else if ($json_data->PatientDetails[0]->CONCEPTION == 'A') {
                                                    echo "Assisted";
                                                } else {
                                                    echo $json_data->PatientDetails[0]->CONCEPTION;
                                                }
                                            } else {
                                                echo "NA";
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Number of Foetus</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB != '') ?
                                                                $json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB : "NA") ?></td>
                                    </tr>
                                    <tr>
                                        <td>EDD <em>(By <?= $TYPE_OF_MEASURE ?>)</em></td>
                                        <td>:</td>
                                        <td class='number'><?php $EDD = "";
                                                            if (isset($CEDD["CEDD"]) && !empty($CEDD["CEDD"])) {
                                                                $EDD = $CEDD["CEDD"];
                                                            }
                                                            if (empty($EDD)) {
                                                                $EDD = $json_data->PatientDetails[0]->CORRECETD_EDD ?? "";
                                                            }
                                                            echo !empty($EDD) ? date('d-m-Y', strtotime($EDD)) : "NA" ?></td>
                                    </tr>
                                    <tr>
                                        <td>Maternal Age at Term</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->age_yy != '') ?
                                                                $json_data->PatientDetails[0]->age_yy . " Years" : "NA") ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <?php $no_of_whimb = "";
                                        if ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
                                            $no_of_whimb = "(1,2)";
                                        } else {
                                            $no_of_whimb = "(mm)";
                                        } ?>
                                        <td>Crown Rump Length<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class="number"><?php
                                                            //twins
                                                            if ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
                                                                // echo $json_data->PatientRiskDetails[0]->CRL_VALUE ."mm, ".$json_data->PatientRiskDetails[0]->CRL_VALUE_2."mm";
                                                                echo (($json_data->PatientRiskDetails[0]->CRL_VALUE != '') ?
                                                                    $json_data->PatientRiskDetails[0]->CRL_VALUE . "mm, " . $json_data->PatientRiskDetails[0]->CRL_VALUE_2 . "mm" : ($json_data->PatientDetails[0]->USG_CRL2 != '' ?
                                                                        $json_data->PatientDetails[0]->USG_CRL2 . "mm" : "NA")
                                                                );
                                                            } else {    //single
                                                                echo (($json_data->PatientDetails[0]->CRL_VALUE != '') ?
                                                                    $json_data->PatientDetails[0]->CRL_VALUE : ($json_data->PatientDetails[0]->USG_CRL != ''
                                                                        ? $json_data->PatientDetails[0]->USG_CRL : "NA")
                                                                );
                                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Biparietal Diameter<?= $no_of_whimb ?></td>
                                        <td>:</td>
                                        <td class='number'><?php
                                                            if ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
                                                                if (
                                                                    isset($json_data->PatientRiskDetails[0]->BPD_VALUE) ||
                                                                    isset($json_data->PatientRiskDetails[0]->BPD_VALUE_2) ||
                                                                    isset($json_data->PatientDetails[0]->USG_BPD2)
                                                                ) {
                                                                    echo (($json_data->PatientRiskDetails[0]->BPD_VALUE != '') ?
                                                                        $json_data->PatientRiskDetails[0]->BPD_VALUE . "mm," . $json_data->PatientRiskDetails[0]->BPD_VALUE_2 . "mm" : (isset($json_data->PatientDetails[0]->USG_BPD2) && $json_data->PatientDetails[0]->USG_BPD2 != '' ?
                                                                            $json_data->PatientDetails[0]->USG_BPD2 . "mm" : "NA")
                                                                    );
                                                                } else {
                                                                    echo "NA";
                                                                }
                                                            } else {    //single
                                                                echo (($json_data->PatientDetails[0]->BPD_VALUE != '') ?
                                                                    $json_data->PatientDetails[0]->BPD_VALUE : (isset($json_data->PatientDetails[0]->USG_BPD) && $json_data->PatientDetails[0]->USG_BPD != ''
                                                                        ? $json_data->PatientDetails[0]->USG_BPD : "NA")
                                                                );
                                                            }
                                                            ?></td>
                                    </tr>
                                    <tr>
                                        <?php if ($stsqflag != "stsq") { ?>
                                            <td>Nasal Bone</td>
                                            <td>:</td>
                                            <td class='number'><?php if (isset($json_data->PatientRiskDetails[0]->NASAL_BONE) && $json_data->PatientRiskDetails[0]->NASAL_BONE != '') {
                                                                    $NASAL_BONE = "";
                                                                    if ($json_data->PatientRiskDetails[0]->NASAL_BONE == "P") {
                                                                        $NASAL_BONE = "Present";
                                                                    } else if ($json_data->PatientRiskDetails[0]->NASAL_BONE == "A") {
                                                                        $NASAL_BONE = "Absent";
                                                                    }

                                                                    if ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
                                                                        if ($json_data->PatientRiskDetails[0]->NASAL_BONE_2 == "P") {
                                                                            $NASAL_BONE_2 = "Present";
                                                                        } else if ($json_data->PatientRiskDetails[0]->NASAL_BONE_2 == "A") {
                                                                            $NASAL_BONE_2 = "Absent";
                                                                        }
                                                                        echo $NASAL_BONE . " , " . $NASAL_BONE_2;
                                                                    } else {
                                                                        echo $NASAL_BONE;
                                                                    }
                                                                } else {
                                                                    echo "NA";
                                                                } ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Scan Date</td>
                                        <td>:</td>
                                        <td class='number'><?php echo (($json_data->PatientDetails[0]->SCAN_DATE != '') ?
                                                                date('d-m-Y', strtotime($json_data->PatientDetails[0]->SCAN_DATE)) : "NA") ?></td>
                                    </tr>
                                    <tr>
                                        <td>GA at Collection</td>
                                        <td>:</td>
                                        <td class='number'><?php echo ucwords(strtolower($GA_MAPPING));
                                                            $fontsize = "font-size: 11px;";
                                                            if ($TYPE_OF_MEASURE == "Ass Rep.") {
                                                                $fontsize = "font-size: 9px;";
                                                            } ?>
                                            <em style="<?php echo $fontsize ?>"><?php echo !empty($GA_MAPPING) ? "(By " . $TYPE_OF_MEASURE . " )" : "NA" ?></em>
                                        </td>
                                    </tr>
                                    <?php if ($json_data->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
                                        $chorionicity = "NA";
                                        if ($json_data->PatientRiskDetails[0]->CHORIONICITY == "0") {
                                            $chorionicity = "Dichorionic";
                                        }
                                        if ($json_data->PatientRiskDetails[0]->CHORIONICITY == "1") {
                                            $chorionicity = "Monochorionic, diamniotic";
                                        }
                                        if ($json_data->PatientRiskDetails[0]->CHORIONICITY == "2") {
                                            $chorionicity = "Monochorionic, monoamniontic";
                                        }
                                        if ($json_data->PatientRiskDetails[0]->CHORIONICITY == "3") {
                                            $chorionicity = "Dichorionic, diamniotic";
                                        }
                                    ?>
                                        <tr>
                                            <td>Chorionicity</td>
                                            <td>:</td>
                                            <td class='number'><?php echo $chorionicity ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td class='patient-speci-presc-tb-def'>
                                <table class='patient-speci-presc-tb-def-div' style='color:#777;font-size:12px;' cellpadding='2'>
                                    <tr>
                                        <td><?php echo $prior_risk ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class='pns_test-report-body assistance-details'>
                <div class='patient-speci-presc-section'>
                    <table style='width:99%; border-radius:10px; background:#fff; ' border='0' cellspacing='5' cellpadding='5'>
                        <tr>
                            <td class='patient-speci-presc-tb-hdr' style="font-size:14px;">Assistance Details</td>
                            <td class="assistance-details">Method<p class='number'>
                                    <?php
                                    if (isset($json_data->PatientRiskDetails[0]->CONCEPTION_TYPE) && ($json_data->PatientRiskDetails[0]->CONCEPTION_TYPE != '')) {
                                        $CONCEPTION_TYPE = $json_data->PatientRiskDetails[0]->CONCEPTION_TYPE;
                                        if ($CONCEPTION_TYPE == 0) {
                                            echo "In Vitro Fertilization";
                                        } else if ($CONCEPTION_TYPE == 1) {
                                            echo "Gift";
                                        } else if ($CONCEPTION_TYPE == 2) {
                                            echo "Zift";
                                        } else if ($CONCEPTION_TYPE == 3) {
                                            echo "Clomiphene Treatment";
                                        } else if ($CONCEPTION_TYPE == 4) {
                                            if ($json_data->PatientRiskDetails[0]->EGG == "Donor") {
                                                echo "Donor Egg";
                                            }
                                            if ($json_data->PatientRiskDetails[0]->EGG == "Own") {
                                                echo  "Own Egg";
                                            }
                                        } else if ($CONCEPTION_TYPE == 5) {
                                            echo "Donor Insemination";
                                        } else if ($CONCEPTION_TYPE == 6) { 
                                            echo "ICSI";
                                        } else if ($CONCEPTION_TYPE == 7) {
                                            echo "Other";
                                        } else if ($CONCEPTION_TYPE == 8) {
                                            echo "IUI";
                                        }
                                    } else {
                                        echo "NA";
                                    } ?>
                                </p>
                            </td>
                            <?php if ($stsqflag == "stsq") { ?>
                                <td class="assistance-details">Egg Extraction Date<p class='number'><?php echo (isset($json_data->PatientRiskDetails[0]->EXTRACTION_DATE) && ($json_data->PatientRiskDetails[0]->EXTRACTION_DATE != '') ?
                                                                                                        date('d-m-Y', strtotime($json_data->PatientRiskDetails[0]->EXTRACTION_DATE)) : "NA") ?></p>
                                </td>
                                <td class="assistance-details">Transfer Date<p class='number'><?php echo (isset($json_data->PatientRiskDetails[0]->TRANSFER_DATE) && ($json_data->PatientRiskDetails[0]->TRANSFER_DATE != '') ?
                                                                                                    date('d-m-Y', strtotime($json_data->PatientRiskDetails[0]->TRANSFER_DATE)) : "NA") ?></p>
                                </td>
                            <?php } else { ?>
                                <td class="assistance-details">Transfer Date<p class='number'><?php echo (isset($json_data->PatientRiskDetails[0]->TRANSFER_DATE) && ($json_data->PatientRiskDetails[0]->TRANSFER_DATE != '') ?
                                                                                                    date('d-m-Y', strtotime($json_data->PatientRiskDetails[0]->TRANSFER_DATE)) : "NA") ?></p>
                                </td>
                                <td class="assistance-details">Egg Extraction Date<p class='number'><?php echo (isset($json_data->PatientRiskDetails[0]->EXTRACTION_DATE) && ($json_data->PatientRiskDetails[0]->EXTRACTION_DATE != '') ?
                                                                                                        date('d-m-Y', strtotime($json_data->PatientRiskDetails[0]->EXTRACTION_DATE)) : "NA") ?></p>
                                </td>
                            <?php } ?>
                            <td class="assistance-details">Age At Extraction<p class='number'><?php echo (isset($json_data->PatientRiskDetails[0]->DONOR_AGE_AT_EDD) && ($json_data->PatientRiskDetails[0]->DONOR_AGE_AT_EDD != '') ?
                                                                                                    $json_data->PatientRiskDetails[0]->DONOR_AGE_AT_EDD : "NA") ?></p>
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
                    if (count($printingNamesOfParameter) == 6) {
                        $table_size = "width:120px !important;font-size:10px !important;";
                        $fontsize = "font-size:10px !important;";
                    } ?>
                    <table style="width:100%;<?php echo $table_size; ?>border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 5px 0;" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <?php $i = 0;


                            foreach ($printingNamesOfParameter as $key => $printingName) { ?>
                                <?php if ($riskSoftwareMethodByPrint == "LIFECYCLE") {
                                    if ($printingName == 'DIA') {
                                        $parameterMethod = 'ELISA';
                                    } else {
                                        $parameterMethod = 'TRF';
                                    }
                                } else {
                                    if ($printingName == 'DIA') {
                                        $parameterMethod = 'ELISA';
                                    } else {
                                        $parameterMethod = 'CLIA';
                                    }
                                } ?>
                                <?php if ($printingName == 'PAPPA') {
                                    $printingName = "PAPP-A";
                                }
                                if ($printingName == 'NT' || $printingName == 'NT2' || $printingName == "UAPI") {
                                    $parameterMethod = "Scan";
                                }
                                if ($riskSoftwareMethodByPrint == "PRISCA") {
                                    if ($printingName == 'INHIBIN') {
                                        $parameterMethod = 'TRF';
                                    }
                                }
                                ?>
                                <td class="patient-speci-presc-tb-parameter"><?php echo $printingName ?><span class="test-title"> (By <?php echo $parameterMethod; ?> )</span>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php //echo "<pre>". print_r($parameterResult)."<<";die; 
                            ?>
                            <?php foreach ($parameterResult as $key => $testResults) { ?>
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
            <?php if ($lab_id == '20600203824') { ?>
                <span class="title">Risk Assessment <br><span class="test-title">(By <?php echo $riskSoftwareMethod; ?>)</span><br>
                <?php } else { ?>
                    <span class="title">Risk Assessment - Aneuploidy<br>
                    <?php } ?>
                    <?php $txt_line = "";
                    if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE") {
                        $txt_line = "Results Were Analyzed by Lifecycle S/W - Version 7.0";
                    }
                    if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") {
                        $txt_line = "Results Were Analyzed by PRISCA S/W - Version 5.2";
                    }
                    if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE") { ?>
                        <span class="test-title alok">(<?= $txt_line ?>)</span></span>
                    <span class="increased_risk">Increased Risk</span>
                    <span class="intermediate_risk">Intermediate Risk</span>
                    <span class="low_risk">Low Risk</span>
                <?php } ?>
                <?php if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") { ?>
                    <span class="test-title alok">(<?= $txt_line ?>)</span></span>
                <span class="increased_risk">Increased Risk</span>
                <span class="low_risk">Low Risk</span>
            <?php  } ?>
        </div>
        <!-- New Graph -->

        <?php $page_break_css = "";
        if ($showBR == 1) {
            $page_break_css = "page-break-after: always";
        }
        if (!empty($printingNamesOfRisk)) { ?>
            <div class="risk-graph-section" style=" float:  left; width:100%;">
                <section class="pns-test-report-parameter-assesed risk" style="float:left;<?= $page_break_css ?>">
                    <div class="patient-speci-presc-section">
                        <table style="width:100%;border-radius:15px;border:0px solid #ccc;border-spacing: 5px 0;margin: 0;" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php foreach ($printingNamesOfRisk as $key => $printingName) {
                                    $css_color = "";
                                    if ($key == "down") {
                                        $css_color = $downsyndrome_border_color . " " . $downsyndrome_risk_color;
                                    }
                                    if ($key == "edward") {
                                        $css_color = $edward_border_color . " " . $edward_risk_color;
                                    }
                                    if ($key == "patau") {
                                        $css_color = $patau_border_color . " " . $patau_risk_color;
                                    }
                                    if ($key == "pe_32") {
                                        $css_color = $pe_32_border_color . " " . $pe_32_risk_color;
                                    }
                                    if ($key == "pe_34") {
                                        $css_color = $pe_34_border_color . " " . $pe_34_risk_color;
                                    }
                                    if ($key == "pe_37") {
                                        $css_color = $pe_37_border_color . " " . $pe_37_risk_color;
                                    }
                                    if ($key == "ntsyndrome") {
                                        $css_color = $ntsyndrome_border_color . " " . $ntsyndrome_risk_color;
                                    }
                                ?>
                                    <td class="patient-speci-presc-tb-parameter <?= $ftclass ?> number <?= $css_color ?>"> <?php echo $printingName; ?></td>
                                <?php } ?>
                            </tr>
                            <?php
                            $temp_prisca_Syndrome_age_risk = [];
                            $BR_Risk_flag = '0:0';
                            $FR_Risk_flag = '0:0';
                            $FR_Risk_Word_flag = '';
                            ?>
                            <tr>
                                <?php if (!empty($downSyndrome)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $downsyndrome_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number <?= $downsyndrome_risk_text ?>" style="font-size:12px;" cellpadding="0">
                                            <?php
                                            if (count($downSyndrome) == 2) {
                                                $keys = array_keys($downSyndrome); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $downSyndrome[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $downSyndrome[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Age Risk(AR) - <?php echo $downSyndrome[$keys[0]]['age_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $downSyndrome[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $downSyndrome[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>

                                                <?php $update_filter['risk_assesment'] .= 'T21-Twin1-' . $downSyndrome[$keys[0]]['risk_result'] . ",";  ?>
                                                <?php $update_filter['risk_assesment'] .= 'T21-Twin2-' . $downSyndrome[$keys[1]]['final_risk'] . ",";  ?>

                                                <?php } else {
                                                foreach ($downSyndrome as $Syndrome) {
                                                    $temp_prisca_Syndrome_age_risk[] = $Syndrome['age_risk']; ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                        <?php $FR_Risk_flag = $Syndrome['final_risk'] ?? '0:0'; ?>
                                                    </tr>
                                                    <tr>
                                                        <?php if ($showBR == 1 && !empty($Syndrome['biochemical_risk'])) { ?>
                                                            <td>
                                                                <span class="risk-graph-font">Biochemical Risk (BR) - <?php echo $Syndrome['biochemical_risk']; ?></span>
                                                                <?php $BR_Risk_flag = $Syndrome['biochemical_risk'] ?? '0:0'; ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo $Syndrome['age_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                        <?php $FR_Risk_Word_flag = $Syndrome['risk_result'] ?? ''; ?>
                                                    </tr>
                                                    <?php $update_filter['risk_assesment'] .= 'T21-' . $Syndrome['risk_result'] . ",";  ?>
                                            <?php }
                                            } ?>

                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($edwardSyndrome)) { ?>
                                    <td class="<?= $edward_risk_color ?> patient-speci-presc-tb-def">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number <?= $edward_risk_text ?>" style="font-size:12px;" cellpadding="0">
                                            <?php
                                            $i = 0;
                                            if (count($edwardSyndrome) == 2) {
                                                $keys = array_keys($edwardSyndrome); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $edwardSyndrome[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $edwardSyndrome[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Age Risk(AR) - <?php echo ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $edwardSyndrome[$keys[0]]['age_risk']; ?></span></td>                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $edwardSyndrome[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $edwardSyndrome[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php $update_filter['risk_assesment'] .= 'T18-Twin1-' . $edwardSyndrome[$keys[0]]['risk_result'] . ",";  ?>
                                                <?php $update_filter['risk_assesment'] .= 'T18-Twin2-' . $edwardSyndrome[$keys[1]]['final_risk'] . ",";  ?>
                                                <?php } else {
                                                foreach ($edwardSyndrome as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $Syndrome['age_risk']; ?></span></td>                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                                    <?php $update_filter['risk_assesment'] .= 'T18-' . $Syndrome['risk_result'] . ",";  ?>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($patueSyndrome)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $patau_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number <?= $patau_risk_text ?>" style="font-size:12px;" cellpadding="0">
                                            <?php
                                            $i = 0;
                                            if (count($patueSyndrome) == 2) {
                                                
                                                $keys = array_keys($patueSyndrome); ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 1) R1 - <?php echo $patueSyndrome[$keys[0]]['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Final Risk (Twin 2) R2 - <?php echo $patueSyndrome[$keys[1]]['risk_result_twin']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Age Risk(AR) - <?php echo ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $patueSyndrome[$keys[0]]['age_risk']; ?></span></td>                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin1 - <?php echo $patueSyndrome[$keys[0]]['risk_result']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk for Twin2 - <?php echo $patueSyndrome[$keys[1]]['final_risk']; ?></span></td>
                                                </tr>
                                                <?php $update_filter['risk_assesment'] .= 'T13-Twin1-' . $patueSyndrome[$keys[0]]['risk_result'] . ",";  ?>
                                                <?php $update_filter['risk_assesment'] .= 'T13-Twin2-' . $patueSyndrome[$keys[1]]['final_risk'] . ",";  ?>
                                                <?php } else {
                                                foreach ($patueSyndrome as $Syndrome) { ?>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Final Risk (FR) - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Age Risk (AR) - <?php echo ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") ? $temp_prisca_Syndrome_age_risk[$i++] : $Syndrome['age_risk']; ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                    </tr>
                                                    <?php $update_filter['risk_assesment'] .= 'T13-' . $Syndrome['risk_result'] . ",";  ?>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($ntSyndrome)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $ntsyndrome_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div <?= $ftclass ?> number <?= $ntsyndrome_risk_text ?>" cellpadding="0">
                                            <?php foreach ($ntSyndrome as $Syndrome) {
                                                $momValue = $Syndrome['final_risk']; ?>
                                                <tr>
                                                    <td><span class="risk-graph-font">AFP MOM - <?php echo $Syndrome['final_risk']; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="risk-graph-font">Risk Result - <?php echo $Syndrome['risk_result']; ?></span></td>
                                                </tr>
                                                <?php $update_filter['risk_assesment'] .= 'NTD-' . $Syndrome['risk_result'] . ",";  ?>
                                            <?php } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($pe32)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $pe_32_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div number <?= $pe_32_risk_text ?>" style="font-size:12px;" cellpadding="0">
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
                                                    <?php $update_filter['risk_assesment'] .= 'NTD-' . $Syndrome['risk_result'] . ",";  ?>
                                            <?php }
                                            } ?>
                                        </table>
                                    </td>
                                <?php } ?>
                                <?php if (!empty($pe34)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $pe_34_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div number <?= $pe_34_risk_text ?>" style="font-size:12px;" cellpadding="0">
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
                                <?php if (!empty($pe37)) { ?>
                                    <td class="patient-speci-presc-tb-def <?= $pe_37_risk_color ?>">
                                        <table class="patient-speci-presc-tb-def-div number <?= $pe_37_risk_text ?>" style="font-size:12px;" cellpadding="0">
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
                                foreach ($printingNamesOfRisk as $key => $printingName) {
                                    if ($key == "down" && (count($downSyndrome) == 1)) { ?>
                                        <td class="graph-main-div <?= $downsyndrome_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <td><?php
                                                    if ($showBR == 1 && (!empty($downSyndrome['PRDS']['biochemical_risk']) || (!empty($downSyndrome['PNSDMDS']['biochemical_risk'])))) {
                                                        if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") {
                                                            echo riskGraphPrisca($downSyndrome, $ftclass);
                                                        } else {
                                                            echo riskGraph($downSyndrome, $ftclass);
                                                        }
                                                    } else {
                                                        if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") {
                                                            echo riskGraphPriscaWithoutBR($downSyndrome, $ftclass);
                                                        } else {
                                                            echo riskGraphWithoutBR($downSyndrome, $ftclass);
                                                        }
                                                    }  ?> </td>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "down" && (count($downSyndrome) == 2)) { ?>
                                        <td class="graph-main-div <?= $downsyndrome_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php if ($showBR == 1) {
                                                            echo riskGraphTwin($downSyndrome, $ftclass);
                                                        } else {
                                                            echo riskGraphForDownSydromeTwin($downSyndrome, $ftclass);
                                                        }  ?> </td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "edward" && (count($edwardSyndrome) == 1)) { ?>
                                        <td class="graph-main-div <?= $edward_border_color; ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($edwardSyndrome, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "edward" && (count($edwardSyndrome) == 2)) { ?>
                                        <td class="graph-main-div <?= $edward_border_color; ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($edwardSyndrome, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "patau" && (count($edwardSyndrome) == 1)) { ?>
                                        <td class="graph-main-div <?= $patau_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($patueSyndrome, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "patau" && (count($patueSyndrome) == 2)) { ?>
                                        <td class="graph-main-div <?= $patau_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($patueSyndrome, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "ntsyndrome" && (count($ntSyndrome) == 1)) {
                                    ?>
                                        <td class="graph-main-div <?= $ntsyndrome_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php 
                                                        if ($data['no_of_foetus'] == 2) {
                                                            echo riskGraphForNTDTwin($momValue, $ftclass);
                                                        } else {
                                                            echo riskGraphForNTD($momValue, $ftclass);
                                                        }
                                                         ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "ntsyndrome" && (count($ntSyndrome) == 2)) {
                                    ?>
                                        <td class="graph-main-div  <?= $ntsyndrome_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForNTDTwin($momValue, $ftclass); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_32" && (count($pe32) == 1)) { ?>
                                        <td class="graph-main-div  <?= $pe_32_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe32); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_32" && (count($pe32) == 2)) { ?>
                                        <td class="graph-main-div <?= $pe_32_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe32); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_34" && (count($pe34) == 1)) { ?>
                                        <td class="graph-main-div <?= $pe_34_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe34); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_34" && (count($pe34) == 2)) { ?>
                                        <td class="graph-main-div <?= $pe_34_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe34); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php }
                                    if ($key == "pe_37" && (count($pe37) == 1)) { ?>
                                        <td class="graph-main-div <?= $pe_37_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdward($pe37); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } else if ($key == "pe_37" && (count($pe37) == 2)) { ?>
                                        <td class="graph-main-div <?= $pe_37_border_color ?>">
                                            <table class="graph" style="color:#333333;font-size:12px;" cellpadding="0">
                                                <tr>
                                                    <td><?php echo riskGraphForEdwardTwin($pe37); ?></td>
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
            $interpretation_css = "width:100%;";
            //   if($data['no_of_foetus'] == 2 &&  $marker != "pereport"){
            //   $interpretation_css = "float:left;width:100%;margin-top:2px;";
            // } 

            $interpretation_margin = "margin-top:5px;padding-top:15px;";

            if (count($printingNamesOfRisk) > 3 || count($printingNamesOfParameter) > 3) {
                $interpretation_margin = "margin-top:5px;padding-top:15px;";
            }
            ?>
            <table style="<?= $interpretation_css; ?><?= $interpretation_margin; ?>;">
            <?php } else { ?>
                <table style="margin-top:1%;page-break-after: always;padding-top:15px;">
                <?php } ?>

                <tr class='interpretation-main'>
                    <!--<td class='interpretation-img'><img class='inter-img' src='<?= base_url('images/pns-interpretation-new.png'); ?>' alt='' /></td>-->
                    <td class='interpretation-details'>
                        <p class='title'>Interpretation</p>
                        <p class='interpretation' style="font-size:14px">
                            <img class='inter-img' src='<?= base_url('images/pns/Interpretation.png'); ?>' alt='' style="width:25px;" />
                            <?php echo $interpretation ?>
                        </p>
                        <?php if ($showBioComment == 1) { ?>
                            <p class='interpretation' style="font-size:14px"> The above risk has been calculated based on Biochemistry values alone.
                                Biochemistry based Screening offers detection rate of 60% (5% FPR)</p>
                        <?php } ?>
                    </td>
                </tr>
                <tr class='interpretation-main'>
                    <td class='interpretation-details'>
                        <?php if (($comment_flag && $comment_flag == 1)) { ?>
                            <span style="font-size: 16px; text-transform: uppercase;margin: 0px; color: #0a81a0;font-weight: 600;">Comments: </span>
                            <span style="    font-size: 15px !important"><?php echo ucfirst($comment) ?></span>
                        <?php } ?>
                    </td>
                </tr>
                <?php if ($data['no_of_foetus'] != 2 && $marker == "pereport") {
                    $margin = 1;
                    $padding = 1;
                } else if ($data['no_of_foetus'] == 1) {
                    $margin = 1;
                    $padding = 1;
                } else {
                    $margin = 1;
                    $padding = 1;
                } ?>
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
                if ($Prefix_flag == 1 && $Risk_Name_flag == "T21" && find_ratio_result($BR_Risk_flag, 1, 1000) && find_ratio_result($FR_Risk_flag, 1000, 100000) && $FR_Risk_Word_flag == "Low Risk") {
                //if(true){ ?>
                    <tr class='interpretation-main'>
                        <td class='interpretation-details'>
                            <p class='title'>Comment</p>
                            <p class='interpretation' style="font-size:10px">
                                <img class='inter-img' src='<?= base_url('images/pns/Interpretation.png'); ?>' alt='' style="width:25px;" />
                                If in case increased biochemical risk (1 to 250), further testing is recommended-non-invasive or invasive testing, along with a detailed anomaly scan between 18 to 20 weeks.
                            </p>
                        </td>
                    </tr>
                <?php } ?>

                <?php
                $next_page = "page-break-before:always;";
                $page_brk_css = "";
                if ($data['no_of_foetus'] == 2 || $showBioComment == 1 || (!empty(trim($interpretation) && count($printingNamesOfRisk) > 0 && count($printingNamesOfParameter) > 0))) {
                    $page_brk_css = "padding-top:10px;display: inline-block;page-break-before:always;";
                    $next_page = "";
                } ?>
                <table style='margin-top:<?= $margin ?>%; padding-bottom: 15px;'>
                    <tr class='caution-main'>

                        <td class='caution-details'>
                            <p class='title'>Caution</p>
                            <p class='caution'><img class='caut-img' src='<?= base_url('images/pns/Caution.png'); ?>' alt='' style="width:26px;" /> <span>It must be clearly understood that this is a screening test, and therefore cannot
                                    be used to reach a definitive diagnosis. A low-risk result doesn't guarantee that your baby won't
                                    have one of these conditions. Likewise, an increased-risk result doesn't guarantee that your
                                    baby will be born with one of these conditions, and that further confirmatory tests must be
                                    performed in consultation with your healthcare provider.</span></p>
                        </td>
                    </tr>
                </table>
    </div><!-- Page 2 Start -->
    <?php if ($marker == "pereport") { ?>
        <div class='report-page page2' style="background: #FFFBF3;<?= $next_page; ?>page-break-after: always;">
        <?php
    } else if (empty($furtherTesting)) { ?>
            <div class='report-page page2' style="background: #FFFBF3;<?= $next_page; ?>page-break-after: always;">
            <?php } else {  ?>
                <div class='report-page page2' style="background: #FFFBF3;<?= $next_page; ?>page-break-after: always;">
                <?php } ?>

                <div class='report-page-main-container'>
                    <div class='page-two-main-container'>
                        <?php if (!empty($furtherTesting)) {
                            $furtherTesting = array_values($furtherTesting);
                            usort($furtherTesting, function ($a, $b) {
                                return $a['sort'] <=> $b['sort'];
                            });
                            $break_css = "";
                            //if($ftclass === "") {$break_css = "page-break-before:always";}
                        ?>
                            <section class='pns-test-report-parameter-assesed testing-options' style="padding:0px;margin-top:0px;<?= $break_css ?>">
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
                        <?php $break_css = "";
                        if ($ftclass === "" && empty($furtherTesting)) {
                            $break_css = "page-break-before:always";
                        } ?>
                        <section class='pns-test-report-parameter-assesed final-risk'>
                            <div class='patient-speci-presc-section'>
                                <?php
                                $lowRiskCutoff = "";
                                if ($marker != "pereport" && strtoupper($risk_type) == "3LEVEL") {
                                    $lowCutoff = '1:250';
                                    $highCutoff = '1:250';
                                    $lowRiskCutoff = '1:1000';
                                } elseif ($marker != "pereport" && strtoupper($risk_type) == "2LEVEL") {
                                    $lowCutoff = '1:250';
                                    $highCutoff = '1:250';
                                    $lowRiskCutoff = '1:250';
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
                                } else {
                                    $lowCutoff = '1:100';
                                    $highCutoff = '1:100';
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
                                } ?>
                                <table style='width:100%;border-radius: 10px; height: 250px;' border='0' cellspacing='10' cellpadding='10' class="pechange">
                                    <p class='title'>Understanding Reported Final Risk:</p>
                                    <p class='content'>Prenatal screening gives a risk estimate after analyzing. The risk
                                        estimate is in the form of a ratio. For example, if the reported final risk is <span class='number'>1:1280,</span>
                                        it means that of <span class='number'>1280</span> pregnancies with similar values, one baby is likely to be affected with the screened condition
                                    </p>
                                    <tr>
                                        <?php if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE") { ?>
                                        <td class='risk-1'>
                                            <p class='risk-title' style="font-size: 12px;">Increased Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Screen Positive” when the
                                                probability ratio is greater than <span class='number'><?php echo $lowCutoff ?></span> births.</p>
                                        </td>
                                        <?php } ?>
                                        <?php if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") { ?>
                                            <td class='prisca-risk-1'>
                                                <p class='risk-title' style="font-size: 12px;">Increased Risk:</p>
                                                <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Screen Positive” when the
                                                    probability ratio is greater than <span class='number'><?php echo $lowCutoff ?></span> births.</p>
                                            </td>
                                        <?php } ?>
                                        <?php if ($marker != "pereport" && strtoupper($risk_type) != "2LEVEL" && $json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE") { ?>
                                            <td class='risk-2'>
                                                <p class='risk-title' style="font-size: 12px;">Intermediate Risk: </p>
                                                <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as “Intermediate Probability” when
                                                    the probability ratio is within <span class='number'>1:251</span> to <span class='number'>1:1000</span> births.</p>
                                            </td>
                                        <?php } ?>
                                        <?php if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA") { ?>
                                            <td class='prisca-risk-3'>
                                            <p class='risk-title' style="font-size: 12px;">Low Risk:</p>
                                            <p class='risk-detail' style="font-size: 11px;max-width: 160px;">The result is considered as "Screen Negative" when the probability ratio is lesser&nbsp; than <span class='number'><?php echo $lowRiskCutoff ?? $lowCutoff ?></span> births.
                                                <!-- <span class='number'><?php echo $highCutoff ?></span> births. -->
                                            </p>
                                        </td>
                                        <?php } ?>
                                        <?php if ($json_data->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE") { ?>
                                            <td class='risk-3'>
                                                <p class='risk-title' style="font-size: 12px;">Low Risk:</p>
                                                <p class='risk-detail'style="font-size: 11px;max-width: 160px;">The result is considered as "Screen Negative" when the probability ratio is lesser&nbsp; than <span class='number'><?php echo $lowRiskCutoff ?? $lowCutoff ?></span> births.
                                                    <!-- <span class='number'><?php echo $highCutoff ?></span> births. -->
                                                </p>
                                            </td>
                                        <?php } ?>
                                        </tr>
                                </table>
                            </div>
                        </section>
                        <?php $disclaimer_css = "";
                        //if(!empty($furtherTesting)) {$disclaimer_css = "page-break-before:always";} 
                        ?>
                        <table style="<?= $disclaimer_css ?>">
                            <tr class='disclaimer-main'>
                                <!--<td class='disclaimer-img'><img class='discl-img' src='<?= base_url('images/pns-disclaimer-new.png'); ?>' alt='' /></td>-->
                                <td class='disclaimer-details'>
                                    <p class='title'>Disclaimer</p>
                                    <p><span class='number'>1.</span> This interpretation assumes that patient and specimen
                                        details are accurate and correct.</p>
                                    <p><span class='number'>2.</span> Ultrasound observations / measurements if not performed as
                                        per imaging guidelines may lead to erroneous risk assessments, and LifeCell does not
                                        bear responsibility for results arising due to such errors</p>
                                    <p><span class='number'><b>3.</b></span><b> As per FMF Guidelines, if Down Syndrome final risk is between 251 to 1000, it will be considered as intermediate risk and further testing will be required for confirmation. </b></p>
                                    <?php
                                    $Hideshowdisclaimer = [
                                        "1TQWPLGF",
                                        "1TPENDEL",
                                        "TDSWOPE",
                                        "1TQWDIA",
                                        "CSPLGFDELV",
                                        "CSPLGFDEL",
                                        "FTSPLGF",
                                        "P0030",
                                        "PLGFBIOVAL",
                                        "DELPLGFPAPPA",
                                        "QSTDELQFPCR",
                                        "QSTIMUQFPCR",
                                        "QSTDEL14W",
                                        "SQDMR",
                                        "STSIMU",
                                        "MSAFPDS",
                                        "STSDEL14W",
                                        "ISDEL-QST",
                                        "QSTDEL",
                                        "QSTIMU",
                                        "STSDEL",
                                        "HPQUAD",
                                        "RCELL_27",
                                        "RCELL_29",
                                        "CSPLGFDELNIPTHB",
                                        "CSPLGFBDEL",
                                        "QSTDSHB",
                                        "RAJEEV_002",
                                        "RAJEEV_008",
                                        "1TQWNIPT",
                                        "CSPLGFDELHB",
                                        "QSTIMUNIPT",
                                        "QSTDSNIPT",
                                        "CSPLGFDELNIPT",
                                        "QSTDSNIPTQFPCR",
                                        "CSPLGFDELLC",
                                        "QSTDSNIPTM",
                                        "QSTDSNIPTQFPCRM",
                                        "CSWOPLGFDELHB",

                                    ];

                                    if ($uk_neqas_logo) {
                                        if (!in_array($testGroupCode, $Hideshowdisclaimer)) {?>
                                        <p><span class='number'>4.</span> Quality of our Prenatal screening results (Biochemistry values, MoM, Risk Assessments) are monitored by the UKNEQAS external quality assessment program. </p>
                                    <?php }
                                    }?>
                                </td>
                            </tr>
                        </table>

                        <p style='text-align: center;margin-bottom:0rem'>End of Report</p>
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
<style>
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(2) .patient-speci-presc-tb-def-div tr td,
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(3) .patient-speci-presc-tb-def-div tr td {
        /* color: #000 !important; */
    }

    /* .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(2), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(2), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(3), .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(3) {
    background: #ee2915;
    color: #fff !important;
    border: 1px solid #ee2915;
} */

    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(1) .patient-speci-presc-tb-def-div tr td {
        /* color: #000 !important; */
    }

    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-parameter.number:nth-child(1),
    .risk-graph-section .patient-speci-presc-section .patient-speci-presc-tb-def:nth-child(1) {
        background: #35a382;
        /* color: #000 !important; */
    }
</style>
<?php
$updateFilter = isset($filter_update) ? $filter_update : 0;
if ($updateFilter == 0) {
    $update_filter['twin'] = 0;
    if ($data['no_of_foetus'] == 2) {
        $update_filter['twin'] = 1;
    }
    $update_filter['type_of_measure'] = $json_data->PatientDetails[0]->TYPE_OF_MEASURE ?? "";
    $update_filter['prior_risk'] =  $prior_risk;
    $update_filter['further_testing'] = 0;
    if ($furtherTesting != '') {
        $update_filter['further_testing'] = 1;
    }
    $update_filter['final_risk'] = $risk_type;
    $update_filter['biochemical_risk'] = 0;
    if ($bioChemicalRisk != '') {
        $update_filter['biochemical_risk'] = 1;
    }
    $update_filter['bio_comment'] = 0;
    if ($showBioComment != '') {
        $update_filter['bio_comment'] = 1;
    }
    $update_filter['assistance_details'] = 0;
    if ($json_data->PatientRiskDetails[0]->CONCEPTION_TYPE != '') {
        $update_filter['assistance_details'] = 1;
    }
    if ($reportTitle != '') {
        $update_filter['report_title'] = $reportTitle;
    }
    $update_filter['cap'] = 0;
    if ($json_data->TestGroupDetails[0]->Is_CAP_ACCREDITED) {
        $update_filter['cap'] = 1;
    }
    $update_filter['nabl'] = 0;
    if ($json_data->TestGroupDetails[0]->Is_NABL_ACCREDITED) {
        $update_filter['nabl'] = 1;
    }
    $update_filter['branch'] = $json_data->PatientDetails[0]->BRANCH_NAME ?? "";
    $branch_address = $json_data->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS  ?? "";
    $uk_neqas_logo = str_contains(strtolower($branch_address), 'chennai');
    $update_filter['uk_neqas'] = 0;
    if ($uk_neqas_logo) {
        $update_filter['uk_neqas'] = 1;
    }
    updateAdditionalFilter($lab_id, $update_filter);
}
?>