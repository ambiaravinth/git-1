<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\GroupModel;
use App\Models\WellnessLimsLogsModel;
use CodeIgniter\API\ResponseTrait;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Entities\User;

/**
 * Class PnsReportListController.
 */
class WellnessLimsLogController extends BaseController
{
    use ResponseTrait;

    /** @var App\Models\UserModel */
    protected $users;

    public function __construct()
    {
        $this->users = new WellnessLimsLogsModel();
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
            $order = WellnessLimsLogsModel::ORDERABLE[$this->request->getGet('order[0][column]')];
            $dir = $this->request->getGet('order[0][dir]');
            return $this->respond(Collection::datatable(
                $this->users->getResource($search, $fromdate, $todate, $status, $dir)->orderBy($order, $dir)->limit(
                    $length,
                    $start
                )->get()->getResultObject(),
                $this->users->getResource()->countAllResults(),
                $this->users->getResource($search, $fromdate, $todate, $status)->countAllResults()
            ));
        }

        return view('Views/User/wellnesslimslogs', ['title'    => lang('Wellness & LIMS Logs'), 'subtitle' => lang('')]);
    }

    public function edit($id)
    {
        $viewcode = new WellnessLimsLogsModel();
        $data_view = $viewcode->find($id);
        $response  = $data_view['response'];
        return $response;
    }

    /**
     * Show profile user or update.
     *
     * @return mixed
     */
}
