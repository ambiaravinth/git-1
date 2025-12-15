<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo base_url('css/wellness.css') ?>">
    <!--<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>-->
    <title>Wellness Report</title>
    <style>
        .image-ressult {
            font-size: 22px !important;
        }

        .electric-g{
            font-size: 8px !important;
        }
    </style>
    <script>
        function number_pages() {
            // var vars = {};
            // var x = document.location.search.substring(1).split('&');
            // for (var i in x) {
            //     var z = x[i].split('=', 2);
            //     vars[z[0]] = decodeURIComponent(z[1]);
            // }
            // var x = ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection'];
            // for (var i in x) {
            //     var y = document.getElementsByClassName(x[i]);
            //     for (var j = 0; j < y.length; ++j) y[j].textContent = vars[x[i]];
            // }
            function getParameterByName(name) {
                var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
                return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
            }

            function substitute(name) {
                var value = getParameterByName(name);
                var elements = document.getElementsByClassName(name);
                for (var i = 0; elements && i < elements.length; i++) {
                    elements[i].textContent = value;
                }
            }
            ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection']
            .forEach(function(param) {
                substitute(param);
            });
        }
    </script>
</head>

<body onload="number_pages()">
    <?php
    // view('WellnessReports/wellness_header', $data);
    $reportData = $data;
    $patientDetails = $reportData['patientdetails'];
    $tgdrsig_details = $reportData['tgdrsig_details'];
    $pancreasResults = $reportData['pancreasresults'];
    $heartResults = $reportData['heartresults'];
    $thyroidResults = $reportData['thyroidresults'];
    $kidneyResults = $reportData['kidneyresults'];
    $liverResults = $reportData['liverresults'];
    $miniralVitaminIronResults = $reportData['miniralvitaminironresults'];
    $pancreasTestgroupdetails = $reportData['pancreasTestgroupdetails'];
    $heartTestgroupdetails = $reportData['heartTestgroupdetails'];
    $thyroidTestgroupdetails = $reportData['thyroidTestgroupdetails'];
    $kidneyTestgroupdetails = $reportData['kidneyTestgroupdetails'];
    $liverTestgroupdetails = $reportData['liverTestgroupdetails'];
    $urineTestgroupdetails = $reportData['urineTestgroupdetails'];
    $bloodTestgroupdetails = $reportData['bloodTestgroupdetails'];
    $min_vit_iron_Testgroupdetails = $reportData['min_vit_iron_Testgroupdetails'];
    $bloodResults = $reportData['bloodresults'];
    $urineResults = $reportData['urineresults'];
    $lab_id = $patientDetails['lab_id'];

    if (!$pancreasResults['glucose_fasting_status_found']) {

        if (($pancreasResults['hba1c_color_code'] == 'red') ||  ($pancreasResults['glucose_fasting_color_code'] == 'red')) {
            $pancreasResults['pancreas-summary'] = 'red-summary';
        } elseif (($pancreasResults['hba1c_color_code'] == 'orange') || ($pancreasResults['glucose_fasting_color_code'] == 'orange')) {
            $pancreasResults['pancreas-summary'] = 'orange-summary';
        } elseif (($pancreasResults['hba1c_color_code'] == 'green') || ($pancreasResults['glucose_fasting_color_code'] == 'green')) {
            $pancreasResults['pancreas-summary'] = 'green-summary';
        }
    } else {
        if (($pancreasResults['hba1c_color_code'] == 'red')) {
            $pancreasResults['pancreas-summary'] = 'red-summary';
        } elseif (($pancreasResults['hba1c_color_code'] == 'orange')) {
            $pancreasResults['pancreas-summary'] = 'orange-summary';
        } elseif (($pancreasResults['hba1c_color_code'] == 'green')) {
            $pancreasResults['pancreas-summary'] = 'green-summary';
        }
    }

    //Heart
    if($heartResults['lipoprotein_ldl_status_found']){
        if (($heartResults['total_cholesterol_color_code'] == 'red') || ($heartResults['triglycerides_color_code'] == 'red') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'red') || ($heartResults['lipoproteincholesterol_color_code'] == 'red') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'red') || ($heartResults['lipoprotein_ldl_color_code'] == 'red') ||
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'red') || ($heartResults['ldlorhdlratio_color_code'] == 'red') ||
        ($heartResults['nonhdlcholesterol_color_code'] == 'red') || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'red') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'red') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'red') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'red')
        ) {
            $heartResults['heart-summary'] = 'red-summary';
        } elseif (($heartResults['total_cholesterol_color_code'] == 'orange') || ($heartResults['triglycerides_color_code'] == 'orange') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'orange') || ($heartResults['lipoproteincholesterol_color_code'] == 'orange') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'orange') || ($heartResults['lipoprotein_ldl_color_code'] == 'orange') ||
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'orange') || ($heartResults['ldlorhdlratio_color_code'] == 'orange') ||
            ($heartResults['nonhdlcholesterol_color_code'] == 'orange') || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'orange') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'orange') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'orange') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'orange')
        ) {
            $heartResults['heart-summary'] = 'orange-summary';
        } elseif (($heartResults['total_cholesterol_color_code'] == 'green') || ($heartResults['triglycerides_color_code'] == 'green') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'green') || ($heartResults['lipoproteincholesterol_color_code'] == 'green') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'green') || ($heartResults['lipoprotein_ldl_color_code'] == 'green') ||
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'green') || ($heartResults['ldlorhdlratio_color_code'] == 'green') ||
            ($heartResults['nonhdlcholesterol_color_code'] == 'green') || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'green') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'green') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'green') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'green')
        ) {
            $heartResults['heart-summary'] = 'green-summary';
        }
    }else{
        if (($heartResults['total_cholesterol_color_code'] == 'red') || ($heartResults['triglycerides_color_code'] == 'red') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'red') || ($heartResults['lipoproteincholesterol_color_code'] == 'red') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'red') || 
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'red') || ($heartResults['ldlorhdlratio_color_code'] == 'red') ||
            ($heartResults['nonhdlcholesterol_color_code'] == 'red')  || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'red') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'red') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'red') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'red')
        ) {
            $heartResults['heart-summary'] = 'red-summary';
        } elseif (($heartResults['total_cholesterol_color_code'] == 'orange') || ($heartResults['triglycerides_color_code'] == 'orange') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'orange') || ($heartResults['lipoproteincholesterol_color_code'] == 'orange') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'orange') || 
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'orange') || ($heartResults['ldlorhdlratio_color_code'] == 'orange') ||
            ($heartResults['nonhdlcholesterol_color_code'] == 'orange') || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'orange') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'orange') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'orange') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'orange')
        ) {
            $heartResults['heart-summary'] = 'orange-summary';
        } elseif (($heartResults['total_cholesterol_color_code'] == 'green') || ($heartResults['triglycerides_color_code'] == 'green') ||
            ($heartResults['hdl_cholesterol_color_code'] == 'green') || ($heartResults['lipoproteincholesterol_color_code'] == 'green') ||
            ($heartResults['lipoproteincholesterol_color_code'] == 'green') ||
            ($heartResults['total_cholesterolhdlratio_color_code'] == 'green') || ($heartResults['ldlorhdlratio_color_code'] == 'green') ||
            ($heartResults['nonhdlcholesterol_color_code'] == 'green') || ($heartResults['high_sensitive_CRP_serum_color_code'] == 'green') ||
            ($heartResults['apolipoprotein_B_serum_color_code'] == 'green') || ($heartResults['apolipoprotein_A1_serum_color_code'] == 'green') ||
            ($heartResults['apolipoprotein_A1_B_serum_color_code'] == 'green')
        ) {
            $heartResults['heart-summary'] = 'green-summary';
        }
    }

    // thyroid
    if (($thyroidResults['thyronine_color_code'] == 'red') || ($thyroidResults['thyroxine_color_code'] == 'red') ||
        ($thyroidResults['tsh_color_code'] == 'red')
    ) {
        $thyroidResults['thyroid-summary'] = 'red-summary';
    } elseif (($thyroidResults['thyronine_color_code'] == 'orange') || ($thyroidResults['thyroxine_color_code'] == 'orange') ||
        ($thyroidResults['tsh_color_code'] == 'orange')
    ) {
        $thyroidResults['thyroid-summary'] = 'orange-summary';
    } elseif (($thyroidResults['thyronine_color_code'] == 'green') || ($thyroidResults['thyroxine_color_code'] == 'green') ||
        ($thyroidResults['tsh_color_code'] == 'green')
    ) {
        $thyroidResults['thyroid-summary'] = 'green-summary';
    }

    // KIDNEY
    if (($kidneyResults['urea_result_color_code'] == 'red') || ($kidneyResults['creatinine_color_code'] == 'red') ||
        ($kidneyResults['uricacid_color_code'] == 'red') || ($kidneyResults['calcium_color_code'] == 'red') ||
        ($kidneyResults['blood_urea_nitrogen_color_code'] == 'red') ||
        ($kidneyResults['creatinine_ratio_color_code'] == 'red') || ($kidneyResults['sodium_result_color_code'] == 'red') || ($kidneyResults['potassium_result_color_code'] == 'red') || ($kidneyResults['chloride_result_color_code'] == 'red') || ($kidneyResults['sodium_result_color_code'] == 'red') ||
        ($kidneyResults['potassium_result_color_code'] == 'red') || ($kidneyResults['chloride_result_color_code'] == 'red') ||
        ($kidneyResults['magnesium_color_code'] == 'red')  || ($kidneyResults['egfr_color_code'] == 'red')
    ) {
        $kidneyResults['kidney-summary'] = 'red-summary';
    } elseif (($kidneyResults['urea_result_color_code'] == 'orange') || ($kidneyResults['creatinine_color_code'] == 'orange') ||
        ($kidneyResults['uricacid_color_code'] == 'orange') || ($kidneyResults['calcium_color_code'] == 'orange') ||
        ($kidneyResults['blood_urea_nitrogen_color_code'] == 'orange') ||
        ($kidneyResults['creatinine_ratio_color_code'] == 'orange') || ($kidneyResults['sodium_result_color_code'] == 'orange') ||
        ($kidneyResults['potassium_result_color_code'] == 'orange') || ($kidneyResults['chloride_result_color_code'] == 'orange') ||
        ($kidneyResults['magnesium_color_code'] == 'orange') || ($kidneyResults['egfr_color_code'] == 'orange')
    ) {
        $kidneyResults['kidney-summary'] = 'orange-summary';
    } elseif (($kidneyResults['urea_result_color_code'] == 'green') || ($kidneyResults['creatinine_color_code'] == 'green') ||
        ($kidneyResults['uricacid_color_code'] == 'green') || ($kidneyResults['calcium_color_code'] == 'green') ||
        ($kidneyResults['blood_urea_nitrogen_color_code'] == 'green') ||
        ($kidneyResults['creatinine_ratio_color_code'] == 'green') || ($kidneyResults['sodium_result_color_code'] == 'green') || ($kidneyResults['potassium_result_color_code'] == 'green') || ($kidneyResults['chloride_result_color_code'] == 'green') || ($kidneyResults['sodium_result_color_code'] == 'green') ||
        ($kidneyResults['potassium_result_color_code'] == 'green') || ($kidneyResults['chloride_result_color_code'] == 'green') ||
        ($kidneyResults['magnesium_color_code'] == 'green') || ($kidneyResults['egfr_color_code'] == 'green')
    ) {
        $kidneyResults['kidney-summary'] = 'green-summary';
    }

    // LIVER
    if (($liverResults['ggt_result_found_view'] == 1)) {
        if (($liverResults['bilirubin_color_code'] == 'red') || ($liverResults['bilirubin_direct_color_code'] == 'red') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'red') || ($liverResults['sgpt_alt_color_code'] == 'red') ||
            ($liverResults['sgot_ast_color_code'] == 'red') || ($liverResults['alkaline_phosphatase_color_code'] == 'red') ||
            ($liverResults['ggt_color_code'] == 'red') || ($liverResults['total_protein_color_code'] == 'red') ||
            ($liverResults['globulin_color_code'] == 'red') || ($liverResults['albumin_color_code'] == 'red') ||
            ($liverResults['ag_ratio_color_code'] == 'red') || ($liverResults['amylase_color_code'] == 'red')
        ) {
            $liverResults['liver-summary'] = 'red-summary';
        } elseif (($liverResults['bilirubin_color_code'] == 'orange') || ($liverResults['bilirubin_direct_color_code'] == 'orange') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'orange') || ($liverResults['sgpt_alt_color_code'] == 'orange') ||
            ($liverResults['sgot_ast_color_code'] == 'orange') || ($liverResults['alkaline_phosphatase_color_code'] == 'orange') ||
            ($liverResults['ggt_color_code'] == 'orange') || ($liverResults['total_protein_color_code'] == 'orange') ||
            ($liverResults['globulin_color_code'] == 'orange') || ($liverResults['albumin_color_code'] == 'orange') ||
            ($liverResults['ag_ratio_color_code'] == 'orange') || ($liverResults['amylase_color_code'] == 'orange')
        ) {
            $liverResults['liver-summary'] = 'orange-summary';
        } elseif (($liverResults['bilirubin_color_code'] == 'green') || ($liverResults['bilirubin_direct_color_code'] == 'green') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'green') || ($liverResults['sgpt_alt_color_code'] == 'green') ||
            ($liverResults['sgot_ast_color_code'] == 'green') || ($liverResults['alkaline_phosphatase_color_code'] == 'green') ||
            ($liverResults['ggt_color_code'] == 'green') || ($liverResults['total_protein_color_code'] == 'green') ||
            ($liverResults['globulin_color_code'] == 'green') || ($liverResults['albumin_color_code'] == 'green') ||
            ($liverResults['ag_ratio_color_code'] == 'green') || ($liverResults['amylase_color_code'] == 'green')
        ) {
            $liverResults['liver-summary'] = 'green-summary';
        }
    } else {
        if (($liverResults['bilirubin_color_code'] == 'red') || ($liverResults['bilirubin_direct_color_code'] == 'red') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'red') || ($liverResults['sgpt_alt_color_code'] == 'red') ||
            ($liverResults['sgot_ast_color_code'] == 'red') || ($liverResults['alkaline_phosphatase_color_code'] == 'red') ||
            ($liverResults['total_protein_color_code'] == 'red') ||
            ($liverResults['globulin_color_code'] == 'red') || ($liverResults['albumin_color_code'] == 'red') ||
            ($liverResults['ag_ratio_color_code'] == 'red') || ($liverResults['amylase_color_code'] == 'red')
        ) {
            $liverResults['liver-summary'] = 'red-summary';
        } elseif (($liverResults['bilirubin_color_code'] == 'orange') || ($liverResults['bilirubin_direct_color_code'] == 'orange') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'orange') || ($liverResults['sgpt_alt_color_code'] == 'orange') ||
            ($liverResults['sgot_ast_color_code'] == 'orange') || ($liverResults['alkaline_phosphatase_color_code'] == 'orange') ||
            ($liverResults['total_protein_color_code'] == 'orange') ||
            ($liverResults['globulin_color_code'] == 'orange') || ($liverResults['albumin_color_code'] == 'orange') ||
            ($liverResults['ag_ratio_color_code'] == 'orange') || ($liverResults['amylase_color_code'] == 'orange')
        ) {
            $liverResults['liver-summary'] = 'orange-summary';
        } elseif (($liverResults['bilirubin_color_code'] == 'green') || ($liverResults['bilirubin_direct_color_code'] == 'green') ||
            ($liverResults['bilirubin_indirect_color_code'] == 'green') || ($liverResults['sgpt_alt_color_code'] == 'green') ||
            ($liverResults['sgot_ast_color_code'] == 'green') || ($liverResults['alkaline_phosphatase_color_code'] == 'green') ||
            ($liverResults['total_protein_color_code'] == 'green') ||
            ($liverResults['globulin_color_code'] == 'green') || ($liverResults['albumin_color_code'] == 'green') ||
            ($liverResults['ag_ratio_color_code'] == 'green') || ($liverResults['amylase_color_code'] == 'green')
        ) {
            $liverResults['liver-summary'] = 'green-summary';
        }
    }

    // URINE
    if (!$urineResults['urinestatus_found']) {
        if (($urineResults['urine_specific_gravity_color_code'] == 'red') || ($urineResults['urine_appearance_color_code'] == 'red') ||
            ($urineResults['urine_ph_color_code'] == 'red') || ($urineResults['urine_protein_color_code'] == 'red') ||
            ($urineResults['urine_glucose_color_code'] == 'red') || ($urineResults['urine_ketones_color_code'] == 'red') ||
            ($urineResults['urine_urobilinogen_color_code'] == 'red') || ($urineResults['urine_bilirubin_color_code'] == 'red') ||
            ($urineResults['urine_nitrite_color_code'] == 'red') || ($urineResults['urine_blood_color_code'] == 'red') || ($urineResults['bacteria_color_code'] == 'red') ||
            ($urineResults['urine_puscell_color_code'] == 'red') || ($urineResults['urine_epithelialcell_color_code'] == 'red') ||
            ($urineResults['urine_crystals_color_code'] == 'red') || ($urineResults['urine_yeast_color_code'] == 'red') ||
            ($urineResults['rbcs_color_code'] == 'red') || ($urineResults['casts_color_code'] == 'red')
        ) {
            $urineResults['urine-summary'] = 'red-summary';
        } elseif (($urineResults['urine_specific_gravity_color_code'] == 'orange') || ($urineResults['urine_appearance_color_code'] == 'orange') ||
            ($urineResults['urine_ph_color_code'] == 'orange') || ($urineResults['urine_protein_color_code'] == 'orange') ||
            ($urineResults['urine_glucose_color_code'] == 'orange') || ($urineResults['urine_ketones_color_code'] == 'orange') ||
            ($urineResults['urine_urobilinogen_color_code'] == 'orange') || ($urineResults['urine_bilirubin_color_code'] == 'orange') || ($urineResults['bacteria_color_code'] == 'orange') ||
            ($urineResults['urine_nitrite_color_code'] == 'orange') || ($urineResults['urine_blood_color_code'] == 'orange') ||
            ($urineResults['urine_puscell_color_code'] == 'orange') || ($urineResults['urine_epithelialcell_color_code'] == 'orange') ||

            ($urineResults['urine_crystals_color_code'] == 'orange') || ($urineResults['urine_yeast_color_code'] == 'orange') ||
            ($urineResults['rbcs_color_code'] == 'orange') || ($urineResults['casts_color_code'] == 'orange')
        ) {
            $urineResults['urine-summary'] = 'orange-summary';
        } elseif (($urineResults['urine_specific_gravity_color_code'] == 'green') || ($urineResults['urine_appearance_color_code'] == 'green') ||
            ($urineResults['urine_ph_color_code'] == 'green') || ($urineResults['urine_protein_color_code'] == 'green') ||
            ($urineResults['urine_glucose_color_code'] == 'green') || ($urineResults['urine_ketones_color_code'] == 'green') || ($urineResults['bacteria_color_code'] == 'green') ||
            ($urineResults['urine_urobilinogen_color_code'] == 'green') || ($urineResults['urine_bilirubin_color_code'] == 'green') ||
            ($urineResults['urine_nitrite_color_code'] == 'green') || ($urineResults['urine_blood_color_code'] == 'green') ||
            ($urineResults['urine_puscell_color_code'] == 'green') || ($urineResults['urine_epithelialcell_color_code'] == 'green') ||
            ($urineResults['urine_crystals_color_code'] == 'green') || ($urineResults['urine_yeast_color_code'] == 'green') ||
            ($urineResults['rbcs_color_code'] == 'green') || ($urineResults['casts_color_code'] == 'green')
        ) {
            $urineResults['urine-summary'] = 'green-summary';
        }
    } else {
        $urineResults['urine-summary'] = 'white-summary';
    }

    // BLOOD
    if (($bloodResults['rbccount_color_code'] == 'red') || ($bloodResults['hematocrit_pcv_color_code'] == 'red') ||
        ($bloodResults['hemoglobin_color_code'] == 'red') || ($bloodResults['corpuscular_volume_color_code'] == 'red') ||
        ($bloodResults['mchc_color_code'] == 'red') || ($bloodResults['red_cell_dist_cv_color_code'] == 'red') ||
        ($bloodResults['red_cell_dist_sd_color_code'] == 'red') || ($bloodResults['platelets_count_color_code'] == 'red') ||
        ($bloodResults['mpv_color_code'] == 'red') || ($bloodResults['pdw_color_code'] == 'red') ||
        ($bloodResults['platelet_crit_color_code'] == 'red') || //($bloodResults['platelet_cell_ratio_color_code'] == 'red') ||
        ($bloodResults['leukocytes_count_color_code'] == 'red') || ($bloodResults['neutrophils_count_color_code'] == 'red') ||
        ($bloodResults['monocyte_count_result_value'] == 'red') || ($bloodResults['lymphocyte_count_color_code'] == 'red') ||
        ($bloodResults['eosinophil_count_color_code'] == 'red') || ($bloodResults['basophil_count_color_code'] == 'red') ||
        ($bloodResults['neutrophils_color_code'] == 'red') || ($bloodResults['lymphocyte_color_code'] == 'red') ||
        ($bloodResults['monocytes_color_code'] == 'red') || ($bloodResults['eosinophils_color_code'] == 'red')  ||
        ($bloodResults['basophils_color_code'] == 'red') ||  ($bloodResults['lactate_dehydragenase_LDH_serum__color_code'] == 'red') || ($bloodResults['erythrocyte_sedimentation_color_code'] == 'red') || ($bloodResults['mch_color_code'] == 'red')
    ) {
        $bloodResults['blood-summary'] = 'red-summary';
    } elseif (($bloodResults['rbccount_color_code'] == 'orange') || ($bloodResults['hematocrit_pcv_color_code'] == 'orange') ||
        ($bloodResults['hemoglobin_color_code'] == 'orange') || ($bloodResults['corpuscular_volume_color_code'] == 'orange') ||
        ($bloodResults['mchc_color_code'] == 'orange') || ($bloodResults['red_cell_dist_cv_color_code'] == 'orange') ||
        ($bloodResults['red_cell_dist_sd_color_code'] == 'orange') || ($bloodResults['platelets_count_color_code'] == 'orange') ||
        ($bloodResults['mpv_color_code'] == 'orange') || ($bloodResults['pdw_color_code'] == 'orange') ||
        ($bloodResults['platelet_crit_color_code'] == 'orange') || //($bloodResults['platelet_cell_ratio_color_code'] == 'orange') ||
        ($bloodResults['leukocytes_count_color_code'] == 'orange') || ($bloodResults['neutrophils_count_color_code'] == 'orange') ||
        ($bloodResults['monocyte_count_result_value'] == 'orange') || ($bloodResults['lymphocyte_count_color_code'] == 'orange') ||
        ($bloodResults['eosinophil_count_color_code'] == 'orange') || ($bloodResults['basophil_count_color_code'] == 'orange') ||
        ($bloodResults['neutrophils_color_code'] == 'orange') || ($bloodResults['lymphocyte_color_code'] == 'orange') ||
        ($bloodResults['monocytes_color_code'] == 'orange') || ($bloodResults['eosinophils_color_code'] == 'orange')  ||
        ($bloodResults['basophils_color_code'] == 'orange') || ($bloodResults['lactate_dehydragenase_LDH_serum__color_code'] == 'orange') || ($bloodResults['erythrocyte_sedimentation_color_code'] == 'orange') || ($bloodResults['mch_color_code'] == 'orange')
    ) {
        $bloodResults['blood-summary'] = 'orange-summary';
    } elseif (($bloodResults['rbccount_color_code'] == 'green') || ($bloodResults['hematocrit_pcv_color_code'] == 'green') ||
        ($bloodResults['hemoglobin_color_code'] == 'green') || ($bloodResults['corpuscular_volume_color_code'] == 'green') ||
        ($bloodResults['mchc_color_code'] == 'green') || ($bloodResults['red_cell_dist_cv_color_code'] == 'green') ||
        ($bloodResults['red_cell_dist_sd_color_code'] == 'green') || ($bloodResults['platelets_count_color_code'] == 'green') ||
        ($bloodResults['mpv_color_code'] == 'green') || ($bloodResults['pdw_color_code'] == 'green') ||
        ($bloodResults['platelet_crit_color_code'] == 'green') || //($bloodResults['platelet_cell_ratio_color_code'] == 'green') ||
        ($bloodResults['leukocytes_count_color_code'] == 'green') || ($bloodResults['neutrophils_count_color_code'] == 'green') ||
        ($bloodResults['monocyte_count_result_value'] == 'green') || ($bloodResults['lymphocyte_count_color_code'] == 'green') ||
        ($bloodResults['eosinophil_count_color_code'] == 'green') || ($bloodResults['basophil_count_color_code'] == 'green') ||
        ($bloodResults['neutrophils_color_code'] == 'green') || ($bloodResults['lymphocyte_color_code'] == 'green') ||
        ($bloodResults['monocytes_color_code'] == 'green') || ($bloodResults['eosinophils_color_code'] == 'green')  ||
        ($bloodResults['basophils_color_code'] == 'green') || ($bloodResults['lactate_dehydragenase_LDH_serum__color_code'] == 'green') || ($bloodResults['erythrocyte_sedimentation_color_code'] == 'green') || ($bloodResults['mch_color_code'] == 'green')
    ) {
        $bloodResults['blood-summary'] = 'green-summary';
    }

    // Vitaminis, Minerals and iron

    if (($miniralVitaminIronResults['vitaminbtwelve_color_code'] == 'red') || ($miniralVitaminIronResults['vitamind_color_code'] == 'red') ||
        // ($miniralVitaminIronResults['folic_acid_color_code'] == 'red') || 
        ($miniralVitaminIronResults['phosphorus_color_code'] == 'red') ||
        ($miniralVitaminIronResults['iron_color_code'] == 'red') ||
        ($miniralVitaminIronResults['uibc_color_code'] == 'red') || ($miniralVitaminIronResults['tibc_color_code'] == 'red') || ($miniralVitaminIronResults['testosterone_color_code'] == 'red')  ||  ($miniralVitaminIronResults['iron_saturation_color_code'] =='red')
    ) {
        $miniralVitaminIronResults['vit-min-iron-summary'] = 'red-summary';
    } elseif (($miniralVitaminIronResults['vitaminbtwelve_color_code'] == 'orange') || ($miniralVitaminIronResults['vitamind_color_code'] == 'orange') ||
        //($miniralVitaminIronResults['folic_acid_color_code'] == 'orange') || 
        ($miniralVitaminIronResults['phosphorus_color_code'] == 'orange') ||
        ($miniralVitaminIronResults['iron_color_code'] == 'orange') ||
        ($miniralVitaminIronResults['uibc_color_code'] == 'orange') || ($miniralVitaminIronResults['tibc_color_code'] == 'orange') || ($miniralVitaminIronResults['testosterone_color_code'] == 'orange')  ||  ($miniralVitaminIronResults['iron_saturation_color_code'] =='orange')
    ) {
        $miniralVitaminIronResults['vit-min-iron-summary'] = 'orange-summary';
    } elseif (($miniralVitaminIronResults['vitaminbtwelve_color_code'] == 'green') || ($miniralVitaminIronResults['vitamind_color_code'] == 'green') ||
        // ($miniralVitaminIronResults['folic_acid_color_code'] == 'green') || 
        ($miniralVitaminIronResults['phosphorus_color_code'] == 'green') ||
        ($miniralVitaminIronResults['iron_color_code'] == 'green') ||
        ($miniralVitaminIronResults['uibc_color_code'] == 'green') || ($miniralVitaminIronResults['tibc_color_code'] == 'green') || ($miniralVitaminIronResults['testosterone_color_code'] == 'orange') ||  ($miniralVitaminIronResults['iron_saturation_color_code'] =='green')
    ) {
        $miniralVitaminIronResults['vit-min-iron-summary'] = 'green-summary';
    } else {
        $miniralVitaminIronResults['vit-min-iron-summary'] = '';
    }

    $collectionDate = $patientDetails['collection_date'];
    $reportingDate = $patientDetails['reporting_date'];
    $patientgender = $patientDetails['patient_gender'];
    $patientAge = $patientDetails['patient_age'];
    $processingBranchAddress = $patientDetails['processing_branch_address'];
    $patientName = ucwords(strtolower($patientDetails['patient_name']));
    $patientCrm = $patientDetails['crm'];
    $isCapAccredited = $patientDetails['is_cap_accredited'];
    $isNablAccredited = $patientDetails['is_nabl_accredited'];

    // if ($isCapAccredited) {
    //     $isCapImage = '<img src="https://cdn.shop.lifecell.in/reports/wellness/images/logo-cap.png" alt="" class="demo-dcn-img">';
    // } else {
    //     $isCapImage = '';
    // }
    // if ($isNablAccredited) {
    //     $isNablImage = '<img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" class="demo-dcn-img">';
    // } else {
    //     $isNablImage = '';
    // }

    $wellnessQrCode = $header['qrcode'];
    $header = ' <div class="display:flex; width:100%;">
                    <div style="width: 35%;margin-right: 5px;" class="header-sample">
                        <table class="border-collapse">
                            <tr>
                                <td class="header-report" style="font-size: 11px;">Sample Collected</td>
                                <td style="padding-left: 2px; font-size: 11px;">' . str_replace('T', ' ', $collectionDate) . '</td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 28%;margin-right: 5px;" class="header-sample">
                        <table class="border-collapse">
                            <tr>
                                <td class="header-report" style="font-size: 11px;">Reported</td>
                                <td style="padding-left: 2px; font-size: 11px;">' . str_replace('T', ' ', $reportingDate) . '</td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 19%;" class="header-sample">
                        <table class="border-collapse">
                            <tr>
                                <td class="header-report" style="font-size: 11px;">Basic Info</td> 
                                <td style="padding-left: 2px; font-size: 11px;">' . $patientgender . "/" . $patientAge . '</td>
                            </tr>
                        </table>
                    </div>   
   
                </div>';

    if (!empty($patientDetails['hospital_logo']['combained'])) {
        $co_brand_banner = '<table style="margin-top: 7px;">
                                <tr>
                                    <td style="width:70%;"></td>
                                    <td style="width:30%; padding-right: 10px;">
                                        <img style="width:100%;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="Logo Not Found" />
                                    </td>
                                </tr>
                            </table>';
        $co_brand_header1 = '<table style="padding-top: 0px; margin-top: -8px;">
                                <tr>
                                    <td style="width:70%;"></td>
                                    <td style="width:30%; padding-left: 2px;">
                                        <img style="width:100%;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="Logo Not Found" />
                                    </td>
                                </tr>
                            </table>';
        $co_brand_header2 = '<table style="padding-top: 0px; margin-top: -8px;">
                                <tr>
                                    <td style="width:70%; padding-left:4px;">
                                        ' . $header . '
                                        <img style="width:15%; margin-top: -2rem; float: right;" src=' . base_url($wellnessQrCode) . ' alt="">
                                    </td>
                                    <td style="width:30%; padding-left: 2px;">
                                        <img style="width:100%;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="Logo Not Found" />
                                    </td>
                                </tr>
                            </table>';
    } else {
        $co_brand_banner = '<table style="margin-top: 20px;">
                                <tr>
                                    <td style="width:85%;">
                                    </td>
                                    <td style="width:15%; padding-right: 10px;">
                                        <img style="width:100%; padding-right: 5px; margin-top:-0.5rem;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="" />
                                    </td>
                                </tr>
                            </table>';
        $co_brand_header1 = '<table style="padding-top: 0px; margin-top: 6px;">
                                <tr>
                                    <td style="width:85%; padding-left:4px;">
                                    </td>
                                    <td style="width:15%; padding-left: 4px;">
                                        <img style="width:100%; margin-top:-0.5rem;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="" />
                                    </td>
                                </tr>
                            </table>';
        $co_brand_header2 = '<table style="padding-top: 0px; margin-top: -6px;">
                                <tr>
                                    <td style="width:85%; padding-left:4px;">
                                        ' . $header . '
                                        <img style="width:15%; margin-top: -2rem; float: right;" src=' . base_url($wellnessQrCode) . ' alt="">
                                    </td>
                                    <td style="width:15%; padding-left: 4px;">
                                        <img style="width:100%; margin-top:-0.5rem;" src="' . $patientDetails['hospital_logo']['logo'] . '" alt="" />
                                    </td>
                                </tr>
                            </table>';
    }


    $footerLogo = base_url('images/wellness/footer-logo.png');
    $footerNablLogo = 'https://reports.lifecell.in/images/footer-logo-pns-new.png';
    /************** DR SIGNATURE START ***************/
    $signature_directory = FCPATH . "/images/drsignature/";
    $signature = $data['signature'];
    $Doctor1 = $signature['doctor1'] ?? "";
    $Doctor1Qualification = $signature['doctor1qualification'] ?? "";
    $doctor1signature = $signature['doctor1signature'] ?? "";

    if ($doctor1signature) {
        $doctor1signatureImg = base64ToWellnessImage($doctor1signature);
    } else {
        $doctor1signatureImg = '';
    }
    $Doctor2 = $signature['doctor2'] ?? "";
    $Doctor2Qualification = $signature['doctor2qualification'] ?? "";
    $doctor2signature = $signature['doctor2signature'] ?? "";
    if ($doctor2signature) {
        $doctor2signatureImg = base64ToWellnessImage($doctor2signature);
    } else {
        $doctor2signatureImg = '';
    }

    $Doctor3 = $signature['doctor3'] ?? "";
    $Doctor3Qualification = $signature['doctor3qualification'] ?? "";
    $doctor3signature = $signature['doctor3signature'] ?? "";
    if ($doctor3signature) {
        $doctor3signatureImg = base64ToWellnessImage($doctor3signature);
    } else {
        $doctor3signatureImg = '';
    }
    /************** DR SIGNATURE END *****************/

    $footerWithoutLogo = "<div class='report-page'>
<footer class='footer-cls' style='margin-top: 10px;'>
    <table style='width:100%; vertical-align:middle; color:#333; font-size:12px;'>
        <tr>
            <td style='text-align:left;width:15%; padding:0px 5px; border-right:1px solid #00977b;'>
                <div style='font-weight:600; padding-bottom:10px; color:#333; font-size:12px;'>Proccessed By:</div>
                <div><img src='" . $footerLogo . "' alt='' style='width: 120px;height:40px;'='processed-img'></div>
            </td>
            <td style='text-align:center; padding:0px 5px; width:25%; border-right:1px solid #00977b;'>";
    if ($patientDetails['is_cap_accredited']) {
        $footerWithoutLogo .= "<div style='display: inline-block; margin-left: 10px;'>
                    <img src='https://cdn.shop.lifecell.in/reports/wellness/images/logo-cap.png' alt='' class='demo-dcn-img'> 
                </div>";
    }
    $footerWithoutLogo .= "
                <div style='font-size: 11px; color:#a5247a; font-weight:600;'>" . ucwords(strtolower($patientDetails['patient_name'])) . "</div>
                                            <div style='font-size: 11px; color:#a5247a; font-weight:600;'> CRM: " . $patientDetails['crm'] . "</div>
                                            <div style='font-size:10px; color:#a5247a; font-weight:600;'>DCN: LC/HCH/STDF-RPT/ENG/1222/V001 </div>
            </td>
            
            <td style='width:100%; margin:0 auto; display:table;'>
                <div style='display:inline-block; width:100%;'>
                    <div style='text-align:center;display:inline-block; padding:0 3px; width:32%;'>
                        <div>" . $doctor1signatureImg . "</div>
                        <div style='color:#a5247a; font-weight:600; font-size: 11px;'>" . $Doctor1 . "</div>
                        <div style='font-size:10px; color:#333; font-weight:600;'>" . $Doctor1Qualification . "</div>
                    </div>
                    <div style='text-align:center; display:inline-block; padding:0 3px; width:32%; border-left:1px solid #00977b;'>
                        <div>" . $doctor2signatureImg . "</div>
                        <div style='color:#a5247a; font-weight:600; font-size: 11px;'>" . $Doctor2 . "</div>
                        <div style='font-size:10px; color:#333; font-weight:600;'>" . $Doctor2Qualification . "</div>
                    </div>
                    <div style='text-align:center; display:inline-block; padding:0 3px; width:32%; border-left:1px solid #00977b;'>
                        <div>" . $doctor3signatureImg . "</div>
                        <div style='color:#a5247a; font-weight:600; font-size: 11px;'>" . $Doctor3 . "</div>
                        <div style='font-size:10px; color:#333; font-weight:600;'>" . $Doctor3Qualification . "</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class='clear-both'>
        <p class='footer-adress' style='font-size:11px; padding:2px 5px 5px;'>Processed at: " . $patientDetails['processing_branch_address'] . "</p>
        <p class='electric-g'>This is a computer Generated medical diagnostic report that has been validated by Authorized medical practitioner/Doctor, the report does not need physical signature. (Initial report V1)</p>
        <img style='width:100%; display: block; height:auto;'src='https://cdn.shop.lifecell.in/reports/wellness/images/footer-divider.png' alt='' />
    </div>   
