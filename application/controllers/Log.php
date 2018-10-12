<?php
use Illuminate\Database\Capsule\Manager as DB;

class LogController extends \BaseController
{
    const HOMEPAGE_V1 = '物业首页';

    public function init()
    {
        parent::init();
    }

    /**
     * Log home page visit
     */
    public function homepageAction()
    {
        $info = array();

        $info['hotelid'] = intval($this->getParamList('hotelid'));
        $info['groupid'] = intval($this->getParamList('groupid'));
        if ($info['hotelid'] <= 0) {
            $this->throwException(1, 'hoteid is null');
        }

        $info['identity'] = self::HOMEPAGE_V1;
        Eloquent_AppWorkingLog::create($info);
        $this->echoSuccessData();
    }

    public function getTypeListAction()
    {
        $data = [];
        $groupId = intval($this->getParamList('groupid'));

        $table = (new Eloquent_AppWorkingLog())->getTable();
        $logs = DB::table($table)->select('identity')
            ->where('groupid', '=', $groupId)
            ->distinct()
            ->get();
        foreach ($logs as $log) {
            $data[] = $log->identity;
        }
        $this->echoSuccessData($data);
    }

    public function getLogListAction()
    {

        $params['groupid'] = $this->getParamList('groupid');
        $params['identity'] = $this->getParamList('identity');
        $params['platform'] = $this->getParamList('platform');
        $params['hotelid'] = $this->getParamList('hotelid');
        $params['userid'] = $this->getParamList('userid');
        $params['staffid'] = $this->getParamList('staffid');
        $params['start'] = $this->getParamList('start');
        $params['end'] = $this->getParamList('end');
        $params['groupby'] = $this->getParamList('groupby');

        $model = new LogModel();
        $result = $model->getLogList($params);
        $this->echoSuccessData($result);

    }
}
