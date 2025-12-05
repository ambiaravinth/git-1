<?php
namespace App\Controllers\Cron;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ReportDataModel;
use App\Models\PNSReportDataModel;
use App\Models\SpermReportDataModel;
use App\Models\ReportLogsModel;
use App\Models\LimsModel;
use App\Models\StoreConfig;
use App\Models\CategoryModel;
use App\Models\CronScheduleModel;
use App\Models\LimsSlimsModel;
use App\Models\OvaScoreDataModel;
use App\Models\PerimenopauseDataModel;
use App\Models\AnnualStemMatchDataModel;
use App\Models\HpvDataModel;
use App\Models\ChlamydiaGonorrheaDataModel;
use App\Models\CbDataModel;
use App\Models\StdReportDataModel;
use App\Models\PharmaCoGenomicsDataModel;
use App\Models\WellnessDataModel;
ini_set('memory_limit', '518M');
class StoreJsonMultipleTestGroupCode extends ResourceController
{
    public function __construct()
    {
        $this->tablename = '';
        $this->model = '';
        $this->report_id = '';
        $this->limsModel = new LimsModel();
        $this->reportModel = new ReportDataModel();
        $this->wellnessDataModel = new WellnessDataModel();
        $this->configModel = new StoreConfig();
        $this->cronschedulemodel = new CronScheduleModel();
        $this->limsslimsmodel = new LimsSlimsModel();
        helper('common');
    }

    use ResponseTrait;
    /***
     * TABLE -> lims_data
     * Column -> is_stored
     * is_stored = 0    //  Pending to store json file
     * is_stored = 1    //  Final Json Data File stored Successfully
     * is_stored = 2    //  Invalid JSON or Data attribute not found or File not Found
     * is_stored = 3    //  Same Json File
     * is_stored = 4    //  waiting for test code details
     * is_stored = 5    //  New Test Code Json Data
     * 
     * TABLE -> 
     * report_status = 0 //InProgress
     * report_status = 1 //Ready to Generate Report
     */


