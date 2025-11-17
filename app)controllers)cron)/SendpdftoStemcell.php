<?php

namespace App\Controllers\Cron;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StoreConfig;
use App\Models\RegistrationServiceLogsModel;
use App\Models\CbStemcellLogsModel;
use App\Libraries\MergePDF;
use App\Models\CronScheduleModel;
use App\Models\SpermReportDataModel;
use App\Models\ChlamydiaGonorrheaDataModel;
use App\Models\HpvDataModel;
use App\Models\PerimenopauseDataModel;
use App\Models\StdReportDataModel;
use App\Models\OvaScoreDataModel;
use App\Models\CbDataModel;

class SendpdftoStemcell extends ResourceController
{
    public function __construct()
    {
        helper('common');
        $this->cronschedulemodel = new CronScheduleModel();
    }

    use ResponseTrait;
    public function getCbconfig()
    {
        //================== FETCH CONFIGURATIONS DETAILS START ====================//
        $configModel = new StoreConfig();
        $config_limit = $configModel->getConfigValue('PUSH_PDF_STEM_CELL_LIMIT');
        $config_cb_url = $configModel->getConfigValue('PUSH_CB_PDF_STEM_CELL_URL');
        $config_cb_token = $configModel->getConfigValue('PUSH_CB_PDF_STEM_CELL_TOKEN');
        $config_cb_date = $configModel->getConfigValue('PUSH_CB_PDF_STEM_CELL_DATE');
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


        // Push CB pdf data to Magento server
        public function pushCbReporttoStemcell()
        {
            $this->cron_id = $this->cronschedulemodel->saveCronSchedule(['cronname'=>'pushCbReporttoStemcell','starttime'=>date('Y-m-d H:i:s'),'status'=>'inprocess']);
            $config =  $this->getCbconfig();
            $limit =  $config['limit'] ?? 10;
            $config_cb_date = $config['config_date'];
            $reportrecords = $this->getCbReportDetails($limit,$config_cb_date);
            if(!empty($reportrecords)){
                $this->pushCbReportData($reportrecords, $config,'cb');
            }else{
                echo 'No pending data to push the PDF';
            }
            $this->cronschedulemodel->updateEndTime(['endtime'=>date('Y-m-d H:i:s'),'status'=>"success"],$this->cron_id);
           
        }

    public function pushCbReportData($reportrecords, $config, $report_type)
    {
            // $registrationreportLogs = new RegistrationServiceLogsModel();
            $registrationreportLogs = new CbStemcellLogsModel();
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
                        'isrsattachmentsenttostemcell' => 3   //TESTGROUPCODE IS BLOCKED TO SENT REPORT
                    ];
                    $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                    echo $row['lab_id'].' Block to send report';
                } else {
                    if (file_exists(FCPATH . $row['pdf_path'])) {
                        $labIdData[$row['lab_id']]['testgroupcode'][] = $row['testgroupcode'];
                        $labIdData[$row['lab_id']]['pdfpath'][] = FCPATH.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['report_url'][] = base_url().'/'.$row['pdf_path'];
                        $labIdData[$row['lab_id']]['crm_number'] = $row['crm_id'];
                        $labIdData[$row['lab_id']]['goals_achieved'] = $row['goals_achieved'] ?? "0";
                        $labIdData[$row['lab_id']]['report_type'] = 'cb';
                        $labIdData[$row['lab_id']]['sample_storage_date_time'] = $row['sample_date'];
                        $labIdData[$row['lab_id']]['report_pdf_encoded'] = $row['sample_date'];
                    } else {
                        $updateIsattachmentsent = [
                            'isrsattachmentsenttostemcell' => 2   //failed to sent attachment
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
                  if (file_exists($labData['pdfpath'][0])) {
                    $pdf_base_64 = base64_encode(file_get_contents($labData['pdfpath'][0]));
                    } else {
                        $updateIsattachmentsent = [
                            'isrsattachmentsenttostemcell' => 2   //failed to sent attachment
                        ];
                        $this->updateIsattachmentsent($row['lab_id'], $report_type, $updateIsattachmentsent);
                        echo $row['lab_id'].' failed to sent attachment';
                    }
                
                $reqPayload['data']['report_pdf_encoded'] = $pdf_base_64;
                
             
                //=============== MAKE STEM CELL THIRD PARTY API CALL ===================//
               
                $response_magento = $this->curlCallCBReportStemcell($reqPayload, $config);
                
                $request  = $response_magento['post_data'];
                $response = $response_magento['result'];
                $regdatareportLogs = [
                    'lab_id' => $labId,
                    'attachment' => $request,
                    'testgroupcode' => $labData['testgroupcode'][0],
                    'response' => json_encode($response),
                    'created_at' => date("Y-m-d H:i:s"),
                    'system_type' => 'stemcell',
                    'report_type' => $report_type
                ];
                if (isset($response['status']) && (strtolower($response['status']) == 'success' || $response['status'] == 'true')) {
                    $regdatareportLogs['status'] = "done";
                    //===================== UPDATE FLAG IN REPORT TABLE ====================// 
                    $updateIsattachmentsent = [
                        'isrsattachmentsenttostemcell' => 1,
                        'pushpdfdatetostemcell' => date("Y-m-d H:i:s")
                    ];
                    $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);

                    echo "<pre>";
                    echo $labId . " Report Attachment Sent Successfully";
                
                } else {
                    //============== updated status as failed if error ============//
                    $regdatareportLogs['status'] = "failed";
                        $updateIsattachmentsent = [
                            'isrsattachmentsenttostemcell' => 2,  //failed to sent attachment
    
                        ];
                        $this->updateIsattachmentsent($labId, $report_type, $updateIsattachmentsent);
                        echo "<pre>";
                        echo $labId . " Getting Error Response from Stem Cell for this LAB ID";
                }

               
                $registrationreportLogs->insert($regdatareportLogs); 
                if (is_file($merged_pdf)) {
                    unlink($merged_pdf);
                }
                //=============== MAKE SUFLAM THIRD PARTY API CALL ===================//
            }
       
    }

