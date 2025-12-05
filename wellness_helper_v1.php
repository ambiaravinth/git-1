<?php

use App\Models\StoreConfig;

$report_issues = [];

$report_issues_email = [];

$report_issues_address = [];
/**@
    Description : getPatientDetails will check for PatientDetails and TestGroupDetails from provided json
    Param : reportJsonData (mandatory)-whole json obj
    Output: patient details in array
@**/
function formatAddress(string $address): string
{
    // 1. Ensure there is a space after each comma
    $address = preg_replace('/,(\S)/', ', $1', $address);

    // 2. Insert a space between letters and numbers (both directions)
    // Letter immediately followed by digit.
    $address = preg_replace('/([a-zA-Z])(\d)/', '$1 $2', $address);
    // Digit immediately followed by letter.
    $address = preg_replace('/(\d)([a-zA-Z])/', '$1 $2', $address);

    // 3. Insert a space before an uppercase letter when preceded by a lowercase letter.
    $address = preg_replace('/([a-z])([A-Z])/', '$1 $2', $address);

    // 4. Clean up any extra spaces that might have been introduced.
    $address = preg_replace('/\s+/', ' ', $address);

    return trim($address);
}

function GetTestGroupDetails($reportJsonData)
{
    $tgdrsig_details = [];
    foreach ($reportJsonData->TestGroupDetails as $TestGroupDetails) {
        $tgdrsig_details[$TestGroupDetails->TEST_GROUP_CODE] = [
            'PROCESSING_BRANCH_ADDRESS' => $TestGroupDetails->PROCESSING_BRANCH_ADDRESS,
            'Doctor1' => ['Doctor1Name' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor1Name), 'Doctor1Degree' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor1Degree), 'Doctor1DigitalSignature' => $TestGroupDetails->Doctor1DigitalSignature],
            'Doctor2' => ['Doctor2Name' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor2Name), 'Doctor2Degree' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor2Degree), 'Doctor2DigitalSignature' => $TestGroupDetails->Doctor2DigitalSignature],
            'Doctor3' => ['Doctor3Name' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor3Name), 'Doctor3Degree' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor3Degree), 'Doctor3DigitalSignature' => $TestGroupDetails->Doctor3DigitalSignature],
            'Doctor4' => ['Doctor4Name' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor4Name), 'Doctor4Degree' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor4Degree), 'Doctor4DigitalSignature' => $TestGroupDetails->Doctor4DigitalSignature],
            'Doctor5' => ['Doctor5Name' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor5Name), 'Doctor5Degree' => str_replace(["�", "ï¿½"],'',$TestGroupDetails->Doctor5Degree), 'Doctor5DigitalSignature' => $TestGroupDetails->Doctor5DigitalSignature],
        ];
    }
    return $tgdrsig_details;
}

function GetTestGroupAddress($reportJsonData)
{
    global $report_issues_address;
    $report_issues_address = GetTestGroupDetails($reportJsonData);
}


function FindTestgroupAddress($testgroupcode = '')
{
    global $report_issues_address;
    if ($testgroupcode != '' && isset($report_issues_address[$testgroupcode]['PROCESSING_BRANCH_ADDRESS']) && $report_issues_address[$testgroupcode]['PROCESSING_BRANCH_ADDRESS'] != '') {
        return " -- " . $report_issues_address[$testgroupcode]['PROCESSING_BRANCH_ADDRESS'];
    }
    return '';
}
function FindCobrandLogo($hospitalcode)
{
    $all_logo = [
        //'001' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'1 - NRL- Chennai',
        // '002' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'2 - Gurgaon',
        // '004' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'4 - Bangalore',
        // '005' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'5 - T Nagar - Chennai',
        //'082' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'Borivali - HS Path',
        '087' => base_url('images/wellness/cobrand-logo/Prasad.png'), //'Prasad hospital',
        //'089' => base_url('images/wellness/cobrand-logo/Healthsolutions.png'),//'Thane - HS Path',
        //'091' => base_url('images/wellness/cobrand-logo/Mmb.png'),//'Lucknow',
        //   '092' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'Amritsar - HS Path',
        //  '093' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'Gorakhpur - HS Path',
        '145' => base_url('images/wellness/cobrand-logo/Sachdeva.png'), //'Sachdeva Diagnostics',
        '175' => base_url('images/wellness/cobrand-logo/Zenith.png'),
        //'194' => base_url('images/wellness/cobrand-logo/Thakral.png'), //'Thakral Hospital & Fertility Centre',
        // '226' => base_url('images/wellness/cobrand-logo/Lifewell.png'), //'TouchLabs',
        // '250' => base_url('images/wellness/cobrand-logo/Chawla.png'),
        // '257' => base_url('images/wellness/cobrand-logo/Drrajeev.png'),
        //  '258' => base_url('images/wellness/cobrand-logo/Chawla.png'),
        '275' => base_url('images/wellness/cobrand-logo/Prasad.png'), //'Prasad Hospital - Pragati Nagar',
        // '278' => base_url('images/wellness/cobrand-logo/Trimurti.png'), //'Trimurti Diagnostic Centre',
        //'307' => base_url('images/wellness/cobrand-logo/Pathocare.png'), //'PathOCare Ekbalpur',
        '313' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        //'316' => 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png',//'LifeWell Diagnostic Pvt Ltd',
        '319' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '320' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '321' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '324' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '325' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '326' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '327' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '359' => base_url('images/wellness/cobrand-logo/Kcj.png'),
        //'401' => base_url('images/wellness/cobrand-logo/Divination.png'),
        '494' => base_url('images/wellness/cobrand-logo/Rcell.png'),
        '495' => base_url('images/wellness/cobrand-logo/Rcell.png'),
        //'503' => base_url('images/wellness/cobrand-logo/Ipsc.png'),
        '692' => base_url('images/wellness/cobrand-logo/Newsaral.png'),
        '691' => base_url('images/wellness/cobrand-logo/Star.png'), //'STAR HOSPITAL GORAKHPUR',
        //'703' => base_url('images/wellness/cobrand-logo/Rashmi.png'),  //'RASHMI ADVANCED DIAGNOSTIC CENTRE',
    ];

    if (!empty($hospitalcode) && isset($all_logo[$hospitalcode]) && ($all_logo[$hospitalcode] != '')) {
        $noncombained = ['001','002','004','005','082','092','093','226','316'];
        if(in_array($hospitalcode, $noncombained)){
            return ['combained'=> false,'logo'=> $all_logo[$hospitalcode] ?? ''];
        }else{
            return ['combained'=> true,'logo'=> $all_logo[$hospitalcode] ?? ''];
        }
    } else{
       return ['combained'=> false,'logo'=> $all_logo['001'] ?? 'https://cdn.shop.lifecell.in/reports/wellness/images/lc-logo.png'];
    }
}
function getPatientDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    GetTestGroupAddress($reportJsonData);

    $gender = '';
    //Getting salutation from JSON
    $salutation = $reportJsonData->PatientDetails[0]->TITLE ?? '';
    if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
        $gender = 'Female';
    } elseif (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
        $gender = 'Male';
    }
    $reportingDate =  isset($reportJsonData->TestGroupDetails[0]->APPROVED_ON) ?
        dateformat($reportJsonData->TestGroupDetails[0]->APPROVED_ON, "d-m-Y H:i:s") : "";

    $receiptDate = isset($reportJsonData->PatientDetails[0]->RECEIVED_DATE) ?
        dateformat($reportJsonData->PatientDetails[0]->RECEIVED_DATE, "d-m-Y") : "";
    $rawAddress = $reportJsonData->TestGroupDetails[0]->PROCESSING_BRANCH_ADDRESS ?? '';
    $formattedAddress = formatAddress($rawAddress);
    $reportversion = isset($reportJsonData->PatientDetails[0]->ReportVersionNo) && $reportJsonData->PatientDetails[0]->ReportVersionNo !== ''
        ? (int)$reportJsonData->PatientDetails[0]->ReportVersionNo
        : '';

    // Updating the is_failed flag to 1 when $reportversion come as empty string or null
    if (empty($reportversion) && $reportversion !== '0' && $reportversion !== 0) {
        $report_issues[] = "ReportVersionNo mapping field is empty or not found.";
        $report_issues_email[] = "ReportVersionNo mapping field is empty or not found." . FindTestgroupAddress('');
    }

    //setting the $reportversion=1 if $reportversion == 0 
    if ($reportversion == 0) {
        $reportversion = 1;
    }

    // Version text logic
    $versionText = ($reportversion > 1) ? "Revised report" : "Initial report";
    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found.";
        $report_issues_email[] = "Package Code not found." . FindTestgroupAddress('');
    }

    return [
        'patient_name' => $reportJsonData->PatientDetails[0]->PATIENT_NAME ?? null,
        'patient_age' => $reportJsonData->PatientDetails[0]->age_yy ?? null,
        'patient_gender' => $gender,
        'birth_date' => $reportJsonData->PatientDetails[0]->DELIVERY_DATE != '' ? date("d-m-Y", strtotime($reportJsonData->PatientDetails[0]->DELIVERY_DATE)) : '',
        'city' => $reportJsonData->PatientDetails[0]->City ?? null,
        'lab_id' => $reportJsonData->PatientDetails[0]->LAB_ID ?? null,
        'sample_quality' => $reportJsonData->PatientDetails[0]->from_lims ?? null,
        'crm' => $reportJsonData->PatientDetails[0]->PATIENT_ID ?? null,
        // $collectionDate = isset($jsonReportData->PatientDetails[0]->SAMPLE_DATE) ?
        // dateformat($jsonReportData->PatientDetails[0]->SAMPLE_DATE, "d-m-Y") : "";
        'collection_date' => dateformat($reportJsonData->PatientDetails[0]->SAMPLE_DATE,  "d-m-Y H:i:s") ?? '',
        'receipt_date' => dateformat($reportJsonData->PatientDetails[0]->RECEIVED_DATE, "d-m-Y H:i:s") ?? '',
        'reporting_date' => dateformat($reportJsonData->TestGroupDetails[0]->APPROVED_ON, "d-m-Y H:i:s") ?? '',
        'hospital_name' => $reportJsonData->PatientDetails[0]->HOSPITAL_NAME ?? null,
        'hospital_code' => $reportJsonData->PatientDetails[0]->BRANCH_CODE ?? null,
        'hospital_address' => $reportJsonData->PatientDetails[0]->HOSPITAL_ADDRESS ?? $reportJsonData->PatientDetails[0]->HOSPITAL_NAME,
        'hospital_logo' => FindCobrandLogo($reportJsonData->PatientDetails[0]->BRANCH_CODE ?? null),
        'version_no' => $reportJsonData->TestGroupDetails[0]->VERSION_NO ?? "",
        'doctorName' => $reportJsonData->PatientDetails[0]->REFERRED_BY ?? null,
        'location' => $reportJsonData->PatientDetails[0]->CENTER_CODE ?? null,
        'refered_by' => $reportJsonData->PatientDetails[0]->REFERRED_BY ?? '',
        'client' => $reportJsonData->PatientDetails[0]->from_lims ?? '',
        'gender' => $reportJsonData->PatientDetails[0]->GENDER ?? '',
        'salutation' => $salutation,
        'processing_branch_address' => $formattedAddress,
        'is_cap_accredited' => $reportJsonData->TestGroupDetails[0]->Is_CAP_ACCREDITED,
        'is_nabl_accredited' => $reportJsonData->TestGroupDetails[0]->Is_NABL_ACCREDITED,
        'nabl_code' => $reportJsonData->PatientDetails[0]->NABL_CODE ?? '',
        //'nabl_code' => null,
        'sample_type' => $reportJsonData->PatientDetails[0]->SAMPLE_ID,
        'date_checking' => $reportingDate,
        'receiptDate' => $receiptDate,
        //'PackageCode' =>  $reportJsonData->TestGroupDetails[0]->PackageCode ?? '',
        'PackageCode' => $PackageCode,
        'reportversion' => $reportversion,
        'versionText' => $versionText,
    ];
}


/**
 * Description : getPancreasDetails() function to get test result details for the pancreas section.
 * 
 * This function retrieves pancreas-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to pancreas diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the pancreas section.
 */


// get Pancreas Details
function getPancreasDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        // echo "Package Code not found";
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
        // exit;
    }
    $pancreas_details = [];

    // HbAlc sub test
    $hbAlc_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'H0005' && explode('|', $resultData->TEST_CODE)[0] == 'HBA1CHPLC') {
            $hbAlc_found = true;
            $pancreas_details['hbAlc_result_value'] = $resultData->RESULT_VALUE;
            if (($pancreas_details['hbAlc_result_value'] ?? null) === '' || ($pancreas_details['hbAlc_result_value'] ?? null) === null) {
                $report_issues[] = " HbAlc TestResultDetails are empty";
                $report_issues_email[] = " HbAlc TestResultDetails are empty" . FindTestgroupAddress('H0005');
            }
            $pancreas_details['hbAlc_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $pancreas_details['hbAlc_uom'] = str_replace(["�", "ï¿½"], "μ", $pancreas_details['hbAlc_uom']);

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $pancreas_details['hbAlc_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code H0005 and test code HBA1CHPLC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code H0005 and test code HBA1CHPLC" . FindTestgroupAddress('H0005');
            }

            if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {
                $report_issues[] = " HbAlc BR Interval are empty";
                $report_issues_email[] = " HbAlc BR Interval are empty" . FindTestgroupAddress('H0005');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $pancreas_details['hbA1c_test_remraks'] = "HbA1c - " . $resultData->TEST_REMARKS;
            } else {
                $pancreas_details['hbA1c_test_remraks'] = '';
            }

            $pancreas_details['hbAlc_BRInterval_result_value'] = trim(($resultData->BRInterval));
            $pancreas_details['hbA1c_sample_method'] = $resultData->NEW_METHOD;

            $intervals = explode("\n", trim($pancreas_details['hbAlc_BRInterval_result_value']));

            $range_map = [];
            // Parse label-value pairs function call
            validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);

            $count = count($range_map);
            if ($count == 3) {
                $thumb_colors = ['green', 'orange', 'red'];
            } elseif ($count == 5) {
                $thumb_colors = ['green', 'orange', 'red', 'red', 'red'];
            } else {
                $thumb_colors = [];
            }
            $thumb_colors_count = count($thumb_colors);
            $range_map_count = count($range_map);
            if ($thumb_colors_count !== $range_map_count) {
                $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('H0005');
            }
            $pancreas_details['hbAlc_reference_ranges_value'] = $range_map;
            // Dynamic color and image map based on position
            $pancreas_details['hba1c_result_value_in_words'] = '';
            $pancreas_details['hba1c_color_code'] = 'gray';
            $pancreas_details['hbAlc_thumb_up_icon'] = '';

            $index = 0;
            foreach ($range_map as $label => $range) {
                if (hba1cmatchesRange($pancreas_details['hbAlc_result_value'], $range)) {
                    $pancreas_details['hba1c_result_value_in_words'] = ucwords($label);
                    $pancreas_details['hba1c_color_code'] = $thumb_colors[$index] ?? 'gray';
                    if ($pancreas_details['hba1c_color_code'] === 'green') {
                        $pancreas_details['hbAlc_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                        $pancreas_details['hba1c_impact_on_health'] = '';
                    } elseif ($pancreas_details['hba1c_color_code'] !== 'gray') {
                        $pancreas_details['hbAlc_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$pancreas_details['hba1c_color_code']}-thumb.png";
                        $pancreas_details['hba1c_impact_on_health'] = "It provides a reliable measure of chronic hyperglycemia but also correlates well with the risk of long-term diabetes complications. Elevated HbA1c has als been regarded as an independent risk factor for coronary heart disease and stroke in subjects with or without diabetes";
                    } else {
                        $pancreas_details['hbAlc_thumb_up_icon'] = '';
                    }
                    break;
                }
                $index++;
            }
            if ($pancreas_details['hba1c_result_value_in_words'] == '' ||  $pancreas_details['hba1c_color_code'] == 'gray') {
                $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('H0005');
            }
        }
    }
    if (!$hbAlc_found) {
        $report_issues[] = " Test Group 'H0005' or Test Code 'HBA1CHPLC' not found";
        $report_issues_email[] = " Test Group 'H0005' or Test Code 'HBA1CHPLC' not found" . FindTestgroupAddress('H0005');
    }

    // Estimated Average glucose sub test
    $estimated_average_glucose_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'H0005' &&  explode('|', $resultData->TEST_CODE)[0] == 'EAG') {
            $estimated_average_glucose_found = true;
            $estimated_average_glucose_found = true;
            $pancreas_details['estimated_average_glucose'] = $resultData->RESULT_VALUE;
            $pancreas_details['estimated_average_uom'] = $resultData->UOM ? utf8_decode($resultData->UOM) : '';
            // Logic to check the empty result value and update remarks with a failed reason for Estimated Average glucose.
            if (empty($pancreas_details['estimated_average_glucose']) && $pancreas_details['estimated_average_glucose'] != 0) {
                $report_issues[] = " Glucose Fasting TestResultDetails are empty";
                $report_issues_email[] = " Glucose Fasting TestResultDetails are empty" . FindTestgroupAddress('H0005');
            }
        }
    }
    if (!$estimated_average_glucose_found) {
        $report_issues[] = " Test Group 'H0005' or Test Code 'EAG' not found";
        $report_issues_email[] = " Test Group 'H0005' or Test Code 'EAG' not found" . FindTestgroupAddress('H0005');
    }


    // Glucose Fasting sub test
    $pancreas_details['glucose_fasting_status_found'] = 0; // default
    $foundS0013a = false;

    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if (explode('|', $resultData->TEST_GROUP_CODE)[0] == 'S0013a') {
            $foundS0013a = true;
            break;
        }
    }

    if (!$foundS0013a) {
        $pancreas_details['glucose_fasting_status_found'] = 1;
    }

    if (!$pancreas_details['glucose_fasting_status_found']) {
        $glucose_fasting_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'S0013a' &&  explode('|', $resultData->TEST_CODE)[0] == 'FPG') {
                $glucose_fasting_found = true;
                $pancreas_details['glucose_fasting_result_value'] = $resultData->RESULT_VALUE;

                if (($pancreas_details['glucose_fasting_result_value'] ?? null) === '' || ($pancreas_details['glucose_fasting_result_value'] ?? null) === null) {
                    $report_issues[] = "Glucose Fasting TestResultDetails are empty";
                    $report_issues_email[] = "Glucose Fasting TestResultDetails are empty" . FindTestgroupAddress('S0013a');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $pancreas_details['glucose_fasting_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code S0013a and test code FPG";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code S0013a and test code FPG" . FindTestgroupAddress('S0013a');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $pancreas_details['glucose_fasting_test_remraks'] = "Glucose Fasting - " . $resultData->TEST_REMARKS;
                } else {
                    $pancreas_details['glucose_fasting_test_remraks'] = '';
                }
                $pancreas_details['glucose_fasting_sample_method'] = $resultData->NEW_METHOD;

                $pancreas_details['glucose_fasting_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $pancreas_details['glucose_fasting_uom'] = str_replace(["�", "ï¿½"], "μ", $pancreas_details['glucose_fasting_uom']);
                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = "Glucose Fasting BR Interval are empty";
                    $report_issues_email[] = "Glucose Fasting BR Interval are empty" . FindTestgroupAddress('S0013a');
                }
                $pancreas_details['glucose_fasting_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($pancreas_details['glucose_fasting_BRInterval_result_value']));

                $range_map = [];
                // Parse label-value pairs function call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);

                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'red'];
                $thumb_colors_count = count($thumb_colors);
                $range_map_count = count($range_map);
                if ($thumb_colors_count !== $range_map_count) {
                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('S0013a');
                }

                $pancreas_details['glucose_fasting_reference_ranges_value'] = $range_map;
                // Comparison without eval
                $pancreas_details['glucose_fasting_result_value_in_words'] = '';
                $pancreas_details['glucose_fasting_color_code'] = 'gray';
                $pancreas_details['glucose_fasting_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (glucosefastingmatchesRange($pancreas_details['glucose_fasting_result_value'], $range)) {
                        $pancreas_details['glucose_fasting_result_value_in_words'] = ucwords($label);
                        $pancreas_details['glucose_fasting_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($pancreas_details['glucose_fasting_color_code'] === 'green') {
                            $pancreas_details['glucose_fasting_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $pancreas_details['glucose_fasting_impact_on_health'] = '';
                            $pancreas_details['glucose_fasting_suggestion'] = '';
                        } elseif ($pancreas_details['hba1c_color_code'] !== 'gray') {
                            $pancreas_details['glucose_fasting_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$pancreas_details['glucose_fasting_color_code']}-thumb.png";
                            $pancreas_details['glucose_fasting_impact_on_health'] = "The Fasting Blood Glucose Test is done to:Detect diabetes mellitus,Screen for high blood sugar in presence of risk factors of Diabetes,Detect diabetes during pregnancy or gestational diabetes,Monitor treatment efficacy in patients undergoing treatment for diabetes";
                            $pancreas_details['glucose_fasting_suggestion'] = "Regular physical activity and lifestyle changes to support weight loss and overall health. Regular monitoring of sugar levels needed";
                        } else {
                            $pancreas_details['glucose_fasting_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($pancreas_details['glucose_fasting_result_value_in_words'] == '' ||  $pancreas_details['glucose_fasting_color_code'] == 'gray') {
                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('S0013a');
                }
            }
        }
        if (!$glucose_fasting_found) {
            $report_issues[] = " Test Group 'S0013a' or Test Code 'FPG' not found";
            $report_issues_email[] = " Test Group 'S0013a' or Test Code 'FPG' not found" . FindTestgroupAddress('S0013a');
        }
    }


    if ($PackageCode == 'AYN_031') {
        $lipase_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'L0005' &&  explode('|', $resultData->TEST_CODE)[0] == 'LIPASES') {
                $lipase_result_found = true;
                $pancreas_details['lipase_result_value'] = $resultData->RESULT_VALUE;
                if (($pancreas_details['lipase_result_value'] ?? null) === '' || ($pancreas_details['lipase_result_value'] ?? null) === null) {
                    $report_issues[] = " Lipase Serum TestResultDetails are empty";
                    $report_issues_email[] = " Lipase Serum TestResultDetails are empty" . FindTestgroupAddress('L0005');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " LIPASES reference ranges are empty";
                    $report_issues_email[] = " LIPASES reference ranges are empty" . FindTestgroupAddress('L0005');
                }
                if (!isset($resultData->BRInterval) ||  $resultData->BRInterval === "") {
                    $report_issues[] = " LIPASES BR Interval are empty";
                    $report_issues_email[] = " LIPASES BR Interval are empty" . FindTestgroupAddress('L0005');
                }
                $pancreas_details['lipase_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $pancreas_details['lipase_uom'] = str_replace(["�", "ï¿½"], "μ", $pancreas_details['lipase_uom']);
                $pancreas_details['lipase_low_result_value'] = $resultData->LOW_VALUE;
                $pancreas_details['lipase_high_result_value'] = $resultData->HIGH_VALUE;
                $pancreas_details['lipase_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $pancreas_details['lipase_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code L0005 and test code LIPASES";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code L0005 and test code LIPASES" . FindTestgroupAddress('L0005');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $pancreas_details['lipase_test_remraks'] = "Lipase - " . $resultData->TEST_REMARKS;
                } else {
                    $pancreas_details['lipase_test_remraks'] = '';
                }
                $pancreas_details['lipase_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $pancreas_details['lipase_low_result_value']) {
                    $pancreas_details['lipase_result_value_in_words'] = 'Low';
                    $pancreas_details['lipase_color_code'] = "red";
                } else if ($resultData->RESULT_VALUE >= $pancreas_details['lipase_low_result_value'] && $resultData->RESULT_VALUE <= $pancreas_details['lipase_high_result_value']) {
                    $pancreas_details['lipase_result_value_in_words'] = 'Normal';
                    $pancreas_details['lipase_color_code'] = "green";
                } else if ($resultData->RESULT_VALUE > $pancreas_details['lipase_high_result_value']) {
                    $pancreas_details['lipase_result_value_in_words'] = 'High';
                    $pancreas_details['lipase_color_code'] = "red";
                }

                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >=  $pancreas_details['lipase_high_result_value']) {
                    $pancreas_details['lipase_impact_on_health'] = "An elevated amount of lipase in the blood can signify that the pancreas is swollen and inflamed, a condition called pancreatitis. Lipase may also be elevated due to other issues in the pancreas, the use of certain medications, or health conditions such as kidney disease, cancer, and problems with the gallbladder or esophagus";
                } else {
                    $pancreas_details['lipase_impact_on_health'] = '';
                }
            }
        }
        if (!$lipase_result_found) {
            $report_issues[] = " Test Group 'L0005' or Test Code 'LIPASES' not found";
            $report_issues_email[] = " Test Group 'L0005' or Test Code 'LIPASES' not found" . FindTestgroupAddress('L0005');
        }
    }
    return $pancreas_details;
}

function glucosefastingcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function glucosefastingmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return glucosefastingcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}

// Comparison without eval
function comparehba1c($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        case '=>':
            return $value >= $threshold;
        case '=<':
            return $value <= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function hba1cmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|=<|=>|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return comparehba1c($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}

/**
 * Description: The getPancreasTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for pancreas-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getPancreasTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{
    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $PancreasNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_025' || $PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || ($PackageCode == 'AYN_030') || ($PackageCode == 'AYN_029')) {
            if ($resultData->TEST_GROUP_CODE == 'H0005') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0005";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0005" . FindTestgroupAddress('H0005');
                }
                $PancreasNablAccredited['h0005_pancreas_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $PancreasNablAccredited['h0005_pancreas_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE == 'S0013a') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code S0013a";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code S0013a" . FindTestgroupAddress('S0013a');
                }
                $PancreasNablAccredited['s0013a_pancreas_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $PancreasNablAccredited['S0013a_pancreas_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif (($PackageCode == 'AYN_031')) {
            if ($resultData->TEST_GROUP_CODE == 'H0005') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0005";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0005" . FindTestgroupAddress('H0005');
                }
                $PancreasNablAccredited['h0005_pancreas_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $PancreasNablAccredited['h0005_pancreas_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE == 'S0013a') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code S0013a";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code S0013a" . FindTestgroupAddress('S0013a');
                }
                $PancreasNablAccredited['s0013a_pancreas_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $PancreasNablAccredited['S0013a_pancreas_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE == 'L0005') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code L0005";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code L0005" . FindTestgroupAddress('L0005');
                }
                $PancreasNablAccredited['L0005_pancreas_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $PancreasNablAccredited['L0005_pancreas_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        }
    }
    //print_r($PancreasNablAccredited);
    //exit;
    return $PancreasNablAccredited;
}


/**
 * Description : getHeartDetails() function to get test result details for the heart section.
 * 
 * This function retrieves heart-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to heart diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the heart section.
 */

// get Heart Details

function getHeartDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $heart_details = [];
    // Total Cholesterol sub test
    $total_cholesterol_found = 0;

    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'TCH') {
            $heart_details['total_cholesterol_result_value'] = $resultData->RESULT_VALUE;
            $total_cholesterol_found = 1;
            if (($heart_details['total_cholesterol_result_value'] ?? null) === '' || ($heart_details['total_cholesterol_result_value'] ?? null) === null) {

                $report_issues[] = "Total Cholesterol TestResultDetails are empty.";
                $report_issues_email[] = "Total Cholesterol TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
            }
            $heart_details['total_cholesterol_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $heart_details['total_cholesterol_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['total_cholesterol_uom']);

            if (!isset($resultData->BRInterval)) {

                $report_issues[] = " Total Cholesterol BR Interval are empty.";
                $report_issues_email[] = " Total Cholesterol BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
            }
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $heart_details['total_cholesterol_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code TCH.";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code TCH." . FindTestgroupAddress('Lipid Profile.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $heart_details['total_cholesterol_test_remraks'] = "Total Cholesterol - " . $resultData->TEST_REMARKS;
            } else {
                $heart_details['total_cholesterol_test_remraks'] = '';
            }
            $heart_details['total_cholesterol_sample_method'] = $resultData->NEW_METHOD;
            $heart_details['total_cholesterol_BRInterval_result_value'] = trim(($resultData->BRInterval));
            $intervals = explode("\n", trim($heart_details['total_cholesterol_BRInterval_result_value']));
            $range_map = [];
            // Parse label-value pairs function call
            validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
            // Dynamic color and image map based on position
            $thumb_colors = ['green', 'orange', 'red'];
            $thumb_colors_count = count($thumb_colors);
            $range_map_count = count($range_map);
            if ($thumb_colors_count !== $range_map_count) {

                $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
            }
            $heart_details['total_cholesterol_reference_ranges_value'] = $range_map;
            $heart_details['total_cholesterol_result_value_in_words'] = '';
            $heart_details['total_cholesterol_color_code'] = 'gray';
            $heart_details['total_cholesterol_thumb_up_icon'] = '';

            $index = 0;
            foreach ($range_map as $label => $range) {
                if (totalcholesterolmatchesRange($heart_details['total_cholesterol_result_value'], $range)) {
                    $heart_details['total_cholesterol_result_value_in_words'] = ucwords($label);
                    $heart_details['total_cholesterol_color_code'] = $thumb_colors[$index] ?? 'gray';
                    if ($heart_details['total_cholesterol_color_code'] === 'green') {
                        $heart_details['total_cholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                        $heart_details['total_cholesterol_impact_on_health'] = '';
                        $heart_details['total_cholesterol_suggestion'] = '';
                    } elseif ($heart_details['total_cholesterol_color_code'] !== 'gray') {
                        $heart_details['total_cholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['total_cholesterol_color_code']}-thumb.png";
                        $heart_details['total_cholesterol_impact_on_health'] = "Serum cholesterol is elevated in hereditary hyperlipoproteinemias. Hypercholesterolemia is a risk factor for cardiovascular disease. Increased cholesterol levels are also seen in hypothyroidism and Nephrotic syndrome. Low levels of cholesterol can be seen in disorders that include hyperthyroidism, malabsorption, and deficiencies of apolipoproteins.";
                        $heart_details['total_cholesterol_suggestion'] = "(1) Eat heart-healthy foods-Reduce saturated fats, Eliminate trans fats, Eat foods rich in omega-3 fatty acids,Increase soluble fiber. (2) Exercise on most days of the week and increase your physical activity-Taking a brisk daily walk during your lunch hour,Riding your bike to work,Playing a favorite sport (3)Quit smoking (4)Lose weight (5)Avoid alcohol";
                    } else {
                        $heart_details['total_cholesterol_thumb_up_icon'] = '';
                    }
                    break;
                }
                $index++;
            }
            if ($heart_details['total_cholesterol_result_value_in_words'] == '' ||  $heart_details['total_cholesterol_color_code'] == 'gray') {

                $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
            }
        }


        // Triglycerides sub teste
        $triglycerides_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'TRIG') {
                $triglycerides_found = true;
                $heart_details['triglycerides_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['triglycerides_result_value'] ?? null) === '' || ($heart_details['triglycerides_result_value'] ?? null) === null) {
                    $report_issues[] = "Triglycerides TestResultDetails are empty.";
                    $report_issues_email[] = "Triglycerides TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['triglycerides_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['triglycerides_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['triglycerides_uom']);

                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = "Triglycerides BR Interval are empty.";
                    $report_issues_email[] = "Triglycerides BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['triglycerides_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                preg_match_all('/\d+\.?\d*/', $heart_details['triglycerides_BRInterval_result_value'], $matches);
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['triglycerides_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = "NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code TRIG.";
                    $report_issues_email[] = "NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code TRIG." . FindTestgroupAddress('Lipid Profile.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['triglycerides_test_remraks'] = "Triglycerides - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['triglycerides_test_remraks'] = '';
                }
                $heart_details['triglycerides_sample_method'] = $resultData->NEW_METHOD;
                $heart_details['triglycerides_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['triglycerides_BRInterval_result_value']));
                $range_map = [];
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $range_map_count = count($range_map);
                if ($range_map_count == 5) {
                    $thumb_colors = ['green', 'orange', 'orange', 'red', 'red'];
                } elseif ($range_map_count == 4) {
                    $thumb_colors = ['green', 'red', 'red', 'red'];
                } elseif ($range_map_count == 3) {
                    $thumb_colors = ['green', 'orange', 'red'];
                } else {
                    $thumb_colors = [];
                }
                $thumb_colors_count = count($thumb_colors);
                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['triglycerides_reference_ranges_value'] = $range_map;
                $heart_details['triglycerides_result_value_in_words'] = '';
                $heart_details['triglycerides_color_code'] = 'gray';
                $heart_details['triglycerides_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (triglyceridesmatchesRange($heart_details['triglycerides_result_value'], $range)) {
                        $heart_details['triglycerides_result_value_in_words'] = ucwords($label);
                        $heart_details['triglycerides_color_code'] = $thumb_colors[$index] ?? 'gray';


                        if ($heart_details['triglycerides_color_code'] === 'green') {
                            $heart_details['triglycerides_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['triglycerides_impact_on_health'] = '';
                            $heart_details['triglycerides_suggestion'] = '';
                        } elseif ($heart_details['triglycerides_color_code'] !== 'gray') {
                            $heart_details['triglycerides_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['triglycerides_color_code']}-thumb.png";
                            $heart_details['triglycerides_impact_on_health'] = "Increased plasma triglyceride levels are indicative of a metabolic abnormality and, along with elevated cholesterol, are considered a risk factor for atherosclerotic disease.Increased triglycerides may also be medication-induced (eg, prednisone).";
                            $heart_details['triglycerides_suggestion'] = "(1) Eat heart-healthy foods-Reduce saturated fats, Eliminate trans fats, Eat foods rich in omega-3 fatty acids,Increase soluble fiber. (2)Exercise on most days of the week and increase your physical activity-Taking a brisk daily walk during your lunch hour,Riding your bike to work,Playing a favorite sport (3)Quit smoking (4)Lose weight (5)Avoid alcohol";
                        } else {
                            $heart_details['triglycerides_thumb_up_icon'] = '';
                        }

                        break;
                    }
                    $index++;
                }

                if ($heart_details['triglycerides_result_value_in_words'] == '' ||  $heart_details['triglycerides_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }

        if (!$triglycerides_found) {

            $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'TRIG' not found.";
            $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'TRIG' not found." . FindTestgroupAddress('Lipid Profile.');
        }
        // HDL Cholesterol sub tes
        $hdl_cholesterol_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'HDLC') {
                $hdl_cholesterol_found = true;
                $heart_details['hdl_cholesterol_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['hdl_cholesterol_result_value'] ?? null) === '' || ($heart_details['hdl_cholesterol_result_value'] ?? null) === null) {

                    $report_issues[] = "HDL Cholesterol TestResultDetails are empty.";
                    $report_issues_email[] = "HDL Cholesterol TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['hdl_cholesterol_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['hdl_cholesterol_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['hdl_cholesterol_uom']);

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['hdl_cholesterol_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code HDLC.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code HDLC." . FindTestgroupAddress('Lipid Profile.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['hdl_cholesterol_test_remraks'] = "HDL Cholesterol - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['hdl_cholesterol_test_remraks'] = '';
                }
                $heart_details['hdl_cholesterol_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {

                    $report_issues[] = " HDL Cholesterol BR Interval are empty.";
                    $report_issues_email[] = " HDL Cholesterol BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['hdl_cholesterol_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['hdl_cholesterol_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs function call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $range_map_count = count($range_map);
                if ($range_map_count == 3) {
                    $thumb_colors = ['red', 'green', 'red'];
                } elseif ($range_map_count == 2) {
                    $thumb_colors = ['red', 'red'];
                } else {
                    $thumb_colors = [];
                }
                $thumb_colors_count = count($thumb_colors);
                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['hdl_cholesterol_reference_ranges_value'] = $range_map;
                $heart_details['hdl_cholesterol_result_value_in_words'] = '';
                $heart_details['hdl_cholesterol_color_code'] = 'gray';
                $heart_details['hdl_cholesterol_thumb_up_icon'] = '';
                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (hdlcholesterolmatchesRange($heart_details['hdl_cholesterol_result_value'], $range)) {
                        $heart_details['hdl_cholesterol_result_value_in_words'] = ucwords($label);
                        $heart_details['hdl_cholesterol_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['hdl_cholesterol_color_code'] === 'green') {
                            $heart_details['hdl_cholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['hdl_cholesterol_impact_on_health'] = '';
                            $heart_details['hdl_cholesterol_suggestion'] = '';
                        } elseif ($heart_details['hdl_cholesterol_color_code'] !== 'gray') {
                            $heart_details['hdl_cholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['hdl_cholesterol_color_code']}-thumb.png";
                            $heart_details['hdl_cholesterol_impact_on_health'] = "HDL cholesterol is an important tool used to assess an individual's risk of developing CHD. It has a strong negative relationship between its concentration and the incidence of CHD. Values greater than or equal to 80 to 100 mg/dL may indicate metabolic response to certain medications such as hormone replacement therapy and chronic liver disease.";
                            $heart_details['hdl_cholesterol_suggestion'] = "(1) Eat heart-healthy foods-Reduce saturated fats, Eliminate trans fats, Eat foods rich in omega-3 fatty acids,Increase soluble fiber. (2)Exercise on most days of the week and increase your physical activity-Taking a brisk daily walk during your lunch hour,Riding your bike to work,Playing a favorite sport (3)Quit smoking (4)Lose weight (5)Avoid alcohol";
                        } else {
                            $heart_details['hdl_cholesterol_thumb_up_icon'] = '';
                        }

                        break;
                    }
                    $index++;
                }
                if ($heart_details['hdl_cholesterol_result_value_in_words'] == '' ||  $heart_details['hdl_cholesterol_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }
        if (!$hdl_cholesterol_found) {

            $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'HDLC' not found.";
            $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'HDLC' not found." . FindTestgroupAddress('Lipid Profile.');
        }

        // Low Density Lipoprotein Cholesterol (LDL) sub teste
        $lipoproteincholesterol_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'LDLC') {
                $lipoproteincholesterol_found = true;
                $heart_details['lipoproteincholesterol_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['lipoproteincholesterol_result_value'] ?? null) === '' || ($heart_details['lipoproteincholesterol_result_value'] ?? null) === null) {

                    $report_issues[] = "Low Density Lipoprotein Cholesterol (LDL) TestResultDetails are empty.";
                    $report_issues_email[] = "Low Density Lipoprotein Cholesterol (LDL) TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['lipoproteincholesterol_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['lipoproteincholesterol_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['lipoproteincholesterol_uom']);

                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = " Low Density Lipoprotein Cholesterol (LDL) BR Interval are empty.";
                    $report_issues_email[] = " Low Density Lipoprotein Cholesterol (LDL) BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['lipoproteincholesterol_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code LDLC.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code LDLC." . FindTestgroupAddress('Lipid Profile.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['lipoproteincholesterol_test_remraks'] = "Low Density Lipoprotein - Cholesterol (LDL) - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['lipoproteincholesterol_test_remraks'] = '';
                }
                $heart_details['lipoproteincholesterol_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {

                    $report_issues[] = " Low Density Lipoprotein Cholesterol BR Interval are empty.";
                    $report_issues_email[] = " Low Density Lipoprotein Cholesterol BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['lipoproteincholesterol_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['lipoproteincholesterol_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs function call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'orange', 'red', 'red'];
                $range_map_count = count($range_map);
                $thumb_colors_count = count($thumb_colors);
                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }

                $heart_details['lipoproteincholesterol_reference_ranges_value'] = $range_map;
                $heart_details['lipoproteincholesterol_result_value_in_words'] = '';
                $heart_details['lipoproteincholesterol_color_code'] = 'gray';
                $heart_details['lipoproteincholesterol_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (lipoproteincholesterolmatchesRange($heart_details['lipoproteincholesterol_result_value'], $range)) {
                        $heart_details['lipoproteincholesterol_result_value_in_words'] = ucwords($label);
                        $heart_details['lipoproteincholesterol_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['lipoproteincholesterol_color_code'] === 'green') {
                            $heart_details['lipoproteincholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['lipoproteincholesterol_impact_on_health'] = '';
                            $heart_details['lipoproteincholesterol_suggestion'] = '';
                        } elseif ($heart_details['lipoproteincholesterol_color_code'] !== 'gray') {
                            $heart_details['lipoproteincholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['lipoproteincholesterol_color_code']}-thumb.png";
                            $heart_details['lipoproteincholesterol_impact_on_health'] = "Increased LDL is associated with an increased risk of cardiovascular disease. It is commonly associated with diabetes, hypertension, hypertriglyceridemia, and atherosclerosis. LDL is clinically significant as it is crucial to monitor levels of LDL in patients with hypertension and diabetes.";
                            $heart_details['lipoproteincholesterol_suggestion'] = "(1) Eat heart-healthy foods-Reduce saturated fats, Eliminate trans fats, Eat foods rich in omega-3 fatty acids,Increase soluble fiber. (2)Exercise on most days of the week and increase your physical activity-Taking a brisk daily walk during your lunch hour,Riding your bike to work,Playing a favorite sport (3)Quit smoking (4)Lose weight (5)Avoid alcohol";
                        } else {
                            $heart_details['lipoproteincholesterol_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($heart_details['lipoproteincholesterol_result_value_in_words'] == '' ||  $heart_details['lipoproteincholesterol_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }
        if (!$lipoproteincholesterol_found) {

            $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'LDLC' not found.";
            $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'LDLC' not found." . FindTestgroupAddress('Lipid Profile.');
        }


        //Very Low Density Lipoprotein - Cholesterol sub teste
        $heart_details['lipoprotein_ldl_status_found'] = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' &&  explode('|', $resultData->TEST_CODE)[0] == 'VLDLC') {
                $heart_details['lipoprotein_ldl_status_found'] = true;
                break;
            }
        }
        if($heart_details['lipoprotein_ldl_status_found']){
            $lipoprotein_ldl_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' &&  explode('|', $resultData->TEST_CODE)[0] == 'VLDLC') {
                    $lipoprotein_ldl_found = true;
                    $heart_details['lipoprotein_ldl_result_value'] = $resultData->RESULT_VALUE;
                    if (($heart_details['lipoprotein_ldl_result_value'] ?? null) === '' || ($heart_details['lipoprotein_ldl_result_value'] ?? null) === null) {
                        $report_issues[] = "Very Low Density Lipoprotein TestResultDetails are empty.";
                        $report_issues_email[] = "Very Low Density Lipoprotein TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                    }
                    if (
                        !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                        !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                    ) {

                        $report_issues[] = " Very Low Density Lipoprotein - Cholesterolreference ranges are empty.";
                        $report_issues_email[] = " Very Low Density Lipoprotein - Cholesterolreference ranges are empty." . FindTestgroupAddress('Lipid Profile.');
                    }
                    if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                        $report_issues[] = " Very Low Density Lipoprotein - Cholesterol BR Interval are empty.";
                        $report_issues_email[] = " Very Low Density Lipoprotein - Cholesterol BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                    }
                    $heart_details['lipoprotein_ldl_low_result_value'] = $resultData->LOW_VALUE;
                    $heart_details['lipoprotein_ldl_high_result_value'] = $resultData->HIGH_VALUE;
                    $heart_details['lipoprotein_ldl_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                    $heart_details['lipoprotein_ldl_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['lipoprotein_ldl_uom']);

                    $heart_details['lipoprotein_ldl_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $heart_details['lipoprotein_ldl_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {

                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code VLDLC.";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code VLDLC." . FindTestgroupAddress('Lipid Profile.');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $heart_details['lipoprotein_ldl_test_remraks'] = "Very Low Density Lipoprotein - Cholesterol (VLDL) - " . $resultData->TEST_REMARKS;
                    } else {
                        $heart_details['lipoprotein_ldl_test_remraks'] = '';
                    }
                    $heart_details['lipoprotein_ldl_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < $heart_details['lipoprotein_ldl_low_result_value']) {
                        $heart_details['lipoprotein_ldl_result_value_in_words'] = 'Low';
                        $heart_details['lipoprotein_ldl_color_code'] = "red";
                    }
                    if ($resultData->RESULT_VALUE >= $heart_details['lipoprotein_ldl_low_result_value'] && $resultData->RESULT_VALUE <= $heart_details['lipoprotein_ldl_high_result_value']) {
                        $heart_details['lipoprotein_ldl_result_value_in_words'] = 'Normal';
                        $heart_details['lipoprotein_ldl_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > $heart_details['lipoprotein_ldl_high_result_value']) {
                        $heart_details['lipoprotein_ldl_result_value_in_words'] = 'High';
                        $heart_details['lipoprotein_ldl_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE < $heart_details['lipoprotein_ldl_low_result_value'] || $resultData->RESULT_VALUE > $heart_details['lipoprotein_ldl_high_result_value']) {
                        $heart_details['lipoprotein_ldl_impact_on_health'] = "VLDL is one of the three main types of lipoproteins. VLDL contains the highest amount of triglycerides. VLDL is a type of 'bad cholesterol' because it helps cholesterol build up on the walls of arteries.A high VLDL cholesterol level may be associated with a higher risk for heart disease and stroke.";
                    } else {
                        $heart_details['lipoprotein_ldl_impact_on_health'] = '';
                    }
                }
            }
            if (!$lipoprotein_ldl_found) {

                $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'VLDLC' not found.";
                $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'VLDLC' not found." . FindTestgroupAddress('Lipid Profile.');
            }
        }

        //Total Cholesterol / HDL Ratio sub teste
        $total_cholesterolhdlratio_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'CHOL') {
                $total_cholesterolhdlratio_found = true;
                $heart_details['total_cholesterolhdlratio_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['total_cholesterolhdlratio_result_value'] ?? null) === '' || ($heart_details['total_cholesterolhdlratio_result_value'] ?? null) === null) {

                    $report_issues[] = "Total Cholesterol / HDL Ratio are empty.";
                    $report_issues_email[] = "Total Cholesterol / HDL Ratio are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['total_cholesterolhdlratio_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['total_cholesterolhdlratio_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['total_cholesterolhdlratio_uom']);

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['total_cholesterolhdlratio_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code CHOL.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code CHOL." . FindTestgroupAddress('Lipid Profile.');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['total_cholesterolhdlratio_test_remraks'] = "Total Cholesterol / HDL Ratio - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['total_cholesterolhdlratio_test_remraks'] = '';
                }

                $heart_details['total_cholesterolhdlratio_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = " Total Cholesterol / HDL Ratio BR Interval are empty.";
                    $report_issues_email[] = " Total Cholesterol / HDL Ratio BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['total_cholesterolhdlratio_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['total_cholesterolhdlratio_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs funtion call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'red'];
                $range_map_count = count($range_map);
                $thumb_colors_count = count($thumb_colors);
                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['total_cholesterolhdlratio_reference_ranges_value'] = $range_map;
                $heart_details['total_cholesterolhdlratio_result_value_in_words'] = '';
                $heart_details['total_cholesterolhdlratio_color_code'] = 'gray';
                $heart_details['total_cholesterolhdlratio_thumb_up_icon'] = '';
                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (totalcholesterolhdlratiomatchesRange($heart_details['total_cholesterolhdlratio_result_value'], $range)) {
                        $heart_details['total_cholesterolhdlratio_result_value_in_words'] = ucwords($label);
                        $heart_details['total_cholesterolhdlratio_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['total_cholesterolhdlratio_color_code'] === 'green') {
                            $heart_details['total_cholesterolhdlratio_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['total_cholesterolhdlratio_impact_on_health'] = '';
                            $heart_details['total_cholesterolhdlratio_suggestion'] = '';
                        } elseif ($heart_details['total_cholesterolhdlratio_color_code'] !== 'gray') {
                            $heart_details['total_cholesterolhdlratio_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['total_cholesterolhdlratio_color_code']}-thumb.png";
                            $heart_details['total_cholesterolhdlratio_impact_on_health'] = "The higher the ratio, the higher the risk. A ratio below 3.5:1 is considered very good.";
                            $heart_details['total_cholesterolhdlratio_suggestion'] = "NA";
                        } else {
                            $heart_details['total_cholesterolhdlratio_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($heart_details['total_cholesterolhdlratio_result_value_in_words'] == '' ||  $heart_details['total_cholesterolhdlratio_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }
        if (!$total_cholesterolhdlratio_found) {

            $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'CHOL' not found.";
            $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'CHOL' not found." . FindTestgroupAddress('Lipid Profile.');
        }


        //LDL / HDL Ratio sub teste
        $ldlorhdlratio_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'LDLR') {
                $ldlorhdlratio_found = true;
                $heart_details['ldlorhdlratio_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['ldlorhdlratio_result_value'] ?? null) === '' || ($heart_details['ldlorhdlratio_result_value'] ?? null) === null) {

                    $report_issues[] = "LDL / HDL RatioTestResultDetails are empty.";
                    $report_issues_email[] = "LDL / HDL RatioTestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['ldlorhdlratio_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['ldlorhdlratio_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['ldlorhdlratio_uom']);

                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = " LDL / HDL Ratio BR Interval are empty.";
                    $report_issues_email[] = " LDL / HDL Ratio BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['ldlorhdlratio_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code LDLR.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code LDLR." . FindTestgroupAddress('Lipid Profile.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['ldlorhdlratio_test_remraks'] = "LDL / HDL Ratio - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['ldlorhdlratio_test_remraks'] = '';
                }
                $heart_details['ldlorhdlratio_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {

                    $report_issues[] = " LDL / HDL Ratio BR Interval are empty.";
                    $report_issues_email[] = " LDL / HDL Ratio BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['ldlorhdlratio_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['ldlorhdlratio_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs funtion call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $range_map_count = count($range_map);
                if ($range_map_count == 5) {
                    $thumb_colors = ['green', 'orange', 'orange', 'red', 'red'];
                } elseif ($range_map_count == 3) {
                    $thumb_colors = ['green', 'orange', 'red'];
                } else {
                    $thumb_colors = [];
                }
                $thumb_colors_count = count($thumb_colors);

                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['ldlorhdlratio_reference_ranges_value'] = $range_map;
                $heart_details['ldlorhdlratio_result_value_in_words'] = '';
                $heart_details['ldlorhdlratio_color_code'] = 'gray';
                $heart_details['ldlorhdlratio_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (ldlorhdlratiomatchesRange($heart_details['ldlorhdlratio_result_value'], $range)) {
                        $heart_details['ldlorhdlratio_result_value_in_words'] = ucwords($label);
                        $heart_details['ldlorhdlratio_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['ldlorhdlratio_color_code'] === 'green') {
                            $heart_details['ldlorhdlratio_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['ldlorhdlratio_impact_on_health'] = '';
                            $heart_details['ldlorhdlratio_suggestion'] = '';
                        } elseif ($heart_details['ldlorhdlratio_color_code'] !== 'gray') {
                            $heart_details['ldlorhdlratio_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['ldlorhdlratio_color_code']}-thumb.png";
                            $heart_details['ldlorhdlratio_impact_on_health'] = "The higher the ratio, the higher the risk. A ratio below 2.5:1 is considered very good.";
                            $heart_details['ldlorhdlratio_suggestion'] = "NA";
                        } else {
                            $heart_details['ldlorhdlratio_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($heart_details['ldlorhdlratio_result_value_in_words'] == '' ||  $heart_details['ldlorhdlratio_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }
        if (!$ldlorhdlratio_found) {

            $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'LDLR' not found.";
            $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'LDLR' not found." . FindTestgroupAddress('Lipid Profile.');
        }


        //Non HDL Cholesterol sub teste
        $nonhdlcholesterol_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.' && explode('|', $resultData->TEST_CODE)[0] == 'NHDLC') {
                $nonhdlcholesterol_found = true;
                $heart_details['nonhdlcholesterol_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['nonhdlcholesterol_result_value'] ?? null) === '' || ($heart_details['nonhdlcholesterol_result_value'] ?? null) === null) {

                    $report_issues[] = "Non HDL Cholesterol TestResultDetails are empty.";
                    $report_issues_email[] = "Non HDL Cholesterol TestResultDetails are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['nonhdlcholesterol_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['nonhdlcholesterol_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['nonhdlcholesterol_uom']);

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['nonhdlcholesterol_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code NHDLC.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Lipid Profile. and test code NHDLC." . FindTestgroupAddress('Lipid Profile.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['nonhdlcholesterol_test_remraks'] = "Non HDL Cholesterol - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['nonhdlcholesterol_test_remraks'] = '';
                }
                $heart_details['nonhdlcholesterol_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {

                    $report_issues[] = " Non HDL Cholesterol BR Interval are empty.";
                    $report_issues_email[] = " Non HDL Cholesterol BR Interval are empty." . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['nonhdlcholesterol_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['nonhdlcholesterol_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs function call
                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'red', 'red'];
                $range_map_count = count($range_map);
                $thumb_colors_count = count($thumb_colors);

                if ($thumb_colors_count !== $range_map_count) {

                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
                $heart_details['nonhdlcholesterol_reference_ranges_value'] = $range_map;
                $heart_details['nonhdlcholesterol_result_value_in_words'] = '';
                $heart_details['nonhdlcholesterol_color_code'] = 'gray';
                $heart_details['nonhdlcholesterol_thumb_up_icon'] = '';
                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (nonhdlcholesterolmatchesRange($heart_details['nonhdlcholesterol_result_value'], $range)) {
                        $heart_details['nonhdlcholesterol_result_value_in_words'] = ucwords($label);
                        $heart_details['nonhdlcholesterol_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['nonhdlcholesterol_color_code'] === 'green') {
                            $heart_details['nonhdlcholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['nonhdlcholesterol_impact_on_health'] = '';
                            $heart_details['nonhdlcholesterol_suggestion'] = '';
                        } elseif ($heart_details['nonhdlcholesterol_color_code'] !== 'gray') {
                            $heart_details['nonhdlcholesterol_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['nonhdlcholesterol_color_code']}-thumb.png";
                            $heart_details['nonhdlcholesterol_impact_on_health'] = "A non-HDL cholesterol value includes all the atherogenic (artery-clogging) lipoprotein particles.";
                            $heart_details['nonhdlcholestero_suggestion'] = "NA";
                        } else {
                            $heart_details['nonhdlcholesterol_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($heart_details['nonhdlcholesterol_result_value_in_words'] == '' ||  $heart_details['nonhdlcholesterol_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Lipid Profile.');
                }
            }
        }
    }
    if (!$nonhdlcholesterol_found) {

        $report_issues[] = " Test Group 'Lipid Profile.' or Test Code 'LDLR' not found.";
        $report_issues_email[] = " Test Group 'Lipid Profile.' or Test Code 'LDLR' not found." . FindTestgroupAddress('Lipid Profile.');
    }
    // High Sensitive CRP (hs-CRP), Serum(Ayushman Wellness Package)
    if ($PackageCode == 'AYN_017' || $PackageCode == 'AYN_018' || $PackageCode == 'AYN_019' ||  $PackageCode == 'AYN_020' ||  $PackageCode == 'AYN_021' || $PackageCode == 'AYN_022' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030') {
        $high_sensitive_CRP_serum_found = false;

        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'H0013' && explode('|', $resultData->TEST_CODE)[0] == 'HSCRP') {
                $high_sensitive_CRP_serum_found = true;
                $heart_details['high_sensitive_CRP_serum_result_value'] = $resultData->RESULT_VALUE;

                if (($heart_details['high_sensitive_CRP_serum_result_value'] ?? null) === '' || ($heart_details['high_sensitive_CRP_serum_result_value'] ?? null) === null) {
                    $report_issues[] = "High Sensitive CRP (hs-CRP), Serum TestResultDetails are empty.";
                    $report_issues_email[] = "High Sensitive CRP (hs-CRP), Serum TestResultDetails are empty." . FindTestgroupAddress('H0013');
                }
                $heart_details['high_sensitive_CRP_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['high_sensitive_CRP_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['high_sensitive_CRP_serum_uom']);

                // BR validation dynamic
                if (!isset($resultData->BRInterval)) {

                    $report_issues[] = "High Sensitive CRP (hs-CRP), Serum BR Interval are empty.";
                    $report_issues_email[] = "High Sensitive CRP (hs-CRP), Serum BR Interval are empty." . FindTestgroupAddress('H0013');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['high_sensitive_CRP_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code H0013 and test code HSCRP.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code H0013 and test code HSCRP." . FindTestgroupAddress('H0013');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['high_sensitive_CRP_serum_test_remraks'] = " High Sensitive CRP (hs-CRP) - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['high_sensitive_CRP_serum_test_remraks'] = '';
                }
                $heart_details['high_sensitive_CRP_serum_sample_method'] = $resultData->NEW_METHOD;

                $heart_details['high_sensitive_CRP_serum_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($heart_details['high_sensitive_CRP_serum_BRInterval_result_value']));
                $range_map = [];
                // Parse label-value pairs function call
                $heart_details['high_sensitive_CRP_serum_heading_BRInterval_result_value'] = null;
                foreach ($intervals as $interval) {
                    $interval = trim($interval);
                    if (!preg_match('/[<>=\d]/', $interval)) {
                        $heart_details['high_sensitive_CRP_serum_heading_BRInterval_result_value'] = $interval;
                        continue;
                    }
                    if (strpos($interval, ':') !== false) {
                        [$label, $range] = explode(':', $interval);
                        $label = strtolower(trim($label));
                        $range = trim($range);
                        if (preg_match('/[^0-9<>=\s\.\-\,]/', $range)) {
                            $invalid_lines[] = $interval;
                        } else {
                            $range_map[$label] = $range;
                        }
                    } else {
                        if (preg_match('/^([^\d<>=]+)([<>=]\s*\d+)/', $interval, $matches)) {
                            $label = strtolower(trim($matches[1]));
                            $range = trim($matches[2]);
                            $range_map[$label] = $range;
                        } else {
                            $invalid_lines[] =  $interval;
                        }
                    }
                }
                if (!empty($invalid_lines)) {
                    $invalids = array_map('htmlspecialchars', $invalid_lines);
                    $errorMessage = $reportJsonData->PatientDetails[0]->LAB_ID . " - The BRinterval sequence is incorrect for " .  $resultData->TEST_CODE;
                    $report_issues[] = "The BRinterval sequence is incorrect for " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "The BRinterval sequence is incorrect for " .  $resultData->TEST_CODE . FindTestgroupAddress('H0013');
                }

                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'red', 'red'];
                $range_map_count = count($range_map);
                $thumb_colors_count = count($thumb_colors);
                if ($thumb_colors_count !== $range_map_count) {
                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('H0013');
                }
                $heart_details['high_sensitive_CRP_serum_reference_ranges_value'] = $range_map;
                $heart_details['high_sensitive_CRP_serum_result_value_in_words'] = '';
                $heart_details['high_sensitive_CRP_serum_color_code'] = 'gray';
                $heart_details['high_sensitive_CRP_serum_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (highsensitiveCRPserummatchesRange($heart_details['high_sensitive_CRP_serum_result_value'], $range)) {
                        $heart_details['high_sensitive_CRP_serum_result_value_in_words'] = ucwords($label);
                        $heart_details['high_sensitive_CRP_serum_color_code'] = $thumb_colors[$index] ?? 'gray';
                        if ($heart_details['high_sensitive_CRP_serum_color_code'] === 'green') {
                            $heart_details['high_sensitive_CRP_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['high_sensitive_CRP_serum_impact_on_health'] = '';
                            $heart_details['high_sensitive_CRP_serum_suggestion'] = '';
                        } elseif ($heart_details['high_sensitive_CRP_serum_color_code'] !== 'gray') {
                            $heart_details['high_sensitive_CRP_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['high_sensitive_CRP_serum_color_code']}-thumb.png";
                            $heart_details['high_sensitive_CRP_serum_impact_on_health'] = "It is used in the risk assessment for developing Myocardial infarction in patients presenting with Acute coronary syndrome. It is also useful in assessing risk of developing Cardiovascular disease or ischemic event in individuals who do not manifest disease at present";
                            $heart_details['high_sensitive_CRP_serum_suggestion'] = "NA";
                        } else {
                            $heart_details['high_sensitive_CRP_serum_thumb_up_icon'] = '';
                        }
                        break;
                    }
                    $index++;
                }
                if ($heart_details['high_sensitive_CRP_serum_result_value_in_words'] == '' ||  $heart_details['high_sensitive_CRP_serum_color_code'] == 'gray') {

                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('H0013');
                }
            }
        }
        if (!$high_sensitive_CRP_serum_found) {
            $report_issues[] = " Test Group 'H0013' or Test Code 'HSCRP' not found.";
            $report_issues_email[] = " Test Group 'H0013' or Test Code 'HSCRP' not found." . FindTestgroupAddress('H0013');
        }
    }

    //Apolipoprotein A1, Serum(Ayushman Wellness Plus)
    if ($PackageCode == 'AYN_018' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031') {


        // if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
        $apolipoprotein_A1_serum_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
       
            if ($resultData->TEST_GROUP_CODE == 'A0018' && explode('|', $resultData->TEST_CODE)[0] == 'APOA1') {
                $apolipoprotein_A1_serum_result_found = true;
                $heart_details['apolipoprotein_A1_serum_result_value'] = $resultData->RESULT_VALUE;

                if (($heart_details['apolipoprotein_A1_serum_result_value'] ?? null) === '' || ($heart_details['apolipoprotein_A1_serum_result_value'] ?? null) === null) {
                    $report_issues[] = "Apolipoprotein A1, Serum TestResultDetails are empty.";
                    $report_issues_email[] = "Apolipoprotein A1, Serum TestResultDetails are empty." . FindTestgroupAddress('A0018');
                }

                $heart_details['apolipoprotein_A1_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['apolipoprotein_A1_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['apolipoprotein_A1_serum_uom']);

                if (!isset($resultData->BRInterval)) {
                    $report_issues[] = "Apolipoprotein A1, serum BR Interval is empty.";
                    $report_issues_email[] = "Apolipoprotein A1, serum BR Interval is empty." . FindTestgroupAddress('A0018');
                }

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '') {
                    $heart_details['apolipoprotein_A1_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = "NABL mapping missing for A0018 and APOA1.";
                    $report_issues_email[] = "NABL mapping missing for A0018 and APOA1." . FindTestgroupAddress('A0018');
                }

                $heart_details['apolipoprotein_A1_serum_test_remraks'] = (!empty($resultData->TEST_REMARKS))
                    ? "Apolipoprotein A1, Serum - " . $resultData->TEST_REMARKS : '';

                $heart_details['apolipoprotein_A1_serum_sample_method'] = $resultData->NEW_METHOD;
                $heart_details['apolipoprotein_A1_serum_BRInterval_result_value'] = trim($resultData->BRInterval);

                $intervals = explode("\n", trim($heart_details['apolipoprotein_A1_serum_BRInterval_result_value']));
                $gender = '';
                if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
                    $gender = 'female';
                } elseif (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
                    $gender = 'male';
                }

                $range_map = [];
                $invalid_lines = [];

                foreach ($intervals as $interval) {
                    $interval = trim($interval);
                    if (strpos($interval, ':') !== false) {
                        [$label, $range] = explode(':', $interval);
                        $label = strtolower(trim($label));
                        $range = trim($range);
                        $range_map[$label] = $range;
                    } elseif (preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $interval)) {
                        $range_map['Range'] = $interval;
                    } else {
                        $invalid_lines[] = $interval;
                    }
                }

                if (!empty($invalid_lines)) {
                    $report_issues[] = "Invalid BRInterval Sequence for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Invalid BRInterval Sequence for " . $resultData->TEST_CODE . FindTestgroupAddress('A0018');
                }

                $value = (float)$heart_details['apolipoprotein_A1_serum_result_value'];
                $matched = false;
                $label = 'Normal';
                $color = 'green';
                $heart_details['apolipoprotein_A1_serum_reference_ranges_value'] = $range_map;

                $label_color_map = [
                    'low' => 'red',
                    'borderline low' => 'orange',
                    'abovedesirable' => 'orange',
                    'acceptable' => 'green',
                    'normal' => 'green',
                    'borderline high' => 'orange',
                    'borderlinehigh' => 'orange',
                    'high' => 'red',
                    'very high' => 'red',
                    'veryhigh' => 'red'
                ];

                // 1. Gender-based range evaluation
                if (isset($range_map[$gender])) {
                    $range_val = trim($range_map[$gender]);

                    if (preg_match('/^[<>=]+=?\s*\d+(\.\d+)?$/', $range_val)) {
                        list($operator, $threshold) = parseRange($range_val);
                        if (compare($value, $operator, $threshold)) {
                            $label = 'Normal';
                            $color = 'green';
                        } else {
                            $label = 'Low';
                            $color = 'red';
                        }
                        $matched = true;
                    } elseif (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range_val, $match)) {
                        $min = (float)$match[1];
                        $max = (float)$match[3];
                        if ($value >= $min && $value <= $max) {
                            $label = 'Normal';
                            $color = 'green';
                        } elseif ($value < $min) {
                            $label = 'Low';
                            $color = 'red';
                        } else { // $value > $max
                            $label = 'High';
                            $color = 'red';
                        }
                        $matched = true;
                    }
                }

                // 2. Labeled ranges like Acceptable: <90 or High: =140
                if (!$matched && count($range_map) > 1) {
                    foreach ($range_map as $lbl => $cond) {
                        if (in_array($lbl, ['male', 'female', 'Range'])) continue;

                        $check_color = $label_color_map[strtolower($lbl)] ?? 'orange';

                        if (preg_match('/^[<>=]+=?\s*\d+(\.\d+)?$/', $cond)) {
                            list($operator, $threshold) = parseRange($cond);
                            if (compare($value, $operator, $threshold)) {
                                $label = ucfirst($lbl);
                                $color = $check_color;
                                $matched = true;
                                break;
                            }
                        } elseif (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $cond, $m)) {
                            $min = (float)$m[1];
                            $max = (float)$m[3];
                            if ($value >= $min && $value <= $max) {
                                $label = ucfirst($lbl);
                                $color = $check_color;
                                $matched = true;
                                break;
                            }
                        }
                    }
                }

                // 3. Generic range fallback
                if (!$matched && isset($range_map['Range'])) {
                    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range_map['Range'], $match)) {
                        $min = (float)$match[1];
                        $max = (float)$match[3];
                        if ($value < $min) {
                            $label = 'Low';
                            $color = 'red';
                        } elseif ($value > $max) {
                            $label = 'High';
                            $color = 'red';
                        } else {
                            $label = 'Normal';
                            $color = 'green';
                        }
                        $matched = true;
                    }
                }

                // 4. Nothing matched
                if (!$matched) {
                    $report_issues[] = "Result value does not match any reference range.";
                    $report_issues_email[] = "Result value does not match any reference range. " . FindTestgroupAddress('A0018');
                }

                // Final values
                $heart_details['apolipoprotein_A1_serum_result_value_in_words'] = ucfirst($label);
                $heart_details['apolipoprotein_A1_serum_color_code'] = $color;

                if ($color === 'green') {
                    $heart_details['apolipoprotein_A1_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$color}-thumbs.png";
                } else {
                    $heart_details['apolipoprotein_A1_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$color}-thumb.png";
                }

                $heart_details['apolipoprotein_A1_serum_impact_on_health'] = ($color === 'red')
                    ? 'The apoB/apoA1 ratio increase indicated an increased risk of CHD.'
                    : '';
            }
        }
        if (!$apolipoprotein_A1_serum_result_found) {
            // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Test Group 'A0018' or Test Code 'APOA1' not found.");
            // echo $reportJsonData->PatientDetails[0]->LAB_ID . " Test Group 'A0018' or Test Code 'APOA1' not found.";
            // exit;
            $report_issues[] = " Test Group 'A0018' or Test Code 'APOA1' not found.";
            $report_issues_email[] = " Test Group 'A0018' or Test Code 'APOA1' not found." . FindTestgroupAddress('A0018');
        }
    }

    //Apolipoprotein B, Serum(Ayushman Wellness Plus)
    if ($PackageCode == 'AYN_018' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_028') {

        $apolipoprotein_B_serum_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'A0018' && explode('|', $resultData->TEST_CODE)[0] == 'APOLB') {
                $apolipoprotein_B_serum_result_found = true;
                $heart_details['apolipoprotein_B_serum_result_value'] = $resultData->RESULT_VALUE;
                $heart_details['apolipoprotein_B_serum_json_low_value'] = $resultData->LOW_VALUE;
                $heart_details['apolipoprotein_B_serum_json_high_value'] = $resultData->HIGH_VALUE;
                if (!isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" || $resultData->LOW_VALUE == null) {
                    $report_issues[] = "Apolipoprotein B serum Low value is empty";
                    $report_issues_email[] = "Apolipoprotein B serum Low value is empty" . FindTestgroupAddress('A0018');
                }

                if (($heart_details['apolipoprotein_B_serum_result_value'] ?? null) === '' || ($heart_details['apolipoprotein_B_serum_result_value'] ?? null) === null) {
                    $report_issues[] = "Apolipoprotein B, Serum TestResultDetails are empty.";
                    $report_issues_email[] = "Apolipoprotein B, Serum TestResultDetails are empty." . FindTestgroupAddress('A0018');
                }

                $heart_details['apolipoprotein_B_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['apolipoprotein_B_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['apolipoprotein_B_serum_uom']);

                if (!isset($resultData->BRInterval)) {
                    $report_issues[] = "Apolipoprotein B serum BR Interval are empty.";
                    $report_issues_email[] = "Apolipoprotein B serum BR Interval are empty." . FindTestgroupAddress('A0018');
                }

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['apolipoprotein_B_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = "NABL mapping is either not found or is empty for the test group code A0018 and test code APOLB.";
                    $report_issues_email[] = "NABL mapping is either not found or is empty for the test group code A0018 and test code APOLB." . FindTestgroupAddress('A0018');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['apolipoprotein_B_serum_test_remraks'] = "Apolipoprotein B, Serum - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['apolipoprotein_B_serum_test_remraks'] = '';
                }

                $heart_details['apolipoprotein_B_serum_sample_method'] = $resultData->NEW_METHOD;
                $heart_details['apolipoprotein_B_serum_BRInterval_result_value'] = trim($resultData->BRInterval);
                $intervals = explode("\n", trim($heart_details['apolipoprotein_B_serum_BRInterval_result_value']));

                $range_map = [];
                $main_range = null;
                $reference_data = [];
                $invalid_lines = [];
                // Detect unit once (from the first line)
                $unit_detected = '';
                if (preg_match('/[a-zA-Z%\/]+$/', $heart_details['apolipoprotein_B_serum_BRInterval_result_value'], $u)) {
                    $unit_detected = trim($u[0]);
                }

                foreach ($intervals as $line) {
                    $line = trim($line);
                    if ($line === '') continue;

                    if (strpos($line, ':') !== false) {
                        // Case 1: Label: Range
                        [$label, $range] = explode(':', $line, 2);
                        $label = trim($label);
                        $range = trim($range);

                        // Keep original range with unit for printing
                        $reference_data[$label] = $range;

                        // Clean only numbers/operators for parsing
                        $clean_range = preg_replace('/[^\d<>=\-\.\s]/', '', $range);
                        $clean_range = preg_replace('/\s+/', ' ', $clean_range);
                        $clean_range = trim($clean_range);

                        if (
                            preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $clean_range) ||
                            preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $clean_range)
                        ) {
                            $range_map[strtolower($label)] = $clean_range;
                            if (in_array(strtolower($label), ['normal', 'desirable'])) {
                                $main_range = $clean_range;
                            }
                        } else {
                            $invalid_lines[] = $line;
                        }
                    } else {
                        // Case 2 & 3: Range without label
                        $reference_data['Range'] = $line; // keep original for printing

                        $clean_range = preg_replace('/[^\d<>=\-\.\s]/', '', $line);
                        $clean_range = preg_replace('/\s+/', ' ', $clean_range);
                        $clean_range = trim($clean_range);

                        if (preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $clean_range)) {
                            $main_range = $clean_range;
                        } elseif (preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $clean_range)) {
                            $main_range = $clean_range;
                        } else {
                            $invalid_lines[] = $line;
                        }
                    }
                }

                // 🔹 Attach unit at the end if found
                if ($unit_detected !== '') {
                    foreach ($reference_data as $label => $range) {
                        if (strpos($range, $unit_detected) === false) {
                            $reference_data[$label] = $range . ' ' . $unit_detected;
                        }
                    }
                }


                $heart_details['apolipoprotein_B_serum_reference_ranges_value'] = $reference_data;
                $heart_details['apolipoprotein_B_serum_result_value_in_words'] = '';
                $heart_details['apolipoprotein_B_serum_color_code'] = 'gray';
                $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = '';

                $matched = false;
                $label_color_map = [
                    'low' => 'red',
                    'acceptable' => 'green',
                    'borderline high' => 'orange',
                    'high' => 'red',
                    'desirable' => 'green',
                    'above desirable' => 'orange',
                    'very high' => 'red'
                ];
                $index = 0;

                foreach ($range_map as $label => $range) {
                    if (highsensitiveCRPserummatchesRange($heart_details['apolipoprotein_B_serum_result_value'], $range)) {
                        $label_lc = strtolower(trim($label));
                        $heart_details['apolipoprotein_B_serum_result_value_in_words'] = ucwords($label_lc);
                        $heart_details['apolipoprotein_B_serum_color_code'] = $label_color_map[$label_lc] ?? 'gray';

                        if ($heart_details['apolipoprotein_B_serum_color_code'] === 'green') {
                            $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $heart_details['apolipoprotein_B_serum_impact_on_health'] = '';
                            $heart_details['apolipoprotein_B_serum_suggestion'] = '';
                        } elseif ($heart_details['apolipoprotein_B_serum_color_code'] !== 'gray') {
                            $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['apolipoprotein_B_serum_color_code']}-thumb.png";
                            $heart_details['apolipoprotein_B_serum_impact_on_health'] = "The apoB/apoA1 ratio increase indicated an increased risk of CHD.";
                            $heart_details['apolipoprotein_B_serum_suggestion'] = "NA";
                        } else {
                            $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = '';
                        }

                        $matched = true;
                        break;
                    }
                    $index++;
                }

                if (!$matched && $main_range && preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $main_range, $match)) {
                    $low = (float)$match[1];
                    $high = (float)$match[3];
                    $value = (float) preg_replace('/[^0-9.]/', '', $heart_details['apolipoprotein_B_serum_result_value']);

                    if ($value < $low) {
                        $heart_details['apolipoprotein_B_serum_result_value_in_words'] = 'Low';
                        $heart_details['apolipoprotein_B_serum_color_code'] = 'red';
                    } elseif ($value > $high) {
                        $heart_details['apolipoprotein_B_serum_result_value_in_words'] = 'High';
                        $heart_details['apolipoprotein_B_serum_color_code'] = 'red';
                    } else {
                        $heart_details['apolipoprotein_B_serum_result_value_in_words'] = 'Normal';
                        $heart_details['apolipoprotein_B_serum_color_code'] = 'green';
                    }

                    if ($heart_details['apolipoprotein_B_serum_color_code'] === 'green') {
                        $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                        $heart_details['apolipoprotein_B_serum_impact_on_health'] = '';
                        $heart_details['apolipoprotein_B_serum_suggestion'] = '';
                    } else {
                        $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['apolipoprotein_B_serum_color_code']}-thumb.png";
                        $heart_details['apolipoprotein_B_serum_impact_on_health'] = "The apoB/apoA1 ratio increase indicated an increased risk of CHD.";
                        $heart_details['apolipoprotein_B_serum_suggestion'] = "NA";
                    }

                    $matched = true;
                }

                if ($heart_details['apolipoprotein_B_serum_result_value_in_words'] === '' || $heart_details['apolipoprotein_B_serum_color_code'] === 'gray') {
                    if(isset($heart_details['apolipoprotein_B_serum_json_low_value'])){
                    if ($heart_details['apolipoprotein_B_serum_result_value'] <= $heart_details['apolipoprotein_B_serum_json_low_value']) {
                        $heart_details['apolipoprotein_B_serum_result_value_in_words'] = 'Low';
                        $heart_details['apolipoprotein_B_serum_color_code'] = 'red';
                        $heart_details['apolipoprotein_B_serum_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$heart_details['apolipoprotein_B_serum_color_code']}-thumb.png";
                        $heart_details['apolipoprotein_B_serum_impact_on_health'] = "The apoB/apoA1 ratio increase indicated an increased risk of CHD.";
                        $heart_details['apolipoprotein_B_serum_suggestion'] = "NA";
                    }
                    else{
                        $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                        $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('A0018');
                    }
                }
                
            }
        }
        }

        
        if (!$apolipoprotein_B_serum_result_found) {
            // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Test Group 'A0018' or Test Code 'APOLB' not found.");
            // echo $reportJsonData->PatientDetails[0]->LAB_ID . " Test Group 'A0018' or Test Code 'APOLB' not found.";
            // exit;
            $report_issues[] = " Test Group 'A0018' or Test Code 'APOLB' not found.";
            $report_issues_email[] = " Test Group 'A0018' or Test Code 'APOLB' not found." . FindTestgroupAddress('A0018');
        }

        //APO- B/ APO- A1 Ratio(Ayushman Wellness Plus)
        $apolipoprotein_A1_B_serum_result_value = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'A0018' && explode('|', $resultData->TEST_CODE)[0] == 'APOBA1') {
                $apolipoprotein_A1_B_serum_result_value = true;
                $heart_details['apolipoprotein_A1_B_serum_result_value'] = $resultData->RESULT_VALUE;
                if (($heart_details['apolipoprotein_A1_B_serum_result_value'] ?? null) === '' || ($heart_details['apolipoprotein_A1_B_serum_result_value'] ?? null) === null) {
                    // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "APO- B/ APO- A1 Ratio TestResultDetails is empty");
                    // echo $reportJsonData->PatientDetails[0]->LAB_ID . "APO- B/ APO- A1 Ratio TestResultDetails are empty.";
                    // exit;
                    $report_issues[] = "APO- B/ APO- A1 Ratio TestResultDetails are empty.";
                    $report_issues_email[] = "APO- B/ APO- A1 Ratio TestResultDetails are empty." . FindTestgroupAddress('A0018');
                }
                $heart_details['apolipoprotein_A1_B_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $heart_details['apolipoprotein_A1_B_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $heart_details['apolipoprotein_A1_B_serum_uom']);

                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "APO- B/ APO- A1 Ratio reference ranges are empty");
                    // echo $reportJsonData->PatientDetails[0]->LAB_ID . " APO- B/ APO- A1 Ratio reference ranges are empty.";
                    // exit;
                    $report_issues[] = " APO- B/ APO- A1 Ratio reference ranges are empty.";
                    $report_issues_email[] = " APO- B/ APO- A1 Ratio reference ranges are empty." . FindTestgroupAddress('A0018');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                    // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "APO- B/ APO- A1 Ratio BR Interval are empty");
                    // echo $reportJsonData->PatientDetails[0]->LAB_ID . " APO- B/ APO- A1 RatioBR Interval are empty.";
                    // exit;
                    $report_issues[] = " APO- B/ APO- A1 RatioBR Interval are empty.";
                    $report_issues_email[] = " APO- B/ APO- A1 RatioBR Interval are empty." . FindTestgroupAddress('A0018');
                }

                $heart_details['apolipoprotein_A1_B_serum_low_result_value'] = $resultData->LOW_VALUE;
                $heart_details['apolipoprotein_A1_B_serum_high_result_value'] = $resultData->HIGH_VALUE;
                $heart_details['apolipoprotein_A1_B_serum_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $heart_details['apolipoprotein_A1_B_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "NABL mapping is either not found or is empty for the test group code A0018 and test code APOBA1.");
                    // echo $reportJsonData->PatientDetails[0]->LAB_ID . " NABL mapping is either not found or is empty for the test group code A0018 and test code APOBA1.";
                    // exit;
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code A0018 and test code APOBA1.";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code A0018 and test code APOBA1." . FindTestgroupAddress('A0018');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $heart_details['apolipoprotein_A1_B_serum_test_remraks'] = "APO- B/ APO- A1 Ratio - " . $resultData->TEST_REMARKS;
                } else {
                    $heart_details['apolipoprotein_A1_B_serum_test_remraks'] = '';
                }

                $heart_details['apolipoprotein_A1_B_serum_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $heart_details['apolipoprotein_A1_B_serum_low_result_value']) {
                    $heart_details['apolipoprotein_A1_B_serum_result_value_in_words'] = 'Low';
                    $heart_details['apolipoprotein_A1_B_serum_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $heart_details['apolipoprotein_A1_B_serum_low_result_value'] && $resultData->RESULT_VALUE <= $heart_details['apolipoprotein_A1_B_serum_high_result_value']) {
                    $heart_details['apolipoprotein_A1_B_serum_result_value_in_words'] = 'Normal';
                    $heart_details['apolipoprotein_A1_B_serum_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $heart_details['apolipoprotein_A1_B_serum_high_result_value']) {
                    $heart_details['apolipoprotein_A1_B_serum_result_value_in_words'] = 'High';
                    $heart_details['apolipoprotein_A1_B_serum_color_code'] = "red";
                }

                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $heart_details['apolipoprotein_A1_B_serum_low_result_value'] || $resultData->RESULT_VALUE > $heart_details['apolipoprotein_A1_B_serum_high_result_value']) {
                    $heart_details['apolipoprotein_A1_B_serum_impact_on_health'] = "The apoB/apoA1 ratio increase indicated an increased risk of CHD.";
                } else {
                    $heart_details['apolipoprotein_A1_B_serum_impact_on_health'] = '';
                }
            }
        }
        if (!$apolipoprotein_A1_B_serum_result_value) {
            // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Test Group 'A0018' or Test Code 'APOBA1' not found.");
            // echo $reportJsonData->PatientDetails[0]->LAB_ID . " Test Group 'A0018' or Test Code 'APOBA1' not found.";
            // exit;
            $report_issues[] = " Test Group 'A0018' or Test Code 'APOBA1' not found.";
            $report_issues_email[] = " Test Group 'A0018' or Test Code 'APOBA1' not found." . FindTestgroupAddress('A0018');
        }
    }
    if (!$total_cholesterol_found) {
        // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Test Group 'Lipid Profile.' or Test Code 'TCH' not found.");
        // echo $reportJsonData->PatientDetails[0]->LAB_ID . "Test Group 'Lipid Profile.' or Test Code 'TCH' not found.";
        // exit;
        $report_issues[] = "Test Group 'Lipid Profile.' or Test Code 'TCH' not found.";
        $report_issues_email[] = "Test Group 'Lipid Profile.' or Test Code 'TCH' not found." . FindTestgroupAddress('A0018');
    }
    //print_r($heart_details);
    return $heart_details;
}

function compare($value, $operator, $threshold)
{
    switch ($operator) {
        case '=':
            return $value == $threshold;
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}
function parseRange($range)
{
    if (preg_match('/^(=|<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return [$match[1], (float)$match[2]];
    }
    return [null, null];
}

// Comparison without eval
function totalcholesterolcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function totalcholesterolmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return totalcholesterolcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
/**
 * Description: The getHeartTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for heart-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function triglyceridescompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function triglyceridesmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return triglyceridescompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}

function hdlcholesterolcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}
function hdlcholesterolmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return hdlcholesterolcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
function lipoproteincholesterolcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

function lipoproteincholesterolmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return lipoproteincholesterolcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
function totalcholesterolhdlratiocompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}
function totalcholesterolhdlratiomatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return totalcholesterolhdlratiocompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
function ldlorhdlratiocompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

function ldlorhdlratiomatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return ldlorhdlratiocompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
function nonhdlcholesterolcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

function nonhdlcholesterolmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return nonhdlcholesterolcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
function highsensitiveCRPserumcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

function highsensitiveCRPserummatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return highsensitiveCRPserumcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}

function getHeartTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{
    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        // echo "Package Code not found";
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $HeartNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_025' || $PackageCode == 'AYN_026' || $PackageCode == 'AYN_027') {

            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Lipid Profile";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Lipid Profile" . FindTestgroupAddress('Lipid Profile.');
                }

                $HeartNablAccredited['lipid_profile_heart_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $HeartNablAccredited['lipid_profile_heart_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif ($PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_029') {
            if ($resultData->TEST_GROUP_CODE == 'Lipid Profile.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Lipid Profile";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Lipid Profile" . FindTestgroupAddress('Lipid Profile.');
                }
                $HeartNablAccredited['lipid_profile_heart_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $HeartNablAccredited['lipid_profile_heart_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'H0013') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0013";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code H0013" . FindTestgroupAddress('H0013');
                }
                $HeartNablAccredited['H0013_heart_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $HeartNablAccredited['H0013_heart_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE === 'A0018') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code A0018";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code A0018" . FindTestgroupAddress('A0018');
                }
                $HeartNablAccredited['A0018_heart_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $HeartNablAccredited['A0018_heart_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        }
    }
    return $HeartNablAccredited;
}

/**
 * Description : getThyroidDetails() function to get test result details for thyroid-related diagnostics.
 * 
 * This function retrieves test results related to thyroid function from the 
 * TestResultDetails array within the JSON response. It filters out relevant test groups 
 * and test codes that correspond to thyroid diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to thyroid function.
 */

// get Thyroid Deatils

function getThyroidDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        // echo "Package Code not found";
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $throid_details = [];
    // Thyroid - TriIodo Thyronine (T3 Total) sub test
    $thyronine_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Thyroid 001' && explode('|', $resultData->TEST_CODE)[0] == 'TITT3') {
            $thyronine_found = true;
            $throid_details['thyronine_result_value'] = $resultData->RESULT_VALUE;
            $throid_details['thyronine_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $throid_details['thyronine_result_value']);
            if (($throid_details['thyronine_result_value'] ?? null) === '' || ($throid_details['thyronine_result_value'] ?? null) === null) {
                $report_issues[] = "Thyroid - TriIodo Thyronine (T3 Total) TestResultDetails are empty";
                $report_issues_email[] = "Thyroid - TriIodo Thyronine (T3 Total) TestResultDetails are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['thyronine_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $throid_details['thyronine_uom'] = str_replace(["�", "ï¿½"], "μ", $throid_details['thyronine_uom']);
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Thyroid - TriIodo Thyronine (T3 Total) reference ranges are empty";
                $report_issues_email[] = " Thyroid - TriIodo Thyronine (T3 Total) reference ranges are empty" . FindTestgroupAddress('Thyroid 001');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Thyroid - TriIodo Thyronine (T3 Total) BR Interval are empty";
                $report_issues_email[] = "  Thyroid - TriIodo Thyronine (T3 Total) BR Interval are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['t_three_low_result_value'] = $resultData->LOW_VALUE;
            $throid_details['t_three_high_result_value'] = $resultData->HIGH_VALUE;
            $throid_details['t_three_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            $range_map = [];

            $brInterval = trim($throid_details['t_three_BRInterval_result_value']);
            if (strpos($brInterval, ':') !== false) {
                $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                foreach ($intervals as $interval) {
                    if (strpos($interval, ':') !== false) {
                        [$label, $range] = explode(':', $interval, 2);
                        $label = strtolower(trim($label));
                        // Trim commas and whitespace from start and end of range
                        $range = trim($range, " \t\n\r\0\x0B,");
                        $range_map[$label] = $range;
                    }
                }
            } else {

                $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                $range_map['Range'] = $clean_range;
            }

            $throid_details['t_three_reference_ranges_value'] = $range_map;
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $throid_details['thyronine_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code TITT3";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code TITT3" . FindTestgroupAddress('Thyroid 001');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $throid_details['thyronine_test_remraks'] = "Thyroid - TriIodo Thyronine (T3 Total) - " . $resultData->TEST_REMARKS;
            } else {
                $throid_details['thyronine_test_remraks'] = '';
            }
            $throid_details['thyronine_sample_method'] = $resultData->NEW_METHOD;
            if ($throid_details['thyronine_result_value_cleaned'] < $throid_details['t_three_low_result_value']) {
                $throid_details['thyronine_result_value_in_words'] = 'Low';
                $throid_details['thyronine_color_code'] = "red";
            }
            if ($throid_details['thyronine_result_value_cleaned'] >= $throid_details['t_three_low_result_value'] && $throid_details['thyronine_result_value_cleaned'] <= $throid_details['t_three_high_result_value']) {
                $throid_details['thyronine_result_value_in_words'] = 'Normal';
                $throid_details['thyronine_color_code'] = "green";
            }
            if ($throid_details['thyronine_result_value_cleaned'] > $throid_details['t_three_high_result_value']) {
                $throid_details['thyronine_result_value_in_words'] = 'High';
                $throid_details['thyronine_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($throid_details['thyronine_result_value_cleaned'] < $throid_details['t_three_low_result_value'] || $throid_details['thyronine_result_value_cleaned'] > $throid_details['t_three_high_result_value']) {
                $throid_details['thyronine_impact_on_health'] = "Triiodothyronine (T3) values above 200 ng/dL in adults or over age related cutoffs in children are consistent with hyperthyroidism or increased thyroid hormone-binding proteins. Abnormal levels (high or low) of thyroid hormone-binding proteins (primarily albumin and thyroid-binding globulin) may cause abnormal T3 concentrations in euthyroid patients. Please note that Triiodothyronine (T3) is not a reliable marker for hypothyroidism. Therapy with amiodarone can lead to depressed T3 values";
            } else {
                $throid_details['thyronine_impact_on_health'] = '';
            }
            if ($throid_details['thyronine_result_value_cleaned'] < $throid_details['t_three_low_result_value'] || $throid_details['thyronine_result_value_cleaned'] > $throid_details['t_three_high_result_value']) {
                $throid_details['thyronine_suggestion'] = "Thyroid hormone levels can be brought to normal in a many ways and each treatment will depend on the cause of your thyroid condition.If you have hyperthyroidism,treatment options can include:Antithyroid drugs,beta blockers,radioactive iodine,surgery.If you have hypothyroidism the main treatment option is Thyroid replacement medication";
            } else {
                $throid_details['thyronine_suggestion'] = '';
            }
        }
    }
    if (!$thyronine_found) {

        $report_issues[] = " Test Group 'Thyroid 001' or Test Code 'TITT3' not found";
        $report_issues_email[] = " Test Group 'Thyroid 001' or Test Code 'TITT3' not found" . FindTestgroupAddress('Thyroid 001');
    }
    // Thyroid Thyroxine (T4) sub test
    // if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
    $thyroxine_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {

        if ($resultData->TEST_GROUP_CODE == 'Thyroid 001' &&  explode('|', $resultData->TEST_CODE)[0] == 'THYT4') {
            $thyroxine_found = true;
            $throid_details['thyroxine_result_value'] = $resultData->RESULT_VALUE;
            $throid_details['thyroxine_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $throid_details['thyroxine_result_value']);
            if (($throid_details['thyroxine_result_value'] ?? null) === '' || ($throid_details['thyroxine_result_value'] ?? null) === null) {
                $report_issues[] = "Thyroid Thyroxine (T4) TestResultDetails are empty";
                $report_issues_email[] = "Thyroid Thyroxine (T4) TestResultDetails are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['thyroxine_uom'] = $resultData->UOM ? $resultData->UOM : '';
            $throid_details['thyroxine_uom'] = str_replace(["�", "ï¿½"], "μ", $throid_details['thyroxine_uom']);
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Thyroid Thyroxine (T4) reference ranges are empty";
                $report_issues_email[] = " Thyroid Thyroxine (T4) reference ranges are empty" . FindTestgroupAddress('Thyroid 001');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Thyroid Thyroxine (T4) BR Interval are empty";
                $report_issues_email[] = "  Thyroid Thyroxine (T4) BR Interval are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['t_four_low_result_value'] = $resultData->LOW_VALUE;
            $throid_details['t_four_high_result_value'] = $resultData->HIGH_VALUE;
            $throid_details['t_four_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            $range_map = [];

            $brInterval = trim($throid_details['t_four_BRInterval_result_value']);
            if (strpos($brInterval, ':') !== false) {
                $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                foreach ($intervals as $interval) {
                    if (strpos($interval, ':') !== false) {
                        [$label, $range] = explode(':', $interval, 2);
                        $label = strtolower(trim($label));
                        // Trim commas and whitespace from start and end of range
                        $range = trim($range, " \t\n\r\0\x0B,");
                        $range_map[$label] = $range;
                    }
                }
            } else {

                $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                $range_map['Range'] = $clean_range;
            }
            $throid_details['t_four_reference_ranges_value'] = $range_map;

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $throid_details['thyroxine_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code THYT4";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code THYT4" . FindTestgroupAddress('Thyroid 001');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $throid_details['thyroxine_test_remraks'] = "Thyroid Thyroxine (T4) - " . $resultData->TEST_REMARKS;
            } else {
                $throid_details['thyroxine_test_remraks'] = '';
            }
            $throid_details['thyroxine_sample_method'] = $resultData->NEW_METHOD;
            if ($throid_details['thyroxine_result_value_cleaned'] <  $throid_details['t_four_low_result_value']) {
                $throid_details['thyroxine_result_value_in_words'] = 'Low';
                $throid_details['thyroxine_color_code'] = "red";
            }
            if ($throid_details['thyroxine_result_value_cleaned'] >=  $throid_details['t_four_low_result_value'] && $throid_details['thyroxine_result_value_cleaned'] <= $throid_details['t_four_high_result_value']) {
                $throid_details['thyroxine_result_value_in_words'] = 'Normal';
                $throid_details['thyroxine_color_code'] = "green";
            }
            if ($throid_details['thyroxine_result_value_cleaned'] > $throid_details['t_four_high_result_value']) {
                $throid_details['thyroxine_result_value_in_words'] = 'High';
                $throid_details['thyroxine_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($throid_details['thyroxine_result_value_cleaned'] < $throid_details['t_four_low_result_value'] || $throid_details['thyroxine_result_value_cleaned'] > $throid_details['t_four_high_result_value']) {
                $throid_details['thyroxine_impact_on_health'] = "Thyroxine (T4) is synthesized in the thyroid gland. High T4 are seen in hyperthyroidism and in patients with acute thyroiditis.Low T4 are seen in hypothyroidism, myxedema, cretinism, chronic thyroiditis, and occasionally, subacute thyroiditis. Increased total thyroxine (T4) is seen in pregnancy and patients who are on estrogen medication. These patients have increased total T4 levels due to increased thyroxine-binding globulin (TBG) levels. Decreased total T4 is seen in patients on treatment with anabolic steroids or nephrosis (decreased TBG levels)";
            } else {
                $throid_details['thyroxine_impact_on_health'] = '';
            }
            if ($throid_details['thyroxine_result_value_cleaned'] < $throid_details['t_four_low_result_value'] || $throid_details['thyroxine_result_value_cleaned'] > $throid_details['t_four_high_result_value']) {
                $throid_details['thyroxine_suggestion'] = "Thyroid hormone levels can be brought to normal in a many ways and each treatment will depend on the cause of your thyroid condition.If you have hyperthyroidism,treatment options can include:Anti-thyroid drugs,beta blockers,radioactive iodine,surgery.If you have hypothyroidism the main treatment option is Thyroid replacement medication";
            } else {
                $throid_details['thyroxine_suggestion'] = '';
            }
        }
    }
    if (!$thyroxine_found) {

        $report_issues[] = " Test Group 'Thyroid 001' or Test Code 'THYT4' not found";
        $report_issues_email[] = " Test Group 'Thyroid 001' or Test Code 'THYT4' not found" . FindTestgroupAddress('Thyroid 001');
    }

    // Thyroid Stimulating Hormone (TSH) sub test
    $tsh_test_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Thyroid 001' && explode('|', $resultData->TEST_CODE)[0] == 'PNSTSH') {
            $tsh_test_found = true;
            $throid_details['tsh_result_value'] = $resultData->RESULT_VALUE;
            $throid_details['tsh_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $throid_details['tsh_result_value']);
            if (($throid_details['tsh_result_value'] ?? null) === '' || ($throid_details['tsh_result_value'] ?? null) === null) {
                $report_issues[] = "Thyroid Stimulating Hormone (TSH) TestResultDetails are empty";
                $report_issues_email[] = "Thyroid Stimulating Hormone (TSH) TestResultDetails are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['tsh_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $throid_details['tsh_uom'] = str_replace(["�", "ï¿½"], "u", $throid_details['tsh_uom']);
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Thyroid Stimulating Hormone (TSH) BR Interval are empty";
                $report_issues_email[] = "  Thyroid Stimulating Hormone (TSH) BR Interval are empty" . FindTestgroupAddress('Thyroid 001');
            }
            $throid_details['tsh_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            $BRInterval = trim($throid_details['tsh_BRInterval_result_value']);
            $lines = explode("\n", trim($BRInterval));
            $range_map = [];
            $extra_info = [];
            $invalid_lines = [];
            $reference_data = [];
            $main_range = null;

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;

                if (strpos($line, ':') !== false) {
                    [$label, $range] = explode(':', $line, 2);
                    $label = trim($label);
                    $range = trim($range);

                    $reference_data[$label] = $range;

                    $lc_label = strtolower($label);
                    if ($range === '') {
                        $extra_info[] = $label;
                    } elseif (
                        preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $range) ||
                        preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $range)
                    ) {
                        $range_map[$lc_label] = $range;
                        if ($lc_label === 'non pregnant' || $lc_label === 'nonpregnant') {
                            $main_range = $range; // prioritize "Non Pregnant" for evaluation
                        }
                    } else {
                        $invalid_lines[] = $line;
                    }
                } else {
                    if (
                        preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $line) ||
                        preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $line)
                    ) {
                        $range_map['normal'] = $line;
                        $reference_data['Range'] = $line;
                        $main_range = $line; // for simple cases like "0.7 - 2.04"
                    } elseif (!preg_match('/^[a-z\s&0-9]+$/i', $line)) {
                        $invalid_lines[] = $line;
                    } else {
                        $extra_info[] = strtolower($line);
                        $reference_data[$line] = '';
                    }
                }
            }
            if (empty($invalid_lines) || (count($invalid_lines) > 0 && strpos($BRInterval, 'Pregnancy:') !== false) || strpos($BRInterval, 'Pregnancy') !== false || strpos($BRInterval, 'pregnancy') !== false || strpos($BRInterval, 'pregnancy:') !== false) {
                $invalid_lines = [];
            } else {
                if (!empty($invalid_lines)) {
                    $invalids = array_map('htmlspecialchars', $invalid_lines);
                    $report_issues[] = "The BRinterval sequence is incorrect for" . $resultData->TEST_CODE;
                    $report_issues_email[] = "The BRinterval sequence is incorrect for" . $resultData->TEST_CODE . FindTestgroupAddress('Thyroid 001');
                }
            }

            $throid_details['tsh_result_value_in_words'] = '';
            $throid_details['tsh_color_code'] = 'gray';
            $throid_details['tsh_thumbs_color'] = '';
            $matched = false;

            // Priority 1: Evaluate from named categories
            foreach ($range_map as $label => $range) {
                if (tshmatchesRange($throid_details['tsh_result_value_cleaned'], $range)) {
                    if (in_array($label, ['euthyroid', 'normal'])) {
                        $throid_details['tsh_color_code'] = 'green';
                        $throid_details['tsh_impact_on_health'] = '';
                        $throid_details['tsh_result_value_in_words'] = ucwords($label);
                    } elseif (in_array($label, ['non pregnant', 'nonpregnant'])) {
                        if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
                            $low = (float)$match[1];
                            $high = (float)$match[3];
                            if ($throid_details['tsh_result_value_cleaned'] < $low) {
                                $throid_details['tsh_result_value_in_words'] = 'Low';
                                $throid_details['tsh_color_code'] = 'red';
                                $throid_details['tsh_impact_on_health'] = '
                                <span style="font-weight: 700;"> Decreased levels:</span> Hyperthyroidism( Primary /
                            Secondary) , Autoimmune thyroiditis, goiter,
                            Hyperthyroidism during pregnancy,Thyroxine over dosage.</br>
                            <span style="font-weight: 700;"> levels: </span>Transient Hypothyroidism, Primary
                            Hypothyroidism, Central Hypothyroidism.
                            </p>';
                            } elseif ($throid_details['tsh_result_value_cleaned'] > $high) {
                                $throid_details['tsh_result_value_in_words'] = 'High';
                                $throid_details['tsh_color_code'] = 'red';
                                $throid_details['tsh_impact_on_health'] = '
                                <span style="font-weight: 700;"> Decreased levels:</span> Hyperthyroidism( Primary /
                            Secondary) , Autoimmune thyroiditis, goiter,
                            Hyperthyroidism during pregnancy,Thyroxine over dosage.</br>
                            <span style="font-weight: 700;"> levels: </span>Transient Hypothyroidism, Primary
                            Hypothyroidism, Central Hypothyroidism.
                            </p>';
                            } else {
                                $throid_details['tsh_result_value_in_words'] = 'Normal';
                                $throid_details['tsh_color_code'] = 'green';
                                $throid_details['tsh_impact_on_health'] = '';
                            }
                        } else {
                            // fallback if range format is invalid
                            $throid_details['tsh_result_value_in_words'] = 'Normal';
                            $throid_details['tsh_color_code'] = 'green';
                            $throid_details['tsh_impact_on_health'] = '';
                        }
                    } else {
                        $throid_details['tsh_color_code'] = 'red';
                        $throid_details['tsh_result_value_in_words'] = ucwords($label);
                        $throid_details['tsh_impact_on_health'] = '
                                <span style="font-weight: 700;"> Decreased levels:</span> Hyperthyroidism( Primary /
                            Secondary) , Autoimmune thyroiditis, goiter,
                            Hyperthyroidism during pregnancy,Thyroxine over dosage.</br>
                            <span style="font-weight: 700;"> levels: </span>Transient Hypothyroidism, Primary
                            Hypothyroidism, Central Hypothyroidism.
                            </p>';
                    }
                    $matched = true;
                    break;
                }
            }
            // Priority 2: Use main_range if no label match (for simple or Non Pregnant cases)
            if (!$matched && $main_range) {
                if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $main_range, $match)) {
                    $low = (float)$match[1];
                    $high = (float)$match[3];

                    if ($throid_details['tsh_result_value_cleaned'] < $low) {
                        $throid_details['tsh_result_value_in_words'] = 'Low';
                        $throid_details['tsh_color_code'] = 'red';
                        $throid_details['tsh_impact_on_health'] = '
                                <span style="font-weight: 700;"> Decreased levels:</span> Hyperthyroidism( Primary /
                            Secondary) , Autoimmune thyroiditis, goiter,
                            Hyperthyroidism during pregnancy,Thyroxine over dosage.</br>
                            <span style="font-weight: 700;"> levels: </span>Transient Hypothyroidism, Primary
                            Hypothyroidism, Central Hypothyroidism.
                            </p>';
                    } elseif ($throid_details['tsh_result_value_cleaned'] > $high) {
                        $throid_details['tsh_result_value_in_words'] = 'High';
                        $throid_details['tsh_color_code'] = 'red';
                        $throid_details['tsh_impact_on_health'] = '
                                <span style="font-weight: 700;"> Decreased levels:</span> Hyperthyroidism( Primary /
                            Secondary) , Autoimmune thyroiditis, goiter,
                            Hyperthyroidism during pregnancy,Thyroxine over dosage.</br>
                            <span style="font-weight: 700;"> levels: </span>Transient Hypothyroidism, Primary
                            Hypothyroidism, Central Hypothyroidism.
                            </p>';
                    } else {
                        $throid_details['tsh_result_value_in_words'] = 'Normal';
                        $throid_details['tsh_color_code'] = 'green';
                        $throid_details['tsh_impact_on_health'] = '';
                    }

                    $matched = true;
                }
            }


            // Assign image
            if ($throid_details['tsh_color_code'] === 'green') {
                $throid_details['tsh_thumbs_color'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
            } elseif (in_array($throid_details['tsh_color_code'], ['orange', 'red'])) {
                $throid_details['tsh_thumbs_color'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$throid_details['tsh_color_code']}-thumb.png";
            }

            // Display reference data
            $throid_details['tsh_reference_ranges_value'] = $reference_data;


            if ($throid_details['tsh_result_value_in_words'] == '' ||  $throid_details['tsh_color_code'] == 'gray') {

                $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('Thyroid 001');
            }
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $throid_details['tsh_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code PNSTSH";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Thyroid 001 and test code PNSTSH" . FindTestgroupAddress('Thyroid 001');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $throid_details['tsh_test_remraks'] = "Thyroid Stimulating Hormone (TSH) - " . $resultData->TEST_REMARKS;
            } else {
                $throid_details['tsh_test_remraks'] = '';
            }

            $throid_details['tsh_sample_method'] = $resultData->NEW_METHOD;
        }
    }
    if (!$tsh_test_found) {

        $report_issues[] = " Test Group 'Thyroid 001' or Test Code 'PNSTSH' not found";
        $report_issues_email[] = " Test Group 'Thyroid 001' or Test Code 'PNSTSH' not found" . FindTestgroupAddress('Thyroid 001');
    }
    return $throid_details;
}

function tshcompare($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Helper: Match value against a range
function tshmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return tshcompare($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}
/**
 * Description: The getThyroidTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for thyroid-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getThyroidTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $ThyroidNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE === 'Thyroid 001') {
            if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Thyroid 001";
                $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Thyroid 001" . FindTestgroupAddress('Thyroid 001');
            }
            $ThyroidNablAccredited['Thyroid_001_thyroid_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
            $ThyroidNablAccredited['Thyroid_001_thyroid_remarks'] = $resultData->SERVICE_REMARKS ?: "";
        }
    }

    return $ThyroidNablAccredited;
}

/**
 * Description : getKidneyDetails() function to get test result details for the kidney section.
 * 
 * This function retrieves kidney-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to kidney diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the kidney section.
 */


function getKidneyDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $kidney_details = [];
    // Urea sub test
    $urea_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'UREA') {
            $urea_result_found = true;
            $kidney_details['urea_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['urea_result_value'] ?? null) === '' || ($kidney_details['urea_result_value'] ?? null) === null) {

                $report_issues[] = "Urea TestResultDetails are empty";
                $report_issues_email[] = "Urea TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['urea_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['urea_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['urea_uom']);

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Urea  reference ranges are empty";
                $report_issues_email[] = " Urea  reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
            }

            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Urea BR Interval are empty";
                $report_issues_email[] = "  Urea BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
            }

            $kidney_details['urea_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['urea_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['urea_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['urea_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code UREA";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code UREA" . FindTestgroupAddress('RFT-Basic');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['urea_test_remraks'] = "Urea - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['urea_test_remraks'] = '';
            }

            $kidney_details['urea_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['urea_low_result_value']) {
                $kidney_details['urea_result_value_in_words'] = 'Low';
                $kidney_details['urea_result_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['urea_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['urea_high_result_value']) {
                $kidney_details['urea_result_value_in_words'] = 'Normal';
                $kidney_details['urea_result_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $kidney_details['urea_high_result_value']) {
                $kidney_details['urea_result_value_in_words'] = 'High';
                $kidney_details['urea_result_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['urea_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['urea_high_result_value']) {
                $kidney_details['urea_impact_on_health'] = "Healthy kidneys remove more than 90% of the urea the body produces, so blood levels can show how well your
                kidneys are working. Most diseases that affect the kidneys or liver can affect the amount of urea present in the blood. If increased
                amounts of urea are produced by the liver or decreased amounts are removed by the kidneys then blood urea concentrations will rise. If
                significant liver damage or disease reduces the production of urea then urea concentrations may fall";
            } else {
                $kidney_details['urea_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE <= $kidney_details['urea_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['urea_high_result_value']) {
                $kidney_details['urea_suggestions'] = "If the test results are outside the standard range, you might need further testing to determine the
                diagnosis";
            } else {
                $kidney_details['urea_suggestions'] = '';
            }
        }
    }
    if (!$urea_result_found) {

        $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'UREA' not found";
        $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'UREA' not found" . FindTestgroupAddress('RFT-Basic');
    }


    // Creatinine sub test
    $creatinine_result_male_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'CREATININE') {
            $creatinine_result_male_found = true;
            $kidney_details['creatinine_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['creatinine_result_value'] ?? null) === '' || ($kidney_details['creatinine_result_value'] ?? null) === null) {
                $report_issues[] = "Creatinine TestResultDetails are empty";
                $report_issues_email[] = "Creatinine TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['creatinine_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['creatinine_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['creatinine_uom']);

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Creatinine reference ranges are empty";
                $report_issues_email[] = " Creatinine reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Creatinine BR Interval are empty";
                $report_issues_email[] = "  Creatinine BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
            }

            $kidney_details['creatinine_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['creatinine_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['creatinine_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));



            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['creatinine_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code CREATININE";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code CREATININE" . FindTestgroupAddress('RFT-Basic');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['creatinine_test_remraks'] = "Creatinine - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['creatinine_test_remraks'] = '';
            }
            $kidney_details['creatinine_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['creatinine_low_result_value']) {
                $kidney_details['creatinine_result_value_in_words'] = 'Low';
                $kidney_details['creatinine_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['creatinine_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['creatinine_high_result_value']) {
                $kidney_details['creatinine_result_value_in_words'] = 'Normal';
                $kidney_details['creatinine_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $kidney_details['creatinine_high_result_value']) {
                $kidney_details['creatinine_result_value_in_words'] = 'High';
                $kidney_details['creatinine_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['creatinine_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['creatinine_high_result_value']) {
                $kidney_details['creatinine_impact_on_health'] = "Increased levels of serum creatinine is seen in Chronic kidney disease,kidney obstruction,Dehydration,Increased
                    consumption of protein and usage of certain drugs like Antibiotics and Cimetidine.Decreased levels of serum creatinine is seen in
                    Pregnancy and extreme weight loss.In cases of kidney failure, dialysis may be required in addition to medications";
            } else {
                $kidney_details['creatinine_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $kidney_details['creatinine_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['creatinine_high_result_value']) {
                $kidney_details['creatinine_suggestions'] = "Medications can help resolve high creatinine levels by treating the condition that’s causing the
                    increase. Some examples include antibiotics for a kidney infection or medications that help control high blood pressure";
            } else {
                $kidney_details['creatinine_suggestions'] = '';
            }
        }
    }
    if (!$creatinine_result_male_found) {
        $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'CREATININE' not  found";
        $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'CREATININE' not  found" . FindTestgroupAddress('RFT-Basic');
    }



    // Uric Acid sub test
    $uricacid_result_male_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' &&  explode('|', $resultData->TEST_CODE)[0] == 'URICACID') {
            $uricacid_result_male_found = true;
            $kidney_details['uricacid_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['uricacid_result_value'] ?? null) === '' || ($kidney_details['uricacid_result_value'] ?? null) === null) {
                $report_issues[] = "Uric Acid TestResultDetails are empty";
                $report_issues_email[] = "Uric Acid TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['uricacid_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['uricacid_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['uricacid_uom']);
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Uric Acid reference ranges are empty";
                $report_issues_email[] = " Uric Acid reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Uric Acid BR Interval are empty";
                $report_issues_email[] = "  Uric Acid BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['uric_acid_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['uric_acid_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['uric_acid_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['uricacid_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code URICACID";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code URICACID" . FindTestgroupAddress('RFT-Basic');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['uricacid_test_remraks'] = "Uric Acid  - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['uricacid_test_remraks'] = '';
            }
            $kidney_details['uricacid_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['uric_acid_low_result_value']) {
                $kidney_details['uricacid_result_value_in_words'] = 'Low';
                $kidney_details['uricacid_color_code'] = "red";
            }
            if (
                $resultData->RESULT_VALUE >= $kidney_details['uric_acid_low_result_value'] &&
                $resultData->RESULT_VALUE <= $kidney_details['uric_acid_high_result_value']
            ) {
                $kidney_details['uricacid_result_value_in_words'] = 'Normal';
                $kidney_details['uricacid_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE >  $kidney_details['uric_acid_high_result_value']) {
                $kidney_details['uricacid_result_value_in_words'] = 'High';
                $kidney_details['uricacid_color_code'] = "red";
            }

            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['uric_acid_low_result_value'] || $resultData->RESULT_VALUE >  $kidney_details['uric_acid_high_result_value']) {
                $kidney_details['uricacid_impact_on_health'] = "The major causes of hyperuricemia are increased purine synthesis, inherited metabolic disorder, excess dietary
                    purine intake, increased nucleic acid turnover, malignancy, cytotoxic drugs, and decreased excretion due to chronic renal failure or
                    increased renal reabsorption";
            } else {
                $kidney_details['uricacid_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $kidney_details['uric_acid_low_result_value'] || $resultData->RESULT_VALUE >  $kidney_details['uric_acid_high_result_value']) {
                $kidney_details['uricacid_suggestions'] = "(1) Losing weight, if necessary (2) Watching what you eat (limit your intake of organ meats, red
                    meat, fish, and alcoholic beverages. (3) A lifelong urate-lowering therapy may be needed, with medications that prevent gout flares
                    and ultimately dissolve crystals that are already in your body";
            } else {
                $kidney_details['uricacid_suggestions'] = '';
            }
        }
    }
    if (!$uricacid_result_male_found) {
        $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'URICACID' not found";
        $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'URICACID' not found" . FindTestgroupAddress('RFT-Basic');
    }
    // Calcium sub test
    $calcium_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'PNR0520') {
            $calcium_result_found = true;
            $kidney_details['calcium_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['calcium_result_value'] ?? null) === '' || ($kidney_details['calcium_result_value'] ?? null) === null) {
                $report_issues[] = "Calcium TestResultDetails are empty";
                $report_issues_email[] = "Calcium TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['calcium_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['calcium_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['calcium_uom']);

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " calcium reference ranges are empty";
                $report_issues_email[] = " calcium reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  calcium BR Interval are empty";
                $report_issues_email[] = "  calcium BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['calcium_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['calcium_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['calcium_BRInterval_result_value'] = trim(nl2br($resultData->BRInterval));
            $range_map = [];
            $brInterval = trim($kidney_details['calcium_BRInterval_result_value']);
            if (strpos($brInterval, ':') !== false) {
                $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                foreach ($intervals as $interval) {
                    if (strpos($interval, ':') !== false) {
                        [$label, $range] = explode(':', $interval, 2);
                        $label = strtolower(trim($label));
                        // Trim commas and whitespace from start and end of range
                        $range = trim($range, " \t\n\r\0\x0B,");
                        $range_map[$label] = $range;
                    }
                }
            } else {
                // Also clean single range
                $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                $range_map['Range'] = $clean_range;
            }
            $kidney_details['calcium_reference_ranges_value'] = $range_map;
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['calcium_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code PNR0520";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code PNR0520" . FindTestgroupAddress('RFT-Basic');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['calcium_test_remraks'] = "Calcium  - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['calcium_test_remraks'] = '';
            }

            $kidney_details['calcium_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['calcium_low_result_value']) {
                $kidney_details['calcium_result_value_in_words'] = 'Low';
                $kidney_details['calcium_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['calcium_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['calcium_high_result_value']) {
                $kidney_details['calcium_result_value_in_words'] = 'Normal';
                $kidney_details['calcium_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $kidney_details['calcium_high_result_value']) {
                $kidney_details['calcium_result_value_in_words'] = 'High';
                $kidney_details['calcium_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['calcium_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['calcium_high_result_value']) {
                $kidney_details['calcium_impact_on_health'] = "<span style='font-weight:bold'>High calcium levels may indicate:</span> Hyperparathyroidism, Paget'disease, Overuse of antacids, Excessive intake of calcium from vitamin
                D supplements or milk or Certain types of cancer.<br/>
                <span style='font-weight:bold'>lower than normal calcium levels may indicate:</span> Hypoparathyroidism, Vitamin D deficiency, Magnesium deficiency,Inflammation of the
                pancreas (pancreatitis) or Kidney disease";
            } else {
                $kidney_details['calcium_impact_on_health'] = '';
            }
            /*if ($resultData->RESULT_VALUE >0) {
                $kidney_details['calcium_impact_on_health'] = "<span style='font-weight:bold'>High calcium levels may indicate:</span> Hyperparathyroidism, Paget'disease, Overuse of antacids, Excessive intake of calcium from vitamin
                D supplements or milk or Certain types of cancer.<br/>
                <span style='font-weight:bold'>lower than normal calcium levels may indicate:</span> Hypoparathyroidism, Vitamin D deficiency, Magnesium deficiency,Inflammation of the
                pancreas (pancreatitis) or Kidney disease";
            } else {
                $kidney_details['calcium_impact_on_health'] = '';
            }*/
            if ($resultData->RESULT_VALUE < $kidney_details['calcium_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['calcium_high_result_value']) {
                $kidney_details['calcium_suggestions'] = "Calcium and Vitamin D supplements can help in increaing calcium levelsGood sources of
                calcium include milk, cheese, yogurt, soy products, sardines, canned salmon, fortified cereal, and dark leafy greens";
            } else {
                $kidney_details['calcium_suggestions'] = '';
            }
        }
    }
    if (!$calcium_result_found) {
        $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'PNR0520' not found";
        $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'PNR0520' not found" . FindTestgroupAddress('RFT-Basic');
    }

    if ($PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_025') {
        //EGFR sub test
        $egfr_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'EGFR') {
                $egfr_result_found = true;
                $kidney_details['egfr_result_value'] = $resultData->RESULT_VALUE;
                if (($kidney_details['egfr_result_value'] ?? null) === '' || ($kidney_details['egfr_result_value'] ?? null) === null) {
                    $report_issues[] = " EGFR TestResultDetails are empty";
                    $report_issues_email[] = " EGFR TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
                }
                $kidney_details['egfr_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $kidney_details['egfr_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['egfr_uom']);

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $kidney_details['egfr_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code EGFR";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code EGFR" . FindTestgroupAddress('RFT-Basic');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $kidney_details['egfr_test_remraks'] = "eGFR  - " . $resultData->TEST_REMARKS;
                } else {
                    $kidney_details['egfr_test_remraks'] = '';
                }
                $kidney_details['egfr_sample_method'] = $resultData->NEW_METHOD;
                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {
                    $report_issues[] = " EGFR BR Interval are empty";
                    $report_issues_email[] = " EGFR BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
                }
                $kidney_details['egfr_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($kidney_details['egfr_BRInterval_result_value']));

                $range_map = [];

                validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
                // Dynamic color and image map based on position
                $thumb_colors = ['green', 'orange', 'orange', 'red', 'red'];
                $range_map_count = count($range_map);
                $thumb_colors_count = count($thumb_colors);

                if ($thumb_colors_count !== $range_map_count) {
                    $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
                    $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('RFT-Basic');
                }
                $kidney_details['egfr_reference_ranges_value'] = $range_map;
                // Comparison without eval

                $kidney_details['egfr_result_value_in_words'] = '';
                $kidney_details['egfr_color_code'] = 'gray';
                $kidney_details['egfr_thumb_up_icon'] = '';

                $index = 0;
                foreach ($range_map as $label => $range) {
                    if (egfrmatchesRange($kidney_details['egfr_result_value'], $range)) {
                        $kidney_details['egfr_result_value_in_words'] = ucwords($label);
                        $kidney_details['egfr_color_code'] = $thumb_colors[$index] ?? 'gray';


                        if ($kidney_details['egfr_color_code'] === 'green') {
                            $kidney_details['egfr_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $kidney_details['egfr_impact_on_health'] = '';
                        } elseif ($kidney_details['egfr_color_code'] !== 'gray') {
                            $kidney_details['egfr_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$kidney_details['egfr_color_code']}-thumb.png";
                            $kidney_details['egfr_impact_on_health'] = "An eGFR test can help identify serious kidney disease and failure. In response to a wide range of symptoms, an eGFR test can help determine if your kidneys are working properly.Sometimes kidney disease does not cause immediate symptoms. In these cases, testing with eGFR may enable an earlier diagnosis and improved ability to slow the progression of the disease";
                        } else {
                            $kidney_details['egfr_thumb_up_icon'] = '';
                        }

                        break;
                    }
                    $index++;
                }

                if ($kidney_details['egfr_result_value_in_words'] == '' ||  $kidney_details['egfr_color_code'] == 'gray') {
                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . FindTestgroupAddress('RFT-Basic');
                }
            }
        }
        if (!$egfr_result_found) {
            $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'EGFR' not found";
            $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'EGFR' not found" . FindTestgroupAddress('RFT-Basic');
        }
    }

    // Rheumatoid Factor (RA) Qualitative, Serum(Ayushman Vital Package)
        if ($PackageCode == 'AYN_026') {
            $ra_factror_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'R0004' &&  explode('|', $resultData->TEST_CODE)[0] == 'RA') {
            $ra_factror_found = true;
            $kidney_details['ra_factror_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['ra_factror_value'] ?? null) === '' || ($kidney_details['ra_factror_value'] ?? null) === null) {
                $report_issues[] = "RA Factor TestResultDetails are empty";
                $report_issues_email[] = "RA Factor TestResultDetails are empty" . FindTestgroupAddress('R0004');
            }
            $kidney_details['ra_factror_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['ra_factror_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['ra_factror_uom']);
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " RA Factor reference ranges are empty";
                $report_issues_email[] = " RA Factor reference ranges are empty" . FindTestgroupAddress('R0004');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  RA Factor BR Interval are empty";
                $report_issues_email[] = "  RA Factor BR Interval are empty" . FindTestgroupAddress('R0004');
            }
            $kidney_details['ra_factror_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['ra_factror_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['ra_factror_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['ra_factror_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0004 and test code RA";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0004 and test code RA" . FindTestgroupAddress('R0004');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['ra_factror_test_remraks'] = "RA Factor  - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['ra_factror_test_remraks'] = '';
            }
            $kidney_details['ra_factror_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['ra_factror_low_result_value']) {
                $kidney_details['ra_factror_value_in_words'] = 'Low';
                $kidney_details['ra_factror_color_code'] = "red";
            }
            if (
                $resultData->RESULT_VALUE >= $kidney_details['ra_factror_low_result_value'] &&
                $resultData->RESULT_VALUE <= $kidney_details['ra_factror_high_result_value']
            ) {
                $kidney_details['ra_factror_value_in_words'] = 'Normal';
                $kidney_details['ra_factror_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE >  $kidney_details['ra_factror_high_result_value']) {
                $kidney_details['ra_factror_value_in_words'] = 'High';
                $kidney_details['ra_factror_color_code'] = "red";
            }

            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['ra_factror_low_result_value'] || $resultData->RESULT_VALUE >  $kidney_details['ra_factror_high_result_value']) {
                $kidney_details['ra_factror_impact_on_health'] = "High levels of rheumatoid factor in the blood are most often related to autoimmune diseases, such as rheumatoid arthritis ,Sjogren syndrome and other autuimmune diseases";
            } else {
                $kidney_details['ra_factror_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $kidney_details['ra_factror_low_result_value'] || $resultData->RESULT_VALUE >  $kidney_details['ra_factror_high_result_value']) {
                $kidney_details['ra_factror_suggestions'] = "";
            } else {
                $kidney_details['ra_factror_suggestions'] = '';
            }
        }
    }
        if (!$ra_factror_found) {
            $report_issues[] = " Test Group 'R0004e' or Test Name 'Rheumatoid Factor (RA) Qualitative, Serum' not found";
            $report_issues_email[] = "Test Group 'R0004e' or Test Name 'Rheumatoid Factor (RA) Qualitative, Serum' not found" . FindTestgroupAddress('RFT-Basic');
        }
        }
    // Blood Urea Nitrogen (BUN) sub test
    $blood_urea_nitrogen_result_found = false;

    if (!empty($reportJsonData->TestResultDetails)) {
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE === 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'BUN') {
                $blood_urea_nitrogen_result_found = true;

                $kidney_details['blood_urea_nitrogen_result_value'] = $resultData->RESULT_VALUE ?? '';

                // Check if result value is empty
                if (($kidney_details['blood_urea_nitrogen_result_value'] ?? null) === '' || ($kidney_details['blood_urea_nitrogen_result_value'] ?? null) === null) {
                    $report_issues[] = " Blood Urea Nitrogen (BUN) TestResultDetails are empty";
                    $report_issues_email[] = " Blood Urea Nitrogen (BUN) TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    $report_issues[] = " Blood urea nitrogen reference ranges are empty";
                    $report_issues_email[] = " Blood urea nitrogen reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Blood urea nitrogen BR Interval are empty";
                    $report_issues_email[] = "  Blood urea nitrogen BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
                }

                $kidney_details['blood_urea_nitrogen_low_result_value'] = $resultData->LOW_VALUE;
                $kidney_details['blood_urea_nitrogen_high_result_value'] = $resultData->HIGH_VALUE;
                $kidney_details['blood_urea_nitrogen_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $kidney_details['blood_urea_nitrogen_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $kidney_details['blood_urea_nitrogen_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['blood_urea_nitrogen_uom']);
                $range_map = [];
                $brInterval = trim($kidney_details['blood_urea_nitrogen_BRInterval_result_value']);
                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {

                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }

                $kidney_details['blood_urea_reference_ranges_value'] = $range_map;

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $kidney_details['blood_urea_nitrogen_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code BUN";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code BUN" . FindTestgroupAddress('RFT-Basic');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $kidney_details['blood_urea_nitrogen_test_remraks'] = "Blood Urea Nitrogen (BUN)  - " . $resultData->TEST_REMARKS;
                } else {
                    $kidney_details['blood_urea_nitrogen_test_remraks'] = '';
                }
                $kidney_details['blood_urea_nitrogen_sample_method'] = $resultData->NEW_METHOD;
                // Determine result range and set appropriate status
                if ($resultData->RESULT_VALUE <  $kidney_details['blood_urea_nitrogen_low_result_value']) {
                    $kidney_details['blood_urea_nitrogen_result_value_in_words'] = 'Low';
                    $kidney_details['blood_urea_nitrogen_color_code'] = "red";
                } elseif ($resultData->RESULT_VALUE >= $kidney_details['blood_urea_nitrogen_low_result_value']  && $resultData->RESULT_VALUE <= $kidney_details['blood_urea_nitrogen_high_result_value']) {
                    $kidney_details['blood_urea_nitrogen_result_value_in_words'] = 'Normal';
                    $kidney_details['blood_urea_nitrogen_color_code'] = "green";
                } else {
                    $kidney_details['blood_urea_nitrogen_result_value_in_words'] = 'High';
                    $kidney_details['blood_urea_nitrogen_color_code'] = "red";
                }
                // Health impact message for abnormal values
                if ($resultData->RESULT_VALUE < $kidney_details['blood_urea_nitrogen_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['blood_urea_nitrogen_high_result_value']) {
                    $kidney_details['blood_urea_nitrogen_impact_on_health'] =
                        "Serum urea levels increase in conditions where renal clearance decreases (in acute and chronic renal failure/impairment). It also increases in other conditions such as upper GI bleeding, dehydration, catabolic states, and high protein diets. Urea may be decreased in starvation, low-protein diet, and severe liver disease";
                    $kidney_details['blood_urea_nitrogen_suggestions'] =
                        "It is the laboratory test for detection and monitoring of kidney disease. The limitation of urea as a test of renal function relates to reduced sensitivity and specificity as there are other causes that can be associated with such a rise e.g., heart failure, dehydration is common. Further evaluation is required for increased serum urea levels";
                } else {
                    $kidney_details['blood_urea_nitrogen_impact_on_health'] = '';
                    $kidney_details['blood_urea_nitrogen_suggestions'] = '';
                }
            }
        }

        // Log message if no result is found
        if (!$blood_urea_nitrogen_result_found) {
            $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'BUN' not found";
            $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'BUN' not found" . FindTestgroupAddress('RFT-Basic');
        }
    }
    // BUN/Creatinine Ratio sub test
    $creatinine_ratio_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'RFT-Basic' && explode('|', $resultData->TEST_CODE)[0] == 'BUN/CRE') {
            $creatinine_ratio_result_found = true;
            $kidney_details['creatinine_ratio_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['creatinine_ratio_result_value'] ?? null) === '' || ($kidney_details['creatinine_ratio_result_value'] ?? null) === null) {

                $report_issues[] = "BUN/Creatinine Ratio TestResultDetails are empty";
                $report_issues_email[] = "BUN/Creatinine Ratio TestResultDetails are empty" . FindTestgroupAddress('RFT-Basic');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "creatinine ratio reference ranges are empty";
                $report_issues_email[] = "creatinine ratio reference ranges are empty" . FindTestgroupAddress('RFT-Basic');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  creatinine ratio BR Interval are empty";
                $report_issues_email[] = "  creatinine ratio BR Interval are empty" . FindTestgroupAddress('RFT-Basic');
            }
            $kidney_details['creatinine_ratio_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['creatinine_ratio_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['creatinine_ratio_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['creatinine_ratio_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['creatinine_ratio_uom']);
            $kidney_details['creatinine_ratio_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['creatinine_ratio_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code BUN/CRE";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code RFT-Basic and test code BUN/CRE" . FindTestgroupAddress('RFT-Basic');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['creatinine_ratio_test_remraks'] = "BUN/Creatinine Ratio - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['creatinine_ratio_test_remraks'] = '';
            }

            $kidney_details['creatinine_ratio_sample_method'] = $resultData->NEW_METHOD;
            $kidney_details['creatinine_ratio_sample_method'] = $resultData->NEW_METHOD;
            if ((float)$resultData->RESULT_VALUE < $kidney_details['creatinine_ratio_low_result_value']) {
                $kidney_details['creatinine_ratio_result_value_in_words'] = 'Low';
                $kidney_details['creatinine_ratio_color_code'] = "red";
            }
            if ((float)$resultData->RESULT_VALUE >= $kidney_details['creatinine_ratio_low_result_value'] && (float)$resultData->RESULT_VALUE <= $kidney_details['creatinine_ratio_high_result_value']) {
                $kidney_details['creatinine_ratio_result_value_in_words'] = 'Normal';
                $kidney_details['creatinine_ratio_color_code'] = "green";
            }
            if ((float)$resultData->RESULT_VALUE > $kidney_details['creatinine_ratio_high_result_value']) {
                $kidney_details['creatinine_ratio_result_value_in_words'] = 'High';
                $kidney_details['creatinine_ratio_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ((float)$resultData->RESULT_VALUE < $kidney_details['creatinine_ratio_low_result_value'] || (float)$resultData->RESULT_VALUE > $kidney_details['creatinine_ratio_high_result_value']) {
                $kidney_details['creatinine_ratio_impact_on_health'] = "The BUN/Creatinine ratio is useful in the differential diagnosis of acute or chronic renal disease. Reduced renal
                        perfusion, e.g. congestive heart failure or recent onset of urinary tract obstruction, will result in an increase in BUN/Creatinine ratio.
                        Increased urea formation also results in an increase in the ratio, e.g. gastrointestinal bleeding, trauma, etc. When there is decreased
                        formation of urea, as seen in liver disease, there is a decrease in the BUN/Creatinine ratio. In most cases of chronic renal disease, the
                        ratio remains relatively normal";
            } else {
                $kidney_details['creatinine_ratio_impact_on_health'] = '';
            }
            if ((float)$resultData->RESULT_VALUE > 23.5) {
                $kidney_details['creatinine_ratio_suggestions'] = "Please consult your physician for personalized medical advice";
            } else {
                $kidney_details['creatinine_ratio_suggestions'] = '';
            }
        }
    }
    if (!$creatinine_ratio_result_found) {

        $report_issues[] = " Test Group 'RFT-Basic' or Test Code 'BUN/CRE' not found";
        $report_issues_email[] = " Test Group 'RFT-Basic' or Test Code 'BUN/CRE' not found" . FindTestgroupAddress('RFT-Basic');
    }
    // Magnesium,magnesium Serum(Ayushman Wellness)
    if ($PackageCode == 'AYN_017' || $PackageCode == 'AYN_018' || $PackageCode == 'AYN_021' || $PackageCode == 'AYN_022' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030') {
        $magnesium_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'M0001' && explode('|', $resultData->TEST_CODE)[0] == 'Mag') {
                $magnesium_result_found = true;
                $kidney_details['magnesium_result_value'] = $resultData->RESULT_VALUE;
                if (($kidney_details['magnesium_result_value'] ?? null) === '' || ($kidney_details['magnesium_result_value'] ?? null) === null) {

                    $report_issues[] = "Magnesium,magnesium Serum TestResultDetails are empty";
                    $report_issues_email[] = "Magnesium,magnesium Serum TestResultDetails are empty" . FindTestgroupAddress('M0001');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = "magnesium reference ranges are empty";
                    $report_issues_email[] = "magnesium reference ranges are empty" . FindTestgroupAddress('M0001');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Magnesium BR Interval are empty";
                    $report_issues_email[] = "  Magnesium BR Interval are empty" . FindTestgroupAddress('M0001');
                }
                $kidney_details['magnesium_low_result_value'] = $resultData->LOW_VALUE;
                $kidney_details['magnesium_high_result_value'] = $resultData->HIGH_VALUE;
                $kidney_details['magnesium_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $kidney_details['magnesium_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['magnesium_uom']);
                $kidney_details['magnesium_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                $brInterval = trim($kidney_details['magnesium_BRInterval_result_value']);
                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {

                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }
                $kidney_details['magnesium_reference_ranges_value'] = $range_map;

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $kidney_details['magnesium_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code M0001 and test code Mag";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code M0001 and test code Mag" . FindTestgroupAddress('M0001');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $kidney_details['magnesium_test_remraks'] = "Magnesium - " . $resultData->TEST_REMARKS;
                } else {
                    $kidney_details['magnesium_test_remraks'] = '';
                }

                $kidney_details['magnesium_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $kidney_details['magnesium_low_result_value']) {
                    $kidney_details['magnesium_result_value_in_words'] = 'Low';
                    $kidney_details['magnesium_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $kidney_details['magnesium_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['magnesium_high_result_value']) {
                    $kidney_details['magnesium_result_value_in_words'] = 'Normal';
                    $kidney_details['magnesium_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $kidney_details['magnesium_high_result_value']) {
                    $kidney_details['magnesium_result_value_in_words'] = 'High';
                    $kidney_details['magnesium_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $kidney_details['magnesium_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['magnesium_high_result_value']) {
                    $kidney_details['magnesium_impact_on_health'] = "An electrolyte imbalance may be a sign of a heart, lung or kidney problem. Dehydration also causes electrolyte imbalances";
                } else {
                    $kidney_details['magnesium_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > $kidney_details['magnesium_high_result_value']) {
                    $kidney_details['magnesium_suggestions'] = "";
                } else {
                    $kidney_details['magnesium_suggestions'] = '';
                }
            }
        }
        if (!$magnesium_result_found) {

            $report_issues[] = " Test Group 'M0001' or Test Code 'Mag' not found";
            $report_issues_email[] = " Test Group 'M0001' or Test Code 'Mag' not found" . FindTestgroupAddress('M0001');
        }
    }
    // ELECTROLYTES Sodium (Na+), Serum

    $sodium_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Electrolyte' && explode('|', $resultData->TEST_CODE)[0] == 'SOD') {
            $sodium_result_found = true;
            $kidney_details['sodium_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['sodium_result_value'] ?? null) === '' || ($kidney_details['sodium_result_value'] ?? null) === null) {

                $report_issues[] = "ELECTROLYTES Sodium (Na+), Serum TestResultDetails are empty";
                $report_issues_email[] = "ELECTROLYTES Sodium (Na+), Serum TestResultDetails are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "Sodium reference ranges are empty";
                $report_issues_email[] = "Sodium reference ranges are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Sodium BR Interval are empty";
                $report_issues_email[] = "  Sodium BR Interval are empty" . FindTestgroupAddress('Electrolyte');
            }
            $kidney_details['sodium_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['sodium_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['sodium_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['sodium_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['sodium_uom']);

            $kidney_details['sodium_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['sodium_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code SOD";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code SOD" . FindTestgroupAddress('Electrolyte');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['sodium_test_remraks'] = "Sodium (Na+), Serum - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['sodium_test_remraks'] = '';
            }

            $kidney_details['sodium_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['sodium_low_result_value']) {
                $kidney_details['sodium_result_value_in_words'] = 'Low';
                $kidney_details['sodium_result_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['sodium_low_result_value'] && $resultData->RESULT_VALUE <=  $kidney_details['sodium_high_result_value']) {
                $kidney_details['sodium_result_value_in_words'] = 'Normal';
                $kidney_details['sodium_result_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE >  $kidney_details['sodium_high_result_value']) {
                $kidney_details['sodium_result_value_in_words'] = 'High';
                $kidney_details['sodium_result_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['sodium_low_result_value'] || $resultData->RESULT_VALUE >  $kidney_details['sodium_high_result_value']) {
                $kidney_details['sodium_impact_on_health'] = "An electrolyte imbalance may be a sign of a heart, lung or kidney problem. Dehydration also causes electrolyte imbalances";
            } else {
                $kidney_details['sodium_impact_on_health'] = '';
            }

            if ($resultData->RESULT_VALUE <  $kidney_details['sodium_high_result_value']) {
                $kidney_details['sodium_suggestions'] = "";
            } else {
                $kidney_details['sodium_suggestions'] = '';
            }
        }
    }
    if (!$sodium_result_found) {

        $report_issues[] = " Test Group 'Electrolyte' or Test Code 'SOD' not found";
        $report_issues_email[] = " Test Group 'Electrolyte' or Test Code 'SOD' not found" . FindTestgroupAddress('Electrolyte');
    }

    // ELECTROLYTES Potassium (K+), Serum

    $potassium_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Electrolyte' && explode('|', $resultData->TEST_CODE)[0] == 'POT') {
            $potassium_result_found = true;
            $kidney_details['potassium_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['potassium_result_value'] ?? null) === '' || ($kidney_details['potassium_result_value'] ?? null) === null) {

                $report_issues[] = "ELECTROLYTES Potassium (K+), Serum TestResultDetails are empty";
                $report_issues_email[] = "ELECTROLYTES Potassium (K+), Serum TestResultDetails are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "Potassium reference ranges are empty";
                $report_issues_email[] = "Potassium reference ranges are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Potassium BR Interval are empty";
                $report_issues_email[] = "  Potassium BR Interval are empty" . FindTestgroupAddress('Electrolyte');
            }
            $kidney_details['potassium_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['potassium_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['potassium_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['potassium_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['potassium_uom']);
            $kidney_details['potassium_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['potassium_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code POT";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code POT" . FindTestgroupAddress('Electrolyte');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['potassium_test_remraks'] = "Potassium (K+), Serum - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['potassium_test_remraks'] = '';
            }
            $kidney_details['potassium_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['potassium_low_result_value']) {
                $kidney_details['potassium_result_value_in_words'] = 'Low';
                $kidney_details['potassium_result_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['potassium_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['potassium_high_result_value']) {
                $kidney_details['potassium_result_value_in_words'] = 'Normal';
                $kidney_details['potassium_result_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $kidney_details['potassium_high_result_value']) {
                $kidney_details['potassium_result_value_in_words'] = 'High';
                $kidney_details['potassium_result_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['potassium_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['potassium_high_result_value']) {
                $kidney_details['potassium_impact_on_health'] = "An electrolyte imbalance may be a sign of a heart, lung or kidney problem. Dehydration also causes electrolyte imbalances";
            } else {
                $kidney_details['potassium_impact_on_health'] = '';
            }

            if ($resultData->RESULT_VALUE <= $kidney_details['potassium_high_result_value']) {
                $kidney_details['potassium_suggestions'] = "";
            } else {
                $kidney_details['potassium_suggestions'] = '';
            }
        }
    }
    if (!$potassium_result_found) {

        $report_issues[] = " Test Group 'Electrolyte' or Test Code 'POT' not found";
        $report_issues_email[] = " Test Group 'Electrolyte' or Test Code 'POT' not found" . FindTestgroupAddress('Electrolyte');
    }
    // ELECTROLYTES Chloride, Serum
    $chloride_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Electrolyte' &&  explode('|', $resultData->TEST_CODE)[0] == 'CHL') {
            $chloride_result_found = true;
            $kidney_details['chloride_result_value'] = $resultData->RESULT_VALUE;
            if (($kidney_details['chloride_result_value'] ?? null) === '' || ($kidney_details['chloride_result_value'] ?? null) === null) {

                $report_issues[] = "ELECTROLYTES Chloride, Serum TestResultDetails are empty";
                $report_issues_email[] = "ELECTROLYTES Chloride, Serum TestResultDetails are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "Chloride reference ranges are empty";
                $report_issues_email[] = "Chloride reference ranges are empty" . FindTestgroupAddress('Electrolyte');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = "  Chloride BR Interval are empty";
                $report_issues_email[] = "  Chloride BR Interval are empty" . FindTestgroupAddress('Electrolyte');
            }
            $kidney_details['chloride_low_result_value'] = $resultData->LOW_VALUE;
            $kidney_details['chloride_high_result_value'] = $resultData->HIGH_VALUE;
            $kidney_details['chloride_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $kidney_details['chloride_uom'] = str_replace(["�", "ï¿½"], "μ", $kidney_details['chloride_uom']);
            $kidney_details['chloride_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $kidney_details['chloride_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code CHL";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Electrolyte and test code CHL" . FindTestgroupAddress('Electrolyte');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $kidney_details['chloride_test_remraks'] = "Chloride, Serum - " . $resultData->TEST_REMARKS;
            } else {
                $kidney_details['chloride_test_remraks'] = '';
            }

            $kidney_details['chloride_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $kidney_details['chloride_low_result_value']) {
                $kidney_details['chloride_result_value_in_words'] = 'Low';
                $kidney_details['chloride_result_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $kidney_details['chloride_low_result_value'] && $resultData->RESULT_VALUE <= $kidney_details['chloride_high_result_value']) {
                $kidney_details['chloride_result_value_in_words'] = 'Normal';
                $kidney_details['chloride_result_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $kidney_details['chloride_high_result_value']) {
                $kidney_details['chloride_result_value_in_words'] = 'High';
                $kidney_details['chloride_result_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $kidney_details['chloride_low_result_value'] || $resultData->RESULT_VALUE > $kidney_details['chloride_high_result_value']) {
                $kidney_details['chloride_impact_on_health'] = "An electrolyte imbalance may be a sign of a heart, lung or kidney problem. Dehydration also causes electrolyte imbalances";
            } else {
                $kidney_details['chloride_impact_on_health'] = '';
            }

            if ($resultData->RESULT_VALUE <= $kidney_details['chloride_high_result_value']) {
                $kidney_details['chloride_suggestions'] = "";
            } else {
                $kidney_details['chloride_suggestions'] = '';
            }
        }
    }
    if (!$chloride_result_found) {

        $report_issues[] = " Test Group 'Electrolyte' or Test Code 'CHL' not found";
        $report_issues_email[] = " Test Group 'Electrolyte' or Test Code 'CHL' not found" . FindTestgroupAddress('Electrolyte');
    }
    return $kidney_details;
}

function compareegfr($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function egfrmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return compareegfr($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}

/**
 * Description: The getKidneyTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for kidney-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getKidneyTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $KidneyNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_025') {

            if ($resultData->TEST_GROUP_CODE === 'RFT-Basic') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic" . FindTestgroupAddress('RFT-Basic');
                }
                $KidneyNablAccredited['RFT_Basic_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['RFT_Basic_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'Electrolyte') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte" . FindTestgroupAddress('Electrolyte');
                }
                $KidneyNablAccredited['Electrolyte_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['Electrolyte_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif ($PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_029') {
            if ($resultData->TEST_GROUP_CODE === 'RFT-Basic') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic" . FindTestgroupAddress('RFT-Basic');
                }
                $KidneyNablAccredited['RFT_Basic_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['RFT_Basic_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'Electrolyte') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte" . FindTestgroupAddress('Electrolyte');
                }
                $KidneyNablAccredited['Electrolyte_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['Electrolyte_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'M0001') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code M0001";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code M0001" . FindTestgroupAddress('M0001');
                }
                $KidneyNablAccredited['M0001_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['M0001_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        }
        else{
                if ($resultData->TEST_GROUP_CODE === 'RFT-Basic') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code RFT-Basic" . FindTestgroupAddress('RFT-Basic');
                }
                $KidneyNablAccredited['RFT_Basic_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['RFT_Basic_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'Electrolyte') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Electrolyte" . FindTestgroupAddress('Electrolyte');
                }
                $KidneyNablAccredited['Electrolyte_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['Electrolyte_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE === 'R0004') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code R0004";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code R0004" . FindTestgroupAddress('Electrolyte');
                }
                $KidneyNablAccredited['R0004_kidney_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $KidneyNablAccredited['R0004_kidney_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

        }
    }

    return $KidneyNablAccredited;
}
/**
 * Description : getLiverDetails() function to get test result details for the liver section.
 * 
 * This function retrieves liver-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to liver diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the liver section.
 */

// get Liver Details

function getLiverDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $liver_details = [];
    if ($PackageCode == 'AYN_016') {
        // Bilirubin - Total sub test
        $bilirubin_total_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'TB') {
                $bilirubin_total_result_found = true;
                $liver_details['bilirubin_total_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_total_result_value'] ?? null) === '' || ($liver_details['bilirubin_total_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }

                $liver_details['bilirubin_total_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 0.1) {
                    $liver_details['bilirubin_result_value_in_words'] = 'Low';
                    $liver_details['bilirubin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 0.1 && $resultData->RESULT_VALUE <= 1.3) {
                    $liver_details['bilirubin_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 1.3) {
                    $liver_details['bilirubin_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 0.1 || $resultData->RESULT_VALUE > 1.3) {
                    $liver_details['bilirubin_total_impact_on_health'] = "Elevated serum bilirubin concentrations can be due to three causes: (1) Overproduction of bilirubin (Hemolysis / Ineffective erythropoiesis), (2) Impaired uptake, conjugation, or excretion of bilirubin (Gilbert syndrome / Crigler Najjar syndrome / Neonatal jaundice / Drugs) and (3) Backward leakage from damaged hepatocytes or bile ducts";
                } else {
                    $liver_details['bilirubin_total_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < 0.1 || $resultData->RESULT_VALUE > 1.3) {
                    $liver_details['bilirubin_total_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet, (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                } else {
                    $liver_details['bilirubin_total_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_total_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'TB' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'TB' not found" . FindTestgroupAddress('LFTW/OGGT');
        }
        // Bilirubin - Direct sub test
        $bilirubin_direct_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'DB') {
                $bilirubin_direct_result_found = true;
                $liver_details['bilirubin_direct_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_direct_result_value'] ?? null) === '' || ($liver_details['bilirubin_direct_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin - Direct TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin - Direct TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['bilirubin_direct_sample_method'] = $resultData->NEW_METHOD;
                if ((float)$resultData->RESULT_VALUE < 0.30) {
                    $liver_details['bilirubin_direct_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_direct_color_code'] = "green";
                } elseif ((float)$resultData->RESULT_VALUE >= 0.30) {
                    $liver_details['bilirubin_direct_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_direct_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >= 0.3) {
                    $liver_details['bilirubin_direct_impact_on_health'] = "Elevated serum direct bilirubin concentrations can be due to: (1) Impaired uptake, conjugation, or excretion of bilirubin(Gilbert syndrome / Crigler Najjar syndrome / Neonatal jaundice / Drugs) (2) Backward leakage from damaged hepatocytes or bile ducts";
                } else {
                    $liver_details['bilirubin_direct_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE >= 0.3) {
                    $liver_details['bilirubin_direct_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly (6)Avoid contaminated needles (7) Get medical care if you’re exposed to blood (8) Practice safe sex";
                } else {
                    $liver_details['bilirubin_direct_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_direct_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'DB' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'DB' not found" . FindTestgroupAddress('LFTW/OGGT');
        }

        // Bilirubin - Indirect sub test
        $bilirubin_indirect_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'IB') {
                $bilirubin_indirect_result_found =  true;
                $liver_details['bilirubin_indirect_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_indirect_result_value'] ?? null) === '' || ($liver_details['bilirubin_indirect_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin - Indirect TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin - Indirect TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['bilirubin_indirect_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 0.2) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'Low';
                    $liver_details['bilirubin_indirect_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 0.2 && $resultData->RESULT_VALUE <= 1) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_indirect_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 1) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_indirect_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 0.2 || $resultData->RESULT_VALUE > 1) {
                    $liver_details['bilirubin_indirect_impact_on_health'] = "Unconjugated hyperbilirubinemia exists when less than 15% to 20% of the total bilirubin is conjugated. Diseases that typically cause this form of jaundice include accelerated erythrocyte (RBC) hemolysis or hepatitis";
                } else {
                    $liver_details['bilirubin_indirect_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < 0.2 || $resultData->RESULT_VALUE > 1) {
                    $liver_details['bilirubin_indirect_suggestion'] = "Consult your physician if you get a abnormal value";
                } else {
                    $liver_details['bilirubin_indirect_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_indirect_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'IB' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'IB' not found" . FindTestgroupAddress('LFTW/OGGT');
        }

        // SGPT-ALT sub test

        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
            $sgpt_alt_result_male_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'SGPT') {
                    $sgpt_alt_result_male_found = true;
                    $liver_details['sgpt_alt_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['sgpt_alt_result_value'] ?? null) === '' || ($liver_details['sgpt_alt_result_value'] ?? null) === null) {

                        $report_issues[] = "SGPT-ALT TestResultDetails are empty";
                        $report_issues_email[] = "SGPT-ALT TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['sgpt_alt_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 45) {
                        $liver_details['sgpt_alt_result_value_in_words'] = 'Normal';
                        $liver_details['sgpt_alt_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > 45) {
                        $liver_details['sgpt_alt_result_value_in_words'] = 'High';
                        $liver_details['sgpt_alt_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE > 45) {
                        $liver_details['sgpt_alt_impact_on_health'] = "A higher than normal result on this test can be a sign of liver problem";
                    } else {
                        $liver_details['sgpt_alt_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE > 45) {
                        $liver_details['sgpt_alt_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                    } else {
                        $liver_details['sgpt_alt_suggestion'] = '';
                    }
                }
            }
            if (!$sgpt_alt_result_male_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'SGPT' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'SGPT' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
            $sgpt_alt_result_female_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'SGPT') {
                    $sgpt_alt_result_female_found = true;
                    $liver_details['sgpt_alt_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['sgpt_alt_result_value'] ?? null) === '' || ($liver_details['sgpt_alt_result_value'] ?? null) === null) {

                        $report_issues[] = "SGPT-ALT TestResultDetails are empty";
                        $report_issues_email[] = "SGPT-ALT TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['sgpt_alt_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 35) {
                        $liver_details['sgpt_alt_result_value_in_words'] = 'Normal';
                        $liver_details['sgpt_alt_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > 35) {
                        $liver_details['sgpt_alt_result_value_in_words'] = 'High';
                        $liver_details['sgpt_alt_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE > 35) {
                        $liver_details['sgpt_alt_impact_on_health'] = "A higher than normal result on this test can be a sign of liver problem";
                    } else {
                        $liver_details['sgpt_alt_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE > 35) {
                        $liver_details['sgpt_alt_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                    } else {
                        $liver_details['sgpt_alt_suggestion'] = '';
                    }
                }
            }
            if (!$sgpt_alt_result_female_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'SGPT' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'SGPT' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }

        // SGOT-AST sub test
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
            $sgot_ast_result_male_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'SGOTAST') {
                    $sgot_ast_result_male_found = true;
                    $liver_details['sgot_ast_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['sgot_ast_result_value'] ?? null) === '' || ($liver_details['sgot_ast_result_value'] ?? null) === null) {

                        $report_issues[] = "SGPT-AST TestResultDetails are empty";
                        $report_issues_email[] = "SGPT-AST TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['sgot_ast_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 35) {
                        $liver_details['sgot_ast_result_value_in_words'] = 'Normal';
                        $liver_details['sgot_ast_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE >= 35) {
                        $liver_details['sgot_ast_result_value_in_words'] = 'High';
                        $liver_details['sgot_ast_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE > 35) {
                        $liver_details['sgot_ast_impact_on_health'] = "When the liver is damaged, AST can be released into the bloodstream. A high result on an AST test might indicate a problem with the liver or muscles";
                    } else {
                        $liver_details['sgot_ast_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE > 35) {
                        $liver_details['sgot_ast_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                    } else {
                        $liver_details['sgot_ast_suggestion'] = '';
                    }
                }
            }
            if (!$sgot_ast_result_male_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'SGOTAST' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'SGOTAST' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
            $sgot_ast_result_female_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'SGOTAST') {
                    $sgot_ast_result_female_found = true;
                    $liver_details['sgot_ast_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['sgot_ast_result_value'] ?? null) === '' || ($liver_details['sgot_ast_result_value'] ?? null) === null) {

                        $report_issues[] = "SGPT-AST TestResultDetails are empty";
                        $report_issues_email[] = "SGPT-AST TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['sgot_ast_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 31) {
                        $liver_details['sgot_ast_result_value_in_words'] = 'Normal';
                        $liver_details['sgot_ast_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > 31) {
                        $liver_details['sgot_ast_result_value_in_words'] = 'High';
                        $liver_details['sgot_ast_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE > 31) {
                        $liver_details['sgot_ast_impact_on_health'] = "When the liver is damaged, AST can be released into the bloodstream. A high result on an AST test might indicate a problem with the liver or muscles";
                    } else {
                        $liver_details['sgot_ast_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE > 31) {
                        $liver_details['sgot_ast_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                    } else {
                        $liver_details['sgot_ast_suggestion'] = '';
                    }
                }
            }
            if (!$sgot_ast_result_female_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'SGOTAST' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'SGOTAST' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }
        // Alkaline Phosphatase sub test

        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
            $alkaline_phosphatase_result_male_found =  false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'ALP') {
                    $alkaline_phosphatase_result_male_found =  true;
                    $liver_details['alkaline_phosphatase_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['alkaline_phosphatase_result_value'] ?? null) === '' || ($liver_details['alkaline_phosphatase_result_value'] ?? null) === null) {

                        $report_issues[] = "Alkaline Phosphatase TestResultDetails are empty";
                        $report_issues_email[] = "Alkaline Phosphatase TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['alkaline_phosphatase_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 53) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Low';
                        $liver_details['alkaline_phosphatase_color_code'] = "red";
                    }
                    if ($resultData->RESULT_VALUE >= 53 && $resultData->RESULT_VALUE <= 128) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Normal';
                        $liver_details['alkaline_phosphatase_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > 128) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'High';
                        $liver_details['alkaline_phosphatase_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE < 53 || $resultData->RESULT_VALUE > 128) {
                        $liver_details['alkaline_phosphatase_impact_on_health'] = "High levels of ALP may indicate liver inflammation, blockage of the bile ducts, or a bone disease. Children and adolescents may have elevated levels of ALP because their bones are growing. Pregnancy can also raise ALP levels";
                    } else {
                        $liver_details['alkaline_phosphatase_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE < 53 || $resultData->RESULT_VALUE > 128) {
                        $liver_details['alkaline_phosphatase_suggestion'] = "ALP rates can be lowered through a combination of medication, dietary changes, and lifestyle modifications. Talk to your doctor about whether further testing is needed";
                    } else {
                        $liver_details['alkaline_phosphatase_suggestion'] = '';
                    }
                }
            }
            if (!$alkaline_phosphatase_result_male_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'ALP' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'ALP' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
            $alkaline_phosphatase_result_female_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'ALP') {
                    $alkaline_phosphatase_result_female_found = true;
                    $liver_details['alkaline_phosphatase_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['alkaline_phosphatase_result_value'] ?? null) === '' || ($liver_details['alkaline_phosphatase_result_value'] ?? null) === null) {

                        $report_issues[] = "Alkaline Phosphatase TestResultDetails are empty";
                        $report_issues_email[] = "Alkaline Phosphatase TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                    }
                    $liver_details['alkaline_phosphatase_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 42) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Low';
                        $liver_details['alkaline_phosphatase_color_code'] = "red";
                    }
                    if ($resultData->RESULT_VALUE >= 42 && $resultData->RESULT_VALUE <= 98) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Normal';
                        $liver_details['alkaline_phosphatase_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE > 98) {
                        $liver_details['alkaline_phosphatase_result_value_in_words'] = 'High';
                        $liver_details['alkaline_phosphatase_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE < 42 || $resultData->RESULT_VALUE > 98) {
                        $liver_details['alkaline_phosphatase_impact_on_health'] = "High levels of ALP may indicate liver inflammation, blockage of the bile ducts, or a bone disease. Children and adolescents may have elevated levels of ALP because their bones are growing. Pregnancy can also raise ALP levels";
                    } else {
                        $liver_details['alkaline_phosphatase_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE < 42 || $resultData->RESULT_VALUE > 98) {
                        $liver_details['alkaline_phosphatase_suggestion'] = "ALP rates can be lowered through a combination of medication, dietary changes, and lifestyle modifications. Talk to your doctor about whether further testing is needed";
                    } else {
                        $liver_details['alkaline_phosphatase_suggestion'] = '';
                    }
                }
            }
            if (!$alkaline_phosphatase_result_female_found) {

                $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'ALP' not found";
                $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'ALP' not found" . FindTestgroupAddress('LFTW/OGGT');
            }
        }
        // Gamma Glutamyl Transferase (GGT) sub test
        if ($PackageCode != 'AYN_016') {
            if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
                $ggt_result_found = false;
                foreach ($reportJsonData->TestResultDetails as $resultData) {
                    if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'GGT') {
                        $ggt_result_found = true;
                        $liver_details['ggt_result_value'] = $resultData->RESULT_VALUE;
                        if (($liver_details['ggt_result_value'] ?? null) === '' || ($liver_details['ggt_result_value'] ?? null) === null) {

                            $report_issues[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty";
                            $report_issues_email[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                        }
                        $liver_details['ggt_sample_method'] = $resultData->NEW_METHOD;
                        if ($resultData->RESULT_VALUE < 55) {
                            $liver_details['ggt_result_value_in_words'] = 'Normal';
                            $liver_details['ggt_color_code'] = "green";
                        } else {
                            $liver_details['ggt_color_code'] = "";
                        }
                        if ($resultData->RESULT_VALUE >= 55) {
                            $liver_details['ggt_result_value_in_words'] = 'High';
                            $liver_details['ggt_color_code'] = "red";
                        } else {
                            $liver_details['ggt_color_code'] = "";
                        }
                        // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                        if ($resultData->RESULT_VALUE > 55) {
                            $liver_details['ggt_impact_on_health'] = "Increased GGT is seen in Hepatitis,Cirrhosis,carcinoma, Cholestasis,Alcoholic liver disease, Primary biliary cirrhosis and sclerosing cholangitis.Certain drugs such as carbamazepine,furosemide,heparin,methotrexate, oral contraceptives, phenobarbital, phenytoin, and valproic acid can increase serum GGT levels";
                        } else {
                            $liver_details['ggt_impact_on_health'] = '';
                        }
                        if ($resultData->RESULT_VALUE > 55) {
                            $liver_details['ggt_suggestion'] = "(1) Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly";
                        } else {
                            $liver_details['ggt_suggestion'] = '';
                        }
                    }
                }
                if (!$$ggt_result_found) {

                    $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'GGT' not found";
                    $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'GGT' not found" . FindTestgroupAddress('LFTW/OGGT');
                }
            }
            if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
                $ggt_result_found = false;
                foreach ($reportJsonData->TestResultDetails as $resultData) {
                    if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'GGT') {
                        $ggt_result_found = true;
                        $liver_details['ggt_result_value'] = $resultData->RESULT_VALUE;
                        if (($liver_details['ggt_result_value'] ?? null) === '' || ($liver_details['ggt_result_value'] ?? null) === null) {

                            $report_issues[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty";
                            $report_issues_email[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                        }
                        $liver_details['ggt_sample_method'] = $resultData->NEW_METHOD;
                        if ($resultData->RESULT_VALUE < 38) {
                            $liver_details['ggt_result_value_in_words'] = 'Normal';
                            $liver_details['ggt_color_code'] = "green";
                        } else {
                            $liver_details['ggt_color_code'] = "";
                        }
                        if ($resultData->RESULT_VALUE > 38) {
                            $liver_details['ggt_result_value_in_words'] = 'High';
                            $liver_details['ggt_color_code'] = "red";
                        } else {
                            $liver_details['ggt_color_code'] = "";
                        }
                        // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                        if ($resultData->RESULT_VALUE > 38) {
                            $liver_details['ggt_impact_on_health'] = "Increased GGT is seen in Hepatitis,Cirrhosis,carcinoma, Cholestasis,Alcoholic liver disease, Primary biliary cirrhosis and sclerosing cholangitis.Certain drugs such as carbamazepine,furosemide,heparin,methotrexate, oral contraceptives, phenobarbital, phenytoin, and valproic acid can increase serum GGT levels";
                        } else {
                            $liver_details['ggt_impact_on_health'] = '';
                        }
                        if ($resultData->RESULT_VALUE > 38) {
                            $liver_details['ggt_suggestion'] = "(1) Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly";
                        } else {
                            $liver_details['ggt_suggestion'] = '';
                        }
                    }
                }
                if (!$$ggt_result_found) {

                    $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'GGT' not found";
                    $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'GGT' not found" . FindTestgroupAddress('LFTW/OGGT');
                }
            }
        }
        // Total Protein sub test
        $total_protein_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'TP') {
                $total_protein_result_found = true;
                $liver_details['total_protein_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['total_protein_result_value'] ?? null) === '' || ($liver_details['total_protein_result_value'] ?? null) === null) {

                    $report_issues[] = "Total Protein TestResultDetails are empty";
                    $report_issues_email[] = "Total Protein TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['total_protein_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 6.4) {
                    $liver_details['total_protein_result_value_in_words'] = 'Low';
                    $liver_details['total_protein_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 6.4 && $resultData->RESULT_VALUE <= 8.8) {
                    $liver_details['total_protein_result_value_in_words'] = 'Normal';
                    $liver_details['total_protein_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 8.8) {
                    $liver_details['total_protein_result_value_in_words'] = 'High';
                    $liver_details['total_protein_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 6.4 || $resultData->RESULT_VALUE > 8.8) {
                    $liver_details['total_protein_impact_on_health'] = "Hyperproteinemia: Dehydration / Diabetic acidosis / Addison disease / Hemoconcentration. Hypoproteinemia: Liver disease / Kidney disease / Leukemia / Malnutrition / Malabsorption / Bone marrow disorders";
                } else {
                    $liver_details['total_protein_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < 6.4 || $resultData->RESULT_VALUE > 8.8) {
                    $liver_details['total_protein_suggestion'] = "If your doctor discovers abnormal blood protein during an evaluation, he or she may recommend additional tests to determine if there is an underlying problem.Other more-specific tests, including serum protein electrophoresis (SPEP), can help determine the exact source, such as liver or bone marrow,There is no specific diet or lifestyle change you can help to bring down your total protein. taking supplement can help to maintain
                levels";
                } else {
                    $liver_details['total_protein_suggestion'] = '';
                }
            }
        }
        if (!$total_protein_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'TP' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'TP' not found" . FindTestgroupAddress('LFTW/OGGT');
        }
        // Globulin sub test
        $globulin_result_value = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'GLOB') {
                $globulin_result_value = true;
                $liver_details['globulin_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['globulin_result_value'] ?? null) === '' || ($liver_details['globulin_result_value'] ?? null) === null) {

                    $report_issues[] = "Globulin TestResultDetails are empty";
                    $report_issues_email[] = "Globulin TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['globulin_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 1.9) {
                    $liver_details['globulin_result_value_in_words'] = 'Low';
                    $liver_details['globulin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 1.9 && $resultData->RESULT_VALUE <= 3.9) {
                    $liver_details['globulin_result_value_in_words'] = 'Normal';
                    $liver_details['globulin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 3.9) {
                    $liver_details['globulin_result_value_in_words'] = 'High';
                    $liver_details['globulin_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 1.9 || $resultData->RESULT_VALUE > 3.9) {
                    $liver_details['globulin_impact_on_health'] = "Increased levels of serum Globulins is seen in infection, inflammatory disease or immune disorders Liver dysfunction, Malnutrition and congenital immune deficiency can cause decrease in total globulins due to reduced synthesis";
                } else {
                    $liver_details['globulin_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > 3.9) {
                    $liver_details['globulin_suggestion'] = "(1) Maintain healthy weight. (2) Eat balanced diet (3) Exercise regularly (4) Avoid toxins (5) use alcohol responsibly (6) Avoid contaminated needles (7) Get medical care if you’re exposed to blood. (8) Practice safe sex. (9) Get vaccinated";
                } else {
                    $liver_details['globulin_suggestion'] = '';
                }
            }
        }
        if (!$globulin_result_value) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'GLOB' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'GLOB' not found" . FindTestgroupAddress('LFTW/OGGT');
        }
        // Albumin sub test
        $albumin_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'ALB') {
                $albumin_result_found =  true;
                $liver_details['albumin_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['albumin_result_value'] ?? null) === '' || ($liver_details['albumin_result_value'] ?? null) === null) {

                    $report_issues[] = "Albumin TestResultDetails are empty";
                    $report_issues_email[] = "Albumin TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['albumin_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 3.5) {
                    $liver_details['albumin_result_value_in_words'] = 'Low';
                    $liver_details['albumin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 3.5 && $resultData->RESULT_VALUE <= 5.2) {
                    $liver_details['albumin_result_value_in_words'] = 'Normal';
                    $liver_details['albumin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 5.2) {
                    $liver_details['albumin_result_value_in_words'] = 'High';
                    $liver_details['albumin_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 3.5 || $resultData->RESULT_VALUE > 5.2) {
                    $liver_details['albumin_impact_on_health'] = "Increased Levels: seen only in acute dehydration.Decreased Levels: from decreased synthesis, increased catabolism , or combinations of these. Decreased synthesis may be primary or genetic (Analbuminemia) or acquired (inflammatory processes). Hypoalbnminemia may result in underestimation of the anion gap when evaluating fluid and electrolyte status";
                } else {
                    $liver_details['albumin_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < 3.5 || $resultData->RESULT_VALUE > 5.2) {
                    $liver_details['albumin_suggestion'] = "(1) Maintain healthy weight. (2) Eat balanced diet (3) Exercise regularly (4) Avoid toxins (5) use alcohol responsibly (6) Avoid contaminated needles (7) Get medical care if you’re exposed to blood. (8) Practice safe sex. (9) Get vaccinated";
                } else {
                    $liver_details['albumin_suggestion'] = '';
                }
            }
        }
        if (!$albumin_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'ALB' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'ALB' not found" . FindTestgroupAddress('LFTW/OGGT');
        }

        // A : G ratio sub test
        $ag_ratio_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFTW/OGGT' && $resultData->TEST_CODE == 'AGR') {
                $ag_ratio_result_found = true;
                $liver_details['ag_ratio_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['ag_ratio_result_value'] ?? null) === '' || ($liver_details['ag_ratio_result_value'] ?? null) === null) {

                    $report_issues[] = "A : G ratio TestResultDetails are empty";
                    $report_issues_email[] = "A : G ratio TestResultDetails are empty" . FindTestgroupAddress('LFTW/OGGT');
                }
                $liver_details['ag_ratio_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < 1.1) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'Low';
                    $liver_details['ag_ratio_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= 1.1 && $resultData->RESULT_VALUE <= 2.5) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'Normal';
                    $liver_details['ag_ratio_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > 2.5) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'High';
                    $liver_details['ag_ratio_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < 1.1 || $resultData->RESULT_VALUE > 2.5) {
                    $liver_details['ag_ratio_impact_on_health'] = "A total protein and A/G ratio test is often included as part of a comprehensive metabolic panel, a test that measures proteins and other substances in the blood. It may also be used to help diagnose kidney disease, liver disease, or nutritional problems";
                } else {
                    $liver_details['ag_ratio_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < 1.1 || $resultData->RESULT_VALUE > 2.5) {
                    $liver_details['ag_ratio_suggestion'] = "Consult your physician if you get a abnormal value";
                } else {
                    $liver_details['ag_ratio_suggestion'] = '';
                }
                if ($resultData->RESULT_VALUE < 1.1 || $resultData->RESULT_VALUE > 2.5) {
                    $liver_details['ag_ratio_about_your_result'] = "During your liver health check we have found out that SGOT-AST , Total Protein, Globulin are your concern parameters, which can impact your health";
                } else {
                    $liver_details['ag_ratio_about_your_result'] = '';
                }
            }
        }
        if (!$ag_ratio_result_found) {

            $report_issues[] = " Test Group 'LFTW/OGGT' or Test Code 'AGR' not found";
            $report_issues_email[] = " Test Group 'LFTW/OGGT' or Test Code 'AGR' not found" . FindTestgroupAddress('LFTW/OGGT');
        }
    } else {
        // Bilirubin - Total sub test
        $bilirubin_total_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'TB') {
                $bilirubin_total_result_found = true;
                $liver_details['bilirubin_total_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_total_result_value'] ?? null) === '' || ($liver_details['bilirubin_total_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin - Total TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin - Total TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Bilirubin - Total reference ranges are empty";
                    $report_issues_email[] = " Bilirubin - Total reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Bilirubin - Total Interval are empty";
                    $report_issues_email[] = " Bilirubin - Total Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['bilirubin_total_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['bilirubin_total_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['bilirubin_total_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['bilirubin_total_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['bilirubin_total_uom']);
                $liver_details['bilirubin_total_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['bilirubin_total_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code TB";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code TB" . FindTestgroupAddress('LFT.');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['bilirubin_total_test_remraks'] = "Bilirubin Total - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['bilirubin_total_test_remraks'] = '';
                }


                $liver_details['bilirubin_total_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_total_low_result_value']) {
                    $liver_details['bilirubin_result_value_in_words'] = 'Low';
                    $liver_details['bilirubin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['bilirubin_total_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['bilirubin_total_high_result_value']) {
                    $liver_details['bilirubin_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['bilirubin_total_high_result_value']) {
                    $liver_details['bilirubin_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_total_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['bilirubin_total_high_result_value']) {
                    $liver_details['bilirubin_total_impact_on_health'] = "Elevated serum bilirubin concentrations can be due to three causes: (1) Overproduction of bilirubin (Hemolysis / Ineffective erythropoiesis), (2) Impaired uptake, conjugation, or excretion of bilirubin (Gilbert syndrome / Crigler Najjar syndrome / Neonatal jaundice / Drugs) and (3) Backward leakage from damaged hepatocytes or bile ducts";
                } else {
                    $liver_details['bilirubin_total_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_total_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['bilirubin_total_high_result_value']) {
                    $liver_details['bilirubin_total_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet, (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                } else {
                    $liver_details['bilirubin_total_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_total_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'TB' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'TB' not found" . FindTestgroupAddress('LFT.');
        }

        // Bilirubin - Direct sub test
        $bilirubin_direct_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'DB') {
                $bilirubin_direct_result_found = true;
                $liver_details['bilirubin_direct_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_direct_result_value'] ?? null) === '' || ($liver_details['bilirubin_direct_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin - Direct TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin - Direct TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->HIGH_VALUE) ||  $resultData->HIGH_VALUE === "") {

                    $report_issues[] = " Bilirubin - Direct reference ranges are empty";
                    $report_issues_email[] = " Bilirubin - Direct reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Bilirubin - Direct Interval are empty";
                    $report_issues_email[] = " Bilirubin - Direct Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['bilirubin_direct_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['bilirubin_direct_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['bilirubin_direct_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['bilirubin_direct_uom']);
                $liver_details['bilirubin_direct_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['bilirubin_direct_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code DB";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code DB" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['bilirubin_direct_test_remraks'] = "Bilirubin Direct - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['bilirubin_direct_test_remraks'] = '';
                }


                $liver_details['bilirubin_direct_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE <  $liver_details['bilirubin_direct_high_result_value']) {
                    $liver_details['bilirubin_direct_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_direct_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['bilirubin_direct_high_result_value']) {
                    $liver_details['bilirubin_direct_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_direct_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE > $liver_details['bilirubin_direct_high_result_value']) {
                    $liver_details['bilirubin_direct_impact_on_health'] = "Elevated serum direct bilirubin concentrations can be due to: (1) Impaired uptake, conjugation, or excretion of bilirubin(Gilbert syndrome / Crigler Najjar syndrome / Neonatal jaundice / Drugs) (2) Backward leakage from damaged hepatocytes or bile ducts";
                } else {
                    $liver_details['bilirubin_direct_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE >= $liver_details['bilirubin_direct_high_result_value']) {
                    $liver_details['bilirubin_direct_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly (6)Avoid contaminated needles (7) Get medical care if you’re exposed to blood (8) Practice safe sex";
                } else {
                    $liver_details['bilirubin_direct_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_direct_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'DB' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'DB' not found" . FindTestgroupAddress('LFT.');
        }
        // Bilirubin - Indirect sub test
        $bilirubin_indirect_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'IB') {
                $bilirubin_indirect_result_found = true;
                $liver_details['bilirubin_indirect_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['bilirubin_indirect_result_value'] ?? null) === '' || ($liver_details['bilirubin_indirect_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin - Indirect TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin - Indirect TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Bilirubin - Indirect reference ranges are empty";
                    $report_issues_email[] = " Bilirubin - Indirect reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Bilirubin - Indirect Interval are empty";
                    $report_issues_email[] = " Bilirubin - Indirect Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['bilirubin_indirect_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['bilirubin_indirect_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['bilirubin_indirect_uom'] = $resultData->UOM ? utf8_decode($resultData->UOM) : '';
                $liver_details['bilirubin_indirect_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['bilirubin_indirect_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code IB";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code IB" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['bilirubin_indirect_test_remraks'] = "Bilirubin Indirect - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['bilirubin_indirect_test_remraks'] = '';
                }

                $liver_details['bilirubin_indirect_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_indirect_low_result_value']) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'Low';
                    $liver_details['bilirubin_indirect_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['bilirubin_indirect_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['bilirubin_indirect_high_result_value']) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'Normal';
                    $liver_details['bilirubin_indirect_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['bilirubin_indirect_high_result_value']) {
                    $liver_details['bilirubin_indirect_result_value_in_words'] = 'High';
                    $liver_details['bilirubin_indirect_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_indirect_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['bilirubin_indirect_high_result_value']) {
                    $liver_details['bilirubin_indirect_impact_on_health'] = "Unconjugated hyperbilirubinemia exists when less than 15% to 20% of the total bilirubin is conjugated. Diseases that typically cause this form of jaundice include accelerated erythrocyte (RBC) hemolysis or hepatitis";
                } else {
                    $liver_details['bilirubin_indirect_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['bilirubin_indirect_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['bilirubin_indirect_high_result_value']) {
                    $liver_details['bilirubin_indirect_suggestion'] = "Consult your physician if you get a abnormal value";
                } else {
                    $liver_details['bilirubin_indirect_suggestion'] = '';
                }
            }
        }
        if (!$bilirubin_indirect_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'IB' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'IB' not found" . FindTestgroupAddress('LFT.');
        }

        // SGPT-ALT sub test

        $sgpt_alt_result_male_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'SGPT') {
                $sgpt_alt_result_male_found = true;
                $liver_details['sgpt_alt_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['sgpt_alt_result_value'] ?? null) === '' || ($liver_details['sgpt_alt_result_value'] ?? null) === null) {

                    $report_issues[] = "SGPT-ALT TestResultDetails are empty";
                    $report_issues_email[] = "SGPT-ALT TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === "") {

                    $report_issues[] = " SGPT-ALT reference ranges are empty";
                    $report_issues_email[] = " SGPT-ALT reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " SGPT-ALT Interval are empty";
                    $report_issues_email[] = " SGPT-ALT Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['sgpt_alt_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['sgpt_alt_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['sgpt_alt_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['sgpt_alt_uom']);
                $liver_details['sgpt_alt_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['sgpt_alt_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code SGPT";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code SGPT" . FindTestgroupAddress('LFT.');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['sgpt_alt_test_remraks'] = "SGPT ALT - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['sgpt_alt_test_remraks'] = '';
                }


                $liver_details['sgpt_alt_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['sgpt_alt_high_result_value']) {
                    $liver_details['sgpt_alt_result_value_in_words'] = 'Normal';
                    $liver_details['sgpt_alt_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['sgpt_alt_high_result_value']) {
                    $liver_details['sgpt_alt_result_value_in_words'] = 'High';
                    $liver_details['sgpt_alt_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE > $liver_details['sgpt_alt_high_result_value']) {
                    $liver_details['sgpt_alt_impact_on_health'] = "A higher than normal result on this test can be a sign of liver problem";
                } else {
                    $liver_details['sgpt_alt_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > $liver_details['sgpt_alt_high_result_value']) {
                    $liver_details['sgpt_alt_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                } else {
                    $liver_details['sgpt_alt_suggestion'] = '';
                }
            }
        }
        if (!$sgpt_alt_result_male_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'SGPT' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'SGPT' not found" . FindTestgroupAddress('LFT.');
        }
        // SGOT-AST sub test
        $sgot_ast_result_male_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' &&  explode('|', $resultData->TEST_CODE)[0] == 'SGOTAST') {
                $sgot_ast_result_male_found = true;
                $liver_details['sgot_ast_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['sgot_ast_result_value'] ?? null) === '' || ($liver_details['sgot_ast_result_value'] ?? null) === null) {

                    $report_issues[] = "SGOT-AST TestResultDetails are empty";
                    $report_issues_email[] = "SGOT-AST TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === "") {

                    $report_issues[] = " SGOT-AST reference ranges are empty";
                    $report_issues_email[] = " SGOT-AST reference ranges are empty" . FindTestgroupAddress('LFT.');
                }

                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " SGOT-AST BR Interval are empty";
                    $report_issues_email[] = " SGOT-AST BR Interval are empty" . FindTestgroupAddress('LFT.');
                }


                $liver_details['sgot_ast_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['sgot_ast_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['sgot_ast_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['sgot_ast_uom']);
                $liver_details['sgot_ast_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['sgot_ast_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code SGOTAST";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code SGOTAST" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['sgot_ast_test_remraks'] = "SGOT AST - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['sgot_ast_test_remraks'] = '';
                }
                $liver_details['sgot_ast_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE <  $liver_details['sgot_ast_high_result_value']) {
                    $liver_details['sgot_ast_result_value_in_words'] = 'Normal';
                    $liver_details['sgot_ast_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['sgot_ast_high_result_value']) {
                    $liver_details['sgot_ast_result_value_in_words'] = 'High';
                    $liver_details['sgot_ast_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >  $liver_details['sgot_ast_high_result_value']) {
                    $liver_details['sgot_ast_impact_on_health'] = "When the liver is damaged, AST can be released into the bloodstream. A high result on an AST test might indicate a problem with the liver or muscles";
                } else {
                    $liver_details['sgot_ast_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE >  $liver_details['sgot_ast_high_result_value']) {
                    $liver_details['sgot_ast_suggestion'] = "(1)Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5) use alcohol responsibly (6)Avoid contaminated needles (7)Get medical care if you’re exposed to blood (8)Practice safe sex";
                } else {
                    $liver_details['sgot_ast_suggestion'] = '';
                }
            }
        }
        if (!$sgot_ast_result_male_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'SGOTAST' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'SGOTAST' not found" . FindTestgroupAddress('LFT.');
        }
        // Alkaline Phosphatase sub test
        $alkaline_phosphatase_result_male_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'ALP') {
                $alkaline_phosphatase_result_male_found =  true;
                $liver_details['alkaline_phosphatase_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['alkaline_phosphatase_result_value'] ?? null) === '' || ($liver_details['alkaline_phosphatase_result_value'] ?? null) === null) {

                    $report_issues[] = "Alkaline Phosphatase TestResultDetails are empty";
                    $report_issues_email[] = "Alkaline Phosphatase TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Alkaline Phosphatase reference ranges are empty";
                    $report_issues_email[] = " Alkaline Phosphatase reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Alkaline Phosphatase BR Interval are empty";
                    $report_issues_email[] = "  Alkaline Phosphatase BR Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['alkaline_phosphatase_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['alkaline_phosphatase_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['alkaline_phosphatase_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['alkaline_phosphatase_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['alkaline_phosphatase_uom']);
                $liver_details['alkaline_phosphatase_BRInterval_result_value'] = trim(nl2br($resultData->BRInterval));

                $range_map = [];

                $brInterval = trim($liver_details['alkaline_phosphatase_BRInterval_result_value']);
                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {
                    // Also clean single range
                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }

                $liver_details['alkaline_phosphatase_reference_ranges_value'] = $range_map;
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['alkaline_phosphatase_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code ALP";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code ALP" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['alkaline_phosphatase_test_remraks'] = "Alkaline Phosphatase - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['alkaline_phosphatase_test_remraks'] = '';
                }
                $liver_details['alkaline_phosphatase_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['alkaline_phosphatase_low_result_value']) {
                    $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Low';
                    $liver_details['alkaline_phosphatase_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['alkaline_phosphatase_low_result_value']  && $resultData->RESULT_VALUE <=  $liver_details['alkaline_phosphatase_high_result_value']) {
                    $liver_details['alkaline_phosphatase_result_value_in_words'] = 'Normal';
                    $liver_details['alkaline_phosphatase_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE >  $liver_details['alkaline_phosphatase_high_result_value']) {
                    $liver_details['alkaline_phosphatase_result_value_in_words'] = 'High';
                    $liver_details['alkaline_phosphatase_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE <  $liver_details['alkaline_phosphatase_low_result_value'] || $resultData->RESULT_VALUE >  $liver_details['alkaline_phosphatase_high_result_value']) {
                    $liver_details['alkaline_phosphatase_impact_on_health'] = "High levels of ALP may indicate liver inflammation, blockage of the bile ducts, or a bone disease. Children and adolescents may have elevated levels of ALP because their bones are growing. Pregnancy can also raise ALP levels";
                } else {
                    $liver_details['alkaline_phosphatase_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE <  $liver_details['alkaline_phosphatase_low_result_value'] || $resultData->RESULT_VALUE >  $liver_details['alkaline_phosphatase_high_result_value']) {
                    $liver_details['alkaline_phosphatase_suggestion'] = "ALP rates can be lowered through a combination of medication, dietary changes, and lifestyle modifications. Talk to your doctor about whether further testing is needed";
                } else {
                    $liver_details['alkaline_phosphatase_suggestion'] = '';
                }
            }
        }
        if (!$alkaline_phosphatase_result_male_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'ALP' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'ALP' not found" . FindTestgroupAddress('LFT.');
        }
        $configModel = new StoreConfig();
        $ggt_processingbranchid = explode(',', $configModel->getConfigValue('GGT_PROCESSINGBRANCHID')['config_value']);

        if (in_array($reportJsonData->TestGroupDetails[0]->ProcessingBranchId, $ggt_processingbranchid)) {
            $liver_details['ggt_result_found_view'] = 0;
        } else {
            $liver_details['ggt_result_found_view'] = 1;
            $ggt_result_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'LFT.' &&  explode('|', $resultData->TEST_CODE)[0] == 'GGT') {
                    $ggt_result_found = true;
                    $liver_details['ggt_result_value'] = $resultData->RESULT_VALUE;
                    if (($liver_details['ggt_result_value'] ?? null) === '' || ($liver_details['ggt_result_value'] ?? null) === null) {

                        $report_issues[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty";
                        $report_issues_email[] = "Gamma Glutamyl Transferase (GGT) TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                    }
                    if (!isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === "") {

                        $report_issues[] = " Gamma Glutamyl Transferase (GGT) reference ranges are empty";
                        $report_issues_email[] = " Gamma Glutamyl Transferase (GGT) reference ranges are empty" . FindTestgroupAddress('LFT.');
                    }
                    if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                        $report_issues[] = "  Gamma Glutamyl Transferase (GGT) BR Interval are empty";
                        $report_issues_email[] = "  Gamma Glutamyl Transferase (GGT) BR Interval are empty" . FindTestgroupAddress('LFT.');
                    }

                    $liver_details['ggt_high_result_value'] = $resultData->HIGH_VALUE;
                    $liver_details['ggt_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                    $liver_details['ggt_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['ggt_uom']);
                    $liver_details['ggt_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $liver_details['ggt_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {

                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code GGT";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code GGT" . FindTestgroupAddress('LFT.');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $liver_details['ggt_test_remraks'] = "Gamma Glutamyl Transferase (GGT) - " . $resultData->TEST_REMARKS;
                    } else {
                        $liver_details['ggt_test_remraks'] = '';
                    }
                    $liver_details['ggt_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < $liver_details['ggt_high_result_value']) {
                        $liver_details['ggt_result_value_in_words'] = 'Normal';
                        $liver_details['ggt_color_code'] = "green";
                    }
                    if ($resultData->RESULT_VALUE >= $liver_details['ggt_high_result_value']) {
                        $liver_details['ggt_result_value_in_words'] = 'High';
                        $liver_details['ggt_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE > $liver_details['ggt_high_result_value']) {
                        $liver_details['ggt_impact_on_health'] = "Increased GGT is seen in Hepatitis,Cirrhosis,carcinoma, Cholestasis,Alcoholic liver disease, Primary biliary cirrhosis and sclerosing cholangitis.Certain drugs such as carbamazepine,furosemide,heparin,methotrexate, oral contraceptives, phenobarbital, phenytoin, and valproic acid can increase serum GGT levels";
                    } else {
                        $liver_details['ggt_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE > $liver_details['ggt_high_result_value']) {
                        $liver_details['ggt_suggestion'] = "(1) Maintain healthy weight. (2)Eat balanced diet (3)Exercise regularly (4)Avoid toxins (5)use alcohol responsibly";
                    } else {
                        $liver_details['ggt_suggestion'] = '';
                    }
                }
            }
            if (!$ggt_result_found) {

                $report_issues[] = " Test Group 'LFT.' or Test Code 'GGT' not found";
                $report_issues_email[] = " Test Group 'LFT.' or Test Code 'GGT' not found" . FindTestgroupAddress('LFT.');
            }
        }
        // Total Protein sub test

        $total_protein_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'TP') {
                $total_protein_result_found = true;
                $liver_details['total_protein_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['total_protein_result_value'] ?? null) === '' || ($liver_details['total_protein_result_value'] ?? null) === null) {

                    $report_issues[] = "Total Protein TestResultDetails are empty";
                    $report_issues_email[] = "Total Protein TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Total Protein reference ranges are empty";
                    $report_issues_email[] = " Total Protein reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Total Protein BR Interval are empty";
                    $report_issues_email[] = "  Total Protein BR Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['total_protein_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['total_protein_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['total_protein_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['total_protein_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['total_protein_uom']);
                $liver_details['total_protein_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['total_protein_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code TP";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code TP" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['total_protein_test_remraks'] = "Total Protein - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['total_protein_test_remraks'] = '';
                }

                $liver_details['total_protein_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['total_protein_low_result_value']) {
                    $liver_details['total_protein_result_value_in_words'] = 'Low';
                    $liver_details['total_protein_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['total_protein_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['total_protein_high_result_value']) {
                    $liver_details['total_protein_result_value_in_words'] = 'Normal';
                    $liver_details['total_protein_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['total_protein_high_result_value']) {
                    $liver_details['total_protein_result_value_in_words'] = 'High';
                    $liver_details['total_protein_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['total_protein_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['total_protein_high_result_value']) {
                    $liver_details['total_protein_impact_on_health'] = "Hyperproteinemia: Dehydration / Diabetic acidosis / Addison disease / Hemoconcentration. Hypoproteinemia: Liver disease / Kidney disease / Leukemia / Malnutrition / Malabsorption / Bone marrow disorders";
                } else {
                    $liver_details['total_protein_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['total_protein_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['total_protein_high_result_value']) {
                    $liver_details['total_protein_suggestion'] = "If your doctor discovers abnormal blood protein during an evaluation, he or she may recommend additional tests to determine if there is an underlying problem.Other more-specific tests, including serum protein electrophoresis (SPEP), can help determine the exact source, such as liver or bone marrow,There is no specific diet or lifestyle change you can help to bring down your total protein. taking supplement can help to maintain
                levels";
                } else {
                    $liver_details['total_protein_suggestion'] = '';
                }
            }
        }
        if (!$total_protein_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'TP' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'TP' not found" . FindTestgroupAddress('LFT.');
        }
        // Globulin sub test
        $globulin_result_value = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'GLOB') {
                $globulin_result_value = true;
                $liver_details['globulin_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['globulin_result_value'] ?? null) === '' || ($liver_details['globulin_result_value'] ?? null) === null) {

                    $report_issues[] = "Globulin TestResultDetails are empty";
                    $report_issues_email[] = "Globulin TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Globulin reference ranges are empty";
                    $report_issues_email[] = " Globulin reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Globulin BR Interval are empty";
                    $report_issues_email[] = "  Globulin BR Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['globulin_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['globulin_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['globulin_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['globulin_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['globulin_uom']);
                $liver_details['globulin_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['globulin_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code GLOB";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code GLOB" . FindTestgroupAddress('LFT.');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['globulin_test_remraks'] = "Globulin - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['globulin_test_remraks'] = '';
                }
                $liver_details['globulin_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['globulin_low_result_value']) {
                    $liver_details['globulin_result_value_in_words'] = 'Low';
                    $liver_details['globulin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['globulin_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['globulin_high_result_value']) {
                    $liver_details['globulin_result_value_in_words'] = 'Normal';
                    $liver_details['globulin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['globulin_high_result_value']) {
                    $liver_details['globulin_result_value_in_words'] = 'High';
                    $liver_details['globulin_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['globulin_low_result_value']  || $resultData->RESULT_VALUE > $liver_details['globulin_high_result_value']) {
                    $liver_details['globulin_impact_on_health'] = "Increased levels of serum Globulins is seen in infection, inflammatory disease or immune disorders Liver dysfunction, Malnutrition and congenital immune deficiency can cause decrease in total globulins due to reduced synthesis";
                } else {
                    $liver_details['globulin_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > $liver_details['globulin_high_result_value']) {
                    $liver_details['globulin_suggestion'] = "(1) Maintain healthy weight. (2) Eat balanced diet (3) Exercise regularly (4) Avoid toxins (5) use alcohol responsibly (6) Avoid contaminated needles (7) Get medical care if you’re exposed to blood. (8) Practice safe sex. (9) Get vaccinated";
                } else {
                    $liver_details['globulin_suggestion'] = '';
                }
            }
        }
        if (!$globulin_result_value) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'GLOB' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'GLOB' not found" . FindTestgroupAddress('LFT.');
        }
        // Albumin sub test
        $albumin_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'ALB') {
                $albumin_result_found =  true;
                $liver_details['albumin_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['albumin_result_value'] ?? null) === '' || ($liver_details['albumin_result_value'] ?? null) === null) {

                    $report_issues[] = "Albumin TestResultDetails are empty";
                    $report_issues_email[] = "Albumin TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Albumin reference ranges are empty";
                    $report_issues_email[] = " Albumin reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Albumin BR Interval are empty";
                    $report_issues_email[] = "  Albumin BR Interval are empty" . FindTestgroupAddress('LFT.');
                }


                $liver_details['albumin_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['albumin_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['albumin_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['albumin_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['albumin_uom']);
                $liver_details['albumin_BRInterval_result_value'] = trim(nl2br($resultData->BRInterval));


                $range_map = [];

                $brInterval = trim($liver_details['albumin_BRInterval_result_value']);
                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {
                    // Also clean single range
                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }

                $liver_details['albumin_reference_ranges_value'] = $range_map;

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['albumin_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code ALB";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code ALB" . FindTestgroupAddress('LFT.');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['albumin_test_remraks'] = "Albumin - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['albumin_test_remraks'] = '';
                }
                $liver_details['albumin_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['albumin_low_result_value']) {
                    $liver_details['albumin_result_value_in_words'] = 'Low';
                    $liver_details['albumin_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['albumin_low_result_value']  && $resultData->RESULT_VALUE <= $liver_details['albumin_high_result_value']) {
                    $liver_details['albumin_result_value_in_words'] = 'Normal';
                    $liver_details['albumin_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['albumin_high_result_value']) {
                    $liver_details['albumin_result_value_in_words'] = 'High';
                    $liver_details['albumin_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['albumin_low_result_value']  || $resultData->RESULT_VALUE > $liver_details['albumin_high_result_value']) {
                    $liver_details['albumin_impact_on_health'] = "Increased Levels: seen only in acute dehydration.Decreased Levels: from decreased synthesis, increased catabolism , or combinations of these. Decreased synthesis may be primary or genetic (Analbuminemia) or acquired (inflammatory processes). Hypoalbnminemia may result in underestimation of the anion gap when evaluating fluid and electrolyte status";
                } else {
                    $liver_details['albumin_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['albumin_low_result_value']  || $resultData->RESULT_VALUE > $liver_details['albumin_high_result_value']) {
                    $liver_details['albumin_suggestion'] = "(1) Maintain healthy weight. (2) Eat balanced diet (3) Exercise regularly (4) Avoid toxins (5) use alcohol responsibly (6) Avoid contaminated needles (7) Get medical care if you’re exposed to blood. (8) Practice safe sex. (9) Get vaccinated";
                } else {
                    $liver_details['albumin_suggestion'] = '';
                }
            }
        }
        if (!$albumin_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'ALB' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'ALB' not found" . FindTestgroupAddress('LFT.');
        }
        // A : G ratio sub test
        $ag_ratio_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'LFT.' && explode('|', $resultData->TEST_CODE)[0] == 'AGR') {
                $ag_ratio_result_found = true;
                $liver_details['ag_ratio_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['ag_ratio_result_value'] ?? null) === '' || ($liver_details['ag_ratio_result_value'] ?? null) === null) {

                    $report_issues[] = "A : G ratio TestResultDetails are empty";
                    $report_issues_email[] = "A : G ratio TestResultDetails are empty" . FindTestgroupAddress('LFT.');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " A : G ratio reference ranges are empty";
                    $report_issues_email[] = " A : G ratio reference ranges are empty" . FindTestgroupAddress('LFT.');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  A : G ratio BR Interval are empty";
                    $report_issues_email[] = "  A : G ratio BR Interval are empty" . FindTestgroupAddress('LFT.');
                }

                $liver_details['ag_ratio_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['ag_ratio_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['ag_ratio_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['ag_ratio_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['ag_ratio_uom']);
                $liver_details['ag_ratio_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['ag_ratio_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code AGR";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code LFT. and test code AGR" . FindTestgroupAddress('LFT.');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['ag_ratio_test_remraks'] = "A : G ratio - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['ag_ratio_test_remraks'] = '';
                }

                $liver_details['ag_ratio_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['ag_ratio_low_result_value']) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'Low';
                    $liver_details['ag_ratio_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['ag_ratio_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['ag_ratio_high_result_value']) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'Normal';
                    $liver_details['ag_ratio_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['ag_ratio_high_result_value']) {
                    $liver_details['ag_ratio_result_value_in_words'] = 'High';
                    $liver_details['ag_ratio_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $liver_details['ag_ratio_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['ag_ratio_high_result_value']) {
                    $liver_details['ag_ratio_impact_on_health'] = "A total protein and A/G ratio test is often included as part of a comprehensive metabolic panel, a test that measures proteins and other substances in the blood. It may also be used to help diagnose kidney disease, liver disease, or nutritional problems";
                } else {
                    $liver_details['ag_ratio_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['ag_ratio_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['ag_ratio_high_result_value']) {
                    $liver_details['ag_ratio_suggestion'] = "Consult your physician if you get a abnormal value";
                } else {
                    $liver_details['ag_ratio_suggestion'] = '';
                }
                if ($resultData->RESULT_VALUE < $liver_details['ag_ratio_low_result_value'] || $resultData->RESULT_VALUE > $liver_details['ag_ratio_high_result_value']) {
                    $liver_details['ag_ratio_about_your_result'] = "During your liver health check we have found out that SGOT-AST , Total Protein, Globulin are your concern parameters, which can impact your health";
                } else {
                    $liver_details['ag_ratio_about_your_result'] = '';
                }
            }
        }
        if (!$ag_ratio_result_found) {

            $report_issues[] = " Test Group 'LFT.' or Test Code 'AGR' not found";
            $report_issues_email[] = " Test Group 'LFT.' or Test Code 'AGR' not found" . FindTestgroupAddress('LFT.');
        }
    }


    if ($PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' ||  $PackageCode == 'AYN_031') {
        // Amylase, Serum
        $amylase_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'A0011' && explode('|', $resultData->TEST_CODE)[0] == 'AMLYASE') {
                $amylase_result_found = true;
                $liver_details['amylase_result_value'] = $resultData->RESULT_VALUE;
                if (($liver_details['amylase_result_value'] ?? null) === '' || ($liver_details['amylase_result_value'] ?? null) === null) {

                    $report_issues[] = "Amylase, Serum TestResultDetails are empty";
                    $report_issues_email[] = "Amylase, Serum TestResultDetails are empty" . FindTestgroupAddress('A0011');
                }
                if (!isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === "") {

                    $report_issues[] = " Amylase, Serum reference ranges are empty";
                    $report_issues_email[] = " Amylase, Serum reference ranges are empty" . FindTestgroupAddress('A0011');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = "  Amylase, Serum BR Interval are empty";
                    $report_issues_email[] = "  Amylase, Serum BR Interval are empty" . FindTestgroupAddress('A0011');
                }

                $liver_details['amylase_low_result_value'] = $resultData->LOW_VALUE;
                $liver_details['amylase_high_result_value'] = $resultData->HIGH_VALUE;
                $liver_details['amylase_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $liver_details['amylase_uom'] = str_replace(["�", "ï¿½"], "μ", $liver_details['amylase_uom']);
                $liver_details['amylase_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $liver_details['amylase_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code A0011 and test code AMYLASE";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code A0011 and test code AMYLASE" . FindTestgroupAddress('A0011');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $liver_details['amylase_test_remraks'] = "Amylase - " . $resultData->TEST_REMARKS;
                } else {
                    $liver_details['amylase_test_remraks'] = '';
                }

                $liver_details['amylase_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $liver_details['amylase_low_result_value']) {
                    $liver_details['amylase_result_value_in_words'] = 'Low';
                    $liver_details['amylase_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $liver_details['amylase_low_result_value'] && $resultData->RESULT_VALUE <= $liver_details['amylase_high_result_value']) {
                    $liver_details['amylase_result_value_in_words'] = 'Normal';
                    $liver_details['amylase_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $liver_details['amylase_high_result_value']) {
                    $liver_details['amylase_result_value_in_words'] = 'High';
                    $liver_details['amylase_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >  $liver_details['amylase_high_result_value']) {
                    $liver_details['amylase_impact_on_health'] = "It is elevated in Acute pancreatitis and acute exacerbation of Chronic pancreatitis. Even in cases of obstruction of the pancreatic duct and drug-induced Acute pancreatitis, Serum Amylase levels are elevated";
                } else {
                    $liver_details['amylase_impact_on_health'] = '';
                }

                if ($resultData->RESULT_VALUE > $liver_details['amylase_high_result_value']) {
                    $liver_details['amylase_suggestion'] = "";
                } else {
                    $liver_details['amylase_suggestion'] = '';
                }
            }
        }
        if (!$amylase_result_found) {

            $report_issues[] = " Test Group 'A0011' or Test Code 'AMYLASE' not found";
            $report_issues_email[] = " Test Group 'A0011' or Test Code 'AMYLASE' not found" . FindTestgroupAddress('A0011');
        }
    }
    return $liver_details;
}


/**
 * Description: The getLiverTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for liver-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getLiverTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $LiverNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_025' || $PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028') {

            if ($resultData->TEST_GROUP_CODE === 'LFT.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code LFT";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code LFT" . FindTestgroupAddress('LFT.');
                }

                $LiverNablAccredited['LFT_liver_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $LiverNablAccredited['LFT_liver_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif ($PackageCode == 'AYN_031' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_029') {

            if ($resultData->TEST_GROUP_CODE === 'LFT.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code LFT";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code LFT" . FindTestgroupAddress('LFT.');
                }

                $LiverNablAccredited['LFT_liver_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $LiverNablAccredited['LFT_liver_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE === 'A0011') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code A0011";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code A0011" . FindTestgroupAddress('A0011');
                }

                $LiverNablAccredited['A0011_liver_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $LiverNablAccredited['A0011_liver_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        }
    }

    return $LiverNablAccredited;
}

/**
 * Description : getUrineDetails() function to get test result details for the urine section.
 * 
 * This function retrieves urine-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to urine diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the urine section.
 */

function getUrineDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $urine_details = [];

    $urine_details['urinestatus_found'] = 0;
    $foundR0007j = false;

    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if (explode('|', $resultData->TEST_GROUP_CODE)[0] == 'R0007j') {
            $foundR0007j = true;
            break;
        }
    }

    if (!$foundR0007j) {
        $urine_details['urinestatus_found'] = 1;
    }



    if (!$urine_details['urinestatus_found']) {

        // Bacteria
        $bacteria_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'BACT') {
                $bacteria_result_found = true;
                $urine_details['bacteria_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['bacteria_result_value'] ?? null) === '' || ($urine_details['bacteria_result_value'] ?? null) === null) {
                    $report_issues[] = "Bacteria TestResultDetails are empty";
                    $report_issues_email[] = "Bacteria TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['bacteria_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code BACT";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code BACT" . FindTestgroupAddress('R0007j');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['bacteria_test_remraks'] = "Bacteria - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['bacteria_test_remraks'] = '';
                }

                $urine_details['bacteria_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['bacteria_result_value_in_words'] = 'Present';
                    $urine_details['bacteria_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['bacteria_result_value_in_words'] = 'Absent';
                    $urine_details['bacteria_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['bacteria_result_value_in_words'] = 'Nil';
                    $urine_details['bacteria_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['bacteria_result_value_in_words'] = 'Negative';
                    $urine_details['bacteria_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['bacteria_result_value_in_words'] = 'Normal';
                    $urine_details['bacteria_color_code'] = "green";
                } else {
                    $urine_details['bacteria_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['bacteria_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE == 'Present') {
                    $urine_details['bacteria_impact_on_health'] = "Recurrent Urinary tract infections, especially in women who experience two or more.Permanent kidney damage from an acute or chronic kidney infection (pyelonephritis) due to an untreated UTI";
                } else {
                    $urine_details['bacteria_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE == 'Present') {
                    $urine_details['bacteria_suggestions'] = "Drink plenty of water, use neat & clean washroom, Release your urine at shorter period";
                } else {
                    $urine_details['bacteria_suggestions'] = '';
                }
            }
        }
        if (!$bacteria_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'BACT' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'BACT' not found" . FindTestgroupAddress('R0007j');
        }
        // Colour sub test under urine
        $urine_colour_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'COL') {
                $urine_colour_result_found = true;
                $urine_details['urine_colour_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_colour_result_value'] ?? null) === '' || ($urine_details['urine_colour_result_value'] ?? null) === null) {

                    $report_issues[] = " Colour TestResultDetails are empty";
                    $report_issues_email[] = " Colour TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_colour_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code COL";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code COL" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_colour_test_remraks'] = "Colour - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_colour_test_remraks'] = '';
                }

                $urine_details['urine_colour_sample_method'] = $resultData->NEW_METHOD;
            }
        }
        if (!$urine_colour_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'COL' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'COL' not found" . FindTestgroupAddress('R0007j');
        }

        // Volume sub test under urine
        $volume_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'VOLU') {
                $volume_result_found  = true;
                $urine_details['volume_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['volume_result_value'] ?? null) === '' || ($urine_details['volume_result_value'] ?? null) === null) {

                    $report_issues[] = "Volume TestResultDetails are empty";
                    $report_issues_email[] = "Volume TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                $urine_details['volume_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $urine_details['volume_uom'] = str_replace(["�", "ï¿½"], "μ", $urine_details['volume_uom']);
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['volume_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code VOLU";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code VOLU" . FindTestgroupAddress('R0007j');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['volume_test_remraks'] = "Colour - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['volume_test_remraks'] = '';
                }

                $urine_details['volume_sample_method'] = $resultData->NEW_METHOD;
            }
        }
        if (!$volume_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'VOLU' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'VOLU' not found" . FindTestgroupAddress('R0007j');
        }

        // Specific Gravity sub test
        $urine_specific_gravity_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' &&  explode('|', $resultData->TEST_CODE)[0] == 'SG') {
                $urine_specific_gravity_result_found =  true;
                $urine_details['urine_specific_gravity_result_value'] = $resultData->RESULT_VALUE;
                $urine_details['urine_specific_gravity_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $urine_details['urine_specific_gravity_result_value']);
                if (($urine_details['urine_specific_gravity_result_value'] ?? null) === '' || ($urine_details['urine_specific_gravity_result_value'] ?? null) === null) {

                    $report_issues[] = "Specific Gravity TestResultDetails are empty";
                    $report_issues_email[] = "Specific Gravity TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Specific Gravity reference ranges are empty";
                    $report_issues_email[] = " Specific Gravity reference ranges are empty" . FindTestgroupAddress('R0007j');
                }
                $urine_details['urine_specific_gravity_low_result_value'] = $resultData->LOW_VALUE;
                $urine_details['urine_specific_gravity_high_result_value'] = $resultData->HIGH_VALUE;
                $urine_details['urine_specific_gravity_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $urine_details['urine_specific_gravity_uom'] = str_replace(["�", "ï¿½"], "μ", $urine_details['urine_specific_gravity_uom']);
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_specific_gravity_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code SG";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code SG" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_specific_gravity_test_remraks'] = "Specific Gravity - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_specific_gravity_test_remraks'] = '';
                }
                $urine_details['urine_specific_gravity_sample_method'] = $resultData->NEW_METHOD;
                if ($urine_details['urine_specific_gravity_result_value_cleaned'] < $urine_details['urine_specific_gravity_low_result_value']) {
                    $urine_details['urine_specific_gravity_result_value_in_words'] = 'Low';
                    $urine_details['urine_specific_gravity_color_code'] = "red";
                }
                if ($urine_details['urine_specific_gravity_result_value_cleaned'] >= $urine_details['urine_specific_gravity_low_result_value'] && $urine_details['urine_specific_gravity_result_value_cleaned'] <= $urine_details['urine_specific_gravity_high_result_value']) {
                    $urine_details['urine_specific_gravity_result_value_in_words'] = 'Normal';
                    $urine_details['urine_specific_gravity_color_code'] = "green";
                }
                if ($urine_details['urine_specific_gravity_result_value_cleaned'] > $urine_details['urine_specific_gravity_high_result_value']) {
                    $urine_details['urine_specific_gravity_result_value_in_words'] = 'High';
                    $urine_details['urine_specific_gravity_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($urine_details['urine_specific_gravity_result_value_cleaned'] < $urine_details['urine_specific_gravity_low_result_value'] || $urine_details['urine_specific_gravity_result_value_cleaned'] > $urine_details['urine_specific_gravity_high_result_value']) {
                    $urine_details['urine_specific_gravity_impact_on_health'] = "";
                }
                if ($urine_details['urine_specific_gravity_result_value_cleaned'] < $urine_details['urine_specific_gravity_low_result_value'] || $urine_details['urine_specific_gravity_result_value_cleaned'] > $urine_details['urine_specific_gravity_high_result_value']) {
                    $urine_details['urine_specific_gravity_suggestions'] = "";
                }
            }
        }
        if (!$urine_specific_gravity_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'SG' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'SG' not found" . FindTestgroupAddress('R0007j');
        }
        // Appearance sub test
        $urine_appearance_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'APP') {
                $urine_appearance_result_found = true;
                $urine_details['urine_appearance_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_appearance_result_value'] ?? null) === '' || ($urine_details['urine_appearance_result_value'] ?? null) === null) {

                    $report_issues[] = "Appearance TestResultDetails are empty";
                    $report_issues_email[] = "Appearance TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_appearance_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code SG";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code SG" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_appearance_test_remraks'] = "Appearance - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_appearance_test_remraks'] = '';
                }

                $urine_details['urine_appearance_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE == 'Clear') {
                    $urine_details['urine_appearance_result_value_in_words'] = 'Normal';
                    $urine_details['urine_appearance_color_code'] = "green";
                } else {
                    $urine_details['urine_appearance_result_value_in_words'] = 'High';
                    $urine_details['urine_appearance_color_code'] = "red";
                }
            }
        }
        if (!$urine_appearance_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'SG' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'SG' not found" . FindTestgroupAddress('R0007j');
        }
        // //Leukocyte Esterase sub test
        if ($PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_025') {
            // RBCs sub test
            $rbcs_result_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'RBCSU') {
                    $rbcs_result_found = true;
                    $urine_details['rbcs_result_value'] = $resultData->RESULT_VALUE;
                    if (($urine_details['rbcs_result_value'] ?? null) === '' || ($urine_details['rbcs_result_value'] ?? null) === null) {

                        $report_issues[] = "RBCs TestResultDetails are empty";
                        $report_issues_email[] = "RBCs TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                    }
                    $urine_details['rbcs_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                    $urine_details['rbcs_uom'] = str_replace(["�", "ï¿½"], "μ", $urine_details['rbcs_uom']);
                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $urine_details['rbcs_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {

                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code RBCSU";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code RBCSU" . FindTestgroupAddress('R0007j');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $urine_details['rbcs_test_remraks'] = "RBCs - " . $resultData->TEST_REMARKS;
                    } else {
                        $urine_details['rbcs_test_remraks'] = '';
                    }


                    $urine_details['rbcs_sample_method'] = $resultData->NEW_METHOD;
                    if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                        $urine_details['rbcs_result_value_in_words'] = 'Absent';
                        $urine_details['rbcs_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                        $urine_details['rbcs_result_value_in_words'] = 'Present';
                        $urine_details['rbcs_color_code'] = "red";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                        $urine_details['rbcs_result_value_in_words'] = 'Normal';
                        $urine_details['rbcs_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                        $urine_details['rbcs_result_value_in_words'] = 'Negative';
                        $urine_details['rbcs_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                        $urine_details['rbcs_result_value_in_words'] = 'Nil';
                        $urine_details['rbcs_color_code'] = "green";
                    } elseif (preg_match('/^0-(\d+)$/', $resultData->RESULT_VALUE, $matches) && (int)$matches[1] < 1) {
                        $urine_details['rbcs_result_value_in_words'] = $resultData->RESULT_VALUE;
                        $urine_details['rbcs_color_code'] = "green";
                    } elseif ($resultData->RESULT_VALUE === "0") {
                        $urine_details['rbcs_result_value_in_words'] = $resultData->RESULT_VALUE;
                        $urine_details['rbcs_color_code'] = "green";
                    } else {
                        $urine_details['rbcs_result_value_in_words'] = $resultData->RESULT_VALUE;
                        $urine_details['rbcs_color_code'] = "red";
                    }
                }
            }
            if (!$rbcs_result_found) {

                $report_issues[] = " Test Group 'R0007j' or Test Code 'RBCSU' not found";
                $report_issues_email[] = " Test Group 'R0007j' or Test Code 'RBCSU' not found" . FindTestgroupAddress('R0007j');
            }
            //CASTS sub test
            $casts_result_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'R0007j' &&  explode('|', $resultData->TEST_CODE)[0] == 'CAS') {
                    $casts_result_found = true;
                    $urine_details['casts_result_value'] = $resultData->RESULT_VALUE;
                    if (($urine_details['casts_result_value'] ?? null) === '' || ($urine_details['casts_result_value'] ?? null) === null) {

                        $report_issues[] = "Casts TestResultDetails are empty";
                        $report_issues_email[] = "Casts TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                    }
                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $urine_details['casts_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {

                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code CAS";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code CAS" . FindTestgroupAddress('R0007j');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $urine_details['casts_test_remraks'] = "Casts - " . $resultData->TEST_REMARKS;
                    } else {
                        $urine_details['casts_test_remraks'] = '';
                    }

                    $urine_details['casts_sample_method'] = $resultData->NEW_METHOD;
                    if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                        $urine_details['casts_result_value_in_words'] = 'Absent';
                        $urine_details['casts_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                        $urine_details['casts_result_value_in_words'] = 'Present';
                        $urine_details['casts_color_code'] = "red";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                        $urine_details['casts_result_value_in_words'] = 'Normal';
                        $urine_details['casts_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                        $urine_details['casts_result_value_in_words'] = 'Negative';
                        $urine_details['casts_color_code'] = "green";
                    } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                        $urine_details['casts_result_value_in_words'] = 'Nil';
                        $urine_details['casts_color_code'] = "green";
                    } else {
                        $urine_details['casts_result_value_in_words'] = $resultData->RESULT_VALUE;
                        $urine_details['casts_color_code'] = "red";
                    }
                }
            }
            if (!$casts_result_found) {

                $report_issues[] = " Test Group 'R0007j' or Test Code 'CAS' not found";
                $report_issues_email[] = " Test Group 'R0007j' or Test Code 'CAS' not found" . FindTestgroupAddress('R0007j');
            }
        }

        // PH sub test
        $urine_ph_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'URINEPH') {
                $urine_ph_result_found = true;
                $urine_details['urine_ph_result_value'] = $resultData->RESULT_VALUE;
                $urine_details['urine_ph_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $urine_details['urine_ph_result_value']);
                if (($urine_details['urine_ph_result_value'] ?? null) === '' || ($urine_details['urine_ph_result_value'] ?? null) === null) {
                    $report_issues[] = "PH TestResultDetails are empty";
                    $report_issues_email[] = "PH TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = "PH reference ranges are empty";
                    $report_issues_email[] = "PH reference ranges are empty" . FindTestgroupAddress('R0007j');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " PH Interval are empty";
                    $report_issues_email[] = " PH Interval are empty" . FindTestgroupAddress('R0007j');
                }
                $urine_details['urine_ph_low_result_value'] = $resultData->LOW_VALUE;
                $urine_details['urine_ph_high_result_value'] = $resultData->HIGH_VALUE;
                $urine_details['urine_ph_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_ph_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URINEPH";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URINEPH" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_ph_test_remraks'] = "Ph - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_ph_test_remraks'] = '';
                }


                $urine_details['urine_ph_sample_method'] = $resultData->NEW_METHOD;
                if ($urine_details['urine_ph_result_value_cleaned'] < $urine_details['urine_ph_low_result_value']) {
                    $urine_details['urine_ph_result_value_in_words'] = 'Low';
                    $urine_details['urine_ph_color_code'] = "red";
                }
                if ($urine_details['urine_ph_result_value_cleaned'] >= $urine_details['urine_ph_low_result_value'] && $urine_details['urine_ph_result_value_cleaned'] <= $urine_details['urine_ph_high_result_value']) {
                    $urine_details['urine_ph_result_value_in_words'] = 'Normal';
                    $urine_details['urine_ph_color_code'] = "green";
                }
                if ($urine_details['urine_ph_result_value_cleaned'] > $urine_details['urine_ph_high_result_value']) {
                    $urine_details['urine_ph_result_value_in_words'] = 'High';
                    $urine_details['urine_ph_color_code'] = "red";
                }
            }
        }
        if (!$urine_ph_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'URINEPH' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'URINEPH' not found" . FindTestgroupAddress('R0007j');
        }

        // Protein sub test
        $urine_protein_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'URP') {
                $urine_protein_result_found =  true;
                $urine_details['urine_protein_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_protein_result_value'] ?? null) === '' || ($urine_details['urine_protein_result_value'] ?? null) === null) {

                    $report_issues[] = "Protein TestResultDetails are empty";
                    $report_issues_email[] = "Protein TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_protein_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URP";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URP" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_protein_test_remraks'] = "Protein - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_protein_test_remraks'] = '';
                }

                $urine_details['urine_protein_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Absent';
                    $urine_details['urine_protein_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Present';
                    $urine_details['urine_protein_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Normal';
                    $urine_details['urine_protein_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Negative';
                    $urine_details['urine_protein_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Nil';
                    $urine_details['urine_protein_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Trace') === 0) {
                    $urine_details['urine_protein_result_value_in_words'] = 'Trace';
                    $urine_details['urine_protein_color_code'] = "red";
                } else {
                    $urine_details['urine_protein_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_protein_color_code'] = "red";
                }
            }
        }
        if (!$urine_protein_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'URP' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'URP' not found" . FindTestgroupAddress('R0007j');
        }
        // Glucose sub test
        $urine_glucose_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' &&  explode('|', $resultData->TEST_CODE)[0] == 'URCLU') {
                $urine_glucose_result_found = true;
                $urine_details['urine_glucose_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_glucose_result_value'] ?? null) === '' || ($urine_details['urine_glucose_result_value'] ?? null) === null) {

                    $report_issues[] = "Glucose TestResultDetails are empty";
                    $report_issues_email[] = "Glucose TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_glucose_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URCLU";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URCLU" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_glucose_test_remraks'] = "Glucose - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_glucose_test_remraks'] = '';
                }



                $urine_details['urine_glucose_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_glucose_result_value_in_words'] = 'Absent';
                    $urine_details['urine_glucose_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_glucose_result_value_in_words'] = 'Present';
                    $urine_details['urine_glucose_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_glucose_result_value_in_words'] = 'Normal';
                    $urine_details['urine_glucose_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_glucose_result_value_in_words'] = 'Negative';
                    $urine_details['urine_glucose_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_glucose_result_value_in_words'] = 'Nil';
                    $urine_details['urine_glucose_color_code'] = "green";
                } else {
                    $urine_details['urine_glucose_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_glucose_color_code'] = "red";
                }
            }
        }
        if (!$urine_protein_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'URCLU' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'URCLU' not found" . FindTestgroupAddress('R0007j');
        }
        // Ketones sub test
        $urine_ketones_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'KETON') {
                $urine_ketones_result_found = true;
                $urine_details['urine_ketones_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_ketones_result_value'] ?? null) === '' || ($urine_details['urine_ketones_result_value'] ?? null) === null) {

                    $report_issues[] = "Ketones TestResultDetails are empty";
                    $report_issues_email[] = "Ketones TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_ketones_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code KETON";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code KETON" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_ketones_test_remraks'] = "Ketones - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_ketones_test_remraks'] = '';
                }

                $urine_details['urine_ketones_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_ketones_result_value_in_words'] = 'Absent';
                    $urine_details['urine_ketones_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_ketones_result_value_in_words'] = 'Negative';
                    $urine_details['urine_ketones_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_ketones_result_value_in_words'] = 'Normal';
                    $urine_details['urine_ketones_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_ketones_result_value_in_words'] = 'Present';
                    $urine_details['urine_ketones_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_ketones_result_value_in_words'] = 'Nil';
                    $urine_details['urine_ketones_color_code'] = "green";
                } else {
                    $urine_details['urine_ketones_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_ketones_color_code'] = "red";
                }
            }
        }
        if (!$urine_ketones_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'KETON' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'KETON' not found" . FindTestgroupAddress('R0007j');
        }
        // Urobilinogen sub test
        $urine_urobilinogen_result_found =  false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'URO') {
                $urine_urobilinogen_result_found =  true;
                $urine_details['urine_urobilinogen_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_urobilinogen_result_value'] ?? null) === '' || ($urine_details['urine_urobilinogen_result_value'] ?? null) === null) {

                    $report_issues[] = "Urobilinogen TestResultDetails are empty";
                    $report_issues_email[] = "Urobilinogen TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_urobilinogen_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URO";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URO" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_urobilinogen_test_remraks'] = "Urobilinogen - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_urobilinogen_test_remraks'] = '';
                }


                $urine_details['urine_urobilinogen_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_urobilinogen_result_value_in_words'] = 'Absent';
                    $urine_details['urine_urobilinogen_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_urobilinogen_result_value_in_words'] = 'Negative';
                    $urine_details['urine_urobilinogen_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_urobilinogen_result_value_in_words'] = 'Normal';
                    $urine_details['urine_urobilinogen_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_urobilinogen_result_value_in_words'] = 'Present';
                    $urine_details['urine_urobilinogen_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_urobilinogen_result_value_in_words'] = 'Nil';
                    $urine_details['urine_urobilinogen_color_code'] = "green";
                } else {

                    $urine_details['urine_urobilinogen_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_urobilinogen_color_code'] = "red";
                }
            }
        }
        if (!$urine_urobilinogen_result_found) {
            $report_issues[] = " Test Group 'R0007j' or Test Code 'URO' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'URO' not found" . FindTestgroupAddress('R0007j');
        }
        // Bilirubin sub test
        $urine_bilirubin_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'UBIL') {
                $urine_bilirubin_result_found = true;
                $urine_details['urine_bilirubin_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_bilirubin_result_value'] ?? null) === '' || ($urine_details['urine_bilirubin_result_value'] ?? null) === null) {

                    $report_issues[] = "Bilirubin TestResultDetails are empty";
                    $report_issues_email[] = "Bilirubin TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_bilirubin_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UBIL";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UBIL" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_bilirubin_test_remraks'] = "Bilirubin - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_bilirubin_test_remraks'] = '';
                }


                $urine_details['urine_bilirubin_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_bilirubin_result_value_in_words'] = 'Absent';
                    $urine_details['urine_bilirubin_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_bilirubin_result_value_in_words'] = 'Present';
                    $urine_details['urine_bilirubin_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_bilirubin_result_value_in_words'] = 'Normal';
                    $urine_details['urine_bilirubin_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_bilirubin_result_value_in_words'] = 'Negative';
                    $urine_details['urine_bilirubin_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_bilirubin_result_value_in_words'] = 'Nil';
                    $urine_details['urine_bilirubin_color_code'] = "green";
                } else {
                    $urine_details['urine_bilirubin_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_bilirubin_color_code'] = "red";
                }
            }
        }
        if (!$urine_bilirubin_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'UBIL' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'UBIL' not found" . FindTestgroupAddress('R0007j');
        }

        // Nitrite sub test
        $urine_nitrite_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'NIT') {
                $urine_nitrite_result_found = true;
                $urine_details['urine_nitrite_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_nitrite_result_value'] ?? null) === '' || ($urine_details['urine_nitrite_result_value'] ?? null) === null) {

                    $report_issues[] = "Nitrite TestResultDetails are empty";
                    $report_issues_email[] = "Nitrite TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_nitrite_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code NIT";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code NIT" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_nitrite_test_remraks'] = "Nitrite - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_nitrite_test_remraks'] = '';
                }

                $urine_details['urine_nitrite_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_nitrite_result_value_in_words'] = 'Absent';
                    $urine_details['urine_nitrite_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_nitrite_result_value_in_words'] = 'Present';
                    $urine_details['urine_nitrite_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_nitrite_result_value_in_words'] = 'Normal';
                    $urine_details['urine_nitrite_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_nitrite_result_value_in_words'] = 'Negative';
                    $urine_details['urine_nitrite_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_nitrite_result_value_in_words'] = 'Nil';
                    $urine_details['urine_nitrite_color_code'] = "green";
                } else {
                    $urine_details['urine_nitrite_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_nitrite_color_code'] = "red";
                }
            }
        }
        if (!$urine_nitrite_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'NIT' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'NIT' not found" . FindTestgroupAddress('R0007j');
        }

        // Blood sub test
        $urine_blood_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' &&  explode('|', $resultData->TEST_CODE)[0] == 'UBLD') {
                $urine_blood_result_found = true;
                $urine_details['urine_blood_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_blood_result_value'] ?? null) === '' || ($urine_details['urine_blood_result_value'] ?? null) === null) {

                    $report_issues[] = "Blood TestResultDetails are empty";
                    $report_issues_email[] = "Blood TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_blood_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UBLD";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UBLD" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_blood_test_remraks'] = "Blood - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_blood_test_remraks'] = '';
                }

                $urine_details['urine_blood_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_blood_result_value_in_words'] = 'Absent';
                    $urine_details['urine_blood_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_blood_result_value_in_words'] = 'Present';
                    $urine_details['urine_blood_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_blood_result_value_in_words'] = 'Normal';
                    $urine_details['urine_blood_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_blood_result_value_in_words'] = 'Negative';
                    $urine_details['urine_blood_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_blood_result_value_in_words'] = 'Nil';
                    $urine_details['urine_blood_color_code'] = "green";
                } else {
                    $urine_details['urine_blood_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_blood_color_code'] = "red";
                }
            }
        }
        if (!$urine_blood_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'UBLD' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'UBLD' not found" . FindTestgroupAddress('R0007j');
        }
        // Pus Cell sub test
        $urine_puscell_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'UPUS') {
                $urine_puscell_result_found = true;
                $urine_details['urine_puscell_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_puscell_result_value'] ?? null) === '' || ($urine_details['urine_puscell_result_value'] ?? null) === null) {

                    $report_issues[] = "Pus Cell TestResultDetails are empty";
                    $report_issues_email[] = "Pus Cell TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (!preg_match('/\d+/', trim($resultData->RESULT_VALUE))) {

                    $report_issues[] = " Pus Cell only accept numeric data in BR intervals";
                    $report_issues_email[] = " Pus Cell only accept numeric data in BR intervals" . FindTestgroupAddress('R0007j');
                }

                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = "Pus Cell reference ranges are empty";
                    $report_issues_email[] = "Pus Cell reference ranges are empty" . FindTestgroupAddress('R0007j');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Pus Cell Interval are empty";
                    $report_issues_email[] = " Pus Cell Interval are empty" . FindTestgroupAddress('R0007j');
                }
                $urine_details['urine_puscell_low_result_value'] = $resultData->LOW_VALUE;
                $urine_details['urine_puscell_high_result_value'] = $resultData->HIGH_VALUE;
                $urine_details['urine_puscell_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $urine_details['urine_puscell_uom'] = str_replace(["�", "ï¿½"], "μ", $urine_details['urine_puscell_uom']);
                $urine_details['urine_puscell_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_puscell_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UPUS";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code UPUS" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_blood_test_remraks'] = "Pus Cell - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_blood_test_remraks'] = '';
                }

                $urine_details['urine_puscell_sample_method'] = $resultData->NEW_METHOD;

                if (preg_match_all('/\d+/', trim($resultData->RESULT_VALUE), $matches)) {
                    $urine_details['urine_puscell_secondvalue'] = isset($matches[0][1]) ? (int)$matches[0][1] : (int)$matches[0][0];

                    if ($urine_details['urine_puscell_secondvalue'] < $urine_details['urine_puscell_low_result_value']) {
                        $urine_details['urine_puscell_result_value_in_words'] = 'Low';
                        $urine_details['urine_puscell_color_code'] = "red";
                    } elseif ($urine_details['urine_puscell_secondvalue'] >= $urine_details['urine_puscell_low_result_value'] &&  $urine_details['urine_puscell_secondvalue'] <= $urine_details['urine_puscell_high_result_value']) {
                        $urine_details['urine_puscell_result_value_in_words'] = 'Normal';
                        $urine_details['urine_puscell_color_code'] = "green";
                    } elseif ($urine_details['urine_puscell_secondvalue'] > $urine_details['urine_puscell_high_result_value']) {
                        $urine_details['urine_puscell_result_value_in_words'] = 'High';
                        $urine_details['urine_puscell_color_code'] = "red";
                    } else {
                        $urine_details['urine_puscell_result_value_in_words'] = '';
                        $urine_details['urine_puscell_color_code'] = "black";
                    }
                } else {
                    $urine_details['urine_puscell_secondvalue'] = '';
                    $urine_details['urine_puscell_result_value_in_words'] = '';
                    $urine_details['urine_puscell_color_code'] = "black";
                }
            }
        }
        if (!$urine_puscell_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'UPUS' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'UPUS' not found" . FindTestgroupAddress('R0007j');
        }

        // Epithelial Cells sub test
        $urine_epithelialcell_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'URINEP') {
                $urine_epithelialcell_result_found = true;
                $urine_details['urine_epithelialcell_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_epithelialcell_result_value'] ?? null) === '' || ($urine_details['urine_epithelialcell_result_value'] ?? null) === null) {

                    $report_issues[] = "Epithelial Cells TestResultDetails are empty";
                    $report_issues_email[] = "Epithelial Cells TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (!preg_match('/\d+/', trim($resultData->RESULT_VALUE))) {

                    $report_issues[] = " Epithelial Cells only accept number data in BR intervals";
                    $report_issues_email[] = " Epithelial Cells only accept number data in BR intervals" . FindTestgroupAddress('R0007j');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = "Epithelial Cells reference ranges are empty";
                    $report_issues_email[] = "Epithelial Cells reference ranges are empty" . FindTestgroupAddress('R0007j');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Epithelial Cells Interval are empty";
                    $report_issues_email[] = " Epithelial Cells Interval are empty" . FindTestgroupAddress('R0007j');
                }
                $urine_details['urine_epithelialcell_low_result_value'] = $resultData->LOW_VALUE;
                $urine_details['urine_epithelialcell_high_result_value'] = $resultData->HIGH_VALUE;
                $urine_details['urine_epithelialcell_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $urine_details['urine_epithelialcell_uom'] = str_replace(["�", "ï¿½"], "μ", $urine_details['urine_epithelialcell_uom']);
                $urine_details['urine_epithelialcell_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_epithelialcell_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URINEP";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code URINEP" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_epithelialcell_test_remraks'] = "Epithelial Cells - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_epithelialcell_test_remraks'] = '';
                }
                $urine_details['urine_epithelialcell_sample_method'] = $resultData->NEW_METHOD;

                if (preg_match_all('/\d+/', trim($resultData->RESULT_VALUE), $matches)) {
                    $urine_details['urine_epithelialcell_secondvalue'] = isset($matches[0][1]) ? (int)$matches[0][1] : (int)$matches[0][0];

                    if ($urine_details['urine_epithelialcell_secondvalue'] < $urine_details['urine_epithelialcell_low_result_value']) {
                        $urine_details['urine_epithelialcell_result_value_in_words'] = 'Low';
                        $urine_details['urine_epithelialcell_color_code'] = "red";
                    } elseif (
                        $urine_details['urine_epithelialcell_secondvalue'] >= $urine_details['urine_epithelialcell_low_result_value'] &&
                        $urine_details['urine_epithelialcell_secondvalue'] <= $urine_details['urine_epithelialcell_high_result_value']
                    ) {
                        $urine_details['urine_epithelialcell_result_value_in_words'] = 'Normal';
                        $urine_details['urine_epithelialcell_color_code'] = "green";
                    } elseif ($urine_details['urine_epithelialcell_secondvalue'] > $urine_details['urine_epithelialcell_high_result_value']) {
                        $urine_details['urine_epithelialcell_result_value_in_words'] = 'High';
                        $urine_details['urine_epithelialcell_color_code'] = "red";
                    } else {
                        $urine_details['urine_epithelialcell_result_value_in_words'] = '';
                        $urine_details['urine_epithelialcell_color_code'] = "black";
                    }
                } else {
                    $urine_details['urine_epithelialcell_secondvalue'] = '';
                    $urine_details['urine_epithelialcell_result_value_in_words'] = '';
                    $urine_details['urine_epithelialcell_color_code'] = "black";
                }
            }
        }
        if (!$urine_epithelialcell_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'UPUS' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'UPUS' not found" . FindTestgroupAddress('R0007j');
        }

        // Crystals sub test
        $urine_crystals_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'CRY') {
                $urine_crystals_result_found = true;
                $urine_details['urine_crystals_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_crystals_result_value'] ?? null) === '' || ($urine_details['urine_crystals_result_value'] ?? null) === null) {

                    $report_issues[] = "Crystals TestResultDetails are empty";
                    $report_issues_email[] = "Crystals TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_crystals_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code CRY";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code CRY" . FindTestgroupAddress('R0007j');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_crystals_test_remraks'] = "Crystals - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_crystals_test_remraks'] = '';
                }
                $urine_details['urine_crystals_sample_method'] = $resultData->NEW_METHOD;

                if (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_crystals_result_value_in_words'] = 'Absent';
                    $urine_details['urine_crystals_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_crystals_result_value_in_words'] = 'Nil';
                    $urine_details['urine_crystals_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_crystals_result_value_in_words'] = 'Present';
                    $urine_details['urine_crystals_color_code'] = "red";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_crystals_result_value_in_words'] = 'Normal';
                    $urine_details['urine_crystals_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_crystals_result_value_in_words'] = 'Negative';
                    $urine_details['urine_crystals_color_code'] = "green";
                } else {
                    $urine_details['urine_crystals_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_crystals_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE == "Nil") {
                    $urine_details['urine_crystals_impact_on_health'] = "";
                }
                if ($resultData->RESULT_VALUE == 'Nil') {
                    $urine_details['urine_crystals_suggestions'] = "";
                }
            }
        }
        if (!$urine_crystals_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'CRY' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'CRY' not found" . FindTestgroupAddress('R0007j');
        }

        // Yeast sub test
        $urine_yeast_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0007j' && explode('|', $resultData->TEST_CODE)[0] == 'YEA') {
                $urine_yeast_result_found = true;
                $urine_details['urine_yeast_result_value'] = $resultData->RESULT_VALUE;
                if (($urine_details['urine_yeast_result_value'] ?? null) === '' || ($urine_details['urine_yeast_result_value'] ?? null) === null) {

                    $report_issues[] = "Yeast TestResultDetails are empty";
                    $report_issues_email[] = "Yeast TestResultDetails are empty" . FindTestgroupAddress('R0007j');
                }

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $urine_details['urine_yeast_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code YEA";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code R0007j and test code YEA" . FindTestgroupAddress('R0007j');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $urine_details['urine_yeast_test_remraks'] = "Yeast - " . $resultData->TEST_REMARKS;
                } else {
                    $urine_details['urine_yeast_test_remraks'] = '';
                }
                $urine_details['urine_yeast_sample_method'] = $resultData->NEW_METHOD;
                if (stripos(trim($resultData->RESULT_VALUE), 'Normal') === 0) {
                    $urine_details['urine_yeast_result_value_in_words'] = 'Normal';
                    $urine_details['urine_yeast_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Nil') === 0) {
                    $urine_details['urine_yeast_result_value_in_words'] = 'Nil';
                    $urine_details['urine_yeast_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Present') === 0) {
                    $urine_details['urine_yeast_result_value_in_words'] = 'Present';
                    $urine_details['urine_yeast_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Negative') === 0) {
                    $urine_details['urine_yeast_result_value_in_words'] = 'Negative';
                    $urine_details['urine_yeast_color_code'] = "green";
                } elseif (stripos(trim($resultData->RESULT_VALUE), 'Absent') === 0) {
                    $urine_details['urine_yeast_result_value_in_words'] = 'Absent';
                    $urine_details['urine_yeast_color_code'] = "green";
                } else {
                    $urine_details['urine_yeast_result_value_in_words'] = $resultData->RESULT_VALUE;
                    $urine_details['urine_yeast_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE == "Present") {
                    $urine_details['urine_yeast_impact_on_health'] = "";
                }
                if ($resultData->RESULT_VALUE == 'Present') {
                    $urine_details['urine_yeast_suggestions'] = "";
                }
            }
        }
        if (!$urine_yeast_result_found) {

            $report_issues[] = " Test Group 'R0007j' or Test Code 'YEA' not found";
            $report_issues_email[] = " Test Group 'R0007j' or Test Code 'YEA' not found" . FindTestgroupAddress('R0007j');
        }
    }

    return $urine_details;
}

/**
 * Description: The getUrineTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for urine-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getUrineTestgroupdetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $UrineNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE === 'R0007j') {
            if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code R0007j";
                $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code R0007j" . FindTestgroupAddress('R0007j');
            }

            $UrineNablAccredited['R0007j_urine_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
            $UrineNablAccredited['R0007j_urine_remarks'] = $resultData->SERVICE_REMARKS ?: "";
        }
    }

    return $UrineNablAccredited;
}
/**
 * Description : getBloodDetails() function to get test result details for the blood section.
 * 
 * This function retrieves blood-related test results from the TestResultDetails array 
 * within the JSON response. It filters out relevant test groups and test codes that 
 * correspond to blood diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to the blood section.
 */

// get Blood Details

function getBloodDetails($reportJsonData,&$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {

        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $blood_details = [];

    // Erythrocyte Count -RBC sub test
    $rbccount_result_male_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'ECRBC') {
            $rbccount_result_male_found = true;
            $blood_details['rbccount_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['rbccount_result_value'] ?? null) === '' || ($blood_details['rbccount_result_value'] ?? null) === null) {

                $report_issues[] = "Erythrocyte Count - RBC TestResultDetails are empty";
                $report_issues_email[] = "Erythrocyte Count - RBC TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Erythrocyte Count -RBC reference ranges are empty";
                $report_issues_email[] = " Erythrocyte Count -RBC reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Erythrocyte Count -RBC Interval are empty";
                $report_issues_email[] = " Erythrocyte Count -RBC Interval are empty" . FindTestgroupAddress('CBC.');
            }

            $blood_details['rbccount_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['rbccount_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['rbccount_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['rbccount_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['rbccount_uom']);

            $blood_details['rbccount_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));



            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['rbccount_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code ECRBC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code ECRBC" . FindTestgroupAddress('CBC.');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['rbccount_test_remraks'] = "Erythrocyte Count-RBC - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['rbccount_test_remraks'] = '';
            }

            $blood_details['rbccount_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['rbccount_low_result_value']) {
                $blood_details['rbccount_result_value_in_words'] = 'Low';
                $blood_details['rbccount_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['rbccount_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['rbccount_high_result_value']) {
                $blood_details['rbccount_result_value_in_words'] = 'Normal';
                $blood_details['rbccount_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['rbccount_high_result_value']) {
                $blood_details['rbccount_result_value_in_words'] = 'High';
                $blood_details['rbccount_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['rbccount_high_result_value']) {
                $blood_details['rbccount_impact_on_health'] = "";
            } else {
                $blood_details['rbccount_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['rbccount_high_result_value']) {
                $blood_details['rbccount_suggestion'] = "NA";
            } else {
                $blood_details['rbccount_suggestion'] = '';
            }
        }
    }
    if (!$rbccount_result_male_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'ECRBC' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'ECRBC' not found" . FindTestgroupAddress('CBC.');
    }

    // Hematocrit-PCV sub test
    $hematocrit_pcv_result_male_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'HPCV') {
            $hematocrit_pcv_result_male_found = true;
            $blood_details['hematocrit_pcv_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['hematocrit_pcv_result_value'] ?? null) === '' || ($blood_details['hematocrit_pcv_result_value'] ?? null) === null) {

                $report_issues[] = "Hematocrit-PCV TestResultDetails are empty";
                $report_issues_email[] = "Hematocrit-PCV TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Hematocrit-PCV reference ranges are empty";
                $report_issues_email[] = " Hematocrit-PCV reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Hematocrit-PCV BR Interval are empty";
                $report_issues_email[] = " Hematocrit-PCV BR Interval are empty" . FindTestgroupAddress('CBC.');
            }

            $blood_details['hematocrit_pcv_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['hematocrit_pcv_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['hematocrit_pcv_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['hematocrit_pcv_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['hematocrit_pcv_uom']);

            $blood_details['hematocrit_pcv_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['hematocrit_pcv_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code HPCV";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code HPCV" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['hematocrit_pcv_test_remraks'] = "Hematocrit-PCV - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['hematocrit_pcv_test_remraks'] = '';
            }
            $blood_details['hematocrit_pcv_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['hematocrit_pcv_low_result_value']) {
                $blood_details['hematocrit_pcv_result_value_in_words'] = 'Low';
                $blood_details['hematocrit_pcv_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['hematocrit_pcv_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['hematocrit_pcv_high_result_value']) {
                $blood_details['hematocrit_pcv_result_value_in_words'] = 'Normal';
                $blood_details['hematocrit_pcv_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['hematocrit_pcv_high_result_value']) {
                $blood_details['hematocrit_pcv_result_value_in_words'] = 'High';
                $blood_details['hematocrit_pcv_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['hematocrit_pcv_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['hematocrit_pcv_high_result_value']) {
                $blood_details['hematocrit_pcv_impact_on_health'] = "A lower than normal hematocrit can indicate: An insufficient supply of healthy red blood cells (anemia) A large number of white blood cells due to long-term illness, infection or a white blood cell disorder such as leukemia or lymphoma, Vitamin or mineral deficiencies Recent or long-term blood loss A higher than normal hematocrit can indicate:Dehydration,A disorder, such as polycythemia vera, that causes your body to produce too many red blood cells Lung or heart disease";
            }
            if ($resultData->RESULT_VALUE < 40 || $resultData->RESULT_VALUE > 50) {
                $blood_details['hematocrit_pcv_suggestion'] = "Please consult your physician for personalized medical advice";
            }
        }
    }
    if (!$hematocrit_pcv_result_male_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'HPCV' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'HPCV' not found" . FindTestgroupAddress('CBC.');
    }

    // Hemoglobin sub test
    $hemoglobin_result_male_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'HB') {
            $hemoglobin_result_male_found = true;
            $blood_details['hemoglobin_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['hemoglobin_result_value'] ?? null) === '' || ($blood_details['hemoglobin_result_value'] ?? null) === null) {

                $report_issues[] = "Hemoglobin TestResultDetails are empty";
                $report_issues_email[] = "Hemoglobin TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Hemoglobin reference ranges are empty";
                $report_issues_email[] = "Hemoglobin reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Hemoglobin BR Interval are empty";
                $report_issues_email[] = " Hemoglobin BR Interval are empty" . FindTestgroupAddress('CBC.');
            }

            $blood_details['hemoglobin_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['hemoglobin_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['hemoglobin_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['hemoglobin_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['hemoglobin_uom']);

            $blood_details['hemoglobin_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['hemoglobin_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code HB";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code HB" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['hemoglobin_test_remraks'] = "Hemoglobin - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['hemoglobin_test_remraks'] = '';
            }
            $blood_details['hemoglobin_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['hemoglobin_low_result_value']) {
                $blood_details['hemoglobin_result_value_in_words'] = 'Low';
                $blood_details['hemoglobin_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['hemoglobin_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['hemoglobin_high_result_value']) {
                $blood_details['hemoglobin_result_value_in_words'] = 'Normal';
                $blood_details['hemoglobin_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['hemoglobin_high_result_value']) {
                $blood_details['hemoglobin_result_value_in_words'] = 'High';
                $blood_details['hemoglobin_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['hemoglobin_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['hemoglobin_high_result_value']) {
                $blood_details['hemoglobin_impact_on_health'] = "Hemoglobin is required to carry oxygen and if you have too few or abnormal red blood cells, or not enough hemoglobin, then blood capacity to carry oxygen to the body’s tissues will be decreased. Symptoms such as fatigue, weakness, dizziness and shortness of breath will be seen";
            } else {
                $blood_details['hemoglobin_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['hemoglobin_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['hemoglobin_high_result_value']) {
                $blood_details['hemoglobin_suggestion'] = "If your hemoglobin level is lower than normal, you have anemia. There are many forms of anemia and with different causes which include iron deficiency, Vitamin B12 deficiency, folate deficiency, hemoglobinopathies and malignancies. If your hemoglobin level is higher than normal it may be because of causes like Polycythemia Vera, heavy smoking etc";
            } else {
                $blood_details['hemoglobin_suggestion'] = '';
            }
        }
    }
    if (!$hemoglobin_result_male_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'HB' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'HB' not found" . FindTestgroupAddress('CBC.');
    }


    // Mean Corpuscular Volume sub test
    $corpuscular_volume_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' &&  explode('|', $resultData->TEST_CODE)[0] == 'CBC-MCV') {
            $corpuscular_volume_result_found = true;
            $blood_details['corpuscular_volume_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['corpuscular_volume_result_value'] ?? null) === '' || ($blood_details['corpuscular_volume_result_value'] ?? null) === null) {
                $report_issues[] = "Mean Corpuscular Volume TestResultDetails are empty";
                $report_issues_email[] = "Mean Corpuscular Volume TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Mean Corpuscular Volume reference ranges are empty";
                $report_issues_email[] = "Mean Corpuscular Volume reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Mean Corpuscular Volume BR Interval are empty";
                $report_issues_email[] = " Mean Corpuscular Volume BR Interval are empty" . FindTestgroupAddress('CBC.');
            }

            $blood_details['corpuscular_volume_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['corpuscular_volume_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['corpuscular_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['corpuscular_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['corpuscular_uom']);

            $blood_details['corpuscular_volume_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['corpuscular_volume_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCV";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCV" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['corpuscular_volume_test_remraks'] = "Mean Corpuscular Volume - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['corpuscular_volume_test_remraks'] = '';
            }
            $blood_details['corpuscular_volume_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['corpuscular_volume_low_result_value']) {
                $blood_details['corpuscular_volume_result_value_in_words'] = 'Low';
                $blood_details['corpuscular_volume_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['corpuscular_volume_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['corpuscular_volume_high_result_value']) {
                $blood_details['corpuscular_volume_result_value_in_words'] = 'Normal';
                $blood_details['corpuscular_volume_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['corpuscular_volume_high_result_value']) {
                $blood_details['corpuscular_volume_result_value_in_words'] = 'High';
                $blood_details['corpuscular_volume_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['corpuscular_volume_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['corpuscular_volume_high_result_value']) {
                $blood_details['corpuscular_volume_impact_on_health'] = "Anemias may be classified based on their etiology, erythropoietic response and morphology. Red cell indices are valuable in the morphologic classification of anemias. Since different etiologic factors result in characteristically different red cell morphology, the clinician can properly plan the management of a patient with an anemia if he can interpret the blood counts";
            } else {
                $blood_details['corpuscular_volume_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['corpuscular_volume_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['corpuscular_volume_high_result_value']) {
                $blood_details['corpuscular_volume_suggestion'] = "Please consult your physician for personalized medical advice.Your doctor may use more tests to search for the cause of your anemia";
            } else {
                $blood_details['corpuscular_volume_suggestion'] = '';
            }
        }
    }
    if (!$corpuscular_volume_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'CBC-MCV' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'CBC-MCV' not found" . FindTestgroupAddress('CBC.');
    }

    //MCH sub test
    $mch_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        // Trim and match to avoid hidden formatting issues
        if (trim($resultData->TEST_GROUP_CODE) === 'CBC.' &&  explode('|', $resultData->TEST_CODE)[0] == 'CBC-MCH') {
            $mch_result_found = true;
            $blood_details['mch_result_value'] = $resultData->RESULT_VALUE ?? null;

            if (($blood_details['mch_result_value'] ?? null) === '' || ($blood_details['mch_result_value'] ?? null) === null) {
                $report_issues[] = " MCH TestResultDetails are empty";
                $report_issues_email[] = " MCH TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "MCH reference ranges are empty";
                $report_issues_email[] = "MCH reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " MCH BR Interval are empty";
                $report_issues_email[] = " MCH BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['mch_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['mch_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['mch_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['mch_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['mch_uom']);
            $blood_details['mch_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['mch_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCH";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCH" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['mch_test_remraks'] = "MCH - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['mch_test_remraks'] = '';
            }
            $blood_details['mch_sample_method'] = $resultData->NEW_METHOD ?? '';
            if ($resultData->RESULT_VALUE < $blood_details['mch_low_result_value']) {
                $blood_details['mch_result_value_in_words'] = 'Low';
                $blood_details['mch_color_code'] = "red";
            } elseif ($resultData->RESULT_VALUE >= $blood_details['mch_low_result_value'] && $resultData->RESULT_VALUE <=  $blood_details['mch_high_result_value']) {
                $blood_details['mch_result_value_in_words'] = 'Normal';
                $blood_details['mch_color_code'] = "green";
            } else {
                $blood_details['mch_result_value_in_words'] = 'High';
                $blood_details['mch_color_code'] = "red";
            }
            $blood_details['mch_impact_on_health'] = ($resultData->RESULT_VALUE < $blood_details['mch_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['mch_high_result_value']) ? "" : "";
            $blood_details['mch_suggestion'] = ($resultData->RESULT_VALUE < $blood_details['mch_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['mch_high_result_value']) ? "" : "";
            break;
        }
    }


    if (!$mch_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'CBC-MCH' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'CBC-MCH' not found" . FindTestgroupAddress('CBC.');
    }
    // MCHC sub test
    $mchc_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' &&  explode('|', $resultData->TEST_CODE)[0] == 'CBC-MCHC') {
            $mchc_result_found = true;
            $blood_details['mchc_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['mchc_result_value'] ?? null) === '' || ($blood_details['mchc_result_value'] ?? null) === null) {
                $report_issues[] = "MCHC TestResultDetails are empty";
                $report_issues_email[] = "MCHC TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "MCHC reference ranges are empty";
                $report_issues_email[] = "MCHC reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " MCHC BR Interval are empty";
                $report_issues_email[] = " MCHC BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['mchc_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['mchc_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['mchc_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['mchc_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['mchc_uom']);
            $blood_details['mchc_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['mchc_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCHC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-MCHC" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['mchc_test_remraks'] = "MCHC - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['mchc_test_remraks'] = '';
            }
            $blood_details['mchc_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['mchc_low_result_value']) {
                $blood_details['mchc_result_value_in_words'] = 'Low';
                $blood_details['mchc_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['mchc_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['mchc_high_result_value']) {
                $blood_details['mchc_result_value_in_words'] = 'Normal';
                $blood_details['mchc_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['mchc_high_result_value']) {
                $blood_details['mchc_result_value_in_words'] = 'High';
                $blood_details['mchc_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['mchc_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['mchc_high_result_value']) {
                $blood_details['mchc_impact_on_health'] = "Anemias may be classified based on their etiology, erythropoietic response and morphology. Red cell indices are valuable in the morphologic classification of anemias. Since different etiologic factors result in characteristically different red cell morphology, the clinician can properly plan the management of a patient with an anemia if he can interpret the blood counts";
            } else {
                $blood_details['mchc_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['mchc_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['mchc_high_result_value']) {
                $blood_details['mchc_suggestion'] = "Please consult your physician for personalized medical advice.Your doctor may use more tests to search for the cause of your anemia";
            } else {
                $blood_details['mchc_suggestion'] = '';
            }
        }
    }
    if (!$mchc_result_found) {

        $report_issues[] = " Test Group 'CBC.' or Test Code 'CBC-MCHC' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'CBC-MCHC' not found" . FindTestgroupAddress('CBC.');
    }


    // Red Cell Distribution Width CV sub test
    $red_cell_dist_cv_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'RDWCV') {
            $red_cell_dist_cv_result_found = true;
            $blood_details['red_cell_dist_cv_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['red_cell_dist_cv_result_value'] ?? null) === '' || ($blood_details['red_cell_dist_cv_result_value'] ?? null) === null) {
                $report_issues[] = "Red Cell Distribution TestResultDetails are empty";
                $report_issues_email[] = "Red Cell Distribution TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Red Cell Distribution Width CV reference ranges are empty";
                $report_issues_email[] = "Red Cell Distribution Width CV reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Red Cell Distribution Width CV  BR Interval are empty";
                $report_issues_email[] = " Red Cell Distribution Width CV  BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['red_cell_dist_cv_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['red_cell_dist_cv_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['red_cell_dist_cv_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['red_cell_dist_cv_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['red_cell_dist_cv_uom']);
            $blood_details['red_cell_dist_cv_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['red_cell_dist_cv_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code RDWCV";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code RDWCV" . FindTestgroupAddress('CBC.');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['red_cell_dist_cv_test_remraks'] = "Red Cell Distribution Width CV  - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['red_cell_dist_cv_test_remraks'] = '';
            }
            $blood_details['red_cell_dist_cv_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['red_cell_dist_cv_low_result_value']) {
                $blood_details['red_cell_dist_cv_result_value_in_words'] = 'Low';
                $blood_details['red_cell_dist_cv_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['red_cell_dist_cv_low_result_value']  && $resultData->RESULT_VALUE <= $blood_details['red_cell_dist_cv_high_result_value']) {
                $blood_details['red_cell_dist_cv_result_value_in_words'] = 'Normal';
                $blood_details['red_cell_dist_cv_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['red_cell_dist_cv_high_result_value']) {
                $blood_details['red_cell_dist_cv_result_value_in_words'] = 'High';
                $blood_details['red_cell_dist_cv_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['red_cell_dist_cv_low_result_value']  || $resultData->RESULT_VALUE > $blood_details['red_cell_dist_cv_high_result_value']) {
                $blood_details['red_cell_dist_cv_impact_on_health'] = "Anemias may be classified based on their etiology, erythropoietic response and morphology. Red cell indices are valuable in the morphologic classification of anemias. Since different etiologic factors result in characteristically different red cell morphology, the clinician can properly plan the management of a patient with an anemia if he can interpret the blood counts";
            } else {
                $blood_details['red_cell_dist_cv_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['red_cell_dist_cv_high_result_value'] || $resultData->RESULT_VALUE > $blood_details['red_cell_dist_cv_high_result_value']) {
                $blood_details['red_cell_dist_cv_suggestion'] = "Please consult your physician for personalized medical advice.Your doctor may use more tests to search for the cause of your anemia";
            } else {
                $blood_details['red_cell_dist_cv_suggestion'] = '';
            }
        }
    }
    if (!$red_cell_dist_cv_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'RDWCV' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'RDWCV' not found" . FindTestgroupAddress('CBC.');
    }


    // Red cell Distribution Width SD sub test
    $red_cell_dist_sd_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'RDWSD') {
            $red_cell_dist_sd_result_found = true;
            $blood_details['red_cell_dist_sd_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['red_cell_dist_sd_result_value'] ?? null) === '' || ($blood_details['red_cell_dist_sd_result_value'] ?? null) === null) {
                $report_issues[] = "Red cell Distribution Width SD TestResultDetails are empty";
                $report_issues_email[] = "Red cell Distribution Width SD TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Red Cell Distribution Width SD reference ranges are empty";
                $report_issues_email[] = "Red Cell Distribution Width SD reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Red Cell Distribution Width SD  BR Interval are empty";
                $report_issues_email[] = " Red Cell Distribution Width SD  BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['red_cell_dist_sd_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['red_cell_dist_sd_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['red_cell_dist_sd_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['red_cell_dist_sd_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['red_cell_dist_sd_uom']);
            $blood_details['red_cell_dist_sd_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['red_cell_dist_sd_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code RDWSD";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code RDWSD" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['red_cell_dist_sd_test_remraks'] = "Red cell Distribution Width SD - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['red_cell_dist_sd_test_remraks'] = '';
            }
            $blood_details['red_cell_dist_sd_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE <  $blood_details['red_cell_dist_sd_low_result_value']) {
                $blood_details['red_cell_dist_sd_result_value_in_words'] = 'Low';
                $blood_details['red_cell_dist_sd_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >=  $blood_details['red_cell_dist_sd_low_result_value'] && $resultData->RESULT_VALUE <=  $blood_details['red_cell_dist_sd_high_result_value']) {
                $blood_details['red_cell_dist_sd_result_value_in_words'] = 'Normal';
                $blood_details['red_cell_dist_sd_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['red_cell_dist_sd_high_result_value']) {
                $blood_details['red_cell_dist_sd_result_value_in_words'] = 'High';
                $blood_details['red_cell_dist_sd_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE <  $blood_details['red_cell_dist_sd_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['red_cell_dist_sd_high_result_value']) {
                $blood_details['red_cell_dist_sd_impact_on_health'] = "Anemias may be classified based on their etiology, erythropoietic response and morphology. Red cell indices are valuable in the morphologic classification of anemias. Since different etiologic factors result in characteristically different red cell morphology, the clinician can properly plan the management of a patient with an anemia if he can interpret the blood counts";
            } else {
                $blood_details['red_cell_dist_sd_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE <  $blood_details['red_cell_dist_sd_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['red_cell_dist_sd_high_result_value']) {
                $blood_details['red_cell_dist_sd_suggestion'] = "Please consult your physician for personalized medical advice.Your doctor may use more tests to search for the cause of your anemia";
            } else {
                $blood_details['red_cell_dist_sd_suggestion'] = '';
            }
        }
    }
    if (!$red_cell_dist_sd_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'RDWSD' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'RDWSD' not found" . FindTestgroupAddress('CBC.');
    }



    // Platelets Count sub test
    $platelets_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'CBC-PC') {
            $platelets_count_result_found = true;
            $blood_details['platelets_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['platelets_count_result_value'] ?? null) === '' || ($blood_details['platelets_count_result_value'] ?? null) === null) {
                $report_issues[] = "Platelets Count TestResultDetails are empty";
                $report_issues_email[] = "Platelets Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Platelets Count reference ranges are empty";
                $report_issues_email[] = "Platelets Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Platelets Count BR Interval are empty";
                $report_issues_email[] = " Platelets Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['platelets_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['platelets_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['platelets_count_units'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['platelets_count_units'] = str_replace(["�", "ï¿½"], "μ", $blood_details['platelets_count_units']);
            $blood_details['platelets_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));



            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['platelets_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-PC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code CBC-PC" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['platelets_count_test_remraks'] = "Platelets Count - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['platelets_count_test_remraks'] = '';
            }
            $blood_details['platelets_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE <  $blood_details['platelets_count_low_result_value']) {
                $blood_details['platelets_count_result_value_in_words'] = 'Low';
                $blood_details['platelets_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >=  $blood_details['platelets_count_low_result_value'] && $resultData->RESULT_VALUE <=  $blood_details['platelets_count_high_result_value']) {
                $blood_details['platelets_count_result_value_in_words'] = 'Normal';
                $blood_details['platelets_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE >  $blood_details['platelets_count_high_result_value']) {
                $blood_details['platelets_count_result_value_in_words'] = 'High';
                $blood_details['platelets_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE <  $blood_details['platelets_count_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['platelets_count_high_result_value']) {
                $blood_details['platelets_count_impact_on_health'] = "An increase in platelet count is termed thrombocytosis while a decrease is termed thrombocytopenia. Thrombocytopenia can be due to decreased bone marrow production or increased destruction. Viral infections, megaloblastic anemia & hematological malignancies are few causes for thrombocytopenia. Thrombocytosis can be seen in iron deficiency anemia etc";
            } else {
                $blood_details['platelets_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE <  $blood_details['platelets_count_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['platelets_count_high_result_value']) {
                $blood_details['platelets_count_suggestion'] = "Kindly consult your clinician for further follow-up & management";
            } else {
                $blood_details['platelets_count_suggestion'] = '';
            }
        }
    }
    if (!$platelets_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'CBC-PC' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'CBC-PC' not found" . FindTestgroupAddress('CBC.');
    }
    // MPV sub test
    $mpv_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'MPV') {
            $mpv_result_found = true;
            $blood_details['mpv_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['mpv_result_value'] ?? null) === '' || ($blood_details['mpv_result_value'] ?? null) === null) {
                $report_issues[] = "MPV TestResultDetails are empty";
                $report_issues_email[] = "MPV TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "MPV reference ranges are empty";
                $report_issues_email[] = "MPV reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " MPV BR Interval are empty";
                $report_issues_email[] = " MPV BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['mpv_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['mpv_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['mpv_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['mpv_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['mpv_uom']);
            $blood_details['mpv_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['mpv_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code MPV";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code MPV" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['mpv_test_remraks'] = "MPV - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['mpv_test_remraks'] = '';
            }
            $blood_details['mpv_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['mpv_low_result_value']) {
                $blood_details['mpv_result_value_in_words'] = 'Low';
                $blood_details['mpv_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['mpv_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['mpv_high_result_value']) {
                $blood_details['mpv_result_value_in_words'] = 'Normal';
                $blood_details['mpv_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['mpv_high_result_value']) {
                $blood_details['mpv_result_value_in_words'] = 'High';
                $blood_details['mpv_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['mpv_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['mpv_high_result_value']) {
                $blood_details['mpv_impact_on_health'] = "Depending on the platelet count and other blood measurements, an increased MPV result can indicate thrombocytopenia, myeloproliferative disease, preeclampsia, heart disease or diabetes. A low MPV can indicate exposure to certain drugs that are harmful to cells. It may also indicate marrow hypoplasia, a disorder that causes a decrease in blood cell production";
            } else {
                $blood_details['mpv_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['mpv_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['mpv_high_result_value']) {
                $blood_details['mpv_suggestion'] = "To learn what your results mean, talk to your health care provider. Depending on your lifestyle, a high or low MPV may be completely normal for you. However, based on other results from your CBC, it can signal to your doctor to do additional testing to rule out any possible underlying conditions";
            } else {
                $blood_details['mpv_suggestion'] = '';
            }
        }
    }
    if (!$mpv_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'MPV' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'MPV' not found" . FindTestgroupAddress('CBC.');
    }


    // PDW sub test
    $pdw_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'PDW') {
            $pdw_result_found = true;
            $blood_details['pdw_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['pdw_result_value'] ?? null) === '' || ($blood_details['pdw_result_value'] ?? null) === null) {
                $report_issues[] = "PDW TestResultDetails are empty";
                $report_issues_email[] = "PDW TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "PDW reference ranges are empty";
                $report_issues_email[] = "PDW reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " PDW BR Interval are empty";
                $report_issues_email[] = " PDW BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['pdw_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['pdw_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['pdw_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['pdw_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['pdw_uom']);
            $blood_details['pdw_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['pdw_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code PDW";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code PDW" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['pdw_test_remraks'] = "PDW - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['pdw_test_remraks'] = '';
            }
            $blood_details['pdw_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['pdw_low_result_value']) {
                $blood_details['pdw_result_value_in_words'] = 'Low';
                $blood_details['pdw_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['pdw_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['pdw_high_result_value']) {
                $blood_details['pdw_result_value_in_words'] = 'Normal';
                $blood_details['pdw_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['pdw_high_result_value']) {
                $blood_details['pdw_result_value_in_words'] = 'High';
                $blood_details['pdw_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['pdw_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['pdw_high_result_value']) {
                $blood_details['pdw_impact_on_health'] = "This marker can give you additional information about your platelets and the cause of a high or low platelet count. Larger platelets are usually younger platelets that have been released earlier than normal from the bone marrow, while smaller platelets may be older and have been in circulation for a few days";
            } else {
                $blood_details['pdw_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['pdw_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['pdw_high_result_value']) {
                $blood_details['pdw_suggestion'] = "Further investigations are required";
            } else {
                $blood_details['pdw_suggestion'] = '';
            }
        }
    }
    if (!$pdw_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'PDW' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'PDW' not found" . FindTestgroupAddress('CBC.');
    }


    // Platelet Crit sub test
    $platelet_crit_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'PLC') {
            $platelet_crit_result_found = true;
            $blood_details['platelet_crit_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['platelet_crit_result_value'] ?? null) === '' || ($blood_details['platelet_crit_result_value'] ?? null) === null) {
                $report_issues[] = "Platelet Crit TestResultDetails are empty";
                $report_issues_email[] = "Platelet Crit TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = "Platelet Crit reference ranges are empty";
                $report_issues_email[] = "Platelet Crit reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Platelet Crit BR Interval are empty";
                $report_issues_email[] = " Platelet Crit BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['platelet_crit_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['platelet_crit_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['platelet_crit_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['platelet_crit_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['platelet_crit_uom']);
            $blood_details['platelet_crit_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));



            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['platelet_crit_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code PLC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code PLC" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['platelet_crit_test_remraks'] = "Platelet Crit - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['platelet_crit_test_remraks'] = '';
            }
            $blood_details['platelet_crit_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['platelet_crit_low_result_value']) {
                $blood_details['platelet_crit_result_value_in_words'] = 'Low';
                $blood_details['platelet_crit_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['platelet_crit_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['platelet_crit_high_result_value']) {
                $blood_details['platelet_crit_result_value_in_words'] = 'Normal';
                $blood_details['platelet_crit_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['platelet_crit_high_result_value']) {
                $blood_details['platelet_crit_result_value_in_words'] = 'High';
                $blood_details['platelet_crit_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $blood_details['platelet_crit_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['platelet_crit_high_result_value']) {
                $blood_details['platelet_crit_impact_on_health'] = "NA";
            } else {
                $blood_details['platelet_crit_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $blood_details['platelet_crit_low_result_value'] || $resultData->RESULT_VALUE > $blood_details['platelet_crit_high_result_value']) {
                $blood_details['platelet_crit_suggestion'] = "NA";
            } else {
                $blood_details['platelet_crit_suggestion'] = '';
            }
        }
    }
    if (!$platelet_crit_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'PLC' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'PLC' not found" . FindTestgroupAddress('CBC.');
    }

    // Leukocytes Count -WBC Total sub test
    $leukocytes_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' &&  explode('|', $resultData->TEST_CODE)[0] == 'LCWBC') {
            $leukocytes_count_result_found = true;
            $blood_details['leukocytes_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['leukocytes_count_result_value'] ?? null) === '' || ($blood_details['leukocytes_count_result_value'] ?? null) === null) {

                $report_issues[] = "Leukocytes Count -WBC Total TestResultDetails are empty";
                $report_issues_email[] = "Leukocytes Count -WBC Total TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = "Leukocytes Count -WBC Total reference ranges are empty";
                $report_issues_email[] = "Leukocytes Count -WBC Total reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Leukocytes Count -WBC Total BR Interval are empty";
                $report_issues_email[] = " Leukocytes Count -WBC Total BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['leukocytes_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['leukocytes_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['leukocytes_count_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['leukocytes_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['leukocytes_count_uom']);
            $blood_details['leukocytes_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['leukocytes_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LCWBC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LCWBC" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['leukocytes_count_test_remraks'] = "Leukocytes Count -WBC Total - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['leukocytes_count_test_remraks'] = '';
            }

            $blood_details['leukocytes_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['leukocytes_count_low_result_value']) {
                $blood_details['leukocytes_count_result_value_in_words'] = 'Low';
                $blood_details['leukocytes_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['leukocytes_count_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['leukocytes_count_high_result_value']) {
                $blood_details['leukocytes_count_result_value_in_words'] = 'Normal';
                $blood_details['leukocytes_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['leukocytes_count_high_result_value']) {
                $blood_details['leukocytes_count_result_value_in_words'] = 'High';
                $blood_details['leukocytes_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['leukocytes_count_high_result_value']) {
                $blood_details['leukocytes_count_impact_on_health'] = "NA";
            } else {
                $blood_details['leukocytes_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['leukocytes_count_high_result_value']) {
                $blood_details['leukocytes_count_suggestion'] = "NA";
            } else {
                $blood_details['leukocytes_count_suggestion'] = '';
            }
        }
    }
    if (!$leukocytes_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'LCWBC' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'LCWBC' not found" . FindTestgroupAddress('CBC.');
    }

    // Absolute Neutrophils Count sub test
    $neutrophils_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' &&  explode('|', $resultData->TEST_CODE)[0] == 'NEUABS') {
            $neutrophils_count_result_found = true;
            $blood_details['neutrophils_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['neutrophils_count_result_value'] ?? null) === '' || ($blood_details['neutrophils_count_result_value'] ?? null) === null) {
                $report_issues[] = "Absolute Neutrophils Count TestResultDetails are empty";
                $report_issues_email[] = "Absolute Neutrophils Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Absolute Neutrophils Count reference ranges are empty";
                $report_issues_email[] = " Absolute Neutrophils Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = "  Absolute Neutrophils Count BR Interval are empty";
                $report_issues_email[] = "  Absolute Neutrophils Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['neutrophils_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['neutrophils_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['neutrophils_count_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['neutrophils_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['neutrophils_count_uom']);
            $blood_details['neutrophils_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['neutrophils_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LCWBC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LCWBC" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['neutrophils_count_test_remraks'] = "Absolute Neutrophils - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['neutrophils_count_test_remraks'] = '';
            }
            $blood_details['neutrophils_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['neutrophils_count_low_result_value']) {
                $blood_details['neutrophils_count_result_value_in_words'] = 'Low';
                $blood_details['neutrophils_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['neutrophils_count_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['neutrophils_count_high_result_value']) {
                $blood_details['neutrophils_count_result_value_in_words'] = 'Normal';
                $blood_details['neutrophils_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_count_high_result_value']) {
                $blood_details['neutrophils_count_result_value_in_words'] = 'High';
                $blood_details['neutrophils_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_count_high_result_value']) {
                $blood_details['neutrophils_count_impact_on_health'] = "NA";
            } else {
                $blood_details['neutrophils_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_count_high_result_value']) {
                $blood_details['neutrophils_count_suggestion'] = "NA";
            } else {
                $blood_details['neutrophils_count_suggestion'] = '';
            }
        }
    }
    if (!$neutrophils_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'NEUABS' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'NEUABS' not found" . FindTestgroupAddress('CBC.');
    }

    // Absolute Monocyte Count sub test
    $monocyte_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'MONOABS') {
            $monocyte_count_result_found = true;
            $blood_details['monocyte_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['monocyte_count_result_value'] ?? null) === '' || ($blood_details['monocyte_count_result_value'] ?? null) === null) {
                $report_issues[] = "Absolute Monocyte Count TestResultDetails are empty";
                $report_issues_email[] = "Absolute Monocyte Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Absolute Monocyte Count reference ranges are empty";
                $report_issues_email[] = " Absolute Monocyte Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Absolute Monocyte Count BR Interval are empty";
                $report_issues_email[] = " Absolute Monocyte Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['monocyte_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['monocyte_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['monocyte_count_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['monocyte_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['monocyte_count_uom']);



            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['monocyte_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code MONOABS";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code MONOABS" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['monocyte_count_test_remraks'] = "Absolute Monocyte Count - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['monocyte_count_test_remraks'] = '';
            }
            $blood_details['monocyte_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['monocyte_count_low_result_value']) {
                $blood_details['monocyte_count_result_value_in_words'] = 'Low';
                $blood_details['monocyte_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['monocyte_count_low_result_value']  && $resultData->RESULT_VALUE <= $blood_details['monocyte_count_high_result_value']) {
                $blood_details['monocyte_count_result_value_in_words'] = 'Normal';
                $blood_details['monocyte_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['monocyte_count_high_result_value']) {
                $blood_details['monocyte_count_result_value_in_words'] = 'High';
                $blood_details['monocyte_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['monocyte_count_low_result_value']) {
                $blood_details['monocyte_count_impact_on_health'] = "";
            } else {
                $blood_details['monocyte_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['monocyte_count_low_result_value']) {
                $blood_details['monocyte_count_suggestion'] = "";
            } else {
                $blood_details['monocyte_count_suggestion'] = '';
            }
        }
    }
    if (!$monocyte_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'MONOABS' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'MONOABS' not found" . FindTestgroupAddress('CBC.');
    }
    // Absolute Lymphocyte Count sub test
    $lymphocyte_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'LYMABS') {
            $lymphocyte_count_result_found = true;
            $blood_details['lymphocyte_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['lymphocyte_count_result_value'] ?? null) === '' || ($blood_details['lymphocyte_count_result_value'] ?? null) === null) {
                $report_issues[] = "Absolute Lymphocyte Count TestResultDetails are empty";
                $report_issues_email[] = "Absolute Lymphocyte Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {

                $report_issues[] = " Absolute Lymphocyte Count reference ranges are empty";
                $report_issues_email[] = " Absolute Lymphocyte Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Absolute Lymphocyte Count BR Interval are empty";
                $report_issues_email[] = " Absolute Lymphocyte Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['lymphocyte_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['lymphocyte_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['lymphocyte_count_uom'] = $resultData->UOM ? $resultData->UOM : '';
            $blood_details['lymphocyte_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['lymphocyte_count_uom']);
            $blood_details['lymphocyte_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['lymphocyte_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LYMABS";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code LYMABS" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['lymphocyte_count_test_remraks'] = "Absolute Lymphocyte Count - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['lymphocyte_count_test_remraks'] = '';
            }
            $blood_details['lymphocyte_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE <  $blood_details['lymphocyte_count_low_result_value']) {
                $blood_details['lymphocyte_count_result_value_in_words'] = 'Low';
                $blood_details['lymphocyte_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >=  $blood_details['lymphocyte_count_low_result_value'] && $resultData->RESULT_VALUE <=  $blood_details['lymphocyte_count_high_result_value']) {
                $blood_details['lymphocyte_count_result_value_in_words'] = 'Normal';
                $blood_details['lymphocyte_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE >  $blood_details['lymphocyte_count_high_result_value']) {
                $blood_details['lymphocyte_count_result_value_in_words'] = 'High';
                $blood_details['lymphocyte_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE <  $blood_details['lymphocyte_count_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['lymphocyte_count_high_result_value']) {
                $blood_details['lymphocyte_count_impact_on_health'] = "";
            } else {
                $blood_details['lymphocyte_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE <  $blood_details['lymphocyte_count_low_result_value'] || $resultData->RESULT_VALUE >  $blood_details['lymphocyte_count_high_result_value']) {
                $blood_details['lymphocyte_count_suggestion'] = " Low levels of iron or vitamins in the body can cause anemia. Poor diet or certain diseases might lead to anemia. Good
                sources of iron- Spinach & dark green leafy vegetables, Beetroot, Watermelon, Pomegranate etc. Good sources of Vitamin B12- Meat,
                salmon, milk, cheese, eggs etc. Kindly consult your clinician for further follow-up & management";
            } else {
                $blood_details['lymphocyte_count_suggestion'] = '';
            }
        }
    }
    if (!$lymphocyte_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'LYMABS' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'LYMABS' not found" . FindTestgroupAddress('CBC.');
    }
    // Absolute Eosinophil Count sub test
    $eosinophil_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'EOSABS') {
            $eosinophil_count_result_found = true;
            $blood_details['eosinophil_count_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['eosinophil_count_result_value'] ?? null) === '' || ($blood_details['eosinophil_count_result_value'] ?? null) === null) {
                $report_issues[] = "Absolute Eosinophil Count TestResultDetails are empty";
                $report_issues_email[] = "Absolute Eosinophil Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Absolute Eosinophil Count reference ranges are empty";
                $report_issues_email[] = " Absolute Eosinophil Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = "Absolute Eosinophil Count BR Interval are empty";
                $report_issues_email[] = "Absolute Eosinophil Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['eosinophil_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['eosinophil_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['eosinophil_count_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['eosinophil_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['eosinophil_count_uom']);
            $blood_details['eosinophil_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['eosinophil_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code EOSABS";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code EOSABS" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['eosinophil_count_test_remraks'] = "Absolute Eosinophil Count - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['eosinophil_count_test_remraks'] = '';
            }
            $blood_details['eosinophil_count_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['eosinophil_count_low_result_value']) {
                $blood_details['eosinophil_count_result_value_in_words'] = 'Low';
                $blood_details['eosinophil_count_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['eosinophil_count_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['eosinophil_count_high_result_value']) {
                $blood_details['eosinophil_count_result_value_in_words'] = 'Normal';
                $blood_details['eosinophil_count_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['eosinophil_count_high_result_value']) {
                $blood_details['eosinophil_count_result_value_in_words'] = 'High';
                $blood_details['eosinophil_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['eosinophil_count_high_result_value']) {
                $blood_details['eosinophil_count_impact_on_health'] = "";
            } else {
                $blood_details['eosinophil_count_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['eosinophil_count_high_result_value']) {
                $blood_details['eosinophil_count_suggestion'] = "";
            } else {
                $blood_details['eosinophil_count_suggestion'] = '';
            }
        }
    }
    if (!$eosinophil_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'EOSABS' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'EOSABS' not found" . FindTestgroupAddress('CBC.');
    }

    // Absolute Basophil Count sub test
    $basophil_count_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'BASOABS') {
            $basophil_count_result_found = true;
            $blood_details['basophil_count_result_value'] = $resultData->RESULT_VALUE;

            if (($blood_details['basophil_count_result_value'] ?? null) === '' || ($blood_details['basophil_count_result_value'] ?? null) === null) {
                $report_issues[] = " Absolute Basophil Count TestResultDetails are empty";
                $report_issues_email[] = " Absolute Basophil Count TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Absolute Basophil Count reference ranges are empty";
                $report_issues_email[] = " Absolute Basophil Count reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = "Absolute Basophil Count BR Interval are empty";
                $report_issues_email[] = "Absolute Basophil Count BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['basophil_count_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['basophil_count_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['basophil_count_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['basophil_count_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['basophil_count_uom']);
            $blood_details['basophil_count_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['basophil_count_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code BASOABS";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code BASOABS" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['basophil_count_test_remraks'] = "Absolute Basophil Count - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['basophil_count_test_remraks'] = '';
            }

            $blood_details['basophil_count_sample_method'] = $resultData->NEW_METHOD;
            if ((float) $resultData->RESULT_VALUE < $blood_details['basophil_count_low_result_value']) {
                $blood_details['basophil_count_result_value_in_words'] = 'Low';
                $blood_details['basophil_count_color_code'] = "red";
            }
            if ((float) $resultData->RESULT_VALUE >= $blood_details['basophil_count_low_result_value'] && (float) $resultData->RESULT_VALUE <= $blood_details['basophil_count_high_result_value']) {
                $blood_details['basophil_count_result_value_in_words'] = 'Normal';
                $blood_details['basophil_count_color_code'] = "green";
            }
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophil_count_high_result_value']) {
                $blood_details['basophil_count_result_value_in_words'] = 'High';
                $blood_details['basophil_count_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophil_count_high_result_value']) {
                $blood_details['basophil_count_impact_on_health'] = "";
            } else {
                $blood_details['basophil_count_impact_on_health'] = '';
            }
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophil_count_high_result_value']) {
                $blood_details['basophil_count_suggestion'] = "";
            } else {
                $blood_details['basophil_count_suggestion'] = '';
            }
        }
    }
    if (!$basophil_count_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'BASOABS' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'BASOABS' not found" . FindTestgroupAddress('CBC.');
    }
    // Neutrophils sub test
    $neutrophils_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'N') {
            $neutrophils_result_found = true;
            $blood_details['neutrophils_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['neutrophils_result_value'] ?? null) === '' || ($blood_details['neutrophils_result_value'] ?? null) === null) {
                $report_issues[] = "Neutrophils TestResultDetails are empty";
                $report_issues_email[] = "Neutrophils TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Neutrophils reference ranges are empty";
                $report_issues_email[] = " Neutrophils reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Neutrophils BR Interval are empty";
                $report_issues_email[] = " Neutrophils BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['neutrophils_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['neutrophils_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['neutrophils_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['neutrophils_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['neutrophils_uom']);
            $blood_details['neutrophils_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['neutrophils_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code N";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code N" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['neutrophils_test_remraks'] = "Neutrophils - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['neutrophils_test_remraks'] = '';
            }
            $blood_details['neutrophils_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['neutrophils_low_result_value']) {
                $blood_details['neutrophils_result_value_in_words'] = 'Low';
                $blood_details['neutrophils_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['neutrophils_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['neutrophils_high_result_value']) {
                $blood_details['neutrophils_result_value_in_words'] = 'Normal';
                $blood_details['neutrophils_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_high_result_value']) {
                $blood_details['neutrophils_result_value_in_words'] = 'High';
                $blood_details['neutrophils_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_high_result_value']) {
                $blood_details['neutrophils_impact_on_health'] = "";
            } else {
                $blood_details['neutrophils_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['neutrophils_high_result_value']) {
                $blood_details['neutrophils_suggestion'] = "";
            } else {
                $blood_details['neutrophils_suggestion'] = '';
            }
        }
    }
    if (!$neutrophils_result_found) {

        $report_issues[] = " Test Group 'CBC.' or Test Code 'N' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'N' not found" . FindTestgroupAddress('CBC.');
    }


    // Lymphocyte sub test
    $lymphocyte_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'L') {
            $lymphocyte_result_found = true;
            $blood_details['lymphocyte_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['lymphocyte_result_value'] ?? null) === '' || ($blood_details['lymphocyte_result_value'] ?? null) === null) {
                $report_issues[] = "Lymphocyte TestResultDetails are empty";
                $report_issues_email[] = "Lymphocyte TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Lymphocyte reference ranges are empty";
                $report_issues_email[] = " Lymphocyte reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Lymphocyte BR Interval are empty";
                $report_issues_email[] = " Lymphocyte BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['lymphocyte_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['lymphocyte_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['lymphocyte_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['lymphocyte_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['lymphocyte_uom']);
            $blood_details['lymphocyte_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['lymphocyte_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {

                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code L";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code L" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['lymphocyte_test_remraks'] = "Lymphocyte - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['lymphocyte_test_remraks'] = '';
            }
            $blood_details['lymphocyte_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['lymphocyte_low_result_value']) {
                $blood_details['lymphocyte_result_value_in_words'] = 'Low';
                $blood_details['lymphocyte_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >=  $blood_details['lymphocyte_low_result_value'] && $resultData->RESULT_VALUE <=  $blood_details['lymphocyte_high_result_value']) {
                $blood_details['lymphocyte_result_value_in_words'] = 'Normal';
                $blood_details['lymphocyte_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['lymphocyte_high_result_value']) {
                $blood_details['lymphocyte_result_value_in_words'] = 'High';
                $blood_details['lymphocyte_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['lymphocyte_high_result_value']) {
                $blood_details['lymphocyte_impact_on_health'] = "NA";
            } else {
                $blood_details['lymphocyte_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['lymphocyte_high_result_value']) {
                $blood_details['lymphocyte_suggestion'] = "NA";
            } else {
                $blood_details['lymphocyte_suggestion'] = '';
            }
        }
    }
    if (!$lymphocyte_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'L' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'L' not found" . FindTestgroupAddress('CBC.');
    }


    // Monocytes sub test
    $monocytes_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'M') {
            $monocytes_result_found = true;
            $blood_details['monocytes_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['monocytes_result_value'] ?? null) === '' || ($blood_details['monocytes_result_value'] ?? null) === null) {
                $report_issues[] = "Monocytes TestResultDetails are empty";
                $report_issues_email[] = "Monocytes TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Monocytes reference ranges are empty";
                $report_issues_email[] = " Monocytes reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Monocytes BR Interval are empty";
                $report_issues_email[] = " Monocytes BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['monocytes_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['monocytes_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['monocytes_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['monocytes_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['monocytes_uom']);
            $blood_details['monocytes_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['monocytes_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code M";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code M" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['monocytes_test_remraks'] = "Monocytes - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['monocytes_test_remraks'] = '';
            }
            $blood_details['monocytes_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['monocytes_low_result_value']) {
                $blood_details['monocytes_result_value_in_words'] = 'Low';
                $blood_details['monocytes_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['monocytes_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['monocytes_high_result_value']) {
                $blood_details['monocytes_result_value_in_words'] = 'Normal';
                $blood_details['monocytes_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['monocytes_high_result_value']) {
                $blood_details['monocytes_result_value_in_words'] = 'High';
                $blood_details['monocytes_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['monocytes_high_result_value']) {
                $blood_details['monocytes_impact_on_health'] = "";
            } else {
                $blood_details['monocytes_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['monocytes_high_result_value']) {
                $blood_details['monocytes_suggestion'] = "";
            } else {
                $blood_details['monocytes_suggestion'] = '';
            }
        }
    }
    if (!$monocytes_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'M' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'M' not found" . FindTestgroupAddress('CBC.');
    }

    // Eosinophils sub test
    $eosinophils_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'E') {
            $eosinophils_result_found = true;
            $blood_details['eosinophils_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['eosinophils_result_value'] ?? null) === '' || ($blood_details['eosinophils_result_value'] ?? null) === null) {
                $report_issues[] = "Eosinophils TestResultDetails are empty";
                $report_issues_email[] = "Eosinophils TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Eosinophils reference ranges are empty";
                $report_issues_email[] = " Eosinophils reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Eosinophils BR Interval are empty";
                $report_issues_email[] = " Eosinophils BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['eosinophils_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['eosinophils_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['eosinophils_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['eosinophils_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['eosinophils_uom']);
            $blood_details['eosinophils_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['eosinophils_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code E";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code E" . FindTestgroupAddress('CBC.');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['eosinophils_test_remraks'] = "Eosinophils - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['eosinophils_test_remraks'] = '';
            }
            $blood_details['eosinophils_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $blood_details['eosinophils_low_result_value']) {
                $blood_details['eosinophils_result_value_in_words'] = 'Low';
                $blood_details['eosinophils_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $blood_details['eosinophils_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['eosinophils_high_result_value']) {
                $blood_details['eosinophils_result_value_in_words'] = 'Normal';
                $blood_details['eosinophils_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $blood_details['eosinophils_high_result_value']) {
                $blood_details['eosinophils_result_value_in_words'] = 'High';
                $blood_details['eosinophils_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $blood_details['eosinophils_high_result_value']) {
                $blood_details['eosinophils_impact_on_health'] = "";
            } else {
                $blood_details['eosinophils_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $blood_details['eosinophils_high_result_value']) {
                $blood_details['eosinophils_suggestion'] = "";
            } else {
                $blood_details['eosinophils_suggestion'] = '';
            }
        }
    }
    if (!$eosinophils_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'E' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'E' not found" . FindTestgroupAddress('CBC.');
    }
    // Basophils sub test
    $basophils_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'CBC.' && explode('|', $resultData->TEST_CODE)[0] == 'BASO') {
            $basophils_result_found = true;
            $blood_details['basophils_result_value'] = $resultData->RESULT_VALUE;
            if (($blood_details['basophils_result_value'] ?? null)  === '' || ($blood_details['basophils_result_value'] ?? null) === null) {
                $report_issues[] = " Basophils TestResultDetails are empty";
                $report_issues_email[] = " Basophils TestResultDetails are empty" . FindTestgroupAddress('CBC.');
            }

            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Basophils reference ranges are empty";
                $report_issues_email[] = " Basophils reference ranges are empty" . FindTestgroupAddress('CBC.');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " Basophils BR Interval are empty";
                $report_issues_email[] = " Basophils BR Interval are empty" . FindTestgroupAddress('CBC.');
            }
            $blood_details['basophils_low_result_value'] = $resultData->LOW_VALUE;
            $blood_details['basophils_high_result_value'] = $resultData->HIGH_VALUE;
            $blood_details['basophils_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $blood_details['basophils_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['basophils_uom']);
            $blood_details['basophils_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $blood_details['basophils_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code BASO ";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code CBC. and test code BASO " . FindTestgroupAddress('CBC.');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $blood_details['basophils_test_remraks'] = "Basophils - " . $resultData->TEST_REMARKS;
            } else {
                $blood_details['basophils_test_remraks'] = '';
            }
            $blood_details['basophils_sample_method'] = $resultData->NEW_METHOD;
            if ((float) $resultData->RESULT_VALUE < $blood_details['basophils_low_result_value']) {
                $blood_details['basophils_result_value_in_words'] = 'Low';
                $blood_details['basophils_color_code'] = "red";
            }
            if ((float) $resultData->RESULT_VALUE >= $blood_details['basophils_low_result_value'] && (float) $resultData->RESULT_VALUE <= $blood_details['basophils_high_result_value']) {
                $blood_details['basophils_result_value_in_words'] = 'Normal';
                $blood_details['basophils_color_code'] = "green";
            }
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophils_high_result_value']) {
                $blood_details['basophils_result_value_in_words'] = 'High';
                $blood_details['basophils_color_code'] = "red";
            }
            // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophils_high_result_value']) {
                $blood_details['basophils_impact_on_health'] = "";
            } else {
                $blood_details['basophils_impact_on_health'] = '';
            }
            if ((float) $resultData->RESULT_VALUE > $blood_details['basophils_high_result_value']) {
                $blood_details['basophils_suggestion'] = "";
            } else {
                $blood_details['basophils_suggestion'] = '';
            }
        }
    }
    if (!$basophils_result_found) {
        $report_issues[] = " Test Group 'CBC.' or Test Code 'BASO' not found";
        $report_issues_email[] = " Test Group 'CBC.' or Test Code 'BASO' not found" . FindTestgroupAddress('CBC.');
    }




    // ESR (Erythrocyte Sedimentation Rate), EDTA Blood (Ayushman Wellness Package)
    if ($PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030') {
        $erythrocyte_sedimentation_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'E0005' && explode('|', $resultData->TEST_CODE)[0] == 'ESRM') {
                $erythrocyte_sedimentation_result_found = true;
                $blood_details['erythrocyte_sedimentation_result_value'] = $resultData->RESULT_VALUE;
                if (($blood_details['erythrocyte_sedimentation_result_value'] ?? null) === '' || ($blood_details['erythrocyte_sedimentation_result_value'] ?? null) === null) {
                    $report_issues[] = "ESR (Erythrocyte Sedimentation Rate), EDTA Blood TestResultDetails are empty";
                    $report_issues_email[] = "ESR (Erythrocyte Sedimentation Rate), EDTA Blood TestResultDetails are empty" . FindTestgroupAddress('E0005');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    $report_issues[] = " ESR (Erythrocyte Sedimentation Rate), EDTA Blood reference ranges are empty";
                    $report_issues_email[] = " ESR (Erythrocyte Sedimentation Rate), EDTA Blood reference ranges are empty" . FindTestgroupAddress('E0005');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                    $report_issues[] = " ESR (Erythrocyte Sedimentation Rate), EDTA Blood BR Interval are empty";
                    $report_issues_email[] = " ESR (Erythrocyte Sedimentation Rate), EDTA Blood BR Interval are empty" . FindTestgroupAddress('E0005');
                }
                $blood_details['erythrocyte_sedimentation_low_result_value'] = $resultData->LOW_VALUE;
                $blood_details['erythrocyte_sedimentation_high_result_value'] = $resultData->HIGH_VALUE;
                $blood_details['erythrocyte_sedimentation_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $blood_details['erythrocyte_sedimentation_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['erythrocyte_sedimentation_uom']);
                $blood_details['erythrocyte_sedimentation_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $blood_details['erythrocyte_sedimentation_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code E0005 and test code ESRM ";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code E0005 and test code ESRM " . FindTestgroupAddress('E0005');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $blood_details['erythrocyte_sedimentation_test_remraks'] = "ESR (Erythrocyte Sedimentation Rate), EDTA Blood - " . $resultData->TEST_REMARKS;
                } else {
                    $blood_details['erythrocyte_sedimentation_test_remraks'] = '';
                }
                $blood_details['erythrocyte_sedimentation_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $blood_details['erythrocyte_sedimentation_low_result_value']) {
                    $blood_details['erythrocyte_sedimentation_result_value_in_words'] = 'Low';
                    $blood_details['erythrocyte_sedimentation_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $blood_details['erythrocyte_sedimentation_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['erythrocyte_sedimentation_high_result_value']) {
                    $blood_details['erythrocyte_sedimentation_result_value_in_words'] = 'Normal';
                    $blood_details['erythrocyte_sedimentation_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $blood_details['erythrocyte_sedimentation_high_result_value']) {
                    $blood_details['erythrocyte_sedimentation_result_value_in_words'] = 'High';
                    $blood_details['erythrocyte_sedimentation_color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE > $blood_details['erythrocyte_sedimentation_high_result_value']) {
                    $blood_details['erythrocyte_sedimentation_impact_on_health'] = "It is primarily a monitoring parameter to check response to treatment of certain diseases but it is never diagnostic for specific diseases";
                } else {
                    $blood_details['erythrocyte_sedimentation_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > $blood_details['erythrocyte_sedimentation_high_result_value']) {
                    $blood_details['erythrocyte_sedimentation_suggestion'] = "NA";
                } else {
                    $blood_details['erythrocyte_sedimentation_suggestion'] = '';
                }
            }
        }
        if (!$erythrocyte_sedimentation_result_found) {
            $report_issues[] = " Test Group 'E0005' or Test Code 'ESRM' not found";
            $report_issues_email[] = " Test Group 'E0005' or Test Code 'ESRM' not found" . FindTestgroupAddress('E0005');
        }
    }
    // Lactate dehydragenase (LDH), Serum (Ayushman Wellness Package)
    if ($PackageCode == 'AYN_027' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031') {

        $lactate_dehydragenase_LDH_serum__result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'L0002' && explode('|', $resultData->TEST_CODE)[0] == 'PNSLDH') {
                $lactate_dehydragenase_LDH_serum__result_found = true;
                $blood_details['lactate_dehydragenase_LDH_serum__result_value'] = $resultData->RESULT_VALUE;
                if (($blood_details['lactate_dehydragenase_LDH_serum__result_value'] ?? null) === '' || ($blood_details['lactate_dehydragenase_LDH_serum__result_value'] ?? null) === null) {
                    $report_issues[] = "Lactate dehydragenase (LDH), Serum TestResultDetails are empty";
                    $report_issues_email[] = "Lactate dehydragenase (LDH), Serum TestResultDetails are empty" . FindTestgroupAddress('L0002');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    $report_issues[] = " Lactate dehydragenase (LDH), Serum reference ranges are empty";
                    $report_issues_email[] = " Lactate dehydragenase (LDH), Serum reference ranges are empty" . FindTestgroupAddress('L0002');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                    $report_issues[] = " Lactate dehydragenase (LDH), Serum BR Interval are empty";
                    $report_issues_email[] = " Lactate dehydragenase (LDH), Serum BR Interval are empty" . FindTestgroupAddress('L0002');
                }
                $blood_details['lactate_dehydragenase_LDH_serum_low_result_value'] = $resultData->LOW_VALUE;
                $blood_details['lactate_dehydragenase_LDH_serum_high_result_value'] = $resultData->HIGH_VALUE;
                $blood_details['lactate_dehydragenase_LDH_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $blood_details['lactate_dehydragenase_LDH_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $blood_details['lactate_dehydragenase_LDH_serum_uom']);
                $blood_details['lactate_dehydragenase_LDH_serum_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                $brInterval = trim($blood_details['lactate_dehydragenase_LDH_serum_BRInterval_result_value']);

                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {
                    // Also clean single range
                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }

                $blood_details['lactate_dehydragenase_LDH_serum_reference_ranges_value'] = $range_map;


                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $blood_details['lactate_dehydragenase_LDH_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code L0002 and test code PNSLDH";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code L0002 and test code PNSLDH" . FindTestgroupAddress('L0002');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $blood_details['lactate_dehydragenase_LDH_serum_test_remraks'] = "Lactate dehydragenase (LDH), Serum  - " . $resultData->TEST_REMARKS;
                } else {
                    $blood_details['lactate_dehydragenase_LDH_serum_test_remraks'] = '';
                }
                $blood_details['lactate_dehydragenase_LDH_serum__sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $blood_details['lactate_dehydragenase_LDH_serum_low_result_value']) {
                    $blood_details['lactate_dehydragenase_LDH_serum__result_value_in_words'] = 'Low';
                    $blood_details['lactate_dehydragenase_LDH_serum__color_code'] = "red";
                } elseif ($resultData->RESULT_VALUE >= $blood_details['lactate_dehydragenase_LDH_serum_low_result_value'] && $resultData->RESULT_VALUE <= $blood_details['lactate_dehydragenase_LDH_serum_high_result_value']) {
                    $blood_details['lactate_dehydragenase_LDH_serum__result_value_in_words'] = 'Normal';
                    $blood_details['lactate_dehydragenase_LDH_serum__color_code'] = "green";
                } elseif ($resultData->RESULT_VALUE > $blood_details['lactate_dehydragenase_LDH_serum_high_result_value']) {
                    $blood_details['lactate_dehydragenase_LDH_serum__result_value_in_words'] = 'High';
                    $blood_details['lactate_dehydragenase_LDH_serum__color_code'] = "red";
                }
                // Incase of abnormal result value - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE > $blood_details['lactate_dehydragenase_LDH_serum_high_result_value']) {
                    $blood_details['lactate_dehydragenase_LDH_serum__impact_on_health'] = "Conditions that can cause increased LDH in the blood may include liver disease, anemia, heart attack, bone fractures, muscle trauma, cancers, and infections such as encephalitis, meningitis, encephalitis, and HIV";
                } else {
                    $blood_details['lactate_dehydragenase_LDH_serum__impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE > $blood_details['lactate_dehydragenase_LDH_serum_high_result_value']) {
                    $blood_details['lactate_dehydragenase_LDH_serum__suggestion'] = "NA";
                } else {
                    $blood_details['lactate_dehydragenase_LDH_serum__suggestion'] = '';
                }
            }
        }
        if (!$lactate_dehydragenase_LDH_serum__result_found) {
            $report_issues[] = " Test Group 'L0002' or Test Code 'PNSLDH' not found";
            $report_issues_email[] = " Test Group 'L0002' or Test Code 'PNSLDH' not found" . FindTestgroupAddress('L0002');
        }
    }

    return $blood_details;
}


/**
 * Description: The getBloodTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for blood-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function getBloodTestgroupdetails($reportJsonData, &$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $BloodNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_025' || $PackageCode == 'AYN_026') {
            if ($resultData->TEST_GROUP_CODE === 'CBC.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code CBC";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code CBC" . FindTestgroupAddress('CBC.');
                }
                $BloodNablAccredited['CBC_blood_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $BloodNablAccredited['CBC_blood_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif ($PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_029') {

            if ($resultData->TEST_GROUP_CODE === 'CBC.') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code CBC";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code CBC" . FindTestgroupAddress('CBC.');
                }
                $BloodNablAccredited['CBC_blood_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $BloodNablAccredited['CBC_blood_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'E0005') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code E0005";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code E0005" . FindTestgroupAddress('E0005');
                }

                $BloodNablAccredited['E0005_blood_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $BloodNablAccredited['E0005_blood_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'L0002') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code L0002";
                    $report_issues_email[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code L0002" . FindTestgroupAddress('L0002');
                }
                $BloodNablAccredited['L0002_blood_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $BloodNablAccredited['L0002_blood_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        }
    }

    return $BloodNablAccredited;
}

/**
 * Description : getMiniralsVitaminIronDetails() function to get test result details for minerals, vitamins, and iron levels.
 * 
 * This function retrieves test results related to minerals, vitamins, and iron from the 
 * TestResultDetails array within the JSON response. It filters out relevant test groups 
 * and test codes that correspond to these diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to minerals, vitamins, and iron levels.
 */

function getMiniralsVitaminIronDetails($reportJsonData, &$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $min_vit_iron_details = [];
    // if ($PackageCode == 'AYN_026') {
    //     // Vitamin B12 sub test
    //     $vitaminbtwelve_result_found = false;
    //     foreach ($reportJsonData->TestResultDetails as $resultData) {
    //         if ($resultData->TEST_GROUP_CODE == 'V0004a' && explode('|', $resultData->TEST_CODE)[0] == 'VB12') {
    //             $vitaminbtwelve_result_found = true;
    //             $min_vit_iron_details['vitaminbtwelve_result_value'] = $resultData->RESULT_VALUE;
    //             $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['vitaminbtwelve_result_value']);
    //             if (empty($min_vit_iron_details['vitaminbtwelve_result_value'])) {
    //                 $report_issues[] = "Vitamin B12  TestResultDetails are empty";
    //                 $report_issues_email[] = "Vitamin B12  TestResultDetails are empty" . FindTestgroupAddress('V0004a');
    //             }
    //             if (
    //                 !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
    //                 !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
    //             ) {

    //                 $report_issues[] = " Vitamin B12 reference ranges are empty";
    //                 $report_issues_email[] = " Vitamin B12 reference ranges are empty" . FindTestgroupAddress('V0004a');
    //             }
    //             if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
    //                 $report_issues[] = " Vitamin B12 BR Interval are empty";
    //                 $report_issues_email[] = " Vitamin B12 BR Interval are empty" . FindTestgroupAddress('V0004a');
    //             }
    //             $min_vit_iron_details['vitaminbtwelve_low_result_value'] = $resultData->LOW_VALUE;
    //             $min_vit_iron_details['vitaminbtwelve_high_result_value'] = $resultData->HIGH_VALUE;
    //             $min_vit_iron_details['vitaminbtwelve_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
    //             $min_vit_iron_details['vitaminbtwelve_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['vitaminbtwelve_uom']);
    //             $min_vit_iron_details['vitaminbtwelve_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));


    //             if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
    //                 $min_vit_iron_details['vitaminbtwelve_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
    //             } else {
    //                 $report_issues[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12";
    //                 $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12" . FindTestgroupAddress('V0004a');
    //             }
    //             if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
    //                 $min_vit_iron_details['vitaminbtwelve_test_remraks'] = "Vitamin B12  - " . $resultData->TEST_REMARKS;
    //             } else {
    //                 $min_vit_iron_details['vitaminbtwelve_test_remraks'] = '';
    //             }

    //             $min_vit_iron_details['vitaminbtwelve_sample_method'] = $resultData->NEW_METHOD;
    //            if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value']) {
    //                 $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Low';
    //                 $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
    //             }
    //             if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] >= (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] &&  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] <= (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
    //                 $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Normal';
    //                 $min_vit_iron_details['vitaminbtwelve_color_code'] = "green";
    //             }
    //             if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
    //                 $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'High';
    //                 $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
    //             }
    //             // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
    //             if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < $min_vit_iron_details['vitaminbtwelve_low_result_value'] || $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > $min_vit_iron_details['vitaminbtwelve_high_result_value']) {
    //                 $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = "It helps to determine the cause of Anemia. Levels also indicate nutritional status in some individuals and help to monitor efficacy of treatment for vitamin b12 or folate deficiency";
    //             } else {
    //                 $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = '';
    //             }
    //             if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] ||  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
    //                 $min_vit_iron_details['vitaminbtwelve_suggestion'] = "Usually, vitamin B12 deficiency anemia is easy to treat with diet and vitamin supplements. To increase the amount of vitamin B12 in your diet, eat more of foods that contain it, such as: Beef, liver, and chicken Fish Fortified breakfast cereal Low-fat milk, yogurt, and cheese Eggs";
    //             } else {
    //                 $min_vit_iron_details['vitaminbtwelve_suggestion'] = '';
    //             }
    //         }
    //     }
    //     if (!$vitaminbtwelve_result_found) {

    //         $report_issues[] = " Test Group 'V0004a' or Test Code 'VB12' not found";
    //         $report_issues_email[] = " Test Group 'V0004a' or Test Code 'VB12' not found" . FindTestgroupAddress('V0004a');
    //     }
    //     // Vitamin D- 25 Hydroxy sub test
    //     $vitamind_result_found = false;
    //     foreach ($reportJsonData->TestResultDetails as $resultData) {
    //         if ($resultData->TEST_GROUP_CODE == 'V0004c' && explode('|', $resultData->TEST_CODE)[0] == 'OHVD') {
    //             $vitamind_result_found = true;
    //             $min_vit_iron_details['vitamind_result_value'] = $resultData->RESULT_VALUE;
    //             if (empty($min_vit_iron_details['vitamind_result_value'])) {

    //                 $report_issues[] = "Vitamin D- 25 Hydroxy TestResultDetails are empty";
    //                 $report_issues_email[] = "Vitamin D- 25 Hydroxy TestResultDetails are empty" . FindTestgroupAddress('V0004c');
    //             }
    //             $min_vit_iron_details['vitamind_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
    //             $min_vit_iron_details['vitamind_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['vitamind_uom']);
    //             if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
    //                 $min_vit_iron_details['vitamind_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
    //             } else {

    //                 $report_issues[] = " NABL mapping is either not found or is empty for the test group code V0004c and test code OHVD";
    //                 $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code V0004c and test code OHVD" . FindTestgroupAddress('V0004c');
    //             }


    //             if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
    //                 $min_vit_iron_details['vitamind_test_remraks'] = " Vitamin D- 25 Hydroxy  - " . $resultData->TEST_REMARKS;
    //             } else {
    //                 $min_vit_iron_details['vitamind_test_remraks'] = '';
    //             }
    //             $min_vit_iron_details['vitamind_sample_method'] = $resultData->NEW_METHOD;

    //             if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {

    //                 $report_issues[] = "  Vitamin D- 25 BR Interval are empty";
    //                 $report_issues_email[] = "  Vitamin D- 25 BR Interval are empty" . FindTestgroupAddress('V0004c');
    //             }

    //             $min_vit_iron_details['vitamind_BRInterval_result_value'] = trim(($resultData->BRInterval));
    //             $intervals = explode("\n", trim($min_vit_iron_details['vitamind_BRInterval_result_value']));

    //             $range_map = [];

    //             validateMutipleBRIntervals($intervals, $resultData->TEST_CODE, $reportJsonData->PatientDetails[0]->LAB_ID, $range_map);
    //             // Dynamic color and image map based on position


    //             $range_map_count = count($range_map);
    //             $thumb_colors = ['red', 'orange', 'green', 'red', 'red'];
    //             if ($range_map_count == 5) {
    //                 $thumb_colors = ['red', 'orange', 'green', 'red', 'red'];
    //             } elseif ($range_map_count == 4) {
    //                 $thumb_colors = ['red', 'orange', 'green', 'red'];
    //             } else {
    //                 $thumb_colors = [];
    //             }
    //             $thumb_colors_count = count($thumb_colors);

    //             if ($thumb_colors_count !== $range_map_count) {

    //                 $report_issues[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE;
    //                 $report_issues_email[] = "We are not getting all reference ranges from Brinterval " .  $resultData->TEST_CODE . FindTestgroupAddress('V0004c');
    //             }
    //             $min_vit_iron_details['vitamind_reference_ranges_value'] = $range_map;


    //             // Dynamic color and image map based on position
    //             $min_vit_iron_details['vitamind_result_value_in_words'] = '';
    //             $min_vit_iron_details['vitamind_color_code'] = 'gray';
    //             $min_vit_iron_details['vitamind_thumb_up_icon'] = '';

    //             $index = 0;
    //             foreach ($range_map as $label => $range) {
    //                 if (vitamindmatchesRange($min_vit_iron_details['vitamind_result_value_cleaned'], $range)) {
    //                     $min_vit_iron_details['vitamind_result_value_in_words'] = ucwords($label);
    //                     $min_vit_iron_details['vitamind_color_code'] = $thumb_colors[$index] ?? 'gray';
    //                     if ($min_vit_iron_details['vitamind_color_code'] === 'green') {
    //                         $min_vit_iron_details['vitamind_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
    //                         $min_vit_iron_details['vitamind_impact_on_health'] = '';
    //                     } elseif ($min_vit_iron_details['vitamind_color_code'] !== 'gray') {
    //                         $min_vit_iron_details['vitamind_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$min_vit_iron_details['vitamind_color_code']}-thumb.png";
    //                         $min_vit_iron_details['vitamind_impact_on_health'] = "Abnormal levels of vitamin D can indicate bone disorders, nutrition problems, organ damage, or other medical conditions";
    //                     } else {
    //                         $min_vit_iron_details['vitamind_thumb_up_icon'] = '';
    //                     }
    //                     break;
    //                 }
    //                 $index++;
    //             }

    //             if ($min_vit_iron_details['vitamind_result_value_in_words'] == '' ||  $min_vit_iron_details['vitamind_color_code'] == 'gray') {
    //                 // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE);
    //                 echo "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
    //                 $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
    //                 $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('V0004c');
    //             }
    //         }
    //     }
    //     if (!$vitamind_result_found) {

    //         $report_issues[] = " Test Group 'V0004c' or Test Code 'OHVD' not found";
    //         $report_issues_email[] = " Test Group 'V0004c' or Test Code 'OHVD' not found" . FindTestgroupAddress('V0004c');
    //     }
    // } else {
    // Vitamin B12 sub test
    if ($PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_031') {
        $vitaminbtwelve_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'V0004a' &&  explode('|', $resultData->TEST_CODE)[0] == 'VB12') {
                $vitaminbtwelve_result_found = true;
                $min_vit_iron_details['vitaminbtwelve_result_value'] = $resultData->RESULT_VALUE;
                $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['vitaminbtwelve_result_value']);
                if (($min_vit_iron_details['vitaminbtwelve_result_value'] ?? null) === '' || ($min_vit_iron_details['vitaminbtwelve_result_value'] ?? null) === null) {
                    $report_issues[] = "Vitamin B12  TestResultDetails are empty";
                    $report_issues_email[] = "Vitamin B12  TestResultDetails are empty" . FindTestgroupAddress('V0004a');
                }

                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Vitamin B12 reference ranges are empty";
                    $report_issues_email[] = " Vitamin B12 reference ranges are empty" . FindTestgroupAddress('V0004a');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Vitamin B12 BR Interval are empty";
                    $report_issues_email[] = " Vitamin B12 BR Interval are empty" . FindTestgroupAddress('V0004a');
                }
                $min_vit_iron_details['vitaminbtwelve_low_result_value'] = $resultData->LOW_VALUE;
                $min_vit_iron_details['vitaminbtwelve_high_result_value'] = $resultData->HIGH_VALUE;
                $min_vit_iron_details['vitaminbtwelve_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $min_vit_iron_details['vitaminbtwelve_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['vitaminbtwelve_uom']);
                $min_vit_iron_details['vitaminbtwelve_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $min_vit_iron_details['vitaminbtwelve_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12" . FindTestgroupAddress('V0004a');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $min_vit_iron_details['vitaminbtwelve_test_remraks'] = "Vitamin B12  - " . $resultData->TEST_REMARKS;
                } else {
                    $min_vit_iron_details['vitaminbtwelve_test_remraks'] = '';
                }
                $min_vit_iron_details['vitaminbtwelve_sample_method'] = $resultData->NEW_METHOD;
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Low';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] >= (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] &&  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] <= (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Normal';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "green";
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'High';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < $min_vit_iron_details['vitaminbtwelve_low_result_value'] || $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > $min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = "It helps to determine the cause of Anemia. Levels also indicate nutritional status in some individuals and help to monitor efficacy of treatment for vitamin b12 or folate deficiency";
                } else {
                    $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = '';
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] ||  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_suggestion'] = "Usually, vitamin B12 deficiency anemia is easy to treat with diet and vitamin supplements. To increase the amount of vitamin B12 in your diet, eat more of foods that contain it, such as: Beef, liver, and chicken Fish Fortified breakfast cereal Low-fat milk, yogurt, and cheese Eggs";
                } else {
                    $min_vit_iron_details['vitaminbtwelve_suggestion'] = '';
                }
            }
        }
        if (!$vitaminbtwelve_result_found) {

            $report_issues[] = " Test Group 'V0004a' or Test Code 'VB12' not found";
            $report_issues_email[] = " Test Group 'V0004a' or Test Code 'VB12' not found" . FindTestgroupAddress('V0004a');
        }
    } elseif ($PackageCode != 'AYN_025') {
        $vitaminbtwelve_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'V0004a' &&  explode('|', $resultData->TEST_CODE)[0] == 'VB12') {
                $vitaminbtwelve_result_found = true;
                $min_vit_iron_details['vitaminbtwelve_result_value'] = $resultData->RESULT_VALUE;
                $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['vitaminbtwelve_result_value']);
                if (($min_vit_iron_details['vitaminbtwelve_result_value'] ?? null) === '' || ($min_vit_iron_details['vitaminbtwelve_result_value'] ?? null) === null) {
                    $report_issues[] = "Vitamin B12  TestResultDetails are empty";
                    $report_issues_email[] = "Vitamin B12  TestResultDetails are empty" . FindTestgroupAddress('V0004a');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {

                    $report_issues[] = " Vitamin B12 reference ranges are empty";
                    $report_issues_email[] = " Vitamin B12 reference ranges are empty" . FindTestgroupAddress('V0004a');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Vitamin B12 BR Interval are empty";
                    $report_issues_email[] = " Vitamin B12 BR Interval are empty" . FindTestgroupAddress('V0004a');
                }
                $min_vit_iron_details['vitaminbtwelve_low_result_value'] = $resultData->LOW_VALUE;
                $min_vit_iron_details['vitaminbtwelve_high_result_value'] = $resultData->HIGH_VALUE;
                $min_vit_iron_details['vitaminbtwelve_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $min_vit_iron_details['vitaminbtwelve_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['vitaminbtwelve_uom']);
                $min_vit_iron_details['vitaminbtwelve_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $min_vit_iron_details['vitaminbtwelve_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {

                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code V0004a and test code VB12" . FindTestgroupAddress('V0004a');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $min_vit_iron_details['vitaminbtwelve_test_remraks'] = "Vitamin B12  - " . $resultData->TEST_REMARKS;
                } else {
                    $min_vit_iron_details['vitaminbtwelve_test_remraks'] = '';
                }

                $min_vit_iron_details['vitaminbtwelve_sample_method'] = $resultData->NEW_METHOD;
                   if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Low';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] >= (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] &&  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] <= (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'Normal';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "green";
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_result_value_in_words'] = 'High';
                    $min_vit_iron_details['vitaminbtwelve_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < $min_vit_iron_details['vitaminbtwelve_low_result_value'] || $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > $min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = "It helps to determine the cause of Anemia. Levels also indicate nutritional status in some individuals and help to monitor efficacy of treatment for vitamin b12 or folate deficiency";
                } else {
                    $min_vit_iron_details['vitaminbtwelve_impact_on_health'] = '';
                }
                if ($min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] < (float) $min_vit_iron_details['vitaminbtwelve_low_result_value'] ||  $min_vit_iron_details['vitaminbtwelve_result_value_cleaned'] > (float)$min_vit_iron_details['vitaminbtwelve_high_result_value']) {
                    $min_vit_iron_details['vitaminbtwelve_suggestion'] = "Usually, vitamin B12 deficiency anemia is easy to treat with diet and vitamin supplements. To increase the amount of vitamin B12 in your diet, eat more of foods that contain it, such as: Beef, liver, and chicken Fish Fortified breakfast cereal Low-fat milk, yogurt, and cheese Eggs";
                } else {
                    $min_vit_iron_details['vitaminbtwelve_suggestion'] = '';
                }
            }
        }
        if (!$vitaminbtwelve_result_found) {

            $report_issues[] = " Test Group 'V0004a' or Test Code 'VB12' not found";
            $report_issues_email[] = " Test Group 'V0004a' or Test Code 'VB12' not found" . FindTestgroupAddress('V0004a');
        }
    }
    // Vitamin D- 25 Hydroxy sub test
    if ($PackageCode != 'AYN_025') {
        $vitamind_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'V0004c' && explode('|', $resultData->TEST_CODE)[0] == 'OHVD') {
                $vitamind_result_found = true;
                $min_vit_iron_details['vitamind_result_value'] = $resultData->RESULT_VALUE;
                $min_vit_iron_details['vitamind_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['vitamind_result_value']);

                if (($min_vit_iron_details['vitamind_result_value'] ?? null) === '' || ($min_vit_iron_details['vitamind_result_value'] ?? null) === null) {
                    $report_issues[] = "Vitamin D- 25 Hydroxy TestResultDetails are empty";
                    $report_issues_email[] = "Vitamin D- 25 Hydroxy TestResultDetails are empty" . FindTestgroupAddress('V0004c');
                }

                $min_vit_iron_details['vitamind_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $min_vit_iron_details['vitamind_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['vitamind_uom']);

                if (!isset($resultData->BRInterval) || $resultData->BRInterval == "") {
                    $report_issues[] = "  Vitamin D- 25 BR Interval are empty";
                    $report_issues_email[] = "  Vitamin D- 25 BR Interval are empty" . FindTestgroupAddress('V0004c');
                }

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $min_vit_iron_details['vitamind_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code V0004c and test code OHVD";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code V0004c and test code OHVD" . FindTestgroupAddress('V0004c');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $min_vit_iron_details['vitamind_test_remraks'] = " Vitamin D- 25 Hydroxy  - " . $resultData->TEST_REMARKS;
                } else {
                    $min_vit_iron_details['vitamind_test_remraks'] = '';
                }

                $min_vit_iron_details['vitamind_sample_method'] = $resultData->NEW_METHOD;
                $min_vit_iron_details['vitamind_BRInterval_result_value'] = trim(($resultData->BRInterval));
                $intervals = explode("\n", trim($min_vit_iron_details['vitamind_BRInterval_result_value']));

                $range_map = [];
                $main_range = null;
                $reference_data = [];
                $invalid_lines = [];
                // Detect unit once (from the first line)
                $unit_detected = '';
                if (preg_match('/[a-zA-Z%\/]+$/', $min_vit_iron_details['vitamind_BRInterval_result_value'], $u)) {
                    $unit_detected = trim($u[0]);
                }

                foreach ($intervals as $line) {
                    $line = trim($line);
                    if ($line === '') continue;
                    if (strpos($line, ':') !== false) {
                        // Case 1: Label: Range
                        [$label, $range] = explode(':', $line, 2);
                        if(preg_match('/\d/', $label))
                            [$range, $label] = explode(':', $line, 2);
                        $label = trim($label);
                        $range = trim($range);
                        // Keep original range with unit for printing
                        $reference_data[$label] = $range;
                        // Clean only numbers/operators for parsing
                        $clean_range = preg_replace('/[^\d<>=\-\.\s]/', '', $range);
                        $clean_range = preg_replace('/\s+/', ' ', $clean_range);
                        $clean_range = trim($clean_range);
                        if (
                            preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $clean_range) ||
                            preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $clean_range)
                        ) {
                            $range_map[strtolower($label)] = $clean_range;
                            if (in_array(strtolower($label), ['normal', 'desirable'])) {
                                $main_range = $clean_range;
                            }
                        } else {
                            $invalid_lines[] = $line;
                        }
                    } else {
                        // Case 2 & 3: Range without label
                        $reference_data['Range'] = $line; // keep original for printing
                        $clean_range = preg_replace('/[^\d<>=\-\.\s]/', '', $line);
                        $clean_range = preg_replace('/\s+/', ' ', $clean_range);
                        $clean_range = trim($clean_range);
                        if (preg_match('/^\d+(\.\d+)?\s*-\s*\d+(\.\d+)?$/', $clean_range)) {
                            $main_range = $clean_range;
                        } elseif (preg_match('/^(<=|>=|<|>)\s*\d+(\.\d+)?$/', $clean_range)) {
                            $main_range = $clean_range;
                        } else {
                            $invalid_lines[] = $line;
                        }
                    }
                }
                // 🔹 Attach unit at the end if found
                if ($unit_detected !== '') {
                    foreach ($reference_data as $label => $range) {
                        if (strpos($range, $unit_detected) === false) {
                            $reference_data[$label] = $range . ' ' . $unit_detected;
                        }
                    }
                }

                $min_vit_iron_details['vitamind_reference_ranges_value'] = $reference_data;
                $min_vit_iron_details['vitamind_result_value_in_words'] = '';
                $min_vit_iron_details['vitamind_color_code'] = 'gray';
                $min_vit_iron_details['vitamind_thumb_up_icon'] = '';

                $matched = false;
                $label_color_map = [
                    'severe deficiency' => 'red',
                    'deficient' => 'red',
                    'mild to moderate deficiency' => 'orange',
                    'insufficient' => 'orange',
                    'optimum level' => 'green',
                    'desired level' => 'green',
                    'increased risk of hypercalciuria' => 'orange',
                    'toxicity possible' => 'red',
                    'toxic level' => 'red'
                ];
                $index = 0;

                foreach ($range_map as $label => $range) {
                    if (vitamindmatchesRange($min_vit_iron_details['vitamind_result_value_cleaned'], $range)) {
                        $label_lc = strtolower(trim($label));
                        $min_vit_iron_details['vitamind_result_value_in_words'] = ucwords($label_lc);
                        $min_vit_iron_details['vitamind_color_code'] = $label_color_map[$label_lc] ?? 'gray';

                        if ($min_vit_iron_details['vitamind_color_code'] === 'green') {
                            $min_vit_iron_details['vitamind_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                            $min_vit_iron_details['vitamind_impact_on_health'] = '';
                            $min_vit_iron_details['vitamind_suggestion'] = '';
                        } elseif ($min_vit_iron_details['vitamind_color_code'] !== 'gray') {
                            $min_vit_iron_details['vitamind_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$min_vit_iron_details['vitamind_color_code']}-thumb.png";
                            $min_vit_iron_details['vitamind_impact_on_health'] = "Abnormal levels of vitamin D can indicate bone disorders, nutrition problems, organ damage, or other medical conditions";
                            $min_vit_iron_details['vitamind_suggestion'] = "NA";
                        } else {
                            $min_vit_iron_details['vitamind_thumb_up_icon'] = '';
                        }
                        $matched = true;
                        break;
                    }
                    $index++;
                }


                if ($min_vit_iron_details['vitamind_result_value_in_words'] == '' ||  $min_vit_iron_details['vitamind_color_code'] == 'gray') {
                    // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE);
                    // echo "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE;
                    $report_issues_email[] = "Result Value is not satisfying any of the reference ranges for " . $resultData->TEST_CODE . FindTestgroupAddress('V0004c');
                }
            }
        }
        if (!$vitamind_result_found) {

            $report_issues[] = " Test Group 'V0004c' or Test Code 'OHVD' not found";
            $report_issues_email[] = " Test Group 'V0004c' or Test Code 'OHVD' not found" . FindTestgroupAddress('V0004c');
        }
    }


    // Folic Acid sub test
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'FOLIC' && $resultData->TEST_CODE == 'FOLIC') {
            $min_vit_iron_details['folic_acid_result_value'] = $resultData->RESULT_VALUE;
            if (($min_vit_iron_details['folic_acid_result_value'] ?? null) === '' || ($min_vit_iron_details['folic_acid_result_value'] ?? null) === null) {
                $report_issues[] = "Folic Acid TestResultDetails are empty";
                $report_issues_email[] = "Folic Acid TestResultDetails are empty" . FindTestgroupAddress('');
            }

            $min_vit_iron_details['folic_acid_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < 2.6) {
                $min_vit_iron_details['folic_acid_result_value_in_words'] = 'Low';
                $min_vit_iron_details['folic_acid_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= 2.6 && $resultData->RESULT_VALUE <= 12.2) {
                $min_vit_iron_details['folic_acid_result_value_in_words'] = 'Normal';
                $min_vit_iron_details['folic_acid_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > 12.2) {
                $min_vit_iron_details['folic_acid_result_value_in_words'] = 'High';
                $min_vit_iron_details['folic_acid_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < 2.6 || $resultData->RESULT_VALUE > 12.2) {
                $min_vit_iron_details['folic_acid_impact_on_health'] = "Folate deficiency is associated with macrocytosis and megaloblastic anemia.Seen in pregnant women carrying fetuses with neural tube defects.Folate deficiency can be due to insufficient dietary intake, in pregnant women or in alcoholics.Other cause includes liver disease,hemolytic disorders malignancies and IEM related to folate metabolisms";
            } else {
                $min_vit_iron_details['folic_acid_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < 2.6 || $resultData->RESULT_VALUE > 12.2) {
                $min_vit_iron_details['folic_acid_suggestion'] = "Most cases of vitamin B12 and folate deficiency can be easily treated with injections or tablets. In some cases, improving your diet can help treat the condition. Vitamin B12 is found in meat,fish, eggs, dairy products, yeast extract and specially fortified foods.The best sources of folate include green vegetables, such as broccoli sprouts and peas";
            } else {
                $min_vit_iron_details['folic_acid_suggestion'] = '';
            }
        }
    }

    // Phosphorus sub test
        if ($PackageCode != 'AYN_026' && $PackageCode !== 'AYN_016' && $PackageCode !== 'AYN_025') {
        $phosphorus_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'P0010b' && explode('|', $resultData->TEST_CODE)[0] == 'PHOS') {
                $phosphorus_result_found = true;
                $min_vit_iron_details['phosphorus_result_value'] = $resultData->RESULT_VALUE;
                if (($min_vit_iron_details['phosphorus_result_value'] ?? null) === '' || ($min_vit_iron_details['phosphorus_result_value'] ?? null) === null) {
                    $report_issues[] = "Phosphorus TestResultDetails are empty";
                    $report_issues_email[] = "Phosphorus TestResultDetails are empty" . FindTestgroupAddress('P0010b');
                }

                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    $report_issues[] = " Phosphorus reference ranges are empty";
                    $report_issues_email[] = " Phosphorus reference ranges are empty" . FindTestgroupAddress('P0010b');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                    $report_issues[] = " Phosphorus BR Interval are empty";
                    $report_issues_email[] = " Phosphorus BR Interval are empty" . FindTestgroupAddress('P0010b');
                }
                $min_vit_iron_details['phosphorus_low_result_value'] = $resultData->LOW_VALUE;
                $min_vit_iron_details['phosphorus_high_result_value'] = $resultData->HIGH_VALUE;
                $min_vit_iron_details['phosphorus_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $min_vit_iron_details['phosphorus_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['phosphorus_uom']);
                $min_vit_iron_details['phosphorus_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $min_vit_iron_details['phosphorus_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code P0010b and test code PHOS";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code P0010b and test code PHOS" . FindTestgroupAddress('P0010b');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $min_vit_iron_details['phosphorus_test_remraks'] = " Phosphorus  - " . $resultData->TEST_REMARKS;
                } else {
                    $min_vit_iron_details['phosphorus_test_remraks'] = '';
                }
                $min_vit_iron_details['phosphorus_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE < $min_vit_iron_details['phosphorus_low_result_value']) {
                    $min_vit_iron_details['phosphorus_result_value_in_words'] = 'Low';
                    $min_vit_iron_details['phosphorus_color_code'] = "red";
                }
                if ($resultData->RESULT_VALUE >= $min_vit_iron_details['phosphorus_low_result_value'] && $resultData->RESULT_VALUE <= $min_vit_iron_details['phosphorus_high_result_value']) {
                    $min_vit_iron_details['phosphorus_result_value_in_words'] = 'Normal';
                    $min_vit_iron_details['phosphorus_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE > $min_vit_iron_details['phosphorus_high_result_value']) {
                    $min_vit_iron_details['phosphorus_result_value_in_words'] = 'High';
                    $min_vit_iron_details['phosphorus_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE < $min_vit_iron_details['phosphorus_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['phosphorus_high_result_value']) {
                    $min_vit_iron_details['phosphorus_impact_on_health'] = "Decreased levels:Shift of phosphate from extracellular to intracellular, renal phosphate wasting, loss from the gastrointestinal tract, and loss from intracellular stores. Increased levels: Secondary to an inability of the kidneys to excrete phosphate, increased intake or a shift of phosphate from the tissues into the extracellular fluid";
                } else {
                    $min_vit_iron_details['phosphorus_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE < $min_vit_iron_details['phosphorus_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['phosphorus_high_result_value']) {
                    $min_vit_iron_details['phosphorus_suggestion'] = "High phosphate levels in your blood can increase your risk for serious medical problems and other complications. Treating hyperphosphatemia with dietary changes and medication as soon as possible can prevent these complications. Getting treated can also slow bone problems linked to chronic kidney disease";
                } else {
                    $min_vit_iron_details['phosphorus_suggestion'] = '';
                }
            }
        }
        if (!$phosphorus_result_found) {
            $report_issues[] = " Test Group 'P0010b' or Test Code 'PHOS' not found";
            $report_issues_email[] = " Test Group 'P0010b' or Test Code 'PHOS' not found" . FindTestgroupAddress('P0010b');
        }
    }


    // Ferritin sub test
    if ($PackageCode == 'AYN_019' || $PackageCode == 'AYN_020') {
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
            $ferritin_result_found =  false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'F0002' && $resultData->TEST_CODE == 'BFTN') {
                    $ferritin_result_found =  true;
                    $min_vit_iron_details['ferritin_result_value'] = $resultData->RESULT_VALUE;
                    if (($min_vit_iron_details['ferritin_result_value'] ?? null) === '' || ($min_vit_iron_details['ferritin_result_value'] ?? null) === null) {
                        $report_issues[] = "Ferritin TestResultDetails are empty";
                        $report_issues_email[] = "Ferritin TestResultDetails are empty" . FindTestgroupAddress('F0002');
                    }
                    $min_vit_iron_details['ferritin_sample_method'] = $resultData->NEW_METHOD;

                    if ($resultData->RESULT_VALUE < 20) {
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'Low';
                        $min_vit_iron_details['ferritin_color_code'] = "red";
                        $min_vit_iron_details['ferritin_impact_on_health'] = "Serum ferritin is decreased in iron deficiency anemia..";
                        $min_vit_iron_details['ferritin_suggestion'] = "Consider consulting a doctor for iron supplementation";
                    } elseif ($resultData->RESULT_VALUE >= 20 && $resultData->RESULT_VALUE <= 250) {
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'Normal';
                        $min_vit_iron_details['ferritin_color_code'] = "green";
                        $min_vit_iron_details['ferritin_impact_on_health'] = '';
                        $min_vit_iron_details['ferritin_suggestion'] = "Maintain a balanced diet to sustain normal levels";
                    } else { // $resultData->RESULT_VALUE > 250
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'High';
                        $min_vit_iron_details['ferritin_color_code'] = "red";
                        $min_vit_iron_details['ferritin_impact_on_health'] = "Elevated ferritin can be seen in Chronic inflammation..";
                        $min_vit_iron_details['ferritin_suggestion'] = "Consult a specialist to rule out chronic or neoplastic diseases";
                    }
                }
            }
            if (!$ferritin_result_found) {
                $report_issues[] = " Test Group 'F0002' or Test Code 'BFTN' not found";
                $report_issues_email[] = " Test Group 'F0002' or Test Code 'BFTN' not found" . FindTestgroupAddress('F0002');
            }
        }
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
            $ferritin_result_found =  false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'F0002' && $resultData->TEST_CODE == 'BFTN') {
                    $ferritin_result_found =  true;
                    $min_vit_iron_details['ferritin_result_value'] = $resultData->RESULT_VALUE;
                    if (($min_vit_iron_details['ferritin_result_value'] ?? null) === '' || ($min_vit_iron_details['ferritin_result_value'] ?? null) === null) {
                        $report_issues[] = "Ferritin TestResultDetails are empty";
                        $report_issues_email[] = "Ferritin TestResultDetails are empty" . FindTestgroupAddress('F0002');
                    }

                    $min_vit_iron_details['ferritin_sample_method'] = $resultData->NEW_METHOD;
                    if ($resultData->RESULT_VALUE < 10) {
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'Low';
                        $min_vit_iron_details['ferritin_color_code'] = "red";
                    } else {
                        $min_vit_iron_details['ferritin_color_code'] = "";
                    }
                    if ($resultData->RESULT_VALUE >= 10 && $resultData->RESULT_VALUE <= 120) {
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'Normal';
                        $min_vit_iron_details['ferritin_color_code'] = "green";
                    } else {
                        $min_vit_iron_details['ferritin_color_code'] = "";
                    }
                    if ($resultData->RESULT_VALUE > 120) {
                        $min_vit_iron_details['ferritin_result_value_in_words'] = 'High';
                        $min_vit_iron_details['ferritin_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($resultData->RESULT_VALUE < 10 || $resultData->RESULT_VALUE > 120) {
                        $min_vit_iron_details['ferritin_impact_on_health'] = "Serum ferritin is decreased in iron deficiency anemia while increased in patients with iron overload (hemochromatosis, hemosiderosis).Elevated ferritin can be also seen in Chronic inflammation acute and chronic liver disease, chronic renal failure, and in certain neoplastic disease.Serum ferritin can be used to monitor the effects of iron therapy";
                    } else {
                        $min_vit_iron_details['ferritin_impact_on_health'] = '';
                    }
                    if ($resultData->RESULT_VALUE < 10 || $resultData->RESULT_VALUE > 120) {
                        $min_vit_iron_details['ferritin_suggestion'] = '';
                    } else {
                        $min_vit_iron_details['ferritin_suggestion'] = '';
                    }
                }
            }
            if (!$ferritin_result_found) {
                $report_issues[] = " Test Group 'F0002' or Test Code 'BFTN' not found";
                $report_issues_email[] = " Test Group 'F0002' or Test Code 'BFTN' not found" . FindTestgroupAddress('F0002');
            }
        }
    }
    // Iron sub test             
    $iron_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Iron Studies' && explode('|', $resultData->TEST_CODE)[0] == 'IRON') {
            $iron_result_found = true;
            $min_vit_iron_details['iron_result_value'] = $resultData->RESULT_VALUE;
            if (($min_vit_iron_details['iron_result_value'] ?? null) === '' || ($min_vit_iron_details['iron_result_value'] ?? null) === null) {
                $report_issues[] = "Iron TestResultDetails are empty";
                $report_issues_email[] = "Iron TestResultDetails are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " Iron reference ranges are empty";
                $report_issues_email[] = " Iron reference ranges are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                $report_issues[] = " Iron BR Interval are empty";
                $report_issues_email[] = " Iron BR Interval are empty" . FindTestgroupAddress('Iron Studies');
            }

            $min_vit_iron_details['iron_low_result_value'] = $resultData->LOW_VALUE;
            $min_vit_iron_details['iron_high_result_value'] = $resultData->HIGH_VALUE;
            $min_vit_iron_details['iron_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $min_vit_iron_details['iron_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['iron_uom']);
            $min_vit_iron_details['iron_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $min_vit_iron_details['iron_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code IRON";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code IRON" . FindTestgroupAddress('Iron Studies');
            }

            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $min_vit_iron_details['iron_test_remraks'] = " Iron  - " . $resultData->TEST_REMARKS;
            } else {
                $min_vit_iron_details['iron_test_remraks'] = '';
            }

            $min_vit_iron_details['iron_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['iron_low_result_value']) {
                $min_vit_iron_details['iron_result_value_in_words'] = 'Low';
                $min_vit_iron_details['iron_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $min_vit_iron_details['iron_low_result_value'] && $resultData->RESULT_VALUE <= $min_vit_iron_details['iron_high_result_value']) {
                $min_vit_iron_details['iron_result_value_in_words'] = 'Normal';
                $min_vit_iron_details['iron_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $min_vit_iron_details['iron_high_result_value']) {
                $min_vit_iron_details['iron_result_value_in_words'] = 'High';
                $min_vit_iron_details['iron_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['iron_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['iron_high_result_value']) {
                $min_vit_iron_details['iron_impact_on_health'] = "The serum iron concentration is decreased in iron deficiency anemia and in chronic inflammatory disorders (acute infection, immunization, and myocardial infarction), Hemorrhage.Too much iron in the body can be seen in hemochromatosis,hemolytic anemia,hepatitis,Iron poisoning and Frequent blood transfusions";
            } else {
                $min_vit_iron_details['iron_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['iron_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['iron_high_result_value']) {
                $min_vit_iron_details['iron_suggestion'] = "Avoid supplements that contain iron, vitamin C supplements and uncooked fish and shellfish,limit alcohol intake, as this can damage the liver.Iron Chelation therapy for severe iron overload.Iron supplementation can be done incase of iron deficiency";
            } else {
                $min_vit_iron_details['iron_suggestion'] = '';
            }
        }
    }
    if (!$iron_result_found) {
        $report_issues[] = " Test Group 'Iron Studies' or Test Code 'IRON' not found";
        $report_issues_email[] = " Test Group 'Iron Studies' or Test Code 'IRON' not found" . FindTestgroupAddress('Iron Studies');
    }
    // UIBC sub test
    $uibc_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Iron Studies' && explode('|', $resultData->TEST_CODE)[0] == 'UIBC') {
            $uibc_result_found = true;
            $min_vit_iron_details['uibc_result_value'] = $resultData->RESULT_VALUE;
            if (($min_vit_iron_details['uibc_result_value'] ?? null) === '' || ($min_vit_iron_details['uibc_result_value'] ?? null) === null) {
                $report_issues[] = "UIBC TestResultDetails are empty";
                $report_issues_email[] = "UIBC TestResultDetails are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " UIBC reference ranges are empty";
                $report_issues_email[] = " UIBC reference ranges are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                // updateFailedReportLog($reportJsonData->PatientDetails[0]->LAB_ID, " UIBC BR Interval are empty");
                // echo $reportJsonData->PatientDetails[0]->LAB_ID . " UIBC BR Interval are empty";
                // exit;
                $report_issues[] = " UIBC BR Interval are empty";
                $report_issues_email[] = " UIBC BR Interval are empty" . FindTestgroupAddress('Iron Studies');
            }

            $min_vit_iron_details['uibc_low_result_value'] = $resultData->LOW_VALUE;
            $min_vit_iron_details['uibc_high_result_value'] = $resultData->HIGH_VALUE;
            $min_vit_iron_details['uibc_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $min_vit_iron_details['uibc_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['uibc_uom']);
            $min_vit_iron_details['uibc_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $min_vit_iron_details['uibc_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code UIBC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code UIBC" . FindTestgroupAddress('Iron Studies');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $min_vit_iron_details['uibc_test_remraks'] = " UIBC  - " . $resultData->TEST_REMARKS;
            } else {
                $min_vit_iron_details['uibc_test_remraks'] = '';
            }
            $min_vit_iron_details['uibc_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['uibc_low_result_value']) {
                $min_vit_iron_details['uibc_result_value_in_words'] = 'Low';
                $min_vit_iron_details['uibc_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $min_vit_iron_details['uibc_low_result_value'] && $resultData->RESULT_VALUE <= $min_vit_iron_details['uibc_high_result_value']) {
                $min_vit_iron_details['uibc_result_value_in_words'] = 'Normal';
                $min_vit_iron_details['uibc_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $min_vit_iron_details['uibc_high_result_value']) {
                $min_vit_iron_details['uibc_result_value_in_words'] = 'High';
                $min_vit_iron_details['uibc_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['uibc_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['uibc_high_result_value']) {
                $min_vit_iron_details['uibc_impact_on_health'] = "UIBC's value lies in its ability to help diagnose various iron disorders. Elevated UIBC might suggest iron deficiency, while low UIBC could indicate inflammation or chronic disease. When paired with other markers, it aids in distinguishing different types of anemias and identifying the underlying causes";
            } else {
                $min_vit_iron_details['uibc_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['uibc_low_result_value'] || $resultData->RESULT_VALUE > $min_vit_iron_details['uibc_high_result_value']) {
                $min_vit_iron_details['uibc_suggestion'] = "";
            } else {
                $min_vit_iron_details['uibc_suggestion'] = '';
            }
        }
    }
    if (!$uibc_result_found) {
        $report_issues[] = " Test Group 'Iron Studies' or Test Code 'UIBC' not found";
        $report_issues_email[] = " Test Group 'Iron Studies' or Test Code 'UIBC' not found" . FindTestgroupAddress('Iron Studies');
    }
    // TIBC sub test
    $tibc_result_found = false;
    foreach ($reportJsonData->TestResultDetails as $resultData) {
        if ($resultData->TEST_GROUP_CODE == 'Iron Studies' &&  explode('|', $resultData->TEST_CODE)[0] == 'TIBC') {
            $tibc_result_found = true;
            $min_vit_iron_details['tibc_result_value'] = $resultData->RESULT_VALUE;
            if (($min_vit_iron_details['tibc_result_value'] ?? null) === '' || ($min_vit_iron_details['tibc_result_value'] ?? null) === null) {
                $report_issues[] = "TIBC TestResultDetails are empty";
                $report_issues_email[] = "TIBC TestResultDetails are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (
                !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
            ) {
                $report_issues[] = " TIBC reference ranges are empty";
                $report_issues_email[] = " TIBC reference ranges are empty" . FindTestgroupAddress('Iron Studies');
            }
            if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                $report_issues[] = " TIBC BR Interval are empty";
                $report_issues_email[] = " TIBC BR Interval are empty" . FindTestgroupAddress('Iron Studies');
            }

            $min_vit_iron_details['tibc_low_result_value'] = $resultData->LOW_VALUE;
            $min_vit_iron_details['tibc_high_result_value'] = $resultData->HIGH_VALUE;
            $min_vit_iron_details['tibc_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
            $min_vit_iron_details['tibc_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['tibc_uom']);
            $min_vit_iron_details['tibc_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

            if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                $min_vit_iron_details['tibc_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
            } else {
                $report_issues[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code TIBC";
                $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code Iron Studies and test code TIBC" . FindTestgroupAddress('Iron Studies');
            }
            if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                $min_vit_iron_details['tibc_test_remraks'] = " TIBC  - " . $resultData->TEST_REMARKS;
            } else {
                $min_vit_iron_details['tibc_test_remraks'] = '';
            }
            $min_vit_iron_details['tibc_sample_method'] = $resultData->NEW_METHOD;
            if ($resultData->RESULT_VALUE < $min_vit_iron_details['tibc_low_result_value']) {
                $min_vit_iron_details['tibc_result_value_in_words'] = 'Low';
                $min_vit_iron_details['tibc_color_code'] = "red";
            }
            if ($resultData->RESULT_VALUE >= $min_vit_iron_details['tibc_low_result_value'] && $resultData->RESULT_VALUE <= $min_vit_iron_details['tibc_high_result_value']) {
                $min_vit_iron_details['tibc_result_value_in_words'] = 'Normal';
                $min_vit_iron_details['tibc_color_code'] = "green";
            }
            if ($resultData->RESULT_VALUE > $min_vit_iron_details['tibc_high_result_value']) {
                $min_vit_iron_details['tibc_result_value_in_words'] = 'High';
                $min_vit_iron_details['tibc_color_code'] = "red";
            }
            // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
            if ($resultData->RESULT_VALUE > $min_vit_iron_details['tibc_high_result_value']) {
                $min_vit_iron_details['tibc_impact_on_health'] = "";
            } else {
                $min_vit_iron_details['tibc_impact_on_health'] = '';
            }
            if ($resultData->RESULT_VALUE > $min_vit_iron_details['tibc_high_result_value']) {
                $min_vit_iron_details['tibc_suggestion'] = "";
            } else {
                $min_vit_iron_details['tibc_suggestion'] = '';
            }
        }
    }
    if (!$tibc_result_found) {
        $report_issues[] = " Test Group 'Iron Studies' or Test Code 'TIBC' not found";
        $report_issues_email[] = " Test Group 'Iron Studies' or Test Code 'TIBC' not found" . FindTestgroupAddress('Iron Studies');
    }
    if ($PackageCode == 'AYN_031') {
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'M') {
            $testosterone_result_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'T0002b' &&  explode('|', $resultData->TEST_CODE)[0] == 'TESTO') {
                    $testosterone_result_found = true;
                    $min_vit_iron_details['testosterone_result_value'] = $resultData->RESULT_VALUE;
                    $min_vit_iron_details['testosterone_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['testosterone_result_value']);
                    if (($min_vit_iron_details['testosterone_result_value'] ?? null) === '' || ($min_vit_iron_details['testosterone_result_value'] ?? null) === null) {
                        $report_issues[] = "Testosterone Total Serum TestResultDetails are empty";
                        $report_issues_email[] = "Testosterone Total Serum TestResultDetails are empty" . FindTestgroupAddress('T0002b');
                    }
                    if (
                        !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                        !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                    ) {

                        $report_issues[] = " Testosterone Total Serum reference ranges are empty";
                        $report_issues_email[] = " Testosterone Total Serum reference ranges are empty" . FindTestgroupAddress('T0002b');
                    }
                    if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                        $report_issues[] = " Testosterone Total Serum BR Interval are empty";
                        $report_issues_email[] = " Testosterone Total Serum BR Interval are empty" . FindTestgroupAddress('T0002b');
                    }

                    $min_vit_iron_details['testosterone_low_result_value'] = $resultData->LOW_VALUE;
                    $min_vit_iron_details['testosterone_high_result_value'] = $resultData->HIGH_VALUE;
                    $min_vit_iron_details['testosterone_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                    $min_vit_iron_details['testosterone_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['testosterone_uom']);
                    $min_vit_iron_details['testosterone_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));

                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $min_vit_iron_details['testosterone_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {
                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code T0002b and test code TESTO";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code T0002b and test code TESTO" . FindTestgroupAddress('T0002b');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $min_vit_iron_details['testosterone_test_remraks'] = "Testosterone  - " . $resultData->TEST_REMARKS;
                    } else {
                        $min_vit_iron_details['testosterone_test_remraks'] = '';
                    }
                    $min_vit_iron_details['testosterone_sample_method'] = $resultData->NEW_METHOD;
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] < $min_vit_iron_details['testosterone_low_result_value']) {
                        $min_vit_iron_details['testosterone_result_value_in_words'] = 'Low';
                        $min_vit_iron_details['testosterone_color_code'] = "red";
                    }
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] >= $min_vit_iron_details['testosterone_low_result_value'] && $min_vit_iron_details['testosterone_result_value_cleaned'] <= $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_result_value_in_words'] = 'Normal';
                        $min_vit_iron_details['testosterone_color_code'] = "green";
                    }
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] > $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_result_value_in_words'] = 'High';
                        $min_vit_iron_details['testosterone_color_code'] = "red";
                    }
                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] <  $min_vit_iron_details['testosterone_low_result_value'] || $min_vit_iron_details['testosterone_result_value_cleaned'] >  $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_impact_on_health'] = "<span>
					    In males, a testosterone test may be performed if you have symptoms that suggest a low testosterone level, such as:<br>
					    <span>1. Early or late onset of puberty</span><br>
					    <span>2. Erectile dysfunction</span><br>
					    <span>3. Fertility problems</span><br>
					    <span>4. Osteoporosis or thinning of the bones</span><br>
					    <span>5. Decrease in sex drive</span>
					</span>";
                    } else {
                        $min_vit_iron_details['testosterone_impact_on_health'] = '';
                    }
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] >  $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_suggestion'] = "";
                    } else {
                        $min_vit_iron_details['testosterone_suggestion'] = '';
                    }
                }
            }
            if (!$testosterone_result_found) {
                $report_issues[] = " Test Group 'T0002b' or Test Code 'TESTO' not found";
                $report_issues_email[] = " Test Group 'T0002b' or Test Code 'TESTO' not found" . FindTestgroupAddress('T0002b');
            }
        }
        if (trim($reportJsonData->PatientDetails[0]->GENDER) == 'F') {
            $testosterone_result_found = false;
            foreach ($reportJsonData->TestResultDetails as $resultData) {
                if ($resultData->TEST_GROUP_CODE == 'T0002b' &&  explode('|', $resultData->TEST_CODE)[0] == 'TESTO') {
                    $testosterone_result_found = true;
                    $min_vit_iron_details['testosterone_result_value'] = $resultData->RESULT_VALUE;
                    $min_vit_iron_details['testosterone_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['testosterone_result_value']);
                    if (($min_vit_iron_details['testosterone_result_value'] ?? null) === '' || ($min_vit_iron_details['testosterone_result_value'] ?? null) === null) {
                        $report_issues[] = "Testosterone Total Serum TestResultDetails are empty";
                        $report_issues_email[] = "Testosterone Total Serum TestResultDetails are empty" . FindTestgroupAddress('T0002b');
                    }
                    if (!isset($resultData->HIGH_VALUE)) {
                        $report_issues[] = " Testosterone Total Serum reference ranges are empty";
                        $report_issues_email[] = " Testosterone Total Serum reference ranges are empty" . FindTestgroupAddress('T0002b');
                    }
                    if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {

                        $report_issues[] = " Testosterone Total Serum BR Interval are empty";
                        $report_issues_email[] = " Testosterone Total Serum BR Interval are empty" . FindTestgroupAddress('T0002b');
                    }

                    $min_vit_iron_details['testosterone_high_result_value'] = $resultData->HIGH_VALUE;
                    $min_vit_iron_details['testosterone_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                    $min_vit_iron_details['testosterone_uom'] = str_replace(["�", "ï¿½"], "μ", $min_vit_iron_details['testosterone_uom']);
                    $min_vit_iron_details['testosterone_BRInterval_result_value'] = trim(utf8_decode($resultData->BRInterval));
                    if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                        $min_vit_iron_details['testosterone_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                    } else {
                        $report_issues[] = " NABL mapping is either not found or is empty for the test group code T0002b and test code TESTO";
                        $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code T0002b and test code TESTO" . FindTestgroupAddress('T0002b');
                    }
                    if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                        $min_vit_iron_details['testosterone_test_remraks'] = "Testosterone - " . $resultData->TEST_REMARKS;
                    } else {
                        $min_vit_iron_details['testosterone_test_remraks'] = '';
                    }
                    $min_vit_iron_details['testosterone_sample_method'] = $resultData->NEW_METHOD;
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] < $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_result_value_in_words'] = 'Normal';
                        $min_vit_iron_details['testosterone_color_code'] = "green";
                    } else {
                        $min_vit_iron_details['testosterone_result_value_in_words'] = 'High';
                        $min_vit_iron_details['testosterone_color_code'] = "red";
                    }

                    // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] > $min_vit_iron_details['testosterone_high_result_value']) {
                        $min_vit_iron_details['testosterone_impact_on_health'] = "<span>
				    In females, if physical changes suggest a higher-than-normal testosterone level. Changes may include the following:
				    <span>1. Irregular periods</span><br>
				    <span>2. Loss of periods</span><br>
				    <span>3. Changes in hair growth patterns</span><br>
				    <span>4. Voice changes</span><br>
				    <span>5. Skin changes such as oily skin or acne</span>
				</span>
				";
                    } else {
                        $min_vit_iron_details['testosterone_impact_on_health'] = '';
                    }
                    if ($min_vit_iron_details['testosterone_result_value_cleaned'] >= 0.9) {
                        $min_vit_iron_details['testosterone_suggestion'] = "";
                    } else {
                        $min_vit_iron_details['testosterone_suggestion'] = '';
                    }
                }
            }
            if (!$testosterone_result_found) {
                $report_issues[] = " Test Group 'T0002b' or Test Code 'TESTO' not found";
                $report_issues_email[] = " Test Group 'T0002b' or Test Code 'TESTO' not found" . FindTestgroupAddress('T0002b');
            }
        }
    }



    // % OF IRON SATURATION 
    if ($PackageCode == 'AYN_026' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_029' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_025') {
        $iron_saturation_result_found = false;

        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'Iron Studies' && explode('|', $resultData->TEST_CODE)[0] == 'IST') {
                $iron_saturation_result_found = true;

                // Store main result
                $min_vit_iron_details['iron_saturation_result_value'] = $resultData->RESULT_VALUE;
                $min_vit_iron_details['iron_saturation_uom'] = $resultData->UOM ? str_replace(["�", "ï¿½"], "μ", $resultData->UOM) : ' ';
                $min_vit_iron_details['iron_saturation_sample_method'] = $resultData->NEW_METHOD;

                if (($min_vit_iron_details['iron_saturation_result_value'] ?? null) === '' || ($min_vit_iron_details['iron_saturation_result_value'] ?? null) === null) {
                    $report_issues[] = "% OF IRON SATURATION TestResultDetails are empty";
                    $report_issues_email[] = "% OF IRON SATURATION TestResultDetails are empty" . FindTestgroupAddress('Iron Studies');
                }

                // NABL check
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '') {
                    $min_vit_iron_details['iron_saturation_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = "NABL mapping is missing for IST";
                    $report_issues_email[] = "NABL mapping is missing for IST" . FindTestgroupAddress('Iron Studies');
                }

                // Remarks
                $min_vit_iron_details['iron_saturation_test_remraks'] = !empty($resultData->TEST_REMARKS) ? "% of Iron Saturation - " . $resultData->TEST_REMARKS : '';

                // --- Parse BRInterval ---
                $brInterval = trim($resultData->BRInterval ?? '');
                $min_vit_iron_details['iron_saturation_BRInterval_result_value'] = $brInterval;

                if ($brInterval === '') {
                    $report_issues[] = "% OF IRON SATURATION BR Interval is empty";
                    $report_issues_email[] = "% OF IRON SATURATION BR Interval is empty" . FindTestgroupAddress('Iron Studies');
                }

                $intervals = explode("\n", $brInterval);
                $reference_data = [];
                $main_range = null;

                foreach ($intervals as $line) {
                    $line = trim($line);
                    if ($line === '') continue;

                    // Gender-specific case: "Male 20% - 50%" OR "Female 15% - 50%"
                    // Regex to handle variations like "Male:20% - 50%", "Male 20% - 50%", "Male20% - 50%"
                    if (preg_match('/^(Male|Female)\s*:?\s*(\d+\.?\d*)%?\s*-\s*(\d+\.?\d*)%?$/i', $line, $matches)) {
                        $gender = ucfirst(strtolower($matches[1]));
                        $low = (float)$matches[2];
                        $high = (float)$matches[3];

                        $reference_data[$gender] = [
                            'low' => $low,
                            'high' => $high,
                            'raw' => $line
                        ];
                    }
                    // Generic case: "20-45"
                    elseif (preg_match('/^(\d+\.?\d*)\s*%?\s*-\s*(\d+\.?\d*)%?$/', $line, $matches)) {
                        $low = (float)$matches[1];
                        $high = (float)$matches[2];
                        $reference_data['Range'] = [
                            'low' => $low,
                            'high' => $high,
                            'raw' => $line
                        ];
                        $main_range = $reference_data['Range'];
                    }
                }

                $min_vit_iron_details['iron_saturation_reference_ranges_value'] = $reference_data;
                // print_r($reference_data);



                // --- Default result values ---
                $min_vit_iron_details['iron_saturation_result_value_in_words'] = '';
                $min_vit_iron_details['iron_saturation_color_code'] = 'gray';
                $min_vit_iron_details['iron_saturation_thumb_up_icon'] = '';

                // --- Pick correct reference range based on gender ---
                $patientGender = strtolower($reportJsonData->PatientDetails[0]->GENDER == 'M' ? 'Male' : 'Female');
                $selected_range = null;
                // print_r($patientGender);


                if ($patientGender === 'male' && isset($reference_data['Male'])) {
                    $selected_range = $reference_data['Male'];
                } elseif ($patientGender === 'female' && isset($reference_data['Female'])) {
                    $selected_range = $reference_data['Female'];
                } elseif (isset($reference_data['Range'])) {
                    $selected_range = $reference_data['Range'];
                }
                // print_r($selected_range);
                // exit;


                $value = (float) preg_replace('/[^0-9.]/', '', $min_vit_iron_details['iron_saturation_result_value']);

                if ($selected_range) {
                    $low = $selected_range['low'];
                    $high = $selected_range['high'];

                    if ($value < $low) {
                        $min_vit_iron_details['iron_saturation_result_value_in_words'] = 'Low';
                        $min_vit_iron_details['iron_saturation_color_code'] = 'red';
                    } elseif ($value > $high) {
                        $min_vit_iron_details['iron_saturation_result_value_in_words'] = 'High';
                        $min_vit_iron_details['iron_saturation_color_code'] = 'red';
                    } else {
                        $min_vit_iron_details['iron_saturation_result_value_in_words'] = 'Normal';
                        $min_vit_iron_details['iron_saturation_color_code'] = 'green';
                    }

                    if ($min_vit_iron_details['iron_saturation_color_code'] === 'green') {
                        $min_vit_iron_details['iron_saturation_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png";
                        $min_vit_iron_details['iron_saturation_impact_on_health'] = '';
                        $min_vit_iron_details['iron_saturation_suggestion'] = '';
                    } else {
                        $min_vit_iron_details['iron_saturation_thumb_up_icon'] = "https://cdn.shop.lifecell.in/reports/wellness/images/{$min_vit_iron_details['iron_saturation_color_code']}-thumb.png";
                        $min_vit_iron_details['iron_saturation_impact_on_health'] = "";
                        $min_vit_iron_details['iron_saturation_suggestion'] = "";
                    }
                } else {
                    $report_issues[] = "Unable to parse BRInterval for IST";
                    $report_issues_email[] = "Unable to parse BRInterval for IST" . FindTestgroupAddress('Iron Studies');
                }
            }
        }

        if (!$iron_saturation_result_found) {
            $report_issues[] = "Test Group 'Iron Studies' or Test Code 'IST' not found";
            $report_issues_email[] = "Test Group 'Iron Studies' or Test Code 'IST' not found" . FindTestgroupAddress('Iron Studies');
        }
    }
    // Rheumatoid Factor (RA) Qualitative, Serum(Ayushman Vital Package)
    if ($PackageCode == 'AYN_016') {
        $ra_factror_result_value_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'R0004e' && $resultData->TEST_NAME == 'Rheumatoid Factor (RA) Qualitative, Serum') {
                $ra_factror_result_value_found = true;
                $min_vit_iron_details['ra_factror_result_value'] = $resultData->RESULT_VALUE;
                if (($min_vit_iron_details['ra_factror_result_value'] ?? null) === '' || ($min_vit_iron_details['ra_factror_result_value'] ?? null) === null) {
                    $report_issues[] = "Rheumatoid Factor (RA) Qualitative, Serum TestResultDetails are empty";
                    $report_issues_email[] = "Rheumatoid Factor (RA) Qualitative, Serum TestResultDetails are empty" . FindTestgroupAddress('R0004e');
                }
                $min_vit_iron_details['ra_factror_uom'] = $resultData->UOM ? utf8_decode($resultData->UOM) : '';
                $min_vit_iron_details['ra_factror_sample_method'] = $resultData->NEW_METHOD;
                if ($resultData->RESULT_VALUE == 'Negative') {
                    $min_vit_iron_details['ra_factror_result_value_in_words'] = 'Negative';
                    $min_vit_iron_details['ra_factror_color_code'] = "green";
                }
                if ($resultData->RESULT_VALUE == 'Positive') {
                    $min_vit_iron_details['ra_factror_result_value_in_words'] = 'Positive';
                    $min_vit_iron_details['ra_factror_color_code'] = "red";
                }
                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE == 'Positive') {
                    $min_vit_iron_details['ra_factrord_impact_on_health'] = "High levels of rheumatoid factor in the blood are most often related to autoimmune diseases, such as rheumatoid arthritis ,Sjogren syndrome and other autuimmune diseases";
                } else {
                    $min_vit_iron_details['ra_factrord_impact_on_health'] = '';
                }
                if ($resultData->RESULT_VALUE == 'Positive') {
                    $min_vit_iron_details['ra_factrord_suggestion'] = "High levels of rheumatoid factor in the blood are most often related to autoimmune diseases, such as rheumatoid arthritis ,Sjogren syndrome and other autuimmune diseases";
                } else {
                    $min_vit_iron_details['ra_factrord_suggestion'] = '';
                }
            }
        }
        if (!$ra_factror_result_value_found) {
            $report_issues[] = " Test Group 'R0004e' or Test Name 'Rheumatoid Factor (RA) Qualitative, Serum' not found";
            $report_issues_email[] = " Test Group 'R0004e' or Test Name 'Rheumatoid Factor (RA) Qualitative, Serum' not found" . FindTestgroupAddress('R0004e');
        }
    }
    // }
    // print_r($min_vit_iron_details);
    //exit;
    return $min_vit_iron_details;
}

// Comparison without eval
function comparevitamind($value, $operator, $threshold)
{
    switch ($operator) {
        case '<':
            return $value < $threshold;
        case '<=':
            return $value <= $threshold;
        case '>':
            return $value > $threshold;
        case '>=':
            return $value >= $threshold;
        default:
            return false;
    }
}

// Determine if value matches condition
function vitamindmatchesRange($value, $range)
{
    if (preg_match('/^(<=|>=|<|>)\s*(\d+(\.\d+)?)/', $range, $match)) {
        return comparevitamind($value, $match[1], (float)$match[2]);
    }

    if (preg_match('/^(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)/', $range, $match)) {
        return $value >= (float)$match[1] && $value <= (float)$match[3];
    }

    return false;
}


/**
 * Description: The get_min_vit_iron_Testgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for minerals, vitamins, and iron-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */

function get_min_vit_iron_Testgroupdetails($reportJsonData, &$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $min_vit_iron_NablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {


        if ($PackageCode == 'AYN_026') {

            if ($resultData->TEST_GROUP_CODE === 'V0004a') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004a";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004a" . FindTestgroupAddress('V0004a');
                }

                $min_vit_iron_NablAccredited['V0004a_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['V0004a_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
            if ($resultData->TEST_GROUP_CODE === 'V0004c') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004c";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004c" . FindTestgroupAddress('V0004c');
                }

                $min_vit_iron_NablAccredited['V0004c_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['V0004c_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

             if ($resultData->TEST_GROUP_CODE === 'Iron Studies') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Iron Studies";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Iron Studies" . FindTestgroupAddress('Iron Studies');
                }
                $min_vit_iron_NablAccredited['iron_studies_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['iron_studies_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
        } elseif ($PackageCode == 'AYN_025' || $PackageCode == 'AYN_027' || $PackageCode == 'AYN_028' || $PackageCode == 'AYN_031' || $PackageCode == 'AYN_030' || $PackageCode == 'AYN_029') {

            if ($PackageCode !== 'AYN_025') {
            if ($resultData->TEST_GROUP_CODE === 'V0004a') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004a";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004a" . FindTestgroupAddress('V0004a');
                }

                $min_vit_iron_NablAccredited['V0004a_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['V0004a_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($resultData->TEST_GROUP_CODE === 'V0004c') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004c";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code V0004c" . FindTestgroupAddress('V0004c');
                }

                $min_vit_iron_NablAccredited['V0004c_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['V0004c_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }
           }
            if ($PackageCode !== 'AYN_025' || $PackageCode !== 'AYN_026') {
                if ($resultData->TEST_GROUP_CODE === 'P0010b') {
                    if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                        $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code P0010b";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code P0010b" . FindTestgroupAddress('P0010b');
                    }
                    $min_vit_iron_NablAccredited['P0010b_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                    $min_vit_iron_NablAccredited['P0010b_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
                }
            }
            if ($resultData->TEST_GROUP_CODE === 'Iron Studies') {
                if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Iron Studies";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code Iron Studies" . FindTestgroupAddress('Iron Studies');
                }
                $min_vit_iron_NablAccredited['iron_studies_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $min_vit_iron_NablAccredited['iron_studies_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
            }

            if ($PackageCode == 'AYN_031') {
                if ($resultData->TEST_GROUP_CODE === 'T0002b') {
                    if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                        $report_issues[] = " Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code T0002b";
                        $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code T0002b" . FindTestgroupAddress('T0002b');
                    }
                    $min_vit_iron_NablAccredited['T0002b_min_vit_iron_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                    $min_vit_iron_NablAccredited['T0002b_min_vit_iron_remarks'] = $resultData->SERVICE_REMARKS ?: "";
                }
            }
        }
    }

    return $min_vit_iron_NablAccredited;
}
/**
 * Description : getCancerMakerDetails() function to get test result details for cancer markers.
 * 
 * This function retrieves test results related to cancer markers from the 
 * TestResultDetails array within the JSON response. It filters out relevant test groups 
 * and test codes that correspond to cancer diagnostics.
 * 
 * @param object $reportJsonData->TestResultDetails The JSON object containing test results.
 * @return array Returns an array of test details specific to cancer markers.
 */

function getCancerMakerDetails($reportJsonData, &$report_issues, &$report_issues_email)
{

    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $cancer_maker_details = [];
    // Prostate Specific Antigen Total Serum 
    if ($PackageCode == 'AYN_029') {
        $prostate_specific_antigen_total_serum_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if ($resultData->TEST_GROUP_CODE == 'P0018b' && explode('|', $resultData->TEST_CODE)[0] == 'PSA') {
                $prostate_specific_antigen_total_serum_result_found = true;
                $cancer_maker_details['prostate_specific_antigen_total_serum_result_value'] = $resultData->RESULT_VALUE;
                $cancer_maker_details['prostate_specific_antigen_total_serum_result_value_cleaned'] = (float) preg_replace('/[^0-9.]/', '', $cancer_maker_details['prostate_specific_antigen_total_serum_result_value']);
                if (($cancer_maker_details['prostate_specific_antigen_total_serum_result_value'] ?? null) === '' || ($cancer_maker_details['prostate_specific_antigen_total_serum_result_value'] ?? null) === null) {
                    $report_issues[] = " Prostate Specific Antigen Total Serum TestResultDetails are empty";
                    $report_issues_email[] = " Prostate Specific Antigen Total Serum TestResultDetails are empty" . FindTestgroupAddress('P0018b');
                }
                $cancer_maker_details['prostate_specific_antigen_total_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $cancer_maker_details['prostate_specific_antigen_total_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $cancer_maker_details['prostate_specific_antigen_total_serum_uom']);
                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code P0018b and test code PSA";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code P0018b and test code PSA" . FindTestgroupAddress('P0018b');
                }

                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_test_remraks'] = "Prostate Specific Antigen - " . $resultData->TEST_REMARKS;
                } else {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_test_remraks'] = '';
                }
                $cancer_maker_details['prostate_specific_antigen_total_serum_sample_method'] = $resultData->NEW_METHOD;
                $patient_age = $reportJsonData->PatientDetails[0]->age_yy ?? null;
                if (empty($patient_age)) {
                    $report_issues[] = " Patient Age Parameter is empty";
                    $report_issues_email[] = " Patient Age Parameter is empty" . FindTestgroupAddress('P0018b');
                }

                // Determine the threshold based on age
                if ($patient_age < 40) {
                    $threshold = 2.0;
                } elseif ($patient_age >= 40 && $patient_age <= 49) {
                    $threshold = 2.5;
                } elseif ($patient_age >= 50 && $patient_age <= 59) {
                    $threshold = 3.5;
                } elseif ($patient_age >= 60 && $patient_age <= 69) {
                    $threshold = 4.5;
                } elseif ($patient_age >= 70 && $patient_age <= 79) {
                    $threshold = 6.5;
                } else {
                    $threshold = 7.2;
                }

                // Compare RESULT_VALUE with the age-specific threshold
                if ($cancer_maker_details['prostate_specific_antigen_total_serum_result_value_cleaned'] < 0) {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_result_value_in_words'] = 'Low';
                    $cancer_maker_details['prostate_specific_antigen_total_serum_color_code'] = "red";
                } elseif ($cancer_maker_details['prostate_specific_antigen_total_serum_result_value_cleaned'] <= $threshold) {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_result_value_in_words'] = 'Normal';
                    $cancer_maker_details['prostate_specific_antigen_total_serum_color_code'] = "green";
                } else {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_result_value_in_words'] = 'High';
                    $cancer_maker_details['prostate_specific_antigen_total_serum_color_code'] = "red";
                }

                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >= $threshold) {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_impact_on_health'] = "";
                } else {
                    $cancer_maker_details['prostate_specific_antigen_total_serum_impact_on_health'] = '';
                }
            }
        }
        if (!$prostate_specific_antigen_total_serum_result_found) {
            $report_issues[] = " Test Group 'P0018b' or Test Code 'PSA' not found";
            $report_issues_email[] = " Test Group 'P0018b' or Test Code 'PSA' not found" . FindTestgroupAddress('P0018b');
        }
    }

    // Carcino Embryonic Antigen (CEA), Serum
    if ($PackageCode == 'AYN_030') {
        $carcinoembryonic_antigen_serum_result_found = false;
        foreach ($reportJsonData->TestResultDetails as $resultData) {
            if (
                $resultData->TEST_GROUP_CODE == 'C0012a' && explode('|', $resultData->TEST_CODE)[0] == 'CEAS'
            ) {
                $carcinoembryonic_antigen_serum_result_found = true;
                $cancer_maker_details['carcinoembryonic_antigen_serum_result_value'] = $resultData->RESULT_VALUE;
                if (($cancer_maker_details['carcinoembryonic_antigen_serum_result_value'] ?? null) === '' || ($cancer_maker_details['carcinoembryonic_antigen_serum_result_value'] ?? null) === null) {

                    $report_issues[] = " Carcino Embryonic Antigen (CEA), Serum TestResultDetails are empty";
                    $report_issues_email[] = " Carcino Embryonic Antigen (CEA), Serum TestResultDetails are empty" . FindTestgroupAddress('C0012a');
                }
                if (
                    !isset($resultData->LOW_VALUE) || $resultData->LOW_VALUE === "" ||
                    !isset($resultData->HIGH_VALUE) || $resultData->HIGH_VALUE === ""
                ) {
                    $report_issues[] = "  Carcino Embryonic Antigen (CEA) reference ranges are empty";
                    $report_issues_email[] = "  Carcino Embryonic Antigen (CEA) reference ranges are empty" . FindTestgroupAddress('C0012a');
                }
                if (!isset($resultData->BRInterval) || $resultData->BRInterval === "") {
                    $report_issues[] = "  Carcino Embryonic Antigen (CEA) BR Interval are empty";
                    $report_issues_email[] = "  Carcino Embryonic Antigen (CEA) BR Interval are empty" . FindTestgroupAddress('C0012a');
                }

                $cancer_maker_details['carcinoembryonic_antigen_serum_low_result_value'] = $resultData->LOW_VALUE;
                $cancer_maker_details['carcinoembryonic_antigen_serum_high_result_value'] = $resultData->HIGH_VALUE;
                $cancer_maker_details['carcinoembryonic_antigen_serum_uom'] = $resultData->UOM ? $resultData->UOM : ' ';
                $cancer_maker_details['carcinoembryonic_antigen_serum_uom'] = str_replace(["�", "ï¿½"], "μ", $cancer_maker_details['carcinoembryonic_antigen_serum_uom']);
                $cancer_maker_details['carcinoembryonic__BRInterval_result_value'] = $resultData->BRInterval;
                $brInterval = trim($cancer_maker_details['carcinoembryonic__BRInterval_result_value']);

                if (strpos($brInterval, ':') !== false) {
                    $intervals = explode("\n", str_replace('<br />', "\n", nl2br($brInterval)));
                    foreach ($intervals as $interval) {
                        if (strpos($interval, ':') !== false) {
                            [$label, $range] = explode(':', $interval, 2);
                            $label = strtolower(trim($label));
                            // Trim commas and whitespace from start and end of range
                            $range = trim($range, " \t\n\r\0\x0B,");
                            $range_map[$label] = $range;
                        }
                    }
                } else {
                    // Also clean single range
                    $clean_range = trim($brInterval, " \t\n\r\0\x0B,");
                    $range_map['Range'] = $clean_range;
                }

                $cancer_maker_details['carcinoembryonic_reference_ranges_value'] = $range_map;



                if (isset($resultData->Is_ProcessingBranch_NABL_ACCREDITED) && $resultData->Is_ProcessingBranch_NABL_ACCREDITED !== '' && !is_null($resultData->Is_ProcessingBranch_NABL_ACCREDITED)) {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_is_nabl_accredited'] = $resultData->Is_ProcessingBranch_NABL_ACCREDITED;
                } else {
                    $report_issues[] = " NABL mapping is either not found or is empty for the test group code C0012a and test code CEAS";
                    $report_issues_email[] = " NABL mapping is either not found or is empty for the test group code C0012a and test code CEAS" . FindTestgroupAddress('C0012a');
                }
                if ($resultData->TEST_REMARKS !== '' && !is_null($resultData->TEST_REMARKS)) {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_test_remraks'] = "Carcino Embryonic Antigen - " . $resultData->TEST_REMARKS;
                } else {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_test_remraks'] = '';
                }
                $cancer_maker_details['carcinoembryonic_antigen_serum_sample_method'] = $resultData->NEW_METHOD;

                // Compare RESULT_VALUE with the age-specific threshold
                if ($resultData->RESULT_VALUE < $cancer_maker_details['carcinoembryonic_antigen_serum_low_result_value']) {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_result_value_in_words'] = 'Low';
                    $cancer_maker_details['carcinoembryonic_antigen_serum_color_code'] = "red";
                } elseif ($resultData->RESULT_VALUE >= $cancer_maker_details['carcinoembryonic_antigen_serum_low_result_value'] && $resultData->RESULT_VALUE <= $cancer_maker_details['carcinoembryonic_antigen_serum_high_result_value']) {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_result_value_in_words'] = 'Normal';
                    $cancer_maker_details['carcinoembryonic_antigen_serum_color_code'] = "green";
                } else {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_result_value_in_words'] = 'High';
                    $cancer_maker_details['carcinoembryonic_antigen_serum_serum_color_code'] = "red";
                }


                // Incase of abnormal result vlaues - need to dispaly the recommendation as per the content shared  [at RS]
                if ($resultData->RESULT_VALUE >=  $cancer_maker_details['carcinoembryonic_antigen_serum_high_result_value']) {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_impact_on_health'] = "";
                } else {
                    $cancer_maker_details['carcinoembryonic_antigen_serum_impact_on_health'] = '';
                }
            }
        }
        if (!$carcinoembryonic_antigen_serum_result_found) {
            $report_issues[] = " Test Group 'C0012a' or Test Code 'CEAS' not found";
            $report_issues_email[] = " Test Group 'C0012a' or Test Code 'CEAS' not found" . FindTestgroupAddress('C0012a');
        }
    }

    return $cancer_maker_details;
}

/**
 * Description: The getCancerMakerTestgroupdetails() function retrieves the ProcessingBranchNABLLicenseNumber 
 * and service remarks for cancer marker-related tests based on test group codes.
 * 
 * This function extracts NABL accreditation codes and service remarks from the 
 * TestGroupDetails array in the provided JSON. It maps each test group code 
 * to its corresponding ProcessingBranchNABLLicenseNumber and service remarks.
 * 
 * @param object $reportJsonData->TestGroupDetails The JSON object containing test group details.
 * @return array Returns an associative array where each test group code is mapped to its 
 *               respective ProcessingBranchNABLLicenseNumber and service remarks.
 */


function getCancerMakerTestgroupdetails($reportJsonData, &$report_issues, &$report_issues_email)
{
    $PackageCode = getpackagecode($reportJsonData->TestGroupDetails);
    if (empty($PackageCode)) {
        $report_issues[] = "Package Code not found";
        $report_issues_email[] = "Package Code not found" . FindTestgroupAddress('');
    }
    $CancerMakerNablAccredited = [];

    foreach ($reportJsonData->TestGroupDetails as $resultData) {
        if ($PackageCode == 'AYN_029') {
            if ($resultData->TEST_GROUP_CODE === 'P0018b') {
            if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {

                    $report_issues[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code P0018b";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code P0018b" . FindTestgroupAddress('P0018b');
            }

                $CancerMakerNablAccredited['P0018b_cancer_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $CancerMakerNablAccredited['P0018b_cancer_remarks'] = $resultData->SERVICE_REMARKS ?: "";
        }
        } elseif ($PackageCode == 'AYN_030') {
            if ($resultData->TEST_GROUP_CODE === 'C0012a') {
            if (!isset($resultData->ProcessingBranchNABLLicenseNumber)) {
                    $report_issues[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code C0012a";
                    $report_issues_email[] = "Mapping field 'ProcessingBranchNABLLicenseNumber' not available for test group code C0012a" . FindTestgroupAddress('P0018b');
            }

                $CancerMakerNablAccredited['C0012a_cancer_nabl_code'] = $resultData->ProcessingBranchNABLLicenseNumber ?: "";
                $CancerMakerNablAccredited['C0012a_cancer_remarks'] = $resultData->SERVICE_REMARKS ?: "";
        }
    }
    }
    return $CancerMakerNablAccredited;
}




// function updateFailedReportLog($labId, $failedReason = "")
// {
//     $dbh = \Config\Database::connect();
//     $sql = "UPDATE wellness_report_data 
//             SET failed_reason = ?, email_sent = 0, is_failed = 1, is_generated = 2, isrsattachmentsent = 0, failed_reason_email_sent =0
//             WHERE lab_id = ?";
//     $dbh->query($sql, [$failedReason, $labId]);
// }

function base64ToWellnessImage($base64String, $flag = "", $width = "", $height = "30px")
{
    // Obtain the original content (usually binary data)

    $bin = base64_decode($base64String);
    // Load GD resource from binary data
    $im = imageCreateFromString($bin);
    // Make sure that the GD library was able to load the image
    // This is important, because you should not miss corrupted or unsupported images
    if (!$im) {
        die('Base64 value is not a valid image');
    }
    $rgb = array(247, 241, 235);
    $rgb = array(255 - $rgb[0], 255 - $rgb[1], 255 - $rgb[2]);
    // find a white in the image
    $white = imagecolorclosest($im, 255, 255, 255);
    imagecolorset($im, $white, 247, 241, 235);
    /* Negative values, don't edit */
    imagefilter($im, IMG_FILTER_NEGATE);
    imagefilter($im, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]);
    imagefilter($im, IMG_FILTER_NEGATE);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    ob_start();
    imagepng($im);
    $imgData = ob_get_contents();
    ob_end_clean();
    imagedestroy($im);

    if ($flag == "json") {
        return base64_encode($imgData);
    } else {
        return '<img class="" height="' . $height . '"  width="' . $width . '" src="data:image/png;base64,' .
            base64_encode($imgData) . '" alt="" />';
    }
}

/**@
    Description : getDoctorSignatureHpv will check for TestResultDetails from provided json
    Param : reportJsonData (mandatory)-whole json obj
    Output: doctor signature details in array
@**/

function getDoctorSignatureWellness($reportJsonData)
{
    $signature = [];
    foreach ($reportJsonData->TestGroupDetails as $doctorResult) {
        $signature = [];
        $doctor1signature =  $doctorResult->Doctor1DigitalSignature ?? "";
        if ($doctor1signature) {
            $doctor1name = $doctorResult->Doctor1Name ?? "";
            $doctor1name = preg_replace('/([a-z])([A-Z])/', '$1 $2', $doctor1name);
            $doctor1name = preg_replace('/(MD)([A-Z])/', '$1 $2', $doctor1name);
            $doctor1name = preg_replace('/\(/', ' (', $doctor1name);
            $signature['doctor1'] = trim($doctor1name);
            // $signature['doctor1'] = $doctorResult->Doctor1Name ?? "";
            $signature['doctor1qualification'] = $doctorResult->Doctor1Degree ?? "";
            $signature['doctor1signature'] = $doctor1signature;
        }

        $doctor2signature = $doctorResult->Doctor2DigitalSignature ?? "";
        if ($doctor2signature) {
            $doctor2name = $doctorResult->Doctor2Name ?? "";
            $doctor2name = preg_replace('/([a-z])([A-Z])/', '$1 $2', $doctor2name);
            $doctor2name = preg_replace('/(MD)([A-Z])/', '$1 $2', $doctor2name);
            $doctor2name = preg_replace('/\(/', ' (', $doctor2name);
            $signature['doctor2'] = trim($doctor2name);
            //$signature['doctor2'] = $doctorResult->Doctor2Name ?? "";
            $signature['doctor2qualification'] = $doctorResult->Doctor2Degree ?? "";
            $signature['doctor2signature'] = $doctor2signature;
        }

        $doctor3signature = $doctorResult->Doctor3DigitalSignature ?? "";
        if ($doctor3signature) {
            $doctor3name = $doctorResult->Doctor3Name ?? "";
            $doctor3name = preg_replace('/([a-z])([A-Z])/', '$1 $2', $doctor3name);
            $doctor3name = preg_replace('/(MD)([A-Z])/', '$1 $2', $doctor3name);
            $doctor3name = preg_replace('/\(/', ' (', $doctor3name);
            $signature['doctor3'] = trim($doctor3name);
            //$signature['doctor3'] = $doctorResult->Doctor3Name ?? "";
            $signature['doctor3qualification'] = $doctorResult->Doctor3Degree ?? "";
            $signature['doctor3signature'] = $doctor3signature;
        }

        $doctor4signature = $doctorResult->Doctor4DigitalSignature ?? "";
        if ($doctor4signature) {
            $doctor4name = $doctorResult->Doctor4Name ?? "";
            $doctor4name = preg_replace('/([a-z])([A-Z])/', '$1 $2', $doctor4name);
            $doctor4name = preg_replace('/(MD)([A-Z])/', '$1 $2', $doctor4name);
            $doctor4name = preg_replace('/\(/', ' (', $doctor4name);
            $signature['doctor4'] = trim($doctor4name);
            //$signature['doctor4'] = $doctorResult->Doctor4Name ?? "";
            $signature['doctor4qualification'] = $doctorResult->Doctor4Degree ?? "";
            $signature['doctor4signature'] = $doctor4signature;
        }

        $doctor5signature = $doctorResult->Doctor5DigitalSignature ?? "";
        if ($doctor5signature) {
            $doctor5name = $doctorResult->Doctor5Name ?? "";
            $doctor5name = preg_replace('/([a-z])([A-Z])/', '$1 $2', $doctor5name);
            $doctor5name = preg_replace('/(MD)([A-Z])/', '$1 $2', $doctor5name);
            $doctor5name = preg_replace('/\(/', ' (', $doctor5name);
            $signature['doctor5'] = trim($doctor5name);
            //$signature['doctor5'] = $doctorResult->Doctor5Name ?? "";
            $signature['doctor5qualification'] = $doctorResult->Doctor5Degree ?? "";
            $signature['doctor5signature'] = $doctor5signature;
        }
    }
    return $signature;
}

/**@
    Description : dateformat function to convert date format
    Param :
        datetime(mandatory) :date
        format(optional) :date format
    Output:formatted date
@**/

if (!function_exists('dateformat')) {
    function dateformat($datetime)
    {
        $dateTime = date_create($datetime);
        return date_format($dateTime, 'd-m-Y H:i');
    }
}

/**@
    Description : getBranchAddress will build branch address
    Param : reportJsonData (mandatory)-whole json obj
    Output:branch address in array
@**/

function getBranchAddress($branchaddress, $setaddressflag, $labId, $limsSlims)
{
    $branchAddress['companyname'] = "";
    $branchAddress['companyaddress']  = "";
    $branchAddress['setaddressflag'] = $setaddressflag;
    if (empty($limsSlims)) {
        $limsSlims = $labId[0] == 4 ? "lims" : "slims";
    }
    if (empty($setaddressflag) && $limsSlims == "lims") {
        $branchAddress['setaddressflag'] = "NO";
        if (empty($branchaddress)) {
            $branchaddress = "LifeCell International Pvt Ltd,
         No: 26, Vandalur-Kelambakkam Main Road, Keelakottaiyur, Chennai - 600127";
        }
    }
    if ($branchaddress) {
        $address = explode(",", $branchaddress);
        $branchAddress['companyname']  = $address[0] ?? "";
        unset($address[0]);
        $branchAddress['companyaddress'] = implode(",", $address);
    }
    return $branchAddress;
}

/**@
    Description : dateformat function to convert date format
    Param :
        $lab_id(mandatory)
    Output: Updates the major_high_risk and other_high_risk detected or Not detected value in the hpv_report_data table
@**/

function updatehpvFilter($labId, $updateFilter)
{
    $majorHighRisk = $updateFilter['major_high_risk'];
    $otherHighRisk = $updateFilter['other_high_risk'];
    $dbh = \Config\Database::connect();
    $dbh->query("update hpv_report_data set major_high_risk = '$majorHighRisk', other_high_risk = '$otherHighRisk'
    where lab_id = '" . $labId . "' ");
}

/**@
    Description : validateMutipleBRIntervals function to validate Brintervals
    Param :
      $intervals - Brintervals
      $testCode -  $resultData->TEST_CODE
      $labId - $reportJsonData->PatientDetails[0]->LAB_ID
      $range_map -    $range_map

      Output - if true :  $range_map
               else false: The BRinterval sequence is incorrect for " . $testCode
@**/

function validateMutipleBRIntervals(array $intervals, $testCode, $labId, &$range_map = [])
{
    $invalid_lines = [];

    foreach ($intervals as $interval) {
        $interval = trim($interval);

        if (strpos($interval, ':') !== false) {
            if (explode('|', $testCode)[0] == 'OHVD') {
                if (preg_match('/^[<>]?\d/', trim($interval))) {
                    // Format A: Range first
                    [$range, $label] = explode(':', $interval, 2);
                } else {
                    // Format B: Label first
                    [$label, $range] = explode(':', $interval, 2);
                }
            } else {
                [$label, $range] = explode(':', $interval);
            }
            $label = strtolower(trim($label));
            $range = trim($range);

            // Check for invalid characters in the range
            if (preg_match('/[^0-9<>=\s\.\-\,]/', $range)) {
                $invalid_lines[] = $interval;
            } else {
                // Try extracting label and range if label includes comparison
                if (preg_match('/^([^\d<>=]+)([<>=]\s*\d+)/', $label, $match)) {
                    $label = strtolower(trim($match[1]));
                    $range = trim($match[2]);
                }
                $range_map[$label] = $range;
            }
        } else {
            // Handle format without colon
            if (preg_match('/^([^\d<>=]+)([<>=]\s*\d+)/', $interval, $matches)) {
                $label = strtolower(trim($matches[1]));
                $range = trim($matches[2]);
                $range_map[$label] = $range;
            } else {
                $invalid_lines[] = $interval;
            }
        }
    }
    if (!empty($invalid_lines)) {
        $invalids = array_map('htmlspecialchars', $invalid_lines);
        $errorMessage = $labId . " - The BRinterval sequence is incorrect for " . $testCode;

        // updateFailedReportLog($labId, "The BRinterval sequence is incorrect for " . $testCode);
        // echo $errorMessage;
        // exit;
        $report_issues[] = "The BRinterval sequence is incorrect for " . $testCode;
        $report_issues_email[] = "The BRinterval sequence is incorrect for " . $testCode . FindTestgroupAddress('');
    }

    return true;
}

function getPackageCode($Testgroupdetails)
{
    $wellness_service_codes = [
        'AYN_016',
        'AYN_017',
        'AYN_018',
        'AYN_019',
        'AYN_020',
        'AYN_021',
        'AYN_022',
        'AYN_025',
        'AYN_026',
        'AYN_027',
        'AYN_028',
        'AYN_029',
        'AYN_030',
        'AYN_031'
    ];

    if (empty($Testgroupdetails) || !is_array($Testgroupdetails)) {
        // Optionally log error here
        return null;
    }

    foreach ($Testgroupdetails as $testGroup) {
        if (!empty($testGroup->PackageCode) && in_array($testGroup->PackageCode, $wellness_service_codes)) {
            return $testGroup->PackageCode;
        }
    }

    // No match found
    return null;
}

/**@
    Description : getMHQ function to fetch MHQ from json
    Param :
        $tests(mandatory)-TestResultDetails
    Output: MHQ data
@**/

function getMHQ($tests)
{

    $lab_id  = $tests[0]->LAB_ID;
    $dbh = \Config\Database::connect();
    $mhq_result = $dbh->query("select previous_pap,previous_hpv_dna,symptoms_reported from hpv_report_data 
    where lab_id = '" . $lab_id . "' ")->getResult();


    $data = [];
    foreach ($mhq_result as $mhq) {

        $data['previous_pap'] = !empty($mhq->previous_pap) ? explode('|', $mhq->previous_pap) : 'None';
        $data['previous_hpv_dna'] = !empty($mhq->previous_hpv_dna) ? explode('|', $mhq->previous_hpv_dna) : 'None';
        $data['symptoms_reported'] = !empty($mhq->symptoms_reported) ? explode('|', $mhq->symptoms_reported) : 'None';
    }

    return $data;
}
