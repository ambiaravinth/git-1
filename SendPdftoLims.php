<?php

namespace App\Controllers\Cron;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StoreConfig;
use App\Models\ReportDataModel;
use App\Models\RegistrationServiceLogsModel;
use App\Models\WellnessLimsLogsModel;
use App\Models\LimsSlimsModel;
use App\Libraries\MergePDF;
use App\Models\CronScheduleModel;

class SendPdftoLims extends ResourceController
{
    public function __construct()
    {
        helper('common');
        $this->cronschedulemodel = new CronScheduleModel();
    }

    use ResponseTrait;

    public function getconfiguration()
    {
        //================== FETCH CONFIGURATIONS DETAILS START ====================//
        $configModel = new StoreConfig();
        $config_url = $configModel->getConfigValue('REG_ATTACHEMNT_TPA_URL');
        $config_username = $configModel->getConfigValue('REG_ATTACHEMNT_TPA_USERNAME');
        $config_password = $configModel->getConfigValue('REG_ATTACHEMNT_TPA_PASSWORD');
        $config_limit = $configModel->getConfigValue('REG_ATTACHEMNT_TPA_LIMIT');
        $config_date = $configModel->getConfigValue('REG_ATTACHEMNT_START_DATE');
        if (!isset($config_url['config_value']) || !isset($config_username['config_value']) || !isset($config_password['config_value']) || !isset($config_date['config_value'])) {
            echo "Please set configuration details";
            $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"error",'remarks'=>"Please set configuration details"],$this->cron_id);
            exit;
        }
        $limit =  $config_limit['config_value'] ?? 1;
        $config = [
            'url' => $config_url['config_value'],
            'username' => $config_username['config_value'],
            'password' => $config_password['config_value'],
            'config_date' => $config_date['config_value'],
            'limit' => $limit
        ];
        //================== FETCH CONFIGURATIONS DETAILS END ====================//
        return $config;
    }
    // Push Sperm Score pdf data to Lims server
    public function pushSpermscoreReporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushsperreporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getSpermReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'sperm');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }
    // Push HPV pdf data to Lims server
    public function pushHpveporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushhpvreporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getHpvReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'hpv');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }
    // Push Wellness pdf data to Lims server
    public function pushWellnesseporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushwellnessreporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getWellnessReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'wellness');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }
    // Push C&G pdf data to Lims server
    public function pushCandgeporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushcandgreporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getCandgReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'candg');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }
    // Push PNS pdf data to Lims server
    public function pushPnsgeporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushpnsreporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getPnsReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'pns');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }
    public function pushPdfData($reportrecords, $config, $report_type)
    {
        if($report_type == 'wellness'){
            $registrationreportLogs = new WellnessLimsLogsModel();
        }else{
            $registrationreportLogs = new RegistrationServiceLogsModel();
        }
            //================INSERT TESTCODES AGAINST LABID'S==================//
            //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
            $configModel = new StoreConfig();
            $config_value = $configModel->getConfigValue('BLOCK_REPORT_TESTCODES');
            $BLOCK_REPORT_TESTCODES = isset($config_value['config_value']) ? explode(',', $config_value['config_value']) : array();
            //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
            $labIdData = array();
            foreach ($reportrecords as $row) {
                if (in_array($row->testgroupcode, $BLOCK_REPORT_TESTCODES)) {
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 3   //TESTGROUPCODE IS BLOCKED TO SENT REPORT
                    ];
                    $this->updateIsattachmentsent($row->lab_id, $report_type, $updateIsattachmentsent);
                    echo $row->lab_id.' Block to send report';
                    echo $row->lab_id.' Block to send report';
                } else {
                    if (is_file(FCPATH . $row->pdf_path)) {
                        $labIdData[$row->lab_id]['testgroupcode'][] = $row->testgroupcode;
                        $labIdData[$row->lab_id]['pdfbase64'][] = $row->pdf_base_64;
                        $labIdData[$row->lab_id]['pdfpath'][] = FCPATH . $row->pdf_path;
                    } else {
                        $updateIsattachmentsent = [
                            'isrsattachmentsent' => 2   //failed to sent attachment
                        ];
                        $this->updateIsattachmentsent($row->lab_id, $report_type, $updateIsattachmentsent);
                        echo $row->lab_id.' failed to sent attachment';
                        echo $row->lab_id.' failed to sent attachment';
                    }
                }
            }
            $merged_pdf = "";
            foreach ($labIdData as $labId => $labData) {
                $reqPayload = array();
                if (count($labData['testgroupcode']) > 1) {
                    $this->MergePDF = new MergePDF();
                    $merged_pdf =  $this->MergePDF->mergePDF($labData['pdfpath'], $labId);
                    $pdf_base_64 = chunk_split(base64_encode(file_get_contents($merged_pdf)));
                    $reqPayload['LabId'] = $labId;
                    $reqPayload['PdfData'] = $pdf_base_64;
                } else {
                    $reqPayload['LabId'] = $labId;
                    if (is_file($labData['pdfpath'][0])) {
                        $pdf_base_64 = chunk_split(base64_encode(file_get_contents($labData['pdfpath'][0])));
                        $reqPayload['PdfData'] = $pdf_base_64;
                    } else {
                        $updateIsattachmentsent = [
                            'isrsattachmentsent' => 2   //failed to sent attachment
                        ];
                        $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                        continue;
                    }
                }
                //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
                // debug($reqPayload);
                $response = $this->curlCall($reqPayload, $config);
                $regdatareportLogs = [
                    'lab_id' => $labId,
                    'attachment' => $reqPayload['PdfData'],
                    'testgroupcode' => $labData['testgroupcode'][0],
                    'response' => json_encode($response),
                    'created_at' => date("Y-m-d H:i:s"),
                    'system_type' => 'lims',
                    'report_type' => $report_type

                ];
                if (isset($response['IsSuccess']) && $response['IsSuccess'] == true) {
                    $regdatareportLogs['status'] = "done";
                    //===================== UPDATE FLAG IN REPORT TABLE ====================//
                   
                    if($report_type == 'wellness'){
                        $dbh = \Config\Database::connect();
                        $sql = "SELECT pushpdfdate FROM wellness_report_data WHERE lab_id = ?";
                        $query = $dbh->query($sql, [$labId]);
                        $results = $query->getResultArray();
                          $updateIsattachmentsent = [
                            'isrsattachmentsent' => 1,
                            'pushpdfdate' => $results[0]['pushpdfdate'],
                        ];


                    }else{
                         $updateIsattachmentsent = [
                        'isrsattachmentsent' => 1,
                        'pushpdfdate' => date("Y-m-d H:i:s")
                    ];
                    }
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
                } else {
                    //============== updated status as failed if error ============//
                    $regdatareportLogs['status'] = "failed";

                     if($report_type == 'wellness'){
                        $dbh = \Config\Database::connect();
                        $sql = "SELECT pushpdfdate FROM wellness_report_data WHERE lab_id = ?";
                        $query = $dbh->query($sql, [$labId]);
                        $results = $query->getResultArray();
                          $updateIsattachmentsent = [
                            'isrsattachmentsent' => 2,
                            'pushpdfdate' => $results[0]['pushpdfdate'],
                        ];


                    }else{
                        $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2   //failed to sent attachment
                      ];

                    }
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from TPA for this LAB ID";
                }
                $registrationreportLogs->insert($regdatareportLogs);
                if (is_file($merged_pdf)) {
                    unlink($merged_pdf);
                }
                //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
            }
       
    }
    function getSpermReportDetails($limit)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select lab_id,pdf_base_64,testgroupcode,pdf_path from sperm_report_data 
        where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1 limit " .$limit);
        return $q->getResult();
    }
    // function getHpvReportDetails($limit)
    // {
    //     $dbh = \Config\Database::connect();
    //     $configModel = new StoreConfig();
    //     $start_date = $configModel->getConfigValue('WELLNESS_CUSTOMER_TRIGGER_START_DATE')['config_value'];
    //     $bs_code_config = explode(',', $configModel->getConfigValue('WELLNESS_BS_CODES')['config_value']);
    //      // Prepare the IN clause
    //     $bs_code_list = implode("','", array_map('trim', $bs_code_config));
    //     $bs_code_list = "'$bs_code_list'";
    //     $q = $dbh->query("select lab_id,pdf_base_64,testgroupcode,pdf_path from hpv_report_data 
    //     where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1 limit " .$limit);
    //     return $q->getResult();
    // }
    function getHpvReportDetails($limit)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select lab_id,pdf_base_64,testgroupcode,pdf_path from hpv_report_data 
        where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1 limit " .$limit);
        return $q->getResult();
    }
    function getWellnessReportDetails($limit = 10)
    {
        $dbh = \Config\Database::connect();
        $configModel = new StoreConfig();

        // Get configuration values
        $start_date = $configModel->getConfigValue('WELLNESS_CUSTOMER_TRIGGER_START_DATE')['config_value'];
    $bs_code_config = explode(',', $configModel->getConfigValue('WELLNESS_BS_CODES')['config_value']);

        // Prepare the IN clause
        $bs_code_list = implode("','", array_map('trim', $bs_code_config));
        $bs_code_list = "'$bs_code_list'";

        // Build and run the query
        $sql = "
        SELECT lab_id, pdf_base_64, created_at, testgroupcode, pdf_path 
            FROM wellness_report_data 
            WHERE 
                created_at >= '2024-11-25 00:00:00'
                AND isrsattachmentsent = 0 
                AND pdf_path IS NOT NULL 
                AND is_generated = 1 
                AND (
                    (created_at >= ? AND bs_code NOT IN ($bs_code_list)) OR 
                    (created_at < ?)
                )
            LIMIT $limit
        ";

        $q = $dbh->query($sql, [$start_date, $start_date]);
        return $q->getResult();
    }


    function getCandgReportDetails($limit)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select lab_id,pdf_base_64,testgroupcode,pdf_path from candg_report_data 
        where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1 limit " .$limit);
        return $q->getResult();
    }
    function getPnsReportDetails($limit)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select created_at,lab_id,pdf_base_64,testgroupcode,pdf_path from pns_report_data 
        where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1 and date(created_at) >= '2022-11-01' limit " .$limit);
        return $q->getResult();
    }
    function updateIsattachmentsent($lab_id, $report_type, $update_isrsattachmentsent)
    {
        $isrsattachmentsent = $update_isrsattachmentsent['isrsattachmentsent'];
        $dbh = \Config\Database::connect();
        if($report_type == 'wellness'){
        $pushpdfdate = $update_isrsattachmentsent['pushpdfdate'];
        if(empty($pushpdfdate)){
             if($isrsattachmentsent == 1){
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent, pushpdfdate = '".date('Y-m-d H:i:s')."' where lab_id = '" . $lab_id . "' ");
        }else{
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent where lab_id = '" . $lab_id . "' ");
        }
        $dbh->query($query);

        }else{
             if($isrsattachmentsent == 1){
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent, repushpdfdate = '".date('Y-m-d H:i:s')."' where lab_id = '" . $lab_id . "' ");
        }else{
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent where lab_id = '" . $lab_id . "' ");
        }
        $dbh->query($query);


        }
       

        }else{
        if($isrsattachmentsent == 1){
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent, pushpdfdate = '".date('Y-m-d H:i:s')."' where lab_id = '" . $lab_id . "' ");
        }else{
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent where lab_id = '" . $lab_id . "' ");
        }
        $dbh->query($query);

        }
        
    }
    function pushregservattachmentlog($log)
    {
        $date =  date('Y-m-d');
        /****************** UPDATE LOGS LIMS ******************/
        if (!is_dir(REGSERV_LOGS_DIR)) {
            mkdir(REGSERV_LOGS_DIR, 0777, TRUE);
        }
        $logfilename = REGSERV_LOGS_DIR . $date . ".log";
        $logfile = fopen($logfilename, 'a');
        fwrite($logfile, "," . json_encode($log));
        fclose($logfile);
    }
    function curlCall($params, $credential)
    {
        $post_data = json_encode($params);
        //============ SAVE API CALL BEFORE EXECUTION ====================//
        $logid = date('Y-m-d H:i:s');
        $ch = curl_init($credential['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "UserId:" . $credential['username'],
                "Password:" . $credential['password'],
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data)
            )
        );
        //To do - Need to uncomment the $result once we deployed code on production
        $result = curl_exec($ch);
        // $result = '{
        //     "IsSuccess": true,
        //     "Error": {
        //         "StatusCode": 400,
        //         "Message": {
        //             "LabId": [
        //                 "LabId : 20600202846 and Integration Software Id: 3 Mismatched"
        //             ]
        //         }
        //     },
        //     "Success": null
        // }';
        //============ AFTER API CALL EXECUTION LOG ==============//
        $configModel = new StoreConfig();
        $config_log = $configModel->getConfigValue('REG_ATTACHEMNT_TPA_LOG');
        if (isset($config_log['status']) && $config_log['status'] == 'active') {
            $log = [
                'log_id' => $logid,
                'requestpayload' => $post_data,
                'response' => $result,
                'status' => "after execution",
                'created_date' => date('Y-m-d H:i:s')
            ];
            $this->pushregservattachmentlog($log);
        }
        $result = json_decode($result, true);
        return $result;
    }

    function getReportDetailsbylabid($lab_id, $report_type){
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select lab_id,pdf_base_64,testgroupcode,pdf_path,isrsattachmentsent,is_generated from  " . trim(strtolower($report_type)) . "_report_data 
        where pdf_path is not null and lab_id =" .$lab_id);
        return $q->getResult();
    }

    public function pushreporttoLimsByLabid($reportrecordsbylabid, $report_type){
        $config =  $this->getconfiguration();
        if($reportrecordsbylabid){
            $this->pushPdfData($reportrecordsbylabid, $config, $report_type);
        }
    }

    // Push Pharmacogenomics pdf data to Lims server
    public function pushPharmacogenegeporttoLims()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushpharmacogenereporttolims','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $reportrecords = $this->getPharmacogeneReportDetails($config['limit']);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'pharmacogene');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
        
    }

    function getPharmacogeneReportDetails($limit)
    {
        $dbh = \Config\Database::connect();
        $q = $dbh->query("select created_at,lab_id,pdf_base_64,testgroupcode,pdf_path from pharmacogene_report_data 
        where isrsattachmentsent = 0 and pdf_path is not null and is_generated =1  limit " .$limit);
        return $q->getResult();
    }
    
}