    /****
     * Common Function to Store JSON and save/update details in database
     */
    public function StoreJSONMultipleTestgroupcode($limsSingleData,$reporttype)
    {

        $lims_data_filpath = FCPATH . $limsSingleData['insert_data'];
        if (file_exists($lims_data_filpath)) {

            /******************* VALIDATE JSON DATA START ********************/
            $json = file_get_contents($lims_data_filpath);
            $Jsondata = array();
            try {
                $Jsondata = json_decode(utf8_encode($json));
                $lab_id = $Jsondata->data->PatientDetails[0]->LAB_ID;
                $crm_id = $Jsondata->data->PatientDetails[0]->PATIENT_ID ?? "";
                $crm_name = $Jsondata->data->PatientDetails[0]->PATIENT_NAME ?? "";
                $mobile_no = $Jsondata->data->PatientDetails[0]->CONTACT_PHONE_NO ?? "";
                $bs_code = !empty($Jsondata->data->PatientDetails[0]->CENTER_CODE) ? $Jsondata->data->PatientDetails[0]->CENTER_CODE : null;
                $branch_name = $Jsondata->data->PatientDetails[0]->BRANCH_NAME ?? "";
                $sample_reg_date = $Jsondata->data->PatientDetails[0]->REGISTRATION_DATE ?? null;
                $report_release_date = $Jsondata->data->TestGroupDetails[0]->APPROVED_ON ?? null;
                if($mobile_no!=$Jsondata->data->PatientDetails[0]->CONTACT_MOBILE_NO){
                    $mobile_no.= !empty($Jsondata->data->PatientDetails[0]->CONTACT_MOBILE_NO)?"|".$Jsondata->data->PatientDetails[0]->CONTACT_MOBILE_NO : "";
                }
                // $email_id = $Jsondata->data->PatientDetails[0]->client_email ?? "";
                // CB report fetch client email based on COMMELG test-group-code
                if($reporttype=='cb' &&  $Jsondata->data->TestGroupDetails[1]->TEST_GROUP_CODE == 'COMMELG'){
                    $email_id = $Jsondata->data->PatientDetails[0]->client_email;
                }else{
                    $email_id = $Jsondata->data->PatientDetails[0]->client_email ?? "";
                }

                // start wellness package distinguish
                if ($reporttype == 'wellness') {
                $wellness_service_code = [
                    'AYN_016' => 'AYN_016',
                    'AYN_017' => 'AYN_017',
                    'AYN_018' => 'AYN_018',
                    'AYN_019' => 'AYN_019',
                    'AYN_020' => 'AYN_020',
                    'AYN_021' => 'AYN_021',
                    'AYN_022' => 'AYN_022',
                    'AYN_025' => 'AYN_025',
                    'AYN_026' => 'AYN_026',
                    'AYN_027' => 'AYN_027',
                    'AYN_028' => 'AYN_028',
                    'AYN_029' => 'AYN_029',
                    'AYN_030' => 'AYN_030',
                    'AYN_031' => 'AYN_031',
                ];

                $service_type = null;
                if (empty($Jsondata->data->TestGroupDetails) || !is_array($Jsondata->data->TestGroupDetails)) {
                    echo '<br> Invalid or missing TestGroupDetails in JSON.';
                }
            
                // Loop through test groups and look for matching package code
                    foreach ($Jsondata->data->TestGroupDetails as $testGroup) {
                    if (empty($testGroup->PackageCode)) {
                        continue;
                    }
            
                    if (array_key_exists($testGroup->PackageCode, $wellness_service_code)) {
                            $service_type = $testGroup->PackageCode;
                            break;
                        }
                    }
                if ($service_type) {
                    $template_version = getTemplateVersionforWellness('wellness', $service_type);


                    if (empty($template_version)) {
                        $msg = '<br> Template version not available for Packagecode';
                        echo $msg;
                        return;
                    }

                    $template_version_no = $template_version[0]->version_no;
                } else {

                    $msg = '<br> No Pacakgecode found in the JSON.';
                    echo $msg;
                    return;
                }
                }
                // end wellness package distinguish

            } catch (\Exception $e) {
                echo $e;
                echo "Data not found";
                $this->updateLIMSStatus($limsSingleData['lims_id'], [
                    'is_stored' => 2,
                    'message' => 'Data attribute not found'
                ]);
                return;
            }
            /******************* VALIDATE JSON DATA END *********************/
            $commonPayload = [
                'lab_id' => $lab_id,
                'lims_data_filpath' => $lims_data_filpath,
                'crm_id' => $crm_id,
                'crm_name' => $crm_name,
                'lims_id' => $limsSingleData['lims_id'],
                'mobile_no' => $mobile_no,
                'email_id' => $email_id
            ];
            // start wellness package distinguish
            if ($reporttype == 'wellness') {
                $commonPayload = array_merge($commonPayload, [
                    'service_type' => $service_type,
                    'template_version' => $template_version_no,
                    'failed_reason_email_sent' => 0,
                    'is_generated' => 0,
                    'is_failed' => 0,
                    'failed_reason' => '',
                    'email_sent' => 0,
                    'isrsattachmentsent' => 0,
                    'reporttype' => $reporttype,
                    'bs_code' => $bs_code,
                    'branch_name' => $branch_name,
                    'sample_reg_date' => $sample_reg_date,
                    'report_release_date'=>$report_release_date,
                    'failed_reason_email' =>''
                ]);
            }
            // end wellness package distinguish
            $fetchTestDetails = $Jsondata->data->TestGroupDetails ?? array();
            $testGroupCode = array_values(array_unique(array_column($fetchTestDetails,'TEST_GROUP_CODE')));
            $this->tablename = '';
            $this->model = NULL;
            $this->getReportConfig($reporttype);
            $commonPayload['reg_type'] = $reporttype;
            $this->storeJSONFile($json, $lab_id, trim(implode(",",$testGroupCode)), $commonPayload, $limsSingleData);
            if (file_exists($lims_data_filpath)) {
                unlink($lims_data_filpath);
            }
               
        } else {
            echo "File Not Found";
            $this->updateLIMSStatus($limsSingleData['lims_id'], [
                'is_stored' => 2,
                'message' => 'File not found'
            ]);
        }
    }

    // function saveInReportDataTable($data)
    // {

    //     $reportData = $this->checkLabRecordExist($data['lab_id'],$data['testgroupcode'],$data['report_type']);
    //     if (empty($reportData)) {
    //         $this->reportModel->insert($data);
    //     }else{
    //         $this->reportModel->where('entity_id',$reportData[0]->entity_id)->where("lab_id", $data['lab_id'])->where("testgroupcode", $data['testgroupcode'])->set([
    //                 'testgroupcode' => $data['testgroupcode'],
    //                 'report_type' => $data['report_type'],
    //                 'report_status' => $data['report_status']
    //             ])->update();
    //     }
    // }