    function getCbReportDetails($limit,$config_cb_date)
    {
        $cb_report_table = new CbDataModel();
        $reportData = $cb_report_table
        ->select('lab_id,crm_name,crm_id,pdf_path,email_id,min(created_at) as created_at,approved_on,registration_date,email_sent,0 as goals_achieved,email_trigger_date_time,sample_date,reportgenerationdate,pushpdfdatetostemcell,isrsattachmentsenttostemcell,approve_date, "" as testgroupcode')
        ->where('isrsattachmentsenttostemcell', 0)
        ->where('pdf_path is not', null)
        ->where('created_at >=', $config_cb_date)
       // ->whereIn('crm_id', [250008200070])
        ->where('is_generated', 1)
        ->groupBy('lab_id')
        ->findAll((int)$limit);
        return $reportData;
    }

    function updateIsattachmentsent($lab_id, $report_type, $update_isrsattachmentsenttostemcell)
    { 
       

        $isrsattachmentsenttostemcell = $update_isrsattachmentsenttostemcell['isrsattachmentsenttostemcell'];
        $dbh = \Config\Database::connect();
        if($isrsattachmentsenttostemcell == 1){
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsenttostemcell = $isrsattachmentsenttostemcell, pushpdfdatetostemcell = '".date('Y-m-d H:i:s')."' where lab_id = '" . $lab_id . "' ");
        }else{
            $query = ("update  " . trim(strtolower($report_type)) . "_report_data set isrsattachmentsenttostemcell = $isrsattachmentsenttostemcell where lab_id = '" . $lab_id . "' ");
        }

        $dbh->query($query);
    }
    

    function curlCallCBReportStemcell($params, $credential)
    {
        // debug($credential);
        $post_data = json_encode($params);
        // debug($post_data);
        //============ SAVE API CALL BEFORE EXECUTION ====================//
        $logid = date('Y-m-d H:i:s');
        $ch = curl_init(trim($credential['url']));
        // $ch = curl_init("https://dev.magento.tech.caretalk.in/rest/V1/getcbreports");

        $authorization = trim($credential['token']);
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
            'Accept: */*',
            'Authorization:'. $authorization,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data)
        )

        );

        $result = curl_exec($ch);
        echo "<pre>";
        if(curl_errno($ch)){
            echo 'Curl error: '.curl_error($ch);
        }
        
        curl_close ($ch); 

        //$result = '{"status":"success","code":"200","message":"Data Updated Successfully","errors":[]}';

        $data['post_data'] = $post_data;
        $data['result'] = json_decode($result, true);
       
        return $data;
    }
}
