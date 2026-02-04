<?php

// PatientDetails 
function getPatientDetails($json_reportdata)
{
    $title =  $json_reportdata->PatientDetails[0]->TITLE != '' ? $json_reportdata->PatientDetails[0]->TITLE : '';
    $patientName = $json_reportdata->PatientDetails[0]->PATIENT_NAME ? ucwords(($json_reportdata->PatientDetails[0]->PATIENT_NAME)) : NULL;
    $husbandName = $json_reportdata->PatientDetails[0]->PARENT_NAME ? ucwords(($json_reportdata->PatientDetails[0]->PARENT_NAME)) : NULL;
    $patientDob = $json_reportdata->PatientDetails[0]->BIRTH_DATE != '' ?
        date("d-m-Y", strtotime($json_reportdata->PatientDetails[0]->BIRTH_DATE)) : '';
    $gender = 'NA';
    if (trim($json_reportdata->PatientDetails[0]->GENDER) == 'F') {
        $gender = 'Female';
    } else if (trim($json_reportdata->PatientDetails[0]->GENDER) == 'M') {
        $gender = 'Male';
    }
    $height = $json_reportdata->PatientRiskDetails[0]->HEIGHT ? $json_reportdata->PatientRiskDetails[0]->HEIGHT . "cm" : "";
    $weight = $json_reportdata->PatientRiskDetails[0]->WEIGHT ? $json_reportdata->PatientRiskDetails[0]->WEIGHT . "Kg" : "";
    $Ethnicity = $json_reportdata->PatientDetails[0]->ETHNICITY != '' ? $json_reportdata->PatientDetails[0]->ETHNICITY : '';
    return ['Title' => $title, 'Patient_name' => $patientName, 'husband_name' => $husbandName, 'patient_Dob' => $patientDob, 'Patient_gender' => $gender, 'height' => $height, 'weight' => $weight, 'Ethnicity' => $Ethnicity];
}