</footer>
</div>";



    // NEW Dynamic FOOTER...
    if (!function_exists('NewFooterPRLab')) {
        function NewFooterPRLab($testgroupcodes, $tgdrsig_details)
        {
            $footer_process_location = "";
            foreach ($testgroupcodes as $code) {
                $footer_process_locations[] = $tgdrsig_details[$code]['PROCESSING_BRANCH_ADDRESS'] ?? '';
            }
            $footer_process_locations = array_filter($footer_process_locations, function ($value) {
                return !empty($value);
            });
            $unique_locs = array_unique($footer_process_locations);
            if (empty($footer_process_locations)) {
                $footer_process_location = "Registered Office: No. 16, Vijayaraghava Lane, T. Nagar, Chennai , Tamil Nadu - 600017, CIN: U85196TN2004PTC053577";
                return $footer_process_location;
            }
            if (count($unique_locs) === 1) {
                foreach ($unique_locs as $loc) {
                    $footer_process_location = $loc;
                }
                return $footer_process_location;
            } else {
                $i = 1;
                $p_cnt = count($unique_locs);
                foreach ($unique_locs as $location) {
                    if ($i == 1) {
                        $footer_process_location .= "<b>(" . $i . ") </b>" . $location . ", ";
                    } else if ($i == $p_cnt) {
                        $footer_process_location .= "<br><b>(" . $i . ") </b>" . $location . ".";
                    } else {
                        $footer_process_location .= "<br><b>(" . $i . ") </b>" . $location . ", ";
                    }
                    $i++;
                }
                return $footer_process_location;
            }
        }
    }
    if (!function_exists('NewFooterDRSig')) {
        function NewFooterDRSig($testgroupcodes, $tgdrsig_details)
        {
            $doctors = [];
            for ($i = 1; $i < 4; $i++) {
                foreach ($testgroupcodes as $groupcode) {
                    $doctors[] = [
                        'signature' => $tgdrsig_details[$groupcode]['Doctor' . $i]['Doctor' . $i . 'DigitalSignature'] ?? '',
                        'name' => $tgdrsig_details[$groupcode]['Doctor' . $i]['Doctor' . $i . 'Name'] ?? '',
                        'qualification' => $tgdrsig_details[$groupcode]['Doctor' . $i]['Doctor' . $i . 'Degree'] ?? ''
                    ];
                }
            }
            $doctors = array_filter($doctors, function ($doc) {
                return !empty($doc['signature']) || !empty($doc['name']) || !empty($doc['qualification']);
            });
            $doctors = array_values(array_unique($doctors, SORT_REGULAR));
            if (count($doctors) > 3) {
                $doctors = array_slice($doctors, 0, 3);
            }
            return $doctors;
        }
    }
    if (!function_exists('NewFooter')) {
        function NewFooter($testgroupcodes, $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo)
        {
            // $doctors = NewFooterDRSig(['H0005','S0013a','L0005'],$tgdrsig_details);
            $processing_branch_address = NewFooterPRLab($testgroupcodes, $tgdrsig_details);
            $doctors = NewFooterDRSig($testgroupcodes, $tgdrsig_details);
            $availableDoctors = array_filter($doctors, function ($doc) {
                return !empty($doc['name']);
            });
            $doctorCount = count($availableDoctors);
            $i = 0;

            $line_sep = ($doctorCount == 0) ? "" : "border-right:1px solid #00977b;";

            $footerWithLogo = " <div class='report-page'>
                                <div class='footer-cls' style='margin-top: 10px;'>
                                    <table style='width:100%; vertical-align:middle; color:#333; font-size:12px; border-collapse:collapse;'>
                                        <tr>
                                            <td style='text-align:left;width:15%; padding:0px 5px; border-right:1px solid #00977b;'>
                                                <div style='font-weight:600; padding-bottom:10px; color:#333; font-size:12px;'>Processed By:</div>
                                                <div><img src='" . $footerLogo . "' alt='' style='width: 120px;height:40px;'></div>
                                            </td>
                                            <td style='text-align:center; padding:0px 5px; width:25%;" . $line_sep . "'>";
            if ($patientDetails['is_cap_accredited']) {
                $footerWithLogo .= "<div style='display: inline-block; margin-left: 10px;'><img src='https://cdn.shop.lifecell.in/reports/wellness/images/logo-cap.png' alt='' class='demo-dcn-img'> </div>";
            }
            $footerWithLogo .= "                    <!-- <div><img src='" . $footerNablLogo . "' alt='' style='width: auto;height:45px;'='processed-img'></div> -->
                                                <!-- <div style='color:#000; line-height:10px; font-size: 9px;'>" . $patientDetails['nabl_code'] . "</div> -->
                                                <!-- <div style='color:#000; line-height:20px; font-size: 12px;'>(Processed at NABL Lab)</div> -->
                                                <div style='font-size: 11px; color:#a5247a; font-weight:600;'>" . ucwords(strtolower($patientDetails['patient_name'])) . "</div>
                                            <div style='font-size: 11px; color:#a5247a; font-weight:600;'> CRM: " . $patientDetails['crm'] . "</div>
                                            <div style='font-size:10px; color:#a5247a; font-weight:600;'>DCN: LC/HCH/STDF-RPT/ENG/1222/V001 </div>
                                            </td>
                                            <td style='width:60%; padding:0px;'>
                                                <table style='width:100%; border-collapse:collapse; text-align:center;'>
                                                    <tr>";
            foreach ($availableDoctors as $doc) {
                $borderStyle = ($i < $doctorCount - 1) ? "border-right:1px solid #00977b;" : "";
                $tdAlign = ($doctorCount === 1) ? "left" : "center";
                $wrapperStyle = ($doctorCount === 1) ? "display:inline-block; text-align:center;" : "text-align:center;";
                $footerWithLogo .= "                            <td style='width:" . (100 / $doctorCount) . "%; padding:10px; $borderStyle; text-align:$tdAlign;'>
                                                            <div style='$wrapperStyle'>
                                                                <div>" . base64ToWellnessImage($doc['signature']) . "</div>
                                                                <div style='color:#a5247a; font-weight:600; font-size: 11px;'>" . $doc['name'] . "</div>
                                                                <div style='font-size:10px; color:#333; font-weight:600;'>" . $doc['qualification'] . "</div>
                                                            </div>
                                                        </td>";
                $i++;
            }
            $footerWithLogo .= "                       </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class='clear-both' style='margin-top:10px;'>
                                        <p class='footer-adress' style='font-size:8px; padding:2px 5px 5px;'> Processed at: " . $processing_branch_address . "</p>
                                        <p class='electric-g'>This is a computer Generated medical diagnostic report that has been validated by Authorized medical practitioner/Doctor, the report does not need physical signature. (" . $patientDetails['versionText'] . " V" . $patientDetails['reportversion'] . ")</p>
                                        <img style='width:100%; display: block; height:auto;' src='https://cdn.shop.lifecell.in/reports/wellness/images/footer-divider.png' alt='' />
                                    </div>
                                </div>
                            </div>";

            return $footerWithLogo;
        }
    }




    $footerWithLogo = "<div class='report-page'>
<div class='footer-cls' style='margin-top: 10px;'>
    <table style='width:100%; vertical-align:middle; color:#333; font-size:12px; border-collapse:collapse;'>
        <tr>
            <td style='text-align:left;width:15%; padding:0px 5px; border-right:1px solid #00977b;'>
                <div style='font-weight:600; padding-bottom:10px; color:#333; font-size:12px;'>Processed By:</div>
                <div><img src='" . $footerLogo . "' alt='' style='width: 120px;height:40px;'></div>
            </td>
            <td style='text-align:center; padding:0px 5px; width:25%;'>";
    if ($patientDetails['is_cap_accredited']) {
        $footerWithLogo .= "<div style='display: inline-block; margin-left: 10px;'>
                    <img src='https://cdn.shop.lifecell.in/reports/wellness/images/logo-cap.png' alt='' class='demo-dcn-img'> 
                </div>";
    }
    $footerWithLogo .= "
                   <!-- <div><img src='" . $footerNablLogo . "' alt='' style='width: auto;height:45px;'='processed-img'></div> -->
                <!-- <div style='color:#000; line-height:10px; font-size: 9px;'>" . $patientDetails['nabl_code'] . "</div> -->
                <!-- <div style='color:#000; line-height:20px; font-size: 12px;'>(Processed at NABL Lab)</div> -->
                <div style='font-size: 11px; color:#a5247a; font-weight:600;'>" . ucwords(strtolower($patientDetails['patient_name'])) . "</div>
                                            <div style='font-size: 11px; color:#a5247a; font-weight:600;'> CRM: " . $patientDetails['crm'] . "</div>
                                            <div style='font-size:10px; color:#a5247a; font-weight:600;'>DCN: LC/HCH/STDF-RPT/ENG/1222/V001 </div>
            </td>
            
            <td style='width:60%; padding:0px;'>
                <table style='width:100%; border-collapse:collapse; text-align:center;'>
                    <tr>";

    // $doctors = [
    //     ['signature' => $doctor1signatureImg, 'name' => $Doctor1, 'qualification' => $Doctor1Qualification],
    //     ['signature' => $doctor2signatureImg, 'name' => $Doctor2, 'qualification' => $Doctor2Qualification],
    //     ['signature' => $doctor3signatureImg, 'name' => $Doctor3, 'qualification' => $Doctor3Qualification]
    // ];
    // $availableDoctors = array_filter($doctors, function ($doc) {
    //     return !empty($doc['name']);
    // });
    // $doctorCount = count($availableDoctors);
    // $i = 0;
    // foreach ($availableDoctors as $doc) {
    //     $borderStyle = ($i < $doctorCount - 1) ? "border-right:1px solid #00977b;" : "";
    //     $tdAlign = ($doctorCount === 1) ? "left" : "center";
    //     $wrapperStyle = ($doctorCount === 1)
    //         ? "display:inline-block; text-align:center;"
    //         : "text-align:center;";
    //     $footerWithLogo .= "
    //         <td style='width:" . (100 / $doctorCount) . "%; padding:10px; $borderStyle; text-align:$tdAlign;'>
    //             <div style='$wrapperStyle'>
    //                 <div>" . $doc['signature'] . "</div>
    //                 <div style='color:#a5247a; font-weight:600; font-size: 11px;'>" . $doc['name'] . "</div>
    //                 <div style='font-size:10px; color:#333; font-weight:600;'>" . $doc['qualification'] . "</div>
    //             </div>
    //         </td>";
    //     $i++;
    // }

    $footerWithLogo .= "</tr>
                </table>
            </td>
        </tr>
    </table>
    <div class='clear-both' style='margin-top:10px;'>
        <p class='footer-adress' style='font-size:8px; padding:2px 5px 5px;'>Registered Office: No. 16, Vijayaraghava Lane, T. Nagar, Chennai , Tamil Nadu - 600017, CIN: U85196TN2004PTC053577 </p>
        <p class='electric-g'>This is a computer Generated medical diagnostic report that has been validated by Authorized medical practitioner/Doctor, the report does not need physical signature. (". $patientDetails['versionText'] . " V" . $patientDetails['reportversion'] . ")</p>
        <img style='width:100%; display: block; height:auto;' src='https://cdn.shop.lifecell.in/reports/wellness/images/footer-divider.png' alt='' />
    </div>
