<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\GroupModel;
use App\Models\WellnessMagentoLogsModel;
use CodeIgniter\API\ResponseTrait;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Entities\User;

/**
 * Class PnsReportListController.
 */
class WellnessMagentoLogController extends BaseController
{
    use ResponseTrait;

    /** @var App\Models\UserModel */
    protected $users;

    public function __construct()
    {
        $this->users = new WellnessMagentoLogsModel();
        helper('common');
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return mixed
     */
    public function index()
    {
        if ($this->request->isAJAX()) {
            $start = $this->request->getGet('start');
            $length = $this->request->getGet('length');
            $search = $this->request->getGet('search[value]');
            $fromdate = $this->request->getGet('fromdate');
            $todate = $this->request->getGet('todate');
            $status = $this->request->getGet('status');
            $order = WellnessMagentoLogsModel::ORDERABLE[$this->request->getGet('order[0][column]')];
            $dir = $this->request->getGet('order[0][dir]');

            // print_r($this->users->getResource($search, $fromdate, $todate, $status, $dir)->orderBy($order, $dir)->limit($length,$start)->get()->getResultObject());exit;

            // return $this->respond(Collection::datatable(
            //     $this->users->getResource($search, $fromdate, $todate, $status, $dir)->orderBy($order, $dir)->limit($length,$start)->get()->getResultObject(),
            //     $this->users->getResource()->countAllResults(),
            //     $this->users->getResource($search, $fromdate, $todate, $status)->countAllResults()
            // ));

            $baseBuilder = $this->users->getResource(); // no filters
            $filterBuilder = $this->users->getResource($search, $fromdate, $todate, $status); // with filters

            // 1️⃣ Clone builders to safely count without resetting
            $totalCountBuilder = clone $baseBuilder;
            $filteredCountBuilder = clone $filterBuilder;

            // 2️⃣ Execute count queries
            $totalRecords = $totalCountBuilder->countAllResults();
            $recordsFiltered = $filteredCountBuilder->countAllResults();

            // 3️⃣ Fetch paginated data
            $data = $filterBuilder
                ->orderBy($order, $dir)
                ->limit($length, $start)
                ->get()
                ->getResultObject();

            // 4️⃣ Return DataTable format
            return $this->respond(Collection::datatable(
                $data,
                $totalRecords,
                $recordsFiltered
            ));
        }
        return view('Views/User/wellnessmagentologs', ['title'    => lang('Wellness & Magento Logs'), 'subtitle' => lang('')]);
    }

    public function edit($id)
    {
        $viewcode = new WellnessMagentoLogsModel();
        $data_view = $viewcode->find($id);
        $response  = $data_view['response'];
        return $response;
    }

    public function viewpayload($id)
    {
        $viewcode = new WellnessMagentoLogsModel();
        $data_view = $viewcode->find($id);
        $payload  = $data_view['attachment'];
        return $payload;
    }

    /**
     * Show profile user or update.
     *
     * @return mixed
     */
}
