<?php

use Illuminate\Database\Capsule\Manager as DB;

class LogModel extends \BaseModel
{


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $params
     */
    public function getLogList(array $params)
    {
        $result = [];
        if (is_null($params['groupid']) || empty($params['start']) || empty($params['identity'])
            || empty($params['end']) || empty($params['groupby'])) {
            $this->throwException('groupid|identity|start|end|groupby is null', 1);
        }
        $paramList = $this->filterParam($params);
        $start = date('Y-m-d H:i:s', strtotime($paramList['start']));
        $end = date('Y-m-d H:i:s', strtotime($paramList['end']));
        $groupBy = $paramList['groupby'];
        unset($paramList['start']);
        unset($paramList['end']);
        unset($paramList['groupby']);

        $table = (new Eloquent_AppWorkingLog())->getTable();
        $logs = DB::table($table)->select('identity', $groupBy, DB::raw('COUNT(*) AS count'))
            ->where($paramList)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy($groupBy)
            ->get();

        foreach ($logs as $log) {
            $tmp = [
                'identity' => $log->identity,
                $groupBy => $log->{$groupBy},
                'count' => $log->count
            ];
            $result[] = $tmp;
        }
        return $result;

    }


}
