<?php

class LogController extends \BaseController
{
    const HOMEPAGE_V1 = 'homepage_v1';

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
        if ($info['hotelid'] <= 0) {
            $this->throwException(1, 'hoteid is null');
        }

        $info['identity'] = self::HOMEPAGE_V1;
        Eloquent_AppWorkingLog::create($info);
        $this->echoSuccessData();
    }
}