    function saveInReportDataTable($data)
    {
        $db = \Config\Database::connect();

        // Check if the record exists
        $sql = "SELECT * FROM report_data WHERE lab_id = ? AND testgroupcode = ? AND report_type = ?";
        $query = $db->query($sql, [$data['lab_id'], $data['testgroupcode'], $data['report_type']]);
        $reportData = $query->getResult();

        if (empty($reportData)) {
            // Perform Insert
            $sql = "INSERT INTO report_data (lab_id, testgroupcode, report_type, report_status) VALUES (?, ?, ?, ?)";
            $insert = $db->query($sql, [$data['lab_id'], $data['testgroupcode'], $data['report_type'], $data['report_status']]);

            if ($insert) {
                echo "Data inserted successfully.";
            } else {
                echo "Insert failed: " . $db->error();
            }
        } else {
            // Perform Update
            $sql = "UPDATE report_data 
                SET report_type = ?, report_status = ?
                WHERE entity_id = ? AND lab_id = ? AND testgroupcode = ?";
            $update = $db->query($sql, [$data['report_type'], $data['report_status'], $reportData[0]->entity_id, $data['lab_id'], $data['testgroupcode']]);

            if ($update) {
                echo "Data updated successfully.";
            } else {
                echo "Update failed: " . $db->error();
            }
        }
    }

    function getReportTypes()
    {
        $category_model = new CategoryModel();
        return $category_model->select('testgroupcode,report_type,report_code')->where('testgroupcode is not null')->find();
    }

