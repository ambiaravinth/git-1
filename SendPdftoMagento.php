<?php

namespace App\Controllers\Cron;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StoreConfig;
use App\Models\RegistrationServiceLogsModel;
use App\Models\CbMagentoLogsModel;
use App\Models\WellnessMagentoLogsModel;
use App\Libraries\MergePDF;
use App\Models\CronScheduleModel;
use App\Models\SpermReportDataModel;
use App\Models\ChlamydiaGonorrheaDataModel;
use App\Models\HpvDataModel;
use App\Models\PerimenopauseDataModel;
use App\Models\StdReportDataModel;
use App\Models\OvaScoreDataModel;
use App\Models\CbDataModel;
use App\Models\WellnessDataModel;
use App\Models\PNSReportDataModel;

class SendPdftoMagento extends ResourceController
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
        $config_url = $configModel->getConfigValue('PUSH_PDF_MAGENTO_URL');
        $config_token = $configModel->getConfigValue('PUSH_PDF_MAGENTO_TOKEN');
        $config_limit = $configModel->getConfigValue('PUSH_PDF_MAGENTO_LIMIT');
        $config_date = $configModel->getConfigValue('PUSH_PDF_MAGENTO_DATE');
        if (!isset($config_url['config_value']) || !isset($config_token['config_value']) || !isset($config_date['config_value'])) {
            echo "Please set configuration details";
            $this->cronschedulemodel->updateEndTime(['endtime' => date('Y-m-d H:i:s'), 'status' => "error", 'remarks' => "Please set configuration details"], $this->cron_id);
            exit;
        }
        $limit =  $config_limit['config_value'] ?? 1;
        $config = [
            'url' => $config_url['config_value'],
            'token' => $config_token['config_value'],
            'config_date' => $config_date['config_value'],
            'limit' => $limit
        ];
        //================== FETCH CONFIGURATIONS DETAILS END ====================//
        return $config;
    }

    public function getCbconfig()
    {
        //================== FETCH CONFIGURATIONS DETAILS START ====================//
        $configModel = new StoreConfig();
        $config_limit = $configModel->getConfigValue('PUSH_PDF_MAGENTO_LIMIT');
        $config_cb_url = $configModel->getConfigValue('PUSH_CB_PDF_MAGENTO_URL');
        $config_cb_token = $configModel->getConfigValue('PUSH_CB_PDF_MAGENTO_TOKEN');
        $config_cb_date = $configModel->getConfigValue('PUSH_CB_PDF_MAGENTO_DATE');
        if (!isset($config_cb_url['config_value']) || !isset($config_cb_token['config_value']) || !isset($config_cb_date['config_value'])) {
            echo "Please set configuration details";
            $this->cronschedulemodel->updateEndTime(['endtime' => date('Y-m-d H:i:s'), 'status' => "error", 'remarks' => "Please set configuration details"], $this->cron_id);
            exit;
        }
        $limit =  $config_limit['config_value'] ?? 1;
        $config = [
            'url' => $config_cb_url['config_value'],
            'token' => $config_cb_token['config_value'],
            'config_date' => $config_cb_date['config_value'],
            'limit' => $limit,
        ];

        //================== FETCH CONFIGURATIONS DETAILS END ====================//
        return $config;
    }
    //  public function getWellnessconfig()
    // {
    //     //================== FETCH CONFIGURATIONS DETAILS START ====================//
    //     $configModel = new StoreConfig();
    //     $config_limit = $configModel->getConfigValue('PUSH_PDF_MAGENTO_LIMIT');
    //     $config_wellness_url = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_URL');
    //     $config_wellness_username = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_USERNAME');
    //     $config_wellness_password = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_PASSWORD');
    //     $config_wellness_authurl = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_AUTHURL');

    //     if (!isset($config_wellness_url['config_value']) || !isset($config_wellness_username['config_value']) || !isset($config_wellness_password['config_value']) || !isset($config_wellness_authurl['config_value'])) {
    //         echo "Please set configuration details";
    //         $this->cronschedulemodel->updateEndTime(['endtime' => date('Y-m-d H:i:s'), 'status' => "error", 'remarks' => "Please set configuration details"], $this->cron_id);
    //         exit;
    //     }
    //     $limit =  $config_limit['config_value'] ?? 1;
    //     $config = [
    //         'url' => $config_wellness_url['config_value'],
    //         'limit' => $limit,
    //         'authurl'=>  $config_wellness_authurl['config_value'],
    //         'username' => $config_wellness_username['config_value'],
    //         'password' => $config_wellness_password['config_value'],
    //     ];

    //     //================== FETCH CONFIGURATIONS DETAILS END ====================//
    //     return $config;
    // }
    public function getWellnessconfig()
    {
        //================== FETCH CONFIGURATIONS DETAILS START ====================//
        $configModel = new StoreConfig();
        $config_limit = $configModel->getConfigValue('PUSH_PDF_MAGENTO_LIMIT');
        $config_wellness_url = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_URL');
        $config_wellness_token = $configModel->getConfigValue('PUSH_WELLNESS_PDF_MAGENTO_TOKEN');

        // Check mandatory configs
        if (!isset($config_wellness_url['config_value']) || !isset($config_wellness_token['config_value'])) {
            echo "Please set configuration details";
            $this->cronschedulemodel->updateEndTime([
                'endtime' => date('Y-m-d H:i:s'),
                'status' => "error",
                'remarks' => "Please set configuration details"
            ], $this->cron_id);
            exit;
        }

        // Default limit
    $limit = $config_limit['config_value'] ?? 10;

        // Return config array
        $config = [
            'url' => $config_wellness_url['config_value'],
            'token' => $config_wellness_token['config_value'],
            'limit' => $limit,
        ];

        //================== FETCH CONFIGURATIONS DETAILS END ====================//
        return $config;
    }
    public function getPnsconfig()
    {
        //================== FETCH CONFIGURATIONS DETAILS START ====================//
        $configModel = new StoreConfig();
        $config_limit = $configModel->getConfigValue('PUSH_PDF_MAGENTO_LIMIT');
        $config_pns_url = $configModel->getConfigValue('PUSH_PNS_PDF_MAGENTO_URL');
        $config_pns_token = $configModel->getConfigValue('PUSH_PNS_PDF_MAGENTO_TOKEN');

        // Check mandatory configs
        if (
            !isset($config_pns_url['config_value']) ||
            !isset($config_pns_token['config_value'])
       
        ) {
            echo "Please set configuration details";
            $this->cronschedulemodel->updateEndTime([
                'endtime' => date('Y-m-d H:i:s'),
                'status' => "error",
                'remarks' => "Please set configuration details"
            ], $this->cron_id);
            exit;
        }

        // Default limit
        $limit = $config_limit['config_value'] ?? 10;

        // Return config array
        $config = [
            'url' => $config_pns_url['config_value'],
            'token' => $config_pns_token['config_value'],
            'limit' => $limit,
        ];

        //================== FETCH CONFIGURATIONS DETAILS END ====================//
        return $config;
    }

    // Push Sperm Score pdf data to Magento server
    public function pushSpermscoreReporttoMagento()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushsperreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $limit =  $config['limit'] ?? 10;
        $reportrecords = $this->getSpermReportDetails($limit);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'sperm');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
       
    }

    // Push CB pdf data to Magento server
    public function pushCbReporttoMagento()
    {
            $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushcbreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getCbconfig();
            $limit =  10;//$config['limit'] ?? 2;
        $reportrecords = $this->getCbReportDetails($limit);
            if(!empty($reportrecords)){
                $this->pushCbReportData($reportrecords, $config,'cb');
            }else{
                echo 'No pending data to push the PDF';
            }
            $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
           
        }
        // Push Wellness pdf data to Magento server
        public function pushWellnessReporttoMagento()
        {
            $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname' => 'pushwellnessreporttomagento', 'starttime' => date('Y-m-d H:i:s'), 'status' => 'inprocess']);
            $config =  $this->getWellnessconfig();
            $limit =  $config['limit'] ?? 10;
            $configModel = new StoreConfig();
            $start_date = $configModel->getConfigValue('PUSH_WELLNESS_DATA_TO_MAGENTO_START_DATE')['config_value'];
            $B2C_CODE = explode(',', $configModel->getConfigValue('B2C_CODE_TO_MAGENTO')['config_value']);
            $reportrecords = $this->getWellnesseportDetails($limit, $start_date,$B2C_CODE);
            if ($reportrecords) {
                $this->pushWellnessReportData($reportrecords, $config, 'wellness');
        } else {
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime' => date('Y-m-d H:i:s'), 'status' => "success"], $this->cron_id);
    }
          public function pushPnsReporttoMagento()
            {
                $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname' => 'pushpnsreporttomagento', 'starttime' => date('Y-m-d H:i:s'), 'status' => 'inprocess']);
                $config =  $this->getPnsconfig();
                $limit =  $config['limit'] ?? 10;
                $configModel = new StoreConfig();
                $start_date = $configModel->getConfigValue('PUSH_PNS_DATA_TO_MAGENTO_START_DATE')['config_value'];
                $B2C_CODE = explode(',', $configModel->getConfigValue('B2C_CODE_TO_MAGENTO_PNS')['config_value']);

                $reportrecords = $this->getPnseportDetails($limit, $start_date,$B2C_CODE);
                // debug($reportrecords);
                if ($reportrecords) {
                    $this->pushPnsReportData($reportrecords, $config, 'pns');
                } else {
                    echo 'No pending data to push the PDF';
                }
                $this->cronschedulemodel->updateEndTime(['endtime' => date('Y-m-d H:i:s'), 'status' => "success"], $this->cron_id);
            }
    

    // Push HPV pdf data to Magento server
    public function pushHpvReporttoMagento()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushhpvreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $limit =  $config['limit'] ?? 10;
        $reportrecords = $this->getHpvReportDetails($limit);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'hpv');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
        
    }


    // Push HPV pdf data to Magento server
    public function pushCgReporttoMagento()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushcgreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $limit =  $config['limit'] ?? 10;
        $reportrecords = $this->getCgReportDetails($limit);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'cg');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
        
    }

    // Push Perimenopause pdf data to Magento server
    public function pushPerimenoReporttoMagento()
    {
        $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushperimenoreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
        $config =  $this->getconfiguration();
        $limit =  $config['limit'] ?? 10;
        $reportrecords = $this->getPerimenoReportDetails($limit);
        if($reportrecords){
            $this->pushPdfData($reportrecords, $config,'perimeno');
        }else{
            echo 'No pending data to push the PDF';
        }
        $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
        
    }

     // Push Ovascore pdf data to Magento server
     public function pushOvascoreReporttoMagento()
    {
         $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushovascorereporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
         $config =  $this->getconfiguration();
         $limit =  $config['limit'] ?? 10;
         $reportrecords = $this->getOvascoreReportDetails($limit);
         if($reportrecords){
             $this->pushPdfData($reportrecords, $config,'ovascore');
         }else{
             echo 'No pending data to push the PDF';
         }
         $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
         
     }
 

      // Push STD pdf data to Magento server
      public function pushSTDReporttoMagento()
      {
          $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushstdreporttomagento','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
          $config =  $this->getconfiguration();
          $limit =  $config['limit'] ?? 10;
          $reportrecords = $this->getSTDReportDetails($limit);
          if($reportrecords){
              $this->pushPdfData($reportrecords, $config,'std');
          }else{
              echo 'No pending data to push the PDF';
          }
          $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
          
      }
  

    public function pushPdfData($reportrecords, $config, $report_type)
    {
            $registrationreportLogs = new RegistrationServiceLogsModel();
        //================INSERT TESTCODES AGAINST LABID'S==================//
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $configModel = new StoreConfig();
        $config_value = $configModel->getConfigValue('BLOCK_REPORT_TESTCODES');
        $BLOCK_REPORT_TESTCODES = isset($config_value['config_value']) ? explode(',', $config_value['config_value']) : array();
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $labIdData = array();
        foreach ($reportrecords as $row) {

            if (in_array($row['testgroupcode'], $BLOCK_REPORT_TESTCODES)) {
                $updateIsattachmentsent = [
                    'isrsattachmentsent' => 3   //TESTGROUPCODE IS BLOCKED TO SENT REPORT
                ];
                $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                    echo $row['lab_id'].' Block to send report';
            } else {
                if (is_file(FCPATH . $row['pdf_path'])) {
                    $labIdData[$row['lab_id']]['testgroupcode'][] = $row['testgroupcode'];
                        $labIdData[$row['lab_id']]['pdfpath'][] = FCPATH.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['report_url'][] = base_url().'/'.$row['pdf_path'];
                    $labIdData[$row['lab_id']]['crm_number'] = $row['crm_id'];
                    $labIdData[$row['lab_id']]['goals_achieved'] = $row['goals_achieved'] ?? "0";
                        if($report_type == 'sperm'){
                            $storagedatetime = $row['sample_storage_date_time'];
                            $labIdData[$row['lab_id']]['sample_storage_date_time'] = date('Y-m-d H:i', strtotime($storagedatetime));
                        }else{
                            $labIdData[$row['lab_id']]['sample_storage_date_time'] = '';
                        }
                    // CB report cron functionlity to send crm,ladid,email_trigger_date,report_type,customer_email_address,email_trigger_status
                        if($report_type == 'cb'){
                        $labIdData[$row['lab_id']]['email_trigger_date_time'] = $row['email_trigger_date_time'];
                        $labIdData[$row['lab_id']]['report_type'] = 'biobank';
                        $labIdData[$row['lab_id']]['registration_date'] = $row['registration_date'];
                        $labIdData[$row['lab_id']]['sample_date'] = $row['sample_date'];
                        $labIdData[$row['lab_id']]['approved_date'] = $row['approved_on'];
                        $labIdData[$row['lab_id']]['approved_by'] = '';
                        $labIdData[$row['lab_id']]['customer_email_address'] = $row['email_id'];
                        $labIdData[$row['lab_id']]['email_trigger_status'] = $row['email_sent'];
                    }
                } else {
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                        echo $row['lab_id'].' failed to sent attachment';
                }
            }
        }
        $merged_pdf = "";
        foreach ($labIdData as $labId => $labData) {
            $reqPayload = array();
            $reqPayload['data']['lab_id'] = $labId;
            $reqPayload['data']['crm_number'] = $labData['crm_number'];
            $reqPayload['data']['report_type'] = $report_type;
            $reqPayload['data']['report_url'] = $labData['report_url'][0];
            $reqPayload['data']['goal_percentage'] = $labData['goals_achieved'];
                $reqPayload['data']['sample_storage_date_time'] = $labData['sample_storage_date_time'];
                if($report_type == 'cb'){
                $reqPayload['data']['email_trigger_date_time'] = $labData['email_trigger_date_time'];
                $reqPayload['data']['registration_date'] = $labData['registration_date'];
                $reqPayload['data']['sample_date'] =  $labData['sample_date'];
                $reqPayload['data']['approved_date'] =  $labData['approved_date'];
                $reqPayload['data']['approved_by'] = '';
                    $reqPayload['data']['customer_email_address'] = $labData['customer_email_address'];
                $reqPayload['data']['email_trigger_status'] = $labData['email_trigger_status'];
                }
                
                if($report_type != 'cb' ){
                if (count($labData['testgroupcode']) > 1) {
                    $this->MergePDF = new MergePDF();
                    $merged_pdf =  $this->MergePDF->mergePDF($labData['pdfpath'], $labId);
                    $pdf_base_64 = chunk_split(base64_encode(file_get_contents($merged_pdf)));
                    // $reqPayload['data']['lab_id'] = $labId;
                    // $reqPayload['data']['crm_number'] = $labData['crm_number'];
                    // $reqPayload['data']['report_url'] = $labData['report_url'][0];
                    // $reqPayload['data']['goal_percentage'] = $labData['goals_achieved'];
                    $reqPayload['data']['report_pdf_encoded'] = $pdf_base_64;
                } else {
                    // $reqPayload['data']['lab_id'] = $labId;
                    // $reqPayload['data']['crm_number'] = $labData['crm_number'];
                    // $reqPayload['data']['report_url'] = $labData['report_url'][0];
                    // $reqPayload['data']['goal_percentage'] = $labData['goals_achieved'];
                    if (is_file($labData['pdfpath'][0])) {
                        $pdf_base_64 = chunk_split(base64_encode(file_get_contents($labData['pdfpath'][0])));
                        $reqPayload['data']['report_pdf_encoded'] = $pdf_base_64;
                    } else {
                        $updateIsattachmentsent = [
                            'isrsattachmentsent' => 2   //failed to sent attachment
                        ];
                        $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                        continue;
                    }
                }
            }

            //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
                // $response_magento = $this->curlCall($reqPayload, $config);
                if($report_type == 'cb'){
            $reqPayload['data']['report_type'] = 'biobank';
            $response_magento = $this->curlCallCBReportMagento($reqPayload, $config);
                }else{
                    $response_magento = $this->curlCall($reqPayload, $config);
                }
            $request  = $response_magento['post_data'];
            $response = $response_magento['result'];

            $regdatareportLogs = [
                'lab_id' => $labId,
                'attachment' => $request,
                'testgroupcode' => $labData['testgroupcode'][0],
                'response' => json_encode($response),
                'created_at' => date("Y-m-d H:i:s"),
                'system_type' => 'magento',
                'report_type' => $report_type
            ];
                if (isset($response['status']) && $response['status'] == 'success') {
                $regdatareportLogs['status'] = "done";
                //===================== UPDATE FLAG IN REPORT TABLE ====================//
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 1,
                        'pushpdfdate' => date("Y-m-d H:i:s")
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
            } else {
                //============== updated status as failed if error ============//
                $regdatareportLogs['status'] = "failed";
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
            }


            $registrationreportLogs->insert($regdatareportLogs);
            if (is_file($merged_pdf)) {
                unlink($merged_pdf);
            }
            //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
        }
       
    }

    public function pushCbReportData($reportrecords, $config, $report_type)
    {
        $registrationreportLogs = new RegistrationServiceLogsModel();
        $registrationreportLogs = new CbMagentoLogsModel();
        //================INSERT TESTCODES AGAINST LABID'S==================//
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $configModel = new StoreConfig();
        $config_value = $configModel->getConfigValue('BLOCK_REPORT_TESTCODES');
        $BLOCK_REPORT_TESTCODES = isset($config_value['config_value']) ? explode(',', $config_value['config_value']) : array();
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $labIdData = array();
        foreach ($reportrecords as $row) {

            if (in_array($row['testgroupcode'], $BLOCK_REPORT_TESTCODES)) {
                $updateIsattachmentsent = [
                    'isrsattachmentsent' => 3   //TESTGROUPCODE IS BLOCKED TO SENT REPORT
                ];
                $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                    echo $row['lab_id'].' Block to send report';
            } else {
                if (is_file(FCPATH . $row['pdf_path'])) {
                    $labIdData[$row['lab_id']]['testgroupcode'][] = $row['testgroupcode'];
                        $labIdData[$row['lab_id']]['pdfpath'][] = FCPATH.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['report_url'][] = base_url().'/'.$row['pdf_path'];
                    $labIdData[$row['lab_id']]['crm_number'] = $row['crm_id'];
                    $labIdData[$row['lab_id']]['goals_achieved'] = $row['goals_achieved'] ?? "0";
                        // CB report cron functionlity to send crm,ladid,email_trigger_date,report_type,customer_email_address,email_trigger_status
                        if($report_type == 'cb'){
                             $input = trim($row['mobile_no']);
                        $mobile_number = null;
                        $alternate_mobile_number = null;

                        if (!empty($input)) {
                            $numbers = explode('|', $input);
                            if (isset($numbers[0]) && isset($numbers[1]) && !empty(trim($numbers[0])) && !empty(trim($numbers[1]))) {
                                $mobile_number = trim($numbers[0]);
                                $alternate_mobile_number = trim($numbers[1]);
                            } elseif (isset($numbers[0]) && !empty(trim($numbers[0])) && (!isset($numbers[1]) || empty(trim($numbers[1])))) {
                                $mobile_number = trim($numbers[0]);
                            } elseif (isset($numbers[1]) && !empty(trim($numbers[1])) && (empty(trim($numbers[0])) || $numbers[0] == '')) {
                                $mobile_number = trim($numbers[1]);
                            }
                        }
                        $labIdData[$row['lab_id']]['email_trigger_date_time'] = $row['email_trigger_date_time'];
                        $labIdData[$row['lab_id']]['report_type'] = 'biobank';
                        $labIdData[$row['lab_id']]['registration_date'] = $row['registration_date'];
                        $labIdData[$row['lab_id']]['sample_date'] = $row['sample_date'];
                            $labIdData[$row['lab_id']]['approved_date'] = $row['approved_on'];
                        $labIdData[$row['lab_id']]['approved_by'] = '';
                        $labIdData[$row['lab_id']]['customer_email_address'] = $row['email_id'];
                        $labIdData[$row['lab_id']]['email_trigger_status'] = $row['email_sent'];
                            $labIdData[$row['lab_id']]['mobile_number'] = $mobile_number;
                            $labIdData[$row['lab_id']]['alternate_mobile_number'] =  $alternate_mobile_number;
                    }
                } else {
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                        echo $row['lab_id'].' failed to sent attachment';
                }
            }
        }
        $merged_pdf = "";
        foreach ($labIdData as $labId => $labData) {
            $reqPayload = array();
            $reqPayload['data']['lab_id'] = $labId;
            $reqPayload['data']['crm_number'] = $labData['crm_number'];
            $reqPayload['data']['report_type'] = $report_type;
            $reqPayload['data']['report_url'] = $labData['report_url'][0];
            $reqPayload['data']['goal_percentage'] = $labData['goals_achieved'];
            $reqPayload['data']['sample_storage_date_time'] = $labData['sample_storage_date_time'];
                if($report_type == 'cb'){
                $reqPayload['data']['email_trigger_date_time'] = $labData['email_trigger_date_time'];
                $reqPayload['data']['registration_date'] = $labData['registration_date'];
                $reqPayload['data']['sample_date'] =  $labData['sample_date'];
                $reqPayload['data']['approved_date'] =  $labData['approved_date'];
                $reqPayload['data']['approved_by'] = '';
                    $reqPayload['data']['customer_email_address'] = trim($labData['customer_email_address']);
                $reqPayload['data']['email_trigger_status'] = $labData['email_trigger_status'];
                    $reqPayload['data']['mobile_number'] = $labData['mobile_number'];
                    $reqPayload['data']['alternate_mobile_number'] = $labData['alternate_mobile_number'];
            }

            //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
           
                $reqPayload['data']['report_type'] = 'biobank';
                $response_magento = $this->curlCallCBReportMagento($reqPayload, $config);

            $request  = $response_magento['post_data'];
            $response = $response_magento['result'];

            $regdatareportLogs = [
                'lab_id' => $labId,
                'attachment' => $request,
                'testgroupcode' => $labData['testgroupcode'][0],
                'response' => json_encode($response),
                'created_at' => date("Y-m-d H:i:s"),
                'system_type' => 'magento',
                'report_type' => $report_type
            ];
            if (isset($response['status']) && ($response['status'] == 'success' || $response['status'] == 'true')) {
                $regdatareportLogs['status'] = "done";
                //===================== UPDATE FLAG IN REPORT TABLE ====================//
                if ($report_type == 'cb') {
                    if (isset($response['response'])) {
                        $decodedResponse = json_decode($response['response'], true);
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            // Invalid JSON - update isrsattachmentsent to 2
                            $isrsattachmentsent = 2;
                            $updateIsattachmentsent = [
                                'isrsattachmentsent' => $isrsattachmentsent,
                                'failed_reason' => "The JSON response from Magento is invalid",
                                'is_failed' => 1
                            ];
                            $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                            echo $labId . " Invalid JSON: " . json_last_error_msg();
                            return;
                        }
                        if (isset($decodedResponse['success']['data'])) {
                            $magento_response_id = $decodedResponse['success']['data'] ?? null;
                        }
                        if (!empty($magento_response_id)) {
                            $isrsattachmentsent = 1;
                            $updateIsattachmentsent = [
                                    'magento_response_id' => $magento_response_id,
                                'isrsattachmentsent' => $isrsattachmentsent,
                                'pushpdfdate' => date("Y-m-d H:i:s"),
                                'failed_reason' => "",
                                'is_failed' => 0
                            ];
                            $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                            echo $labId . " Report Attachment Sent Successfully";
                        } else {
                            $isrsattachmentsent = 2;
                            $updateIsattachmentsent = [
                                'isrsattachmentsent' => $isrsattachmentsent,
                                'failed_reason' => 'Magento response ID is missing or unavailable',
                                'is_failed' => 1
                            ];
                            $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                            echo $labId . " Magento reponse id empty";
                        }
                    }
                    }else{
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 1,
                        'pushpdfdate' => date("Y-m-d H:i:s")
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
                }
            } else {
                //============== updated status as failed if error ============//
                $regdatareportLogs['status'] = "failed";
                if ($report_type == 'cb') {
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2,  //failed to sent attachment
                        'failed_reason' => "Getting an error response from Magento",
                        'is_failed' => 1

                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                    }
                    else{
                    $updateIsattachmentsent = [
                        'isrsattachmentsent' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                }
            }


            $registrationreportLogs->insert($regdatareportLogs);
            if (is_file($merged_pdf)) {
                unlink($merged_pdf);
            }
            //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
        }
       
    }

    public function pushWellnessReportData($reportrecords, $config, $report_type)
    {
        // $registrationreportLogs = new RegistrationServiceLogsModel();
        $registrationreportLogs = new WellnessMagentoLogsModel;
        //================INSERT TESTCODES AGAINST LABID'S==================//
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $configModel = new StoreConfig();
        $config_value = $configModel->getConfigValue('BLOCK_REPORT_TESTCODES');
        $BLOCK_REPORT_TESTCODES = isset($config_value['config_value']) ? explode(',', $config_value['config_value']) : array();
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $labIdData = array();
        foreach ($reportrecords as $row) {

            if (in_array($row['testgroupcode'], $BLOCK_REPORT_TESTCODES)) {
                $updateIsattachmentsent = [
                    'isrsattachmentsenttomagento' => 3   //TESTGROUPCODE IS BLOCKED TO SENT REPORT
                ];
                $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                    echo $row['lab_id'].' Block to send report';
            } else {
                if (is_file(FCPATH . $row['pdf_path'])) {
                    $labIdData[$row['lab_id']]['testgroupcode'][] = $row['testgroupcode'];
                        $labIdData[$row['lab_id']]['pdfpath'][] = FCPATH.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['report_url'][] = base_url().'/'.$row['pdf_path'];
                    $labIdData[$row['lab_id']]['crm_number'] = $row['crm_id'];
                    $labIdData[$row['lab_id']]['lab_id'] = $row['lab_id'];
                    $labIdData[$row['lab_id']]['report_type'] = $report_type;
                    $labIdData[$row['lab_id']]['service_type'] = $row['service_type'];
                    $labIdData[$row['lab_id']]['report_released_date'] = $row['report_release_date'];
                    $labIdData[$row['lab_id']]['sample_registered_date'] = $row['sample_reg_date'];
                    if ($labIdData[$row['lab_id']]['service_type']) {
                        $serviceType = $labIdData[$row['lab_id']]['service_type'];

                        $packageNames = [
                            "AYN_026" => "Vital Package",
                            "AYN_027" => "Wellness Package",
                            "AYN_028" => "Wellness Plus Package",
                            "AYN_031" => "Tax Saver",
                            "AYN_025" => "Wellness - Total Package",
                            "AYN_029" => "Ayushman - Comprehensive  (M) Package",
                            "AYN_030" => "Ayushman - Comprehensive  (F) Package",
                            "AYN_016" => "Vital Package",
                            "AYN_017" => "Wellness Package",
                            "AYN_018" => "Wellness Plus Package",
                            "AYN_019" => "Tax Saver",
                            "AYN_020" => "Tax Saver",
                            "AYN_021" => "Ayushman - Comprehensive (F) Package",
                            "AYN_022" => "Ayushman - Comprehensive  (M) Package"
                        ];

                        $reportTitle = $packageNames[$serviceType] ?? '';
                        $labIdData[$row['lab_id']]['report_title'] = $reportTitle;
                    }
                       
                } else {
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                        echo $row['lab_id'].' failed to sent attachment';
                }
            }
        }
        $merged_pdf = "";
        foreach ($labIdData as $labId => $labData) {

            $reqPayload = array();
            $reqPayload['data']['crm'] = $labData['crm_number'];
            $reqPayload['data']['lab_id'] = $labId;
            $reqPayload['data']['report_type'] = $report_type;
            $reqPayload['data']['report_link'] = $labData['report_url'][0];
            $reqPayload['data']['report_released_date'] =  $labData['report_released_date'];
            $reqPayload['data']['sample_registered_date'] =   $labData['sample_registered_date'];
            $reqPayload['data']['report_title'] =   $labData['report_title'];
            $reqPayload['data']['service_id'] =  $labData['service_type'];


            //=============== MAKE POST LOGIN THIRD PARTY API CALL ===================//


            // debug($config);
            $response_magento = $this->curlCallWellnessReportMagento($reqPayload, $config);
            //debug($response_magento);

            $request  = $response_magento['post_data'];
            $response = $response_magento['result'];

            $regdatareportLogs = [
                'lab_id' => $labId,
                'attachment' => $request,
                'testgroupcode' => $labData['testgroupcode'][0],
                'response' => json_encode($response),
                'created_at' => date("Y-m-d H:i:s"),
                'system_type' => 'magento',
                'report_type' => $report_type
            ];
            if (isset($response['status']) && ($response['status'] == 'success' || $response['status'] == 'true')) {
                $regdatareportLogs['status'] = "done";
                //===================== UPDATE FLAG IN REPORT TABLE ====================//
                if ($report_type == 'wellness') {
                    if (isset($response['response'])) {
                        $decodedResponse = json_decode($response['response'], true);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            // Invalid JSON - update isrsattachmentsenttomagento to 2
                            $isrsattachmentsenttomagento = 2;
                            $updateIsattachmentsent = [
                                'isrsattachmentsenttomagento' => $isrsattachmentsenttomagento,
                                'failed_reason' => "The JSON response from Magento is invalid",
                                'is_failed' => 1
                            ];
                            $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                            echo $labId . " Invalid JSON: " . json_last_error_msg();
                            return;
                        }

                        // No need to check for response ID — assume success if no error
                        $isrsattachmentsenttomagento = 1;
                        $updateIsattachmentsent = [
                            'isrsattachmentsenttomagento' => $isrsattachmentsenttomagento,
                            'pushpdfdate' => date("Y-m-d H:i:s"),
                            'failed_reason' => "",
                            'is_failed' => 0
                        ];
                        $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                        echo $labId . " Report Attachment Sent Successfully";
                    }
                }
                else{
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 1,
                        'pushpdfdate' => date("Y-m-d H:i:s")
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
                }
            } else {
                //============== updated status as failed if error ============//
                $regdatareportLogs['status'] = "failed";
                if ($report_type == 'wellness') {
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 2,  //failed to sent attachment
                        'failed_reason' => "Getting an error response from Magento",
                        'is_failed' => 1

                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                    }
                    else{
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                }
            }


            $registrationreportLogs->insert($regdatareportLogs);
            if (is_file($merged_pdf)) {
                unlink($merged_pdf);
            }
            //=============== MAKE MAGENTO THIRD PARTY API CALL ===================//
        }
       
    }

    public function pushPnsReportData($reportrecords, $config, $report_type)
    {
        $registrationreportLogs = new RegistrationServiceLogsModel();

        //================INSERT TESTCODES AGAINST LABID'S==================//
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $configModel = new StoreConfig();
        $config_value = $configModel->getConfigValue('BLOCK_REPORT_TESTCODES');
        $BLOCK_REPORT_TESTCODES = isset($config_value['config_value']) ? explode(',', $config_value['config_value']) : array();
        //================ VERIFY TESTCODES ALLOWED TO SENT OR NOT ===============//
        $labIdData = array();
        foreach ($reportrecords as $row) {

            if (is_file(FCPATH . $row['pdf_path'])) {
                $labIdData[$row['lab_id']]['testgroupcode'][] = $row['testgroupcode'];
                        $labIdData[$row['lab_id']]['pdfpath'][] = FCPATH.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['report_url'][] = base_url().'/'.$row['pdf_path'];
                $labIdData[$row['lab_id']]['crm_number'] = $row['crm_id'];
                $labIdData[$row['lab_id']]['lab_id'] = $row['lab_id'];
                $labIdData[$row['lab_id']]['report_type'] = $report_type;
                $labIdData[$row['lab_id']]['report_released_date'] = $row['report_release_date'];
                $labIdData[$row['lab_id']]['sample_registered_date'] = $row['sample_reg_date'];
                $services = [
                    '1TQWPLGF'     => '1T Quad (with PLGF) (Delfia)',
                    '1TPENDEL'     => '1T Penta (Delfia)',
                    'TDSWOPE'      => '1TPenta_Delfia Serum without PE',
                    'CSDEL'        => 'Combined Screening Delfia Serum',
                    'CSIMUNIPTOLD' => 'Combined Screening with NIPT (Immulite)',
                    'CSDELNIPTOLD' => 'Combined Screening with NIPT (Delfia)',
                    'CSIMUQFPCR'   => 'Combined Screening with QF-PCR (Immulite)',
                    'CSDELQFPCR'   => 'Combined Screening with QFPCR (Delfia)',
                    'DMNIPT'       => 'Double Marker with NIPT',
                    'DMNDS'        => 'Double Marker With NIPT Delfia_Serum',
                    'DMDS'         => 'Double Marker-Delfia_Serum',
                    'CSPLGFDEL'    => 'Combined Screening with PLGF (Delfia)',
                            'CSPLGFDELNIPT'=> 'Combined Screening + PLGF with NIPT (Delfia)',
                    'QSTDEL14W'    => '2T Quadruple Screening (14w 1days to 14w 5 days) - Delfia',
                    'STSIMU'       => '2T Triple Screening (Immulite)',
                    'STSDEL14W'    => '2T Triple Screening (14w 1 days to 14w 5 days) (Delfia)',
                    'QSTDEL'       => '2T Quadruple Screening (Delfia)',
                    'QSTIMU'       => '2T Quadruple Screening (Immulite)',
                    'STSDEL'       => '2T Triple Screen (Delfia)',
                    'CSIMU'        => 'Combined Screening (Immulite)',
                    'DMDEL'        => 'Double marker (Delfia)',
                    'DMIMU'        => 'Double marker (Immulite)',
                    'CSDELHBA'     => 'Combined Screening (Delfia) with Hemoglobinopathy + HBA1C',
                    'GEN0875'      => 'msurePGx-Pharmacogenetics Comprehensive Panel',
                    'GEN0916'      => 'msurePGx-Pharmacogenetics Comprehensive Panel for Onco',
                ];
                if (!empty($labIdData[$row['lab_id']]['testgroupcode'])) {
                    $testgroupcode = $labIdData[$row['lab_id']]['testgroupcode'][0];
                    $labIdData[$row['lab_id']]['report_title'] = $services[$testgroupcode] ?? $row['report_title'];
                }
                       
            } else {
                $updateIsattachmentsent = [
                    'isrsattachmentsenttomagento' => 2   //failed to sent attachment
                ];
                $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                        echo $row['lab_id'].' failed to sent attachment';
            }
        }
        $merged_pdf = "";
        foreach ($labIdData as $labId => $labData) {

            $reqPayload = array();
            $reqPayload['data']['crm'] = $labData['crm_number'];
            $reqPayload['data']['lab_id'] = $labId;
            $reqPayload['data']['report_type'] = $report_type;
            $reqPayload['data']['report_link'] = $labData['report_url'][0];
            $reqPayload['data']['report_released_date'] =  $labData['report_released_date'];
            $reqPayload['data']['sample_registered_date'] =   $labData['sample_registered_date'];
            $reqPayload['data']['report_title'] =   $labData['report_title'];
            $reqPayload['data']['service_id'] = $labData['testgroupcode'][0];


            // debug($reqPayload['data']);


            //=============== MAKE POST LOGIN THIRD PARTY API CALL ===================//


            // debug($config);
            $response_magento = $this->curlCallPNSReportMagento($reqPayload, $config);
            // debug($response_magento);

            $request  = $response_magento['post_data'];
            $response = $response_magento['result'];



            $regdatareportLogs = [
                'lab_id' => $labId,
                'attachment' => $request,
                'testgroupcode' => $labData['testgroupcode'][0],
                'response' => json_encode($response),
                'created_at' => date("Y-m-d H:i:s"),
                'system_type' => 'magento',
                'report_type' => $report_type
            ];
            if (isset($response['status']) && ($response['status'] == 'success' || $response['status'] == 'true')) {
                $regdatareportLogs['status'] = "done";
                //===================== UPDATE FLAG IN REPORT TABLE ====================//
                if ($report_type == 'pns') {
                    if (isset($response['response'])) {
                        $decodedResponse = json_decode($response['response'], true);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            // Invalid JSON - update isrsattachmentsenttomagento to 2
                            $isrsattachmentsenttomagento = 2;
                            $updateIsattachmentsent = [
                                'isrsattachmentsenttomagento' => $isrsattachmentsenttomagento,
                                'failed_reason' => "The JSON response from Magento is invalid",
                                'is_failed' => 1
                            ];
                            $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                            echo $labId . " Invalid JSON: " . json_last_error_msg();
                            return;
                        }

                        // No need to check for response ID — assume success if no error
                        $isrsattachmentsenttomagento = 1;
                        $updateIsattachmentsent = [
                            'isrsattachmentsenttomagento' => $isrsattachmentsenttomagento,
                            'pushpdfdate' => date("Y-m-d H:i:s"),
                            'failed_reason' => "",
                            'is_failed' => 0
                        ];
                        $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                        echo $labId . " Report Attachment Sent Successfully";
                    }
                }
                else{
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 1,
                        'pushpdfdate' => date("Y-m-d H:i:s"),
                        'failed_reason' => "",
                        'is_failed' => 0
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
                }
            } else {
                //============== updated status as failed if error ============//
                $regdatareportLogs['status'] = "failed";
                if ($report_type == 'wellness') {
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttomagento' => 2,  //failed to sent attachment
                        'failed_reason' => "Getting an error response from Magento",
                        'is_failed' => 1

                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                    }
                    else{
                    $updateIsattachmentsent = [
                            'isrsattachmentsenttomagento' => 2   //failed to sent attachment
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                    echo "<pre>";
                    echo $labId . " Getting Error Response from Magento for this LAB ID";
                }
            }


            $registrationreportLogs->insert($regdatareportLogs);
            if (is_file($merged_pdf)) {
                unlink($merged_pdf);
            }
            //=============== MAKE MAGENTO THIRD PARTY API CALL ===================//
        }
       
    }

    function getSpermReportDetails($limit)
    {
        $spermscore_report_table = new SpermReportDataModel();
        $reportData = $spermscore_report_table
            ->select("lab_id,testgroupcode,pdf_path,crm_id,goals_achieved,sample_storage_date_time")
            ->where('isrsattachmentsent', 0)
            ->where('report_status', 1)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            ->where('created_at >=', '2023-07-26 16:00:00')
            ->findAll((int)$limit);
        return $reportData;
    }

    function getHpvReportDetails($limit)
    {
        $hpv_report_table = new HpvDataModel();
        $reportData = $hpv_report_table
            ->select("lab_id,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
            ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            // ->where('lab_id','31200112209')
            ->findAll((int)$limit);
        return $reportData;
    }

    function getCgReportDetails($limit)
    {
        $cg_report_table = new ChlamydiaGonorrheaDataModel();
        $reportData = $cg_report_table
        ->select("lab_id,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
        ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            ->findAll((int)$limit);
        return $reportData;
    }
    function getWellnesseportDetails($limit, $start_date,$B2C_CODE)
    {
        $wellness_report_table = new WellnessDataModel();
        $reportData = $wellness_report_table
            ->select("lab_id,crm_id,service_type,approved_on,sample_reg_date,report_release_date,email_trigger_date_time,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
            ->where('isrsattachmentsenttomagento', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            ->whereIn('bs_code',$B2C_CODE)
            ->where('created_at >=',$start_date)
            ->findAll((int)$limit);
        return $reportData;
    }
      function getPnseportDetails($limit, $start_date,$B2C_CODE)
    {
        $wellness_report_table = new PNSReportDataModel();
        $reportData = $wellness_report_table
            ->select("lab_id,crm_id,sample_reg_date,report_release_date,testgroupcode,pdf_path,report_title")
            ->where('isrsattachmentsenttomagento', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            ->whereIn('bs_code',$B2C_CODE)
            ->where('created_at >=',$start_date)
            ->findAll((int)$limit);
        return $reportData;
    }
    function getOvascoreReportDetails($limit)
    {
        $ovascore_report_table = new OvaScoreDataModel();
        $reportData = $ovascore_report_table
            ->select("lab_id,pdf_base_64,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
            ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
        // ->where('lab_id','40200101886')
            ->findAll((int)$limit);
        // debug($reportData);
        return $reportData;
    }

    function getPerimenoReportDetails($limit)
    {
        $peri_report_table = new PerimenopauseDataModel();
        $reportData = $peri_report_table
            ->select("lab_id,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
            ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
            ->findAll((int)$limit);
        return $reportData;
    }


    function getSTDReportDetails($limit)
    {
        $std_report_table = new StdReportDataModel();
        $reportData = $std_report_table
            ->select("lab_id,testgroupcode,pdf_path,crm_id,0 as goals_achieved")
            ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
            ->where('is_generated', 1)
        // ->where('lab_id', '40200104280')
            ->findAll((int)$limit);
        return $reportData;
    }

    function getCbReportDetails($limit)
    {
        $cb_report_table = new CbDataModel();
        $reportData = $cb_report_table
        ->select('lab_id,crm_name,crm_id,pdf_path,email_id,min(created_at) as created_at,approved_on,registration_date,email_sent,0 as goals_achieved,email_trigger_date_time,mobile_no,sample_date,reportgenerationdate,approve_date, "" as testgroupcode')
        ->where('isrsattachmentsent', 0)
            ->where('pdf_path is not', null)
        ->where('reportgenerationdate >=', '2025-01-08')
        // ->where('crm_id', '240003701038')
            ->where('is_generated', 1)
            ->groupBy('lab_id')
            ->findAll((int)$limit);
        return $reportData;
    }

    function updateIsattachmentsent($lab_id, $report_type, $update_isrsattachmentsent)
    {
        if ($report_type == 'cb') {
        $isrsattachmentsent = $update_isrsattachmentsent['isrsattachmentsent'];
            $dbh = \Config\Database::connect();
            if ($isrsattachmentsent == 1) {
            $magento_response_id = $update_isrsattachmentsent['magento_response_id'] ?? null;
            $magento_response_value = is_null($magento_response_id) ? null : "'" . $magento_response_id . "'";
            $failed_reason = $update_isrsattachmentsent['failed_reason'];
            $is_failed = $update_isrsattachmentsent['is_failed'];

                $query = "UPDATE " . trim(strtolower($report_type)) . "_report_data 
                SET isrsattachmentsent = $isrsattachmentsent, 
                  pushpdfdate = '" . date('Y-m-d H:i:s') . "', 
                  magento_response_id = $magento_response_value,
                  failed_reason = '" . addslashes($failed_reason) . "',
                  is_failed =  $is_failed
                 WHERE lab_id = '" . $lab_id . "'";
            } else {
            $failed_reason = $update_isrsattachmentsent['failed_reason'];
            $is_failed = $update_isrsattachmentsent['is_failed'];
                $query = "UPDATE " . trim(strtolower($report_type)) . "_report_data 
                SET isrsattachmentsent = $isrsattachmentsent,
                    failed_reason = '" . addslashes($failed_reason) . "',
                     is_failed =  $is_failed
                WHERE lab_id = '" . addslashes($lab_id) . "'";
            }

            $dbh->query($query);
    }else {
       if ($report_type == 'wellness'|| $report_type == 'pns') {
            $isrsattachmentsent = $update_isrsattachmentsent['isrsattachmentsenttomagento'];
                $dbh = \Config\Database::connect();

                if ($isrsattachmentsent == 1) {
                $failed_reason = $update_isrsattachmentsent['failed_reason'];
                $is_failed = $update_isrsattachmentsent['is_failed'];

                    $query = "UPDATE " . trim(strtolower($report_type)) . "_report_data 
                SET isrsattachmentsenttomagento = $isrsattachmentsent, 
                  pushpdfdatemaganto  = '" . date('Y-m-d H:i:s') . "',
                  failed_reason = '" . addslashes($failed_reason) . "',
                  is_failed =  $is_failed
                 WHERE lab_id = '" . $lab_id . "'";
                } else {
                $failed_reason = $update_isrsattachmentsent['failed_reason'];
                $is_failed = $update_isrsattachmentsent['is_failed'];
                    $query = "UPDATE " . trim(strtolower($report_type)) . "_report_data 
                SET isrsattachmentsenttomagento = $isrsattachmentsent,
                    failed_reason = '" . addslashes($failed_reason) . "',
                     is_failed =  $is_failed
                WHERE lab_id = '" . addslashes($lab_id) . "'";
                }

                $dbh->query($query);
        }

        else{
                $isrsattachmentsent = $update_isrsattachmentsent['isrsattachmentsent'];
                $dbh = \Config\Database::connect();
                if ($isrsattachmentsent == 1) {
                    $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent, pushpdfdate = '" . date('Y-m-d H:i:s') . "' where lab_id = '" . $lab_id . "' ");
                } else {
                    $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsent = $isrsattachmentsent where lab_id = '" . $lab_id . "' ");
                }

                $dbh->query($query);

            }

            
        }
    }


    function getReportDetailsbylabid($lab_id, $report_type){
        $goal_achieved = " ,0 as goals_achieved";
        $dbh = \Config\Database::connect();
        if(trim(strtolower($report_type))=='sperm'){
            $goal_achieved = " ,goals_achieved,sample_storage_date_time";
            $q = $dbh->query("select lab_id,testgroupcode,pdf_path,isrsattachmentsent,is_generated,crm_id,report_status,is_failed $goal_achieved from  " . trim(strtolower($report_type)) . "_report_data 
            where pdf_path is not null and lab_id =" .$lab_id);
        }else if(trim(strtolower($report_type))=='cb'){
            $q = $dbh->query("select lab_id,testgroupcode,pdf_path,isrsattachmentsent,is_generated,crm_id,report_status,email_id,email_sent,is_failed,email_trigger_date_time,sample_date,registration_date,reportgenerationdate,approve_date  from  " . trim(strtolower($report_type)) . "_report_data 
            where pdf_path is not null and is_generated = 1 and lab_id =" .$lab_id);
        }else{
            $q = $dbh->query("select lab_id,testgroupcode,pdf_path,isrsattachmentsent,is_generated,crm_id,report_status,email_id,email_sent,is_failed from  " . trim(strtolower($report_type)) . "_report_data 
            where pdf_path is not null and is_generated = 1 and lab_id =" .$lab_id);
        }
        return $q->getResult();
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

    public function pushreporttoMagentoByLabid($reportrecordsbylabid, $report_type){
        $config =  $this->getconfiguration();
        if($reportrecordsbylabid){
            $reportrecordsbylabid_data =  json_decode(json_encode($reportrecordsbylabid), true);
            $this->pushPdfData($reportrecordsbylabid_data, $config, $report_type);
        }
    }

    function curlCall($params, $credential)
    {
        $post_data = json_encode($params);
        //============ SAVE API CALL BEFORE EXECUTION ====================//
        $logid = date('Y-m-d H:i:s');
        $ch = curl_init($credential['url']);
        $authorization = "Authorization: Bearer ".$credential['token'];
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                $authorization,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data)
            )
        );

        $result = curl_exec($ch);

        if(curl_errno($ch)){
            echo 'Curl error: '.curl_error($ch);
        }

        curl_close ($ch); 

        //$result = '{"status":"success","code":"200","message":"Data Updated Successfully","errors":[]}';

        $data['post_data'] = $post_data;
        $data['result'] = json_decode($result, true);

        return $data;
    }

    function curlCallCBReportMagento($params, $credential)
    {
        // debug($credential);
        $post_data = json_encode($params);
        // debug($post_data);
        //============ SAVE API CALL BEFORE EXECUTION ====================//
        $logid = date('Y-m-d H:i:s');
        $ch = curl_init(trim($credential['url']));
        // $ch = curl_init("https://dev.magento.tech.caretalk.in/rest/V1/getcbreports");

        $authorization = "Authorization: Bearer ".trim($credential['token']);
        // $authorization = "Authorization: Bearer 2nnagxwlne6o0eme9zqyiossm9of8qiy";

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                $authorization,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data)
            )
        );

        $result = curl_exec($ch);
        echo "<pre>";
        // debug($result);
        if(curl_errno($ch)){
            echo 'Curl error: '.curl_error($ch);
        }

        curl_close ($ch); 

        //$result = '{"status":"success","code":"200","message":"Data Updated Successfully","errors":[]}';

        $data['post_data'] = $post_data;
        $data['result'] = json_decode($result, true);
       
        return $data;
    }


    // function curlCallWellnessReportMagento($params,$config)
    // {
    //     // Step 1: Magento credentials (define here directly)

    //     $username = $config['username'];
    //     $password = $config['password'];
    //     $authUrl = $config['authurl'];
    //     $apiUrl  =  $config['url'];

    //     // Step 2: Get token from Magento
    //     $tokenPayload = json_encode([
    //         'username' => $username,
    //         'password' => $password
    //     ]);

    //     $ch_token = curl_init($authUrl);
    //     curl_setopt_array($ch_token, [
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => $tokenPayload,
    //         CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    //     ]);

    //     $tokenResponse = curl_exec($ch_token);
    //     if (curl_errno($ch_token)) {
    //         echo 'Token Error: ' . curl_error($ch_token);
    //         curl_close($ch_token);
    //         return ['error' => 'Token fetch failed'];
    //     }

    //     curl_close($ch_token);
    //     $token = json_decode($tokenResponse, true);

    //     if (!$token || !is_string($token)) {
    //         return ['error' => 'Invalid token response', 'token_response' => $tokenResponse];
    //     }

    //     // Step 3: Call the actual Magento API with token
    //     $postData = json_encode($params);
    //     $ch = curl_init($apiUrl);
    //     curl_setopt_array($ch, [
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => $postData,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
    //         CURLOPT_HTTPHEADER => [
    //             'Authorization: Bearer ' . $token,
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($postData),
    //         ],
    //     ]);

    //     $result = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo 'Curl error: ' . curl_error($ch);
    //     }

    //     curl_close($ch);

    //     return [
    //         'post_data' => $postData,
    //         'result' => json_decode($result, true)
    //     ];
    // }
    function curlCallWellnessReportMagento($params, $config)
    {
        $apiUrl = $config['url'];
    $token  = $config['token']; 

        // Prepare post data
        $postData = json_encode($params);

        // Initialize cURL
        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postData),
            ],
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return ['error' => 'Curl request failed'];
        }

        curl_close($ch);

        return [
            'post_data' => $postData,
            'result' => json_decode($result, true),
        ];
    }
    function curlCallPNSReportMagento($params, $config)
    {
        $apiUrl = $config['url'];
        $token  = $config['token']; // Token comes directly from config

        // Prepare post data
        $postData = json_encode($params);

        // Initialize cURL
        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postData),
            ],
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return ['error' => 'Curl request failed'];
        }

        curl_close($ch);

        return [
            'post_data' => $postData,
            'result' => json_decode($result, true),
        ];
    }
}