// Specimen Details
function getSpecimenDetails($json_reportdata)
{
    $lab_id  = $json_reportdata->PatientDetails[0]->LAB_ID != '' ? $json_reportdata->PatientDetails[0]->LAB_ID : '';
    $Specimen = $json_reportdata->PatientDetails[0]->SAMPLE_ID != '' ? $json_reportdata->PatientDetails[0]->SAMPLE_ID : '';
    $collectedOn = $json_reportdata->PatientDetails[0]->SAMPLE_DATE != '' ? dateformat($json_reportdata->PatientDetails[0]->SAMPLE_DATE) : '';
    $Receivedon = $json_reportdata->PatientDetails[0]->RECEIVED_DATE != '' ? dateformat($json_reportdata->PatientDetails[0]->RECEIVED_DATE) : '';
    $ReportDate = $json_reportdata->TestGroupDetails[0]->APPROVED_ON != '' ? dateformat($json_reportdata->TestGroupDetails[0]->APPROVED_ON) : '';
    $PatientId = $json_reportdata->PatientDetails[0]->PATIENT_ID != '' ? $json_reportdata->PatientDetails[0]->PATIENT_ID : '';
    return ['Specimen' => $Specimen, 'lab_id' => $lab_id, 'Collected_on' => $collectedOn, 'Receivedon' => $Receivedon, 'ReportDate' => $ReportDate, 'Crm_id' => $PatientId, 'Lab_id' => $lab_id];
}
//Patient PrescriptionDetails
function getPrescriptionDetails($json_reportdata)
{
    $Clinician = $json_reportdata->PatientDetails[0]->REFERRED_BY != '' ? $json_reportdata->PatientDetails[0]->REFERRED_BY : '';
    $Hospital = trim($json_reportdata->PatientDetails[0]->HOSPITAL_NAME) != '' ? $json_reportdata->PatientDetails[0]->HOSPITAL_NAME : (trim($json_reportdata->PatientDetails[0]->HOSPITAL_CODE) != '' ? $json_reportdata->PatientDetails[0]->HOSPITAL_CODE : '');
    if($json_reportdata->PatientDetails[0]->SYSTEM_TYPE == "Web"){
        $City = $json_reportdata->PatientDetails[0]->City != '' ? $json_reportdata->PatientDetails[0]->City : '';
    }else{
    $City = $json_reportdata->PatientDetails[0]->CENTER_CODE != '' ? $json_reportdata->PatientDetails[0]->CENTER_CODE : '';
    }
    return ['Clinician' => $Clinician, 'Hospital' => $Hospital, 'City' => $City];
}
//Patient getOngoingPregnancy
function getOngoingPregnancy($json_reportdata)
{
    $lastMenstrualPeriod = $json_reportdata->PatientDetails[0]->LMP_DATE != '' ?
    date('d-m-Y', strtotime($json_reportdata->PatientDetails[0]->LMP_DATE)) : 'NA';
    $type_of_measure =  $json_reportdata->PatientDetails[0]->TYPE_OF_MEASURE ?? "";
    $conception = $json_reportdata->PatientDetails[0]->CONCEPTION;
    if($conception == "A"){
        $type_of_measure = "Ass Rep.";
    }

    if ($conception != '') {
        if ($conception == 'N') {
            $conception = "Natural";
        } else if ($conception == 'A') {
            $conception = "Assisted";
        } else {
            $conception;
        }
    } else {
        $conception = 'NA';
    }
    if($type_of_measure == "USG EDD"){
        $type_of_measure = str_replace("EDD", "", $type_of_measure);
    }
  
    $NumberofFoetus = $json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB != '' ? $json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB : 'NA';
    $MaternalAgeatTerm = $json_reportdata->PatientDetails[0]->age_yy != '' ?  $json_reportdata->PatientDetails[0]->age_yy." Years" : 'NA';
    return ['lastMenstrualPeriod' => $lastMenstrualPeriod, 'Conception_Method' => $conception, 'NumberofFoetus' => $NumberofFoetus,'MaternalAgeatTerm' => $MaternalAgeatTerm,"type_of_measure" => $type_of_measure];
}
function getSonographyDetails($json_reportdata)
{
    //twins
    if ($json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
        // $crlvalue = $json_reportdata->PatientRiskDetails[0]->CRL_VALUE ."mm, ".$json_reportdata->PatientRiskDetails[0]->CRL_VALUE_2."mm";
        $crlvalue = (($json_reportdata->PatientRiskDetails[0]->CRL_VALUE != '') ?
        $json_reportdata->PatientRiskDetails[0]->CRL_VALUE . "mm, " . $json_reportdata->PatientRiskDetails[0]->CRL_VALUE_2 . "mm" : ($json_reportdata->PatientDetails[0]->USG_CRL2 != '' ?
            $json_reportdata->PatientDetails[0]->USG_CRL2 . "mm" : "NA")
    );
    } else {    //single
        // $crlvalue = $json_reportdata->PatientDetails[0]->CRL_VALUE != '' ? $json_reportdata->PatientDetails[0]->CRL_VALUE : 'NA';
        $crlvalue = (($json_reportdata->PatientDetails[0]->CRL_VALUE != '') ?
        $json_reportdata->PatientDetails[0]->CRL_VALUE : ($json_reportdata->PatientDetails[0]->USG_CRL != ''
            ? $json_reportdata->PatientDetails[0]->USG_CRL : "NA")
    );
    }

    if ($json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
        // if(isset($json_reportdata->PatientRiskDetails[0]->BPD_VALUE) && !empty($json_reportdata->PatientRiskDetails[0]->BPD_VALUE)){
        //     $biparietalDiameter = $json_reportdata->PatientRiskDetails[0]->BPD_VALUE ."mm,".$json_reportdata->PatientRiskDetails[0]->BPD_VALUE_2."mm";
        // }
        if(isset($json_reportdata->PatientRiskDetails[0]->BPD_VALUE) || isset($json_reportdata->PatientRiskDetails[0]->BPD_VALUE_2) || isset($json_reportdata->PatientDetails[0]->USG_BPD2)){
            $biparietalDiameter = (($json_reportdata->PatientRiskDetails[0]->BPD_VALUE != '') ?
            $json_reportdata->PatientRiskDetails[0]->BPD_VALUE . "mm," . $json_reportdata->PatientRiskDetails[0]->BPD_VALUE_2 . "mm" : (isset($json_reportdata->PatientDetails[0]->USG_BPD2) && $json_reportdata->PatientDetails[0]->USG_BPD2 != '' ?
            $json_reportdata->PatientDetails[0]->USG_BPD2 . "mm" : "NA"));
        }else{
            $biparietalDiameter = "NA";
        }
    } else {
        $biparietalDiameter  = (($json_reportdata->PatientDetails[0]->BPD_VALUE != '') ?
        $json_reportdata->PatientDetails[0]->BPD_VALUE : (isset($json_reportdata->PatientDetails[0]->USG_BPD) && $json_reportdata->PatientDetails[0]->USG_BPD != ''
            ? $json_reportdata->PatientDetails[0]->USG_BPD : "NA"));
    }

    if (isset($json_reportdata->PatientRiskDetails[0]->NASAL_BONE) && $json_reportdata->PatientRiskDetails[0]->NASAL_BONE != '') {
        $NASAL_BONE = "";
        if ($json_reportdata->PatientRiskDetails[0]->NASAL_BONE == "P") {
            $NASAL_BONE = "Present";
        } else if ($json_reportdata->PatientRiskDetails[0]->NASAL_BONE == "A") {
            $NASAL_BONE = "Absent";
        }

        if ($json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
            if ($json_reportdata->PatientRiskDetails[0]->NASAL_BONE_2 == "P") {
                $NASAL_BONE_2 = "Present";
            } else if ($json_reportdata->PatientRiskDetails[0]->NASAL_BONE_2 == "A") {
                $NASAL_BONE_2 = "Absent";
            }
            $nasalbon_result = $NASAL_BONE . ',' . $NASAL_BONE_2;
        } else {
            $nasalbon_result = $NASAL_BONE;
        }
    } else {
        $nasalbon_result = "NA";
    }


    $ScanDate = $json_reportdata->PatientDetails[0]->SCAN_DATE != '' ? date('d-m-Y', strtotime($json_reportdata->PatientDetails[0]->SCAN_DATE)) : 'NA';
    $Bycrl = $json_reportdata->PatientDetails[0]->TYPE_OF_MEASURE;
    $Sonographer = $json_reportdata->PatientDetails[0]->FMF_DR_NAME ?? "";

    $chorionicity = "";
   if ($json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB == 2) {
        $chorionicity = "NA";
        if ($json_reportdata->PatientRiskDetails[0]->CHORIONICITY == "0") {
            $chorionicity = "Dichorionic";
        }
        if ($json_reportdata->PatientRiskDetails[0]->CHORIONICITY == "1") {
            $chorionicity = "Monochorionic, diamniotic";
        }
        if ($json_reportdata->PatientRiskDetails[0]->CHORIONICITY == "2") {
            $chorionicity = "Monochorionic, monoamniontic";
        }
        if ($json_reportdata->PatientRiskDetails[0]->CHORIONICITY == "3") {
            $chorionicity = "Dichorionic, diamniotic";
        }
    }
    if (isset($Sonographer)) {
        $Sonographer != '' ? $Sonographer : '';
    }
    return ['CrownRumpLength' => $crlvalue, 'BiparietalDiameter' => $biparietalDiameter, 'NasalBon' => $nasalbon_result, 'ScanDate' => $ScanDate, 'Sonographer' => $Sonographer,
    'no_of_whimb' => $json_reportdata->PatientRiskDetails[0]->NUMBER_OF_FETEUS_IN_WHIMB,'chorionicity' =>$chorionicity ];
   
}