    function storeJSONFile($json_data, $lab_id, $testGroupCode, $commonPayload, $lims_data)
    {
        //========= FIND EQUIVALENT TEST GROUP CODE ============//
        if ($this->checkReportExist($lab_id)) {
            $isResponseMatch = false;
            $old_json = NULL;
            /*************** CHECK LAB ID ALREADY EXIST ************/
            $oldData = $this->getReportExist($lab_id);
            $old_filepath = $oldData[0]->filepath;
            $old_filepath_json = FCPATH . $old_filepath;

            if (file_exists($old_filepath_json)) {
                $old_json = file_exists($old_filepath_json) ? file_get_contents($old_filepath_json) : array();
                $old_decoded_json = $old_json ? json_decode($old_json) : array();
                $new_decoded_json = json_decode($json_data);
                if(isset($old_decoded_json->data)){
                    $isResponseMatch = ($old_decoded_json->data == $new_decoded_json->data) ? true :false;
                }
            }

            if ($isResponseMatch) {
                /************ UPDATE SAME JSON FLAG **************/
                $sameJsonData = [
                    'lab_id' => $lab_id,
                    'crm_id' => $commonPayload['crm_id'],
                    'is_stored' => 3,
                    'message' => 'Same Json Data pushed'
                ];
                // start wellness package distinguish
                if($commonPayload['reg_type'] == 'wellness'){
                    $existing = $this->model->where('lab_id', $lab_id)->first();
                    if($existing['is_generated'] == 2){
                        $existing['is_generated'] = 0;
                    }
                    if($existing['email_sent'] == 2){
                        $existing['email_sent'] = 0;
                    }
                    if($existing['isrsattachmentsent'] == 2){
                        $existing['isrsattachmentsent'] = 0;
                    }
                     if($existing['isrsattachmentsenttomagento'] == 2){
                        $existing['isrsattachmentsenttomagento'] = 0;
                    }
                    $report_type = $commonPayload['reg_type'] ?? '';
                    $service_type = $commonPayload['service_type'] ?? '';
                    $template_version_no = $commonPayload['template_version'] ?? '';
                    $bs_code = $commonPayload['bs_code'] ?? null;
                    $branch_name = $commonPayload['branch_name'] ?? '';
                    $sample_reg_date = $commonPayload['sample_reg_date'] ?? null;
                    $report_release_date = $commonPayload['report_release_date'] ?? null;
                    if (!empty($service_type)) {
                        $commonPayload['report_type'] = $report_type;
                        $commonPayload['service_type'] = $service_type;
                        $commonPayload['template_version'] = $template_version_no;
                        $commonPayload['failed_reason_email_sent'] = 0;
                        $commonPayload['is_generated'] = $existing['is_generated'];
                        $commonPayload['is_failed'] = 0;
                        $commonPayload['failed_reason'] = '';
                        $commonPayload['email_sent'] = $existing['email_sent'];
                        $commonPayload['isrsattachmentsent'] = $existing['isrsattachmentsent'];
                        $commonPayload['isrsattachmentsenttomagento'] = $existing['isrsattachmentsenttomagento'];
                        $commonPayload['json_update_date'] =  date('Y-m-d H:i:s');
                        $commonPayload['bs_code'] = $bs_code;
                        // $commonPayload['reportregenerationdate'] = null;
                        // $commonPayload['repushpdfdate'] = null;
                        $commonPayload['branch_name'] = $branch_name;
                        $commonPayload['sample_reg_date'] = $sample_reg_date;
                        $commonPayload['failed_reason_email'] = '';
                        $commonPayload['resend_date'] = null;
                        $commonPayload['resend_mail_status'] = 0;
                        $commonPayload['report_release_date'] = $report_release_date;

    
                    }
                    //debug( $commonPayload);
                    $this->updateWellnessData($commonPayload['lab_id'], $commonPayload);
                }
                echo "<pre>\n";
                echo $lab_id . ' Same Json Data pushed for test group code '.$testGroupCode;
                $this->moveNonProcessableJsonFiles($commonPayload,'samejsonfile');

                $this->updateLIMSStatus($commonPayload['lims_id'], $sameJsonData);

                //===================== UPDATE EXECUTION LOG ===================//
                  saveExecutionLog(["lab_id" => $lab_id,"message" => "Same Json Data pushed to generate report ".$commonPayload['reg_type']." and test group code ".$testGroupCode,
                  "datetime" => date('Y-m-d H:i:s'),"testgroupcode" => $testGroupCode ]);

            } else {
                $json_filepath = $this->moveFinalJsonFileInDirectory($lab_id, $commonPayload['reg_type'], $commonPayload['lims_data_filpath']);
                if (empty($json_filepath)) {
                    return;
                }
                /**************** UPDATE JSON  *****************/
                if (!empty($this->model)) {
                    $this->updateJsonDetails($lab_id, $commonPayload['lims_id'], $old_json, $json_data, $json_filepath,$testGroupCode,$commonPayload);
                } else {
                    $this->updateIntoTable($lab_id, $commonPayload['lims_id'], $old_json, $json_data, $json_filepath,$testGroupCode,$commonPayload);
                }

                //=================== TAKE BACKUP OF PREV JSON FILE & PDF FILE ==============//
                $this->backupPrevFiles($oldData,$lab_id,$commonPayload['reg_type']);

                echo "<pre>\n";
                echo $lab_id ." - Json Data updated successfully for generating ".$commonPayload['reg_type']." Report ".$testGroupCode." test code";

            }
        } else {

            $json_filepath = $this->moveFinalJsonFileInDirectory($lab_id, $commonPayload['reg_type'], $commonPayload['lims_data_filpath']);
            if (empty($json_filepath)) {
                echo "filenotfound";
                return [];
            }

            /********* If TestGroupDetails & TestResultDetails 
             * is not empty then 
             * save final json filepath 
             * Ready to Initiate Report Generation
             * ***/
            $datauser = [
                'lab_id' => $lab_id,
                'report_id' => $this->report_id,
                'filepath' => $json_filepath,
                'crm_id' => $commonPayload['crm_id'],
                'crm_name' => $commonPayload['crm_name'],
                'report_status' => 1,
                'testgroupcode' => $testGroupCode,
                'created_at' => date('Y-m-d H:i:s'),
                'mobile_no' => $commonPayload['mobile_no'],
                'email_id' => $commonPayload['email_id']
            ];
            // start wellness package distinguish
            $service_type = $commonPayload['service_type'] ?? '';
            $template_version_no = $commonPayload['template_version'] ?? '';
            
            if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
                $failed_reason_email_sent  =  $commonPayload['failed_reason_email_sent'];
                $is_generated = $commonPayload['is_generated'];
                $is_failed =  $commonPayload['is_failed'];
                $failed_reason = $commonPayload['failed_reason'];
                $email_sent = $commonPayload['email_sent'];
                $isrsattachmentsent = $commonPayload['isrsattachmentsent'];
                $bs_code = $commonPayload['bs_code'] ?? null;
                $branch_name = $commonPayload['branch_name'] ?? '';
                $sample_reg_date = $commonPayload['sample_reg_date'] ?? null;
                $failed_reason_email =  $commonPayload['failed_reason_email'] ?? '';
                $report_release_date = $commonPayload['report_release_date'] ?? null;

            }
            
                $datauser['service_type'] = $service_type;
                $datauser['template_version'] = $template_version_no;
            if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
                $datauser['failed_reason_email_sent'] = $failed_reason_email_sent;
                $datauser['is_generated'] = $is_generated;
                $datauser['is_failed'] = $is_failed;
                $datauser['failed_reason'] = $failed_reason;
                $datauser['email_sent'] = $email_sent;
                $datauser['isrsattachmentsent'] = $isrsattachmentsent;
                $datauser['bs_code'] = $bs_code;
                $datauser['branch_name'] = $branch_name;
                $datauser['sample_reg_date'] = $sample_reg_date;
                $datauser['failed_reason_email'] =$failed_reason_email;
                $datauser['report_release_date'] = $report_release_date;
            }