</div>
</div>";

    ?>

    <div class="body-cl">
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;">
                <div style="width:100%; position: absolute;">
                    <?php echo $co_brand_banner; ?>
                </div>
                <div>
                    <!-- <img style="width:100%;" src="https://cdn.shop.lifecell.in/reports/wellness/images/wellness-report-banner.jpg" alt="" /> -->
                    <img style="width:100%;" src="<?= base_url('images/wellness/wellness-report-banner-new.png') ?>" alt="" />
                </div>
                <div style="padding-top: 20px;">
                    <div style="text-align: center;font-weight: bold;font-size: 22px;">
                        <td style="color: #333;font-size: 16px; font-weight:600; ">Tax Saver (M)</td>
                    </div>
                    <div style="width: 50%; padding-bottom:5%;" class="float-left">
                        <table>
                            <tr>
                                <td style="color: #333;font-size: 16px; font-weight:600;">Client Code : <?= ucwords(strtolower($patientDetails['crm'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:32px;"><?= $patientDetails['salutation']; ?> <?= ucwords(strtolower($patientDetails['patient_name'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px;"><?= $patientDetails['patient_gender']; ?>, <?= $patientDetails['patient_age']; ?> years</td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 50%;" class="float-left">
                        <table style="text-align:left; margin-right:0; width:65%; font-weight:700;" class="margin-auto">
                            <tr>
                                <td class="f-14 w-50">Lab ID</td>
                                <td>: </td>
                                <td class="f-14" style="text-align: end;   width: 50%;"><?= $patientDetails['lab_id']; ?></td>
                            </tr>
                            <tr>
                                <td class="f-14 w-50">Registration Date</td>
                                <td>: </td>
                                <td class="f-14" style="text-align: end;width: 50%;"><?= $patientDetails['receipt_date']; ?></td>
                            </tr>
                            <tr>
                                <td class="f-14 w-50">Reported On</td>
                                <td>: </td>
                                <td class="f-14" style="text-align: end;width: 50%;"><?= $patientDetails['reporting_date']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                    <div>
                        <?php echo $footerWithLogo; ?>
                    </div>
                    <?php
                    $Total_pg_no =  ($urineResults['urinestatus_found'] == 1) ? 26 : 28;
                    $c_page = 1;
                    ?>
                    <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
                </footer>
            </div>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top: 20px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header1; ?>
                </div>
                <div class="personal-health">
                    <p>Test Result and Personal Health Report</p>
                </div>
                <div style="width:31%; padding-left:5px;" class="data-report-health">
                    <table>
                        <tr>
                            <td>NAME</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['salutation']; ?> <?= $patientDetails['patient_name']; ?></td>
                        </tr>
                        <tr>
                            <td>DOB</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['birth_date']; ?></td>
                        </tr>
                        <tr>
                            <td>AGE</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['patient_age']; ?> Years</td>
                        </tr>
                        <tr>
                            <td>CRM</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['crm']; ?></td>
                        </tr>
                    </table>
                </div>
                <div style="width:31%; padding-left:5px; border-left:2px solid #ccc;" class="data-report-health">
                    <table>
                        <tr>
                            <td>Collected</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['collection_date']; ?></td>
                        </tr>
                        <tr>
                            <td>Received</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['receipt_date']; ?></td>
                        </tr>
                        <tr>
                            <td>Reported</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['reporting_date']; ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td>Final</td>
                        </tr>
                        <tr>
                            <td>Ref By</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['refered_by']; ?></td>
                        </tr>
                    </table>
                </div>
                <div style="width:34%; padding-left:5px; margin-bottom:5px; border-left:2px solid #ccc;" class="data-report-health">
                    <table>
                        <tr>
                            <td>Lab ID</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['lab_id']; ?></td>
                        </tr>
                        <tr>
                            <td>Sample Quality</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td>Adequate</td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= $patientDetails['location']; ?></td>
                        </tr>
                        <tr>
                            <td>Client</td>
                            <td style="width:30px; text-align:center;">: </td>
                            <td><?= ucwords(strtolower($patientDetails['hospital_name'])); ?></td>
                        </tr>
                    </table>
                </div>
                <div style="text-align:center;">
                    <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-personal-health-banner.png" alt="" style="padding-top: 20px;" />
                </div>
                <div class="text-c">
                    <h2 style="color: #00977b; font-weight: lighter;font-size: 60px;">Personal Health</h2>
                    <p><span style="background:#b5d9e2; color:#606060; padding:2px 7px; font-weight:600;">Analytics Report</span></p>
                </div>
                <table>
                    <tr>
                        <td style="text-align: left; display: inline-block;"><img style="width: 40px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/personal-health-icon.png" alt="" /></td>
                        <td style="display: inline-block; font-size: 18px;padding-left: 10px; color:#606060; width:80%; font-weight:600;">What to expect from this report?</td>
                    </tr>
                </table>
                <div style="background-color: #e5f4f2;padding: 20px 50px;">
                    <p style="line-height: 24px; color: #a5247a;">
                        <span><b>The LifeCell Wellness Insights Report</b></span>
                        gives you a quick overview of your overall health status. It summarises key findings from your lab results and lifestyle-related questions, highlighting areas that need attention.
                    </p>
                </div>
                <div>
                    <table style="padding-left:50px;">
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-bullets.png" alt="" class="health-jou"></td>
                            <td class="health-font"><span class="health-span">Health Journey
                                    Charts :</span> The Interactive Charts visually track your health parameters over
                                time. They help you see how things have changed within your body which helps you keep
                                accurate track of your health. </td>
                        </tr>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-bullets.png" alt="" class="health-jou"></td>
                            <td class="health-font"><span class="health-span">Test Insights
                                    :</span> Using advanced technology and strict quality checks, this part dives deep into
                                your test results. It explains each test you've done, sets ideal benchmarks, and points out
                                areas that need immediate attention </td>
                        </tr>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-bullets.png" alt="" class="health-jou"></td>
                            <td class="health-font"><span class="health-span">Personalised
                                    Recommendations :</span> Get tailored advice to improve your nutrition and lifestyle
                                choices. From managing your BMI to suggesting proactive tests and guiding you on future
                                consultations, these suggestions </td>
                        </tr>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-bullets.png" alt="" class="health-jou"> </td>
                            <td class="health-font"><span class="health-span">Preventive Testing
                                    Guide :</span> This section is a quick guide to essential tests based on your age group.
                                Find out which tests are recommended for you and how often you should schedule them to stay
                                proactive about your health. </td>
                        </tr>
                    </table>
                </div>
                <table class="d-block">
                    <tr>
                        <td style="padding-right: 10px; width: auto;"> <img style="width: 40px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/cyd-icon.png" alt="" /></td>
                        <td style="font-size: 18px;padding-left:10px; color:#00977b; width:100%; font-weight:600;">Always consult your doctor</td>
                    </tr>
                </table>
            </div>
            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php echo $footerWithLogo; ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>

        <!-- page 3 -->
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>

                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <div style="padding-bottom:40px; padding-left: 5px;">
                    <img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/health-report-icon.png" alt="" />
                    <p style="font-size: 46px;font-weight: lighter;color: #00977b;">Health Report</p>
                    <p> <span style="color:#606060; background:#b5d9e2; padding:2px 7px; font-weight:600;">Walk Through</span></p>
                </div>
                <table style="width:30%; margin-bottom:14%;" class="float-left">
                    <tr>
                        <td><img style="width: 100%;" src="https://cdn.shop.lifecell.in/reports/wellness/images/health-report-banner.png" alt="" /></td>
                    </tr>
                </table>
                <table style="width: 65%; margin-top:100px; margin-left:25px;" class="float-left border-collapse">
                    <tr>
                        <td class="topic-summary"></td>
                        <td class="topic-summary">TOPICS</td>
                        <td class="topic-summary"> PAGE NO.</td>
                    </tr>
                    <tr>
                        <td class="healthy-summary"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/h-report-icon.png" alt="" /></td>
                        <td class="healthy-summary">Health Summary</td>
                        <td class="healthy-summary">4</td>
                    </tr>
                    <tr>
                        <td class="imp-para"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/h-report-icon.png" alt="" /></td>
                        <td class="imp-para">Important Parameters</td>
                        <td class="imp-para">5</td>
                    </tr>
                    <tr>
                        <td class="imp-para"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/h-report-icon.png" alt="" /></td>
                        <td class="imp-para">Health Guidance</td>
                        <td class="imp-para"><?= (!$urineResults['urinestatus_found']) ? '25' : '23' ?></td>
                    </tr>
                    <tr>
                        <td class="imp-para"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/h-report-icon.png" alt="" /></td>
                        <td class="imp-para">Suggestions for Preventive Tests</td>
                        <td class="imp-para"><?= (!$urineResults['urinestatus_found']) ? '27' : '25' ?></td>
                    </tr>
                </table>
            </div>
            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php echo $footerWithLogo; ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <!-- page 4 -->
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always; padding-top: 50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0" style="padding-bottom: 50px;">
                    <tr class="title-block">
                        <td style="padding-left: 20px; width: 95%;">
                            <div>
                                <p>Your Health Picture</p>
                                <p style="color: #606060; padding-top: 2px;">Health Summary</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="text-align: center; width:50%;" class="float-left">
                    <!-- <img src="https://cdn.shop.lifecell.in/reports/wellness/images/health-picture.png" alt="" style="padding-bottom: 20px; width: 40%;"> -->
                    <img src="https://cdn.shop.lifecell.in/reports/wellness/images/health-picture.png" alt="" style="padding-bottom: 20px; width: 60%;">

                </div>
                <table style="width: 45%; padding-top: 50px;" class="float-left">
                    <tr>
                        <td class="<?= $pancreasResults['pancreas-summary']; ?> d-block diabetes"> </td>
                        <td class="pancreas-col">PANCREAS (DIABETES)</td>
                    </tr>
                    <tr>
                        <td class="<?= $heartResults['heart-summary']; ?> d-block heart"> </td>
                        <td class="pancreas-col">HEART
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $thyroidResults['thyroid-summary']; ?> d-block thyroid"> </td>
                        <td class="pancreas-col">THYROID</td>
                    </tr>
                    <tr>
                        <td class="<?= $kidneyResults['kidney-summary']; ?> d-block kidney"> </td>
                        <td class="pancreas-col">KIDNEY</td>
                    </tr>
                    <tr>
                        <td class="<?= $liverResults['liver-summary']; ?> d-block liver"> </td>
                        <td class="pancreas-col">LIVER</td>
                    </tr>
                    <tr>
                        <td class="<?= $bloodResults['blood-summary']; ?> d-block blood"> </td>
                        <td class="pancreas-col">BLOOD</td>
                    </tr>
                    <tr>
                        <td class="<?= $miniralVitaminIronResults['vit-min-iron-summary']; ?> d-block vitamins"> </td>
                        <td class="pancreas-col">VITAMINS,MINERALS,IRON & HORMONE</td>
                    </tr>
                    <?php if (!$urineResults['urinestatus_found']) { ?>
                        <tr>
                            <td class="<?= $urineResults['urine-summary']; ?> d-block urine"> </td>
                            <td class="pancreas-col">URINE</td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="footer-colors clear-both w-100" style="margin-top: 220px;background: #e5f4f2; border-radius: 0;">
                    <table style="padding-bottom: 10px;width: 60%;" class="margin-auto">
                        <tr>
                            <td class="normal" style="padding: 5px;border-radius: 5px;"></td>
                            <td class="normal-signs">Normal</td>
                            <td class="abnormal" style="    padding: 5px;border-radius: 5px;"></td>
                            <td class="normal-signs">Concern *</td>
                            <td class="v-abnormal" style="padding: 5px;border-radius: 5px;"></td>
                            <td class="normal-signs">Critical *</td>
                        </tr>
                    </table>
                    <table style="padding:0px;">
                        <tr>
                            <td style="font-size:12px;"> <em>* Please Consult Your Doctor</em> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php echo $footerWithLogo; ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <tr class="title-block">
                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/important-parameters-icon.png" alt="" style="width: 100%; padding-top: 10px;"></td>
                        <td style="padding-left: 20px; width: 95%;">
                            <div>
                                <p>Important Parameters</p>
                                <p style="color: #606060; padding-top: 2px;">At A Glance</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- pancreas started -->
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:6%;">
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/pancreas-icon.png" alt="" style="width: 70%;">

                        </td>
                        <td> <span class="result-title <?= $pancreasResults['pancreas-summary']; ?>">Pancreas (Diabetes)</span></td>
                    </tr>
                </table>
                <?php if (!$pancreasResults['glucose_fasting_status_found']) : ?>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $pancreasResults['glucose_fasting_color_code']; ?>" style="  font-size: 34px;">
                                            <?php echo (($pancreasResults['glucose_fasting_result_value'] != '') ? $pancreasResults['glucose_fasting_result_value'] : '') ?></span> <?php echo htmlspecialchars($pancreasResults['glucose_fasting_uom']); ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <td><img src="<?= $pancreasResults['glucose_fasting_thumb_up_icon'] ?>" /></td>
                                            <td class="<?= $pancreasResults['glucose_fasting_color_code']; ?> image-ressult">
                                                <?= ($pancreasResults['glucose_fasting_result_value_in_words'] != '') ? $pancreasResults['glucose_fasting_result_value_in_words'] : '' ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <?php
                                        foreach ($pancreasResults['glucose_fasting_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "</tr>";
                                        }
                                        ?>

                                    </table>
                                </div>
                            </td>
                            <!-- >Glucose Fasting -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Glucose Fasting</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $pancreasResults['glucose_fasting_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                        <?php if ($pancreasResults['glucose_fasting_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $pancreasTestgroupdetails['s0013a_pancreas_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p style="margin-top:5px;">This test helps to diagnose the level of glucose in your blood at fasting conditions. It helps in detection of Prediabetes and monitoring of diabetes treatment plan.</p>

                                    <?php if ($pancreasResults['glucose_fasting_impact_on_health'] != '') { ?>
                                        <h4>Impact on health</h4>
                                        <p><?= $pancreasResults['glucose_fasting_impact_on_health']; ?></p>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $pancreasResults['hba1c_color_code']; ?>" style="  font-size: 34px;">
                                        <?php echo (($pancreasResults['hbAlc_result_value'] != '') ? $pancreasResults['hbAlc_result_value'] : '') ?></span> <?php echo htmlspecialchars($pancreasResults['hbAlc_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $pancreasResults['hbAlc_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $pancreasResults['hba1c_color_code']; ?> image-ressult">
                                            <?php echo (($pancreasResults['hba1c_result_value_in_words'] != '') ? $pancreasResults['hba1c_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($pancreasResults['hbAlc_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- HbA1c -->
                        <td class="rightPanel">
                            <div class="graphContent">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">HbA1c</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $pancreasResults['hbA1c_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($pancreasResults['hbAlc_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $pancreasTestgroupdetails['h0005_pancreas_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">HbA1c test helps to diagnose Prediabetes and monitor diabetes treatment plan</p>
                                    <p> <span style="font-weight: bold;">Estimated Average Glucose: </span><?= $pancreasResults['estimated_average_glucose']; ?> mg/dL</p>

                                    <?php if ($pancreasResults['hba1c_impact_on_health'] != '') { ?>
                                        <h4>Impact on health</h4>
                                        <p><?php echo ($pancreasResults['hba1c_impact_on_health'] != '') ? $pancreasResults['hba1c_impact_on_health'] : '' ?></p>
                                    <?php } ?>
                                </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $pancreasResults['lipase_color_code']; ?>" style="  font-size: 34px;">
                                        <?php echo (($pancreasResults['lipase_result_value'] != '') ? $pancreasResults['lipase_result_value'] : '') ?></span> <?php echo htmlspecialchars($pancreasResults['lipase_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($pancreasResults['lipase_result_value'] < $pancreasResults['lipase_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>
                                        <?php if ($pancreasResults['lipase_result_value'] >= $pancreasResults['lipase_low_result_value'] && $pancreasResults['lipase_result_value'] <  $pancreasResults['lipase_high_result_value']) { ?>
                                            <td><img src=" https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /> </td>
                                        <?php } ?>
                                        <?php if ($pancreasResults['lipase_result_value'] > $pancreasResults['lipase_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $pancreasResults['lipase_color_code']; ?>  image-ressult">
                                            <?php echo (($pancreasResults['lipase_result_value_in_words'] != '') ? $pancreasResults['lipase_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                        <td>Range </td>
                                        <td>: < <?php echo $pancreasResults['lipase_high_result_value'] ?> <?php echo htmlspecialchars($pancreasResults['lipase_uom']) ?></td>
                                    </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($pancreasResults['lipase_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $pancreasResults['lipase_BRInterval_result_value'] . " " . $pancreasResults['lipase_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $pancreasResults['lipase_low_result_value'] . " - " . $pancreasResults['lipase_high_result_value'] . " " . $pancreasResults['lipase_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Lipase, Serum -->
                        <td class="rightPanel">
                            <div class="graphContent">
                                <h4>Lipase, Serum</h4>
                                <p class="methodology"><?= $pancreasResults['lipase_sample_method']; ?></p>
                                <p>A lipase test measures the amount of lipase in the blood.</p>
                                <?php if ($pancreasResults['lipase_impact_on_health'] != '') { ?>
                                    <h4>Impact on health</h4>
                                    <p><?php echo ($pancreasResults['lipase_impact_on_health'] != '') ? $pancreasResults['lipase_impact_on_health'] : '' ?></p> <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Sample Type :</span> EDTA Whole Blood(HbA1c), Plasma(Glucose Fasting)
                    </p>
                </div>
                <?php if (
                    !empty($pancreasTestgroupdetails['h0005_pancreas_remarks']) ||
                    !empty($pancreasTestgroupdetails['S0013a_pancreas_remarks']) ||
                    !empty($pancreasTestgroupdetails['L0005_pancreas_remarks'])
                ) { ?>
                    <div style="padding-top: 2.5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                            <?= htmlspecialchars($pancreasTestgroupdetails['h0005_pancreas_remarks']) ?>
                            <?php if (!empty($pancreasTestgroupdetails['h0005_pancreas_remarks']) && !empty($pancreasTestgroupdetails['S0013a_pancreas_remarks'])): ?>
                                ,
                            <?php endif; ?>
                            <?= htmlspecialchars($pancreasTestgroupdetails['S0013a_pancreas_remarks']) ?>
                            <?php if ((!empty($pancreasTestgroupdetails['h0005_pancreas_remarks']) || !empty($pancreasTestgroupdetails['S0013a_pancreas_remarks'])) && !empty($pancreasTestgroupdetails['L0005_pancreas_remarks'])): ?>
                                ,
                            <?php endif; ?>
                            <?= htmlspecialchars($pancreasTestgroupdetails['L0005_pancreas_remarks']) ?>
                        </p>
                    </div>
                <?php } ?>
                <div>
                    <p class="suggestions-para">
                        <span class="p-tag" style="font-size: 16px;">Suggestions :</span> (1) Regular physical activity and lifestyle changes to support weight loss and overall health. (2) Regular monitoring of sugar levels needed.
                    </p>
                </div>
                <?php
                if (
                    !empty($pancreasResults['hbA1c_test_remraks'])
                    || !empty($pancreasResults['glucose_fasting_test_remraks'])
                    || !empty($pancreasResults['lipase_test_remraks'])
                ) {
                ?>
                    <div style="padding-top: 10px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                            <span class="test-remarks suggestions-para sample-type-para">
                                <?php
                                $remarks = array_filter([
                                    $pancreasResults['hbA1c_test_remraks'] ?? '',
                                    $pancreasResults['glucose_fasting_test_remraks'] ?? '',
                                    $pancreasResults['lipase_test_remraks'] ?? '',

                                ]);
                                echo htmlspecialchars(implode(', ', $remarks));
                                ?>
                            </span>
                        </p>
                    </div>
                <?php } ?>
                <!--<div style="font-size: 16px;">
                <p>Diabetes is a long lasting disease(Chronic disease). </p>
                <p>In diabetes your blood glucose, or blood sugar, levels are too high. </p>
                <div>
                    <p class="p-tag" style="font-size: 14px; padding-top: 10px;"> HbA1c:</p>
                    <p>This test looks for the average amount of glucose attached to the emoglobin over the past 2-3
                        months. </p>
                </div>
            </div>
            <table>
                <tr>
                    <td class="p-tag" style="font-size: 20px;">Suggestions</td>
                </tr>
                <tr style="padding-top: 5px;" class="d-block">
                    <td style="padding-top: 5px;"><img src="https://staging-cloud.lifecell.in/media/newsletter/medias/media/Group_4809.png" alt="" class="w-100"></td>
                    <td style="font-size: 16px;padding-top: 10px;color: #333;padding-left: 18px;padding-bottom: 3px;">
                        </td>
                </tr>
            </table>-->
                <!-- pancreas ended -->

            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['H0005', 'S0013a', 'L0005'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <!-- Heart parameter started -->
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-heart.png" alt="" class="w-100" style="padding-left: 10px; width:40px;">
                        </td>
                        <td style="padding-left:15px;"> <span class="result-title <?= $heartResults['heart-summary']; ?> ">Heart</span></td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['total_cholesterol_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['total_cholesterol_result_value'] != '') ? $heartResults['total_cholesterol_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['total_cholesterol_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['total_cholesterol_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['total_cholesterol_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['total_cholesterol_result_value_in_words'] != '') ? $heartResults['total_cholesterol_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['total_cholesterol_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- Total Cholesterol -->
                        <td class="rightPanel">

                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Total Cholesterol</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['total_cholesterol_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($heartResults['total_cholesterol_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Total Cholesterol is a blood test that measures the amount of total cholesterol in your blood. This test will confirm the risk of heart disease</p>
                                <?php if ($heartResults['total_cholesterol_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['total_cholesterol_impact_on_health'] != '') ? $heartResults['total_cholesterol_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['triglycerides_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['triglycerides_result_value'] != '') ? $heartResults['triglycerides_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['triglycerides_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['triglycerides_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['triglycerides_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['triglycerides_result_value_in_words'] != '') ? $heartResults['triglycerides_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['triglycerides_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- Triglycerides -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Triglycerides</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['triglycerides_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($heartResults['triglycerides_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Triglycerides are one of the most common types of fat present in your body.This test checks for presence or absence of heart risk diseases.
                                    Triglyceride is the test that will detect the total amount of Triglycerides in your blood. High levels of triglycerides in the blood can increase the risk of developing cardiovascular disease (CVD)</p>
                                <?php if ($heartResults['triglycerides_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['triglycerides_impact_on_health'] != '') ? $heartResults['triglycerides_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['hdl_cholesterol_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['hdl_cholesterol_result_value'] != '') ? $heartResults['hdl_cholesterol_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['hdl_cholesterol_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['hdl_cholesterol_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['hdl_cholesterol_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['hdl_cholesterol_result_value_in_words'] != '') ? $heartResults['hdl_cholesterol_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['hdl_cholesterol_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- HDL Cholesterol -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">HDL Cholesterol</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['hdl_cholesterol_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($heartResults['hdl_cholesterol_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">HDL cholesterol also known as “Good-Cholesterol” as they carries Bad cholesterol i.e LDL away from arteries to prevent blockage. This test checks for the level of HDL in your blood
                                    The function of the HDL Cholesterol test is to monitor your heart health. HDL Cholesterol is also known as “Good Cholesterol” as it is associated with better heart health.
                                </p>
                                <?php if ($heartResults['hdl_cholesterol_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['hdl_cholesterol_impact_on_health'] != '') ? $heartResults['hdl_cholesterol_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['nonhdlcholesterol_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['nonhdlcholesterol_result_value'] != '') ? $heartResults['nonhdlcholesterol_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['nonhdlcholesterol_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['nonhdlcholesterol_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['nonhdlcholesterol_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['nonhdlcholesterol_result_value_in_words'] != '') ? $heartResults['nonhdlcholesterol_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['nonhdlcholesterol_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- Non HDL Cholesterol -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Non HDL Cholesterol</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['nonhdlcholesterol_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($heartResults['nonhdlcholesterol_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">Non HDL Cholesterol test detects amount of “Bad Cholesterol” in your blood. This test is
                                    done for various purposes such as screening, diagnosis and monitoring heart disease
                                </p>
                                <?php if ($heartResults['nonhdlcholesterol_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['nonhdlcholesterol_impact_on_health'] != '') ? $heartResults['nonhdlcholesterol_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['Lipid Profile.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['lipoproteincholesterol_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['lipoproteincholesterol_result_value'] != '') ? $heartResults['lipoproteincholesterol_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['lipoproteincholesterol_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['lipoproteincholesterol_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['lipoproteincholesterol_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['lipoproteincholesterol_result_value_in_words'] != '') ? $heartResults['lipoproteincholesterol_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['lipoproteincholesterol_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- Low Density Lipoprotein - Cholesterol (LDL) -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Low Density Lipoprotein - Cholesterol (LDL)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['lipoproteincholesterol_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($heartResults['lipoproteincholesterol_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">Low Density Lipoprotein - Cholesterol (LDL) is the test that will detect the total amount of LDL in your blood.This test is done for various purposes such as screening, diagnosis and monitoring heart disease.
                                    LDL Cholesterol also known as “Bad Cholesterol” as its deposition in arteries can narrow the arteries and cause heart risk. This test assesses the value of LDL cholesterol in your blood.
                                </p>
                                <?php if ($heartResults['lipoproteincholesterol_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['lipoproteincholesterol_impact_on_health'] != '') ? $heartResults['lipoproteincholesterol_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <?php if (isset($heartResults['triglycerides_result_value']) && $heartResults['triglycerides_result_value'] != null && $heartResults['triglycerides_result_value'] <= 400) { ?>
                    <?php if($heartResults['lipoprotein_ldl_status_found']){ ?>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $heartResults['lipoprotein_ldl_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($heartResults['lipoprotein_ldl_result_value'] != '') ? $heartResults['lipoprotein_ldl_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($heartResults['lipoprotein_ldl_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <?php if ($heartResults['lipoprotein_ldl_result_value'] < $heartResults['lipoprotein_ldl_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>

                                            <?php if ($heartResults['lipoprotein_ldl_result_value'] >= $heartResults['lipoprotein_ldl_low_result_value'] && $heartResults['lipoprotein_ldl_result_value'] <= $heartResults['lipoprotein_ldl_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>

                                            <?php if ($heartResults['lipoprotein_ldl_result_value'] > $heartResults['lipoprotein_ldl_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $heartResults['lipoprotein_ldl_color_code']; ?> image-ressult">
                                                <?php echo (($heartResults['lipoprotein_ldl_result_value_in_words'] != '') ? $heartResults['lipoprotein_ldl_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <!-- <tr>
                                        <td>Range </td>
                                        <td>: <?php echo $heartResults['lipoprotein_ldl_low_result_value'] . " - " . $heartResults['lipoprotein_ldl_high_result_value'] . ""; ?> <?php echo htmlspecialchars($heartResults['lipoprotein_ldl_uom']); ?></td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($heartResults['lipoprotein_ldl_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $heartResults['lipoprotein_ldl_BRInterval_result_value'] . " " . $heartResults['lipoprotein_ldl_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $heartResults['lipoprotein_ldl_low_result_value'] . " - " . $heartResults['lipoprotein_ldl_high_result_value'] . " " . $heartResults['lipoprotein_ldl_uom']; ?> </td>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                            <!-- Very Low Density Lipoprotein - Cholesterol (VLDL) -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Very Low Density Lipoprotein - Cholesterol (VLDL)</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $heartResults['lipoprotein_ldl_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                        <?php if ($heartResults['lipoprotein_ldl_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p style="margin-top:5px;">VLDL is a type of lipoprotein that your liver produces. This test will check the levels of VLDL in your blood to check for any heart risk
                                        Very Low Density Lipoprotein - Cholesterol is the test that will detect the total amount of LDL in your blood. High levels of VLDLcan cause clogging in the arteries which can cause stroke.
                                    </p>
                                    <?php if ($heartResults['lipoprotein_ldl_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($heartResults['lipoprotein_ldl_impact_on_health'] != '') ? $heartResults['lipoprotein_ldl_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                    <?php }?>
                <?php } ?>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['total_cholesterolhdlratio_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['total_cholesterolhdlratio_result_value'] != '') ? $heartResults['total_cholesterolhdlratio_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($heartResults['total_cholesterolhdlratio_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['total_cholesterolhdlratio_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['total_cholesterolhdlratio_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['total_cholesterolhdlratio_result_value_in_words'] != '') ? $heartResults['total_cholesterolhdlratio_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['total_cholesterolhdlratio_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- Total Cholesterol / HDL Ratio -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Total Cholesterol / HDL Ratio</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['total_cholesterolhdlratio_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($heartResults['total_cholesterolhdlratio_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Total Cholesterol/HDL Ratio is the comparison test which compares your Total Cholesterol
                                    with your HDL to predict heart risk. Higher the ratio greater will be your heart risk </p>
                                <?php if ($heartResults['total_cholesterolhdlratio_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['total_cholesterolhdlratio_impact_on_health'] != '') ? $heartResults['total_cholesterolhdlratio_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['ldlorhdlratio_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['ldlorhdlratio_result_value'] != '') ? $heartResults['ldlorhdlratio_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['ldlorhdlratio_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['ldlorhdlratio_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $heartResults['ldlorhdlratio_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['ldlorhdlratio_result_value_in_words'] != '') ? $heartResults['ldlorhdlratio_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['ldlorhdlratio_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- LDL / HDL Ratio -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">LDL / HDL Ratio</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['ldlorhdlratio_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($heartResults['ldlorhdlratio_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['lipid_profile_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">LDL / HDL Ratio is the comparison test which compares your LDL / HDL Ratio to predict
                                    heart risk.</p>
                                <?php if ($heartResults['ldlorhdlratio_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['ldlorhdlratio_impact_on_health'] != '') ? $heartResults['ldlorhdlratio_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['Lipid Profile.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>


        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>



                <?php if (($patientDetails['PackageCode'] !== 'AYN_016') && ($patientDetails['PackageCode'] !== 'AYN_017')) { ?>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $heartResults['apolipoprotein_B_serum_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($heartResults['apolipoprotein_B_serum_result_value'] != '') ? $heartResults['apolipoprotein_B_serum_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($heartResults['apolipoprotein_B_serum_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <td><img src="<?= $heartResults['apolipoprotein_B_serum_thumb_up_icon'] ?>" /></td>
                                            <td class="<?= $heartResults['apolipoprotein_B_serum_color_code']; ?> image-ressult">
                                                <?php echo (($heartResults['apolipoprotein_B_serum_result_value_in_words'] != '') ? $heartResults['apolipoprotein_B_serum_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <?php
                                        foreach ($heartResults['apolipoprotein_B_serum_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </table>

                                </div>
                            </td>
                            <!-- Apolipoprotein B, Serum -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Apolipoprotein B, Serum</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $heartResults['apolipoprotein_B_serum_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($heartResults['apolipoprotein_B_serum_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $heartTestgroupdetails['A0018_heart_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">Apolipoprotein B is the primary protein associated with LDL cholesterol and other lipid particles. Like LDL cholesterol, increased concentrations are associated with increased risk of cardiovascular disease.</p>
                                    <?php if ($heartResults['apolipoprotein_B_serum_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($heartResults['apolipoprotein_B_serum_impact_on_health'] != '') ? $heartResults['apolipoprotein_B_serum_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $heartResults['apolipoprotein_A1_serum_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($heartResults['apolipoprotein_A1_serum_result_value'] != '') ? $heartResults['apolipoprotein_A1_serum_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($heartResults['apolipoprotein_A1_serum_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $heartResults['apolipoprotein_A1_serum_thumb_up_icon'] ?>" /></td>

                                        <td class="<?= $heartResults['apolipoprotein_A1_serum_color_code']; ?> image-ressult">
                                            <?php echo (($heartResults['apolipoprotein_A1_serum_result_value_in_words'] != '') ? $heartResults['apolipoprotein_A1_serum_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($heartResults['apolipoprotein_A1_serum_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>


                            </div>
                        </td>
                        <!-- Apolipoprotein A1, Serum -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Apolipoprotein A1, Serum</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $heartResults['apolipoprotein_A1_serum_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($heartResults['apolipoprotein_A1_serum_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $heartTestgroupdetails['A0018_heart_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Apolipoprotein A1 is the primary protein associated with HDL cholesterol. Like HDL cholesterol, increased concentrations are associated with reduced risk of cardiovascular disease.</p>
                                <?php if ($heartResults['apolipoprotein_A1_serum_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($heartResults['apolipoprotein_A1_serum_impact_on_health'] != '') ? $heartResults['apolipoprotein_A1_serum_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>


                <?php if (($patientDetails['PackageCode'] !== 'AYN_016') && ($patientDetails['PackageCode'] !== 'AYN_017')) { ?>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $heartResults['apolipoprotein_A1_B_serum_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($heartResults['apolipoprotein_A1_B_serum_result_value'] != '') ? $heartResults['apolipoprotein_A1_B_serum_result_value'] : '') ?>
                                        </span>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <?php if ($heartResults['apolipoprotein_A1_B_serum_result_value'] < $heartResults['apolipoprotein_A1_B_serum_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <?php if ($heartResults['apolipoprotein_A1_B_serum_result_value'] >= $heartResults['apolipoprotein_A1_B_serum_low_result_value'] && $heartResults['apolipoprotein_A1_B_serum_result_value'] <= $heartResults['apolipoprotein_A1_B_serum_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>
                                            <?php if ($heartResults['apolipoprotein_A1_B_serum_result_value'] > $heartResults['apolipoprotein_A1_B_serum_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $heartResults['apolipoprotein_A1_B_serum_color_code']; ?> image-ressult">
                                                <?php echo (($heartResults['apolipoprotein_A1_B_serum_result_value_in_words'] != '') ? $heartResults['apolipoprotein_A1_B_serum_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- <table class="mediacal-update">
                                    <tr>
                                        <td>Range</td>
                                        <td> : <?php echo $heartResults['apolipoprotein_A1_B_serum_low_result_value'] . " - " . $heartResults['apolipoprotein_A1_B_serum_high_result_value'] . ""; ?> <?php echo htmlspecialchars($heartResults['apolipoprotein_A1_B_serum_uom']); ?></td>
                                    </tr>
                                </table> -->
                                    <table class="mediacal-update">
                                        <!-- <tr>
                                        <td>Range </td>
                                        <td>: <?php echo $heartResults['apolipoprotein_A1_B_serum_low_result_value'] . " - " . $heartResults['apolipoprotein_A1_B_serum_high_result_value'] . ""; ?> <?php echo htmlspecialchars($heartResults['apolipoprotein_A1_B_serum_uom']); ?></td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($heartResults['apolipoprotein_A1_B_serum_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $heartResults['apolipoprotein_A1_B_serum_BRInterval_result_value'] . " " . $heartResults['apolipoprotein_A1_B_serum_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $heartResults['apolipoprotein_A1_B_serum_low_result_value'] . " - " . $heartResults['apolipoprotein_A1_B_serum_high_result_value'] . " " . $heartResults['apolipoprotein_A1_B_serum_uom']; ?> </td>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                            <!-- APO- B/ APO- A1 Ratio -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">APO- B/ APO- A1 Ratio</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $heartResults['apolipoprotein_A1_B_serum_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($heartResults['apolipoprotein_A1_B_serum_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $heartTestgroupdetails['A0018_heart_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">The ratio of these two apolipoproteins correlates with risk of cardiovascular disease.</p>
                                    <?php if ($heartResults['apolipoprotein_A1_B_serum_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($heartResults['apolipoprotein_A1_B_serum_impact_on_health'] != '') ? $heartResults['apolipoprotein_A1_B_serum_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                <?php } ?>


                <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                    <div>
                        <?php //echo $footerWithLogo;
                        echo NewFooter(['A0018'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                        ?>
                    </div>
                    <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
                </footer>
            </div>
        </div>





        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>

                <?php if ($patientDetails['PackageCode'] !== 'AYN_016') { ?>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $heartResults['high_sensitive_CRP_serum_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($heartResults['high_sensitive_CRP_serum_result_value'] != '') ? $heartResults['high_sensitive_CRP_serum_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($heartResults['high_sensitive_CRP_serum_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <td><img src="<?= $heartResults['high_sensitive_CRP_serum_thumb_up_icon'] ?>" /></td>
                                            <td class="<?= $heartResults['high_sensitive_CRP_serum_color_code']; ?> image-ressult">
                                                <?php echo (($heartResults['high_sensitive_CRP_serum_result_value_in_words'] != '') ? $heartResults['high_sensitive_CRP_serum_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <td>
                                            <?php echo $heartResults['high_sensitive_CRP_serum_heading_BRInterval_result_value'] ?>
                                        </td>
                                        <?php
                                        foreach ($heartResults['high_sensitive_CRP_serum_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </table>
                                </div>
                            </td>
                            <!-- High Sensitive CRP (hs-CRP), Serum -->
                            <td class="rightPanel">

                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">High Sensitive CRP (hs-CRP), Serum</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $heartResults['high_sensitive_CRP_serum_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($heartResults['high_sensitive_CRP_serum_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $heartTestgroupdetails['H0013_heart_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">hsCRP is a sensitive predictor of increased cardiovascular risk in both men and women.</p>
                                    <?php if ($heartResults['high_sensitive_CRP_serum_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($heartResults['high_sensitive_CRP_serum_impact_on_health'] != '') ? $heartResults['high_sensitive_CRP_serum_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>
                <?php } ?>


                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Serum
                    </p>
                </div>
                <?php
                if (!empty($heartTestgroupdetails['lipid_profile_heart_remarks']) || !empty($heartTestgroupdetails['H0013_heart_remarks']) || !empty($heartTestgroupdetails['A0018_heart_remarks'])) { ?>
                    <div style="padding-top: 2.5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                            <?= htmlspecialchars($heartTestgroupdetails['lipid_profile_heart_remarks']) ?>
                            <?php if (!empty($heartTestgroupdetails['lipid_profile_heart_remarks']) && !empty($heartTestgroupdetails['H0013_heart_remarks'])): ?>
                                ,
                            <?php endif; ?>
                            <?= htmlspecialchars($heartTestgroupdetails['H0013_heart_remarks']) ?>
                            <?php if ((!empty($heartTestgroupdetails['lipid_profile_heart_remarks']) || !empty($heartTestgroupdetails['H0013_heart_remarks'])) && !empty($heartTestgroupdetails['A0018_heart_remarks'])): ?>
                                ,
                            <?php endif; ?>
                            <?= htmlspecialchars($heartTestgroupdetails['A0018_heart_remarks']) ?>
                        </p>
                    </div>
                <?php } ?>
                <div>
                    <p class="suggestions-para">
                        <span class="p-tag" style="font-size: 16px;">Suggestions
                            :</span> (1) Eat heart-healthy foods-Reduce saturated fats, Eliminate trans fats, Eat foods rich in omega-3 fatty acids,Increase
                        soluble fiber. (2) Exercise on most days of the week and increase your physical activity-Taking a brisk daily walk during your lunch
                        hour,Riding your bike to work,Playing a favorite sport (3) Quit smoking (4) Lose weight (5) Avoid alcohol
                    </p>
                </div>
                <?php
                if (
                    !empty($heartResults['total_cholesterol_test_remraks']) ||
                    !empty($heartResults['triglycerides_test_remraks']) ||
                    !empty($heartResults['hdl_cholesterol_test_remraks']) ||
                    !empty($heartResults['lipoproteincholesterol_test_remraks']) ||
                    !empty($heartResults['lipoprotein_ldl_test_remraks']) ||
                    !empty($heartResults['total_cholesterolhdlratio_test_remraks']) ||
                    !empty($heartResults['ldlorhdlratio_test_remraks']) ||
                    !empty($heartResults['nonhdlcholesterol_test_remraks']) ||
                    !empty($heartResults['apolipoprotein_B_serum_test_remraks']) ||
                    !empty($heartResults['apolipoprotein_A1_serum_test_remraks']) ||
                    !empty($heartResults['apolipoprotein_A1_B_serum_test_remraks']) ||
                    !empty($heartResults['high_sensitive_CRP_serum_test_remraks'])
                ) {
                ?>
                    <div style="padding-top: 5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                            <span class="test-remarks suggestions-para sample-type-para">
                                <?php

                                $remarks = array_filter([
                                    $heartResults['total_cholesterol_test_remraks'] ?? '',
                                    $heartResults['triglycerides_test_remraks'] ?? '',
                                    $heartResults['hdl_cholesterol_test_remraks'] ?? '',
                                    $heartResults['lipoproteincholesterol_test_remraks'] ?? '',
                                    $heartResults['lipoprotein_ldl_test_remraks'] ?? '',
                                    $heartResults['total_cholesterolhdlratio_test_remraks'] ?? '',
                                    $heartResults['ldlorhdlratio_test_remraks'] ?? '',
                                    $heartResults['nonhdlcholesterol_test_remraks'] ?? '',
                                    $heartResults['apolipoprotein_B_serum_test_remraks'] ?? '',
                                    $heartResults['apolipoprotein_A1_serum_test_remraks'] ?? '',
                                    $heartResults['apolipoprotein_A1_B_serum_test_remraks'] ?? '',
                                    $heartResults['high_sensitive_CRP_serum_test_remraks'] ?? ''
                                ]);


                                echo htmlspecialchars(implode(', ', $remarks));
                                ?>
                            </span>
                        </p>
                    </div>
                <?php } ?>
                <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                    <div>
                        <?php //echo $footerWithLogo;
                        echo NewFooter(['H0013'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                        ?>
                    </div>
                    <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
                </footer>
            </div>
        </div>



        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <!-- THYROID STARTED -->
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-thyroid.png" alt="" class="w-100" style="padding-left: 10px; width:40px;">
                        </td>
                        <td style="padding-left: 15px;"> <span class="result-title <?= $thyroidResults['thyroid-summary']; ?>">Thyroid</span>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="color: #333; padding-left: 60px;">Thyroid test monitors the functioning of your
                            thyroid gland which produces thyroid hormone that controls body mechanisms
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $thyroidResults['thyronine_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($thyroidResults['thyronine_result_value'] != '') ? $thyroidResults['thyronine_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($thyroidResults['thyronine_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($thyroidResults['thyronine_result_value_cleaned'] <  $thyroidResults['t_three_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($thyroidResults['thyronine_result_value_cleaned'] >= $thyroidResults['t_three_low_result_value'] && $thyroidResults['thyronine_result_value_cleaned'] <= $thyroidResults['t_three_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($thyroidResults['thyronine_result_value_cleaned'] > $thyroidResults['t_three_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $thyroidResults['thyronine_color_code']; ?> image-ressult">
                                            <?php echo (($thyroidResults['thyronine_result_value_in_words'] != '') ? $thyroidResults['thyronine_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php if (!empty($thyroidResults['t_three_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($thyroidResults['t_three_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            if (strtolower($label) === 'pregnancy') {
                                                echo "<td colspan='3'><strong>" . ucwords($label) . "</strong></td>";
                                            } else {
                                                echo "<td>" . ucwords($label) . "</td>";
                                                echo "<td>: $range</td>";
                                                echo "<td>" . $thyroidResults['thyronine_uom'] . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td>Range</td>
                                            <td> : <?php echo $thyroidResults['t_three_low_result_value'] . " - " . $thyroidResults['t_three_high_result_value']; ?> </td>
                                            <td><?php echo $thyroidResults['thyronine_uom']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Thyroid - TriIodo Thyronine (T3 Total) -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Thyroid - TriIodo Thyronine (T3 Total)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $thyroidResults['thyronine_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($thyroidResults['thyronine_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $thyroidTestgroupdetails['Thyroid_001_thyroid_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">TriIodoThyronine is the one of the main hormones produced by thyroid gland. T3 total test
                                    helps to detect Hyperthyroidism, a condition where your thyroid gland starts producing
                                    excess amount of thyroid hormones</p>
                                <?php if ($thyroidResults['thyronine_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($thyroidResults['thyronine_impact_on_health'] != '') ? $thyroidResults['thyronine_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $thyroidResults['thyroxine_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($thyroidResults['thyroxine_result_value'] != '') ? $thyroidResults['thyroxine_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($thyroidResults['thyroxine_uom']) ?>
                                </div>

                                <table class="image-result">
                                    <tr>
                                        <?php if ($thyroidResults['thyroxine_result_value_cleaned'] <  $thyroidResults['t_four_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($thyroidResults['thyroxine_result_value_cleaned'] >= $thyroidResults['t_four_low_result_value']  && $thyroidResults['thyroxine_result_value_cleaned'] <= $thyroidResults['t_four_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($thyroidResults['thyroxine_result_value_cleaned'] > $thyroidResults['t_four_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $thyroidResults['thyroxine_color_code']; ?> image-ressult">
                                            <?php echo (($thyroidResults['thyroxine_result_value_in_words'] != '') ? $thyroidResults['thyroxine_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>

                                <table class="mediacal-update">
                                    <?php if (!empty($thyroidResults['t_four_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($thyroidResults['t_four_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            if (strtolower($label) === 'pregnancy') {
                                                echo "<td colspan='3'><strong>" . ucwords($label) . "</strong></td>";
                                            } else {
                                                echo "<td>" . ucwords($label) . "</td>";
                                                echo "<td>: $range</td>";
                                                echo "<td>" . $thyroidResults['thyroxine_uom'] . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td>Range</td>
                                            <td> : <?php echo $thyroidResults['t_four_low_result_value'] . " - " . $thyroidResults['t_four_high_result_value']; ?> </td>
                                            <td><?php echo $thyroidResults['thyroxine_uom']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>


                            </div>
                        </td>
                        <!-- Thyroid Thyroxine (T4) -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Thyroid Thyroxine (T4)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $thyroidResults['thyroxine_sample_method']; ?> </p>
                                </div>
                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($thyroidResults['thyroxine_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $thyroidTestgroupdetails['Thyroid_001_thyroid_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">Thyroxine test looks for the disorder of thyroid by evaluating the functioning of thyroid
                                    gland</p>
                                <?php if ($thyroidResults['thyroxine_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($thyroidResults['thyroxine_impact_on_health'] != '') ? $thyroidResults['thyroxine_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $thyroidResults['tsh_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($thyroidResults['tsh_result_value'] != '') ? $thyroidResults['tsh_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($thyroidResults['tsh_uom']); ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $thyroidResults['tsh_thumbs_color'] ?>" /></td>
                                        <td class="<?= $thyroidResults['tsh_color_code']; ?> image-ressult">
                                            <?php echo (($thyroidResults['tsh_result_value_in_words'] != '') ? $thyroidResults['tsh_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php if (!empty($thyroidResults['tsh_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($thyroidResults['tsh_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            if (strtolower($label) === 'pregnancy') {
                                                echo "<td colspan='3'><strong>" . ucwords($label) . "</strong></td>";
                                            } else {
                                                echo "<td>" . ucwords($label) . "</td>";
                                                echo "<td>: $range</td>";
                                                echo "<td>" . $thyroidResults['tsh_uom'] . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } ?>

                                </table>
                            </div>
                        </td>
                        <!-- Thyroid Stimulating Hormone (TSH) -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Thyroid Stimulating Hormone (TSH)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $thyroidResults['tsh_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($thyroidResults['tsh_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $thyroidTestgroupdetails['Thyroid_001_thyroid_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Thyroid Stimulating Hormone looks for the proper functioning of your thyroid gland.</p>
                                <?php if ($thyroidResults['tsh_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($thyroidResults['tsh_impact_on_health'] != '') ? $thyroidResults['tsh_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Serum
                    </p>
                </div>
                <?php if (!empty($thyroidTestgroupdetails['Thyroid_001_thyroid_remarks'])) { ?>
                    <div style="padding-top: 2.5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                            <?= htmlspecialchars($thyroidTestgroupdetails['Thyroid_001_thyroid_remarks']) ?>
                        </p>
                    </div>
                <?php } ?>
                <div>
                    <p class="suggestions-para">
                        <span class="p-tag" style="font-size: 16px;">Suggestions
                            :</span>Thyroid hormone levels can be brought to normal in a many ways and each treatment will depend on the cause of your thyroid condition. If you have hyperthyroidism,treatment options can include:Anti-thyroid drugs,beta blockers,radioactive iodine,surgery. If you have hypothyroidism the main treatment option is Thyroid replacement medication.
                    </p>
                </div>
                <?php
                if (
                    !empty($thyroidResults['thyronine_test_remraks']) ||
                    !empty($thyroidResults['thyroxine_test_remraks']) ||
                    !empty($thyroidResults['tsh_test_remraks'])
                ) {
                ?>
                    <div style="padding-top: 10px; ">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>

                            <span class="test-remarks suggestions-para sample-type-para">
                                <?php
                                $remarks = array_filter([
                                    $thyroidResults['thyronine_test_remraks'] ?? '',
                                    $thyroidResults['thyroxine_test_remraks'] ?? '',
                                    $thyroidResults['tsh_test_remraks'] ?? '',
                                ]);
                                echo htmlspecialchars(implode(', ', $remarks));
                                ?>
                            </span>
                        </p>
                    </div>
                <?php } ?>

            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['Thyroid 001'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>

        <!-- KIDNEY STARTED -->
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-kidny-mfine.png" alt="" style="padding-left: 10px; width:50px;" class="w-100">

                        </td>
                        <td style="padding-left: 15px;"> <span class="result-title <?= $kidneyResults['kidney-summary']; ?>">Kidney</span></td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['creatinine_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['creatinine_result_value'] != '') ? $kidneyResults['creatinine_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['creatinine_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['creatinine_result_value'] < $kidneyResults['creatinine_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <?php if ($kidneyResults['creatinine_result_value'] >= $kidneyResults['creatinine_low_result_value'] && $kidneyResults['creatinine_result_value'] <= $kidneyResults['creatinine_high_result_value']) { ?>
                                            <td><img src=" https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /> </td>
                                        <?php } ?>
                                        <?php if ($kidneyResults['creatinine_result_value'] > $kidneyResults['creatinine_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['creatinine_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['creatinine_result_value_in_words'] != '') ? $kidneyResults['creatinine_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>

                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $kidneyResults['creatinine_low_result_value'] . " - " . $kidneyResults['creatinine_high_result_value'] . " " . $kidneyResults['creatinine_uom']; ?> </td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($kidneyResults['creatinine_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $kidneyResults['creatinine_BRInterval_result_value'] . " " . $kidneyResults['creatinine_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $kidneyResults['creatinine_low_result_value'] . " - " . $kidneyResults['creatinine_high_result_value'] . " " . $kidneyResults['creatinine_uom']; ?> </td>
                                    <?php } ?>
                                </table>

                            </div>
                        </td>
                        <!-- Creatinine -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Creatinine</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['creatinine_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['creatinine_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">This test checks the production of Creatinine in your blood. Usually the kidney is used
                                    to filter creatinine from your blood. If your creatinine values are high this suggest
                                    problem in kidney</p>
                                <?php if ($kidneyResults['creatinine_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['creatinine_impact_on_health'] != '') ? $kidneyResults['creatinine_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['urea_result_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['urea_result_value'] != '') ? $kidneyResults['urea_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['urea_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['urea_result_value'] < $kidneyResults['urea_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <?php if ($kidneyResults['urea_result_value'] >= $kidneyResults['urea_low_result_value'] && $kidneyResults['urea_result_value'] <= $kidneyResults['urea_high_result_value']) { ?>
                                            <td><img src=" https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /> </td>
                                        <?php } ?>
                                        <?php if ($kidneyResults['urea_result_value'] > $kidneyResults['urea_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['urea_result_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['urea_result_value_in_words'] != '') ? $kidneyResults['urea_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $kidneyResults['urea_low_result_value'] . " - " . $kidneyResults['urea_high_result_value'] . " " . $kidneyResults['urea_uom']; ?> </td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($kidneyResults['urea_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $kidneyResults['urea_BRInterval_result_value'] . " " . $kidneyResults['urea_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $kidneyResults['urea_low_result_value'] . " - " . $kidneyResults['urea_high_result_value'] . " " . $kidneyResults['urea_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Urea -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Urea</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['urea_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['urea_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Urea test is used to detect malfunctioning of kidney</p>
                                <?php if ($kidneyResults['urea_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['urea_impact_on_health'] != '') ? $kidneyResults['urea_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['blood_urea_nitrogen_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['blood_urea_nitrogen_result_value'] != '') ? $kidneyResults['blood_urea_nitrogen_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['blood_urea_nitrogen_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['blood_urea_nitrogen_result_value'] < $kidneyResults['blood_urea_nitrogen_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['blood_urea_nitrogen_result_value'] >= $kidneyResults['blood_urea_nitrogen_low_result_value'] && $kidneyResults['blood_urea_nitrogen_result_value'] <= $kidneyResults['blood_urea_nitrogen_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['blood_urea_nitrogen_result_value'] > $kidneyResults['blood_urea_nitrogen_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['blood_urea_nitrogen_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['blood_urea_nitrogen_result_value_in_words'] != '') ? $kidneyResults['blood_urea_nitrogen_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php if (!empty($kidneyResults['blood_urea_nitrogen_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($kidneyResults['blood_urea_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "<td>" . $kidneyResults['blood_urea_nitrogen_uom'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['blood_urea_low_result_value'] . " - " . $kidneyResults['blood_urea_high_result_value'] . " " . $kidneyResults['blood_urea_nitrogen_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Blood Urea Nitrogen (BUN) -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Blood Urea Nitrogen (BUN)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['blood_urea_nitrogen_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['blood_urea_nitrogen_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Blood Urea Nitrogen monitors kidney health. This test checks how well your kidney is
                                    working by measuring the amount of urea nitrogen in your blood</p>
                                <?php if ($kidneyResults['blood_urea_nitrogen_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['blood_urea_nitrogen_impact_on_health'] != '') ? $kidneyResults['blood_urea_nitrogen_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['creatinine_ratio_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['creatinine_ratio_result_value'] != '') ? $kidneyResults['creatinine_ratio_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['creatinine_ratio_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ((float)$kidneyResults['creatinine_ratio_result_value'] < $kidneyResults['creatinine_ratio_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ((float)$kidneyResults['creatinine_ratio_result_value'] >= $kidneyResults['creatinine_ratio_low_result_value'] && $kidneyResults['creatinine_ratio_result_value'] <= $kidneyResults['creatinine_ratio_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ((float)$kidneyResults['creatinine_ratio_result_value'] > $kidneyResults['creatinine_ratio_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['creatinine_ratio_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['creatinine_ratio_result_value_in_words'] != '') ? $kidneyResults['creatinine_ratio_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range </td>
                                    <td>: <?php echo $kidneyResults['creatinine_ratio_low_result_value'] . " - " . $kidneyResults['creatinine_ratio_high_result_value'] . " " . $kidneyResults['creatinine_ratio_uom']; ?> </td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($kidneyResults['creatinine_ratio_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $kidneyResults['creatinine_ratio_BRInterval_result_value'] . " " . $kidneyResults['creatinine_ratio_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $kidneyResults['creatinine_ratio_low_result_value'] . " - " . $kidneyResults['creatinine_ratio_high_result_value'] . " " . $kidneyResults['creatinine_ratio_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- BUN/Creatinine Ratio -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">BUN/Creatinine Ratio</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['creatinine_ratio_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['creatinine_ratio_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Bun/Creatinine ratio is the test used to detect Chronic Kidney Disease (CKD) & Damage</p>
                                <?php if ($kidneyResults['creatinine_ratio_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['creatinine_ratio_impact_on_health'] != '') ? $kidneyResults['creatinine_ratio_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>

            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['RFT-Basic'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['uricacid_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['uricacid_result_value'] != '') ? $kidneyResults['uricacid_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['uricacid_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['uricacid_result_value'] <  $kidneyResults['uric_acid_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['uricacid_result_value'] >= $kidneyResults['uric_acid_low_result_value']  && $kidneyResults['uricacid_result_value'] <= $kidneyResults['uric_acid_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['uricacid_result_value'] > $kidneyResults['uric_acid_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['uricacid_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['uricacid_result_value_in_words'] != '') ? $kidneyResults['uricacid_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>

                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $kidneyResults['uric_acid_low_result_value'] . " - " . $kidneyResults['uric_acid_high_result_value'] . " " . $kidneyResults['uricacid_uom']; ?> </td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($kidneyResults['uric_acid_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $kidneyResults['uric_acid_BRInterval_result_value'] . " " . $kidneyResults['uricacid_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $kidneyResults['uric_acid_low_result_value'] . " - " . $kidneyResults['uric_acid_high_result_value'] . " " . $kidneyResults['uricacid_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Uric Acid -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Uric Acid</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['uricacid_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['uricacid_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Uric Acid measures the amount of uric acid in your blood. Higher value of Uric Acid can
                                    cause Kidney Stone & Kidney Failure</p>
                                <?php if ($kidneyResults['uricacid_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['uricacid_impact_on_health'] != '') ? $kidneyResults['uricacid_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['calcium_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['calcium_result_value'] != '') ? $kidneyResults['calcium_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['calcium_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['calcium_result_value'] <  $kidneyResults['calcium_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['calcium_result_value'] >= $kidneyResults['calcium_low_result_value']  && $kidneyResults['calcium_result_value'] <= $kidneyResults['calcium_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['calcium_result_value'] > $kidneyResults['calcium_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['calcium_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['calcium_result_value_in_words'] != '') ? $kidneyResults['calcium_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php if (!empty($kidneyResults['calcium_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($kidneyResults['calcium_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "<td>" . $kidneyResults['calcium_uom'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['calcium_low_result_value'] . " - " . $kidneyResults['calcium_high_result_value'] . " " . $kidneyResults['calcium_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Calcium -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Calcium</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['calcium_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['calcium_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Calcium monitors the function of Kidney and confirm if any stone formation is happening
                                    in Kidney</p>
                                <?php if ($kidneyResults['calcium_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['calcium_impact_on_health'] != '') ? $kidneyResults['calcium_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['magnesium_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['magnesium_result_value'] != '') ? $kidneyResults['magnesium_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['magnesium_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($kidneyResults['magnesium_result_value'] < $kidneyResults['magnesium_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <?php if ($kidneyResults['magnesium_result_value'] >= $kidneyResults['magnesium_low_result_value']  && $kidneyResults['magnesium_result_value'] <= $kidneyResults['magnesium_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($kidneyResults['magnesium_result_value'] > $kidneyResults['magnesium_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $kidneyResults['magnesium_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                            <?php echo (($kidneyResults['magnesium_result_value_in_words'] != '') ? $kidneyResults['magnesium_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php if (!empty($kidneyResults['magnesium_BRInterval_result_value'])) { ?>
                                        <?php
                                        foreach ($kidneyResults['magnesium_reference_ranges_value'] as $label => $range) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($label) . "</td>";
                                            echo "<td>: $range</td>";
                                            echo "<td>" . $kidneyResults['magnesium_uom'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['magnesium_low_result_value'] . " - " . $kidneyResults['magnesium_high_result_value'] . " " . $kidneyResults['magnesium_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Magnesium, Serum -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Magnesium, Serum</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['magnesium_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['magnesium_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['M0001_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Electrolytes are primarily used for assessing acid base balance in a variety of medical conditions.</p>
                                <?php if ($kidneyResults['magnesium_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['magnesium_impact_on_health'] != '') ? $kidneyResults['magnesium_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $kidneyResults['egfr_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($kidneyResults['egfr_result_value'] != '') ? $kidneyResults['egfr_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($kidneyResults['egfr_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <td><img src="<?= $kidneyResults['egfr_thumb_up_icon'] ?>" /></td>
                                        <td class="<?= $kidneyResults['egfr_color_code']; ?> image-ressult">
                                            <?php echo (($kidneyResults['egfr_result_value_in_words'] != '') ? $kidneyResults['egfr_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <?php
                                    foreach ($kidneyResults['egfr_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <!-- eGFR -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">eGFR</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $kidneyResults['egfr_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($kidneyResults['egfr_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $kidneyTestgroupdetails['RFT_Basic_kidney_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">eGFR test is to screen and monitor kidney problems such as urinary changes, fatigue, swelling in the arms or legs, itching, nausea, and vomiting</p>
                                <?php if ($kidneyResults['egfr_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($kidneyResults['egfr_impact_on_health'] != '') ? $kidneyResults['egfr_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>


            </div>
            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['RFT-Basic', 'M0001'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <?php if ($patientDetails['PackageCode'] !== 'AYN_016') { ?>
                    <p class="electrolytes" style="font-size:20px; font-weight:bold;padding:5px;">Electrolytes</p>
                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <!-- Sodium (Na+), Serum -->
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $kidneyResults['sodium_result_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($kidneyResults['sodium_result_value'] != '') ? $kidneyResults['sodium_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($kidneyResults['sodium_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <?php if ($kidneyResults['sodium_result_value'] < $kidneyResults['sodium_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['sodium_result_value'] >= $kidneyResults['sodium_low_result_value'] && $kidneyResults['sodium_result_value'] <= $kidneyResults['sodium_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['sodium_result_value'] > $kidneyResults['sodium_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $kidneyResults['sodium_result_color_code']; ?> image-ressult">
                                                <?php echo (($kidneyResults['sodium_result_value_in_words'] != '') ? $kidneyResults['sodium_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <!-- <tr>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['sodium_low_result_value'] . " - " . $kidneyResults['sodium_high_result_value'] . " " . $kidneyResults['sodium_uom']; ?> </td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($kidneyResults['sodium_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $kidneyResults['sodium_BRInterval_result_value'] . " " . $kidneyResults['sodium_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $kidneyResults['sodium_low_result_value'] . " - " . $kidneyResults['sodium_high_result_value'] . " " . $kidneyResults['sodium_uom']; ?> </td>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                            <!-- Sodium (Na+), Serum -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Sodium (Na+), Serum</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $kidneyResults['sodium_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($kidneyResults['sodium_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $kidneyTestgroupdetails['Electrolyte_kidney_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">Electrolytes are primarily used for assessing acid base balance in a variety of medical conditions.</p>
                                    <?php if ($kidneyResults['sodium_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($kidneyResults['sodium_impact_on_health'] != '') ? $kidneyResults['sodium_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>

                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <!-- Potassium (K+), Serum -->
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $kidneyResults['potassium_result_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($kidneyResults['potassium_result_value'] != '') ? $kidneyResults['potassium_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($kidneyResults['potassium_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <?php if ($kidneyResults['potassium_result_value'] < $kidneyResults['potassium_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['potassium_result_value'] >= $kidneyResults['potassium_low_result_value'] && $kidneyResults['potassium_result_value'] <= $kidneyResults['potassium_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['potassium_result_value'] > $kidneyResults['potassium_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $kidneyResults['potassium_result_color_code']; ?> image-ressult">
                                                <?php echo (($kidneyResults['potassium_result_value_in_words'] != '') ? $kidneyResults['potassium_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <!-- <tr>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['potassium_low_result_value'] . " - " . $kidneyResults['potassium_high_result_value'] . " " . $kidneyResults['potassium_uom']; ?></td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($kidneyResults['potassium_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $kidneyResults['potassium_BRInterval_result_value'] . " " . $kidneyResults['potassium_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $kidneyResults['potassium_low_result_value'] . " - " . $kidneyResults['potassium_high_result_value'] . " " . $kidneyResults['potassium_uom']; ?> </td>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                            <!-- Potassium (K+), Serum -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Potassium (K+), Serum</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $kidneyResults['potassium_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($kidneyResults['potassium_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $kidneyTestgroupdetails['Electrolyte_kidney_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">Electrolytes are primarily used for assessing acid base balance in a variety of medical conditions.</p>
                                    <?php if ($kidneyResults['potassium_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($kidneyResults['potassium_impact_on_health'] != '') ? $kidneyResults['potassium_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>

                    <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                        <tr>
                            <!-- Chloride, Serum -->
                            <td class="leftPanel">
                                <div class="graphDetail">
                                    <p style="color: #333;font-weight:600;">Your Result Value</p>
                                    <div>
                                        <span class="<?= $kidneyResults['chloride_result_color_code']; ?>" style="font-size: 34px;">
                                            <?php echo (($kidneyResults['chloride_result_value'] != '') ? $kidneyResults['chloride_result_value'] : '') ?>
                                        </span><?php echo htmlspecialchars($kidneyResults['chloride_uom']) ?>
                                    </div>
                                    <table class="image-result">
                                        <tr>
                                            <?php if ($kidneyResults['chloride_result_value'] < $kidneyResults['chloride_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['chloride_result_value'] >= $kidneyResults['chloride_low_result_value'] && $kidneyResults['chloride_result_value'] <= $kidneyResults['chloride_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>
                                            <?php if ($kidneyResults['chloride_result_value'] > $kidneyResults['chloride_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $kidneyResults['chloride_result_color_code']; ?> image-ressult">
                                                <?php echo (($kidneyResults['chloride_result_value_in_words'] != '') ? $kidneyResults['chloride_result_value_in_words'] : '') ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="mediacal-update">
                                        <!-- <tr>
                                        <td>Range</td>
                                        <td> : <?php echo $kidneyResults['chloride_low_result_value'] . " - " . $kidneyResults['chloride_high_result_value'] . " " . $kidneyResults['chloride_uom']; ?> </td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($kidneyResults['chloride_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $kidneyResults['chloride_BRInterval_result_value'] . " " . $kidneyResults['chloride_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $kidneyResults['chloride_low_result_value'] . " - " . $kidneyResults['chloride_high_result_value'] . " " . $kidneyResults['chloride_uom']; ?> </td>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                            <!-- Chloride, Serum -->
                            <td class="rightPanel">
                                <div class="graphContent" style="position: relative;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                        <h4 style="margin: 0;">Chloride, Serum</h4>
                                        <p class="methodology" style="margin: 0;"> <?= $kidneyResults['chloride_sample_method']; ?> </p>
                                    </div>

                                    <!-- NABL Logo and Code Positioned Absolutely -->
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                        <?php if ($kidneyResults['chloride_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                                <?= $kidneyTestgroupdetails['Electrolyte_kidney_nabl_code']; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <p style="margin-top:5px;">Electrolytes are primarily used for assessing acid base balance in a variety of medical conditions.</p>
                                    <?php if ($kidneyResults['chloride_impact_on_health'] != '') { ?>
                                        <h4 style="font-size: 18px;">Impact on health</h4>
                                        <p>
                                            <?php echo ($kidneyResults['chloride_impact_on_health'] != '') ? $kidneyResults['chloride_impact_on_health'] : '' ?>
                                        </p>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    </table>




                <?php } ?>


                <div style="float:left;">
                    <div style="padding-top: 5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Serum
                        </p>
                    </div>
                    <?php if (!empty($kidneyTestgroupdetails['RFT_Basic_kidney_remarks']) || !empty($kidneyTestgroupdetails['Electrolyte_kidney_remarks']) || !empty($kidneyTestgroupdetails['M0001_kidney_remarks'])) { ?>
                        <div style="padding-top: 2.5px;">
                            <p class="sample-type-para">
                                <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                                <?= htmlspecialchars($kidneyTestgroupdetails['RFT_Basic_kidney_remarks']) ?>
                                <?php if (!empty($kidneyTestgroupdetails['RFT_Basic_kidney_remarks']) && !empty($kidneyTestgroupdetails['Electrolyte_kidney_remarks'])): ?>
                                    ,
                                <?php endif; ?>
                                <?= htmlspecialchars($kidneyTestgroupdetails['Electrolyte_kidney_remarks']) ?>
                                <?php if ((!empty($kidneyTestgroupdetails['RFT_Basic_kidney_remarks']) || !empty($kidneyTestgroupdetails['Electrolyte_kidney_remarks'])) && !empty($kidneyTestgroupdetails['M0001_kidney_remarks'])): ?>
                                    ,
                                <?php endif; ?>
                                <?= htmlspecialchars($kidneyTestgroupdetails['M0001_kidney_remarks']) ?>
                            </p>
                        </div>
                    <?php } ?>
                    <div>
                        <p class="suggestions-para" style="padding-bottom:37%;">
                            <span class="p-tag" style="font-size: 16px;">Suggestions :</span>
                            (1) If the test results are outside the standard range, you might need further testing to determine the diagnosis.
                            (2) Medications can help resolve high creatinine levels by treating the condition that’s causing the increase. Some examples include antibiotics for a kidney infection or medications that help control high blood pressure.
                            (3) Losing weight, if necessary (4) Watching what you eat limit your intake of organ meats, red meat, fish, and alcoholic beverages. (5) A lifelong urate-lowering therapy may be needed, with medications that prevent gout flares and ultimately dissolve crystals that are already in your body
                            (6) Calcium and Vitamin D supplements can help in increasing calcium levels Good sources of calcium include milk, cheese, yogurt, soy products, sardines, canned salmon, fortified cereal, and dark leafy greens
                            (7) It is the laboratory test for detection and monitoring of kidney disease.The limitation of urea as a test of renal function relates to reduced sensitivity and specificity as there are other causes that can be associated with such a rise e.g. heart failure, dehydration is common.Further evaluation is required for increased serum urea levels.
                            (8) Please consult your physician for personalized medical advice.
                        </p>
                    </div>
                    <?php
                    if (
                        !empty($kidneyResults['urea_test_remraks']) ||
                        !empty($kidneyResults['creatinine_test_remraks']) ||
                        !empty($kidneyResults['uricacid_test_remraks']) ||
                        !empty($kidneyResults['calcium_test_remraks']) ||

                        !empty($kidneyResults['egfr_test_remraks']) ||
                        !empty($kidneyResults['blood_urea_nitrogen_test_remraks']) ||
                        !empty($kidneyResults['creatinine_ratio_test_remraks']) ||
                        !empty($kidneyResults['sodium_test_remraks']) ||
                        !empty($kidneyResults['potassium_test_remraks']) ||
                        !empty($kidneyResults['chloride_test_remraks']) ||
                        !empty($kidneyResults['magnesium_test_remraks'])
                    ) {
                    ?>
                        <div style="padding-top: 5px;">
                            <p class="sample-type-para">
                                <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                                <span class="test-remarks suggestions-para sample-type-para">
                                    <?php

                                    $remarks = array_filter([
                                        $kidneyResults['urea_test_remraks'] ?? '',
                                        $kidneyResults['creatinine_test_remraks'] ?? '',
                                        $kidneyResults['uricacid_test_remraks'] ?? '',
                                        $kidneyResults['calcium_test_remraks'] ?? '',

                                        $kidneyResults['egfr_test_remraks'] ?? '',
                                        $kidneyResults['magnesium_test_remraks'] ?? '',
                                        $kidneyResults['blood_urea_nitrogen_test_remraks'] ?? '',
                                        $kidneyResults['creatinine_ratio_test_remraks'] ?? '',
                                        $kidneyResults['sodium_test_remraks'] ?? '',
                                        $kidneyResults['potassium_test_remraks'] ?? '',
                                        $kidneyResults['chloride_test_remraks'] ?? '',


                                    ]);

                                    echo htmlspecialchars(implode(', ', $remarks));
                                    ?>
                                </span>
                            </p>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <footer style="position: absolute; bottom: -10px; left: 0; width: 100%; text-align: center; padding: 10px 0; page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['Electrolyte'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>

        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <!-- LIVER STARTED -->
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-liver-mfine.png" alt="" style="padding-left: 10px; width:45px;" class="w-100">
                        </td>
                        <td style="padding-left: 15px;"> <span class="result-title <?= $liverResults['liver-summary']; ?>">Liver</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="color: #414042;
                    padding-left: 60px;">Liver test detects the liver infection and monitor functioning of liver in
                            your body by measuring levels of different enzymes & protein in your blood</td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $liverResults['bilirubin_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($liverResults['bilirubin_total_result_value'] != '') ? $liverResults['bilirubin_total_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($liverResults['bilirubin_total_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($liverResults['bilirubin_total_result_value'] < $liverResults['bilirubin_total_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['bilirubin_total_result_value'] >= $liverResults['bilirubin_total_low_result_value']  && $liverResults['bilirubin_total_result_value'] <= $liverResults['bilirubin_total_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['bilirubin_total_result_value'] > $liverResults['bilirubin_total_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $liverResults['bilirubin_color_code']; ?> image-ressult">
                                            <?php echo (($liverResults['bilirubin_result_value_in_words'] != '') ? $liverResults['bilirubin_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range</td>
                                    <td style="width:75%;"> :<?php echo $liverResults['bilirubin_total_low_result_value'] . " - " . $liverResults['bilirubin_total_high_result_value'] . " " . $liverResults['bilirubin_total_uom']; ?></td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($liverResults['bilirubin_total_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $liverResults['bilirubin_total_BRInterval_result_value'] . " " . $liverResults['bilirubin_total_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $liverResults['bilirubin_total_low_result_value'] . " - " . $liverResults['bilirubin_total_high_result_value'] . " " . $liverResults['bilirubin_total_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Bilirubin - Total -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Bilirubin - Total</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $liverResults['bilirubin_total_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($liverResults['bilirubin_total_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Bilirubin blood test measures the amount of Bilirubin total in your blood. This test
                                    monitor the health of your live</p>
                                <?php if ($liverResults['bilirubin_total_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($liverResults['bilirubin_total_impact_on_health'] != '') ? $liverResults['bilirubin_total_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $liverResults['bilirubin_direct_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($liverResults['bilirubin_direct_result_value'] != '') ? $liverResults['bilirubin_direct_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($liverResults['bilirubin_direct_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ((float)$liverResults['bilirubin_direct_result_value'] < $liverResults['bilirubin_direct_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ((float)$liverResults['bilirubin_direct_result_value'] >= $liverResults['bilirubin_direct_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $liverResults['bilirubin_direct_color_code']; ?> image-ressult">
                                            <?php echo (($liverResults['bilirubin_direct_result_value_in_words'] != '') ? $liverResults['bilirubin_direct_result_value_in_words'] : ''); ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                    <td>Range</td>
                                    <td> : &#60; <?php echo $liverResults['bilirubin_direct_high_result_value'] . " " . $liverResults['bilirubin_direct_uom']; ?></td>
                                </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($liverResults['bilirubin_direct_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $liverResults['bilirubin_direct_BRInterval_result_value'] . " " . $liverResults['bilirubin_direct_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $liverResults['bilirubin_direct_low_result_value'] . " - " . $liverResults['bilirubin_direct_high_result_value'] . " " . $liverResults['bilirubin_direct_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Bilirubin - Direct -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Bilirubin - Direct</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $liverResults['bilirubin_direct_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($liverResults['bilirubin_direct_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Bilirubin blood test measures the amount of Direct Bilirubin total in your blood. This
                                    test monitor the health of your live</p>
                                <?php if ($liverResults['bilirubin_direct_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($liverResults['bilirubin_direct_impact_on_health'] != '') ? $liverResults['bilirubin_direct_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection ">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $liverResults['bilirubin_indirect_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($liverResults['bilirubin_indirect_result_value'] != '') ? $liverResults['bilirubin_indirect_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($liverResults['bilirubin_indirect_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($liverResults['bilirubin_indirect_result_value'] < $liverResults['bilirubin_indirect_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['bilirubin_indirect_result_value'] >= $liverResults['bilirubin_indirect_low_result_value'] && $liverResults['bilirubin_indirect_result_value'] <= $liverResults['bilirubin_indirect_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['bilirubin_indirect_result_value'] >  $liverResults['bilirubin_indirect_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                        </td>
                        <td class="<?= $liverResults['bilirubin_indirect_color_code']; ?> image-ressult">
                            <?php echo (($liverResults['bilirubin_indirect_result_value_in_words'] != '') ? $liverResults['bilirubin_indirect_result_value_in_words'] : '') ?>
                        </td>
                    </tr>
                </table>
                <table class="mediacal-update">
                    <!-- <tr>
                    <td>Range</td>
                    <td> : <?php echo $liverResults['bilirubin_indirect_low_result_value'] . " - " . $liverResults['bilirubin_indirect_high_result_value'] . " " . $liverResults['bilirubin_indirect_uom']; ?></td>
                </tr> -->
                    <td>Range</td>
                    <?php if (!empty($liverResults['bilirubin_indirect_BRInterval_result_value'])) { ?>
                        <td> : <?php echo $liverResults['bilirubin_indirect_BRInterval_result_value'] . " " . $liverResults['bilirubin_indirect_uom']; ?> </td>
                    <?php } else { ?>
                        <td> : <?php echo $liverResults['bilirubin_indirect_low_result_value'] . " - " . $liverResults['bilirubin_indirect_high_result_value'] . " " . $liverResults['bilirubin_indirect_uom']; ?> </td>
                    <?php } ?>
                </table>
            </div>
            </td>
            <!-- Bilirubin - Indirect -->
            <td class="rightPanel">
                <div class="graphContent" style="position: relative;">
                    <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                        <h4 style="margin: 0;">Bilirubin - Indirect</h4>
                        <p class="methodology" style="margin: 0;"> <?= $liverResults['bilirubin_indirect_sample_method']; ?> </p>
                    </div>

                    <!-- NABL Logo and Code Positioned Absolutely -->
                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                        <?php if ($liverResults['bilirubin_indirect_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                            <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                            <div style="color: #000; font-size: 8px; line-height: 8px;">
                                <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <p style="margin-top:5px;">This test detects the presence or absence of Crystals in your urine</p>
                    <?php if ($liverResults['bilirubin_indirect_impact_on_health'] != '') { ?>
                        <h4 style="font-size: 18px;">Impact on health</h4>
                        <p>
                            <?php echo ($liverResults['bilirubin_indirect_impact_on_health'] != '') ? $liverResults['bilirubin_indirect_impact_on_health'] : '' ?>
                        </p>
                    <?php } ?>

                </div>
            </td>
            </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['sgot_ast_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['sgot_ast_result_value'] != '') ? $liverResults['sgot_ast_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['sgot_ast_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['sgot_ast_result_value'] < $liverResults['sgot_ast_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['sgot_ast_result_value'] >= $liverResults['sgot_ast_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['sgot_ast_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['sgot_ast_result_value_in_words'] != '') ? $liverResults['sgot_ast_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <!-- <tr>
                                <td>Range</td>
                                <td>: &#60; <?php echo $liverResults['sgot_ast_high_result_value'] . " " . $liverResults['sgot_ast_uom']; ?> </td>
                            </tr> -->
                                <td>Range</td>
                                <?php if (!empty($liverResults['sgot_ast_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $liverResults['sgot_ast_BRInterval_result_value'] . " " . $liverResults['sgot_ast_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $liverResults['sgot_ast_low_result_value'] . " - " . $liverResults['sgot_ast_high_result_value'] . " " . $liverResults['sgot_ast_uom']; ?> </td>
                                <?php } ?>
                            </table>

                        </div>
                    </td>
                    <!-- SGOT-AST -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">SGOT-AST</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['sgot_ast_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['sgot_ast_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">SGOT test is used to detect damage in the tissues of your Liver.
                                SGOT is an enzyme found in liver. This test help to detect liver damage or disease by
                                measuring the levels of SGOT levels in your blood</p>
                            <?php if ($liverResults['sgot_ast_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['sgot_ast_impact_on_health'] != '') ? $liverResults['sgot_ast_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>

        </div>
        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['LFT.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['sgpt_alt_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['sgpt_alt_result_value'] != '') ? $liverResults['sgpt_alt_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['sgpt_alt_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['sgpt_alt_result_value'] < $liverResults['sgpt_alt_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['sgpt_alt_result_value'] >= $liverResults['sgpt_alt_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['sgpt_alt_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['sgpt_alt_result_value_in_words'] != '') ? $liverResults['sgpt_alt_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td>: &#60; <?php echo $liverResults['sgpt_alt_high_result_value'] . " " . $liverResults['sgpt_alt_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($liverResults['sgpt_alt_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $liverResults['sgpt_alt_BRInterval_result_value'] . " " . $liverResults['sgpt_alt_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $liverResults['sgpt_alt_low_result_value'] . " - " . $liverResults['sgpt_alt_high_result_value'] . " " . $liverResults['sgpt_alt_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- SGPT-ALT -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">SGPT-ALT</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['sgpt_alt_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['sgpt_alt_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">SGPT test is used to detect disease of liver</p>
                            <?php if ($liverResults['sgpt_alt_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['sgpt_alt_impact_on_health'] != '') ? $liverResults['sgpt_alt_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>

                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['alkaline_phosphatase_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['alkaline_phosphatase_result_value'] != '') ? $liverResults['alkaline_phosphatase_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['alkaline_phosphatase_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['alkaline_phosphatase_result_value'] < $liverResults['alkaline_phosphatase_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['alkaline_phosphatase_result_value'] >= $liverResults['alkaline_phosphatase_low_result_value'] && $liverResults['alkaline_phosphatase_result_value'] <= $liverResults['alkaline_phosphatase_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['alkaline_phosphatase_result_value'] >  $liverResults['alkaline_phosphatase_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['alkaline_phosphatase_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['alkaline_phosphatase_result_value_in_words'] != '') ? $liverResults['alkaline_phosphatase_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $liverResults['alkaline_phosphatase_low_result_value'] . " - " . $liverResults['alkaline_phosphatase_high_result_value'] . " " . $liverResults['alkaline_phosphatase_uom']; ?> </td>
                                </tr> -->
                                <?php if (!empty($liverResults['alkaline_phosphatase_BRInterval_result_value'])) { ?>
                                    <?php
                                    foreach ($liverResults['alkaline_phosphatase_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "<td>" . $liverResults['alkaline_phosphatase_uom'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                <?php } else { ?>
                                    <td>Range</td>
                                    <td> : <?php echo $liverResults['alkaline_phosphatase_low_result_value'] . " - " . $liverResults['alkaline_phosphatase_high_result_value'] . " " . $liverResults['alkaline_phosphatase_uom']; ?> </td>
                                <?php } ?>
                            </table>

                        </div>
                    </td>
                    <!-- Alkaline Phosphatase -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Alkaline Phosphatase</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['alkaline_phosphatase_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['alkaline_phosphatase_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Alkaline Phosphatase is the test that measures Alkaline Phosphatase enzyme level in your blood and detects liver diseases</p>
                            <?php if ($liverResults['alkaline_phosphatase_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['alkaline_phosphatase_impact_on_health'] != '') ? $liverResults['alkaline_phosphatase_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>
            <?php if ($liverResults['ggt_result_found_view'] == 1) { ?>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $liverResults['ggt_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($liverResults['ggt_result_value'] != '') ? $liverResults['ggt_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($liverResults['ggt_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($liverResults['ggt_result_value'] < $liverResults['ggt_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['ggt_result_value'] >= $liverResults['ggt_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $liverResults['ggt_color_code']; ?> image-ressult">
                                            <?php echo (($liverResults['ggt_result_value_in_words'] != '') ? $liverResults['ggt_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>

                                <table class="mediacal-update">
                                    <!-- <tr>
                                            <td>Range</td>
                                            <td>: &#60; <?php echo $liverResults['ggt_high_result_value'] . " " . $liverResults['ggt_uom']; ?></td>
                                        </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($liverResults['ggt_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $liverResults['ggt_BRInterval_result_value'] . " " . $liverResults['ggt_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $liverResults['ggt_low_result_value'] . " - " . $liverResults['ggt_high_result_value'] . " " . $liverResults['ggt_uom']; ?> </td>
                                    <?php } ?>
                                </table>

                            </div>
                        </td>
                        <!-- Gamma Glutamyl Transferase (GGT) -->

                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Gamma Glutamyl Transferase (GGT)</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $liverResults['ggt_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($liverResults['ggt_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Gamma Glutamyl Transferase test look for liver disease and damage in Bile duct</p>
                                <?php if ($liverResults['ggt_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($liverResults['ggt_impact_on_health'] != '') ? $liverResults['ggt_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>

                    </tr>
                </table>
            <?php } ?>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['total_protein_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['total_protein_result_value'] != '') ? $liverResults['total_protein_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['total_protein_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['total_protein_result_value'] < $liverResults['total_protein_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['total_protein_result_value'] >= $liverResults['total_protein_low_result_value']  && $liverResults['total_protein_result_value'] <= $liverResults['total_protein_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['total_protein_result_value'] > $liverResults['total_protein_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['total_protein_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['total_protein_result_value_in_words'] != '') ? $liverResults['total_protein_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $liverResults['total_protein_low_result_value'] . " - " . $liverResults['total_protein_high_result_value'] . " " . $liverResults['total_protein_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($liverResults['total_protein_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $liverResults['total_protein_BRInterval_result_value'] . " " . $liverResults['total_protein_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $liverResults['total_protein_low_result_value'] . " - " . $liverResults['total_protein_high_result_value'] . " " . $liverResults['total_protein_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Total Protein -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Total Protein</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['total_protein_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['total_protein_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Total Protein test is used to evaluate total protein levels in your blood
                                Total Protein: Majority of Proteins are produced by your liver. Total protein measures
                                the combined levels of Albumin & Globulin in your blood. </p>
                            <?php if ($liverResults['total_protein_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['total_protein_impact_on_health'] != '') ? $liverResults['total_protein_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>

        </div>

        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['LFT.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['albumin_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['albumin_result_value'] != '') ? $liverResults['albumin_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['albumin_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['albumin_result_value'] < $liverResults['albumin_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['albumin_result_value'] >= $liverResults['albumin_low_result_value'] && $liverResults['albumin_result_value'] <= $liverResults['albumin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['albumin_result_value'] > $liverResults['albumin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['albumin_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['albumin_result_value_in_words'] != '') ? $liverResults['albumin_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <?php if (!empty($liverResults['albumin_BRInterval_result_value'])) { ?>
                                    <?php
                                    foreach ($liverResults['albumin_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "<td>" . $liverResults['albumin_uom'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                <?php } else { ?>
                                    <td>Range</td>
                                    <td> : <?php echo $liverResults['albumin_low_result_value'] . " - " . $liverResults['albumin_high_result_value'] . " " . $liverResults['albumin_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Albumin -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Albumin</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['albumin_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['albumin_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Albumin test is used to measure the levels of Albumin protein in your blood. This test
                                monitor the liver health</p>
                            <?php if ($liverResults['albumin_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['albumin_impact_on_health'] != '') ? $liverResults['albumin_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['globulin_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['globulin_result_value'] != '') ? $liverResults['globulin_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($liverResults['globulin_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['globulin_result_value'] < $liverResults['globulin_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['globulin_result_value'] >= $liverResults['globulin_low_result_value'] && $liverResults['globulin_result_value'] <= $liverResults['globulin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['globulin_result_value'] > $liverResults['globulin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['globulin_color_code']; ?> image-ressult"><?php echo (($liverResults['globulin_result_value_in_words'] != '') ? $liverResults['globulin_result_value_in_words'] : '') ?></td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $liverResults['globulin_low_result_value'] . " - " . $liverResults['globulin_high_result_value'] . " " . $liverResults['globulin_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($liverResults['globulin_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $liverResults['globulin_BRInterval_result_value'] . " " . $liverResults['globulin_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $liverResults['globulin_low_result_value'] . " - " . $liverResults['globulin_high_result_value'] . " " . $liverResults['globulin_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Globulin -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Globulin</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['globulin_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['globulin_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Globulin is a protein produced by your liver. This test measure the levels of Globulin in
                                your blood Globulins are a group of proteins that is made by your immune system in your
                                blood. Globulin test helps in identifying liver disease or damage</p>
                            <?php if ($liverResults['globulin_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['globulin_impact_on_health'] != '') ? $liverResults['globulin_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>

                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $liverResults['ag_ratio_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($liverResults['ag_ratio_result_value'] != '') ? $liverResults['ag_ratio_result_value'] : '') ?>
                                </span>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($liverResults['ag_ratio_result_value'] < $liverResults['ag_ratio_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['ag_ratio_result_value'] >= $liverResults['ag_ratio_low_result_value'] && $liverResults['ag_ratio_result_value'] <= $liverResults['ag_ratio_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($liverResults['ag_ratio_result_value'] > $liverResults['ag_ratio_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $liverResults['ag_ratio_color_code']; ?> image-ressult">
                                        <?php echo (($liverResults['ag_ratio_result_value_in_words'] != '') ? $liverResults['ag_ratio_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td>: <?php echo $liverResults['ag_ratio_low_result_value'] . " - " . $liverResults['ag_ratio_high_result_value'] . " "; ?> <?php echo htmlspecialchars($liverResults['ag_ratio_uom']); ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($liverResults['ag_ratio_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $liverResults['ag_ratio_BRInterval_result_value'] . " " . $liverResults['ag_ratio_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $liverResults['ag_ratio_low_result_value'] . " - " . $liverResults['ag_ratio_high_result_value'] . " " . $liverResults['ag_ratio_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- A/G Ratio -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">A : G Ratio</h4>
                                <p class="methodology" style="margin: 0;"> <?= $liverResults['ag_ratio_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($liverResults['ag_ratio_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Albumin to Globulin ratio used for comparison of concentration of Albumin & Globulin in
                                your blood</p>
                            <?php if ($liverResults['ag_ratio_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($liverResults['ag_ratio_impact_on_health'] != '') ? $liverResults['ag_ratio_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <?php if (($patientDetails['PackageCode'] == 'AYN_001') || ($patientDetails['PackageCode'] == 'AYN_018') || ($patientDetails['PackageCode'] == 'AYN_031')) { ?>
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $liverResults['amylase_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($liverResults['amylase_result_value'] != '') ? $liverResults['amylase_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($liverResults['amylase_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($liverResults['amylase_result_value'] < $liverResults['amylase_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['amylase_result_value'] >= $liverResults['amylase_low_result_value'] && $liverResults['amylase_result_value'] <= $liverResults['amylase_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($liverResults['amylase_result_value'] > $liverResults['amylase_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $liverResults['amylase_color_code']; ?> image-ressult">
                                            <?php echo (($liverResults['amylase_result_value_in_words'] != '') ? $liverResults['amylase_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php if ($patientDetails['patient_gender'] == 'Male') { ?>
                                    <table class="mediacal-update">
                                        <tr>
                                            <td>Range</td>
                                            <td> : <?php echo $liverResults['amylase_high_result_value'] . " " . htmlspecialchars($liverResults['amylase_uom']) ?> </td>
                                        </tr>
                                    </table>
                                <?php  } ?>
                                <?php if ($patientDetails['patient_gender'] == 'Female') { ?>
                                    <table class="mediacal-update">
                                        <tr>
                                            <td>Range</td>
                                            <td> : <?php echo $liverResults['amylase_high_result_value'] . " " . htmlspecialchars($liverResults['amylase_uom']) ?> </td>
                                        </tr>
                                    </table>
                                <?php  } ?>



                            </div>
                        </td>
                        <!-- Amylase, Serum -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Amylase, Serum</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $liverResults['amylase_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($liverResults['amylase_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $liverTestgroupdetails['LFT_liver_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">It is mainly used to diagnose problems with your pancreas, including pancreatitis , which is an inflammation of the pancreas.</p>
                                <?php if ($liverResults['amylase_impact_on_health'] != '') { ?>
                                    <h4 style="font-size: 18px;">Impact on health</h4>
                                    <p>
                                        <?php echo ($liverResults['amylase_impact_on_health'] != '') ? $liverResults['amylase_impact_on_health'] : '' ?>
                                    </p>
                                <?php } ?>

                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div style="padding-top: 5px;">
                <p class="sample-type-para">
                    <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Serum
                </p>
            </div>
            <?php if (
                !empty($liverTestgroupdetails['LFT_liver_remarks']) ||
                !empty($liverTestgroupdetails['A0011_liver_remarks'])
            ) { ?>
                <div style="padding-top: 2.5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                        <?= htmlspecialchars($liverTestgroupdetails['LFT_liver_remarks']) ?>
                        <?php if (
                            !empty($liverTestgroupdetails['LFT_liver_remarks']) &&
                            !empty($liverTestgroupdetails['A0011_liver_remarks'])
                        ): ?>
                            ,
                        <?php endif; ?>
                        <?= htmlspecialchars($liverTestgroupdetails['A0011_liver_remarks']) ?>
                    </p>
                </div>
            <?php } ?>
            <div>
                <p class="suggestions-para">
                    <span class="p-tag" style="font-size: 16px;">Suggestions :</span>
                    There is no specific diet or lifestyle change you can help to bring down your total protein. taking supplement can help to maintain levels
                    (1) Maintain healthy weight. (2) Eat balanced diet, (3) Exercise regularly (4) Avoid toxins (5) Use alcohol responsibly (6) Avoid contaminated needles (7) Get medical care if you’re exposed to blood (8) Practice safe sex. (9) Get vaccinated (10) Consult your physician if you get a abnormal value.
                </p>
            </div>
            <?php
            if (
                !empty($liverResults['bilirubin_total_test_remraks']) ||
                !empty($liverResults['bilirubin_direct_test_remraks']) ||
                !empty($liverResults['bilirubin_indirect_test_remraks']) ||
                !empty($liverResults['sgpt_alt_test_remraks']) ||
                !empty($liverResults['sgot_ast_test_remraks']) ||
                !empty($liverResults['alkaline_phosphatase_test_remraks']) ||
                !empty($liverResults['ggt_test_remraks']) ||
                !empty($liverResults['total_protein_test_remraks']) ||
                !empty($liverResults['globulin_test_remraks']) ||
                !empty($liverResults['albumin_test_remraks']) ||
                !empty($liverResults['ag_ratio_test_remraks']) ||
                !empty($liverResults['amylase_test_remraks'])

            ) {
            ?>
                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                        <span class="test-remarks suggestions-para sample-type-para">
                            <?php

                            $remarks = array_filter([
                                $liverResults['bilirubin_total_test_remraks'] ?? '',
                                $liverResults['bilirubin_direct_test_remraks'] ?? '',
                                $liverResults['bilirubin_indirect_test_remraks'] ?? '',
                                $liverResults['sgpt_alt_test_remraks'] ?? '',
                                $liverResults['sgot_ast_test_remraks'] ?? '',
                                $liverResults['alkaline_phosphatase_test_remraks'] ?? '',
                                $liverResults['ggt_test_remraks'] ?? '',
                                $liverResults['total_protein_test_remraks'] ?? '',
                                $liverResults['globulin_test_remraks'] ?? '',
                                $liverResults['albumin_test_remraks'] ?? '',
                                $liverResults['ag_ratio_test_remraks'] ?? '',
                                $liverResults['amylase_test_remraks'] ?? ''
                            ]);

                            echo htmlspecialchars(implode(', ', $remarks));
                            ?>
                        </span>
                    </p>
                </div>
            <?php } ?>
        </div>

        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['LFT.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0">
                <tr class="d-block">
                    <td>
                        <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-blood.png" alt="" style="padding-left: 10px; width:40px;" class="w-100">
                    </td>
                    <td style="padding-left: 15px;"> <span class="result-title <?= $bloodResults['blood-summary']; ?>">Blood</span></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="color: #414042;padding-left: 60px;">A complete blood count (CBC) analyses all types of cells and gives information about disorders like anaemia, immune system disorders, infections, etc</td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['hemoglobin_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['hemoglobin_result_value'] != '') ? $bloodResults['hemoglobin_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['hemoglobin_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['hemoglobin_result_value'] < $bloodResults['hemoglobin_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['hemoglobin_result_value'] >= $bloodResults['hemoglobin_low_result_value']  && $bloodResults['hemoglobin_result_value'] <= $bloodResults['hemoglobin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['hemoglobin_result_value'] >  $bloodResults['hemoglobin_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['hemoglobin_color_code']; ?> image-ressult">
                                        <?php echo (($bloodResults['hemoglobin_result_value_in_words'] != '') ? $bloodResults['hemoglobin_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['hemoglobin_low_result_value'] . " - " . $bloodResults['hemoglobin_high_result_value'] . " " . $bloodResults['hemoglobin_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['hemoglobin_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['hemoglobin_BRInterval_result_value'] . " " . $bloodResults['hemoglobin_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['hemoglobin_low_result_value'] . " - " . $bloodResults['hemoglobin_high_result_value'] . " " . $bloodResults['hemoglobin_uom']; ?> </td>
                                <?php } ?>
                            </table>

                        </div>
                    </td>
                    <!-- Hemoglobin -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Hemoglobin</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['hemoglobin_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($bloodResults['hemoglobin_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Hemoglobin test is done to detect Anemia, a condition in which blood have less no. of
                                RBCs Hemoglobin is the protein molecule in red blood cells that carries oxygen from the
                                lungs to the body's tissues and returns carbon dioxide from the tissues back to the
                                lungs. A hemoglobin test measures the amount of hemoglobin in your blood</p>
                            <?php if ($bloodResults['hemoglobin_impact_on_health'] != '') { ?>
                                <h4 style="font-size: 18px;">Impact on health</h4>
                                <p>
                                    <?php echo ($bloodResults['hemoglobin_impact_on_health'] != '') ? $bloodResults['hemoglobin_impact_on_health'] : '' ?>
                                </p>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['rbccount_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['rbccount_result_value'] != '') ? $bloodResults['rbccount_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['rbccount_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['rbccount_result_value'] < $bloodResults['rbccount_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['rbccount_result_value'] >= $bloodResults['rbccount_low_result_value'] && $bloodResults['rbccount_result_value'] <= $bloodResults['rbccount_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['rbccount_result_value'] > $bloodResults['rbccount_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['rbccount_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['rbccount_result_value_in_words'] != '') ? $bloodResults['rbccount_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <tr>
                                    <td>Range</td>
                                    <?php if (!empty($bloodResults['rbccount_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $bloodResults['rbccount_BRInterval_result_value'] . " " . $bloodResults['rbccount_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $bloodResults['rbccount_low_result_value'] . " - " . $bloodResults['rbccount_high_result_value'] . " " . $bloodResults['rbccount_uom']; ?> </td>
                                    <?php } ?>
                                </tr>
                            </table>

                        </div>
                    </td>
                    <!-- Erythrocyte Count- RBC -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0; width: auto; max-width: 65%; white-space: normal; word-wrap: break-word;">
                                    Erythrocyte Count- RBC
                                </h4>
                                <p class="methodology" style="margin: 0; flex-shrink: 0; white-space: nowrap;">
                                    <?= $bloodResults['rbccount_sample_method']; ?>
                                </p>
                            </div>

                            <p>Erythrocyte count or RBC test helps to quantify the amount of RBCs in your blood</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0px; display: flex; align-items: center; max-width: 30%;">
                                <?php if ($bloodResults['rbccount_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt=""
                                        style="width: auto; height: 40px; margin-left: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px; margin-left:10px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['hematocrit_pcv_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['hematocrit_pcv_result_value'] != '') ? $bloodResults['hematocrit_pcv_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['hematocrit_pcv_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['hematocrit_pcv_result_value'] < $bloodResults['hematocrit_pcv_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['hematocrit_pcv_result_value'] >= $bloodResults['hematocrit_pcv_low_result_value'] && $bloodResults['hematocrit_pcv_result_value'] <= $bloodResults['hematocrit_pcv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['hematocrit_pcv_result_value'] >  $bloodResults['hematocrit_pcv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['hematocrit_pcv_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['hematocrit_pcv_result_value_in_words'] != '') ? $bloodResults['hematocrit_pcv_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['hematocrit_pcv_low_result_value'] . " - " . $bloodResults['hematocrit_pcv_high_result_value'] . " " . $bloodResults['hematocrit_pcv_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['hematocrit_pcv_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['hematocrit_pcv_BRInterval_result_value'] . " " . $bloodResults['hematocrit_pcv_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['hematocrit_pcv_low_result_value'] . " - " . $bloodResults['hematocrit_pcv_high_result_value'] . " " . $bloodResults['hematocrit_pcv_uom']; ?> </td>
                                <?php } ?>
                            </table>

                        </div>
                    </td>
                    <!-- Hematocrit-PCV -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0; width: auto; max-width: 65%; white-space: normal; word-wrap: break-word;">
                                    Hematocrit-PCV
                                </h4>
                                <p class="methodology" style="margin: 0; flex-shrink: 0; white-space: nowrap;">
                                    <?= $bloodResults['hematocrit_pcv_sample_method']; ?>
                                </p>
                            </div>

                            <p>Hematocrit test measure the RBCs level in your blood in percentage</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0px; display: flex; align-items: center; max-width: 30%;">
                                <?php if ($bloodResults['hematocrit_pcv_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt=""
                                        style="width: auto; height: 40px; margin-left: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px; margin-left:10px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['corpuscular_volume_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['corpuscular_volume_result_value'] != '') ? $bloodResults['corpuscular_volume_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['corpuscular_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['corpuscular_volume_result_value'] < $bloodResults['corpuscular_volume_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['corpuscular_volume_result_value'] >= $bloodResults['corpuscular_volume_low_result_value'] && $bloodResults['corpuscular_volume_result_value'] <= $bloodResults['corpuscular_volume_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['corpuscular_volume_result_value'] > $bloodResults['corpuscular_volume_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['corpuscular_volume_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['corpuscular_volume_result_value_in_words'] != '') ? $bloodResults['corpuscular_volume_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['corpuscular_volume_low_result_value'] . " - " . $bloodResults['corpuscular_volume_high_result_value'] . " " . $bloodResults['corpuscular_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['corpuscular_volume_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['corpuscular_volume_BRInterval_result_value'] . " " . $bloodResults['corpuscular_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['corpuscular_volume_low_result_value'] . " - " . $bloodResults['corpuscular_volume_high_result_value'] . " " . $bloodResults['corpuscular_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Mean Corpuscular Volume-MCV -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Mean Corpuscular Volume-MCV</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['corpuscular_volume_sample_method']; ?> </p>
                            </div>
                            <p>Mean Corpuscular Volume test is used to evaluate the average size and volume of RBCs in
                                your blood. This test helps to understand anaemia conditions</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['corpuscular_volume_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['mchc_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['mchc_result_value'] != '') ? $bloodResults['mchc_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['mchc_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['mchc_result_value'] < $bloodResults['mchc_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mchc_result_value'] >= $bloodResults['mchc_low_result_value'] && $bloodResults['mchc_result_value'] <= $bloodResults['mchc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mchc_result_value'] > $bloodResults['mchc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['mchc_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['mchc_result_value_in_words'] != '') ? $bloodResults['mchc_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update" style="width: 87%;">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['mchc_low_result_value'] . " - " . $bloodResults['mchc_high_result_value'] . " " . $bloodResults['mchc_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['mchc_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['mchc_BRInterval_result_value'] . " " . $bloodResults['mchc_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['mchc_low_result_value'] . " - " . $bloodResults['mchc_high_result_value'] . " " . $bloodResults['mchc_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- MCHC -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">MCHC</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['mchc_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px">MCHC measures the average amount of hemoglobin present in a group of hemoglobin in your blood</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['mchc_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['red_cell_dist_cv_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['red_cell_dist_cv_result_value'] != '') ? $bloodResults['red_cell_dist_cv_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['red_cell_dist_cv_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['red_cell_dist_cv_result_value'] < $bloodResults['red_cell_dist_cv_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['red_cell_dist_cv_result_value'] >= $bloodResults['red_cell_dist_cv_low_result_value'] && $bloodResults['red_cell_dist_cv_result_value'] <= $bloodResults['red_cell_dist_cv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['red_cell_dist_cv_result_value'] > $bloodResults['red_cell_dist_cv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['red_cell_dist_cv_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['red_cell_dist_cv_result_value_in_words'] != '') ? $bloodResults['red_cell_dist_cv_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update" style="width: 80%;">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['red_cell_dist_cv_low_result_value'] . " - " . $bloodResults['red_cell_dist_cv_high_result_value'] . " " . $bloodResults['red_cell_dist_cv_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['red_cell_dist_cv_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['red_cell_dist_cv_BRInterval_result_value'] . " " . $bloodResults['red_cell_dist_cv_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['red_cell_dist_cv_low_result_value'] . " - " . $bloodResults['red_cell_dist_cv_high_result_value'] . " " . $bloodResults['red_cell_dist_cv_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Red Cell Distribution Width CV -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Red Cell Distribution Width CV</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['red_cell_dist_cv_sample_method']; ?> </p>
                            </div>
                            <p>Red Cell Distribution Width CV is used to diagnose anaemia</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['red_cell_dist_cv_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px; padding-bottom:20%;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['red_cell_dist_sd_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['red_cell_dist_sd_result_value'] != '') ? $bloodResults['red_cell_dist_sd_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['red_cell_dist_sd_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['red_cell_dist_sd_result_value'] < $bloodResults['red_cell_dist_sd_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['red_cell_dist_sd_result_value'] >= $bloodResults['red_cell_dist_sd_low_result_value'] && $bloodResults['red_cell_dist_sd_result_value'] <= $bloodResults['red_cell_dist_sd_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['red_cell_dist_sd_result_value'] > $bloodResults['red_cell_dist_sd_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['red_cell_dist_sd_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['red_cell_dist_sd_result_value_in_words'] != '') ? $bloodResults['red_cell_dist_sd_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['red_cell_dist_sd_low_result_value'] . " - " . $bloodResults['red_cell_dist_sd_high_result_value'] . " " . $bloodResults['red_cell_dist_sd_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['red_cell_dist_sd_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['red_cell_dist_sd_BRInterval_result_value'] . " " . $bloodResults['red_cell_dist_sd_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['red_cell_dist_sd_low_result_value'] . " - " . $bloodResults['red_cell_dist_sd_high_result_value'] . " " . $bloodResults['red_cell_dist_sd_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Red Cell Distribution Width SD -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Red Cell Distribution Width SD</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['red_cell_dist_sd_sample_method']; ?> </p>
                            </div>
                            <p>Red Cell Distribution Width SD is used to rule out conditions like infections, and
                                malnutrition in your body</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -13px; display: flex; align-items: center;">

                                <?php if ($bloodResults['red_cell_dist_sd_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>

        </div>
        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['CBC.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div style="white-space: nowrap;">
                                <span class="<?= $bloodResults['leukocytes_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['leukocytes_count_result_value'] != '') ? $bloodResults['leukocytes_count_result_value'] : '') ?>
                                </span>
                                <span style="font-size: 16px;">
                                    <?php echo htmlspecialchars($bloodResults['leukocytes_count_uom']); ?>
                                </span>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['leukocytes_count_result_value'] < $bloodResults['leukocytes_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['leukocytes_count_result_value'] >= $bloodResults['leukocytes_count_low_result_value'] && $bloodResults['leukocytes_count_result_value'] <=  $bloodResults['leukocytes_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['leukocytes_count_result_value'] > $bloodResults['leukocytes_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['leukocytes_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['leukocytes_count_result_value_in_words'] != '') ? $bloodResults['leukocytes_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td style="width:75%;"> : <?php echo $bloodResults['leukocytes_count_low_result_value'] . " - " . $bloodResults['leukocytes_count_high_result_value'] . " " . $bloodResults['leukocytes_count_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['leukocytes_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['leukocytes_count_BRInterval_result_value'] . " " . $bloodResults['leukocytes_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['leukocytes_count_low_result_value'] . " - " . $bloodResults['leukocytes_count_high_result_value'] . " " . $bloodResults['leukocytes_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Leucocytes Count - WBC Total -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0; width: auto; max-width: 65%; white-space: normal; word-wrap: break-word;">
                                    Leucocytes Count - WBC Total
                                </h4>
                                <p class="methodology" style="margin: 0; flex-shrink: 0; white-space: nowrap;">
                                    <?= $bloodResults['leukocytes_count_sample_method']; ?>
                                </p>
                            </div>

                            <p>Leucocytes count or WBC test help to quantify the amount of RBCs in your blood</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0px; display: flex; align-items: center; max-width: 30%;">
                                <?php if ($bloodResults['leukocytes_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt=""
                                        style="width: auto; height: 40px; margin-left: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px; margin-left:10px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['neutrophils_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['neutrophils_result_value'] != '') ? $bloodResults['neutrophils_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['neutrophils_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['neutrophils_result_value'] < $bloodResults['neutrophils_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['neutrophils_result_value'] >= $bloodResults['neutrophils_low_result_value'] && $bloodResults['neutrophils_result_value'] <= $bloodResults['neutrophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['neutrophils_result_value'] > $bloodResults['neutrophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['neutrophils_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['neutrophils_result_value_in_words'] != '') ? $bloodResults['neutrophils_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['neutrophils_low_result_value'] . " - " . $bloodResults['neutrophils_high_result_value'] . " " . $bloodResults['neutrophils_count_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['neutrophils_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['neutrophils_BRInterval_result_value'] . " " . $bloodResults['neutrophils_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['neutrophils_low_result_value'] . " - " . $bloodResults['neutrophils_high_result_value'] . " " . $bloodResults['neutrophils_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Neutrophils -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0;">Neutrophils</h4>
                                <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                    <?= $bloodResults['neutrophils_sample_method']; ?>
                                </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <?php if ($bloodResults['neutrophils_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                <div style="position: absolute; top: -5px; right: -10px; display: flex; align-items: center;">
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                </div>
                                <style>
                                    /* Adjust methodology styling when NABL logo is present */
                                    .methodology {
                                        max-width: 100%;
                                        /* Allow it to take full width */
                                        display: block;
                                        white-space: normal;
                                    }
                                </style>
                            <?php endif; ?>

                            <p style="margin-top: 5px;">Neutrophils checks body’s ability to fight against infection, mostly bacterial infection</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['lymphocyte_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['lymphocyte_result_value'] != '') ? $bloodResults['lymphocyte_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['lymphocyte_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['lymphocyte_result_value'] < $bloodResults['lymphocyte_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lymphocyte_result_value'] >= $bloodResults['lymphocyte_low_result_value'] && $bloodResults['lymphocyte_result_value'] <= $bloodResults['lymphocyte_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lymphocyte_result_value'] > $bloodResults['lymphocyte_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['lymphocyte_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['lymphocyte_result_value_in_words'] != '') ? $bloodResults['lymphocyte_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['lymphocyte_low_result_value'] . " - " . $bloodResults['lymphocyte_high_result_value'] . " " . $bloodResults['lymphocyte_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['lymphocyte_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['lymphocyte_BRInterval_result_value'] . " " . $bloodResults['lymphocyte_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['lymphocyte_low_result_value'] . " - " . $bloodResults['lymphocyte_high_result_value'] . " " . $bloodResults['lymphocyte_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Lymphocyte -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0;">Lymphocyte</h4>
                                <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                    <?= $bloodResults['lymphocyte_sample_method']; ?>
                                </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <?php if ($bloodResults['lymphocyte_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                <div style="position: absolute; top: -5px; right: -10px; display: flex; align-items: center;">
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                </div>
                                <style>
                                    /* Adjust methodology styling when NABL logo is present */
                                    .methodology {
                                        max-width: 100%;
                                        /* Allow it to take full width */
                                        display: block;
                                        white-space: normal;
                                    }
                                </style>
                            <?php endif; ?>

                            <p style="margin-top: 5px;">Lymphocyte test checks levels of Lymphocytes in the blood</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['monocytes_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['monocytes_result_value'] != '') ? $bloodResults['monocytes_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['monocytes_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['monocytes_result_value'] < $bloodResults['monocytes_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['monocytes_result_value'] >= $bloodResults['monocytes_low_result_value'] && $bloodResults['monocytes_result_value'] <= $bloodResults['monocytes_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['monocytes_result_value'] > $bloodResults['monocytes_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['monocytes_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['monocytes_result_value_in_words'] != '') ? $bloodResults['monocytes_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> :<?php echo $bloodResults['monocytes_low_result_value'] . " - " . $bloodResults['monocytes_high_result_value'] . " " . $bloodResults['monocytes_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['monocytes_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['monocytes_BRInterval_result_value'] . " " . $bloodResults['monocytes_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['monocytes_low_result_value'] . " - " . $bloodResults['monocytes_high_result_value'] . " " . $bloodResults['monocytes_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Monocytes -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0;">Monocytes</h4>
                                <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                    <?= $bloodResults['monocytes_sample_method']; ?>
                                </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <?php if ($bloodResults['monocytes_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                <div style="position: absolute; top: -5px; right: -10px; display: flex; align-items: center;">
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                </div>
                                <style>
                                    /* Adjust methodology styling when NABL logo is present */
                                    .methodology {
                                        max-width: 100%;
                                        /* Allow it to take full width */
                                        display: block;
                                        white-space: normal;
                                    }
                                </style>
                            <?php endif; ?>

                            <p style="margin-top: 5px;">Monocytes test checks levels of Monocytes in the blood</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['eosinophils_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['eosinophils_result_value'] != '') ? $bloodResults['eosinophils_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['eosinophils_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['eosinophils_result_value'] < $bloodResults['eosinophils_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['eosinophils_result_value'] >= $bloodResults['eosinophils_low_result_value'] && $bloodResults['eosinophils_result_value'] <= $bloodResults['eosinophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['eosinophils_result_value'] > $bloodResults['eosinophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['eosinophils_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['eosinophils_result_value_in_words'] != '') ? $bloodResults['eosinophils_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['eosinophils_low_result_value'] . " - " . $bloodResults['eosinophils_high_result_value'] . " " . $bloodResults['eosinophils_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['eosinophils_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['eosinophils_BRInterval_result_value'] . " " . $bloodResults['eosinophils_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['eosinophils_low_result_value'] . " - " . $bloodResults['eosinophils_high_result_value'] . " " . $bloodResults['eosinophils_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Eosinophils -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0;">Eosinophils</h4>
                                <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                    <?= $bloodResults['eosinophils_sample_method']; ?>
                                </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <?php if ($bloodResults['eosinophils_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                <div style="position: absolute; top: -5px; right: -10px; display: flex; align-items: center;">
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                </div>
                                <style>
                                    /* Adjust methodology styling when NABL logo is present */
                                    .methodology {
                                        max-width: 100%;
                                        /* Allow it to take full width */
                                        display: block;
                                        white-space: normal;
                                    }
                                </style>
                            <?php endif; ?>

                            <p style="margin-top: 5px;">Eosinophil test confirms the presence or absence of infection</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['basophils_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['basophils_result_value'] != '') ? $bloodResults['basophils_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['basophils_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ((float)$bloodResults['basophils_result_value'] < (float) $bloodResults['basophils_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ((float)$bloodResults['basophils_result_value'] >= (float) $bloodResults['basophils_low_result_value'] && (float) $bloodResults['basophils_result_value'] <= (float) $bloodResults['basophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ((float)$bloodResults['basophils_result_value'] > (float) $bloodResults['basophils_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['basophils_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['basophils_result_value_in_words'] != '') ? $bloodResults['basophils_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['basophils_low_result_value'] . " - " . $bloodResults['basophils_high_result_value'] . " " . $bloodResults['basophils_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['basophils_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['basophils_BRInterval_result_value'] . " " . $bloodResults['basophils_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['basophils_low_result_value'] . " - " . $bloodResults['basophils_high_result_value'] . " " . $bloodResults['basophils_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Basophils -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                <h4 style="margin: 0;">Basophils</h4>
                                <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                    <?= $bloodResults['basophils_sample_method']; ?>
                                </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <?php if ($bloodResults['basophils_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                <div style="position: absolute; top: -5px; right: -10px; display: flex; align-items: center;">
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                </div>
                                <style>
                                    /* Adjust methodology styling when NABL logo is present */
                                    .methodology {
                                        max-width: 100%;
                                        /* Allow it to take full width */
                                        display: block;
                                        white-space: normal;
                                    }
                                </style>
                            <?php endif; ?>

                            <p style="margin-top: 5px;">Basophils checks the level of basophil in your blood</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['neutrophils_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['neutrophils_count_result_value'] != '') ? $bloodResults['neutrophils_count_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['neutrophils_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['neutrophils_count_result_value'] < $bloodResults['neutrophils_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['neutrophils_count_result_value'] >= $bloodResults['neutrophils_count_low_result_value'] && $bloodResults['neutrophils_count_result_value'] <= $bloodResults['neutrophils_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['neutrophils_count_result_value'] > $bloodResults['neutrophils_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['neutrophils_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['neutrophils_count_result_value_in_words'] != '') ? $bloodResults['neutrophils_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update" style="padding-left: 10px;">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td style="width:80%;"> : <?php echo $bloodResults['neutrophils_count_low_result_value'] . " - " . $bloodResults['neutrophils_count_high_result_value'] . " " . $bloodResults['neutrophils_count_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['neutrophils_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['neutrophils_count_BRInterval_result_value'] . " " . $bloodResults['neutrophils_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['neutrophils_count_low_result_value'] . " - " . $bloodResults['neutrophils_count_high_result_value'] . " " . $bloodResults['neutrophils_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Absolute Neutrophils Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Absolute Neutrophils Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['neutrophils_count_sample_method']; ?> </p>
                            </div>
                            <p>Absolute Neutrophils Count or ANC is a test which checks body’s ability to fight against
                                infection, mostly bacterial infection</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -13px; display: flex; align-items: center;">

                                <?php if ($bloodResults['neutrophils_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['lymphocyte_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['lymphocyte_count_result_value'] != '') ? $bloodResults['lymphocyte_count_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['lymphocyte_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['lymphocyte_count_result_value'] < $bloodResults['lymphocyte_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lymphocyte_count_result_value'] >= $bloodResults['lymphocyte_count_low_result_value'] && $bloodResults['lymphocyte_count_result_value'] <= $bloodResults['lymphocyte_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lymphocyte_count_result_value'] > $bloodResults['lymphocyte_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <td class="<?= $bloodResults['lymphocyte_count_color_code']; ?> image-ressult">
                                        <?php echo (($bloodResults['lymphocyte_count_result_value_in_words'] != '') ? $bloodResults['lymphocyte_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['lymphocyte_count_low_result_value'] . " - " . $bloodResults['lymphocyte_count_high_result_value'] . " " . $bloodResults['lymphocyte_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['lymphocyte_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['lymphocyte_count_BRInterval_result_value'] . " " . $bloodResults['lymphocyte_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['+lymphocyte_count_low_result_value'] . " - " . $bloodResults['lymphocyte_count_high_result_value'] . " " . $bloodResults['lymphocyte_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Absolute Lymphocyte Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Absolute Lymphocyte Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['lymphocyte_count_sample_method']; ?> </p>
                            </div>
                            <p>Absolute Lymphocyte Count test checks levels of Lymphocytes in the blood. This test is
                                used to check the presence of infection</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -17px; display: flex; align-items: center;">

                                <?php if ($bloodResults['lymphocyte_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['monocyte_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['monocyte_count_result_value'] != '') ? $bloodResults['monocyte_count_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['monocyte_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['monocyte_count_result_value'] < $bloodResults['monocyte_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['monocyte_count_result_value'] >= $bloodResults['monocyte_count_low_result_value'] && $bloodResults['monocyte_count_result_value'] <= $bloodResults['monocyte_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['monocyte_count_result_value'] > $bloodResults['monocyte_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['monocyte_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['monocyte_count_result_value_in_words'] != '') ? $bloodResults['monocyte_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update" style="padding-left: 10px;">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td style="width:80%;">: <?php echo $bloodResults['monocyte_count_low_result_value'] . " - " . $bloodResults['monocyte_count_high_result_value'] . " " . $bloodResults['monocyte_count_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['monocyte_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['monocyte_count_BRInterval_result_value'] . " " . $bloodResults['monocyte_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['monocyte_count_low_result_value'] . " - " . $bloodResults['monocyte_count_high_result_value'] . " " . $bloodResults['monocyte_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Absolute Monocyte Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Absolute Monocyte Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['monocyte_count_sample_method']; ?> </p>
                            </div>
                            <p>Absolute Monocyte Count checks confirm the infection WBCs.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -13px; display: flex; align-items: center;">

                                <?php if ($bloodResults['monocyte_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>

            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px; padding-bottom:8%;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>

                                <span class="<?= $bloodResults['eosinophil_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['eosinophil_count_result_value'] != '') ? $bloodResults['eosinophil_count_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['eosinophil_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['eosinophil_count_result_value'] < $bloodResults['eosinophil_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['eosinophil_count_result_value'] >= $bloodResults['eosinophil_count_low_result_value'] && $bloodResults['eosinophil_count_result_value'] <= $bloodResults['eosinophil_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['eosinophil_count_result_value'] > $bloodResults['eosinophil_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['eosinophil_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['eosinophil_count_result_value_in_words'] != '') ? $bloodResults['eosinophil_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['eosinophil_count_low_result_value'] . " - " . $bloodResults['eosinophil_count_high_result_value'] . " " . $bloodResults['eosinophil_count_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['eosinophil_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['eosinophil_count_BRInterval_result_value'] . " " . $bloodResults['eosinophil_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['eosinophil_count_low_result_value'] . " - " . $bloodResults['eosinophil_count_high_result_value'] . " " . $bloodResults['eosinophil_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Absolute Eosinophil Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Absolute Eosinophil Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['eosinophil_count_sample_method']; ?> </p>
                            </div>
                            <p>Absolute Eosinophil Count test checks for levels of Eosinophils. This test confirms the
                                presence or absence of infection</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -13px; display: flex; align-items: center;">

                                <?php if ($bloodResults['eosinophil_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                    </td>
                </tr>
            </table>

        </div>

        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['CBC.'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>


            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>

                                <span class="<?= $bloodResults['basophil_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['basophil_count_result_value'] != '') ? $bloodResults['basophil_count_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['basophil_count_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ((float)$bloodResults['basophil_count_result_value'] < $bloodResults['basophil_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ((float)$bloodResults['basophil_count_result_value'] >= $bloodResults['basophil_count_low_result_value'] && (float) $bloodResults['basophil_count_result_value'] <= $bloodResults['basophil_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ((float)$bloodResults['basophil_count_result_value'] > $bloodResults['basophil_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['basophil_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['basophil_count_result_value_in_words'] != '') ? $bloodResults['basophil_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['basophil_count_low_result_value'] . " - " . $bloodResults['basophil_count_high_result_value'] . " " . $bloodResults['basophil_count_uom']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['basophil_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['basophil_count_BRInterval_result_value'] . " " . $bloodResults['basophil_count_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['basophil_count_low_result_value'] . " - " . $bloodResults['basophil_count_high_result_value'] . " " . $bloodResults['basophil_count_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Absolute Basophil Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Absolute Basophil <br> Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['basophil_count_sample_method']; ?> </p>
                            </div>
                            <p>Absolute Basophil Count test checks for levels of Basophils. This test confirms the
                                presence or absence of infection.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['basophil_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['platelets_count_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['platelets_count_result_value'] != '') ? $bloodResults['platelets_count_result_value'] : '') ?>
                                </span>
                                <span style="color: black; font-size: 16px;"><?php echo htmlspecialchars($bloodResults['platelets_count_units']); ?></span>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['platelets_count_result_value'] < $bloodResults['platelets_count_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['platelets_count_result_value'] >= $bloodResults['platelets_count_low_result_value'] && $bloodResults['platelets_count_result_value'] <= $bloodResults['platelets_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['platelets_count_result_value'] > $bloodResults['platelets_count_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <td class="<?= $bloodResults['platelets_count_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['platelets_count_result_value_in_words'] != '') ? $bloodResults['platelets_count_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['platelets_count_low_result_value'] . " - " . $bloodResults['platelets_count_high_result_value'] . " " . $bloodResults['platelets_count_units']; ?></td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['platelets_count_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['platelets_count_BRInterval_result_value'] . " " . $bloodResults['platelets_count_units']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['platelets_count_low_result_value'] . " - " . $bloodResults['platelets_count_high_result_value'] . " " . $bloodResults['platelets_count_units']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Platelet Count -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Platelet Count</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['platelets_count_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px">Platelets are the cell that helps in blood clotting. This test is used to check the levels of platelets in your blood.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['platelets_count_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['mpv_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['mpv_result_value'] != '') ? $bloodResults['mpv_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['mpv_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['mpv_result_value'] < $bloodResults['mpv_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mpv_result_value'] >= $bloodResults['mpv_low_result_value'] && $bloodResults['mpv_result_value'] <= $bloodResults['mpv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mpv_result_value'] > $bloodResults['mpv_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['mpv_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['mpv_result_value_in_words'] != '') ? $bloodResults['mpv_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['mpv_low_result_value'] . " - " . $bloodResults['mpv_high_result_value'] . " " . $bloodResults['mpv_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['mpv_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['mpv_BRInterval_result_value'] . " " . $bloodResults['mpv_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['mpv_low_result_value'] . " - " . $bloodResults['mpv_high_result_value'] . " " . $bloodResults['mpv_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- MPV -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">MPV</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['mpv_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px">MPV measures the average amount of platelets present in blood. This test helps in detection of bleeding & bone marrow disorders</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['mpv_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['pdw_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['pdw_result_value'] != '') ? $bloodResults['pdw_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['pdw_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['pdw_result_value'] < $bloodResults['pdw_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['pdw_result_value'] >= $bloodResults['pdw_low_result_value'] && $bloodResults['pdw_result_value'] <= $bloodResults['pdw_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['pdw_result_value'] > $bloodResults['pdw_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['pdw_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['pdw_result_value_in_words'] != '') ? $bloodResults['pdw_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['pdw_low_result_value'] . " - " . $bloodResults['pdw_high_result_value'] . " " . $bloodResults['pdw_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['pdw_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['pdw_BRInterval_result_value'] . " " . $bloodResults['pdw_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['pdw_low_result_value'] . " - " . $bloodResults['pdw_high_result_value'] . " " . $bloodResults['pdw_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- PDW -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">PDW</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['pdw_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px">PWD is one of the markers to check function & activation of platelets. PDW test check for
                                variability in the size of platelets.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['pdw_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail" style="min-height: 167px;">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['platelet_crit_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['platelet_crit_result_value'] != '') ? $bloodResults['platelet_crit_result_value'] : '') ?>
                                </span> <?php echo htmlspecialchars($bloodResults['platelet_crit_uom']); ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['platelet_crit_result_value'] < $bloodResults['platelet_crit_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['platelet_crit_result_value'] >= $bloodResults['platelet_crit_low_result_value'] && $bloodResults['platelet_crit_result_value'] <= $bloodResults['platelet_crit_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['platelet_crit_result_value'] > $bloodResults['platelet_crit_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['platelet_crit_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['platelet_crit_result_value_in_words'] != '') ? $bloodResults['platelet_crit_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['platelet_crit_low_result_value'] . " - " . $bloodResults['platelet_crit_high_result_value'] . " " . $bloodResults['platelet_crit_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['platelet_crit_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['platelet_crit_BRInterval_result_value'] . " " . $bloodResults['platelet_crit_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['platelet_crit_low_result_value'] . " - " . $bloodResults['platelet_crit_high_result_value'] . " " . $bloodResults['platelet_crit_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Platelet Crit -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">Platelet Crit</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['platelet_crit_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['platelet_crit_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style="padding-left: 10px;">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail" style="min-height: 167px;">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['mch_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['mch_result_value'] != '') ? $bloodResults['mch_result_value'] : '') ?>
                                </span> <?php echo htmlspecialchars($bloodResults['mch_uom']); ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['mch_result_value'] < $bloodResults['mch_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mch_result_value'] >= $bloodResults['mch_low_result_value'] && $bloodResults['mch_result_value'] <=  $bloodResults['mch_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['mch_result_value'] >  $bloodResults['mch_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['mch_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['mch_result_value_in_words'] != '') ? $bloodResults['mch_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $bloodResults['mch_low_result_value'] . " - " . $bloodResults['mch_high_result_value'] . " " . $bloodResults['mch_uom']; ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($bloodResults['mch_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $bloodResults['mch_BRInterval_result_value'] . " " . $bloodResults['mch_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $bloodResults['mch_low_result_value'] . " - " . $bloodResults['mch_high_result_value'] . " " . $bloodResults['mch_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- MCH (Mean Corpuscular Hb) -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">MCH (Mean <br> Corpuscular Hb)</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['mch_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px;">Mean corpuscular hemoglobin (MCH) refers to the amount of hemoglobin in a red blood cell. High or low numbers may indicate a vitamin deficiency or certain types of anemia.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['mch_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['CBC_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail" style="min-height: 167px;">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['erythrocyte_sedimentation_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['erythrocyte_sedimentation_result_value'] != '') ? $bloodResults['erythrocyte_sedimentation_result_value'] : '') ?>
                                </span> <?php echo htmlspecialchars($bloodResults['erythrocyte_sedimentation_uom']); ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($bloodResults['erythrocyte_sedimentation_result_value'] < $bloodResults['erythrocyte_sedimentation_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['erythrocyte_sedimentation_result_value'] >= $bloodResults['erythrocyte_sedimentation_low_result_value'] && $bloodResults['erythrocyte_sedimentation_result_value'] <= $bloodResults['erythrocyte_sedimentation_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['erythrocyte_sedimentation_result_value'] > $bloodResults['erythrocyte_sedimentation_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['erythrocyte_sedimentation_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['erythrocyte_sedimentation_result_value_in_words'] != '') ? $bloodResults['erythrocyte_sedimentation_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <tr>
                                    <td>Range </td>
                                    <td> : &#60;= <?php echo $bloodResults['erythrocyte_sedimentation_high_result_value'] . " " . $bloodResults['erythrocyte_sedimentation_uom']; ?> </td>
                                </tr>

                            </table>
                        </div>
                    </td>
                    <!-- ESR, EDTA Blood -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">ESR, EDTA Blood</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['erythrocyte_sedimentation_sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px;">ESR is an acute phase reactant indicating presence and intensity of an inflammatory process.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">
                                <?php if ($bloodResults['erythrocyte_sedimentation_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['E0005_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
        </div>

        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['CBC.', 'E0005'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>
    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>



            <table cellspacing="0" cellpadding="0" class="graphBArContentSection w-50">
                <tr>
                    <td class="leftPanel blood">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $bloodResults['lactate_dehydragenase_LDH_serum__color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($bloodResults['lactate_dehydragenase_LDH_serum__result_value'] != '') ? $bloodResults['lactate_dehydragenase_LDH_serum__result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($bloodResults['lactate_dehydragenase_LDH_serum_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>

                                    <?php if ($bloodResults['lactate_dehydragenase_LDH_serum__result_value'] < $bloodResults['lactate_dehydragenase_LDH_serum_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lactate_dehydragenase_LDH_serum__result_value'] >= $bloodResults['lactate_dehydragenase_LDH_serum_low_result_value'] && $bloodResults['lactate_dehydragenase_LDH_serum__result_value'] <= $bloodResults['lactate_dehydragenase_LDH_serum_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($bloodResults['lactate_dehydragenase_LDH_serum__result_value'] > $bloodResults['lactate_dehydragenase_LDH_serum_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $bloodResults['lactate_dehydragenase_LDH_serum__color_code']; ?> image-ressult" style="padding-left: 10px;">
                                        <?php echo (($bloodResults['lactate_dehydragenase_LDH_serum__result_value_in_words'] != '') ? $bloodResults['lactate_dehydragenase_LDH_serum__result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <?php if (!empty($bloodResults['lactate_dehydragenase_LDH_serum_BRInterval_result_value'])) { ?>
                                    <?php
                                    foreach ($bloodResults['lactate_dehydragenase_LDH_serum_reference_ranges_value'] as $label => $range) {
                                        echo "<tr>";
                                        echo "<td>" . ucwords($label) . "</td>";
                                        echo "<td>: $range</td>";
                                        echo "<td>" . $bloodResults['lactate_dehydragenase_LDH_serum_uom'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                <?php } else { ?>
                                    <td>Range</td>
                                    <td> : <?php echo $bloodResults['lactate_dehydragenase_LDH_serum_low_result_value'] . " - " . $bloodResults['lactate_dehydragenase_LDH_serum_high_result_value'] . " " . $bloodResults['lactate_dehydragenase_LDH_serum_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Lactatedehydragenase (LDH), Serum -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin-right: 5px;">LDH (Lactate <br> dehydragenase)</h4>
                                <p class="methodology" style="margin: 0;"> <?= $bloodResults['lactate_dehydragenase_LDH_serum__sample_method']; ?> </p>
                            </div>
                            <p style="margin-top:5px;">LDH levels that are higher than normal usually mean that there is some type of tissue damage. The damage is usually from disease, infection, or injury.</p>

                            <!-- NABL Logo and Code Positioned Absolutely -->

                            <div style="position: absolute; top: -5px; right: -10PX; display: flex; align-items: center;">

                                <?php if ($bloodResults['lactate_dehydragenase_LDH_serum_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $bloodTestgroupdetails['L0002_blood_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </td>
                </tr>
            </table>
            <div style="padding-top: 5px;">
                <p class="sample-type-para">
                    <span class="p-tag" style="font-size: 16px;">Sample Type :</span> EDTA Whole Blood
                </p>
            </div>
            <?php if (!empty($bloodTestgroupdetails['CBC_blood_remarks']) || !empty($bloodTestgroupdetails['E0005_blood_remarks']) || !empty($bloodTestgroupdetails['L0002_blood_remarks'])) { ?>
                <div style="padding-top: 2.5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                        <?= htmlspecialchars($bloodTestgroupdetails['CBC_blood_remarks']) ?>
                        <?php if (!empty($bloodTestgroupdetails['CBC_blood_remarks']) && !empty($bloodTestgroupdetails['E0005_blood_remarks'])): ?>
                            ,
                        <?php endif; ?>
                        <?= htmlspecialchars($bloodTestgroupdetails['E0005_blood_remarks']) ?>
                        <?php if ((!empty($bloodTestgroupdetails['CBC_blood_remarks']) || !empty($bloodTestgroupdetails['E0005_blood_remarks'])) && !empty($bloodTestgroupdetails['L0002_blood_remarks'])): ?>
                            ,
                        <?php endif; ?>
                        <?= htmlspecialchars($bloodTestgroupdetails['L0002_blood_remarks']) ?>
                    </p>
                </div>
            <?php } ?>

            <div>
                <p class="suggestions-para">
                    <span class="p-tag" style="font-size: 16px;">Suggestions : </span> (1) If your hemoglobin level is lower than normal, you have anemia. There are many forms of anemia and with different causes which
                    include iron deficiency, Vitamin B12 deficiency, folate deficiency, hemoglobinopathies and malignancies. If your hemoglobin level is
                    higher than normal it may be because of causes like Polycythemia Vera, heavy smoking etc. (2) Low levels of iron or vitamins in the body can cause anemia. Poor diet or certain diseases might lead to anemia. Good sources of ironSpinach & dark green leafy vegetables, Beetroot, Watermelon, Pomegranate etc. Good sources of Vitamin B12- Meat, salmon, milk,
                    cheese, eggs etc. Kindly consult your clinician for further follow-up & management.
                </p>
            </div>
            <?php
            if (
                !empty($bloodResults['rbccount_test_remraks']) ||
                !empty($bloodResults['hematocrit_pcv_test_remraks']) ||
                !empty($bloodResults['hemoglobin_test_remraks']) ||
                !empty($bloodResults['corpuscular_volume_test_remraks']) ||
                !empty($bloodResults['mch_test_remraks']) ||
                !empty($bloodResults['mchc_test_remraks']) ||
                !empty($bloodResults['red_cell_dist_cv_test_remraks']) ||
                !empty($bloodResults['red_cell_dist_sd_test_remraks']) ||
                !empty($bloodResults['platelets_count_test_remraks']) ||
                !empty($bloodResults['mpv_test_remraks']) ||
                !empty($bloodResults['pdw_test_remraks']) ||
                !empty($bloodResults['platelet_crit_test_remraks']) ||
                // !empty($bloodResults['platelet_cell_ratio_test_remraks']) ||
                !empty($bloodResults['leukocytes_count_test_remraks']) ||
                !empty($bloodResults['neutrophils_count_test_remraks']) ||
                !empty($bloodResults['monocyte_count_test_remraks']) ||
                !empty($bloodResults['lymphocyte_count_test_remraks']) ||
                !empty($bloodResults['eosinophil_count_test_remraks']) ||
                !empty($bloodResults['basophil_count_test_remraks']) ||
                !empty($bloodResults['neutrophils_test_remraks']) ||
                !empty($bloodResults['lymphocyte_test_remraks']) ||
                !empty($bloodResults['monocytes_test_remraks']) ||
                !empty($bloodResults['eosinophils_test_remraks']) ||
                !empty($bloodResults['basophils_test_remraks']) ||
                !empty($bloodResults['erythrocyte_sedimentation_test_remraks']) ||
                !empty($bloodResults['lactate_dehydragenase_LDH_serum_test_remraks'])
            ) {
            ?>
                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                        <span class="test-remarks suggestions-para sample-type-para">
                            <?php

                            $remarks = array_filter([
                                $bloodResults['rbccount_test_remraks'] ?? '',
                                $bloodResults['hematocrit_pcv_test_remraks'] ?? '',
                                $bloodResults['hemoglobin_test_remraks'] ?? '',
                                $bloodResults['corpuscular_volume_test_remraks'] ?? '',
                                $bloodResults['mch_test_remraks'] ?? '',
                                $bloodResults['mchc_test_remraks'] ?? '',
                                $bloodResults['red_cell_dist_cv_test_remraks'] ?? '',
                                $bloodResults['red_cell_dist_sd_test_remraks'] ?? '',
                                $bloodResults['platelets_count_test_remraks'] ?? '',
                                $bloodResults['mpv_test_remraks'] ?? '',
                                $bloodResults['pdw_test_remraks'] ?? '',
                                $bloodResults['platelet_crit_test_remraks'] ?? '',
                                //$bloodResults['platelet_cell_ratio_test_remraks'] ?? '',
                                $bloodResults['leukocytes_count_test_remraks'] ?? '',
                                $bloodResults['neutrophils_count_test_remraks'] ?? '',
                                $bloodResults['monocyte_count_test_remraks'] ?? '',
                                $bloodResults['lymphocyte_count_test_remraks'] ?? '',
                                $bloodResults['eosinophil_count_test_remraks'] ?? '',
                                $bloodResults['basophil_count_test_remraks'] ?? '',
                                $bloodResults['neutrophils_test_remraks'] ?? '',
                                $bloodResults['lymphocyte_test_remraks'] ?? '',
                                $bloodResults['monocytes_test_remraks'] ?? '',
                                $bloodResults['eosinophils_test_remraks'] ?? '',
                                $bloodResults['basophils_test_remraks'] ?? '',
                                $bloodResults['erythrocyte_sedimentation_test_remraks'] ?? '',
                                $bloodResults['lactate_dehydragenase_LDH_serum_test_remraks'] ?? '',

                            ]);

                            echo htmlspecialchars(implode(', ', $remarks));
                            ?>
                        </span>
                    </p>
                </div>
            <?php } ?>


        </div>

        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['L0002'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0">
                <tr class="d-block">
                    <td>
                        <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-iron.png" alt="" style=" padding-left: 10px; width:45px;" class="w-100">
                    </td>
                    <td style="padding-left:15px;"> <span style="width:100%;" class="result-title <?= $miniralVitaminIronResults['vit-min-iron-summary']; ?>">Vitamins,Minerals,Iron & Hormone</span>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="padding-left: 65px;font-size: 14px;">
                        <p> <span style="font-weight: 700;">Vitamins:</span> Vitamins test is used to check the levels of essential vitamins levels in your blood</p>
                        <p><span style="font-weight: 700;">Minerals:</span> Adequate amount of mineral is required for proper functioning of body</p>
                        <p><span style="font-weight: 700;">Iron:</span> Iron Profile is a set of tests that checks for Iron levels of your body</p>
                        <p><span style="font-weight: 700;">Hormone:</span> A test that measures the hormone levels in your body.</p>

                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['vitaminbtwelve_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['vitaminbtwelve_result_value'] != '') ? $miniralVitaminIronResults['vitaminbtwelve_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['vitaminbtwelve_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($miniralVitaminIronResults['vitaminbtwelve_result_value_cleaned'] < (float) $miniralVitaminIronResults['vitaminbtwelve_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['vitaminbtwelve_result_value_cleaned'] >= (float) $miniralVitaminIronResults['vitaminbtwelve_low_result_value'] && $miniralVitaminIronResults['vitaminbtwelve_result_value_cleaned'] <= (float) $miniralVitaminIronResults['vitaminbtwelve_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['vitaminbtwelve_result_value_cleaned'] > (float) $miniralVitaminIronResults['vitaminbtwelve_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $miniralVitaminIronResults['vitaminbtwelve_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['vitaminbtwelve_result_value_in_words'] != '') ? $miniralVitaminIronResults['vitaminbtwelve_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <!-- <tr>
                                        <td>Range</td>
                                        <td> : <?php echo $miniralVitaminIronResults['vitaminbtwelve_low_result_value'] . " - " . $miniralVitaminIronResults['vitaminbtwelve_high_result_value'] . " " . $miniralVitaminIronResults['vitaminbtwelve_uom']; ?></td>
                                    </tr> -->
                                <td>Range</td>
                                <?php if (!empty($miniralVitaminIronResults['vitaminbtwelve_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $miniralVitaminIronResults['vitaminbtwelve_BRInterval_result_value'] . " " . $miniralVitaminIronResults['vitaminbtwelve_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $miniralVitaminIronResults['vitaminbtwelve_low_result_value'] . " - " . $miniralVitaminIronResults['vitaminbtwelve_high_result_value'] . " " . $miniralVitaminIronResults['vitaminbtwelve_uom']; ?> </td>
                                <?php } ?>
                            </table>
                        </div>
                    </td>
                    <!-- Vitamin B12 -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Vitamin B12</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['vitaminbtwelve_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['vitaminbtwelve_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['V0004a_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Vitamin B12 is one of the essential vitamins of your body. This test measures the level
                                of Vitamin B12 in your blood. Vitamin B12 controls many body functions such as
                                regulation of brain health, production of blood cells and other functioning. Deficiency
                                of Vitamin B is common</p>

                            <?php if ($miniralVitaminIronResults['vitaminbtwelve_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['vitaminbtwelve_impact_on_health'] != '') ? $miniralVitaminIronResults['vitaminbtwelve_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['vitamind_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['vitamind_result_value'] != '') ? $miniralVitaminIronResults['vitamind_result_value'] : '') ?>
                                </span> <?php echo htmlspecialchars($miniralVitaminIronResults['vitamind_uom']); ?>
                            </div>

                            <table class="image-result">
                                <tr>
                                    <td><img src="<?= $miniralVitaminIronResults['vitamind_thumb_up_icon'] ?>" /></td>
                                    <td class="<?= $miniralVitaminIronResults['vitamind_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['vitamind_result_value_in_words'] != '') ? $miniralVitaminIronResults['vitamind_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <?php
                                foreach ($miniralVitaminIronResults['vitamind_reference_ranges_value'] as $label => $range) {
                                    echo "<tr>";
                                    echo "<td>" . ucwords($label) . "</td>";
                                    echo "<td>: $range</td>";
                                    echo "</tr>";
                                }
                                ?>

                            </table>
                        </div>
                    </td>
                    <!-- Vitamin D-25 Hydroxy -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Vitamin D-25 Hydroxy</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['vitamind_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['vitamind_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['V0004c_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Vitamin D- 25 Hydroxy monitors Vitamin- D levels in your bodyIn your bloodstream, vitamin
                                D2 and vitamin D3 are changed into a form of vitamin D called Vitamin D-25 Hydroxy. A
                                vitamin D blood test measures the level of 25 (OH) D in your blood.</p>

                            <?php if ($miniralVitaminIronResults['vitamind_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['vitamind_impact_on_health'] != '') ? $miniralVitaminIronResults['vitamind_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php if ($patientDetails['PackageCode'] !== 'AYN_016') { ?>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                    <tr>
                        <td class="leftPanel">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $miniralVitaminIronResults['phosphorus_color_code']; ?>" style="font-size: 34px;">
                                        <?php echo (($miniralVitaminIronResults['phosphorus_result_value'] != '') ? $miniralVitaminIronResults['phosphorus_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($miniralVitaminIronResults['phosphorus_uom']) ?>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <?php if ($miniralVitaminIronResults['phosphorus_result_value'] < $miniralVitaminIronResults['phosphorus_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($miniralVitaminIronResults['phosphorus_result_value'] >= $miniralVitaminIronResults['phosphorus_low_result_value'] && $miniralVitaminIronResults['phosphorus_result_value'] <= $miniralVitaminIronResults['phosphorus_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($miniralVitaminIronResults['phosphorus_result_value'] > $miniralVitaminIronResults['phosphorus_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $miniralVitaminIronResults['phosphorus_color_code']; ?> image-ressult">
                                            <?php echo (($miniralVitaminIronResults['phosphorus_result_value_in_words'] != '') ? $miniralVitaminIronResults['phosphorus_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <tr>
                                        <!-- <td>Range</td>
                                        <td>: <?php echo $miniralVitaminIronResults['phosphorus_low_result_value'] . " - " . $miniralVitaminIronResults['phosphorus_high_result_value'] . " "; ?> <?php echo htmlspecialchars($miniralVitaminIronResults['phosphorus_uom']); ?></td> -->


                                        <td>Range</td>
                                        <?php if (!empty($miniralVitaminIronResults['phosphorus_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $miniralVitaminIronResults['phosphorus_BRInterval_result_value'] . " " . $miniralVitaminIronResults['phosphorus_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $miniralVitaminIronResults['phosphorus_low_result_value'] . " - " . $miniralVitaminIronResults['phosphorus_high_result_value'] . " " . $miniralVitaminIronResults['phosphorus_uom']; ?> </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <!-- Phosphorus -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Phosphorus</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['phosphorus_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($miniralVitaminIronResults['phosphorus_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $min_vit_iron_Testgroupdetails['P0010b_min_vit_iron_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <p style="margin-top:5px;">Phosphorus is a mineral which makes bones and teeth strong. This test checks the level of
                                    phosphorus in your blood.</p>

                                <?php if ($miniralVitaminIronResults['phosphorus_impact_on_health'] != '') { ?>
                                    <h4>Impact on health</h4>
                                    <p><?php echo ($miniralVitaminIronResults['phosphorus_impact_on_health'] != '') ? $miniralVitaminIronResults['phosphorus_impact_on_health'] : '' ?></p>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['uibc_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['uibc_result_value'] != '') ? $miniralVitaminIronResults['uibc_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['uibc_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($miniralVitaminIronResults['uibc_result_value'] < $miniralVitaminIronResults['uibc_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['uibc_result_value'] >= $miniralVitaminIronResults['uibc_low_result_value'] && $miniralVitaminIronResults['uibc_result_value'] <= $miniralVitaminIronResults['uibc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['uibc_result_value'] > $miniralVitaminIronResults['uibc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $miniralVitaminIronResults['uibc_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['uibc_result_value_in_words'] != '') ? $miniralVitaminIronResults['uibc_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <tr>
                                    <!-- <td>Range</td>
                                    <td> : <?php echo $miniralVitaminIronResults['uibc_low_result_value'] . " - " . $miniralVitaminIronResults['uibc_high_result_value'] . " "; ?> <?php echo htmlspecialchars($miniralVitaminIronResults['uibc_uom']); ?></td> -->

                                    <td>Range</td>
                                    <?php if (!empty($miniralVitaminIronResults['uibc_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['uibc_BRInterval_result_value'] . " " . $miniralVitaminIronResults['uibc_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['uibc_low_result_value'] . " - " . $miniralVitaminIronResults['uibc_high_result_value'] . " " . $miniralVitaminIronResults['uibc_uom']; ?> </td>
                                    <?php } ?>

                                </tr>
                            </table>
                        </div>
                    </td>
                    <!-- UIBC -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">UIBC</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['uibc_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['uibc_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['iron_studies_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">UIBC checks for the body efficiency to transport Iron in the blood</p>

                            <?php if ($miniralVitaminIronResults['uibc_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['uibc_impact_on_health'] != '') ? $miniralVitaminIronResults['uibc_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>


        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['V0004a', 'V0004c', 'Iron Studies'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>
    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['tibc_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['tibc_result_value'] != '') ? $miniralVitaminIronResults['tibc_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['tibc_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($miniralVitaminIronResults['tibc_result_value'] < $miniralVitaminIronResults['tibc_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['tibc_result_value'] >= $miniralVitaminIronResults['tibc_low_result_value'] && $miniralVitaminIronResults['tibc_result_value'] <= $miniralVitaminIronResults['tibc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['tibc_result_value'] > $miniralVitaminIronResults['tibc_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $miniralVitaminIronResults['tibc_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['tibc_result_value_in_words'] != '') ? $miniralVitaminIronResults['tibc_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <tr>
                                    <!-- <td>Range </td>
                                    <td> : <?php echo $miniralVitaminIronResults['tibc_low_result_value'] . " - " . $miniralVitaminIronResults['tibc_high_result_value'] . " "; ?> <?php echo htmlspecialchars($miniralVitaminIronResults['tibc_uom']); ?></td> -->
                                    <td>Range</td>
                                    <?php if (!empty($miniralVitaminIronResults['tibc_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['tibc_BRInterval_result_value'] . " " . $miniralVitaminIronResults['tibc_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['tibc_low_result_value'] . " - " . $miniralVitaminIronResults['tibc_high_result_value'] . " " . $miniralVitaminIronResults['tibc_uom']; ?> </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <!-- TIBC -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">TIBC</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['tibc_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['tibc_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['iron_studies_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">TIBC check iron level in your blood TIBC (total iron-binding capacity) measures the total amount of iron that can be bound by proteins in the blood.</p>

                            <?php if ($miniralVitaminIronResults['tibc_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['tibc_impact_on_health'] != '') ? $miniralVitaminIronResults['tibc_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['iron_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['iron_result_value'] != '') ? $miniralVitaminIronResults['iron_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['iron_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($miniralVitaminIronResults['iron_result_value'] < $miniralVitaminIronResults['iron_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['iron_result_value'] >= $miniralVitaminIronResults['iron_low_result_value'] && $miniralVitaminIronResults['iron_result_value'] <= $miniralVitaminIronResults['iron_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['iron_result_value'] > $miniralVitaminIronResults['iron_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $miniralVitaminIronResults['iron_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['iron_result_value_in_words'] != '') ? $miniralVitaminIronResults['iron_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <tr>
                                    <!-- <td>Range </td>
                                    <td> : <?php echo $miniralVitaminIronResults['iron_low_result_value'] . " - " . $miniralVitaminIronResults['iron_high_result_value'] . " "; ?> <?php echo htmlspecialchars($miniralVitaminIronResults['iron_uom']); ?></td> -->

                                    <td>Range</td>
                                    <?php if (!empty($miniralVitaminIronResults['iron_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['iron_BRInterval_result_value'] . " " . $miniralVitaminIronResults['iron_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['iron_low_result_value'] . " - " . $miniralVitaminIronResults['iron_high_result_value'] . " " . $miniralVitaminIronResults['iron_uom']; ?> </td>
                                    <?php } ?>
                                </tr>
                            </table>

                        </div>
                    </td>
                    <!-- Iron -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Iron</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['iron_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['iron_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['iron_studies_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Iron is an essential mineral that forms RBCs of your blood. This test measures the level
                                of iron in your blood.</p>

                            <?php if ($miniralVitaminIronResults['iron_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['iron_impact_on_health'] != '') ? $miniralVitaminIronResults['iron_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['iron_saturation_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['iron_saturation_result_value'] != '') ? $miniralVitaminIronResults['iron_saturation_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['iron_saturation_uom']) ?>
                            </div>

                            <!-- Thumbs + Interpretation -->
                            <table class="image-result">
                                <tr>
                                    <?php if (!empty($miniralVitaminIronResults['iron_saturation_thumb_up_icon'])): ?>
                                        <td><img src="<?= $miniralVitaminIronResults['iron_saturation_thumb_up_icon']; ?>" /></td>
                                    <?php endif; ?>
                                    <td class="<?= $miniralVitaminIronResults['iron_saturation_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['iron_saturation_result_value_in_words'] != '') ? $miniralVitaminIronResults['iron_saturation_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>
                            <table class="mediacal-update">
                                <tr>
                                    <td>Range</td>
                                    <?php if (!empty($miniralVitaminIronResults['iron_saturation_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $miniralVitaminIronResults['iron_saturation_BRInterval_result_value'] ?> </td>
                                    <?php } else { ?>
                                            <td> : <?php echo $miniralVitaminIronResults['iron_saturation_low_result_value'] . " - " . $miniralVitaminIronResults['iron_saturation_high_result_value']?> </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </td>

                    <!-- % OF IRON SATURATION -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">% of Iron Saturation</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['iron_saturation_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                <?php if ($miniralVitaminIronResults['iron_saturation_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['iron_studies_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Description -->
                            <p style="margin-top:5px;">
                                Percentage of Iron Saturation also known as Transferrin saturation is the ratio of serum iron and TIBC.
                                This parameter provides an estimate of how much serum iron is actually bound to transferrin and is expressed as a percentage.
                                Transferrin saturation is typically utilised to determine a patient's iron status to detect either iron deficiency or overload.
                            </p>

                            <!-- Impact on health -->
                            <?php if (!empty($miniralVitaminIronResults['iron_saturation_impact_on_health'])): ?>
                                <h4>Impact on health</h4>
                                <p><?= $miniralVitaminIronResults['iron_saturation_impact_on_health']; ?></p>
                            <?php endif; ?>

                            <!-- Suggestion -->
                            <?php if (!empty($miniralVitaminIronResults['iron_saturation_suggestion'])): ?>
                                <h4>Suggestion</h4>
                                <p><?= $miniralVitaminIronResults['iron_saturation_suggestion']; ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>


            <table cellspacing="0" cellpadding="0" class="graphBArContentSection">
                <tr>
                    <td class="leftPanel">
                        <div class="graphDetail">
                            <p style="color: #333;font-weight:600;">Your Result Value</p>
                            <div>
                                <span class="<?= $miniralVitaminIronResults['testosterone_color_code']; ?>" style="font-size: 34px;">
                                    <?php echo (($miniralVitaminIronResults['testosterone_result_value'] != '') ? $miniralVitaminIronResults['testosterone_result_value'] : '') ?>
                                </span><?php echo htmlspecialchars($miniralVitaminIronResults['testosterone_uom']) ?>
                            </div>
                            <table class="image-result">
                                <tr>
                                    <?php if ($miniralVitaminIronResults['testosterone_result_value_cleaned'] < $miniralVitaminIronResults['testosterone_low_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['testosterone_result_value_cleaned'] >=  $miniralVitaminIronResults['testosterone_low_result_value'] && $miniralVitaminIronResults['testosterone_result_value_cleaned'] <=  $miniralVitaminIronResults['testosterone_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                    <?php } ?>

                                    <?php if ($miniralVitaminIronResults['testosterone_result_value_cleaned'] >  $miniralVitaminIronResults['testosterone_high_result_value']) { ?>
                                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                    <?php } ?>
                                    <td class="<?= $miniralVitaminIronResults['testosterone_color_code']; ?> image-ressult">
                                        <?php echo (($miniralVitaminIronResults['testosterone_result_value_in_words'] != '') ? $miniralVitaminIronResults['testosterone_result_value_in_words'] : '') ?>
                                    </td>
                                </tr>
                            </table>

                            <table class="mediacal-update">
                                <!-- <tr>
                                    <td>Range </td>
                                    <td> : <?php echo $miniralVitaminIronResults['testosterone_low_result_value'] . " - " . $miniralVitaminIronResults['testosterone_high_result_value'] . " " . htmlspecialchars($miniralVitaminIronResults['testosterone_uom']) ?> </td>
                                </tr> -->
                                <td>Range</td>
                                <?php if (!empty($miniralVitaminIronResults['testosterone_BRInterval_result_value'])) { ?>
                                    <td> : <?php echo $miniralVitaminIronResults['testosterone_BRInterval_result_value'] . " " . $miniralVitaminIronResults['testosterone_uom']; ?> </td>
                                <?php } else { ?>
                                    <td> : <?php echo $miniralVitaminIronResults['testosterone_low_result_value'] . " - " . $miniralVitaminIronResults['testosterone_high_result_value'] . " " . $miniralVitaminIronResults['testosterone_uom']; ?> </td>
                                <?php } ?>
                            </table>

                        </div>
                    </td>
                    <!-- Testosterone Total Serum -->
                    <td class="rightPanel">
                        <div class="graphContent" style="position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                <h4 style="margin: 0;">Testosterone Total Serum</h4>
                                <p class="methodology" style="margin: 0;"> <?= $miniralVitaminIronResults['testosterone_sample_method']; ?> </p>
                            </div>

                            <!-- NABL Logo and Code Positioned Absolutely -->
                            <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                <?php if ($miniralVitaminIronResults['testosterone_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                    <div style="color: #000; font-size: 8px; line-height: 8px;">
                                        <?= $min_vit_iron_Testgroupdetails['T0002b_min_vit_iron_nabl_code']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <p style="margin-top:5px;">Testosterone tests are performed to determine the amount of testosterone in a blood sample. Testosterone levels that are outside of a normal range can cause changes to health and physical appearance</p>

                            <?php if ($miniralVitaminIronResults['testosterone_impact_on_health'] != '') { ?>
                                <h4>Impact on health</h4>
                                <p><?php echo ($miniralVitaminIronResults['testosterone_impact_on_health'] != '') ? $miniralVitaminIronResults['testosterone_impact_on_health'] : '' ?></p>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>




            <div style="float:left;">
                <div style="padding-top: 5px;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Serum
                    </p>
                </div>
                <?php
                $remarks = array_filter([
                    $min_vit_iron_Testgroupdetails['V0004a_min_vit_iron_remarks'] ?? '',
                    $min_vit_iron_Testgroupdetails['V0004c_min_vit_iron_remarks'] ?? '',
                    $min_vit_iron_Testgroupdetails['P0010b_min_vit_iron_remarks'] ?? '',
                    $min_vit_iron_Testgroupdetails['iron_studies_min_vit_iron_remarks'] ?? '',
                    $min_vit_iron_Testgroupdetails['T0002b_min_vit_iron_remarks'] ?? ''
                ]);

                if (!empty($remarks)) { ?>
                    <div style="padding-top: 2.5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                            <?= htmlspecialchars(implode(', ', $remarks)) ?>
                        </p>
                    </div>
                <?php } ?>
                <div>
                    <p class="suggestions-para">
                        <span class="p-tag" style="font-size: 16px;">Suggestions :</span> (1) Usually, vitamin B12 deficiency anemia is easy to treat with diet and vitamin supplements. To increase the amount of vitamin B12 in your
                        diet, eat more of foods that contain it, such as: Beef, liver, and chicken Fish Fortified breakfast cereal Low-fat milk, yogurt, and cheese
                        Eggs. (2) Common effective ways to increase vitamin D levels in the body:
                        Sunlight, Seafood, Mushrooms, Egg yolks, Fortified foods, Supplements.
                    </p>
                </div>
                <?php
                if (
                    !empty($miniralVitaminIronResults['vitaminbtwelve_test_remraks']) ||
                    !empty($miniralVitaminIronResults['vitamind_test_remraks']) ||
                    !empty($miniralVitaminIronResults['phosphorus_test_remraks']) ||
                    !empty($miniralVitaminIronResults['iron_test_remraks']) ||
                    !empty($miniralVitaminIronResults['uibc_test_remraks']) ||
                    !empty($miniralVitaminIronResults['tibc_test_remraks']) ||
                    !empty($miniralVitaminIronResults['iron_saturation_test_remraks']) ||
                    !empty($miniralVitaminIronResults['testosterone_test_remraks'])
                ) {
                ?>
                    <div style="padding-top: 5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                            <span class="test-remarks suggestions-para sample-type-para">
                                <?php

                                $remarks = array_filter([
                                    $miniralVitaminIronResults['vitaminbtwelve_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['vitamind_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['phosphorus_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['iron_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['uibc_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['tibc_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['iron_saturation_test_remraks'] ?? '',
                                    $miniralVitaminIronResults['testosterone_test_remraks'] ?? ''
                                ]);

                                echo htmlspecialchars(implode(', ', $remarks));
                                ?>
                            </span>
                        </p>
                    </div>
                <?php } ?>
            </div>
            <?php if ($urineResults['urinestatus_found']) { ?>
                <div style="margin-top: 150px;">
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-urine.png" alt="" style="padding-left: 10px; width:40px;" class="w-100">
                        </td>
                        <td style="padding-left: 15px;"> <span class="result-title" style="background-color: white;color:black">Urine</span></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="padding-left: 65px;font-size: 14px;">
                            <p> <span style="font-weight: 700;">Remarks:</span> Sample Not Received.</p>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </div>
        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php //echo $footerWithLogo;
                echo NewFooter(['Iron Studies', 'T0002b'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>


    <?php if (!$urineResults['urinestatus_found']) { ?>
        <!-- URINE STARTED -->
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0">
                    <tr class="d-block">
                        <td>
                            <img src="https://cdn.shop.lifecell.in/reports/wellness/images/mfine-urine.png" alt="" style="padding-left: 10px; width:40px;" class="w-100">

                        </td>
                        <td style="padding-left: 15px;"> <span class="result-title <?= $urineResults['urine-summary']; ?>">Urine</span></td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:90px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span style="font-size: 26px;">
                                        <?php echo (($urineResults['urine_colour_result_value'] != '') ? $urineResults['urine_colour_result_value'] : '') ?>
                                    </span>
                                    <!-- Yellow -->
                                </div>
                            </div>
                        </td>
                        <!-- Colour -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Colour</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_colour_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_colour_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <p style="margin-top:5px;">This is a physical exam of urine</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:90px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span style="font-size: 26px;">
                                        <?php echo (($urineResults['volume_result_value'] != '') ? $urineResults['volume_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($urineResults['volume_uom']); ?>
                                </div>
                            </div>
                        </td>
                        <!-- Volume -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Volume</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['volume_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['volume_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <p style="margin-top:5px;">This is a physical exam of urine</p>
                            </div>

                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:143px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span style="font-size: 26px;">
                                        <?php echo (($urineResults['urine_specific_gravity_result_value'] != '') ? $urineResults['urine_specific_gravity_result_value'] : '') ?>
                                    </span>
                                </div>
                                <table class="image-result">
                                    <tr>
                                        <!-- <?php if ($urineResults['urine_specific_gravity_result_value_cleaned'] < $urineResults['urine_specific_gravity_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_specific_gravity_result_value_cleaned'] >= $urineResults['urine_specific_gravity_low_result_value']  && $urineResults['urine_specific_gravity_result_value_cleaned'] <= $urineResults['urine_specific_gravity_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_specific_gravity_result_value_cleaned'] > $urineResults['urine_specific_gravity_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $urineResults['urine_specific_gravity_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                                <?php echo (($urineResults['urine_specific_gravity_result_value_in_words'] != '') ? $urineResults['urine_specific_gravity_result_value_in_words'] : '') ?>
                                            </td> -->
                                    </tr>
                                </table>
                                <table class="mediacal-update" style="width: 77%;">
                                    <!-- <tr>
                                        <td>Range </td>
                                        <td>: <?php echo $urineResults['urine_specific_gravity_low_result_value'] . " - " . $urineResults['urine_specific_gravity_high_result_value'] . ""; ?></td>
                                    </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($urineResults['urine_specific_gravity_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $urineResults['urine_specific_gravity_BRInterval_result_value'] . " " . $urineResults['urine_specific_gravity_uom']; ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $urineResults['urine_specific_gravity_low_result_value'] . " - " . $urineResults['urine_specific_gravity_high_result_value'] . " " . $urineResults['urine_specific_gravity_uom']; ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Specific Gravity -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Specific Gravity</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_specific_gravity_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_specific_gravity_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <p style="margin-top:5px;">Specific Gravity test is used in the evaluation of water balance and urine concentration</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_ph_color_code']; ?>" style="font-size: 26px;">
                                        <?php echo (($urineResults['urine_ph_result_value'] != '') ? $urineResults['urine_ph_result_value'] : '') ?>
                                    </span>
                                </div>
                                <table class="image-result" style="font-size: 15px;">
                                    <tr>
                                        <?php if ($urineResults['urine_ph_result_value_cleaned'] < $urineResults['urine_ph_low_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>

                                        <?php if ($urineResults['urine_ph_result_value_cleaned'] >= $urineResults['urine_ph_low_result_value']  && $urineResults['urine_ph_result_value_cleaned'] <= $urineResults['urine_ph_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                        <?php } ?>

                                        <?php if ($urineResults['urine_ph_result_value_cleaned'] > $urineResults['urine_ph_high_result_value']) { ?>
                                            <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                        <?php } ?>
                                        <td class="<?= $urineResults['urine_ph_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                            <?php echo (($urineResults['urine_ph_result_value_in_words'] != '') ? $urineResults['urine_ph_result_value_in_words'] : '') ?>
                                        </td>
                                    </tr>
                                </table>
                                <table class="mediacal-update">
                                    <!-- <tr>
                                        <td>Range </td>
                                        <td>: <?php echo $urineResults['urine_ph_low_result_value'] . " - " . $urineResults['urine_ph_high_result_value'] . ""; ?></td>
                                    </tr> -->
                                    <td>Range</td>
                                    <?php if (!empty($urineResults['urine_ph_BRInterval_result_value'])) { ?>
                                        <td> : <?php echo $urineResults['urine_ph_BRInterval_result_value'] ?> </td>
                                    <?php } else { ?>
                                        <td> : <?php echo $urineResults['urine_ph_low_result_value'] . " - " . $urineResults['urine_ph_high_result_value'] ?> </td>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- pH -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">pH</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_ph_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_ph_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <p style="margin-top:5px;">pH of urine may confirm Kidney stone conditions</p>
                            </div>

                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection w-50 float-left m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_protein_color_code']; ?>" style="font-size: 26px;">
                                        <!--  <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_protein_result_value'] != '') ? $urineResults['urine_protein_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Protein -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; position: relative;">
                                    <h4 style="margin: 0;">Protein</h4>
                                    <p class="methodology" style="margin: 0; max-width: 70%; word-wrap: break-word;">
                                        <?= $urineResults['urine_protein_sample_method']; ?>
                                    </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <?php if ($urineResults['urine_protein_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                    <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    </div>
                                    <style>
                                        /* Adjust methodology styling when NABL logo is present */
                                        .methodology {
                                            max-width: 100%;
                                            /* Allow it to take full width */
                                            display: block;
                                            white-space: normal;
                                        }
                                    </style>
                                <?php endif; ?>

                                <p style="margin-top: 5px;">This test checks for presence or absence of protein in urine</p>
                            </div>


                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_glucose_color_code']; ?>" style="font-size: 26px;">
                                        <!--  <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_glucose_result_value'] != '') ? $urineResults['urine_glucose_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Glucose -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Glucose</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_glucose_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_glucose_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Glucose in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_ketones_color_code']; ?>" style="font-size: 26px;">
                                        <!--  <span style="font-size: 26px;"> -->
                                        <?php echo (($urineResults['urine_ketones_result_value'] != '') ? $urineResults['urine_ketones_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Ketones -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Ketones</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_ketones_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_ketones_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Ketones in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_urobilinogen_color_code']; ?>" style="font-size: 26px;">
                                        <!--  <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_urobilinogen_result_value'] != '') ? $urineResults['urine_urobilinogen_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Urobilinogen -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Urobilinogen</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_urobilinogen_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_urobilinogen_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Urobilinogen in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_bilirubin_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_bilirubin_result_value'] != '') ? $urineResults['urine_bilirubin_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Bilirubin -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Bilirubin</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_bilirubin_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_bilirubin_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Bilirubin in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style="padding-bottom:34%; padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_nitrite_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;"> -->
                                        <?php echo (($urineResults['urine_nitrite_result_value'] != '') ? $urineResults['urine_nitrite_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Nitrite -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Nitrite</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_nitrite_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_nitrite_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Nitrite in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['R0007j'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
        <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
            <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
                <div style="width:100%;">
                    <?php echo $co_brand_header2; ?>
                </div>
                <div>
                    <table>
                        <tr>
                            <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_blood_color_code']; ?>" style="font-size: 26px;">
                                        <!--<span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_blood_result_value'] != '') ? $urineResults['urine_blood_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Blood -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Blood</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_blood_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_blood_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test checks for presence or absence of Blood in urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height: 107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_crystals_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;"> -->
                                        <?php echo (($urineResults['urine_crystals_result_value'] != '') ? $urineResults['urine_crystals_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Crystals -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Crystals</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_crystals_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_crystals_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the presence or absence of Crystals in your urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:147px">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <?php $paddingtop = !empty($urineResults['urine_puscell_secondvalue']) ? "" : 25 ?>
                                <div style="padding-top:   <?= $paddingtop ?>px;">
                                    <span class="<?= $urineResults['urine_puscell_color_code']; ?>" style="font-size: 26px;">
                                        <?php echo (($urineResults['urine_puscell_result_value'] != '') ? $urineResults['urine_puscell_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($urineResults['urine_puscell_uom']); ?>
                                </div>
                                <table class="image-result" style="font-size: 20px;">
                                    <tr>
                                        <?php
                                        if (!empty($urineResults['urine_puscell_secondvalue'])) { ?>
                                            <?php
                                            if ($urineResults['urine_puscell_secondvalue'] < $urineResults['urine_puscell_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_puscell_secondvalue'] >= $urineResults['urine_puscell_low_result_value']  && $urineResults['urine_puscell_secondvalue'] <= $urineResults['urine_puscell_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_puscell_secondvalue'] > $urineResults['urine_puscell_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $urineResults['urine_puscell_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                                <?php echo (($urineResults['urine_puscell_result_value_in_words'] != '') ? $urineResults['urine_puscell_result_value_in_words'] : '') ?>
                                            </td>
                                    </tr>
                                <?php } ?>
                                </table>
                                <table class="mediacal-update" style="width: 77%;">
                                    <?php if (!empty($urineResults['urine_puscell_secondvalue'])) { ?>
                                        <!-- <tr>
                                            <td>Range</td>
                                            <td> : <?php echo $urineResults['urine_puscell_low_result_value'] . " - " . $urineResults['urine_puscell_high_result_value'] . " " . $urineResults['urine_puscell_uom']; ?> </td>
                                    </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($urineResults['urine_puscell_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $urineResults['urine_puscell_BRInterval_result_value'] . " " . $urineResults['urine_puscell_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $urineResults['urine_puscell_low_result_value'] . " - " . $urineResults['urine_puscell_high_result_value'] . " " . $urineResults['urine_puscell_uom']; ?> </td>
                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Pus Cell< -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Pus Cell</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_puscell_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_puscell_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects Pyuria which confirms Urinary Tract Infection (UTI)</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:147px">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <?php $paddingtop = !empty($urineResults['urine_epithelialcell_secondvalue']) ? "" : 25 ?>
                                <div style="padding-top:<?= $paddingtop ?>px;">
                                    <span class="<?= $urineResults['urine_epithelialcell_color_code']; ?>" style="font-size: 26px;">
                                        <?php echo (($urineResults['urine_epithelialcell_result_value'] != '') ? $urineResults['urine_epithelialcell_result_value'] : '') ?>
                                    </span><?php echo htmlspecialchars($urineResults['urine_epithelialcell_uom']); ?>
                                </div>
                                <table class="image-result" style="width: 74%; font-size: 20px;">
                                    <tr>
                                        <?php
                                        if (!empty($urineResults['urine_epithelialcell_secondvalue'])) { ?>
                                            <?php
                                            if ($urineResults['urine_epithelialcell_secondvalue'] < $urineResults['urine_epithelialcell_low_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_epithelialcell_secondvalue'] >= $urineResults['urine_epithelialcell_low_result_value']  && $urineResults['urine_epithelialcell_secondvalue'] <= $urineResults['urine_epithelialcell_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/green-thumbs.png" /></td>
                                            <?php } ?>

                                            <?php if ($urineResults['urine_epithelialcell_secondvalue'] > $urineResults['urine_epithelialcell_high_result_value']) { ?>
                                                <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/red-thumb.png" /></td>
                                            <?php } ?>
                                            <td class="<?= $urineResults['urine_epithelialcell_color_code']; ?> image-ressult" style="padding-left: 10px;">
                                                <?php echo (($urineResults['urine_epithelialcell_result_value_in_words'] != '') ? $urineResults['urine_epithelialcell_result_value_in_words'] : '') ?>
                                            </td>
                                    </tr>
                                <?php } ?>
                                </table>


                                <table class="mediacal-update" style="width: 77%;">
                                    <?php
                                    if (!empty($urineResults['urine_epithelialcell_secondvalue'])) { ?>
                                        <!-- <tr>
                                            <td>Range </td>
                                            <td>: <?php echo $urineResults['urine_epithelialcell_low_result_value'] . " - " . $urineResults['urine_epithelialcell_high_result_value'] . " " . $urineResults['urine_epithelialcell_uom']; ?> </td>
                                        </tr> -->
                                        <td>Range</td>
                                        <?php if (!empty($urineResults['urine_epithelialcell_BRInterval_result_value'])) { ?>
                                            <td> : <?php echo $urineResults['urine_epithelialcell_BRInterval_result_value'] . " " . $urineResults['urine_epithelialcell_uom']; ?> </td>
                                        <?php } else { ?>
                                            <td> : <?php echo $urineResults['urine_epithelialcell_low_result_value'] . " - " . $urineResults['urine_epithelialcell_high_result_value'] . " " . $urineResults['urine_epithelialcell_uom']; ?> </td>
                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                        </td>
                        <!-- Epithelial Cells -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Epithelial Cells</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_epithelialcell_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_epithelialcell_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the amount of Epithelial cells in your urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_yeast_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['urine_yeast_result_value'] != '') ? $urineResults['urine_yeast_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Yeast -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Yeast</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_yeast_sample_method']; ?> </p>
                                </div>
                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($urineResults['urine_yeast_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the presence or absence of Crystals in your urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['bacteria_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['bacteria_result_value'] != '') ? $urineResults['bacteria_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Bacteria -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Bacteria</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['bacteria_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['bacteria_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the presence or absence of Bacteria in your urine Bacteria in urine
                                    confirms Urinary Tract Infection.</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['urine_appearance_color_code']; ?>" style="font-size: 26px;">
                                        <!--  <span style="font-size: 26px;"> -->
                                        <?php echo (($urineResults['urine_appearance_result_value'] != '') ? $urineResults['urine_appearance_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Appearance -->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Appearance</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['urine_appearance_sample_method']; ?> </p>
                                </div>
                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['urine_appearance_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This is a physical exam of urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h" style=" padding-left: 10px;">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail" style="min-height:107px;">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['casts_color_code']; ?>" style="font-size: 26px;">
                                        <!-- <span style="font-size: 26px;"> -->
                                        <?php echo (($urineResults['casts_result_value'] != '') ? $urineResults['casts_result_value'] : '') ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <!-- Casts-->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">Casts</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['casts_sample_method']; ?> </p>
                                </div>
                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">
                                    <?php if ($urineResults['casts_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the presence or absence of Casts in your urine</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" class="graphBArContentSection float-left w-50 m-h">
                    <tr>
                        <td class="leftPanel urine">
                            <div class="graphDetail">
                                <p style="color: #333;font-weight:600;">Your Result Value</p>
                                <div>
                                    <span class="<?= $urineResults['rbcs_color_code']; ?>" style="font-size: 27px;">
                                        <!-- <span style="font-size: 26px;">-->
                                        <?php echo (($urineResults['rbcs_result_value'] != '') ? $urineResults['rbcs_result_value'] : '') ?>
                                    </span> <?php echo htmlspecialchars($urineResults['rbcs_uom']); ?>
                                </div>
                            </div>
                        </td>
                        <!-- RBCs-->
                        <td class="rightPanel">
                            <div class="graphContent" style="position: relative;">
                                <div style="display: flex; align-items: center; justify-content: space-between; position: relative;">
                                    <h4 style="margin: 0;">RBCs</h4>
                                    <p class="methodology" style="margin: 0;"> <?= $urineResults['rbcs_sample_method']; ?> </p>
                                </div>

                                <!-- NABL Logo and Code Positioned Absolutely -->
                                <div style="position: absolute; top: -5px; right: 0; display: flex; align-items: center;">

                                    <?php if ($urineResults['rbcs_is_nabl_accredited'] == 1  && !($patientDetails['hospital_logo']['combained'])): ?>
                                        <img src="https://reports.lifecell.in/images/footer-logo-pns-new.png" alt="" style="width: auto; height: 40px; margin-right: 10px;">
                                        <div style="color: #000; font-size: 8px; line-height: 8px;">
                                            <?= $urineTestgroupdetails['R0007j_urine_nabl_code']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p style="margin-top:5px;">This test detects the presence or absence of RBCs in your urine</p>
                            </div>
                        </td>
                    </tr>
                </table>



                <div style="padding-top: 5px; clear: both;">
                    <p class="sample-type-para">
                        <span class="p-tag" style="font-size: 16px;">Sample Type :</span> Urine
                    </p>
                </div>
                <?php if (!empty($urineTestgroupdetails['R0007j_urine_remarks'])) { ?>
                    <div style="padding-top: 2.5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Service Remarks :</span>
                            <?= htmlspecialchars($urineTestgroupdetails['R0007j_urine_remarks']) ?>
                        </p>
                    </div>
                <?php } ?>
                <div>
                    <p class="suggestions-para">
                        <span class="p-tag" style="font-size: 16px;">Suggestions :</span> Drink plenty of water, use neat & clean washroom, Release your urine at shorter period

                    </p>
                </div>
                <?php
                if (
                    !empty($urineResults['bacteria_test_remraks']) ||
                    !empty($urineResults['urine_colour_test_remraks']) ||
                    !empty($urineResults['volume_test_remraks']) ||
                    !empty($urineResults['urine_specific_gravity_test_remraks']) ||
                    !empty($urineResults['urine_appearance_test_remraks']) ||
                    !empty($urineResults['rbcs_test_remraks']) ||
                    !empty($urineResults['casts_test_remraks']) ||
                    !empty($urineResults['urine_protein_test_remraks']) ||
                    !empty($urineResults['urine_glucose_test_remraks']) ||
                    !empty($urineResults['urine_ketones_test_remraks']) ||
                    !empty($urineResults['urine_urobilinogen_test_remraks']) ||
                    !empty($urineResults['urine_bilirubin_test_remraks']) ||
                    !empty($urineResults['urine_nitrite_test_remraks']) ||
                    !empty($urineResults['urine_blood_test_remraks']) ||
                    !empty($urineResults['urine_epithelialcell_test_remraks']) ||
                    !empty($urineResults['urine_crystals_test_remraks']) ||
                    !empty($urineResults['urine_yeast_test_remraks'])

                ) {
                ?>
                    <div style="padding-top: 5px;">
                        <p class="sample-type-para">
                            <span class="p-tag" style="font-size: 16px;">Test Remarks :</span>
                            <span class="test-remarks suggestions-para sample-type-para">
                                <?php

                                $remarks = array_filter([
                                    $urineResults['bacteria_test_remraks'] ?? '',
                                    $urineResults['urine_colour_test_remraks'] ?? '',
                                    $urineResults['volume_test_remraks'] ?? '',
                                    $urineResults['urine_specific_gravity_test_remraks'] ?? '',
                                    $urineResults['urine_appearance_test_remraks'] ?? '',
                                    $urineResults['rbcs_test_remraks'] ?? '',
                                    $urineResults['casts_test_remraks'] ?? '',
                                    $urineResults['urine_protein_test_remraks'] ?? '',
                                    $urineResults['urine_glucose_test_remraks'] ?? '',
                                    $urineResults['urine_ketones_test_remraks'] ?? '',
                                    $urineResults['urine_urobilinogen_test_remraks'] ?? '',
                                    $urineResults['urine_bilirubin_test_remraks'] ?? '',
                                    $urineResults['urine_nitrite_test_remraks'] ?? '',
                                    $urineResults['urine_blood_test_remraks'] ?? '',
                                    $urineResults['urine_epithelialcell_test_remraks'] ?? '',
                                    $urineResults['urine_crystals_test_remraks'] ?? '',
                                    $urineResults['urine_yeast_test_remraks'] ?? '',
                                ]);

                                echo htmlspecialchars(implode(', ', $remarks));
                                ?>
                            </span>
                        </p>
                    </div>
                <?php } ?>
                <div style="padding-top: 2px;">

                    <?php
                    if ($urineResults['urine_specific_gravity_color_code'] != 'green') {
                        $urineResults['urine_specific_gravity'] = 'Specific Gravity,';
                    } else {
                        $urineResults['urine_specific_gravity'] = '';
                    }
                    if ($urineResults['urine_ph_color_code'] != 'green') {
                        $urineResults['urine_ph'] = 'pH,';
                    } else {
                        $urineResults['urine_ph'] = '';
                    }
                    if ($urineResults['urine_protein_color_code'] != 'green') {
                        $urineResults['urine_protein'] = 'Protein,';
                    } else {
                        $urineResults['urine_protein'] = '';
                    }
                    if ($urineResults['urine_glucose_color_code'] != 'green') {
                        $urineResults['urine_glucose'] = 'Glucose,';
                    } else {
                        $urineResults['urine_glucose'] = '';
                    }
                    if ($urineResults['urine_ketones_color_code'] != 'green') {
                        $urineResults['urine_ketones'] = 'Ketones,';
                    } else {
                        $urineResults['urine_ketones'] = '';
                    }
                    if ($urineResults['urine_urobilinogen_color_code'] != 'green') {
                        $urineResults['urine_urobilinogen'] = 'Urobilinogen,';
                    } else {
                        $urineResults['urine_urobilinogen'] = '';
                    }
                    if ($urineResults['urine_bilirubin_color_code'] != 'green') {
                        $urineResults['urine_bilirubin'] = 'Bilirubin,';
                    } else {
                        $urineResults['urine_bilirubin'] = '';
                    }
                    if ($urineResults['urine_nitrite_color_code'] != 'green') {
                        $urineResults['urine_nitrite'] = 'Nitrite,';
                    } else {
                        $urineResults['urine_nitrite'] = '';
                    }
                    if ($urineResults['urine_blood_color_code'] != 'green') {
                        $urineResults['urine_blood'] = 'Blood,';
                    } else {
                        $urineResults['urine_blood'] = '';
                    }
                    if ($urineResults['urine_crystals_color_code'] != 'green') {
                        $urineResults['urine_crystals'] = 'Crystals,';
                    } else {
                        $urineResults['urine_crystals'] = '';
                    }
                    if ($urineResults['urine_puscell_color_code'] != 'green' && $urineResults['urine_puscell_color_code'] != 'black') {
                        $urineResults['urine_puscell'] = 'Pus Cell,';
                    } else {
                        $urineResults['urine_puscell'] = '';
                    }

                    if ($urineResults['urine_epithelialcell_color_code'] != 'green' && $urineResults['urine_epithelialcell_color_code'] != 'black') {
                        $urineResults['urine_epithelialcell'] = 'Epithelial Cells,';
                    } else {
                        $urineResults['urine_epithelialcell'] = '';
                    }

                    if ($urineResults['urine_yeast_color_code'] != 'green') {
                        $urineResults['urine_yeast'] = 'Yeast,';
                    } else {
                        $urineResults['urine_yeast'] = '';
                    }
                    if ($urineResults['urine_appearance_color_code'] != 'green') {
                        $urineResults['urine_appearance'] = 'Appearance,';
                    } else {
                        $urineResults['urine_appearance'] = '';
                    }
                    if ($urineResults['rbcs_color_code'] != 'green') {
                        $urineResults['rbcs'] = 'RBCs,';
                    } else {
                        $urineResults['rbcs'] = '';
                    }
                    if ($urineResults['casts_color_code'] != 'green') {
                        $urineResults['casts'] = 'Casts,';
                    } else {
                        $urineResults['casts'] = '';
                    }


                    ?>

                    <p class="p-tag">About your Results</p>
                    <?php if (($urineResults['urine_specific_gravity']) ||
                        ($urineResults['urine_ph']) ||
                        ($urineResults['urine_ph']) || ($urineResults['urine_protein']) ||
                        ($urineResults['urine_glucose']) || ($urineResults['urine_ketones']) ||
                        ($urineResults['urine_bilirubin']) || ($urineResults['urine_nitrite']) ||
                        ($urineResults['urine_blood']) || ($urineResults['urine_crystals']) ||
                        ($urineResults['urine_puscell']) || ($urineResults['urine_epithelialcell']) || ($urineResults['urine_yeast']) || ($urineResults['urine_appearance']) || ($urineResults['rbcs']) || ($urineResults['casts'])
                    ) { ?>
                        <p style="font-size: 14px;">During your health check we have found out that &nbsp; <span style="color: #EC1C24;">
                                <?php echo $urineResults['urine_specific_gravity'];
                                ?>
                                <?= $urineResults['urine_ph'] ?>
                                <?php echo $urineResults['urine_protein'];
                                ?>
                                <?php echo $urineResults['urine_glucose'];
                                ?>
                                <?php echo $urineResults['urine_ketones'];
                                ?>
                                <?php echo $urineResults['urine_bilirubin'];
                                ?>
                                <?php echo $urineResults['urine_nitrite'];
                                ?>
                                <?php echo $urineResults['urine_blood'];
                                ?>
                                <?php echo $urineResults['urine_crystals'];
                                ?>
                                <?= $urineResults['urine_puscell'] ?>
                                <?= $urineResults['urine_epithelialcell'] ?>
                                <?php echo $urineResults['urine_yeast'];
                                ?>
                                <?php echo $urineResults['urine_appearance'];
                                ?>
                                <?php echo $urineResults['rbcs'];
                                ?>
                                <?php echo $urineResults['casts'];
                                ?>


                            </span>is your concern parameters, which can impact your health.</p>
                    <?php } else { ?>
                        <p style="font-size: 14px;">All the test results are Normal.</p>
                    <?php  } ?>
                </div>
            </div>
            <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
                <div>
                    <?php //echo $footerWithLogo;
                    echo NewFooter(['R0007j'], $tgdrsig_details, $footerLogo, $patientDetails, $footerNablLogo);
                    ?>
                </div>
                <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
            </footer>
        </div>
    <?php } ?>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td> <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <div class="margin-auto w-50">
                <img style="width:95%;" src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-health-guid.png" alt="" />
            </div>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;
                    padding-right: 10px;
                    padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/nutrition-icon.png" alt=""></td>
                    <td></td>
                    <td class="nutrition">Nutrition</td>
                </tr>
            </table>
            <table style="display:table-cell; height:340px; background: #f3f5f8;" class="float-left w-50">
                <tr>
                    <td class="dos">Do's</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Maintain balance with whole grains, legumes, dairy, fruits, vegetables, nuts, and healthy fats</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Boost calcium with milk, yogurt, cheese, and leafy greens Add variety with Brazil nuts, sesame seeds, and sunflower</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Add variety with Brazil nuts, sesame seeds, and sunflower
                        seeds</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Enjoy apples, berries, and melons for fruit diversity</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Choose whole grains like whole wheat bread, brown rice,
                        and oats</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Prioritize fresh fruits, greens, and unsalted nuts and seeds</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Ensure iodized salt intake for thyroid health</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Include fresh fruit and veggie juices for extra nutrients</td>
                </tr>

            </table>
            <table style="display:table-cell; height:340px; background: #f2faff;" class="w-50">
                <tr>
                    <td class="donts">Dont's</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r">
                        <img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" />
                    </td>
                    <td class="dos-donts-td" style="color: #333;">Control sugar intake</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Reduce consumption of colas and sugary drinks</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td style="color: #333;">Decrease caffeine consumption</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Refrain from flavored and seasoned foods</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Avoid saturated fats, trans fats, and greasy foods such as cakes and fried items</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Exclude cruciferous vegetables like cauliflower, cabbage, and spinach</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Steer clear of soy products like soy milk or tofu</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Minimize intake of refined carbohydrates and processed foods</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Limit consumption of red meat and organ meats</td>
                </tr>
            </table>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;
                    padding-right: 10px;
                    padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/lifestyle-icon.png" alt=""></td>
                    <td></td>
                    <td class="nutrition">Lifestyle</td>
                </tr>
            </table>
            <table style="display:table-cell; height:290px; background: #f3f5f8;" class="float-left w-50">
                <tr>
                    <td class="dos">Do's</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Ensure consistent sunlight exposure</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Keep physically active and maintain a healthy weight</td>
                </tr>
            </table>
            <table style="display:table-cell; height:290px; background: #f2faff;" class="w-50">
                <tr>
                    <td class="donts">Dont's</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Pay attention to your body's signal and attend your
                        routine health check-ups.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Refrain from overexerting yourself without consuming
                        food or beverages.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Steer clear of smoking and alcohol consumption.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Avoid engaging in rigorous exercises.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Resist the temptation of overeating or consuming
                        calorie-rich foods.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Prevent prolonged stress or overwork.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wrong-icon.png" class="dos-donts" alt="wrong-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Reduce the frequency of dining out.</td>
                </tr>
            </table>

        </div>
        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php echo $footerWithLogo; ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>

    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-after: always;padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table>
                <tr class="d-block">
                    <td style="    border-right: 1px solid #00977b;
                    padding-right: 10px;
                    padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/physical-activity-icon.png" alt="">
                    </td>
                    <td></td>
                    <td class="nutrition">Physical Activity</td>
                </tr>
            </table>
            <table class="w-100">
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Physical activities range from walks to yoga and light weight lifting, recommended for 30 minutes, 3-4 days a week</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">If regular workouts are tough, try using stairs and doing household chores
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Options for physical exertion vary, including walks, sports, and
                        weightlifting</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;"> Engage in physical activity for at least 30 minutes, 3-4 times
                        weekly
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">
                        Incorporate incidental activities like stair climbing and household tasks for fitness
                    </td>
                </tr>
            </table>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;
                    padding-right: 10px;
                    padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/balanced-diet-icon.png" alt="">
                    </td>
                    <td></td>
                    <td class="nutrition">Balanced Diet</td>
                </tr>
            </table>
            <table class="w-100">
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">A healthy lifestyle hinges on a balanced diet comprising whole
                        grains, vegetables, fruits, nuts, seeds, beans, and plant oils.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Prioritize a high-protein breakfast and a modest dinner for optimal
                        nutrition.
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Steer clear of processed foods, potatoes, and calorie-laden sugary
                        products.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;"> Remember to hydrate consistently by drinking water throughout the
                        day.
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">
                        Optimal nutrition entails incorporating whole foods and avoiding processed items while
                        maintaining a balanced meal schedule.
                    </td>
                </tr>
            </table>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;
                    padding-right: 10px;
                    padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/stress-management-icon.png" alt="">
                    </td>
                    <td></td>
                    <td class="nutrition">Stress Management</td>
                </tr>
            </table>
            <table class="w-100">
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Stress management plays a crucial role in maintaining overall
                        well-being, necessitating daily adjustments.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Prioritizing adequate sleep, aiming for 6-8 hours nightly, is
                        foundational to stress reduction.
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">Engaging in meditation fosters mental clarity and resilience against
                        stressors.</td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td style="color: #333;"> Cultivating a positive lifestyle outlook and incorporating humor
                        into daily routines can alleviate stress.
                    </td>
                </tr>
                <tr class="d-block guidance">
                    <td class="paddingl-r"><img src="https://cdn.shop.lifecell.in/reports/wellness/images/right-icon.png" class="dos-donts" alt="right-icon" /></td>
                    <td class="dos-donts-td" style="color: #333;">
                        Traveling, connecting with supportive individuals, and dedicating time to beloved hobbies are
                        effective stress-relief strategies.
                    </td>
                </tr>
            </table>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;padding-right: 10px;padding-left: 10px;"><img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/follow-up-test-icon.png" alt="">
                    </td>
                    <td></td>
                    <td class="nutrition">Suggested follow up test</td>
                </tr>

            </table>
            <table class="border-collapse" style="width:100%; margin: 10px; border: 1px solid #777;">
                <tr>
                    <?php
                    if ($pancreasResults['glucose_fasting_status_found']) {
                        if ($pancreasResults['hba1c_color_code'] != 'green') {
                            $pancreasResults['hba1c'] = 'HbA1c,';
                        } else {
                            $pancreasResults['hba1c'] = '';
                        }
                    ?>
                        <?php if ($pancreasResults['hba1c_color_code'] == 'green') { ?>
                            <td class="tests">Pancreas - Nill </td>
                        <?php } else { ?>
                            <td class="tests">Pancreas -
                                <?= $pancreasResults['hba1c'] ?>
                            </td>
                        <?php } ?>
                    <?php
                    } else {
                        if ($pancreasResults['hba1c_color_code'] != 'green') {
                            $pancreasResults['hba1c'] = 'HbA1c,';
                        } else {
                            $pancreasResults['hba1c'] = '';
                        }

                        if ($pancreasResults['glucose_fasting_color_code'] != 'green') {
                            $pancreasResults['glucose_fasting'] = 'Glucose Fasting,';
                        } else {
                            $pancreasResults['glucose_fasting'] = '';
                        }
                    if ($pancreasResults['lipase_color_code'] != 'green') {
                        $pancreasResults['lipase_color'] = 'Lipase serum,';
                    } else {
                        $pancreasResults['lipase_color'] = '';
                    }


                    ?>
                        <?php if ($pancreasResults['hba1c_color_code'] == 'green' && $pancreasResults['glucose_fasting_color_code'] == 'green') { ?>
                            <td class="tests">Pancreas - Nill </td>
                        <?php } else { ?>
                            <td class="tests">Pancreas -
                                <?= $pancreasResults['hba1c'] ?>
                                <?= $pancreasResults['glucose_fasting'] ?>
                            <?= $pancreasResults['lipase_color'] ?>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
                <tr>
                    <?php
                    if ($heartResults['lipoprotein_ldl_status_found']) {
                        // LDL status found → include VLDL
                        $heartResults['total_cholesterol'] = ($heartResults['total_cholesterol_color_code'] != 'green') ? 'Total Cholesterol,' : '';
                        $heartResults['triglycerides'] = ($heartResults['triglycerides_color_code'] != 'green') ? 'Triglycerides,' : '';
                        $heartResults['HDL_cholesterol'] = ($heartResults['hdl_cholesterol_color_code'] != 'green') ? 'HDL Cholesterol,' : '';
                        $heartResults['low_Density_lipoprotein'] = ($heartResults['lipoproteincholesterol_color_code'] != 'green') ? 'Low Density Lipoprotein - Cholesterol (LDL),' : '';
                        $heartResults['very_low_Density_lipoprotein'] = ($heartResults['lipoprotein_ldl_color_code'] != 'green') ? 'Very Low Density Lipoprotein - Cholesterol (VLDL),' : '';
                        $heartResults['total_cholesterol_hdl_ratio'] = ($heartResults['total_cholesterolhdlratio_color_code'] != 'green') ? 'Total Cholesterol / HDL Ratio,' : '';
                        $heartResults['ldl_or_hdl_ratio'] = ($heartResults['ldlorhdlratio_color_code'] != 'green') ? 'LDL / HDL Ratio,' : '';
                        $heartResults['non_hdl_cholesterol'] = ($heartResults['nonhdlcholesterol_color_code'] != 'green') ? 'Non HDL Cholesterol,' : '';
                        $heartResults['high_sensitive_CRP_serum'] = ($heartResults['high_sensitive_CRP_serum_color_code'] != 'green') ? 'High sensitive CRP serum,' : '';
                        $heartResults['apolipoprotein_B_serum'] = ($heartResults['apolipoprotein_B_serum_color_code'] != 'green') ? 'Apolipoprotein B, Serum,' : '';
                        $heartResults['apolipoprotein_A1_serum'] = ($heartResults['apolipoprotein_A1_serum_color_code'] != 'green') ? 'Apolipoprotein A1, Serum,' : '';
                        $heartResults['apolipoprotein_A1_B_serum'] = ($heartResults['apolipoprotein_A1_B_serum_color_code'] != 'green') ? 'APO- B/ APO- A1 Ratio' : '';
                    ?>

                    <?php if (
                            $heartResults['total_cholesterol_color_code'] == 'green' &&
                            $heartResults['triglycerides_color_code'] == 'green' &&
                            $heartResults['hdl_cholesterol_color_code'] == 'green' &&
                            $heartResults['lipoproteincholesterol_color_code'] == 'green' &&
                            $heartResults['lipoprotein_ldl_color_code'] == 'green' &&
                            $heartResults['total_cholesterolhdlratio_color_code'] == 'green' &&
                        $heartResults['ldlorhdlratio_color_code'] == 'green' &&
                            $heartResults['nonhdlcholesterol_color_code'] == 'green' &&
                            $heartResults['high_sensitive_CRP_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_B_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_A1_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_A1_B_serum_color_code'] == 'green'
                    ) { ?>
                            <td class="tests">Heart - Nill</td>
                        <?php } else { ?>
                        <td class="tests">Heart -
                            <?= $heartResults['total_cholesterol'] ?>
                            <?= $heartResults['triglycerides'] ?>
                            <?= $heartResults['HDL_cholesterol'] ?>
                            <?= $heartResults['low_Density_lipoprotein'] ?>
                            <?= $heartResults['very_low_Density_lipoprotein'] ?>
                                <?= $heartResults['total_cholesterol_hdl_ratio'] ?>
                                <?= $heartResults['ldl_or_hdl_ratio'] ?>
                                <?= $heartResults['non_hdl_cholesterol'] ?>
                                <?= $heartResults['high_sensitive_CRP_serum'] ?>
                                <?= $heartResults['apolipoprotein_B_serum'] ?>
                                <?= $heartResults['apolipoprotein_A1_serum'] ?>
                                <?= $heartResults['apolipoprotein_A1_B_serum'] ?>
                            </td>
                            <?php } ?>
                    <?php } else {
                        // LDL status NOT found → exclude VLDL
                        $heartResults['total_cholesterol'] = ($heartResults['total_cholesterol_color_code'] != 'green') ? 'Total Cholesterol,' : '';
                        $heartResults['triglycerides'] = ($heartResults['triglycerides_color_code'] != 'green') ? 'Triglycerides,' : '';
                        $heartResults['HDL_cholesterol'] = ($heartResults['hdl_cholesterol_color_code'] != 'green') ? 'HDL Cholesterol,' : '';
                        $heartResults['low_Density_lipoprotein'] = ($heartResults['lipoproteincholesterol_color_code'] != 'green') ? 'Low Density Lipoprotein - Cholesterol (LDL),' : '';
                        $heartResults['total_cholesterol_hdl_ratio'] = ($heartResults['total_cholesterolhdlratio_color_code'] != 'green') ? 'Total Cholesterol / HDL Ratio,' : '';
                        $heartResults['ldl_or_hdl_ratio'] = ($heartResults['ldlorhdlratio_color_code'] != 'green') ? 'LDL / HDL Ratio,' : '';
                        $heartResults['non_hdl_cholesterol'] = ($heartResults['nonhdlcholesterol_color_code'] != 'green') ? 'Non HDL Cholesterol,' : '';
                        $heartResults['high_sensitive_CRP_serum'] = ($heartResults['high_sensitive_CRP_serum_color_code'] != 'green') ? 'High sensitive CRP serum,' : '';
                        $heartResults['apolipoprotein_B_serum'] = ($heartResults['apolipoprotein_B_serum_color_code'] != 'green') ? 'Apolipoprotein B, Serum,' : '';
                        $heartResults['apolipoprotein_A1_serum'] = ($heartResults['apolipoprotein_A1_serum_color_code'] != 'green') ? 'Apolipoprotein A1, Serum,' : '';
                        $heartResults['apolipoprotein_A1_B_serum'] = ($heartResults['apolipoprotein_A1_B_serum_color_code'] != 'green') ? 'APO- B/ APO- A1 Ratio' : '';
                        ?>

                        <?php if (
                            $heartResults['total_cholesterol_color_code'] == 'green' &&
                            $heartResults['triglycerides_color_code'] == 'green' &&
                            $heartResults['hdl_cholesterol_color_code'] == 'green' &&
                            $heartResults['lipoproteincholesterol_color_code'] == 'green' &&
                            $heartResults['total_cholesterolhdlratio_color_code'] == 'green' &&
                            $heartResults['ldlorhdlratio_color_code'] == 'green' &&
                            $heartResults['nonhdlcholesterol_color_code'] == 'green' &&
                            $heartResults['high_sensitive_CRP_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_B_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_A1_serum_color_code'] == 'green' &&
                            $heartResults['apolipoprotein_A1_B_serum_color_code'] == 'green'
                        ) { ?>
                            <td class="tests">Heart - Nill</td>
                        <?php } else { ?>
                            <td class="tests">Heart -
                                <?= $heartResults['total_cholesterol'] ?>
                                <?= $heartResults['triglycerides'] ?>
                                <?= $heartResults['HDL_cholesterol'] ?>
                                <?= $heartResults['low_Density_lipoprotein'] ?>
                            <?= $heartResults['total_cholesterol_hdl_ratio'] ?>
                            <?= $heartResults['ldl_or_hdl_ratio'] ?>
                            <?= $heartResults['non_hdl_cholesterol'] ?>
                            <?= $heartResults['high_sensitive_CRP_serum'] ?>
                            <?= $heartResults['apolipoprotein_B_serum'] ?>
                            <?= $heartResults['apolipoprotein_A1_serum'] ?>
                            <?= $heartResults['apolipoprotein_A1_B_serum'] ?>
                        </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
                <tr>
                    <?php
                    if ($thyroidResults['thyronine_color_code'] != 'green') {
                        $thyroidResults['thyronine'] = 'Thyronine (T3 Total),';
                    } else {
                        $thyroidResults['thyronine'] = '';
                    }
                    if ($thyroidResults['thyroxine_color_code'] != 'green') {
                        $thyroidResults['thyroxine'] = 'Thyroid Thyroxine (T4),';
                    } else {
                        $thyroidResults['thyroxine'] = '';
                    }
                    if ($thyroidResults['tsh_color_code'] != 'green') {
                        $thyroidResults['tsh'] = 'TSH,';
                    } else {
                        $thyroidResults['tsh'] = '';
                    }
                    ?>
                    <?php if ($thyroidResults['thyronine_color_code'] == 'green' && $thyroidResults['thyroxine_color_code'] == 'green' && $thyroidResults['tsh_color_code'] == 'green') { ?>
                        <td class="tests">Thyroid - Nil </td>
                    <?php } else { ?>
                        <td class="tests">Thyroid -
                            <?= $thyroidResults['thyronine'] ?>
                            <?= $thyroidResults['thyroxine'] ?>
                            <?= $thyroidResults['tsh'] ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php
                    if ($kidneyResults['urea_result_color_code'] != 'green') {
                        $kidneyResults['urea'] = 'Urea,';
                    } else {
                        $kidneyResults['urea'] = '';
                    }
                    if ($kidneyResults['creatinine_color_code'] != 'green') {
                        $kidneyResults['creatinine'] = 'Creatinine,';
                    } else {
                        $kidneyResults['creatinine'] = '';
                    }
                    if ($kidneyResults['uricacid_color_code'] != 'green') {
                        $kidneyResults['uric_Acid'] = 'Uric Acid,';
                    } else {
                        $kidneyResults['uric_Acid'] = '';
                    }
                    if ($kidneyResults['calcium_color_code'] != 'green') {
                        $kidneyResults['calcium'] = 'Calcium,';
                    } else {
                        $kidneyResults['calcium'] = '';
                    }
                    if ($kidneyResults['blood_urea_nitrogen_color_code'] != 'green') {
                        $kidneyResults['blood_urea_nitrogen'] = 'Blood Urea Nitrogen (BUN),';
                    } else {
                        $kidneyResults['blood_urea_nitrogen'] = '';
                    }

                    if ($kidneyResults['creatinine_ratio_color_code'] != 'green') {
                        $kidneyResults['creatinine_ratio'] = 'BUN/Creatinine Ratio,';
                    } else {
                        $kidneyResults['creatinine_ratio'] = '';
                    }
                    if ($kidneyResults['magnesium_color_code'] != 'green') {
                        $kidneyResults['magnesium'] = 'Magnesium Serum,';
                    } else {
                        $kidneyResults['magnesium'] = '';
                    }
                    if ($kidneyResults['sodium_result_color_code'] != 'green') {
                        $kidneyResults['sodium_result_color'] = 'Sodium (Na+) Serum,';
                    } else {
                        $kidneyResults['sodium_result_color'] = '';
                    }

                    if ($kidneyResults['potassium_result_color_code'] != 'green') {
                        $kidneyResults['potassium_result_color'] = 'Potassium (K+) Serum,';
                    } else {
                        $kidneyResults['potassium_result_color'] = '';
                    }

                    if ($kidneyResults['chloride_result_color_code'] != 'green') {
                        $kidneyResults['chloride_result_color'] = 'Chloride Serum,';
                    } else {
                        $kidneyResults['chloride_result_color'] = '';
                    }
                    if ($kidneyResults['egfr_color_code'] != 'green') {
                        $kidneyResults['egfr'] = 'eGFR,';
                    } else {
                        $kidneyResults['egfr'] = '';
                    }
                    ?>
                    <?php if (
                        $kidneyResults['urea_result_color_code'] == 'green' && $kidneyResults['creatinine_color_code'] == 'green' &&
                        $kidneyResults['uricacid_color_code'] == 'green' && $kidneyResults['calcium_color_code'] == 'green' &&
                        $kidneyResults['blood_urea_nitrogen_color_code'] == 'green' &&
                        $kidneyResults['creatinine_ratio_color_code'] == 'green'  && $kidneyResults['sodium_result_color_code'] == 'green' && $kidneyResults['potassium_result_color_code'] == 'green' && $kidneyResults['chloride_result_color_code'] == 'green' && $kidneyResults['magnesium_color_code'] == 'green'  && $kidneyResults['egfr_color_code'] == 'green'
                    ) { ?>
                        <td class="tests">Kidney - Nil
                        </td>
                    <?php   } else { ?>
                        <td class="tests">Kidney -
                            <?= $kidneyResults['urea'] ?>
                            <?= $kidneyResults['creatinine'] ?>
                            <?= $kidneyResults['uric_Acid'] ?>
                            <?= $kidneyResults['calcium'] ?>
                            <?= $kidneyResults['blood_urea_nitrogen'] ?>
                            <?= $kidneyResults['creatinine_ratio'] ?>
                            <?= $kidneyResults['sodium_result_color'] ?>
                            <?= $kidneyResults['potassium_result_color'] ?>
                            <?= $kidneyResults['chloride_result_color'] ?>
                            <?= $kidneyResults['magnesium'] ?>
                            <?= $kidneyResults['egfr'] ?>
                        </td>
                    <?php   } ?>
                </tr>
                <tr>
                    <?php
                    if ($liverResults['bilirubin_color_code'] != 'green') {
                        $liverResults['bilirubin_total'] = 'Bilirubin  - Total,';
                    } else {
                        $liverResults['bilirubin_total'] = '';
                    }
                    if ($liverResults['bilirubin_direct_color_code'] != 'green') {
                        $liverResults['bilirubin_direct'] = 'Bilirubin - Direct,';
                    } else {
                        $liverResults['bilirubin_direct'] = '';
                    }
                    if ($liverResults['bilirubin_indirect_color_code'] != 'green') {
                        $liverResults['bilirubin_indirect'] = 'Bilirubin - Indirect,';
                    } else {
                        $liverResults['bilirubin_indirect'] = '';
                    }
                    if ($liverResults['sgpt_alt_color_code'] != 'green') {
                        $liverResults['sgpt_alt'] = 'GSGPT-AL,';
                    } else {
                        $liverResults['sgpt_alt'] = '';
                    }
                    if ($liverResults['sgot_ast_color_code'] != 'green') {
                        $liverResults['sgot_ast'] = 'SGOT-AST,';
                    } else {
                        $liverResults['sgot_ast'] = '';
                    }
                    if ($liverResults['alkaline_phosphatase_color_code'] != 'green') {
                        $liverResults['alkaline_phosphatase'] = 'Alkaline Phosphatase,';
                    } else {
                        $liverResults['alkaline_phosphatase'] = '';
                    }
                    if ($liverResults['ggt_result_found_view'] == 1) {
                        if (($liverResults['ggt_color_code'] != 'green')) {
                            $liverResults['ggt'] = 'Gamma Glutamyl Transferase (GGT),';
                        } else {
                            $liverResults['ggt'] = '';
                        }
                    }
                    if ($liverResults['total_protein_color_code'] != 'green') {
                        $liverResults['total_protein'] = 'Protein Total,';
                    } else {
                        $liverResults['total_protein'] = '';
                    }
                    if ($liverResults['globulin_color_code'] != 'green') {
                        $liverResults['globulin'] = 'Globulin,';
                    } else {
                        $liverResults['globulin'] = '';
                    }
                    if ($liverResults['albumin_color_code'] != 'green') {
                        $liverResults['albumin'] = 'Albumin,';
                    } else {
                        $liverResults['albumin'] = '';
                    }
                    if ($liverResults['ag_ratio_color_code'] != 'green') {
                        $liverResults['ag_ratio'] = 'A : G Ratio,';
                    } else {
                        $liverResults['ag_ratio'] = '';
                    }
                    if ($liverResults['amylase_color_code'] != 'green') {
                        $liverResults['amylase_color'] = 'Amylase Serum ';
                    } else {
                        $liverResults['amylase_color'] = '';
                    }
                    ?>
                    <?php if ($liverResults['ggt_result_found_view'] == 1) { ?>
                        <?php if (
                            $liverResults['bilirubin_color_code'] == 'green' && $liverResults['bilirubin_direct_color_code'] == 'green' &&
                            $liverResults['bilirubin_indirect_color_code'] == 'green' && $liverResults['sgpt_alt_color_code'] == 'green' &&
                            $liverResults['sgot_ast_color_code'] == 'green' && $liverResults['alkaline_phosphatase_color_code'] == 'green' &&
                            $liverResults['ggt_color_code'] == 'green' &&
                            $liverResults['total_protein_color_code'] == 'green' &&
                            $liverResults['globulin_color_code'] == 'green' && $liverResults['albumin_color_code'] == 'green' &&
                            $liverResults['ag_ratio_color_code'] == 'green' &&  $liverResults['amylase_color_code'] == 'green'
                        ) { ?>
                            <td class="tests">Liver - Nil
                            </td>
                        <?php   } else { ?>
                            <td class="tests">Liver -
                                <?= $liverResults['bilirubin_total'] ?>
                                <?= $liverResults['bilirubin_direct'] ?>
                                <?= $liverResults['bilirubin_indirect'] ?>
                                <?= $liverResults['sgpt_alt'] ?>
                                <?= $liverResults['sgot_ast'] ?>
                                <?= $liverResults['alkaline_phosphatase'] ?>
                                <?= $liverResults['ggt'] ?>
                                <?= $liverResults['total_protein'] ?>
                                <?= $liverResults['globulin'] ?>
                                <?= $liverResults['albumin'] ?>
                                <?= $liverResults['ag_ratio'] ?>
                                <?= $liverResults['amylase_color'] ?>
                            </td>
                        <?php   } ?>
                    <?php } else { ?>
                        <?php if (
                            $liverResults['bilirubin_color_code'] == 'green' && $liverResults['bilirubin_direct_color_code'] == 'green' &&
                            $liverResults['bilirubin_indirect_color_code'] == 'green' && $liverResults['sgpt_alt_color_code'] == 'green' &&
                            $liverResults['sgot_ast_color_code'] == 'green' && $liverResults['alkaline_phosphatase_color_code'] == 'green' &&
                            $liverResults['total_protein_color_code'] == 'green' &&
                            $liverResults['globulin_color_code'] == 'green' && $liverResults['albumin_color_code'] == 'green' &&
                            $liverResults['ag_ratio_color_code'] == 'green' &&  $liverResults['amylase_color_code'] == 'green'
                        ) { ?>
                            <td class="tests">Liver - Nil
                            </td>
                        <?php   } else { ?>
                            <td class="tests">Liver -
                                <?= $liverResults['bilirubin_total'] ?>
                                <?= $liverResults['bilirubin_direct'] ?>
                                <?= $liverResults['bilirubin_indirect'] ?>
                                <?= $liverResults['sgpt_alt'] ?>
                                <?= $liverResults['sgot_ast'] ?>
                                <?= $liverResults['alkaline_phosphatase'] ?>
                                <?= $liverResults['total_protein'] ?>
                                <?= $liverResults['globulin'] ?>
                                <?= $liverResults['albumin'] ?>
                                <?= $liverResults['ag_ratio'] ?>
                                <?= $liverResults['amylase_color'] ?>
                            </td>
                        <?php   } ?>
                    <?php   } ?>

                </tr>
                <tr>
                    <?php
                    if ($bloodResults['hemoglobin_color_code'] != 'green') {
                        $bloodResults['hemoglobin'] = 'Hemoglobin,';
                    } else {
                        $bloodResults['hemoglobin'] = '';
                    }
                    if ($bloodResults['rbccount_color_code'] != 'green') {
                        $bloodResults['rbccount_ery'] = 'Erythrocyte Count-RBC,';
                    } else {
                        $bloodResults['rbccount_ery'] = '';
                    }
                    if ($bloodResults['hematocrit_pcv_color_code'] != 'green') {
                        $bloodResults['hematocrit_pcv'] = 'Hematocrit-PCV,';
                    } else {
                        $bloodResults['hematocrit_pcv'] = '';
                    }
                    if ($bloodResults['leukocytes_count_color_code'] != 'green') {
                        $bloodResults['leukocytes_count'] = ' Leukocytes Count - WBC Total,';
                    } else {
                        $bloodResults['leukocytes_count'] = '';
                    }
                    if ($bloodResults['neutrophils_count_color_code'] != 'green') {
                        $bloodResults['neutrophils_count'] = 'Absolute Neutrophils Count,';
                    } else {
                        $bloodResults['neutrophils_count'] = '';
                    }
                    if ($bloodResults['monocyte_count_color_code'] != 'green') {
                        $bloodResults['monocyte_count'] = 'Absolute Monocyte Count,';
                    } else {
                        $bloodResults['monocyte_count'] = '';
                    }
                    if ($bloodResults['corpuscular_volume_color_code'] != 'green') {
                        $bloodResults['corpuscular_volume'] = 'Mean Corpuscular Volume-MCV,';
                    } else {
                        $bloodResults['corpuscular_volume'] = '';
                    }
                    if ($bloodResults['mchc_color_code'] != 'green') {
                        $bloodResults['mchc'] = 'MCHC,';
                    } else {
                        $bloodResults['mchc'] = '';
                    }
                    if ($bloodResults['red_cell_dist_cv_color_code'] != 'green') {
                        $bloodResults['red_cell_dist_cv'] = 'Red Cell Distribution Width CV,';
                    } else {
                        $bloodResults['red_cell_dist_cv'] = '';
                    }
                    if ($bloodResults['red_cell_dist_sd_color_code'] != 'green') {
                        $bloodResults['red_cell_dist_sd'] = 'Red Cell Distribution Width SD,';
                    } else {
                        $bloodResults['red_cell_dist_sd'] = '';
                    }
                    if ($bloodResults['platelets_count_color_code'] != 'green') {
                        $bloodResults['platelets_count'] = 'Platelet Count,';
                    } else {
                        $bloodResults['platelets_count'] = '';
                    }
                    if ($bloodResults['mpv_color_code'] != 'green') {
                        $bloodResults['mpv'] = 'MPV,';
                    } else {
                        $bloodResults['mpv'] = '';
                    }
                    if ($bloodResults['pdw_color_code'] != 'green') {
                        $bloodResults['pdw'] = 'PDW,';
                    } else {
                        $bloodResults['pdw'] = '';
                    }
                    if ($bloodResults['platelet_crit_color_code'] != 'green') {
                        $bloodResults['platelet_crit'] = 'Platelet Crit,';
                    } else {
                        $bloodResults['platelet_crit'] = '';
                    }
                    if ($bloodResults['lymphocyte_count_color_code'] != 'green') {
                        $bloodResults['lymphocyte_count'] = 'Absolute Lymphocyte Count,';
                    } else {
                        $bloodResults['lymphocyte_count'] = '';
                    }
                    if ($bloodResults['eosinophil_count_color_code'] != 'green') {
                        $bloodResults['eosinophil_count'] = 'Absolute Eosinophil Count,';
                    } else {
                        $bloodResults['eosinophil_count'] = '';
                    }
                    if ($bloodResults['basophil_count_color_code'] != 'green') {
                        $bloodResults['basophil_count'] = 'Absolute Basophil Count,';
                    } else {
                        $bloodResults['basophil_count'] = '';
                    }
                    if ($bloodResults['neutrophils_color_code'] != 'green') {
                        $bloodResults['neutrophils_color'] = 'Neutrophils,';
                    } else {
                        $bloodResults['neutrophils_color'] = '';
                    }
                    if ($bloodResults['lymphocyte_color_code'] != 'green') {
                        $bloodResults['lymphocyte_color'] = 'Lymphocyte,';
                    } else {
                        $bloodResults['lymphocyte_color'] = '';
                    }
                    if ($bloodResults['monocytes_color_code'] != 'green') {
                        $bloodResults['monocytes_color'] = 'Monocytes,';
                    } else {
                        $bloodResults['monocytes_color'] = '';
                    }
                    if ($bloodResults['lactate_dehydragenase_LDH_serum__color_code'] != 'green') {
                        $bloodResults['lactate_dehydragenase_LDH_serum__color'] = 'Lactatedehydragenase (LDH) Serum,';
                    } else {
                        $bloodResults['lactate_dehydragenase_LDH_serum__color'] = '';
                    }
                    if ($bloodResults['erythrocyte_sedimentation_color_code'] != 'green') {
                        $bloodResults['erythrocyte_sedimentation'] = 'ESR EDTA Blood,';
                    } else {
                        $bloodResults['erythrocyte_sedimentation'] = '';
                    }
                    if ($bloodResults['mch_color_code'] != 'green') {
                        $bloodResults['mch_color'] = 'MCH (Mean Corpuscular Hb),';
                    } else {
                        $bloodResults['mch_color'] = '';
                    }
                    ?>
                    <?php if (
                        $bloodResults['hemoglobin_color_code'] == 'green' && $bloodResults['rbccount_color_code'] == 'green' &&
                        $bloodResults['hematocrit_pcv_color_code'] == 'green' && // $bloodResults['platelet_cell_ratio_color_code'] == 'green' &&
                        $bloodResults['leukocytes_count_color_code'] == 'green' && $bloodResults['neutrophils_count_color_code'] == 'green' &&
                        $bloodResults['monocyte_count_color_code'] == 'green' && $bloodResults['corpuscular_volume_color_code'] == 'green' &&
                        $bloodResults['mchc_color_code'] == 'green' && $bloodResults['red_cell_dist_cv_color_code'] == 'green' &&
                        $bloodResults['platelets_count_color_code'] == 'green' && $bloodResults['mpv_color_code'] == 'green' &&
                        $bloodResults['pdw_color_code'] == 'green' && $bloodResults['platelet_crit_color_code'] == 'green' &&
                        $bloodResults['lymphocyte_count_color_code'] == 'green' && $bloodResults['eosinophil_count_color_code'] == 'green' &&
                        $bloodResults['basophil_count_color_code'] == 'green' &&  $bloodResults['neutrophils_color_code'] == 'green' &&
                        $bloodResults['lymphocyte_color_code'] == 'green' && $bloodResults['monocytes_color_code'] == 'green' &&
                        $bloodResults['lactate_dehydragenase_LDH_serum__color_code'] == 'green' && ($bloodResults['erythrocyte_sedimentation_color_code'] == 'green') && $bloodResults['mch_color_code'] == 'green'
                    ) { ?>
                        <td class="tests">Blooad - Nill </td>

                    <?php } else { ?>
                        <td class="tests">Blood -
                            <?= $bloodResults['hemoglobin'] ?>
                            <?= $bloodResults['rbccount_ery'] ?>
                            <?= $bloodResults['hematocrit_pcv'] ?>
                            <?= $bloodResults['leukocytes_count'] ?>
                            <?= $bloodResults['neutrophils_count'] ?>
                            <?= $bloodResults['monocyte_count'] ?>
                            <?= $bloodResults['corpuscular_volume'] ?>
                            <?= $bloodResults['mchc'] ?>
                            <?= $bloodResults['red_cell_dist_cv'] ?>
                            <?= $bloodResults['red_cell_dist_sd'] ?>
                            <?= $bloodResults['platelets_count'] ?>
                            <?= $bloodResults['mpv'] ?>
                            <?= $bloodResults['pdw'] ?>
                            <?= $bloodResults['platelet_crit'] ?>
                            <?= $bloodResults['lymphocyte_count'] ?>
                            <?= $bloodResults['eosinophil_count'] ?>
                            <?= $bloodResults['basophil_count'] ?>
                            <?= $bloodResults['neutrophils_color'] ?>
                            <?= $bloodResults['lymphocyte_color'] ?>
                            <?= $bloodResults['monocytes_color'] ?>
                            <?= $bloodResults['lactate_dehydragenase_LDH_serum__color'] ?>
                            <?= $bloodResults['erythrocyte_sedimentation'] ?>
                            <?= $bloodResults['mch_color'] ?>

                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php
                    if ($miniralVitaminIronResults['vitaminbtwelve_color_code'] != 'green') {
                        $miniralVitaminIronResults['vitaminbtwelve_color'] = 'Vitamin B12,';
                    } else {
                        $miniralVitaminIronResults['vitaminbtwelve_color'] = '';
                    }
                    if ($miniralVitaminIronResults['vitamind_color_code'] != 'green') {
                        $miniralVitaminIronResults['vitamind_twentyfive'] = 'Vitamin D-25 Hydroxy,';
                    } else {
                        $miniralVitaminIronResults['vitamind_twentyfive'] = '';
                    }
                    if ($miniralVitaminIronResults['phosphorus_color_code'] != 'green') {
                        $miniralVitaminIronResults['phosphorus'] = 'Phosphorus,';
                    } else {
                        $miniralVitaminIronResults['phosphorus'] = '';
                    }
                    if ($miniralVitaminIronResults['iron_color_code'] != 'green') {
                        $miniralVitaminIronResults['iron'] = 'Iron,';
                    } else {
                        $miniralVitaminIronResults['iron'] = '';
                    }
                    if ($miniralVitaminIronResults['uibc_color_code'] != 'green') {
                        $miniralVitaminIronResults['uibc'] = 'UIBC,';
                    } else {
                        $miniralVitaminIronResults['uibc'] = '';
                    }
                    if ($miniralVitaminIronResults['tibc_color_code'] != 'green') {
                        $miniralVitaminIronResults['tibc'] = 'TIBC,';
                    } else {
                        $miniralVitaminIronResults['tibc'] = '';
                    }
                    if ($miniralVitaminIronResults['testosterone_color_code'] != 'green') {
                        $miniralVitaminIronResults['testosterone'] = 'Testosterone Total Serum,';
                    } else {
                        $miniralVitaminIronResults['testosterone'] = '';
                    }
                    if ($miniralVitaminIronResults['iron_saturation_color_code'] != 'green') {
                        $miniralVitaminIronResults['iron_saturation'] = 'Iron Saturation,';
                    } else {
                        $miniralVitaminIronResults['iron_saturation'] = '';
                    }

                    ?>

                    <?php if (
                        $miniralVitaminIronResults['vitaminbtwelve_color_code'] == 'green' &&
                        $miniralVitaminIronResults['vitamind_color_code'] == 'green' &&
                        $miniralVitaminIronResults['phosphorus_color_code'] == 'green' &&
                        $miniralVitaminIronResults['iron_color_code'] == 'green' &&
                        $miniralVitaminIronResults['uibc_color_code'] == 'green' &&
                        $miniralVitaminIronResults['tibc_color_code'] == 'green' &&  $miniralVitaminIronResults['testosterone_color_code'] == 'green' &&   $miniralVitaminIronResults['iron_saturation_color_code'] == 'green'
                    ) { ?>
                        <td class="tests">Vitamins, Minerals,Iron & Hormone - Nill</td>
                    <?php } else { ?>
                        <td class="tests">Vitamins, Minerals,Iron & Hormone -
                            <?= $miniralVitaminIronResults['vitaminbtwelve_color'] ?>
                            <?= $miniralVitaminIronResults['vitamind_twentyfive'] ?>
                            <?= $miniralVitaminIronResults['phosphorus'] ?>
                            <?= $miniralVitaminIronResults['iron']
                            ?>
                            <?= $miniralVitaminIronResults['uibc']
                            ?>
                            <?= $miniralVitaminIronResults['tibc']
                            ?>
                            <?= $miniralVitaminIronResults['testosterone'] ?>
                            <?= $miniralVitaminIronResults['iron_saturation']?>

                        </td>
                    <?php } ?>
                </tr>

                <?php if (!$urineResults['urinestatus_found']) { ?>
                    <tr>
                        <?php
                        if ($urineResults['urine_specific_gravity_color_code'] != 'green') {
                            $urineResults['urine_specific_gravity'] = 'Specific Gravity,';
                        } else {
                            $urineResults['urine_specific_gravity'] = '';
                        }
                        if ($urineResults['urine_ph_color_code'] != 'green') {
                            $urineResults['urine_ph'] = 'pH,';
                        } else {
                            $urineResults['urine_ph'] = '';
                        }
                        if ($urineResults['urine_protein_color_code'] != 'green') {
                            $urineResults['urine_protein'] = 'Protein,';
                        } else {
                            $urineResults['urine_protein'] = '';
                        }
                        if ($urineResults['bacteria_color_code'] != 'green') {
                            $urineResults['bacteria'] = 'Bacteria,';
                        } else {
                            $urineResults['bacteria'] = '';
                        }
                        if ($urineResults['urine_glucose_color_code'] != 'green') {
                            $urineResults['urine_glucose'] = 'Glucose,';
                        } else {
                            $urineResults['urine_glucose'] = '';
                        }
                        if ($urineResults['urine_ketones_color_code'] != 'green') {
                            $urineResults['urine_ketones'] = 'Ketones,';
                        } else {
                            $urineResults['urine_ketones'] = '';
                        }
                        if ($urineResults['urine_urobilinogen_color_code'] != 'green') {
                            $urineResults['urine_urobilinogen'] = 'Urobilinogen,';
                        } else {
                            $urineResults['urine_urobilinogen'] = '';
                        }
                        if ($urineResults['urine_bilirubin_color_code'] != 'green') {
                            $urineResults['urine_bilirubin'] = 'Bilirubin,';
                        } else {
                            $urineResults['urine_bilirubin'] = '';
                        }
                        if ($urineResults['urine_nitrite_color_code'] != 'green') {
                            $urineResults['urine_nitrite'] = 'Nitrite,';
                        } else {
                            $urineResults['urine_nitrite'] = '';
                        }
                        if ($urineResults['urine_blood_color_code'] != 'green') {
                            $urineResults['urine_blood'] = 'Blood,';
                        } else {
                            $urineResults['urine_blood'] = '';
                        }
                        if ($urineResults['urine_crystals_color_code'] != 'green') {
                            $urineResults['urine_crystals'] = 'Crystals,';
                        } else {
                            $urineResults['urine_crystals'] = '';
                        }
                        if ($urineResults['urine_puscell_color_code'] != 'green') {
                            $urineResults['urine_puscell'] = 'Pus Cell,';
                        } else {
                            $urineResults['urine_puscell'] = '';
                        }
                        if ($urineResults['urine_epithelialcell_color_code'] != 'green') {
                            $urineResults['urine_epithelialcell'] = 'Epithelial Cells,';
                        } else {
                            $urineResults['urine_epithelialcell'] = '';
                        }
                        if ($urineResults['urine_yeast_color_code'] != 'green') {
                            $urineResults['urine_yeast'] = 'Yeast,';
                        } else {
                            $urineResults['urine_yeast'] = '';
                        }
                        if ($urineResults['urine_appearance_color_code'] != 'green') {
                            $urineResults['urine_appearance'] = 'Appearance,';
                        } else {
                            $urineResults['urine_appearance'] = '';
                        }
                        if ($urineResults['rbcs_color_code'] != 'green') {
                            $urineResults['rbcs'] = 'RBCs,';
                        } else {
                            $urineResults['rbcs'] = '';
                        }
                        if ($urineResults['casts_color_code'] != 'green') {
                            $urineResults['casts'] = 'Casts,';
                        } else {
                            $urineResults['casts'] = '';
                        }
                        ?>
                        <?php if (!$urineResults['urinestatus_found']) { ?>
                            <?php if (
                                $urineResults['urine_specific_gravity_color_code'] == 'green' && $urineResults['urine_ph_color_code'] == 'green' &&
                                $urineResults['urine_protein_color_code'] == 'green' && $urineResults['urine_glucose_color_code'] == 'green' &&
                                $urineResults['urine_ketones_color_code'] == 'green' && $urineResults['urine_urobilinogen_color_code'] == 'green' && $urineResults['bacteria_color_code'] == 'green' &&
                                $urineResults['urine_bilirubin_color_code'] == 'green' && $urineResults['urine_nitrite_color_code'] == 'green' &&
                                $urineResults['urine_blood_color_code'] == 'green' && $urineResults['urine_crystals_color_code'] == 'green' &&
                                $urineResults['urine_puscell_color_code'] == 'green' && $urineResults['urine_epithelialcell_color_code'] == 'green' &&
                                $urineResults['urine_yeast_color_code'] == 'green' && $urineResults['urine_appearance_color_code'] == 'green' &&
                                $urineResults['rbcs_color_code'] == 'green' && $urineResults['casts_color_code'] == 'green'
                            ) { ?>
                                <td class="tests">Urine - Nil </td>
                            <?php } else { ?>
                                <td class="tests">Urine -
                                    <?= $urineResults['urine_specific_gravity'] ?>
                                    <?= $urineResults['urine_ph'] ?>
                                    <?= $urineResults['urine_protein'] ?>
                                    <?= $urineResults['urine_glucose'] ?>
                                    <?= $urineResults['urine_ketones'] ?>
                                    <?= $urineResults['urine_bilirubin'] ?>
                                    <?= $urineResults['urine_nitrite'] ?>
                                    <?= $urineResults['urine_blood'] ?>
                                    <?= $urineResults['urine_crystals'] ?>
                                    <?= $urineResults['bacteria'] ?>
                                    <?= $urineResults['urine_puscell'] ?>
                                    <?= $urineResults['urine_epithelialcell'] ?>
                                    <?= $urineResults['urine_yeast'] ?>
                                    <?= $urineResults['urine_appearance'] ?>
                                    <?= $urineResults['rbcs'] ?>
                                    <?= $urineResults['casts'] ?>
                                </td>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <footer style="
		position: absolute; 
		bottom: -10px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0; 
		page-break-before: always;">
            <div>
                <?php echo $footerWithLogo; ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>



    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="padding-top:50px;">
            <div style="width:100%;">
                <?php echo $co_brand_header2; ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td><img src="https://cdn.shop.lifecell.in/reports/wellness/images/wr-header-divider.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <table>
                <tr class="d-block">
                    <td style="border-right: 1px solid #00977b;padding-right: 10px;padding-left: 10px;">
                        <img style="width:50px;" src="https://cdn.shop.lifecell.in/reports/wellness/images/screening-icon.png" alt="">
                    </td>
                    <td></td>
                    <td class="nutrition"> Suggestions for preventive screening</td>
                </tr>
            </table>
            <table style="font-size:14px; padding-top:16px; padding-bottom: 17px;font-weight:700;" class="float-left w-30">
                <tr>
                    <td>Risks Factors</td>
                    <td>Recommended Tests</td>
                </tr>
            </table>
            <table style="width: 70%;font-size: 14px; font-weight:normal;" class="float-left border-collapse">
                <tr>
                    <td style="border-bottom: 1px solid #444444;padding-bottom: 5px;"></td>
                    <td style="border-bottom: 1px solid #444444;padding-bottom: 5px;"></td>
                    <td style="border-bottom: 1px solid #444444;padding-bottom: 5px; font-weight: 600;">Age Group</td>
                    <td style="border-bottom: 1px solid #444444;padding-bottom: 5px;"></td>
                </tr>
                <tr style="text-align: center;">
                    <td style="padding-top: 5px;padding-bottom: 8px;font-weight: 600;">
                        (18-29 Yrs.)</td>
                    <td style="padding-top: 5px;padding-bottom: 8px;font-weight: 600;">
                        (30-39 Yrs.)</td>
                    <td style="padding-top: 5px;padding-bottom: 8px;font-weight: 600;">
                        (40-55 Yrs.)</td>
                    <td style="padding-top: 5px;padding-bottom: 8px;font-weight: 600;">
                        (Above 55 Yrs.)</td>
                </tr>
            </table>
            <table style="border-bottom:1px solid #ACACAD; font-size:14px; border-top: 1px solid #0293B2;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Diabetes</td>
                    <td style="padding-left: 80px;">HbA1c</br>
                        Blood Glucose</br> fasting</td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="  border-bottom: 1px solid #ACACAD;  font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Thyroid</br>Disorder</td>
                    <td style="padding-left: 80px;">Thyroid Profile-Total</br>(T3, T4 & TSH Ultra-</br> sensitive)</td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="border-bottom: 1px solid #ACACAD; font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Vitamin-D</br>Deficiency</td>
                    <td style="padding-left: 65px;">Vitamin D Total 25</br>-Hydroxy </td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="  border-bottom: 1px solid #ACACAD; font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Vitamin B12</br> Deficiency</td>
                    <td style="padding-left: 60px;">Vitamin B12</br>Cyanocobalamin</td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="  border-bottom: 1px solid #ACACAD; font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">High</br>Cholesterol</br>/Dyslipidemia</td>
                    <td style="padding-left: 50px;">Lipid Profile</br>Cholesterol-Total,</br>Serum</td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="border-bottom: 1px solid #ACACAD; font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Kidney</br>Disorder </td>
                    <td style="padding-left: 80px;">Kidney function test</br>Urine Routine &</br>MicroscopySerum </br>Urea Serum</td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="float-left w-17">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <table style="font-size: 14px;">
                <tr class="float-left w-30">
                    <td style="font-weight:600;">Liver Disorder</td>
                    <td style="padding-left: 50px;">Liver function test</br>SGOT/AST</br>SGPT/ALT</td>
                </tr>
                <tr class="w-17 float-left">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="w-17 float-left">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="w-17 float-left">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
                <tr class="w-17 float-left">
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></td>
                    <td><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></td>
                </tr>
            </table>
            <div style="padding-top: 20px;">
                <p class="details-img"><span><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-1.png" alt="" /></span>Recommended</p>
                <p class="details-img"><span><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-5.png" alt="" /></span>Strongly Recommended</p>
                <p class="details-img"><span><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-2.png" alt="" /></span>Screen annually</p>
                <p class="details-img"><span> <img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-3.png" alt="" /></span>Repeat earlier in case of symptoms</p>
                <p class="details-img"><span><img class="screening-icon" src="https://cdn.shop.lifecell.in/reports/wellness/images/icon-screening-4.png" alt="" /></span>Under treatment- Repeat every 3 months</p>
            </div>
        </div>

        <div class="wr-disclaimer" style="width:100%; padding-bottom:10px;">
            <p class="title" style="color:#a5247a; font-size:16px; padding:10px 0px 2px;">Disclaimer</p>
            <div style="width:70%; float:left;">
                <p style="font-size:12px;">This is an electronically authenticated report, if test results are alarming or unexpected, customer/Client is advised to contact the customer care immediately for possible remedial action. All lab results are subject to clinical interpretation by qualified medical professional and this report is not subject to use for any medico-legal purpose.</p>
            </div>
            <div style="width: 28%; border-left: 1px solid #ccc; vertical-align: middle; float:right; text-align:right;">
                <p><a style="font-size:12px; margin-right:10px; text-decoration:none;" href="mailto:care@lifecell.in"><img style="padding-right:10px; padding-bottom:3px; width:20px; vertical-align:middle;" src="https://cdn.shop.lifecell.in/reports/wellness/images/mail-icon-wr.png" alt='' />care@lifecell.in</a>
                    <a style="font-size:12px; margin-right:10px; text-decoration:none;" href="tel:1800 266 5533"><img style="padding-right:10px; padding-bottom:3px; width:20px; vertical-align:middle;" src="https://cdn.shop.lifecell.in/reports/wellness/images/call-brand-color.png" alt='' />1800 266 5533</a>
                </p>
                <p><a style="font-size:12px; margin-right:10px; text-decoration:none;" href="tel:+917845756259"><img style="padding-right: 1px; width:22px; vertical-align:middle;" src="https://cdn.shop.lifecell.in/reports/wellness/images/whatsapp-icon-wr.png" alt='' />+91 78457 56259</a>
                    <a style="font-size:12px; margin-right:10px; text-decoration:none;" href="https://www.lifecell.in" target="_blank"><img style="padding-right:7px; width:20px; vertical-align:middle;" src="https://cdn.shop.lifecell.in/reports/wellness/images/web-brand-color.png" alt='' />www.lifecell.in</a>
                </p>
            </div>
            <!-- <div style="padding-top:25%;"></div> -->
        </div>

        <footer style="
		position: absolute; 
		bottom: -302px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0;">
            <div>
                <?php echo $footerWithLogo; ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>

    </div>






    <div class="body-cl" style="min-height: 1110px; position: relative; padding: 0px;">
        <div class="resultDetails" style="page-break-before:always;padding-top:0px;">
            <div style="width:100%; position: absolute;">
                <br>
                <?php echo $co_brand_banner; ?>
            </div>
            <div class="title" style="padding-bottom:5%;">
                <div style="height: 1230px; overflow: hidden; padding: 0px 10px; margin: 0 auto;">
                    <!-- <img style="width:100%; display:block;" src="<?= base_url('images/wellness/lab_network_image.jpg') ?>" alt="" /> -->
                    <img style="width:100%; display:block;" src="<?= base_url('images/wellness/lab_network_image-new.png') ?>" alt="" />
                </div>
            </div>
        </div>
        <footer style="
		position: absolute; 
		bottom: -125px; 
		left: 0;
		width: 100%; 
		text-align: center; 
		padding: 10px 0;">
            <div>
                <?php echo $footerWithLogo; ?>
            </div>
            <div class="pageno">Page <?= $c_page++ ?> of <?= $Total_pg_no ?></div>
        </footer>
    </div>
    </div>
</body>

</html>