function getPriorRiskFactors($json_reportdata)
{
    if (isset($json_reportdata->PatientRiskDetails)) {

        $prior_risk = [];
        $SMOKING = $json_reportdata->PatientRiskDetails[0]->SMOKING;
        if ($SMOKING == "Y" || $SMOKING == "YES") {
            $prior_risk['Smoker'] = "Yes";
        }else if ($SMOKING == "N" || $SMOKING == "NO") {
            $prior_risk['Smoker'] = "No";
        }else if ($SMOKING == "" || $SMOKING == NULL) {
            $prior_risk['Smoker'] = "NULL";
        }
        $DIABETETS = $json_reportdata->PatientRiskDetails[0]->DIABETETS;
        if ($DIABETETS == "Y") {
            if($json_reportdata->PatientRiskDetails[0]->DIABETIC_TYPE == "1"){
                $prior_risk['Diabetes'] = "Type 1";
            }
            if($json_reportdata->PatientRiskDetails[0]->DIABETIC_TYPE == "2"){
                $prior_risk['Diabetes'] = "Type 2";
            }
        }else if ($DIABETETS == "N") {
            $prior_risk['Diabetes'] = "No";
        }else if ($DIABETETS == "" || $DIABETETS == NULL) {
            $prior_risk['Diabetes'] = "NULL";
        }else{
            $prior_risk['Diabetes'] = "NA";
        }
        $CHRONIC_HYPERTENSION = $json_reportdata->PatientRiskDetails[0]->CHRONIC_HYPERTENSION;
        if ($CHRONIC_HYPERTENSION == "3") {
            $prior_risk['Hypertension'] = "Yes";
        }else if($CHRONIC_HYPERTENSION == "1") {
            $prior_risk['Hypertension'] = "Untreated";
        }else if($CHRONIC_HYPERTENSION == "2"){
            $prior_risk['Hypertension'] = "Medication";
        }elseif($CHRONIC_HYPERTENSION == "0"){
            $prior_risk['Hypertension'] = "No";
        }elseif($CHRONIC_HYPERTENSION == "-1"){
            $prior_risk['Hypertension'] = "Not Known";
        }else{
            $prior_risk['Hypertension'] = "NULL";
        }

        $prev_history = "";
        
        $PREVIOUS_DOWN = $json_reportdata->PatientRiskDetails[0]->PREVIOUS_DOWN;
        if ($PREVIOUS_DOWN == "Y") {
            $prev_history .= "T21";
        }
        $PATAUS_SYNDROME = $json_reportdata->PatientRiskDetails[0]->PATAUS_SYNDROME;
        if ($PATAUS_SYNDROME == "Y") {
            $prev_history .= !empty($prev_history) ?  ",T13" : "T13";
        }
        $PREVIOUS_EDWARDS = $json_reportdata->PatientRiskDetails[0]->PREVIOUS_EDWARDS;
        if ($PREVIOUS_EDWARDS == "Y") {
            $prev_history .= !empty($prev_history) ? ",T18" : "T18";
        }

        $PREVIOUS_NTD = $json_reportdata->PatientRiskDetails[0]->PREVIOUS_NTD;
        if ($PREVIOUS_NTD == "Y") {
            $prev_history .= !empty($prev_history) ? ",O NTD" : "O NTD";
        }

        if(!empty($prev_history)){
            $prior_risk['Previous Baby history'] = "$prev_history";
        }else if($PREVIOUS_DOWN == "N" && $PATAUS_SYNDROME == "N" && $PREVIOUS_EDWARDS == "N" && $PREVIOUS_NTD == "N"){
            $prior_risk['Previous Baby history'] = "No";
        }else if(empty($PREVIOUS_DOWN) && empty($PATAUS_SYNDROME) && empty($PREVIOUS_EDWARDS) && empty($PREVIOUS_NTD)){
            $prior_risk['Previous Baby history'] = "NULL";
        }

        $past_history = "";
        
        $FAMILY_HISTORY_DOWNS = $json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_DOWNS;
        if ($FAMILY_HISTORY_DOWNS == "Y") {
            $past_history .= "T21";
        }
       
        $FAMILY_HISTORY_EDWARDS = $json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_EDWARDS;
        if ($FAMILY_HISTORY_EDWARDS == "Y") {
            $past_history .= !empty($past_history) ? ",T18" : "T18";
        }

        $FAMILY_HISTORY_ONTD = $json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_ONTD;
        if ($FAMILY_HISTORY_ONTD == "Y") {
            $past_history .= !empty($past_history) ? ",O NTD" : "O NTD";
        }

        if(!empty($past_history)){
            $prior_risk['Past / Family History'] = $past_history;
        }else if($FAMILY_HISTORY_DOWNS == "N" && $FAMILY_HISTORY_EDWARDS == "N" && $FAMILY_HISTORY_ONTD == "N"){
            $prior_risk['Past / Family History'] = "No";
        }else if(empty($FAMILY_HISTORY_DOWNS) && empty($FAMILY_HISTORY_EDWARDS) && empty($FAMILY_HISTORY_ONTD)){
            $prior_risk['Past / Family History'] = "NULL";
        }
    
        $pe_prior_risk = [];
        if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "1") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "Patient had  Preeclampsia";
        }else if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "0") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "No";
        }else if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "2") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "Mother of Patient had  Preeclampsia";
        }else if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "3") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "Mother of Patient & Patient had  Preeclampsia";
        }else if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "Y") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "Preeclampsia in previous pregnancy";
        }else if ($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE == "N") {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "No";
        }else if (empty($json_reportdata->PatientRiskDetails[0]->FAMILY_HISTORY_OF_PE)) {
            $pe_prior_risk['Past / Family History of Preeclampsia'] = "NULL";
        }
    
        return ['prior_risk' => $prior_risk,'pe_prior_risk' => $pe_prior_risk];
    }
}