            // end wellness package distinguish
            if (!empty($this->model)) {
                $this->model->insert($datauser);
            } else {
                $this->saveIntoTable($datauser);
            }

            //IDENTIFY LIMS-SLIMS LABID
            $lims_slims = NULL;
            if($lab_id[0] == 4){
                $lims_slims = "lims";
            }

            if($lab_id[0] == 2){
                $lims_slims = "slims";
            }

            //save new record
            $saveData = [
                'lab_id' => $commonPayload['lab_id'],
                'report_type' => strtoupper($commonPayload['reg_type']),
                'report_id' => $this->report_id,
                'crm_id' => $commonPayload['crm_id'],
                'testgroupcode' => $testGroupCode,
                'report_status' => 1,
                'lims_slims' => $lims_slims,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->saveInReportDataTable($saveData);

            $this->updateLIMSStatus($commonPayload['lims_id'], [
                'is_stored' => 1,
                'message' => 'Json Data Stored Successfully',
                'lab_id' => $lab_id,
                'crm_id' => $commonPayload['crm_id'],
            ]);

            echo "<pre>\n";
            echo $lab_id ." - Record saved for generating ".$commonPayload['reg_type']." Report ".$testGroupCode." test code";

        }
    }

    public function backupPrevFiles($oldData,$lab_id,$reg_type){

        $filepath = INPUT_PATH."backupprevfiles/" . strtolower($reg_type) ."/" . trim($lab_id) . "/";
        if (!file_exists($filepath)) {
            mkdir($filepath, 0777, TRUE);
        }

        //Json file backup 
        $old_json_path = FCPATH . $oldData[0]->filepath;
        if(is_file($old_json_path)){
            $json_file = explode("/", $old_json_path);
            $json_filename = end($json_file);
            if(count($json_file) > 1){
                if (!file_exists($filepath."json/")) {
					mkdir($filepath."json/", 0777, TRUE);
                }

                // if (copy($old_json_path, FCPATH . $filepath."json/".$json_filename)) {
                //     unlink($old_json_path);
                // }
            }
        }

        //Pdf Report backup
        $old_pdf_report_path = FCPATH . $oldData[0]->pdf_path;
        if(is_file($old_pdf_report_path)){
            $pdf_file = explode("/", $old_pdf_report_path);
            $pdf_filename = end($pdf_file);
            if (count($pdf_file) > 1) {

                if (!file_exists($filepath . "pdf/")) {
                    mkdir($filepath . "pdf/", 0777, TRUE);
                }

               if($reg_type == 'wellness'){
                    copy($old_pdf_report_path, FCPATH . $filepath . "pdf/" . $pdf_filename);
                }else{
                if (copy($old_pdf_report_path, FCPATH . $filepath."pdf/".$pdf_filename)) {
                        unlink($old_pdf_report_path);
                    }
                }
            }
        }

    }

    public function checkLabRecordExist($lab_id)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select entity_id,lab_id,testgroupcode from report_data where lab_id = '" . $lab_id . "'");
        $results = $q->getResult();
        // return count($results);
        return $results;
    }

    public function checkReportExist($lab_id)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select lab_id,testgroupcode from " . $this->tablename .  " where lab_id = '" . $lab_id . "'");
        $results = $q->getResult();
        return count($results);
    }

    public function getReportExist($lab_id)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select filepath,pdf_path,pe_pdf_path from " . $this->tablename . " where lab_id = '" . $lab_id . "'");
        return $q->getResult();
    }

    public function getReportConfig($reg_type)
    {
        if ($reg_type == "pns") {
            $this->tablename = "pns_report_data";
            $this->model = new PNSReportDataModel();
            $this->report_id = 1;
        } else if ($reg_type == "sperm") {
            $this->tablename = "sperm_report_data";
            $this->model = new SpermReportDataModel();
            $this->report_id = 2;
        } 
        else if (trim($reg_type) == "hpv") {
            $this->tablename = "hpv_report_data";
            $this->model = new HpvDataModel();
            $this->report_id = 3;
        }
        else if (trim($reg_type) == "cg") {
            $this->tablename = "cg_report_data";
            $this->model = new ChlamydiaGonorrheaDataModel();
            $this->report_id = 4;
        }
        else if (trim($reg_type) == "cb") {
            $this->tablename = "cb_report_data";
            $this->model = new CbDataModel();
            $this->report_id = 5;
        }
        else if (trim($reg_type) == "std") {
            $this->tablename = "std_report_data";
            $this->model = new StdReportDataModel();
            $this->report_id = 6;
        }

        else if (trim($reg_type) == "perimeno") {
            $this->tablename = "perimeno_report_data";
            $this->model = new PerimenopauseDataModel();
            $this->report_id = 7;
        }
        else if (trim($reg_type) == "ovascore") {

            $this->tablename = "ovascore_report_data";
            $this->model = new OvaScoreDataModel();
            $this->report_id = 8;
        }
        else if (trim($reg_type) == "annualstemmatch") {

            $this->tablename = "annualstemmatch_report_data";
            $this->model = new AnnualStemMatchDataModel();
            $this->report_id = 9;
        }
        else if (trim($reg_type) == "pharmacogene") {

            $this->tablename = "pharmacogene_report_data";
            $this->model = new PharmaCoGenomicsDataModel();
            $this->report_id = 10;
        }
        else if (trim($reg_type) == "wellness") {

            $this->tablename = "wellness_report_data";
            $this->model = new WellnessDataModel();
            $this->report_id = 11;
        }
        else {
            $this->tablename = strtolower($reg_type) . "_report_data";
            $this->createTable($this->tablename);
        }
    }

    public function createTable($tablename)
    {
        $query = "CREATE TABLE IF NOT EXISTS $tablename (
            entity_id int(11) NOT NULL AUTO_INCREMENT,
            report_id int(11) NOT NULL,
            lab_id varchar(100) DEFAULT NULL,
            json_data longtext CHARACTER SET latin1 NOT NULL,
            pdf_path varchar(200) NOT NULL,
            pe_pdf_path varchar(200) NOT NULL,
            pdf_base_64 longtext NOT NULL,
            pe_pdf_base_64 longtext NOT NULL,
            is_generated int(11) NOT NULL DEFAULT 0,
            pdf_version int(11) NOT NULL,
            qr_codepath text NOT NULL,
            pe_qr_codepath text NOT NULL,
            created_at datetime DEFAULT current_timestamp(),
            is_failed int(11) DEFAULT 0,
            retrycount int(11) DEFAULT 0,
            filepath text NOT NULL,
            crm_id varchar(100) DEFAULT NULL,
            crm_name varchar(500) DEFAULT NULL,
            report_status int(11) DEFAULT 0,
            testgroupcode text DEFAULT NULL,
            risktype varchar(100) DEFAULT NULL,
            archive_path longtext DEFAULT NULL,
            failed_reason varchar(255) DEFAULT NULL,
            email_sent int(11) DEFAULT 0,
            reportgenerationdate datetime DEFAULT NULL,
            PRIMARY KEY (entity_id),
            KEY report_id (report_id)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;";
        $dbh = \Config\Database::connect();
        $dbh->query($query);
    }

    public function saveIntoTable($data)
    {
        $dbh = \Config\Database::connect();
        $dbh->table($this->tablename)->insert($data);
    }

    public function updateIntoTable($lab_id, $lims_id, $old_json, $json_data, $filepath,$testGroupCode,$commonPayload)
    {
        $mobile_no = $commonPayload['mobile_no'];
        $email_id = $commonPayload['email_id'];
        /****************** UPDATE LOG ******************/
        if ($old_json) {
            $reportLogs = new ReportLogsModel();
            $datareportLogs = [
                // 'old_data' => $old_json,
                // 'new_data' => $json_data,
                'report_data_id' => $lab_id
            ];
            $reportLogs->insert($datareportLogs);
        }

        /***************** UPDATE is_stored FLAG ***************/
        $this->updateLIMSStatus($lims_id, [
            'is_stored' => 1,
            'lab_id' => $lab_id,
            'message' => 'Json Data updated successfully'
        ]);

        /*************** UPDATE FILE PATH ********************/
        $updatePath = [
            'filepath' => $filepath,
            'is_generated' => 0,
            'report_status' => 1,
            'testgroupcode' => $testGroupCode,
            'mobile_no' => $mobile_no,
            'email_id' => $email_id
        ];

        // start wellness package distinguish
        $service_type = $commonPayload['service_type'] ?? '';
        $template_version_no = $commonPayload['template_version'] ?? '';
          if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
            $existing = $this->model->where('lab_id', $lab_id)->first();
            if($existing['is_generated'] == 2){
                $existing['is_generated'] = 0;
            }
            if($existing['email_sent'] == 2){
                $existing['email_sent'] = 0;
            }
            if($existing['isrsattachmentsent'] == 2){
                $existing['isrsattachmentsent'] = 0;
            }
             if($existing['isrsattachmentsenttomagento'] == 2){
                        $existing['isrsattachmentsenttomagento'] = 0;
             }
            $failed_reason_email_sent  =  $commonPayload['failed_reason_email_sent'];
            $is_generated = $existing['is_generated'];
            $is_failed =  $commonPayload['is_failed'];
            $failed_reason = $commonPayload['failed_reason'];
            $email_sent = $existing['email_sent'];
            $isrsattachmentsent = $existing['isrsattachmentsent'];
            $isrsattachmentsenttomagento = $existing['isrsattachmentsenttomagento'];
                $bs_code = $commonPayload['bs_code']?? null;
            $branch_name = $commonPayload['branch_name'] ?? '';
            $sample_reg_date = $commonPayload['sample_reg_date'] ?? null;
                $failed_reason_email = $commonPayload['failed_reason_email'] ?? '';
            $report_release_date = $commonPayload['report_release_date'] ?? null;
            if (!empty($service_type)) {
                $updatePath['service_type'] = $service_type;
                $updatePath['template_version'] = $template_version_no;
             if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
                $updatePath['failed_reason_email_sent'] = $failed_reason_email_sent;
                $updatePath['is_generated'] = $is_generated;
                $updatePath['is_failed'] = $is_failed;
                $updatePath['failed_reason'] = $failed_reason;
                $updatePath['email_sent'] = $email_sent;
                $updatePath['isrsattachmentsent'] = $isrsattachmentsent;
                $updatePath['isrsattachmentsenttomagento'] = $isrsattachmentsenttomagento;
                $updatePath['json_update_date']  = date('Y-m-d H:i:s');
                $updatePath['bs_code']  = $bs_code;
                $updatePath['reportregenerationdate'] = null;
                $updatePath['repushpdfdate'] = null;
                $updatePath['branch_name'] = $branch_name;
                $updatePath['sample_reg_date'] = $sample_reg_date;
                $updatePath['failed_reason_email'] =$failed_reason_email;
                $updatePath['resend_date'] = null;
                $updatePath['resend_mail_status'] = 0;
                $updatePath['report_release_date'] = $report_release_date;
            }
            }
                
        }

        // end wellness package distinguish

        $dbh = \Config\Database::connect();
        $dbh->table($this->tablename)->where('lab_id',$lab_id)->set($updatePath)->update();
        $reportModel = new ReportDataModel();
        $updateReportStatus = [
            'report_status' => 1,
            'testgroupcode' => $testGroupCode
        ];
        $reportModel->update($lab_id, $updateReportStatus);
        $reportModel->where('lab_id',$lab_id)->set($updateReportStatus)->update();

    }

    public function updateLIMSStatus($lims_id, $updateData)
    {
        $this->limsModel->update($lims_id, $updateData);
    }
    public function updateWellnessData($lab_id, $updateData)
    {
        $this->wellnessDataModel->update($lab_id, $updateData);
    }
    public function updateJsonDetails($lab_id, $lims_id, $old_json, $json_data, $filepath,$testGroupCode,$commonPayload)
    {
        $mobile_no = $commonPayload['mobile_no'];
        $email_id = $commonPayload['email_id'];
        /****************** UPDATE LOG ******************/
        if ($old_json) {
            $reportLogs = new ReportLogsModel();
            $datareportLogs = [
                // 'old_data' => $old_json,
                // 'new_data' => $json_data,
                'report_data_id' => $lab_id
            ];
            $reportLogs->insert($datareportLogs);
        }

        /***************** UPDATE is_stored FLAG ***************/
        $this->updateLIMSStatus($lims_id, [
            'is_stored' => 1,
            'lab_id' => $lab_id,
            'message' => 'Json Data updated successfully'
        ]);

        /*************** UPDATE FILE PATH ********************/
        $updatePath = [
            'filepath' => $filepath,
            'is_generated' => 0,
            'report_status' => 1,
            'testgroupcode' => $testGroupCode,
            'mobile_no' => $mobile_no,
            'email_id' => $email_id
        ];
        // start wellness package distinguish
        $service_type = $commonPayload['service_type'] ?? '';
        $template_version_no = $commonPayload['template_version'] ?? '';
        if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
            $existing = $this->model->where('lab_id', $lab_id)->first();
          
            $existing['is_generated'] = 0;
            $existing['email_sent'] = 0;
            $existing['isrsattachmentsent'] = 0;
            $existing['isrsattachmentsenttomagento'] = 0;
            $existing['isrsattachmentsenttomfine'] = 0;

            // if ($existing['is_generated'] == 2) {
            //     $existing['is_generated'] = 0;
            // }
            // if ($existing['email_sent'] == 2) {
            //     $existing['email_sent'] = 0;
            // }
            // if ($existing['isrsattachmentsent'] == 2) {
            //     $existing['isrsattachmentsent'] = 0;
            // }
            
            $failed_reason_email_sent  =  $commonPayload['failed_reason_email_sent'];
            $is_generated =  $existing['is_generated'];
            $is_failed =  $commonPayload['is_failed'];
            $failed_reason = $commonPayload['failed_reason'];
            $email_sent = $existing['email_sent'];
            $isrsattachmentsent = $existing['isrsattachmentsent'];
            $isrsattachmentsenttomagento = $existing['isrsattachmentsenttomagento'];
            $bs_code = $commonPayload['bs_code']?? null;
            $branch_name = $commonPayload['branch_name'] ?? '';
            $sample_reg_date = $commonPayload['sample_reg_date'] ?? null;
            $failed_reason_email = $commonPayload['failed_reason_email'] ?? '';
            $report_release_date = $commonPayload['report_release_date'] ?? null;
            $isrsattachmentsenttomfine = $existing['isrsattachmentsenttomfine'];

            if (!empty($service_type)) {
                $updatePath['service_type'] = $service_type;
                $updatePath['template_version'] = $template_version_no;
            if(isset($commonPayload['reporttype']) && $commonPayload['reporttype']=='wellness'){
                $updatePath['failed_reason_email_sent'] = $failed_reason_email_sent;
                $updatePath['is_generated'] = $is_generated;
                $updatePath['is_failed'] = $is_failed;
                $updatePath['failed_reason'] = $failed_reason;
                $updatePath['email_sent'] = $email_sent;
                $updatePath['isrsattachmentsent'] = $isrsattachmentsent;
                $updatePath['isrsattachmentsenttomagento'] = $isrsattachmentsenttomagento;
                $updatePath['isrsattachmentsenttomfine'] = $isrsattachmentsenttomfine;
                $updatePath['json_update_date']  = date('Y-m-d H:i:s');
                $updatePath['bs_code']  = $bs_code;
            $updatePath['reportregenerationdate'] = null;
            $updatePath['repushpdfdate'] = null;
                $updatePath['branch_name'] = $branch_name;
                $updatePath['sample_reg_date'] = $sample_reg_date;
            $updatePath['failed_reason_email'] =$failed_reason_email;
            $updatePath['resend_date'] = null;
            $updatePath['resend_mail_status'] = 0;
                $updatePath['report_release_date'] = $report_release_date;
            
            }
        }
        }

        
        // end wellness package distinguish
        $this->model->where('lab_id',$lab_id)->set($updatePath)->update();
        $reportModel = new ReportDataModel();
        $updateReportStatus = [
            'report_status' => 1,
            'is_generated' => 0,
            'testgroupcode' => $testGroupCode
        ];
        $reportModel->where('lab_id',$lab_id)->set($updateReportStatus)->update();
    }

    public function moveFinalJsonFileInDirectory($lab_id, $reg_type, $lims_data_filpath)
    {
        /********************* CREATE FOLDER REPORT TYPE WISE & MOVE JSON FILE START *****************/
        $date =  date('Y-m-d');
        $filename = "LIMS_" . trim($lab_id) . "_" . date('Y-m-d-H-i-s') . ".json";
        $filepath = INPUT_PATH . strtolower($reg_type) . "/" . $date . "/" . trim($lab_id) . "/";
        if (!file_exists($filepath)) {
            mkdir($filepath, 0777, TRUE);
        }
        $json_filepath = $filepath . $filename;
        if(!is_file($lims_data_filpath)){
            return "";
        }
        if (!copy($lims_data_filpath, FCPATH . $json_filepath)) {
            echo "File can't be moved!";
            $json_filepath = "";
        }
        return $json_filepath;
        /********************* CREATE FOLDER REPORT TYPE WISE & MOVE JSON FILE END *****************/
    }

    public function moveNonProcessableJsonFiles($commonPayload, $directory_name)
    {
        $filedetails = explode("/", $commonPayload['lims_data_filpath']);
        $date = date('Y-m-d');
        $filename = end($filedetails) ?? "LIMS_" . trim($commonPayload['lab_id']) . "_" . date('Y-m-d-H-i-s') . ".json";
        $filepath =  INPUT_PATH.$directory_name ."/".$date."/".trim($commonPayload['lab_id']) . "/";
        if(!empty($commonPayload['reg_type'])){
            $filepath =  INPUT_PATH.$directory_name ."/" . strtolower($commonPayload['reg_type']) . "/" .$date."/" .trim($commonPayload['lab_id']) . "/";
        }
        if (!file_exists(FCPATH .$filepath)) {
            mkdir($filepath, 0777, TRUE);
        }
        if (!copy($commonPayload['lims_data_filpath'], FCPATH .$filepath . $filename)) {
            echo "Temp File can't be moved!";
            return "";
        } else {
            return $filepath . $filename;
        }
    }
}
