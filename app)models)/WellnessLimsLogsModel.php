<?php

namespace App\Models;

use CodeIgniter\Model;

class WellnessLimsLogsModel extends Model
{
    protected $table = 'wellness_lims_logs';
    protected $primaryKey = 'reg_id';
    protected $allowedFields = ['testgroupcode', 'lab_id', 'attachment', 'created_at', 'response', 'status','system_type','report_type'];

    const ORDERABLE = [
        0 => 'lab_id',
        1 => 'testgroupcode',
        2 => 'status',
        3 => 'response',
        4 => 'created_at'
    ];

    /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '', $fromdate = "", $todate = "", $status = "")
    {
        $builder = $this->builder()
            ->select('reg_id,lab_id,testgroupcode,Attachment,status,response,created_at');

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
            ->like('lab_id', $search)
            ->orLike('testgroupcode', $search)
            ->groupEnd();
        if ($status == "failed" || $status == "done") {
            $where['status'] = $status;
        }
        if (!empty($fromdate)) {
            $where['date(created_at) >='] = $fromdate;
        }
        if (!empty($todate)) {
            $where['date(created_at) <='] = $todate;
        }
        if (empty($where)) {
            return $condition;
        }
        return $condition->where($where);
    }
}