function getAssistanceDetails($json_reportdata)
{
    if (isset($json_reportdata->PatientRiskDetails[0]->CONCEPTION_TYPE) && ($json_reportdata->PatientRiskDetails[0]->CONCEPTION_TYPE != '')) {
        $CONCEPTION_TYPE = $json_reportdata->PatientRiskDetails[0]->CONCEPTION_TYPE;
        if ($CONCEPTION_TYPE == 0) {
            $conceptiontype = "In Vitro Fertilization";
        } else if ($CONCEPTION_TYPE == 1) {
            $conceptiontype = "Gift";
        } else if ($CONCEPTION_TYPE == 2) {
            $conceptiontype = "Zift";
        } else if ($CONCEPTION_TYPE == 3) {
            $conceptiontype = "Clomiphene Treatment";
        } else if ($CONCEPTION_TYPE == 4) {
            if ($json_reportdata->PatientRiskDetails[0]->EGG == "Donor") {
                $conceptiontype = "Donor Egg";
            }
            if ($json_reportdata->PatientRiskDetails[0]->EGG == "Own") {
                $conceptiontype = "Own Egg";
            }
        } else if ($CONCEPTION_TYPE == 5) {
            $conceptiontype = "Donor Insemination";
        } else if ($CONCEPTION_TYPE == 6) {
            $conceptiontype = "ICSI";
        } else if ($CONCEPTION_TYPE == 7) {
            $conceptiontype = "Other";
        } else if ($CONCEPTION_TYPE == 8) {
            $conceptiontype = "IUI";
        }
    } else {
        $conceptiontype = "NA";
    }

    $method = $conceptiontype;
    $transferDate = $json_reportdata->PatientRiskDetails[0]->TRANSFER_DATE != '' ?
    date('d-m-Y', strtotime($json_reportdata->PatientRiskDetails[0]->TRANSFER_DATE)) : 'NA';
    $eggExtractionDate = $json_reportdata->PatientRiskDetails[0]->EXTRACTION_DATE != '' ?
        date('d-m-Y', strtotime($json_reportdata->PatientRiskDetails[0]->EXTRACTION_DATE)) : 'NA';
    $ageAtExtraction = $json_reportdata->PatientRiskDetails[0]->DONOR_AGE_AT_EDD != '' ?
        $json_reportdata->PatientRiskDetails[0]->DONOR_AGE_AT_EDD : 'NA';
    return ['Method' => $method, 'TransferDate' => $transferDate, 'EggExtractionDate' => $eggExtractionDate, 'AgeAtExtraction' => $ageAtExtraction];
}



