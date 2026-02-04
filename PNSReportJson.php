<?php

namespace App\Controllers\Reports;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ReportDataModel;
use App\Models\PackageConfigModel;
use App\Models\PNSReportDataModel;

class PnsReportJson extends ResourceController
{
    use ResponseTrait;

    public function GeneratePnsReportJson($json_reportdata, $marker)
    {
        helper('pns');
        $this->report_table = new PNSReportDataModel();
        /** GET PATEINT DETAILS START*/
        $PatientDetails = getPatientDetails($json_reportdata);
        /** GET PATEINT DETAILS END*/

        /** GET SpecimenDetails Details*/
        $SpecimenDetails = getSpecimenDetails($json_reportdata);
        /** GET SpecimenDetails End*/

        /** GET PrescriptionDetails Start */
        $PrescriptionDetails = getPrescriptionDetails($json_reportdata);
        /** GET PrescriptionDetails End */

        /** GET OngoingPregnancy Start */
        $ongoingPregnancy = getOngoingPregnancy($json_reportdata);
        /** GET ongoingPregnancy end */

        /** GET SonographyDetails Start */
        $getSonographyDetails = getSonographyDetails($json_reportdata);
        /** GET SonographyDetails End */

        /** PriorRiskFactors start */
        $RiskFactors = getPriorRiskFactors($json_reportdata);
        /**  PriorRiskFactors End */

        /** Get Risk Assessment start */
        $assistDetails = getAssistanceDetails($json_reportdata);
        /** Get Risk Assessment End */

        /**
         * VALIDATE PROCESSING_BRANCH_ADDRESS FEILD
         */
        $PROCESSING_BRANCH_ADDRESS = $this->validateAddress($json_reportdata);
        if(empty($PROCESSING_BRANCH_ADDRESS)){
            return array();
        }

        /**
         * IF DR SIGNATURE NOT EXIST IN JSON THEN DON'T GENERATE THE REPORT
        */
        $doctor1signature = $json_reportdata->TestGroupDetails[0]->Doctor1Signature ?? "";
        $doctor2signature = $json_reportdata->TestGroupDetails[0]->Doctor2Signature ?? "";
        $doctor3signature = $json_reportdata->TestGroupDetails[0]->Doctor3Signature ?? "";

        if(empty($doctor1signature) && empty($doctor2signature) && empty($doctor3signature)){
            updateFailedReportLog($json_reportdata->PatientDetails[0]->LAB_ID,2);
            $this->report_table->updateFailedReprtFlag($json_reportdata->PatientDetails[0]->LAB_ID,"","Doctor Signature Not Exist in JSON");
            return array();
        }

        $testgroupcode = $json_reportdata->TestGroupDetails[0]->TEST_GROUP_CODE;
        $riskAssessment = $this->getParameterAssessedandRiskGraph($json_reportdata, $testgroupcode, $marker);
        $parameterAssessed = ['parameterAssessed' => $riskAssessment['parameterAssessed']];
        $reportTitle = $riskAssessment['reportTitle'];
        $interpretation = $riskAssessment['interpretation'];
        $getSonographyDetails['ga_at_collection'] = $riskAssessment['ga_at_collection'];
        $ongoingPregnancy['expectedduedate'] = $riskAssessment['expectedduedate'];
        $furtherTesting = $riskAssessment['furtherTesting'];
        $footerContent = $riskAssessment['footercontent'];
        unset($riskAssessment['parameterAssessed']);
        unset($riskAssessment['reportTitle']);
        unset($riskAssessment['furtherTesting']);
        unset($riskAssessment['interpretation']);
        unset($riskAssessment['footerContent']);

        /** Get FOOTER DOCTOR Signature  start */
        $signature = getDoctorSignature($json_reportdata);
        /** Get FOOTER DOCTOR Signature  END */
        $pdf_version = $json_reportdata->TestGroupDetails[0]->VERSION_NO;
        $lab_id = $json_reportdata->TestGroupDetails[0]->LAB_ID;
        $is_cap_accredited = $json_reportdata->TestGroupDetails[0]->Is_CAP_ACCREDITED ?? "";
        $is_nabl_accredited = $json_reportdata->TestGroupDetails[0]->Is_NABL_ACCREDITED ?? "";
        $nabl_code = $json_reportdata->TestGroupDetails[0]->NABL_CODE ?? "";
        $branch_address = $json_reportdata->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS  ?? "";
        $this->dbModel = new ReportDataModel();
        $addressflag = $this->dbModel->getsetaddressflag($lab_id);
        $setaddressflag = $addressflag[0]->setaddress_flag ?? "NO";
        $lims_slims = $addressflag[0]->lims_slims ?? "";
        $bracnhAddress = getBranchAddress($branch_address, $setaddressflag, $lab_id, $lims_slims);
        $companyname = $bracnhAddress['companyname'];
        $companyaddress  = $bracnhAddress['companyaddress'];
        $setaddressflag = $bracnhAddress['setaddressflag'];
        return [
            'lab_id' => $lab_id,
            'version_no' => $pdf_version,
            'reportTitle' => $reportTitle,
            'companyaddress' => $companyaddress,
            'companyname' => $companyname,
            'addressflag' => $setaddressflag,
            'lims_slims'   => $lims_slims,
            'PatientDetails' => $PatientDetails,
            'SpecimenDetails' => $SpecimenDetails,
            'PrescriptionDetails' => $PrescriptionDetails,
            'OngoingPregnancy' => $ongoingPregnancy,
            'SonographyDetails' => $getSonographyDetails,
            'RiskFactors' => $RiskFactors,
            'assistdetails' => $assistDetails,
            'parameterAssessed' => $parameterAssessed['parameterAssessed'],
            'Risk_Assessment' => $riskAssessment,
            'Interpretation' => $interpretation,
            'furtherTesting' => $furtherTesting,
            'signature' => $signature,
            'is_cap_accredited' => $is_cap_accredited,
            'is_nabl_accredited' => $is_nabl_accredited,
            'nabl_code' => $nabl_code,
            'abbreviations' => $footerContent
        ];
    }

