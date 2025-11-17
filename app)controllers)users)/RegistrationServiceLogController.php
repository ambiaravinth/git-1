<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Entities\Collection;
use App\Models\GroupModel;
use App\Models\RegistrationServiceLogsModel;
use CodeIgniter\API\ResponseTrait;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Entities\User;

/**
 * Class PnsReportListController.
 */
class RegistrationServiceLogController extends BaseController
{
    use ResponseTrait;

    /** @var App\Models\UserModel */
    protected $users;

    public function __construct()
    {
        $this->users = new RegistrationServiceLogsModel();
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
            $order = RegistrationServiceLogsModel::ORDERABLE[$this->request->getGet('order[0][column]')];
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

        return view('User/regserviceattchmentlist', [
            'title'    => lang('Report PDF TPA Log List'),
            'subtitle' => lang(''),
        ]);
    }

    public function edit($id)
    {
        $viewcode = new RegistrationServiceLogsModel();
        $data_view = $viewcode->find($id);
        $response  = $data_view['response'];
        return $response;
    }

    public function viewpayload($id)
    {
        $viewcode = new RegistrationServiceLogsModel();
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
