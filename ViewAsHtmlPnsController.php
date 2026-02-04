<?php
namespace App\Controllers\Reports;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PNSReportDataModel;
use App\Models\ReportDataModel;
use App\Controllers\Reports\PNSReportJson;
use App\Controllers\Reports\MfineReportJson;
use App\Models\StoreConfig;

class ViewAsHtmlPnsController extends ResourceController
{
    use ResponseTrait;

    protected $users;

    public function __construct()
    {
        $this->users = new PNSReportDataModel();
        $this->dbModel = new ReportDataModel();
    }

    // Data getting based on lab id
    public function edit($lab_id=null)
    {

        $mrker =$this->request->getVar('marker');
        helper('qr');
		 ## Select record by lab_id
		$viewcode = new PNSReportDataModel();
		$data_view = $viewcode->find($lab_id);
        if(empty($data_view['filepath']) || !file_exists( FCPATH . $data_view['filepath'])){
            debug('Final Json Not Received,Report Yet to be Generate');
        }
		$json_full_path = FCPATH . $data_view['filepath'];
		$json_data = file_get_contents($json_full_path);
        $resultdata = json_decode(utf8_encode($json_data));	
		$json_reportdata = $resultdata->data;
	    $actual_link = base_url();	
		$site =$actual_link.'admin/user/pdftohtml/'.$lab_id.'/edit';
		$htmlUrl= $site;
        $htmlqr = generateHtmlQRCode($htmlUrl);
        $addressflag = $this->dbModel->getsetaddressflag($lab_id);
        $setaddressflag = $addressflag[0]->setaddress_flag ?? "NO";
        $lims_slims = $addressflag[0]->lims_slims ?? "";
        $testGroupCode = $json_reportdata->TestGroupDetails[0]->TEST_GROUP_CODE;
        
		 $data = [];
         try {
            if($mrker == 'pe'){
                $controller = new MfineReportJson();
                $reportData = $controller->getPEReportJson($json_reportdata,0);
                $data =['postdata' =>$json_reportdata,'reportdata'=>$reportData,'marker' => 'pereport','qrcode' => $htmlqr,'pegen'=> $mrker,'setaddressflag' =>$setaddressflag,"lims_slims" => $lims_slims,'is_pdf'=>0];
                
                $result = view('PnsReports/mfine/mfine_pe_pns_report', $data);
                $ageRiskIssue = str_contains($result, 'ageriskissue');
                $RiskIssue = str_contains($result, 'Empty');
               
                if ($result === FALSE || $ageRiskIssue == true) { /* Handle error */
                    echo "error in the Age Risk";
                } 
                else if($RiskIssue==true){
                    echo "error in the Graph Risk";
                }
                else{
                    echo view('PnsReports/mfine/mfine_header',$data);
                    echo $result ;
                    echo view('PnsReports/mfine/mfine_footer',$data);
                }

            }else{
                $configModel = new StoreConfig();
                $stSqTestCodes = $configModel->getConfigValue('ST_SQ_TEST_CODES');
                $stSqTestCodes = $stSqTestCodes['config_value'] ?? [];
                $stsqflag = "";
                if($stSqTestCodes && in_array($testGroupCode,explode(',',$stSqTestCodes))){
                    $stsqflag = "stsq";
                }
                $data =['stsqflag' => $stsqflag,'postdata' =>$json_reportdata,'marker' => 'report','setaddressflag' =>$setaddressflag,"lims_slims" => $lims_slims,'is_pdf'=>0];
                
                $result = view('mfine_report', $data);
               
                $ageRiskIssue = str_contains($result, 'ageriskissue');
                $RiskIssue = str_contains($result, 'Empty');
                if ($result === FALSE || $ageRiskIssue == true) { /* Handle error */
                    echo "error in the Age Risk";
                } 
                else if($RiskIssue==true){
                    echo "error in the Graph Risk";
                }
                else{
                    echo view('PnsReports/mfine/mfine_header',$data);
                    echo $result ;
                    echo view('PnsReports/mfine/mfine_footer',$data);
                }
                
            }
         }catch (\Exception $e) {
            $this->users->updateFailedReprtFlag($lab_id,$e,"Something Went wrong");
            echo 'Something Went wrong <br/>';
        }


     
    }



}