function getParameterAssesedNames($printingNamesOfParameter, $riskSoftwareMethodByPrint)
{
    $testresultsparameter = [];
    foreach ($printingNamesOfParameter as $parametertestCode) {
        $printingName = $parametertestCode;
        $parameterMethod = "";
        if ($riskSoftwareMethodByPrint == "LIFECYCLE") {
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
        }
        if ($printingName == 'PAPPA') {
            $printingName = "PAPP-A";
        }

        if ($printingName == 'UTPi MoM') {
            $printingName = "UTPi";
        }
        if ($printingName == 'MAP MoM') {
            $printingName = "MAP";
        }
        if ($printingName == 'NT' || $printingName == 'NT2' || $printingName == "UAPI") {
            $parameterMethod = "Scan";
        }
        $testresultsparameter[] = [
            'printing_name' => $printingName,
            'parametermethod' => "By $parameterMethod",
        ];
    }
    return $testresultsparameter;
}

function getInterpretation($json_reportdata)
{
    /* Interpretation variable declared */
    $fts_flag = $fts_penta_flag = $sts_flag = 0;
    $interpretation = "";
    if (isset($json_reportdata->TestResultDetails)) {
        foreach ($json_reportdata->TestResultDetails as $resultData) {
            if ($resultData->TEST_NAME == "FTS Interpretation" && $fts_flag == 0) {
                $interpretation .= $resultData->RESULT_VALUE;
                $fts_flag = 1;
            }
            if ($resultData->TEST_NAME == "FTS Penta Interpretation" && $fts_penta_flag == 0) {
                $interpretation .= $resultData->RESULT_VALUE;
                $fts_penta_flag = 1;
            }
            if ($resultData->TEST_NAME == "STS Interpretation" && $sts_flag == 0) {
                $interpretation .= $resultData->RESULT_VALUE;
                $sts_flag = 1;
            }
            // if($resultData->LAB_ID == "41000104647"){
            //     debug($interpretation);
            // }
        }
    }
    return ['Interpretation' => $interpretation];
}


function getBranchAddress($branch_address, $setaddressflag, $lab_id,$lims_slims)
{
    $branchAddress['companyname'] = "";
    $branchAddress['companyaddress']  = "";
    $branchAddress['setaddressflag'] = $setaddressflag;
    if(empty($lims_slims)){
        $lims_slims = $lab_id[0] == 4 ? "lims" : "slims";
    }
    if (empty($setaddressflag) && $lims_slims == "lims") {
        $branchAddress['setaddressflag'] = "NO";
        if (empty($branch_address)) {
            $branch_address = "LifeCell International Pvt Ltd,
         No: 26, Vandalur-Kelambakkam Main Road, Keelakottaiyur, Chennai - 600127";
        }
    }
    if ($branch_address) {
        $branch_address = trim($branch_address,"\r\n");
		$branch_address = str_replace("\r\n","<br>",$branch_address);
        $address = explode(",", $branch_address);
        $branchAddress['companyname']  = $address[0] ?? "";
        unset($address[0]);
        $branchAddress['companyaddress'] = implode(",", $address);
    }
    return $branchAddress;
}


function updateFailedReportLog($lab_id,$is_generate,$failed_reason=""){
    $dbh = \Config\Database::connect();
    $dbh->query("update pns_report_data set is_generated = $is_generate,is_failed = 1,failed_reason='$failed_reason',email_sent=0 where lab_id = '".$lab_id."' ");
}