    public function findoutPNSTestGroupCode($record, $testgroupcode)
    {
        foreach ($record->TestGroupDetails as $tgRow) {
            if ($testgroupcode == $tgRow->TEST_GROUP_CODE) {
                $record->TestGroupDetails[0] = $tgRow;
            }
        }
        return $record;
    }
    public function getParameterAssessedandRiskGraph($json_data, $testGroupCode, $marker)
    {
        /* Risk Assessment graph requiered variable declation */
        $ageRisk = "";
        $bioChemicalRisk = "";
        $bioChemicalRiskGrph = "";
        $riskResultValue = "";
        $ageGrph = "";
        $footerContent = "";
        /* Risk Assessment Test Codes */
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

        /*Parameter Asses test codes*/
        $testGroupCode = $json_data->TestGroupDetails[0]->TEST_GROUP_CODE;
        $TYPE_OF_MEASURE =  $json_data->PatientDetails[0]->TYPE_OF_MEASURE ?? "";
        $CONCEPTION = $json_data->PatientDetails[0]->CONCEPTION ?? "";
        if ($TYPE_OF_MEASURE == "USG EDD") {
            $TYPE_OF_MEASURE = str_replace("EDD", "", $TYPE_OF_MEASURE);
        }
        if ($CONCEPTION == "A") {
            $CONCEPTION = "Assisted";
            $TYPE_OF_MEASURE = "Ass Rep.";
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

        //===================== GET PACKAGES =========================/
        $packageconfigModel = new PackageConfigModel();
        $packages = $packageconfigModel->find();

        if (empty($packages)) {
            echo "update packages";
            return;
        }

        foreach ($packages as $pRow) {
            $packageData[$pRow['package_name']] = explode(",", $pRow['testgroupcodes']);
        }
        if (in_array($testGroupCode, $packageData['PE_MARKER_TEST_GROUP_CODE'])) {
            $pereport = 1;
        }
        if ($marker == "pereport") {
            $pe = 1;
            if (in_array($testGroupCode, $packageData['PE_MARKER_TEST_GROUP_CODE'])) {
                $pe = 1;
                if (in_array($testGroupCode, $packageData['PE_MARKER_TEST_GROUP_CODE']) && in_array($testGroupCode, $packageData['DOUBLE_MARKER_TEST_GROUP_CODE'])) {
                    $reportTitle = 'First Trimester Combined + Preeclampsia Screening Report';
                } elseif (in_array($testGroupCode, $packageData['ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE'])) {
                    $onetquadrapleMarker = 1;

                    $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
                } elseif (in_array($testGroupCode, $packageData['TRIPLE_MARKER_TEST_GROUP_CODE'])) {

                    $reportTitle = 'Second Trimester Triple Marker Screening Report';
                } elseif (in_array($testGroupCode, $packageData['QUADRUPLE_MARKER_TEST_GROUP_CODE'])) {
                    if (substr($testGroupCode, 0, 1) === 's') {
                        $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
                    } else {
                        $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
                    }
                } elseif (in_array($testGroupCode, $packageData['PENTA_MARKER_TEST_GROUP_CODE'])) {

                    $reportTitle = 'First Trimester Penta Marker Screening Report';
                }
            } else {
                if (in_array($testGroupCode, $packageData['DOUBLE_MARKER_TEST_GROUP_CODE'])) {
                    $reportTitle = 'First Trimester Combined + Preeclampsia Screening Report';
                    $doubleMarker = 1;
                } elseif (in_array($testGroupCode, $packageData['DOUBLE_MARKER_TEST_GROUP_CODE'])) {
                    $doubleMarker = 1;
                } elseif (in_array($testGroupCode, $packageData['TRIPLE_MARKER_TEST_GROUP_CODE'])) {
                    $tripleMarker = 1;
                    $reportTitle = 'Second Trimester Triple Marker Screening Report';
                } elseif (in_array($testGroupCode, $packageData['QUADRUPLE_MARKER_TEST_GROUP_CODE'])) {

                    $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
                } elseif (in_array($testGroupCode, $packageData['PENTA_MARKER_TEST_GROUP_CODE'])) {
                    $pentaMarker = 1;

                    $reportTitle = 'First Trimester Penta Marker Screening Report';
                } elseif (in_array($testGroupCode, $packageData['PE_MARKER_TEST_GROUP_CODE'])) {
                    $pe = 1;
                }
            }
        } else {
            if (in_array($testGroupCode, $packageData['PE_MARKER_TEST_GROUP_CODE']) && in_array($testGroupCode, $packageData['DOUBLE_MARKER_TEST_GROUP_CODE'])) {
                $reportTitle = 'First Trimester Combined + Preeclampsia Screening Report';
                $doubleMarker = 1;
            } elseif (in_array($testGroupCode, $packageData['DOUBLE_MARKER_TEST_GROUP_CODE'])) {
                $NT_VALUE = isset($json_data->PatientRiskDetails[0]->NT_VALUE) ? $json_data->PatientRiskDetails[0]->NT_VALUE :"";
                if ($NT_VALUE !="") {
                    $reportTitle = 'First Trimester Combined Screening Report ';
                    $showBR = 1;
                } else {
                    $reportTitle = 'First Trimester Double Marker Screening Report ';
                    $showBioComment = 1;
                }
                $doubleMarker = 1;
            } elseif (in_array($testGroupCode, $packageData['TRIPLE_MARKER_TEST_GROUP_CODE'])) {
                $tripleMarker = 1;

                $reportTitle = 'Second Trimester Triple Marker Screening Report';
            } elseif (in_array($testGroupCode, $packageData['QUADRUPLE_MARKER_TEST_GROUP_CODE'])) {
                $quadrapleMarker = 1;

                $reportTitle = 'Second Trimester Quadruple Marker Screening Report';
            } elseif (in_array($testGroupCode, $packageData['ONET_QUADRUPLE_MARKER_TEST_GROUP_CODE'])) {
                $onetquadrapleMarker = 1;

                $reportTitle = 'First Trimester Quadruple Marker Screening Report ';
            } elseif (in_array($testGroupCode, $packageData['PENTA_MARKER_TEST_GROUP_CODE'])) {
                $pentaMarker = 1;
                $reportTitle = 'First Trimester Penta Marker Screening Report';
            }
        }
        if ($doubleMarker) {
            $testCodes = $packageData['DOUBLE_MARKER_PARAMETERS_ASSESED'];
            $momCodes = DOUBLE_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        } elseif ($tripleMarker) {
            $testCodes = $packageData['TRIPLE_MARKER_PARAMETERS_ASSESED'];
            $momCodes = TRIPLE_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        } elseif ($quadrapleMarker) {
            $testCodes = $packageData['QUADRUPLE_MARKER_PARAMETERS_ASSESED'];
            $momCodes = QUADRUPLE_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        } elseif ($onetquadrapleMarker) {
            $testCodes = $packageData['ONET_QUADRUPLE_MARKER_PARAMETERS_ASSESED'];
            $momCodes = ONET_QUADRUPLE_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        } elseif ($pentaMarker) {
            $testCodes = $packageData['PENTA_MARKER_PARAMETERS_ASSESED'];
            if($marker === "report"){
                foreach($testCodes as $tKey => $test){
                    if($test == "P0030" || $test == "PLGF" || $test == "UTPIMOM" || $test == "MAPMOM"){
                        unset($testCodes[$tKey]);
                    }
                }
                $testCodes = array_values($testCodes);
            }
            $momCodes = PENTA_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        }
        if ($pe) {
            $testCodes = $packageData['PENTA_PE_MARKER_PARAMETERS_ASSESED'];
            $momCodes = PENTA_PE_MARKER_MOM_PARAMETERS_ASSESED;
            $data['parameter_assed'] = $testCodes;
        }
        /* Start Risk Assessment Test code merge based on Test Group*/
        $riskTestCodes = [];

        if (!isset($pe) || $pe == 0) {

            $riskTestCodes = array_merge($riskTestCodes, $packageData['DOWN_SYNDROME']);
            $riskTestCodes = array_merge($riskTestCodes, $packageData['EDWARD_SYNDROME']);
            $riskTestCodes = array_merge($riskTestCodes, $packageData['PATAU_SYNDROME']);
            $riskTestCodes = array_merge($riskTestCodes, $packageData['NEURAL_TUBE_DEFECTS']);
        } else {

            $riskTestCodes = array_merge($riskTestCodes, $packageData['PE_32']);
            $riskTestCodes = array_merge($riskTestCodes, $packageData['PE_34']);
            $riskTestCodes = array_merge($riskTestCodes, $packageData['PE_37']);
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
        $interpretation = "";
        $furtherTesting = [];
        $CEDD = [];
        $GA = [];
        $GA_CODES = ['GAATSAMPLELC', 'GAATSCANLC', 'GAATSAMPLE', 'GAATSAMPLEDAYS', 'GAATSCAN', 'GAATSCANDAYS'];
        $downsyndrome_risk_color = "";
        $downsyndrome_border_color = "";
        $edward_risk_color = "";
        $edward_border_color = "";
        $patau_risk_color = "";
        $patau_border_color = "";
        $ntsyndrome_risk_color = "";
        $ntsyndrome_border_color = "";
        $pe_32_risk_color = "";
        $pe_32_border_color = "";
        $pe_34_risk_color = "";
        $pe_34_border_color = "";
        $pe_37_risk_color = "";
        $pe_37_border_color = "";
        if (isset($json_data->TestResultDetails)) {
            $finalOutPut = [];

            foreach ($json_data->TestResultDetails as $resultData) {

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
                    $fts_penta_flag = 1;
                }

                if ($resultData->TEST_CODE == "PENTAINTERWOPE" && $fts_penta_flag == 0 && $pereport == 1  && $marker == "report") {
                    $interpretation .= str_replace(["/","Preeclampsia"],"",$resultData->RESULT_VALUE) . "\n";
                    $fts_penta_flag = 1;
                }
                if ($resultData->TEST_NAME == "STS Interpretation" && $sts_flag == 0) {
                    $interpretation .= $resultData->RESULT_VALUE . "\n";
                    $sts_flag = 1;
                }

                if (in_array($resultData->TEST_CODE, $testCodes)) {

                    $momValue = "";
                    foreach ($momTestResults as $momtestResult) {
                        if($resultData->TEST_CODE == "UTPIMOM" || $resultData->TEST_CODE == "MAPMOM"){
                            $momTestCode = $resultData->TEST_CODE;
                        }else{
                            $momTestCode = trim($momCodes[$resultData->TEST_CODE]);
                        }
                        if (trim($momtestResult->TEST_CODE) == $momTestCode) {
                            $momValue = $momtestResult->RESULT_VALUE;
                        }
                    }
                    $data[$resultData->TEST_CODE] = [
                        'result_value' => $resultData->RESULT_VALUE,
                        'mom_value' => $momValue,
                        'printing_name' => $resultData->PRINTING_NAME,
                        'uom_value' => str_replace(["�", "ï¿½"], "μ", $resultData->UOM),
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
                    if (in_array($resultData->TEST_CODE, $packageData['DOWN_SYNDROME'])) {
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
                                        $ageGrph = $agegraphValue[0] / $agegraphValue[1];
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['EDWARD_SYNDROME'])) {
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
                                        if (isset($agegraphValue[1]) && !empty($agegraphValue[1])) {
                                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                        } else {
                                            updateFailedReportLog($lab_id, 2);
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['PATAU_SYNDROME'])) {
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
                                        if (isset($agegraphValue[1]) && !empty($agegraphValue[1])) {
                                            $ageGrph = $agegraphValue[0] / $agegraphValue[1];
                                        } else {
                                            updateFailedReportLog($lab_id, 2);
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['NEURAL_TUBE_DEFECTS'])) {
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['PE_32'])) {
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['PE_34'])) {
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
                    } elseif (in_array($resultData->TEST_CODE, $packageData['PE_37'])) {
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

            //================================ FOOTER CONTENT ===========================================//
            if(array_key_exists($resultData->TEST_CODE, FOOTER_ABBREVATION)){
                $footerAbbrevation = FOOTER_ABBREVATION;
                $resultValue = $footerAbbrevation[$resultData->TEST_CODE];
                $footerContent .= $resultData->PRINTING_NAME.":".$resultValue." | ";
            }
            if($resultData->TEST_CODE == 'DIA'){
                $footerContent .='ELISA:'.'Enzyme-linked immunoassay |';
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
            if($TYPE_OF_MEASURE == "CRL"){
                $footerContent .= "CRL:Crown Rump Length ";
            }
        
            if($TYPE_OF_MEASURE == "BPD"){
                $footerContent .= "BPD: Biparietal Diameter";
            }

            $footerContent .= "| GA: Gestational Age | EDD: Expected Due Date | NM: Not Mentioned |";
            //============================= FOOTER CONTENT END ===========================================//

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
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $downsyndrome_risk_color = "low_risk";
                        //     $downsyndrome_border_color = "low_risk_border";
                        // }
                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $downsyndrome_risk_color = "intermediate_risk";
                            $downsyndrome_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $downsyndrome_risk_color = "increased_risk";
                            $downsyndrome_border_color = "increased_risk_border";
                        }

                        $printingName['down'] = 'Down Syndrome (T21)';
                    } else if ($data[$risktestCode]['syndrome'] == 'edward' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['edward'][$risktestCode] = $data[$risktestCode];
                        $edward_risk_color = "low_risk";
                        $edward_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $edward_risk_color = "low_risk";
                        //     $edward_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $edward_risk_color = "intermediate_risk";
                            $edward_border_color = "intermediate_risk_border";
                        }
                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $edward_risk_color = "increased_risk";
                            $edward_border_color = "increased_risk_border";
                        }

                        $printingName['edward'] = 'Edward Syndrome (T18)';
                    } else if ($data[$risktestCode]['syndrome'] == 'patau' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['patau'][$risktestCode] = $data[$risktestCode];
                        $patau_risk_color = "low_risk";
                        $patau_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $patau_risk_color = "low_risk";
                        //     $patau_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $patau_risk_color = "intermediate_risk";
                            $patau_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $patau_risk_color = "increased_risk";
                            $patau_border_color = "increased_risk_border";
                        }

                        $printingName['patau'] = 'Patau Syndrome (T13)';
                    } elseif ($data[$risktestCode]['syndrome'] == 'ntsyndrome' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['ntsyndrome'][$risktestCode] = $data[$risktestCode];
                        $ntsyndrome_risk_color = "low_risk";
                        $ntsyndrome_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $ntsyndrome_risk_color = "low_risk";
                        //     $ntsyndrome_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $ntsyndrome_risk_color = "intermediate_risk";
                            $ntsyndrome_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $ntsyndrome_risk_color = "increased_risk";
                            $ntsyndrome_border_color = "increased_risk_border";
                        }