function getHeaderTitle($json_reportdata)
{
    $lab_id = $json_reportdata->PatientDetails[0]->LAB_ID;

    /*Parameter Asses test codes*/
    $testGroupCode = $json_reportdata->TestGroupDetails[0]->TEST_GROUP_CODE;
    $marker = "";
    $reportTitle = '';
    if ($marker == "pereport") {
        $pe = 1;
        if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE)) {
            if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
                $reportTitle = 'First Trimester Combine + Pre-eclampsia Screening Report';
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
                $reportTitle = 'First Trimester Combine + Pre-eclampsia Screening Report';
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
        //die("hi");
        if (in_array($testGroupCode, PE_MARKER_TEST_GROUP_CODE) && in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
            $reportTitle = 'First Trimester Combine + Pre-eclampsia Screening Report';
        } elseif (in_array($testGroupCode, DOUBLE_MARKER_TEST_GROUP_CODE)) {
            if (isset($json_reportdata->PatientRiskDetails[0]->IS_NT_VALUE_PASS) && ($json_reportdata->PatientRiskDetails[0]->IS_NT_VALUE_PASS == 'Y')) {
                $reportTitle = 'First Trimester Combined Screening Report ';
            } else {
                $reportTitle = 'First Trimester Double Marker Screening Report ';
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
    $filename = "report-" . $lab_id . "-ver-" . $json_reportdata->PatientDetails[0]->VERSION_NO;
    return ['ReportTitle' => $reportTitle, 'FileName' => $filename];
}

function getDoctorSignature($json_data)
{
    
    foreach ($json_data->TestGroupDetails as $doctorResult) {
        $signature = [];
        $doctor1signature = $doctorResult->Doctor1DigitalSignature ?? "";
        if ($doctor1signature) {
            $doctor1signature = base64ToImage($doctor1signature, "json");
            $signature['doctor1'] =  $doctorResult->Doctor1Name ?? "";
            $signature['doctor1qualification'] = $doctorResult->Doctor1Degree ?? "";
            $signature['doctor1signature'] = $doctor1signature;
        }

        $doctor2signature = $doctorResult->Doctor2DigitalSignature ?? "";
        if ($doctor2signature) {
            $doctor2signature = base64ToImage($doctor2signature, "json");
            $signature['doctor2'] = $doctorResult->Doctor2Name ?? "";
            $signature['doctor2qualification'] = $doctorResult->Doctor2Degree ?? "";
            $signature['doctor2signature'] = $doctor2signature;
        }

        $doctor3signature = $doctorResult->Doctor3DigitalSignature ?? "";
        if ($doctor3signature) {
            $doctor3signature = base64ToImage($doctor3signature, "json");
            $signature['doctor3'] = $doctorResult->Doctor3Name ?? "";
            $signature['doctor3qualification'] = $doctorResult->Doctor3Degree ?? "";
            $signature['doctor3signature'] = $doctor3signature;
        }
    }
    return $signature;
}


if(!function_exists('dateformat')){
    function dateformat($datetime)
    {
        $dateTime = date_create($datetime);
        return date_format($dateTime, 'd-m-Y H:i');
    }
}


function updateAdditionalFilter($lab_id, $update_filter)
{
    $twin = $update_filter['twin'];
    $type_of_measure = $update_filter['type_of_measure'];
    $prior_risk = $update_filter['prior_risk'];
    $risk_assesment = $update_filter['risk_assesment'] ?? '';
    $further_testing = $update_filter['further_testing'];
    $final_risk = $update_filter['final_risk'];
    $biochemical_risk = $update_filter['biochemical_risk'];
    $bio_comment = $update_filter['bio_comment'];
    $assistance_details = $update_filter['assistance_details'];
    $report_title = $update_filter['report_title'] ?? "";
    $cap = $update_filter['cap'] ?? "";
    $nabl = $update_filter['nabl'] ?? "";
    $branch = $update_filter['branch'] ?? "";
    $uk_neqas = $update_filter['uk_neqas'] ?? "";
    $dbh = \Config\Database::connect();
    $dbh->query("update pns_report_data set twin = $twin,type_of_measure = '$type_of_measure', prior_risk='$prior_risk', 
    risk_assesment='$risk_assesment', further_testing=$further_testing, final_risk='$final_risk', 
    biochemical_risk=$biochemical_risk, bio_comment= $bio_comment, assistance_details= $assistance_details,
    report_title='$report_title',cap=$cap,nabl=$nabl,branch='$branch',uk_neqas=$uk_neqas where lab_id = '" . $lab_id . "' ");

}


/**@ SR-263
    Description : checkRisk will check if required risk details are available in json
    Param : labid, Risk array ,double marker flag
@**/
function checkRisk($lab_id,$riskResult,$doubleMarker,$pe_sub_report,$risk_type){
   
    /**For rest of cases logic is same except for non double marker report with down syndrome */
    foreach($riskResult as $risk_details){
        if(empty($risk_details['final_risk'])){
            updateBlockedReasonLog($lab_id, "Final Risk Empty for $risk_type Syndrome");
            return "Final Risk Empty for $risk_type Syndrome";
        }

        if($risk_type=='Down' && $doubleMarker==0 && $pe_sub_report==0){
           
            if(empty($risk_details['biochemical_risk'])){
                updateBlockedReasonLog($lab_id,  "Biochemical Risk Empty for $risk_type Syndrome");
                return "Biochemical Risk Empty for $risk_type Syndrome";
            }
        }

        if(empty($risk_details['age_risk']) && $pe_sub_report==0){
            updateBlockedReasonLog($lab_id, "Age Risk Empty for $risk_type Syndrome");
            return "Age Risk Empty for $risk_type Syndrome";
        }

        if(empty($risk_details['risk_result'])){
            updateBlockedReasonLog($lab_id,  "Risk Result Empty for $risk_type Syndrome");
            return "Risk Result Empty for $risk_type Syndrome";
        }

    }

    return 1;
}


function updateBlockedReasonLog($lab_id,$failed_reason=""){
    $dbh = \Config\Database::connect();
    $dbh->query("update pns_report_data set blocked_reason='$failed_reason',blocked_email_sent=0 where lab_id = '".$lab_id."' ");
}



function checkRiskMatrix($lab_id,$riskResult,$software,$report_title,$is_pdf,$testGroupCode){

    $risk_config = [
        'LIFECYCLE'=>[
            'FTS'=>[
                'combined_screening'=>[
                    'down'=>['final_risk','biochemical_risk','age_risk','risk_result'],
                    'edward'=>['final_risk','age_risk','risk_result'],
                    'patau'=>['final_risk','age_risk','risk_result']
                ],
                'double_marker'=>[
                    'down'=>['age_risk','risk_result'],
                    'edward'=>['final_risk','age_risk','risk_result'],
                    'patau'=>['final_risk','age_risk','risk_result']
                ],
            ],
            'STS'=>[
                'down'=>['final_risk','age_risk','risk_result'],
                'edward'=>['final_risk','age_risk','risk_result'],
                'patau'=>['final_risk','age_risk','risk_result'],
                'ntsyndrome'=>['risk_result']
            ],
            'SQ'=>[
                'down'=>['final_risk','age_risk','risk_result'],
                'edward'=>['final_risk','age_risk','risk_result'],
                'patau'=>['final_risk','age_risk','risk_result'],
                'ntsyndrome'=>['risk_result']
            ],
            'FTS_PE'=>[
                'combined_screening'=>[
                    'down'=>['final_risk','biochemical_risk','age_risk','risk_result'],
                    'edward'=>['final_risk','age_risk','risk_result'],
                    'patau'=>['final_risk','age_risk','risk_result'],
                    'pe32'=>['final_risk','risk_result'],
                    'pe34'=>['final_risk','risk_result'],
                    'pe37'=>['final_risk','risk_result']
                ]
            ],
        ],
        'PRISCA'=>[
            'FTS'=>[
                'combined_screening'=>[
                    'down'=>['final_risk','biochemical_risk','age_risk','risk_result'],
                    'edward'=>['final_risk','risk_result'],
                    'patau'=>['final_risk','risk_result']
                ],
                'double_marker'=>[
                    'down'=>['age_risk','risk_result'],
                    'edward'=>['final_risk','risk_result'],
                    'patau'=>['final_risk','risk_result']
                ],
            ],
            'STS'=>[
                'down'=>['final_risk','age_risk','risk_result'],
                'edward'=>['final_risk','risk_result'],
                'patau'=>['final_risk','risk_result'],
                'ntsyndrome'=>['risk_result']
            ],
            'SQ'=>[
                'down'=>['final_risk','age_risk','risk_result'],
                'edward'=>['final_risk','risk_result'],
                'patau'=>['final_risk','risk_result'],
                'ntsyndrome'=>['risk_result']
            ],
            'FTS_PE'=>[
                'combined_screening'=>[
                    'down'=>['final_risk','biochemical_risk','age_risk','risk_result'],
                    'edward'=>['final_risk','risk_result'],
                    'patau'=>['final_risk','risk_result'],
                    'pe32'=>['final_risk','risk_result'],
                    'pe34'=>['final_risk','risk_result'],
                    'pe37'=>['final_risk','risk_result']
                ]
            ],
        ],
    ];

    $double_marker_testgroups = ['DMDEL','DMIMU'];

    $suffix = "";
    $package = "";
    if(isset($risk_config[$software])){
        $config_result = $risk_config[$software];
      
        switch(trim($report_title)){
            case "First Trimester Combined Screening Report":
                $suffix = 'FTS';
                $package = "combined_screening";
                break;
            case "First Trimester Double Marker Screening Report":
                $suffix = 'FTS';
                $package = "double_marker";
                break;
            case "Second Trimester Triple Marker Screening Report":
                $suffix = 'STS';
                break;
            case "Second Trimester Quadruple Marker Screening Report":
                $suffix = 'SQ';
                break;
            case "First Trimester Combined +  Preeclampsia Screening Report":
                $suffix = 'FTS_PE';
                $package = "combined_screening";
                break;
            default:
            $suffix = '';
        }

        if(in_array($testGroupCode,$double_marker_testgroups) && $suffix=='FTS' && $package == "combined_screening"){
            $suffix = 'FTS';
            $package = "double_marker";
        }
      
        // echo"<pre>";

        $details =[];
        foreach($riskResult as $risktype =>$risks){
            // print_r($risktype);
            foreach($risks  as $riskdetails){
                /**Check if suffix exists */
               if(isset($config_result[$suffix])){
                /**If suffix has FTS then package to be consider */
                if($suffix=='FTS_PE' || $suffix=='FTS'){
                    /**Check if package exists */
                    if(isset($config_result[$suffix][$package])){
                        $details = $config_result[$suffix][$package][$risktype];
                    }

                }
                else{
                    /**SQ and STS suffix*/
                    $details = $config_result[$suffix][$risktype];
                }
               
                foreach($details as $field_name){

                    $field_name_details = explode('_',$field_name);
                    $display_field = ucwords(strtolower(implode(' ',$field_name_details)));
                    // print_r($field_name);
                    // print_r($riskdetails[$field_name]);
                    if(isset($riskdetails[$field_name])){

                        if(empty($riskdetails[$field_name])){

                            if($is_pdf==1){
                                updateBlockedReasonLog($lab_id,  "$display_field Empty for $risktype Syndrome");
                            }

                            return "$display_field Empty for $risktype Syndrome";
                        }

                    }
                    else{
      
                        if($is_pdf==1){
                            updateBlockedReasonLog($lab_id,  "$display_field Empty for $risktype Syndrome");
                        }
                        return "$display_field Empty for $risktype Syndrome";
                    }

                }
               }
            //    print_r($details);
            //    print_r($riskdetails);
            }
           
        }

    }
    
    return 1;
}

function checkRiskMatrixTwin($lab_id,$riskResult,$software,$report_title,$is_pdf){
   
    $risk_config = [
        'LIFECYCLE'=>[
            'FTS'=>[
                'combined_screening'=>[
                    'down'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ],
                    'edward'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ],
                    'patau'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ]
                ]
            ],
            'STS'=>[
                'down'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'edward'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'patau'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'ntsyndrome'=>[
                    ['risk_result'],
                    ['risk_result']
                ]
            ],
            'SQ'=>[
                'down'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'edward'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'patau'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'ntsyndrome'=>[
                    ['risk_result'],
                    ['risk_result']
                ]
            ],
        ],
        'PRISCA'=>[
            'FTS'=>[
                'combined_screening'=>[
                    'down'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ],
                    'edward'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ],
                    'patau'=>[
                        ['final_risk','age_risk','risk_result'],
                        ['final_risk','age_risk','risk_result']
                    ]
                ]
            ],
            'STS'=>[
                'down'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'edward'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'patau'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'ntsyndrome'=>[
                    ['risk_result'],
                    ['risk_result']
                ]
            ],
            'SQ'=>[
                'down'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'edward'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'patau'=>[
                    ['final_risk','age_risk','risk_result'],
                    ['final_risk','age_risk','risk_result']
                ],
                'ntsyndrome'=>[
                    ['risk_result'],
                    ['risk_result']
                ]
            ],
        ],
    ];

    $suffix = "";
    $package = "";
    if(isset($risk_config[$software])){
       
        $config_result = $risk_config[$software];
      
        switch(trim($report_title)){
            case "First Trimester Combined Screening Report":
                $suffix = 'FTS';
                $package = "combined_screening";
                break;
            case "Second Trimester Triple Marker Screening Report":
                $suffix = 'STS';
                break;
            case "Second Trimester Quadruple Marker Screening Report":
                $suffix = 'SQ';
                break;
            default:
                $suffix = '';
        }

        $details =[];
        foreach($riskResult as $risktype =>$risks){
            foreach($risks  as $riskdetails){
                /**Check if suffix exists */
               if(isset($config_result[$suffix])){
                    /**If suffix has FTS then package to be consider */
                    if($suffix=='FTS'){
                        /**Check if package exists */
                        if(isset($config_result[$suffix][$package])){
                            $details = $config_result[$suffix][$package][$risktype];
                        }

                    }
                    else{
                        /**SQ and STS suffix*/
                        $details = $config_result[$suffix][$risktype];
                    }
                    foreach($details as $subdetails){
                        foreach($subdetails as $field_name){
                            $field_name_details = explode('_',$field_name);
                            $display_field = ucwords(strtolower(implode(' ',$field_name_details)));
                            if(isset($riskdetails[$field_name])){
                                if(empty($riskdetails[$field_name])){
    
                                    if($is_pdf==1){
                                        updateBlockedReasonLog($lab_id,  "$display_field Empty for $risktype Syndrome");
                                    }
    
                                    return "$display_field Empty for $risktype Syndrome";
                                }
    
                            }
                            else{
                                if($is_pdf==1){
                                    updateBlockedReasonLog($lab_id,  "$display_field Empty for $risktype Syndrome");
                                }
                                return "$display_field Empty for $risktype Syndrome";
                            }
                        }
                    }
               }
            }
        }
    }

    return 1;
}