                        $printingName['ntsyndrome'] = 'Neural Tube Defects (NTD)';
                    } elseif ($data[$risktestCode]['syndrome'] == 'pe_32' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['pe_32'][$risktestCode] = $data[$risktestCode];
                        $pe_32_risk_color = "low_risk";
                        $pe_32_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $pe_32_risk_color = "low_risk";
                        //     $pe_32_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $pe_32_risk_color = "intermediate_risk";
                            $pe_32_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $pe_32_risk_color = "increased_risk";
                            $pe_32_border_color = "increased_risk_border";
                        }

                        $printingName['pe_32'] = 'PE <32 weeks';
                    } elseif ($data[$risktestCode]['syndrome'] == 'pe_34' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['pe_34'][$risktestCode] = $data[$risktestCode];
                        $pe_34_risk_color = "low_risk";
                        $pe_34_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $pe_34_risk_color = "low_risk";
                        //     $pe_34_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $pe_34_risk_color = "intermediate_risk";
                            $pe_34_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $pe_34_risk_color = "increased_risk";
                            $pe_34_border_color = "increased_risk_border";
                        }

                        $printingName['pe_34'] = 'PE <34 weeks';
                    } elseif ($data[$risktestCode]['syndrome'] == 'pe_37' && !empty($data[$risktestCode]['final_risk'])) {
                        $testresults['pe_37'][$risktestCode] = $data[$risktestCode];
                        $pe_37_risk_color = "low_risk";
                        $pe_37_border_color = "low_risk_border";
                        // if (strtolower($data[$risktestCode]['risk_result']) == "low risk") {
                        //     $pe_37_risk_color = "low_risk";
                        //     $pe_37_border_color = "low_risk_border";
                        // }

                        if (strtolower($data[$risktestCode]['risk_result']) == "intermediate risk") {
                            $pe_37_risk_color = "intermediate_risk";
                            $pe_37_border_color = "intermediate_risk_border";
                        }

                        if(strtolower($data[$risktestCode]['risk_result']) == "increased risk"){
                            $pe_37_risk_color = "increased_risk";
                            $pe_37_border_color = "increased_risk_border";
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
        $riskSoftwareMethod = $finalRiskData['risk_software_method'];
        $riskSoftwareMethodByPrint = $finalRiskData['risk_software_method'];
        $downSyndrome = isset($riskResult['down']) ? $riskResult['down'] : [];
        $edwardSyndrome = isset($riskResult['edward']) ? $riskResult['edward'] : [];
        $patueSyndrome = isset($riskResult['patau']) ? $riskResult['patau'] : [];
        $ntSyndrome = isset($riskResult['ntsyndrome']) ? $riskResult['ntsyndrome'] : [];
        $pe32 = isset($riskResult['pe_32']) ? $riskResult['pe_32'] : [];
        $pe34 = isset($riskResult['pe_34']) ? $riskResult['pe_34'] : [];
        $pe37 = isset($riskResult['pe_37']) ? $riskResult['pe_37'] : [];
        $printingNamesOfRisk = $finalRiskData['printingNames'];
        $printingNamesOfParameter = $finalOutPut['printingNames'];

        $parameterAssessed['printingnames'] = getParameterAssesedNames($printingNamesOfParameter, $riskSoftwareMethodByPrint);
        $parameterAssessed['resultvalues'] = array_values($parameterResult);


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

        if (isset($CEDD["CEDD"]) && !empty($CEDD["CEDD"])) {
            $EDD = $CEDD["CEDD"];
        }
        if (empty($EDD)) {
            $EDD = $json_data->PatientDetails[0]->CORRECETD_EDD ?? "";
        }

        $riskAssessment =  [
            'reportTitle' => $reportTitle,
            "risksoftwaremethod" => $riskSoftwareMethod,
            "printingnamesofrisk" => $printingNamesOfRisk,
            "parameterAssessed" => $parameterAssessed,
            "showBioComment" => $showBioComment,
            "showBR" => $showBR,
            "interpretation" => $interpretation,
            "style_color" => [
                "downsyndrome_risk_color" => $downsyndrome_risk_color,
                "downsyndrome_border_color" =>  $downsyndrome_border_color,
                "edward_risk_color" =>  $edward_risk_color,
                "edward_border_color" =>  $edward_border_color,
                "patau_risk_color" =>  $patau_risk_color,
                "patau_border_color" =>  $patau_border_color,
                "ntsyndrome_risk_color" =>  $ntsyndrome_risk_color,
                "ntsyndrome_border_color" =>  $ntsyndrome_border_color,
                "pe_32_risk_color" =>  $pe_32_risk_color,
                "pe_32_border_color" =>  $pe_32_border_color,
                "pe_34_risk_color" =>  $pe_34_risk_color,
                "pe_34_border_color" =>  $pe_34_border_color,
                "pe_37_risk_color" =>  $pe_37_risk_color,
                "pe_37_border_color" =>  $pe_37_border_color
            ],
            'ga_at_collection' => $GA_MAPPING,
            'expectedduedate' => !empty($EDD) ? date('d-m-Y',strtotime($EDD)) : "NA",
            'furtherTesting' => $furtherTesting,
            'footercontent' => $footerContent
        ];
        if ($marker == "pereport") {
            $riskAssessment["pe32"] = $pe32;
            $riskAssessment["pe34"] = $pe34;
            $riskAssessment["pe37"] = $pe37;
        } else {
            $riskAssessment["downsyndrome"] = $downSyndrome;
            $riskAssessment["edwardSyndrome"] = $edwardSyndrome;
            $riskAssessment["patueSyndrome"] = $patueSyndrome;
            $riskAssessment["ntSyndrome"] = $ntSyndrome;
        }
        return $riskAssessment;
    }

    public function validateAddress($record){
        /**
        * IF PROCESSING_BRANCH_ADDRESS is empty then dont generate the reports
       */
       $PROCESSING_BRANCH_ADDRESS = $record->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS ?? "";

       if(empty($PROCESSING_BRANCH_ADDRESS)){
           updateFailedReportLog($record->PatientDetails[0]->LAB_ID,2);
           $this->report_table->updateFailedReprtFlag($record->PatientDetails[0]->LAB_ID,"","PROCESSING_BRANCH_ADDRESS Is Empty in JSON");
           return $PROCESSING_BRANCH_ADDRESS;
       }
       return $PROCESSING_BRANCH_ADDRESS;
   }

   public function getPEReportJson($json_reportdata)
   {
       helper('pns');
       $this->report_table = new PNSReportDataModel();
       /** GET PATEINT DETAILS START*/
       $PatientDetails = getPatientDetails($json_reportdata);
       /** GET PATEINT DETAILS END*/

       /** GET SpecimenDetails Details*/
       $SpecimenDetails = getSpecimenDetails($json_reportdata);
       /** GET SpecimenDetails End*/

       /** GET PrescriptionDetails Start */
       $PrescriptionDetails = getPrescriptionDetails($json_reportdata);
       /** GET PrescriptionDetails End */

       /** GET OngoingPregnancy Start */
       $ongoingPregnancy = getOngoingPregnancy($json_reportdata);
       /** GET ongoingPregnancy end */

       /** GET SonographyDetails Start */
       $getSonographyDetails = getSonographyDetails($json_reportdata);
       /** GET SonographyDetails End */

       /** PriorRiskFactors start */
       $RiskFactors = getPriorRiskFactors($json_reportdata);
       /**  PriorRiskFactors End */

       /** Get Risk Assessment start */
       $assistDetails = getAssistanceDetails($json_reportdata);
       /** Get Risk Assessment End */

       $testgroupcode = $json_reportdata->TestGroupDetails[0]->TEST_GROUP_CODE;
       $riskAssessment = $this->getParameterAssessedandRiskGraph($json_reportdata, $testgroupcode, "report");
       $parameterAssessed = ['parameterAssessed' => $riskAssessment['parameterAssessed']];
       $reportTitle = $riskAssessment['reportTitle'];
       $interpretation = $riskAssessment['interpretation'];
       $getSonographyDetails['ga_at_collection'] = ucwords(strtolower($riskAssessment['ga_at_collection']));
       $ongoingPregnancy['expectedduedate'] = $riskAssessment['expectedduedate'];
       $furtherTesting = $riskAssessment['furtherTesting'];
       $footerContent = $riskAssessment['footercontent'];
       unset($riskAssessment['parameterAssessed']);
       unset($riskAssessment['reportTitle']);
       unset($riskAssessment['furtherTesting']);
       unset($riskAssessment['interpretation']);
       unset($riskAssessment['footercontent']);
       /*** GET PE DETAILS */
       $pe_riskAssessment = $this->getParameterAssessedandRiskGraph($json_reportdata, $testgroupcode, "pereport");
       $pe_parameterAssessed = ['parameterAssessed' => $pe_riskAssessment['parameterAssessed']];
       $pe_Interpretation = $pe_riskAssessment['interpretation'];
    
       unset($pe_riskAssessment['parameterAssessed']);
       unset($pe_riskAssessment['reportTitle']);
       unset($pe_riskAssessment['furtherTesting']);
       unset($pe_riskAssessment['interpretation']);
       unset($pe_riskAssessment['footercontent']);
       unset($pe_riskAssessment['risksoftwaremethod']);
       unset($pe_riskAssessment['showBioComment']);
       unset($pe_riskAssessment['showBR']);
       unset($pe_riskAssessment['ga_at_collection']);
       unset($pe_riskAssessment['expectedduedate']);
       
       /** Get FOOTER DOCTOR Signature  start */
       $signature = getDoctorSignature($json_reportdata);
       /** Get FOOTER DOCTOR Signature  END */
       $pdf_version = $json_reportdata->TestGroupDetails[0]->VERSION_NO;
       $lab_id = $json_reportdata->TestGroupDetails[0]->LAB_ID;
       $is_cap_accredited = $json_reportdata->TestGroupDetails[0]->Is_CAP_ACCREDITED ?? "";
       $is_nabl_accredited = $json_reportdata->TestGroupDetails[0]->Is_NABL_ACCREDITED ?? "";
       $nabl_code = $json_reportdata->TestGroupDetails[0]->NABL_CODE ?? "";
       $branch_address = $json_reportdata->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS  ?? "";
       $this->dbModel = new ReportDataModel();
       $addressflag = $this->dbModel->getsetaddressflag($lab_id);
       $setaddressflag = $addressflag[0]->setaddress_flag ?? "NO";
       $lims_slims = $addressflag[0]->lims_slims ?? "";
       $bracnhAddress = getBranchAddress($branch_address, $setaddressflag, $lab_id, $lims_slims);
       $companyname = $bracnhAddress['companyname'];
       $companyaddress  = $bracnhAddress['companyaddress'];
       $setaddressflag = $bracnhAddress['setaddressflag'];

        if($json_reportdata->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "LIFECYCLE"){
            $risk_software_txt_line = "These results were analyzed with LifeCycle software from PerkinElmer Life and Analytical Sciences";
        }
        if($json_reportdata->PatientRiskDetails[0]->RISK_SOFTWARE_NAME == "PRISCA"){
            $risk_software_txt_line = "These results were analyzed with PRISCA software from siemens";
        } 

        $risk_type =  $json_reportdata->PatientDetails[0]->RISK_TYPE ?? "2LEVEL";

       return [
           'lab_id' => $lab_id,
           'version_no' => $pdf_version,
           'reportTitle' => $reportTitle,
           'companyaddress' => $companyaddress,
           'companyname' => $companyname,
           'addressflag' => $setaddressflag,
           'lims_slims'   => $lims_slims,
           'PatientDetails' => $PatientDetails,
           'SpecimenDetails' => $SpecimenDetails,
           'PrescriptionDetails' => $PrescriptionDetails,
           'OngoingPregnancy' => $ongoingPregnancy,
           'SonographyDetails' => $getSonographyDetails,
           'RiskFactors' => $RiskFactors,
           'assistdetails' => $assistDetails,
           'parameterAssessed' => $parameterAssessed['parameterAssessed'],
           'Risk_Assessment' => $riskAssessment,
           'Interpretation' => $interpretation,
           'pe_parameterAssessed' => $pe_parameterAssessed['parameterAssessed'],
           'pe_Risk_Assessment' => $pe_riskAssessment,
           'pe_Interpretation' => $pe_Interpretation,
           'furtherTesting' => $furtherTesting,
           'signature' => $signature,
           'is_cap_accredited' => $is_cap_accredited,
           'is_nabl_accredited' => $is_nabl_accredited,
           'nabl_code' => $nabl_code,
           'abbreviations' => $footerContent,
           'risk_software_txt_line' => $risk_software_txt_line,
           'risk_type' => $risk_type
       ];
   }
}
